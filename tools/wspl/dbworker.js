/*
  Copyright 2009 Google Inc.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.
*/

/**
 * @fileoverview A worker thread that performs synchronous queries against a
 * Gears database on behalf of an asynchronous calling client.
 *
 * The worker replies to the sender with messages to pass results, errors, and
 * notifications about completed transactions. The type field of the message
 * body specifies the message type. For each successful statement, a RESULT
 * message is sent with a result attribute containing the Gears result set. For
 * the first unsuccessful statement, an ERROR message will be sent with details
 * stored in the error field. After the transaction has been committed, a COMMIT
 * message is sent. If the transaction is rolled back, a ROLLBACK message is
 * sent.
 *
 * NB: The worker must be served over http. Further, to operate successfully,
 * it requires the inclusion of global_functions.js and gearsutils.js.
 */


/**
 * Creates a DbWorker to handle incoming messages, execute queries, and return
 * results to the main thread.
 *
 * @param {GearsWorkerPool} wp The gears worker pool.
 * @constructor
 */
google.wspl.gears.DbWorker = function(wp) {

  /**
   * An array of transaction ids representing the transactions that are open on
   * the database.
   * @type {Array.<number>}
   * @private
   */
  this.transactions_ = [];

  /**
   * The gears worker pool.
   * @type {GearsWorkerPool}
   * @private
   */
  this.wp_ = wp;

  this.wp_.onmessage = google.bind(this.onMessage_, this);

  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.ReplyTypes.STARTED
  });
};

/**
 * The gears database that this worker thread will interact with.
 * @type {GearsDatabase}
 * @private
 */
google.wspl.gears.DbWorker.prototype.db_;

/**
 * A singleton instance of DbWorker.
 * @type {google.wspl.gears.DbWorker?}
 * @private
 */
google.wspl.gears.DbWorker.instance_;

/**
 * The sender ID of the incomming messages.  Default to 0 for workerpool ID.
 * @type {number}
 * @private
 */
google.wspl.gears.DbWorker.prototype.senderId_ = 0;

/**
 * Message type constants for worker command messages.
 * @enum {number}
 */
google.wspl.gears.DbWorker.CommandTypes = {
  OPEN: 1,
  BEGIN: 2,
  EXECUTE: 3,
  COMMIT: 4,
  ROLLBACK: 5
};

/**
 * Message type constants for worker reply messages.
 * @enum {number}
 */
google.wspl.gears.DbWorker.ReplyTypes = {
  RESULT: 1,
  FAILURE: 2,
  COMMIT: 3,
  ROLLBACK: 4,
  STARTED: 5,
  OPEN_SUCCESSFUL: 6,
  OPEN_FAILED: 7,
  LOG: 8
};

/**
 * Starts the DbWorker.
 */
google.wspl.gears.DbWorker.start = function() {
  var wp = google.gears.workerPool;
  google.wspl.gears.DbWorker.instance_ = new google.wspl.gears.DbWorker(wp);
};

/**
 * Handles an OPEN command from the main thread.
 *
 * @param {string} userId The user to which the database belongs.
 * @param {string} name The database's name.
 */
google.wspl.gears.DbWorker.prototype.handleOpen_ = function(userId, name) {
  this.log_('Attempting to create Gears database: userId=' + userId + ', name='
      + name);
  try {
    this.db_ = google.gears.factory.create('beta.database', '1.0');
    google.wspl.GearsUtils.openDatabase(userId, name, this.db_, this.log_);
    this.sendMessageToWorker_({
      'type': google.wspl.gears.DbWorker.ReplyTypes.OPEN_SUCCESSFUL
    });
  } catch (ex) {
    this.sendMessageToWorker_({
      'type': google.wspl.gears.DbWorker.ReplyTypes.OPEN_FAILED,
      'error': ex
    });
  }
};

/**
 * Handles a EXECUTE command from the main thread.
 *
 * @param {!Array.<google.wspl.Statement>} statements The statements to execute.
 * @param {number} callbackId The callback to invoke after each execution.
 * @param {number} transactionId The transaction that the statements belong to.
 * @private
 */
google.wspl.gears.DbWorker.prototype.handleExecute_ =
    function(statements, callbackId, transactionId) {
  var self = this;
  try {
    this.executeAll_(statements, function(results) {
      self.sendMessageToWorker_(/** @type {string} */({
        'type': google.wspl.gears.DbWorker.ReplyTypes.RESULT,
        'results': results,
        'callbackId': callbackId,
        'transactionId': transactionId
      }));
    });
  } catch (e) {
    this.sendMessageToWorker_({
      'type': google.wspl.gears.DbWorker.ReplyTypes.FAILURE,
      'error': e,
      'callbackId': callbackId,
      'transactionId': transactionId
    });
  }
};

/**
 * Executes all of the statements on the Gears database.  The callback is
 * invoked with the query results after each successful query execution.
 *
 * @param {!Array.<Object>} statements The statements to execute.
 * @param {Function} callback The callback to invoke with query results.
 * @private
 */
google.wspl.gears.DbWorker.prototype.executeAll_ =
    function(statements, callback) {
  var results = [];
  for (var i = 0; i < statements.length; i++) {
    var resultset = this.db_.execute(statements[i]['sql'],
        statements[i]['params']);
    var result = google.wspl.GearsUtils.resultSetToObjectArray(resultset);
    results.push(result);
  }
  callback(results);
};

/**
 * Handles a BEGIN command from the main thread.
 *
 * @param {number} transactionId The transaction that the statements belong to.
 * @private
 */
google.wspl.gears.DbWorker.prototype.handleBegin_ = function(transactionId) {
  this.transactions_.push(transactionId);
  this.db_.execute('BEGIN IMMEDIATE');
};

/**
 * Handles a COMMIT command from the main thread.
 *
 * @param {number} transactionId The transaction that the statements belong to.
 * @private
 */
google.wspl.gears.DbWorker.prototype.handleCommit_ = function(transactionId) {
  this.db_.execute('COMMIT');
  this.postCommit_();
};

/**
 * Handles a ROLLBACK command from the main thread.
 *
 * @param {number} transactionId The transaction that the statements belong to.
 * @private
 */
google.wspl.gears.DbWorker.prototype.handleRollback_ = function(transactionId) {
  this.db_.execute('ROLLBACK');
  this.postRollback_();
};

/**
 * Sends a COMMIT reply to the main thread for each transaction that was
 * committed.
 *
 * @private
 */
google.wspl.gears.DbWorker.prototype.postCommit_ = function() {
  for (var i = this.transactions_.length - 1; i >= 0; i--) {
    this.sendMessageToWorker_({
      'type': google.wspl.gears.DbWorker.ReplyTypes.COMMIT,
      'transactionId': this.transactions_[i]
    });
  }
  this.transactions_ = [];
};

/**
 * Sends a ROLLBACK reply to the main thread for each transaction that was
 * rolled back.
 *
 * @private
 */
google.wspl.gears.DbWorker.prototype.postRollback_ = function() {
  for (var i = this.transactions_.length - 1; i >= 0; i --) {
    this.sendMessageToWorker_({
      'type': google.wspl.gears.DbWorker.ReplyTypes.ROLLBACK,
      'transactionId': this.transactions_[i]
    });
  }
  this.transactions_ = [];
};

/**
 * Handles incomming messages.
 * @param {string} a Deprecated.
 * @param {number} b Deprecated.
 * @param {Object} messageObject The message object.
 * @private
 */
google.wspl.gears.DbWorker.prototype.onMessage_ =
    function(a, b, messageObject) {
  this.senderId_ = messageObject.sender;
  var message = messageObject.body;
  var type = message['type'];
  var name = message['name'];
  var statements = message['statements'];
  var callbackId = message['callbackId'];
  var transactionId = message['transactionId'];
  var userId = message['userId'];

  try {
    switch(type) {
      case google.wspl.gears.DbWorker.CommandTypes.OPEN:
        this.handleOpen_(userId, name);
        break;

      case google.wspl.gears.DbWorker.CommandTypes.EXECUTE:
        this.handleExecute_(statements, callbackId, transactionId);
        break;

      case google.wspl.gears.DbWorker.CommandTypes.BEGIN:
        this.handleBegin_(transactionId);
        break;

      case google.wspl.gears.DbWorker.CommandTypes.COMMIT:
        this.handleCommit_(transactionId);
        break;

      case google.wspl.gears.DbWorker.CommandTypes.ROLLBACK:
        this.handleRollback_(transactionId);
        break;
    }
  } catch (ex) {
    this.log_('Database worker failed: ' + ex.message);
  }
};

/**
 * Sends a log message to the main thread to be logged.
 * @param {string} msg The message to log.
 * @private
 */
google.wspl.gears.DbWorker.prototype.log_ = function(msg) {
  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.ReplyTypes.LOG,
    'msg': msg
  });
};

/**
 * Sends a message to the main worker thread.
 * @param {Object} msg The message object to send.
 * @private
 */
google.wspl.gears.DbWorker.prototype.sendMessageToWorker_ = function(msg) {
  this.wp_.sendMessage(msg, this.senderId_);
};

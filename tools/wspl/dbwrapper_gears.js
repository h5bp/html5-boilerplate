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
 * @fileoverview A Gears implementation of dbwrapperapi Database.
 *
 * This implementation locks database access upon invoking the transaction's
 * populate callback.  Statements are then asynchronously sent to a worker
 * thread for execution.
 */

/**
 * @see google.wspl.Database#Database
 * @param {boolean} opt_sync Perform all callbacks synchronously.
 * @constructor
 * @extends google.wspl.Database
 */
google.wspl.gears.Database = function(opt_sync) {
  google.wspl.Database.call(this);

  /**
   * Begin transactions synchronously.
   * @type {boolean}
   * @private
   */
  this.synchronous_ = !!opt_sync;
};
google.inherits(google.wspl.gears.Database, google.wspl.Database);

/**
 * The time to wait for the dbworker to reply with STARTED.
 * @type {number}
 */
google.wspl.gears.Database.TIMEOUT = 60000;

/**
 * Whether the gears worker failed to reply with STARTED before TIMEOUT.
 * @type {boolean}
 * @private
 */
google.wspl.gears.Database.prototype.workerTimeout_ = false;

/**
 * Flag set when the worker is ready with an open database connection.
 * @type {boolean}
 * @private
 */
google.wspl.gears.Database.prototype.workerReady_ = false;

/**
 * Flag set when this database should use the worker to process transactions.
 * @type {boolean}
 * @private
 */
google.wspl.gears.Database.prototype.useWorker_ = false;

/**
 * The user for this database.
 * @type {string}
 * @private
 */
google.wspl.gears.Database.prototype.userId_;

/**
 * The name for this database.
 * @type {string}
 * @private
 */
google.wspl.gears.Database.prototype.name_;

/**
 * A map of open transactions and their callbacks.
 * @type {Object}
 * @private
 */
google.wspl.gears.Database.prototype.transactions_ = {};

/**
 * An array of transaction ids that should be executed in order as the lock
 * becomes available.
 * @type {Array.<number>}
 * @private
 */
google.wspl.gears.Database.prototype.queuedTransactions_ = [];

/**
 * The transaction lock for this database.
 * @type {boolean}
 * @private
 */
google.wspl.gears.Database.prototype.locked_ = false;

/**
 * The number of transactions to be used as an index.
 * @type {number}
 * @private
 */
google.wspl.gears.Database.prototype.transCount_ = 1;

/**
 * The id of the transaction being executed.
 * @type {number}
 * @private
 */
google.wspl.gears.Database.prototype.currentTransactionId_;

/**
 * The Gears worker pool.
 * @type {GearsWorkerPool}
 * @private
 */
google.wspl.gears.Database.prototype.wp_;

/**
 * The worker ID.
 * @type {number}
 * @private
 */
google.wspl.gears.Database.prototype.workerId_;

/**
 * The Gears database object.
 * @type {GearsDatabase}
 * @private
 */
google.wspl.gears.Database.prototype.db_;

/**
 * Opens a new Gears database.  This operation can only be performed once.
 * @param {string} userId The user for this database.
 * @param {string} name The name for this database.
 * @param {GearsDatabase} gearsDb The gears database.
 */
google.wspl.gears.Database.prototype.openDatabase = function(userId, name,
    gearsDb) {
  if (!this.db_) {
    this.db_ = gearsDb;
    this.userId_ = userId;
    this.name_ = name;
    google.wspl.GearsUtils.openDatabase(userId, name, this.db_,
        google.logger);
  } else {
   google.logger('openDatabase already invoked.');
  }
};

/**
 * Starts a worker to handle the database interactions.  The worker will be
 * asynchronously started after the specified delay and will not be used until
 * the completion of any pending transaction.
 * @param {GearsWorkerPool} wp The Gears worker pool.
 * @param {string} workerUrl The URL to find the gears database worker.
 * @return {number} The worker ID.
 */
google.wspl.gears.Database.prototype.startWorker = function(wp, workerUrl) {
  this.wp_ = wp;

  google.logger('Starting dbworker thread.');

  this.workerId_ = wp.createWorkerFromUrl(workerUrl);

  this.timeoutId_ = window.setTimeout(google.bind(this.handleTimeout_, this),
      google.wspl.gears.Database.TIMEOUT);

  return this.workerId_;
};

/**
 * @see google.wspl.Transaction#createTransaction
 * @inheritDoc
 */
google.wspl.gears.Database.prototype.createTransaction = function(populate,
    opt_callback) {
  var transactionCallback = opt_callback || {
    onSuccess : function() {},
    onFailure : function() {}
  };

  var id = this.transCount_++;
  var transaction = new google.wspl.gears.Transaction(id, this);

  this.saveTransaction_(transaction, transactionCallback, populate);

  this.queuedTransactions_.push(transaction.id_);
  this.nextTransaction_();
};

/**
 * Saves the transaction and transaction callback to be accessed later when a
 * commit or rollback is performed.
 *
 * @param {google.wspl.gears.Transaction} transaction The transaction that the
 *     callback belongs to.
 * @param {Object} callback A transaction callback with onSuccess and onFailure
 * @private
 */
google.wspl.gears.Database.prototype.saveTransaction_ = function(
    transaction, callback, populate) {
  this.transactions_[transaction.id_] = {
    transaction: transaction,
    callback: callback,
    populate: populate
  };
};

/**
 * Handles incomming messages.
 * @param {string} a Deprecated.
 * @param {number} b Deprecated.
 * @param {Object} messageObject The message object.
 * @private
 */
google.wspl.gears.Database.prototype.onMessage_ =
    function(a, b, messageObject) {
  var message = messageObject.body;

  try {
    switch(message['type']) {
      case google.wspl.gears.DbWorker.ReplyTypes.RESULT:
        this.handleResult_(message['results'], message['callbackId'],
            message['transactionId']);
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.FAILURE:
        this.handleFailure_(message['error'], message['callbackId'],
            message['transactionId']);
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.COMMIT:
        this.handleCommit_(message['transactionId']);
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.ROLLBACK:
        this.handleRollback_(message['transactionId']);
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.STARTED:
        this.handleStarted_();
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.OPEN_SUCCESSFUL:
        this.handleOpenSuccessful_();
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.OPEN_FAILED:
        this.handleOpenFailed_(message['error']);
        break;
      case google.wspl.gears.DbWorker.ReplyTypes.LOG:
        google.logger(message['msg']);
        break;
    }
  } catch (ex) {
    google.logger('Gears database failed: ' + ex.message, ex);
  }
};

/**
 * Opens a new Gears database.
 *
 * @param {string} userId The user to which the database belongs.
 * @param {string} name The name of the database.
 */
google.wspl.gears.Database.prototype.doOpen = function(userId, name) {
  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.CommandTypes.OPEN,
    'name': name,
    'userId': userId
  });
};

/**
 * Begins a new transaction on the Gears database.
 *
 * @param {number} transactionId The id of the transaction being committed.
 */
google.wspl.gears.Database.prototype.doBegin = function(transactionId) {
  if (!this.useWorker_) {
    this.db_.execute('BEGIN IMMEDIATE');
    return;
  }

  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.CommandTypes.BEGIN,
    'transactionId': transactionId
  });
};

/**
 * Commits the current transaction on the Gears database.  The transactionId
 * is used to invoke the callback associated with the transaction.
 *
 * @param {number} transactionId The id of the transaction being committed.
 */
google.wspl.gears.Database.prototype.doCommit = function(transactionId) {
  if (!this.useWorker_) {
    this.db_.execute('COMMIT');
    this.postCommit_();
    return;
  }

  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.CommandTypes.COMMIT,
    'transactionId': transactionId
  });
};

/**
 * Rolls the current transaction back on the Gears database.  The transactionId
 * is used to invoke the callback associated with the transaction.
 *
 * @param {number} transactionId The id of the transaction being rolled back.
 */
google.wspl.gears.Database.prototype.doRollback = function(transactionId) {
  if (!this.useWorker_) {
    this.db_.execute('ROLLBACK');
    this.postRollback_();
    return;
  }

  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.CommandTypes.ROLLBACK,
    'transactionId': transactionId
  });
};

/**
 * Executes an array of statements on the Gears database.  The transactionId and
 * callbackId are used to identify the callback that should be invoked when
 * handleResult or handleFailure is called.
 *
 * @param {Array.<google.wspl.Statement>} statements The group of statements to
 *     execute
 * @param {number} callbackId The callback to invoke for each statement
 * @param {number} transactionId The transaction that the statements belong to
 */
google.wspl.gears.Database.prototype.doExecute = function(statements,
                                                          callbackId,
                                                          transactionId) {
  if (!this.useWorker_) {
    this.doExecuteSynchronously_(statements, callbackId, transactionId);
    return;
  }

  var newStatements = [];
  for (var i = 0; i < statements.length; i++) {
    newStatements[i] = {
      'sql': statements[i].sql,
      'params': statements[i].params
    };
  }

  this.sendMessageToWorker_({
    'type': google.wspl.gears.DbWorker.CommandTypes.EXECUTE,
    'statements': newStatements,
    'callbackId': callbackId,
    'transactionId': transactionId
  });
};

/**
 * Executes an array of statements on the synchronous Gears databse.
 * @param {Array.<google.wspl.Statement>} statements
 * @param {number} callbackId
 * @param {number} transactionId
 * @private
 */
google.wspl.gears.Database.prototype.doExecuteSynchronously_ =
    function(statements, callbackId, transactionId) {
  var db = this;
  var results = [];
  for (var i = 0; i < statements.length; i++) {
    try {
      var resultset = this.db_.execute(statements[i].sql, statements[i].params);
      var result = google.wspl.GearsUtils.resultSetToObjectArray(resultset);
      results.push(result);
    } catch (e) {
      var error = e;
      function failureCallback() {
        db.handleFailure_(error, callbackId, transactionId);
      };
      this.setTimeout_(failureCallback, 0);
      return;
    }
  }

  function resultCallback() {
    db.handleResult_(results, callbackId, transactionId);
  };
  this.setTimeout_(resultCallback, 0);
};

/**
 * Handles a RESULT message from the worker thread.
 *
 * @param {!Array.<!Array.<Object>>} results A Gears result set.
 * @param {number} callbackId The callback to invoke.
 * @param {number} transactionId The transaction that the statement is executing
 *     in.
 * @private
 */
google.wspl.gears.Database.prototype.handleResult_ = function(results,
    callbackId, transactionId) {
  var transInfo = this.transactions_[transactionId];
  if (transInfo) {
    for (var i = 0, l = results.length; i < l; i++) {
      var resultSet = new google.wspl.gears.ResultSet(results[i]);
      transInfo.transaction.success(resultSet, callbackId);
    }
  }
};

/**
 * Handles a FAILURE message from the worker thread.
 *
 * @param {Error} error An error produced by the Gears database
 * @param {number} callbackId The callback to invoke
 * @param {number} transactionId The transaction that the statement is executing
 *     in
 * @private
 */
google.wspl.gears.Database.prototype.handleFailure_ = function(error,
    callbackId, transactionId) {
  var transInfo = this.transactions_[transactionId];
  if (transInfo) {
    transInfo.error = error;
    transInfo.transaction.failure(error, callbackId);
  }
};

/**
 * Handles a COMMIT message from the worker thread.
 *
 * @param {number} id The transaction id.
 * @private
 */
google.wspl.gears.Database.prototype.handleCommit_ = function(id) {
  var transaction = this.removeTransaction_(id);
  if (transaction) {
    transaction.callback.onSuccess();
  }

  this.nextTransaction_();
};

/**
 * Handles the completion of a commit from the synchronous database.
 * @private
 */
google.wspl.gears.Database.prototype.postCommit_ = function() {
  this.handleCommit_(this.currentTransactionId_);
};

/**
 * Handles a ROLLBACK message from the worker thread.
 *
 * @param {number} id The transaction id
 * @private
 */
google.wspl.gears.Database.prototype.handleRollback_ = function(id) {
  var transaction = this.removeTransaction_(id);
  if (transaction) {
    transaction.callback.onFailure(transaction.error);
  }

  this.nextTransaction_();
};

/**
 * Handles the completion of a rollback from the synchronous database.
 * @private
 */
google.wspl.gears.Database.prototype.postRollback_ = function() {
  this.handleRollback_(this.currentTransactionId_);
};

/**
 * Handles a STARTED message from the worker thread.
 *
 * @private
 */
google.wspl.gears.Database.prototype.handleStarted_ = function() {
  if (!this.workerTimeout_) {
    google.logger('Dbworker started.');
    window.clearTimeout(this.timeoutId_);
    this.timeoutId_ = 0;
    this.doOpen(this.userId_, this.name_);
  }
};

/**
 * Handles a timeout of waiting for a STARTED message from the worker thread.
 *
 * @private
 */
google.wspl.gears.Database.prototype.handleTimeout_ = function() {
  this.workerTimeout_ = true;
  google.logger('Timed out while waiting for the dbworker to start.');
};

/**
 * Handles a OPEN_SUCCESSFUL message from the worker thread.
 *
 * @private
 */
google.wspl.gears.Database.prototype.handleOpenSuccessful_ = function() {
  this.workerReady_ = true;
};

/**
 * Handles a OPEN_FAILED message from the worker thread.
 * @param {string} error
 * @private
 */
google.wspl.gears.Database.prototype.handleOpenFailed_ = function(error) {
  google.logger('Worker failed to open Gears database.');
};

/**
 * Executes the next transaction if there is one queued.
 *
 * @private
 */
google.wspl.gears.Database.prototype.nextTransaction_ = function() {
  if (this.queuedTransactions_.length && !this.locked_) {
    this.locked_ = true;

    if (this.workerReady_ && !this.useWorker_) {
      this.useWorker_ = true;
      google.logger('Switching to asynchronous database interface.');
    }

    var id = this.queuedTransactions_.shift();
    this.currentTransactionId_ = id;
    var transactionData = this.transactions_[id];

    var db = this;
    function populate() {
      transactionData.populate(transactionData.transaction);

      // If populate did not execute statements on the database, invoke the
      // success callback and process the next transaction.
      if (!transactionData.transaction.isExecuting()) {
        db.handleCommit_(id);
      }
    };

    this.setTimeout_(populate, 0);
  }
};

/**
 * Cleans up the transaction and transaction callback for the id specified.
 *
 * @param {number} id The transaction id.
 * @return {google.wspl.Transaction} The transaction and callback in an object.
 * @private
 */
google.wspl.gears.Database.prototype.removeTransaction_ = function(id) {
  this.locked_ = false;
  var transaction = this.transactions_[id];
  if (transaction) {
    delete this.transactions_[id];
  }
  return transaction;
};

/**
 * Execute a function using window's setTimeout.
 * @param {Function} func The function to execute.
 * @param {number} time The time delay before invocation.
 * @private
 */
google.wspl.gears.Database.prototype.setTimeout_ = function(func, time) {
  if (this.synchronous_) {
    func();
  } else {
    window.setTimeout(func, time);
  }
};

/**
 * Sends a message to the database worker thread.
 * @param {Object} msg The message object to send.
 * @private
 */
google.wspl.gears.Database.prototype.sendMessageToWorker_ = function(msg) {
  this.wp_.sendMessage(msg, this.workerId_);
};

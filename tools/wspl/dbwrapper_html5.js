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
 * @fileoverview Generic Database API.
 *
 * A small set of classes to define how we interact with databases that
 * can easily be implemented on top of HTML5.
 */

google.wspl.html5 = google.wspl.html5 || {};

/**
 * Specification's default largest database size in HTML5 databases.
 * @type{number}
 */
google.wspl.LARGEST_SUPPORTED_DATABASE = 1024 * 1024 * 4;

/**
 * Creates an HTML5 Transaction object.
 * @see google.wspl.Transaction#Transaction
 *
 * @constructor
 * @extends google.wspl.Transaction
 *
 * @param {SQLTransaction} html5tx The HTML5 implementation of transactions.
 */
google.wspl.html5.Transaction = function(html5tx) {
  this.tx_ = html5tx;
};
google.inherits(google.wspl.html5.Transaction, google.wspl.Transaction);

/**
 * Runs an array of statements in a single database transaction.
 * Invokes the onSuccess callback once for each succeesfully executed
 *     statement and
 * once for the first failed statement.
 *
 * @param {Array.<google.wspl.Statement>} statements The statements to
 *     execute.
 * @param {Object?} opt_callback An object containing onSuccess and onFailure
 *     handlers.
 */
google.wspl.html5.Transaction.prototype.executeAll = function(statements,
    opt_callback) {
  if (statements.length == 0) {
    throw Error('Possibly silly attempt to execute empty statement list.');
  }

  var self = this;
  for (var i = 0; i < statements.length; ++i) {
    var statement = statements[i];
    google.logger('SQL: ' + statement.sql + ' PARAMS: ' + statement.params);
    this.tx_.executeSql(statement.sql, statement.params,
        function(tx, result) {
          if (opt_callback && opt_callback.onSuccess) {
            var resultSet = new google.wspl.html5.ResultSet(result);
            opt_callback.onSuccess(self, resultSet);
          }
        },
        function(tx, error) {
          if (opt_callback && opt_callback.onFailure) {
            opt_callback.onFailure(error);
          }
          // fail the whole transaction if any step fails
          return true;
        });
  }
};

/**
 * @see google.wspl.Database#Database
 * @param {string} name The name for this database.
 * @param {window} opt_window A window object for dependency injection.
 * @constructor
 * @extends google.wspl.Database
 */
google.wspl.html5.Database = function(name, opt_window) {
  /**
   * Sequence number for transactions.
   * @type {number}
   * @private
   */
  this.sequenceNum_ = 1;

  /**
   * Map of transactionIds -> transaction start time in millis.
   * @type {Object}
   * @private
   */
  this.inflightTransactions_ = {};

  var win = opt_window || window;
  this.db_ = win.openDatabase(name, '',
      name, google.wspl.LARGEST_SUPPORTED_DATABASE);
  if (this.db_ == null) {
    throw Error('The returned database was null.');
  }
};
google.inherits(google.wspl.html5.Database, google.wspl.Database);

/**
 * @see google.wspl.Database#createTransaction
 */
google.wspl.html5.Database.prototype.createTransaction = function(populate,
    opt_callback) {
  var transactionCallback = opt_callback || {
    onSuccess: function() {},
    onFailure: function() {}
  };

  var transactionId = this.sequenceNum_++;
  var inflightTransactions = this.inflightTransactions_;
  inflightTransactions[transactionId] = this.getCurrentTime();
  this.db_.transaction(
      function(tx) {
        // Delete the transaction before the executing it because our
        // definition of an 'in-flight' transaction is the time between
        // when the request was made and when the database starts to
        // execute the transaction.
        delete inflightTransactions[transactionId];
        populate(new google.wspl.html5.Transaction(tx));
      },
      function(error) {transactionCallback.onFailure(error);},
      function() {transactionCallback.onSuccess();});
};

/**
 * Determine if there is an in-flight database transaction that's older than
 * the given time period.
 * @param {number} olderThanMillis The time period.
 * @return {boolean} True if the database has an in-flight transaction older
 *     than the given time period, false otherwise.
 */
google.wspl.html5.Database.prototype.hasInflightTransactions =
    function(olderThanMillis) {
  for (var transactionId in this.inflightTransactions_) {
    var startTime = this.inflightTransactions_[transactionId];
    if (this.getCurrentTime() - startTime > olderThanMillis) {
      return true;
    }
  }
  return false;
};

/**
 * Returns the current time.
 * @return {number} The current time in millis.
 */
google.wspl.html5.Database.prototype.getCurrentTime = function() {
  // The iPhone does not support Date.now()
  var d = new Date();
  return d.getTime();
};

/**
 * Creates an HTML5 ResultSet object.
 * @see google.wspl.ResultSet#ResultSet
 *
 * @constructor
 * @extends google.wspl.ResultSet
 *
 * @param {Object} html5_result The HTML5 implementation of result set.
 */
google.wspl.html5.ResultSet = function(html5_result) {
  this.result_ = html5_result;
  this.index_ = 0;
};
google.inherits(google.wspl.html5.ResultSet, google.wspl.ResultSet);

/**
 * @see google.wspl.ResultSet#isValidRow
 */
google.wspl.html5.ResultSet.prototype.isValidRow = function() {
  return this.index_ >= 0 && this.index_ < this.result_.rows.length;
};

/**
 * @see google.wspl.ResultSet#next
 */
google.wspl.html5.ResultSet.prototype.next = function() {
  this.index_ ++;
};

/**
 * @see google.wspl.ResultSet#getRow
 */
google.wspl.html5.ResultSet.prototype.getRow = function() {
  return this.result_.rows.item(this.index_);
};

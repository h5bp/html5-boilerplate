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
 * A small set of classes to define how we interact with databases that can
 * easily be implemented on top of HTML5 and Gears.  The classes in this file
 * should be extended to provide the missing method implementations and more
 * sophisticated constructors where applicable.
 *
 */

/**
 * Constructs a Statement object.  A Statement is an SQL statement paired
 * with the parameters needed to execute it.
 *
 * @constructor
 * @param {!string} sql The SQL statement.
 * @param {Array.<Object>?} opt_params The parameters for the SQL statement.
 */
google.wspl.Statement = function(sql, opt_params) {

  /**
   * The SQL statement with '?' in place of parameters.
   * @type {string}
   */
  this.sql = sql;

  /**
   * The parameters to use with the SQL statement.
   * @type {!Array}
   */
  this.params = opt_params || [];
};

/**
 * Returns a new statement object from the given statement with the parameters
 * set as specified.
 * @param {Array.<Object>} params The array of values for ? placeholders.
 * @return {!google.wspl.Statement} The created Statement.
 */
google.wspl.Statement.prototype.createStatement = function(params) {
  return new google.wspl.Statement(this.sql, params);
};

/**
 * Constructs a Transaction object.  Transaction objects
 * group together a series of statements into a single atomic
 * action on the database.
 *
 * @constructor
 */
google.wspl.Transaction = function() {
};

/**
 * Takes a statement and an optional callback object and
 * runs the statement on the database. The callback can be used to
 * add more statements to the same transaction, or execute can be
 * called repeatedly and the transactions will later execute in the
 * order provided.
 *
 * @param {google.wspl.Statement} statement The statement to execute.
 * @param {Object} opt_callback An object containing onSuccess and onFailure
 *     handlers.
 */
google.wspl.Transaction.prototype.execute = function(statement,
    opt_callback) {
  this.executeAll([statement], opt_callback);
};

/**
 * Runs an array of statements in a single database transaction.
 * Invokes the onSuccess callback once for each successfully executed
 * statement and once for the first failed statement. The callback can be
 * used to add more statements to the same transaction, or executeAll can
 * be called repeatedly and each block of statements given will execute
 * in the same order as the sequence of calls to executeAll.
 *
 * @param {Array.<google.wspl.Statement>} statements The statements to
 *     execute.
 * @param {Object?} opt_callback An object containing onSuccess and onFailure
 *     handlers.
 */
google.wspl.Transaction.prototype.executeAll = function(statements,
    opt_callback) {
  throw Error('executeAll not implemented');
};

/**
 * Constructs a Database object. Database objects are handles that allow
 * access to a database (and create the corresponding database if it doesn't
 * already exist). To open the database, pass the name of the needed
 * database to the constructor, and then execute transactions on it using
 * the execute method.
 *
 * @constructor
 */
google.wspl.Database = function() {
};

/**
 * Creates a transaction object that can execute a series of SQL statements
 * atomically.
 *
 * @param {Function} populate A callback to run execute calls on the
 *     transaction.
 * @param {Object?} opt_callback An optional success/failure callback that is
 *     called when the entire transaction is finished executing.
 */
google.wspl.Database.prototype.createTransaction = function(populate,
    opt_callback) {
  throw Error('createTransaction not implemented');
};

/**
 * Executes an array of statements on the database, invoking the optional
 * callback after statement execution and the optional transactionCallback upon
 * completion of the transaction.
 *
 * @param {google.wspl.Statement} statement the statement to execute
 * @param {Object?} opt_callback object that defines onSuccess and onFailure
 * @param {Object?} opt_transactionCallback object that defines onSuccess and
 *    onFailure
 */
google.wspl.Database.prototype.execute = function(statement,
                                                  opt_callback,
                                                  opt_transactionCallback) {
  this.createTransaction(function(tx) {
    tx.execute(statement, opt_callback);
  }, opt_transactionCallback);
};

/**
 * Executes an array of statements on the database, invoking the optional
 * callback for each statement in the transaction.  In the case of a statement
 * failure, only the first failed statement will be reported and the transaction
 * will be rolled back.  This method invokes the optional transactionCallback
 * upon completion of the transaction.
 *
 * @param {Array.<google.wspl.Statement>} statements the statements to execute
 * @param {Object?} opt_callback object that defines onSuccess and onFailure
 * @param {Object?} opt_transactionCallback object that defines onSuccess and
 *     onFailure
 */
google.wspl.Database.prototype.executeAll = function(statements,
                                                     opt_callback,
                                                     opt_transactionCallback) {
  this.createTransaction(function(tx) {
    tx.executeAll(statements, opt_callback);
  }, opt_transactionCallback);
};

/**
 * An immutable set of results that is returned from a single successful query
 * on the database.
 *
 * @constructor
 */
google.wspl.ResultSet = function() {
};

/**
 * Returns true if next() will advance to a valid row in the result set.
 *
 * @return {boolean} if next() will advance to a valid row in the result set
 */
google.wspl.ResultSet.prototype.isValidRow = function() {
  throw Error('isValidRow not implemented');
};

/**
 * Advances to the next row in the results.
 */
google.wspl.ResultSet.prototype.next = function() {
  throw Error('next not implemented');
};

/**
 * Returns the current row as an object with a property for each field returned
 * by the database.  The property will have the name of the column and the value
 * of the cell.
 *
 * @return {Object} The current row
 */
google.wspl.ResultSet.prototype.getRow = function() {
  throw Error('getRow not implemented');
};

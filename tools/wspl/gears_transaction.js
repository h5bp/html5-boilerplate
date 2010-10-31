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
 * @fileoverview A Gears implementation of dbwrapperapi Transaction.
 */

/**
 * Creates a Gears Transaction object.
 * @see google.wspl.ResultSet#ResultSet
 *
 * @constructor
 * @extends google.wspl.Transaction
 *
 * @param {number} id The unique id for this transaction
 * @param {google.wspl.gears.Database} db The Gears implementation of the
 *    dbwrapperapi database
 */
google.wspl.gears.Transaction = function(id, db) {
  google.wspl.Transaction.call(this);

  /**
   * The unique id for this transaction.
   * @type {number}
   * @private
   */
  this.id_ = id;

  /**
   * The Gears implementation of the dbwrapperapi database.
   * @type {google.wspl.gears.Database}
   * @private
   */
  this.db_ = db;

  /**
   * A map of statements, callback, and current statement.
   * @type {Object}
   * @private
   */
  this.activeExecutes_ = {};
};
google.inherits(google.wspl.gears.Transaction, google.wspl.Transaction);

/**
 * The number of active executes.
 * @type {number}
 * @private
 */
google.wspl.gears.Transaction.prototype.numActiveExecutes_ = 0;

/**
 * The id for the next call to execute.  Incremented after use.
 * @type {number}
 * @private
 */
google.wspl.gears.Transaction.prototype.nextCallbackId_ = 1;

/**
 * Whether the transaction should be rolled back or not. This property is set
 * to true when a statement fails.
 * @type {boolean}
 * @private
 */
google.wspl.gears.Transaction.prototype.needsRollback_ = false;

/**
 * Begins a new transaction with the Gears database. Commits the transaction if
 * all calls to executeAll for this transaction have finished receiving
 * callbacks.  Rolls the transaction back if a statement failed.
 *
 * @see google.wspl.Transaction#executeAll
 * @inheritDoc
 */
google.wspl.gears.Transaction.prototype.executeAll = function(statements,
    opt_callback) {
  if (statements.length == 0) {
    throw Error('Possibly silly attempt to execute empty statement list.');
  }
  if (this.numActiveExecutes_ == 0) {
    this.db_.doBegin(this.id_);
  }

  this.numActiveExecutes_++;
  var callbackId = this.nextCallbackId_++;

  var callback = opt_callback || {
    onSuccess : function() {},
    onFailure : function() {}
  };

  this.activeExecutes_[callbackId] = {
    statements: statements,
    currentStatement: 0,
    callback: callback
  };

  this.db_.doExecute(statements, callbackId, this.id_);
};

/**
 * Invokes onSuccess on the specified callback.
 *
 * @param {google.wspl.ResultSet} result The result of a successful statement
 * @param {number} callbackId The callback to invoke
 */
google.wspl.gears.Transaction.prototype.success = function(result,
                                                           callbackId) {
  if (!this.needsRollback_) {
    var activeExecute = this.activeExecutes_[callbackId];
    activeExecute.callback.onSuccess(this, result);
  }
  this.endStatement_(callbackId);
};

/**
 * Invokes onFailure on the specified callback.
 *
 * @param {Error} error The error of an unsuccessful statement
 * @param {number} callbackId The callback to invoke
 */
google.wspl.gears.Transaction.prototype.failure = function(error,
                                                           callbackId) {
  if (!this.needsRollback_) {
    this.needsRollback_ = true;
    var activeExecute = this.activeExecutes_[callbackId];
    activeExecute.callback.onFailure(error);
  }
  this.endStatement_(callbackId);
};

/**
 * Handles clean up for the end of a single execution.
 *
 * @param {number} callbackId The callback to clean up.
 * @private
 */
google.wspl.gears.Transaction.prototype.endStatement_ = function(callbackId) {
  var activeExecute = this.activeExecutes_[callbackId];
  var statements = activeExecute.statements;
  var currentStatement = ++activeExecute.currentStatement;

  if (currentStatement == statements.length) {
    this.endExecute_(callbackId);
  }
};

/**
 * Handles clean up for the end of a call to executeAll.  Performs a commit or
 * rollback if this is the last active execute to clean up.
 *
 * @param {number} callbackId The callback to clean up
 * @private
 */
google.wspl.gears.Transaction.prototype.endExecute_ = function(callbackId) {
  delete this.activeExecutes_[callbackId];
  this.numActiveExecutes_--;
  if (!this.isExecuting()) {
    this.endTransaction_();
  }
};

/**
 * Instructs the worker to commit the transaction or roll it back if a failure
 * occurred and a rollback is required.
 *
 * @private
 */
google.wspl.gears.Transaction.prototype.endTransaction_ = function() {
  if (this.needsRollback_) {
    this.db_.doRollback(this.id_);
  } else {
    this.db_.doCommit(this.id_);
  }
};

/**
 * @return {boolean} True if the transaction has statements executing, false
 *     otherwise.
 */
google.wspl.gears.Transaction.prototype.isExecuting = function() {
  return this.numActiveExecutes_ > 0;
};

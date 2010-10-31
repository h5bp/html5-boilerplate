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
 * @fileoverview A Gears implementation of dbwrapperapi ResultSet.
 */

/**
 * Creates a Gears ResultSet object.
 * @see google.wspl.ResultSet#ResultSet
 *
 * @constructor
 * @extends google.wspl.ResultSet
 * @param {!Array.<Object>} resultArray An array of hash objects where the
 *     column names in the query are used as members of the objects.
 */
google.wspl.gears.ResultSet = function(resultArray) {
  google.wspl.ResultSet.call(this);

  /**
   * The result set as an array of hash objects.
   * @type {!Array.<Object>}
   * @private
   */
  this.resultArray_ = resultArray;
};
google.inherits(google.wspl.gears.ResultSet, google.wspl.ResultSet);

/**
 * The current record in the result set.
 * @type {number}
 * @private
 */
google.wspl.gears.ResultSet.prototype.current_ = 0;

/**
 * @see google.wspl.ResultSet#isValidRow
 * @inheritDoc
 */
google.wspl.gears.ResultSet.prototype.isValidRow = function() {
  return this.current_ < this.resultArray_.length;
};

/**
 * @see google.wspl.ResultSet#next
 * @inheritDoc
 */
google.wspl.gears.ResultSet.prototype.next = function() {
  this.current_++;
};

/**
 * @see google.wspl.ResultSet#getRow
 * @inheritDoc
 */
google.wspl.gears.ResultSet.prototype.getRow = function() {
  return this.resultArray_[this.current_];
};

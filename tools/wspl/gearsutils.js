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
 * @fileoverview Some simple utilities for supporting Gears usage.
 */
google.wspl.GearsUtils = google.wspl.GearsUtils || {};

/**
 * Returns an array of hash objects, one per row in the result set,
 * where the column names in the query are used as the members of
 * the object.
 *
 * @param {GearsResultSet} rs the result set returned by execute.
 * @return {Array.<Object>} An array containing hashes. Returns an empty
 *     array if there are no matching rows.
 */
google.wspl.GearsUtils.resultSetToObjectArray = function(rs) {
  var rv = [];
  if (rs) {
    var cols = rs['fieldCount']();
    var colNames = [];
    for (var i = 0; i < cols; i++) {
      colNames.push(rs['fieldName'](i));
    }

    while (rs['isValidRow']()) {
      var h = {};
      for (var i = 0; i < cols; i++) {
        h[colNames[i]] = rs['field'](i);
      }
      rv.push(h);
      rs['next']();
    }
  }
  return rv;
};

/**
 * Maximum file name length.
 * @type {number}
 * @private
 */
google.wspl.GearsUtils.MAX_FILE_NAME_LENGTH_ = 64;

/**
 * Ensures that the given dbName is safe to use as a Gears database name.
 * @type {!string} dbName
 * @return {!string} The sanitized name.
 * @private
 */
google.wspl.GearsUtils.makeSafeFileName_ = function(dbName) {
  var sanitizedFileName = dbName.replace(/[^a-zA-Z0-9\.\-@_]/g, '');
  if (sanitizedFileName.length <=
      google.wspl.GearsUtils.MAX_FILE_NAME_LENGTH_) {
    return sanitizedFileName;
  } else {
    return sanitizedFileName.substring(0,
        google.wspl.GearsUtils.MAX_FILE_NAME_LENGTH_);
  }
};

/**
 * Opens a Gears Database using the provided userid and name.
 * @param {string} userId The user to which the database belongs.
 * @param {string} name The database's name.
 * @param {GearsDatabase} db The Gears database to open.
 * @param {function(string)} opt_logger A logger function for writing
 *     messages.
 * @return {GearsDatabase} The open GearsDatabase object.
 */
google.wspl.GearsUtils.openDatabase = function(userId, name, db,
    opt_logger) {
  var dbId = userId + '-' + name;
  var safeDbId = google.wspl.GearsUtils.makeSafeFileName_(dbId);
  if (opt_logger && dbId != safeDbId) {
    opt_logger('database name ' + dbId + '->' + safeDbId);
  }
  db.open(safeDbId);
  return db;
};

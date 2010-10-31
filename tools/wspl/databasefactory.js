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

// Namespace.
google.wspl.DatabaseFactory = google.wspl.DatabaseFactory || {};

/**
 * Factory function to build databases in a cross-API manner.
 * @param {string} dbName of the database
 * @param {string} dbworkerUrl the URL for Gears worker.
 * @return {google.wspl.Database} The database object.
 */
google.wspl.DatabaseFactory.createDatabase = function(dbName, dbworkerUrl) {
  var dbms;
  if (window.openDatabase) {
    // We have HTML5 functionality.
    dbms = new google.wspl.html5.Database(dbName);
  } else {
    // Try to use Google Gears.
    var gearsDb = goog.gears.getFactory().create('beta.database');
    var wp = goog.gears.getFactory().create('beta.workerpool');

    // Note that Gears will not allow file based URLs when creating a worker.
    dbms = new wireless.db.gears.Database();
    dbms.openDatabase('', dbName, gearsDb);
    wp.onmessage = google.bind(dbms.onMessage_, dbms);

    // Comment this line out to use the synchronous database.
    dbms.startWorker(wp, dbworkerUrl, 0);
  }
  return dbms;
};

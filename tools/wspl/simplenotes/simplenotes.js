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
 * @fileoverview A concrete example of the cache pattern for building an offline
 * webapplication: a cache for SimpleNotes.
 */

google.wspl.simplenotes = google.wspl.simplenotes || {};
google.logger('start simplenotes.js');

/**
 * Status keys for the write buffer.
 * @enum {number}
 */
google.wspl.simplenotes.WriteBufferStates = {
  /**
   * The update is in flight to the server.
   */
  INFLIGHT: 1,

  /**
   * The update needs to be (re)sent to the server but is not in flight.
   */
  SEND: 2,

  /**
   * The update needs to be applied to the cached notes.
   */
  REAPPLY: 8
};

/**
 * Creates a SimpleNotes cache wrapping a backing database.
 * @constructor
 */
google.wspl.simplenotes.Cache = function() {
  this.dbms_ = google.wspl.DatabaseFactory.createDatabase(
      'simple-notes', 'http://yourdomain/dbworker.js');

  /**
   * Cache directory is a two-tuple over a range. (Holes
   * must be allowed to support delection.)
   * This is the lower (inclusive) bound of the cached range.
   * @type {number}
   * @private
  */
  this.start_ = -1;

  /**
   *
   * This is the upper (inclusive) bound of the cached range.
   * @type {number}
   * @private
   */
  this.end_ = -1;

  /**
   * Start of range of notes known to exist on server at time of last
   * response.
   * @param {number}
   */
   this.serverStart_ = -1;

  /**
   * End of range of notes known to exist on server at time of last
   * response.
   * @param {number}
   */
   this.serverEnd_ = -1;

  /**
   * Time of last refresh.
   * @type {number}
   * @private
   */
  this.lastRefresh_ = -1;

  /**
   * Last missing query.
   * @type {Object}
   * @private
   */
  this.lastMiss_ = undefined;
};

/**
 * Interval between refreshes in milliseconds.
 * @type {number}
 * @private
 */
google.wspl.simplenotes.Cache.TIME_BETWEEN_REFRESH_ = 2000;

google.wspl.simplenotes.Cache.CREATE_CACHED_NOTES_ =
      new google.wspl.Statement(
    'CREATE TABLE IF NOT EXISTS cached_notes (' +
        'noteKey INTEGER UNIQUE PRIMARY KEY,' +
        'subject TEXT,' +
        'body TEXT' +
    ');'
);

google.wspl.simplenotes.Cache.CREATE_WRITE_BUFFER_ =
      new google.wspl.Statement(
    'CREATE TABLE IF NOT EXISTS write_buffer (' +
        'sequence INTEGER UNIQUE PRIMARY KEY AUTOINCREMENT,' +
        'noteKey INTEGER,' +
        'status INTEGER,' +
        'subject TEXT,' +
        'body TEXT' +
    ');'
);

google.wspl.simplenotes.Cache.DETERMINE_MIN_KEY_ =
  new google.wspl.Statement(
  'SELECT MIN(noteKey) as minNoteKey FROM cached_notes;');

google.wspl.simplenotes.Cache.DETERMINE_MAX_KEY_ =
  new google.wspl.Statement(
  'SELECT MAX(noteKey) as maxNoteKey FROM cached_notes;');

/**
 * Builds a cache and writebuffer combination for notes and then
 * invokes the given callback.
 * @param {function) callback.
 */
google.wspl.simplenotes.Cache.prototype.startCache = function(callback) {
  google.logger('startCache');
  var statc  = 0;
  var self = this;

  var perStatCallback = function(tx, result) {
    google.logger('perStatCallback');
    if (statc == 4) {
      self.start_ = (result.isValidRow()) ? result.getRow().minNoteKey : -1;
      self.serverStart_ = self.start_; // Temporary. Remove when server exists.
    } else if (statc == 5) {
      self.end_ = (result.isValidRow()) ? result.getRow().maxNoteKey : -1;
      self.serverEnd_ = self.end_; // Temporary. Remove when server exists.
    }
    statc++;
  };

  this.dbms_.executeAll([
      google.wspl.simplenotes.Cache.CREATE_CACHED_NOTES_,
      google.wspl.simplenotes.Cache.CREATE_WRITE_BUFFER_,
      google.wspl.simplenotes.Cache.CREATE_UPDATE_TRIGGER_,
      google.wspl.simplenotes.Cache.CREATE_REPLAY_TRIGGER_,
      google.wspl.simplenotes.Cache.DETERMINE_MIN_KEY_,
      google.wspl.simplenotes.Cache.DETERMINE_MAX_KEY_],
      {onSuccess: perStatCallback, onFailure: this.logError_},
      {onSuccess: callback, onFailure: this.logError_});
  google.logger('finished startCache');
};

/**
 * Stub function to be replaced with a server communication.
 * @param {Array.<Object>} updates Payload to send to server.
 */
google.wspl.simplenotes.Cache.prototype.sendXhrPost = function(updates) {
  google.logger('Should dispatch XHR to server now.');
};

/**
 * @type {google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.LIST_CACHED_NOTES_ =
      new google.wspl.Statement(
    'SELECT noteKey, subject from cached_notes WHERE ' +
        'noteKey >= ? AND ' +
        'noteKey <= ? ' +
    ';'
);

/**
 * Tests if the given range is stored in the cache.
 * Note that this mechanism requires extension to handle the
 * creation of new notes.
 * @param {number} start Lower bound (inclusive) on range.
 * @param {number} end Uppder bound (inclusive) on range.
 * @private
 */
google.wspl.simplenotes.Cache.prototype.isCacheHit_ = function(start, end) {
  return start >= this.start_ && end <= this.end_
};

/**
 * Logs a possibly useful error message.
 * @param {Object} error An error descriptor.
 * @private
 */
google.wspl.simplenotes.Cache.prototype.logError_ = function(error) {
  google.logger('Simple Notes Cache is sad: ' + error);
};

/**
 * Queries the cache for a list of note headers.
 * @param {number} start The lower id in a range of notes.
 * @param {number} end The higher id in a range of notes.
 * @param {function(Array.<Object>)} valuesCallback A function to call
 *     with the result set after the transaction has completed.
 * @private
 */
google.wspl.simplenotes.Cache.prototype.getNoteList_ = function(start, end,
    valuesCallback) {
  var notes = [];

  var accumulateResults = function(tx, result) {
    for(; result.isValidRow(); result.next()) {
      notes.push(result.getRow());
      google.logger('pushed...');
    }
  };

  var inTransactionGetNotes = function(tx) {
    tx.execute(google.wspl.simplenotes.Cache.LIST_CACHED_NOTES_.
        createStatement([start, end]), {
        onSuccess: accumulateResults,
        onFailure: this.logError_});
  };

  var hit = this.isCacheHit_(start, end);
  this.dbms_.createTransaction(inTransactionGetNotes, {onSuccess: function() {
    valuesCallback(notes, hit);
  }, onFailure: this.logError_});

  if (hit) {
    this.fetchFromServer(this.start_, this.end_); // Refresh
  } else {
    this.fetchFromServer(Math.min(this.start_, start), Math.max(this.end_, end));
    this.lastMiss_ = {callback: valuesCallback, start: start, end: end};
  }
};

/**
 * @type {google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.GET_ONE_NOTE_ =
      new google.wspl.Statement(
    'SELECT noteKey, subject, body from cached_notes WHERE ' +
        'noteKey = ? ' +
    ';'
);

/**
 * Queries the cache for a list of note headers.
 * @param {number} noteId The note to get from the cache.
 * @param {function(Array.<Object>)} valuesCallback A function to call
 *     with the result set after the transaction has completed.
 * @private
 */
google.wspl.simplenotes.Cache.prototype.getOneNote_ = function(noteId,
    callback) {
  var note;

  this.dbms_.execute(google.wspl.simplenotes.Cache.GET_ONE_NOTE_.
      createStatement([noteId]),
      {onSuccess: function(tx, result) { note = result.getRow(); },
      onFailure: this.logError_},
      {onSuccess: function() { callback(note, true); },
      onFailure: this.logError_});
};

/**
 * Queries the cache for either a list of notes or a single note including
 * its body.
 * @param {string} type The kind of values desired: 'list' or 'fullnote'.
 * @param {Array.<number>} query The query for the values.
 * @param {function(Array.<Object>)} valuesCallback A function to call
 *     with the result set after the transaction has completed.
 */
google.wspl.simplenotes.Cache.prototype.getValues = function(type,
    query, valuesCallback) {

  // Reduce any query to what would be available from the server
  query[0] = Math.max(this.serverStart_, query[0]);
  query[1] = Math.min(this.serverEnd_, query[1]);

  if (type == 'list') {
    this.getNoteList_(query[0], query[1], valuesCallback);
  } else if (type == 'fullnote') {
    this.getOneNote_(query[0], valuesCallback);
  }
};

/**
 * SQL trigger to insert a new change from write buffer to
 * cache.
 * @private
 */
google.wspl.simplenotes.Cache.CREATE_UPDATE_TRIGGER_ =
    new google.wspl.Statement(
        'CREATE TRIGGER IF NOT EXISTS updateTrigger ' +
        'AFTER INSERT ON write_buffer ' +
        'BEGIN ' +
        '  REPLACE INTO cached_notes ' +
        '    SELECT noteKey, subject, body ' +
        '      FROM write_buffer WHERE status & 8 = 8; ' +
        '  UPDATE write_buffer SET status = status & ~ 8; ' +
        'END;'
    );

/**
 * SQL trigger to replay changes from the write buffer to
 * the cache.
 * @private
 */
google.wspl.simplenotes.Cache.CREATE_REPLAY_TRIGGER_ =
    new google.wspl.Statement(
        'CREATE TRIGGER IF NOT EXISTS replayTrigger ' +
        'AFTER UPDATE ON write_buffer WHEN NEW.status & 8 = 8 ' +
        'BEGIN ' +
        '  REPLACE INTO cached_notes ' +
        '    SELECT noteKey, subject, body ' +
        '      FROM write_buffer ' +
        '      WHERE noteKey = NEW.noteKey ' +
        '      ORDER BY sequence ASC;' +
        '  UPDATE write_buffer SET status = status & ~ 8; ' +
        'END;'
    );


/**
 * SQL statement to mark actions for replay.
 */
google.wspl.simplenotes.Cache.MARK_FOR_REPLAY =
    new google.wspl.Statement(
        'UPDATE write_buffer SET status = status | 8;');

/**
 * SQL statement to insert notes updates.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.INSERT_UI_UPDATE_ =
    new google.wspl.Statement(
        'INSERT INTO write_buffer (' +
          'noteKey, status, subject, body' +
        ') ' + 'VALUES(?,?,?,?);');

/**
 * Updates the given entry and write a new write buffer entry.
 * @param {number} noteKey
 * @param {string} subject
 * @param {string} body
 * @param {function(number)} ackCallback
 */
google.wspl.simplenotes.Cache.prototype.applyUiChange = function(noteKey,
    subject, body, ackCallback) {
  var self = this;
  var update = [noteKey, 2 | 8, subject, body];
  var stat = google.wspl.simplenotes.Cache.INSERT_UI_UPDATE_.createStatement(
      update);

  this.dbms_.execute(stat, null, {onSuccess: function() {
    google.logger('applyUiChange cb');
    ackCallback(noteKey);
  }, onFailure: function (error) {
    self.logError_(error);
    ackCallback(-1);
  }});
};

/**
 * SQL statement to insert notes updates.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.INSERT_NOTE_ =
    new google.wspl.Statement(
        'REPLACE INTO cached_notes (noteKey, subject, body) ' +
        'VALUES(?,?,?);' );

/**
 * SQL statement to force replay of pending actions by setting a bit
 * flag on each write-buffer row indicating that it should be reapplied
 * to the contents of the cache.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.FORCE_REPLAY_ =
    new google.wspl.Statement(
        'UPDATE write_buffer SET status = status | 8;' );

/**
 * SQL statement to delete notes no longer to be cached.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.EVICT_ =
    new google.wspl.Statement(
        'DELETE FROM cached_notes WHERE noteKey < ? OR noteKey > ?;');

/**
 * Applies the changes delivered from the server by first inserting
 * them into the cache and reapplying the write-buffer to the cache.
 * @param {!Array.<Object>} notes An array of arrays.
 */
google.wspl.simplenotes.Cache.prototype.insertUpdate = function(notes) {
  var self = this; var stats = [];
  var start = notes[0].noteKey;
  var end = notes[0].noteKey;

  for (var i = 0; i < notes.length; i++) {
    stats.push(google.wspl.simplenotes.Cache.INSERT_NOTE_.
        createStatement([notes[i].noteKey, notes[i].subject, notes[i].body]));
    start = Math.min(start, notes[0].noteKey);
    end = Math.max(end, notes[0].noteKey);
  }
  stats.push(google.wspl.simplenotes.Cache.EVICT_.createStatement([start, end]));
  stats.push(google.wspl.simplenotes.Cache.FORCE_REPLAY_);

  var inTrans = function(tx) {
    self.start_ = start;
    self.end_ = end;
    tx.executeAll(stats);
  };

  var afterInsert = function(tx) {
    if (this.lastMiss_ &&
        this.isCacheHit_(this.lastMiss_.start, this.lastMiss_.end)) {
      this.lastMiss_.callback(notes);
      this.lastMiss_ = undefined;
    }
  };

  this.dbms_.createTransaction(inTrans, {onSuccess: afterInsert,
      onError: this.logError_});
};

/**
 * SQL statement to force replay of pending actions by setting a bit
 * flag on each write-buffer row indicating that it should be reapplied
 * to the contents of the cache.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.GET_UPDATES_TO_RESEND_ =
    new google.wspl.Statement(
        'SELECT noteKey, subject, body FROM write_buffer WHERE status & 2 = 2;');



/**
 * SQL statement to mark write buffer statements as inflight.
 * @type {!google.wspl.Statement}
 * @private
 */
google.wspl.simplenotes.Cache.MARK_AS_INFLIGHT_ =
    new google.wspl.Statement(
        'UPDATE write_buffer SET status = status & ~2 | 1 WHERE status & 2 = 2;');

/**
 * Fetches new material from the server as required.
 * @param {number} start
 * @param {number} end
 * @param {function} opt_valueCallBack
 */
google.wspl.simplenotes.Cache.prototype.fetchFromServer = function(start,
    end) {
  google.logger('fetchFromServer');
  var now = this.dbms_.getCurrentTime();
  if (start >= this.start_ && end <= this.end_ &&
      now - this.lastRefresh_ <
      google.wspl.simplenotes.Cache.TIME_BETWEEN_REFRESH_) {
    return;
  }

  var updates = []; var self = this; var flag = 1; var sql = []
  sql.push(google.wspl.simplenotes.Cache.GET_UPDATES_TO_RESEND_);
  sql.push(google.wspl.simplenotes.Cache.MARK_AS_INFLIGHT_);

  var accumulateUpdates = function(tx, rs) {
    if (flag == 1) {
      for(; rs.isValidRow(); rs.next()) { updates.push(['u', rs.getRow()]); }
      flag++;
    }
  };

  var ackAndPost = function() {
    updates.push(['q', {start: start, end: end}]);
    self.sendXhrPost(updates);
  };

  this.dbms_.executeAll(sql,
      {onSuccess: accumulateUpdates, onFailure: this.logError_},
      {onSuccess: ackAndPost, onFailure: this.logError_});
};

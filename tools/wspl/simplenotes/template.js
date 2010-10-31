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
 * @fileoverview template.js contains the implementation for a simple template
 * scheme. Templates are fragments of HTML containing patterns into which
 * arguments will be substituted.
 */

google.wspl.simplenotes = google.wspl.simplenotes || {};

/**
 * Template class constructor. A template is an object which will
 * substitute provided parameters into a marked-up string.
 * @param {string} template
 * @constructor
*/
google.wspl.simplenotes.Template = function(template) {
  this.template_ = template;
  this.res_ = null;
};

/**
 * Returns the template expanded with the given args where args
 * is an object (acting as an associative array) binding keys (found
 * in the template wrapped with % symbols) to the associated
 * values.
 *
 * Template substitution symbols without corresponding arguments
 * will be passed through unchanged to the output.
 *
 * We assume that in typical use, the same template will be expanded
 * repeatedly with different values. In this case, storing and re-using
 * previously generated regular expressions will provide a performance
 * improvement.
 * @param {Object} args associates names with values
 * @param {boolean} opt_rebuild set to true to force re-building the
 *     the regular epxression.
*/
google.wspl.simplenotes.Template.prototype.process = function(args,
    opt_rebuild) {
  var rebuild = opt_rebuild || false;

  if (rebuild || this.res_ == null) {
    var accumulatedRe = [];
    this.res_ = null;
    for (var a in args) {
      accumulatedRe.push('%' + String(a) + '%');
    }
    if (accumulatedRe.length > 0) {
      this.res_ = new RegExp(accumulatedRe.join('|'), 'g');
    }
  }
  if (this.res_ != null) {
    return this.template_.replace(this.res_, function(match) {
          var keyName = match.slice(1,-1);
          return args[keyName];
    });
  } else {
    return this.template_;
  }
};

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
 * @fileoverview Global function implementations used for running the
 * web storage portability layer code outside of the Google internal
 * development environment.
 *
 * Include this file only once.
 *
 */

/**
 * Namespace object.
 * @type {Object}
 */
var google = google || {};
google.wspl = google.wspl || {};
google.wspl.gears = google.wspl.gears || {};

/**
 * Inherit the prototype methods from one constructor into another.
 * @param {Function} childConstructor Child class.
 * @param {Function} parentConstructor Parent class.
 */
google.inherits = function(childConstructor, parentConstructor) {
  function tempConstructor() {};
  tempConstructor.prototype = parentConstructor.prototype;
  childConstructor.prototype = new tempConstructor();
  childConstructor.prototype.constructor = childConstructor;
};

/**
 * Binds a context object to the function.
 * @param {Function} fn The function to bind to.
 * @param {Object} context The "this" object to use when the function is run.
 * @return {Function} A partially-applied form of fn.
 */
google.bind = function(fn, context) {
  return function() {
    return fn.apply(context, arguments);
  };
};

/**
 * Null function used for callbacks.
 * @type {Function}
 */
google.nullFunction = function() {};

/**
 * Simple logging facility.
 * @param {string} msg A message to write to the console.
 */
google.logger = function(msg) {
  // Uncomment the below to get log messages
  // May require firebug enabled to work in FireFox.
  // window.console.info(msg);
};

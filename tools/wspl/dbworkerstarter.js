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
 * @fileoverview Starts the dbworker.
 *
 * When constructing the worker for execution, this needs to be the last
 * file. The worker consists of the following source files combined together.
 *
 *   globalfunctions.js
 *   gearsutils.js
 *   dbworker.js
 *   dbworkerstarter.js
 *
 * and then loaded into a Gears worker process as implemented in
 * databasefactory.js
 */

google.wspl.gears.DbWorker.start();

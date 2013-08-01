### HEAD

* Update to Apache Server Configs 1.1.0
* Vertical centering for audio-, canvas- and video-tags ([#1326](https://github.com/h5bp/html5-boilerplate/issues/1326)).
* Update to Google Universal Analytics ([#1347](https://github.com/h5bp/html5-boilerplate/issues/1347)).
* Update to jQuery 1.10.2.
* Update to Normalize.css 1.1.2.

### 4.2.0 (April 8, 2013)

* Remove Google Analytics protocol check ([#1319](https://github.com/h5bp/html5-boilerplate/pull/1319)).
* Update to Normalize.css 1.1.1.
* Update Apache configurations to include the latest changes in the canonical
  [`.htaccess`](https://github.com/h5bp/server-configs-apache) file.
* Use a protocol relative URL for the 404 template script.
* Update to jQuery 1.9.1.

### 4.1.0 (January 21, 2013)

* Update to Normalize.css 1.1.0.
* Update to jQuery 1.9.0.

### 4.0.3 (January 12, 2013)

* Use 32x32 favicon.ico ([#1286](https://github.com/h5bp/html5-boilerplate/pull/1286)).
* Remove named function expression in plugins.js ([#1280](https://github.com/h5bp/html5-boilerplate/pull/1280)).
* Adjust CSS image-replacement code ([#1239](https://github.com/h5bp/html5-boilerplate/issues/1239)).
* Update HiDPI example media query ([#1127](https://github.com/h5bp/html5-boilerplate/issues/1127)).

### 4.0.2 (December 9, 2012)

* Update placeholder icons.
* Update to Normalize.css 1.0.2.
* Update to jQuery 1.8.3.

### 4.0.1 (October 20, 2012)

* Further improvements to `console` method stubbing ([#1206](https://github.com/h5bp/html5-boilerplate/issues/1206), [#1229](https://github.com/h5bp/html5-boilerplate/pull/1229)).
* Update to jQuery 1.8.2.
* Update to Modernizr 2.6.2.
* Minor additions to the documentation.

### 4.0.0 (August 28, 2012)

* Improve the Apache compression configuration ([#1012](https://github.com/h5bp/html5-boilerplate/issues/1012), [#1173](https://github.com/h5bp/html5-boilerplate/issues/1173)).
* Add a HiDPI example media query ([#1127](https://github.com/h5bp/html5-boilerplate/issues/1127)).
* Add bundled docs ([#1154](https://github.com/h5bp/html5-boilerplate/issues/1154)).
* Add MIT license ([#1139](https://github.com/h5bp/html5-boilerplate/issues/1139)).
* Update to Normalize.css 1.0.1.
* Separate Normalize.css from the rest of the CSS ([#1160](https://github.com/h5bp/html5-boilerplate/issues/1160)).
* Improve `console.log` protection ([#1107](https://github.com/h5bp/html5-boilerplate/issues/1107)).
* Replace hot pink text selection color with a neutral color.
* Change image replacement technique ([#1149](https://github.com/h5bp/html5-boilerplate/issues/1149)).
* Code format and consistency changes ([#1112](https://github.com/h5bp/html5-boilerplate/issues/1112)).
* Rename CSS file and rename JS files and subdirectories.
* Update to jQuery 1.8 ([#1161](https://github.com/h5bp/html5-boilerplate/issues/1161)).
* Update to Modernizr 2.6.1 ([#1086](https://github.com/h5bp/html5-boilerplate/issues/1086)).
* Remove uncompressed jQuery ([#1153](https://github.com/h5bp/html5-boilerplate/issues/1153)).
* Remove superfluous inline comments ([#1150](https://github.com/h5bp/html5-boilerplate/issues/1150)).

### 3.0.2 (February 19, 2012)

* Update to Modernizr 2.5.3.

### 3.0.1 (February 08, 2012).

* Update to Modernizr 2.5.2 (includes html5shiv 3.3).

### 3.0.0 (February 06, 2012)

* Improvements to `.htaccess`.
* Improve 404 design.
* Simplify JS folder structure.
* Change `html` IE class names changed to target ranges rather than specific versions of IE.
* Update CSS to include latest normalize.css changes and better typographic defaults ([#825](https://github.com/h5bp/html5-boilerplate/issues/825)).
* Update to Modernizr 2.5 (includes yepnope 1.5 and html5shiv 3.2).
* Update to jQuery 1.7.1.
* Revert to async snippet for the Google Analytics script.
* Remove the ant build script ([#826](https://github.com/h5bp/html5-boilerplate/issues/826)).
* Remove Respond.js ([#816](https://github.com/h5bp/html5-boilerplate/issues/816)).
* Remove the `demo/` directory ([#808](https://github.com/h5bp/html5-boilerplate/issues/808)).
* Remove the `test/` directory ([#808](https://github.com/h5bp/html5-boilerplate/issues/808)).
* Remove Google Chrome Frame script for IE6 users; replace with links to Chrome Frame and options for alternative browsers.
* Remove `initial-scale=1` from the viewport `meta` ([#824](https://github.com/h5bp/html5-boilerplate/issues/824)).
* Remove `defer` from all scripts to avoid legacy IE bugs.
* Remove explicit Site Speed tracking for Google Analytics. It's now enabled by default.

### 2.0.0 (August 10, 2011)

* Change starting CSS to be based on normalize.css instead of reset.css ([#500](https://github.com/h5bp/html5-boilerplate/issues/500)).
* Add Respond.js media query polyfill.
* Add Google Chrome Frame script prompt for IE6 users.
* Simplify the `html` conditional comments for modern browsers and add an `oldie` class.
* Update clearfix to use "micro clearfix".
* Add placeholder CSS MQs for mobile-first approach.
* Add `textarea { resize: vertical; }` to only allow vertical resizing.
* Add `img { max-width: 100%; }` to the print styles; prevents images being truncated.
* Add Site Speed tracking for Google Analytics.
* Update to jQuery 1.6.2 (and use minified by default).
* Update to Modernizr 2.0 Complete, Production minified (includes yepnope, html5shiv, and Respond.js).
* Use `Modernizr.load()` to load the Google Analytics script.
* Much faster build process.
* Add build script options for CSSLint, JSLint, JSHint tools.
* Build script now compresses all images in subfolders.
* Build script now versions files by SHA hash.
* Many `.htaccess` improvements including: disable directory browsing, improved support for all versions of Apache, more robust and extensive HTTP compression rules.
* Remove `handheld.css` as it has very poor device support.
* Remove touch-icon `link` elements from the HTML and include improved touch-icon support.
* Remove the cache-busting query paramaters from files references in the HTML.
* Remove IE6 PNGFix.

### 1.0.0 (March 21, 2011)

* Rewrite build script to make it more customizable and flexible.
* Add a humans.txt.
* Numerous `.htaccess` improvements (including inline documentation).
* Move the alternative server configurations to the H5BP server configs repo.
* Use a protocol-relative url to reference jQuery and prevent mixed content warnings.
* Optimize the Google Analytics snippet.
* Use Eric Meyer's recent CSS reset update and the HTML5 Doctor reset.
* More robust `sub`/`sup` CSS styles.
* Add keyboard `.focusable` helper class that extends `.visuallyhidden`.
* Print styles no longer print hash or JavaScript links.
* Add a print reset for IE's proprietary filters.
* Remove IE9-specific conditional class on the `html` element.
* Remove margins from lists within `nav` elements.
* Remove YUI profiling.

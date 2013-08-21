### HEAD
* Updated:
  - Apache Server Configs (1.1.0)
  - Google Universal Analytics ([#1347](https://github.com/h5bp/html5-boilerplate/issues/1347))
  - `jQuery` (1.10.2)
  - `Normalize.css` (1.1.2)
* Vertical centering for `audio`, `canvas`, and `video` tags ([#1326](https://github.com/h5bp/html5-boilerplate/issues/1326))



### 4.2.0 (April 8, 2013)

* Remove Google Analytics protocol check ([#1319](https://github.com/h5bp/html5-boilerplate/pull/1319))
* Use a protocol-relative URL for the 404 template script
* Updated:
  - `Normalize.css` (1.1.1)
  - `jQuery` (1.9.1)
  - the canonical [`.htaccess`](https://github.com/h5bp/server-configs-apache) Apache configuration now includes the latest changes

### 4.1.0 (January 21, 2013)

* Updated:
  - `Normalize.css` (1.1.0)
  - `jQuery` (1.9.0)

### 4.0.3 (January 12, 2013)

* Use 32×32 `favicon.ico` ([#1286](https://github.com/h5bp/html5-boilerplate/pull/1286))
* Adjust CSS image-replacement code ([#1239](https://github.com/h5bp/html5-boilerplate/issues/1239))
* Remove named function expression in `plugins.js` ([#1280](https://github.com/h5bp/html5-boilerplate/pull/1280))
* Updated:
  - HiDPI example media query ([#1127](https://github.com/h5bp/html5-boilerplate/issues/1127))

### 4.0.2 (December 9, 2012)

* Updated:
  - placeholder icons
  - `Normalize.css` (1.0.2)
  - `jQuery` (1.8.3)

### 4.0.1 (October 20, 2012)

* Updated:
  - `jQuery` (1.8.2)
  - `Modernizr` (2.6.2)
* Minor additions to the documentation
* Further improvements to `console` method stubbing ([#1206](https://github.com/h5bp/html5-boilerplate/issues/1206), [#1229](https://github.com/h5bp/html5-boilerplate/pull/1229))

### 4.0.0 (August 28, 2012)

* Added:
  - A HiDPI example media query ([#1127](https://github.com/h5bp/html5-boilerplate/issues/1127))
  - Bundled docs ([#1154](https://github.com/h5bp/html5-boilerplate/issues/1154))
  - An MIT license ([#1139](https://github.com/h5bp/html5-boilerplate/issues/1139))
* Improved:
  - Apache compression configuration ([#1012](https://github.com/h5bp/html5-boilerplate/issues/1012), [#1173](https://github.com/h5bp/html5-boilerplate/issues/1173))
  - `console.log` protection ([#1107](https://github.com/h5bp/html5-boilerplate/issues/1107))
* Updated:
  - `Normalize.css` (1.0.1)
  - `jQuery` (1.8) ([#1161](https://github.com/h5bp/html5-boilerplate/issues/1161))
  - `Modernizr` (2.6.1) ([#1086](https://github.com/h5bp/html5-boilerplate/issues/1086))
  - Code format and consistency ([#1112](https://github.com/h5bp/html5-boilerplate/issues/1112))
* Removed:
  - uncompressed `jQuery` ([#1153](https://github.com/h5bp/html5-boilerplate/issues/1153))
  - superfluous inline comments ([#1150](https://github.com/h5bp/html5-boilerplate/issues/1150))
* Change image replacement technique ([#1149](https://github.com/h5bp/html5-boilerplate/issues/1149))
* Replace hot pink text selection color with a neutral color
* Renamed CSS files and rename JS files and subdirectories
* Separated `Normalize.css` from the rest of the CSS ([#1160](https://github.com/h5bp/html5-boilerplate/issues/1160))

### 3.0.2 (February 19, 2012)

* Updated `Modernizr` (2.5.3)

### 3.0.1 (February 08, 2012)

* Updated `Modernizr` (2.5.2) (includes `html5shiv` 3.3)

### 3.0.0 (February 06, 2012)

* Improved:
  - `.htaccess`
  -  404 design
* Updated:
  - CSS now includes latest `normalize.css` changes (and better typographic defaults) ([#825](https://github.com/h5bp/html5-boilerplate/issues/825))
  - `Modernizr` (2.5) (includes `yepnope` 1.5 and `html5shiv` 3.2)
  - `jQuery` (1.7.1)
* Removed:
  - the ant build script ([#826](https://github.com/h5bp/html5-boilerplate/issues/826))
  - `Respond.js` ([#816](https://github.com/h5bp/html5-boilerplate/issues/816))
  - the `demo/` directory ([#808](https://github.com/h5bp/html5-boilerplate/issues/808))
  - the `test/` directory ([#808](https://github.com/h5bp/html5-boilerplate/issues/808))
  - Google Chrome Frame script for IE6 users; replace with links to Chrome Frame and options for alternative browsers
  - `initial-scale=1` from the viewport `meta` ([#824](https://github.com/h5bp/html5-boilerplate/issues/824))
  - `defer` from all `script`s to avoid legacy IE bugs
  - Explicit Site Speed tracking for Google Analytics (it's now enabled by default)
* Revert to async snippet for the Google Analytics script
* Simplify JS folder structure
* Change `html` IE class names changed to target ranges rather than specific versions of IE

### 2.0.0 (August 10, 2011)

* Added:
  - `Respond.js` media query polyfill
  - Google Chrome Frame script prompt for IE6 users
  - placeholder CSS MQs for mobile-first approach
  - `textarea { resize: vertical; }` to only allow vertical resizing
  - `img { max-width: 100%; }` to the print styles; prevents images being truncated
  - Site Speed tracking for Google Analytics
* Updated:
  - `jQuery` (1.6.2) (and use minified by default)
  - `Modernizr` (2.0) (Complete, Production minified; includes `yepnope`, `html5shiv`, and `Respond.js`)
* Removed:
  - `handheld.css` (as it has very poor device support)
  - touch-icon `link` elements from HTML (and include improved touch-icon support)
  - cache-busting query paramaters from files references in the HTML
  - IE6 PNGFix
* Build script improvements:
  - Much faster!
  - Added build options for `CSSLint`, `JSLint`, and `JSHint` tools
  - Now compresses all images in subfolders
  - Now versions files by SHA hash
* Change `clearfix` to use "micro clearfix"
* Change starting CSS to be based on `normalize.css` instead of `reset.css` ([#500](https://github.com/h5bp/html5-boilerplate/issues/500))
* Simplify `html` conditional comments for modern browsers and add an `oldie` class
* Use `Modernizr.load()` to load the Google Analytics script
* Many `.htaccess` improvements including: disable directory browsing, improved support for all versions of Apache, more robust and extensive HTTP compression rules


### 1.0.0 (March 21, 2011)

* Added:
  - keyboard `.focusable` helper class (which extends `.visuallyhidden`)
  - `humans.txt`
  - print reset for IE's proprietary filters
* Removed:
  - IE9-specific conditional class on the `html` element
  - margins from lists within `nav` elements
  - YUI profiling
* CSS stuff:
  - Use Eric Meyer's recent CSS reset update and the HTML5 Doctor reset
  - More robust `sub`/`sup` CSS styles
  - Print styles no longer print hash or JavaScript links 
* Server stuff:
  - Numerous `.htaccess` improvements (including inline documentation)
  - Moved alternative server configurations to the H5BP server configs repo
* Rewrite build script to make it more customizable and flexible
* Use a protocol-relative URL to reference `jQuery` and prevent mixed-content warnings
* Optimize the Google Analytics snippet



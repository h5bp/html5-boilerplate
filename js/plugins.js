/**
* @preserve Plugins
*/
(
/** 
* Redefining "window" and "document" allows Google Closure 
* Compiler to use single-character names for those 
* variables. It also speeds lookups to those objects in most
* browsers by localizing them to our closure.
* @param {jQuery}  $ The jQuery object
* @param {Window}  window The window
* @param {Document}  document The document
* @param {undefined=} undefined Makes sure undefined is undefined (optional)
*/
function ($, window, document, undefined) {

    /*  plugins */













    /** 
    * Usage: log('Inside coolFunc', this, arguments);
    * http://paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
    * @param {...*} _args
    */
    var log = function (_args) {
        log.history.push(arguments);
        if (window.console) {
            console.log(Array.prototype.slice.call(arguments));
        }
    };
    log.history = [];

    /**
    * Closure around our new document.write()
    * @param {function(*, ...[*])} write Native document.write
    */
    document.write = (function (write) {
        var rwhiteList = /docwriteregexwhitelist/;
        /**
        * Catch all document.write() calls
        * @param {...*} q The objects(s) being written
        */
        return function (q) {
            log("document.write(): ", arguments);
            if (rwhiteList.test(q)) {
                write.apply(document, arguments);
            }
        };
    } (document.write));

    // Expose log globally.
    window.log = log;

} (jQuery, window, document));
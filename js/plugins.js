
// remap jQuery to $
(function($){

 





 



})(window.jQuery);



// usage: log('inside coolFunc',this,arguments);
// http://paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  if(this.console){
    console.log( Array.prototype.slice.call(arguments) );
  }
};



// catch all document.write() calls
(function(){
  var docwrite = document.write;
  document.write = function(q){ 
    log('document.write(): ',q); 
    if (/docwriteregexwhitelist/.test(q)) docwrite(q);  
  }
})();


// background image cache bug for ie6.  via: http://www.mister-pixel.com/#Content__state=
/*@cc_on   @if (@_win32) { document.execCommand("BackgroundImageCache",false,true) }   @end @*/


/* Author: 

*/

if(window['debug'] === undefined) {
  window.debug = function(q,w,e,r){  
    try { if (typeof console != 'undefined') console.log.apply(console,arguments); } 
    catch(err){ if (typeof console != 'undefined')  console.log(q,w,e,r); }
  }
}

// catch all document.write() calls
document._write = document.write;
document.write = function(q){ 
  if (q.match(/docwriteregextopassthrough/)) document._write(q);  
  debug('document.write(): ',q); 
}






   

// background image cache bug for ie6.  via: http://www.mister-pixel.com/#Content__state=
/*@cc_on   @if (@_win32) { document.execCommand("BackgroundImageCache",false,true) }   @end @*/


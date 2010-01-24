/* Author: Molecular, Inc. 
   www.molecular.com 
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



/*
  Object: FOO
  Object literal to hold code
*/
window.FOO = {

  config : {
    slideDuration     : 700,
    fadeDuration      : 300,
    collapseDuration  : 500
  },
  
  strings : {
    
  },
  
  // common domrady code
  common : function(){
    
    $.browser.ie6 = ($.browser.msie && jQuery.browser.version < 7);
    
    
    
    if (!!document.location.search.match(/fbug=true/) ){
        $.getScript('http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js',function(){ firebug.init(); });
    } 
    
    // catch ajax errors
    $(document).ajaxError(function(){ debug('ajax error:',arguments); });
    
    
  }, // end of FOO.common()
  
  
  

  // pngfix for IE6
  // e.g. FOO.pngfix('img.bigProdShot,a.thumb');
  pngfix : function(sel){
    // conditional comments for inclusion of that js.
    if (typeof DD_belatedPNG == 'undefined'){  return; 
    } else {
      // delay pngfix until window onload
      $(window).load(function(){ $(sel).each(function(){ DD_belatedPNG.fixPng(arguments[1]); }); }); 
    }
  } // end of FOO.pngfix()
  
  
  
}

// kick off document ready
// this is a lo-fi version of this: http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
$(document).ready(FOO.common);






/*
   Function: setCookie
   Sets a cookie for the given domain
*/
function setCookie(name,value,expires,path) {
    var cookieString = name + "=" +escape(value) +
       ( (expires) ? ";expires=" + expires.toGMTString() : "") +
       ( (path) ? ";path=" + path : "");
    document.cookie = cookieString;
}
   
   

// background image cache bug for ie6.  via: http://www.mister-pixel.com/#Content__state=
/*@cc_on   @if (@_win32) { document.execCommand("BackgroundImageCache",false,true) }   @end @*/


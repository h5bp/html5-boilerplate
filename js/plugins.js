
// remap jQuery to $
(function($){

 





 



})(this.jQuery);



// this just makes sure leaving any console statements won't break your site
(function () {
    var noOp = function () {},
        methods = [
            'log',
            'warn',
            'count',
            'debug',
            'profile',
            'profileEnd',
            'trace',
            'dir',
            'dirxml',
            'assert',
            'time',
            'profile',
            'timeEnd',
            'group',
            'groupEnd'
        ],
        i = methods.length;
    if (!this.console) this.console = {};
    while (i--) {
        if (this.console[methods[i]] === undefined) this.console[methods[i]] = noOp;
    }
})();


// catch all document.write() calls
(function(doc){
  var write = doc.write;
  doc.write = function(q){ 
    console.log('document.write(): ',arguments); 
    if (/docwriteregexwhitelist/.test(q)) write.apply(doc,arguments);  
  };
})(document);



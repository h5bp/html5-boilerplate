// Avoid `console` errors in browsers that lack a console.
;
(function ($, window, document, undefined) {
 
    var defaults = {
        color: "red" //rename your option
    };
 
    function Plugin(element, options) {
 
        this.el = element;

        this.pluginName;
        
        this.options = $.extend({}, defaults, options);
        
        this.init();
        
        return this;
    }
 
    Plugin.prototype.init = function () {
        $(this.el).css('color', this.options.color);//setting up your option
    };
 
    $.fn.pluginName = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_')) {
                $.data(this, 'plugin_', new Plugin(this, options));
            }
        });
    };
 
})(jQuery, window, document);



// Place any jQuery/helper plugins in here.

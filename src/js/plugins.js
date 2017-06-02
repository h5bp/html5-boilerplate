// Avoid `console` errors in browsers that lack a console.
(function () {
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'profile', 'profileEnd', 'table', 'time', 'timeEnd', 'timeStamp',
        'trace', 'warn'
    ];
    console = window.console = window.console || {};
    methods.forEach(function (method) {
        if (!console[method]) {
            console[method] = function () {};
        }
    });
}());

// Place any jQuery/helper plugins in here.

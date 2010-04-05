/*
 * QUnit - jQuery unit testrunner
 * 
 * http://docs.jquery.com/QUnit
 *
 * Copyright (c) 2008 John Resig, Jörn Zaefferer
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * $Id: testrunner.js 6173 2009-02-02 20:09:32Z jeresig $
 */

(function($) {

// Tests for equality any JavaScript type and structure without unexpected results.
// Discussions and reference: http://philrathe.com/articles/equiv
// Test suites: http://philrathe.com/tests/equiv
// Author: Philippe Rathé <prathe@gmail.com>
var equiv = function () {

    var innerEquiv; // the real equiv function
    var callers = []; // stack to decide between skip/abort functions

    // Determine what is o.
    function hoozit(o) {
        if (typeof o === "string") {
            return "string";

        } else if (typeof o === "boolean") {
            return "boolean";

        } else if (typeof o === "number") {

            if (isNaN(o)) {
                return "nan";
            } else {
                return "number";
            }

        } else if (typeof o === "undefined") {
            return "undefined";

        // consider: typeof null === object
        } else if (o === null) {
            return "null";

        // consider: typeof [] === object
        } else if (o instanceof Array) {
            return "array";
        
        // consider: typeof new Date() === object
        } else if (o instanceof Date) {
            return "date";

        // consider: /./ instanceof Object;
        //           /./ instanceof RegExp;
        //          typeof /./ === "function"; // => false in IE and Opera,
        //                                          true in FF and Safari
        } else if (o instanceof RegExp) {
            return "regexp";

        } else if (typeof o === "object") {
            return "object";

        } else if (o instanceof Function) {
            return "function";
        }
    }

    // Call the o related callback with the given arguments.
    function bindCallbacks(o, callbacks, args) {
        var prop = hoozit(o);
        if (prop) {
            if (hoozit(callbacks[prop]) === "function") {
                return callbacks[prop].apply(callbacks, args);
            } else {
                return callbacks[prop]; // or undefined
            }
        }
    }

    var callbacks = function () {

        // for string, boolean, number and null
        function useStrictEquality(b, a) {
            return a === b;
        }

        return {
            "string": useStrictEquality,
            "boolean": useStrictEquality,
            "number": useStrictEquality,
            "null": useStrictEquality,
            "undefined": useStrictEquality,

            "nan": function (b) {
                return isNaN(b);
            },

            "date": function (b, a) {
                return hoozit(b) === "date" && a.valueOf() === b.valueOf();
            },

            "regexp": function (b, a) {
                return hoozit(b) === "regexp" &&
                    a.source === b.source && // the regex itself
                    a.global === b.global && // and its modifers (gmi) ...
                    a.ignoreCase === b.ignoreCase &&
                    a.multiline === b.multiline;
            },

            // - skip when the property is a method of an instance (OOP)
            // - abort otherwise,
            //   initial === would have catch identical references anyway
            "function": function () {
                var caller = callers[callers.length - 1];
                return caller !== Object &&
                        typeof caller !== "undefined";
            },

            "array": function (b, a) {
                var i;
                var len;

                // b could be an object literal here
                if ( ! (hoozit(b) === "array")) {
                    return false;
                }

                len = a.length;
                if (len !== b.length) { // safe and faster
                    return false;
                }
                for (i = 0; i < len; i++) {
                    if( ! innerEquiv(a[i], b[i])) {
                        return false;
                    }
                }
                return true;
            },

            "object": function (b, a) {
                var i;
                var eq = true; // unless we can proove it
                var aProperties = [], bProperties = []; // collection of strings

                // comparing constructors is more strict than using instanceof
                if ( a.constructor !== b.constructor) {
                    return false;
                }

                // stack constructor before traversing properties
                callers.push(a.constructor);

                for (i in a) { // be strict: don't ensures hasOwnProperty and go deep

                    aProperties.push(i); // collect a's properties

                    if ( ! innerEquiv(a[i], b[i])) {
                        eq = false;
                    }
                }

                callers.pop(); // unstack, we are done

                for (i in b) {
                    bProperties.push(i); // collect b's properties
                }

                // Ensures identical properties name
                return eq && innerEquiv(aProperties.sort(), bProperties.sort());
            }
        };
    }();

    innerEquiv = function () { // can take multiple arguments
        var args = Array.prototype.slice.apply(arguments);
        if (args.length < 2) {
            return true; // end transition
        }

        return (function (a, b) {
            if (a === b) {
                return true; // catch the most you can

            } else if (typeof a !== typeof b || a === null || b === null || typeof a === "undefined" || typeof b === "undefined") {
                return false; // don't lose time with error prone cases

            } else {
                return bindCallbacks(a, callbacks, [b, a]);
            }

        // apply transition with (1..n) arguments
        })(args[0], args[1]) && arguments.callee.apply(this, args.splice(1, args.length -1));
    };

    return innerEquiv;
}(); // equiv

var GETParams = $.map( location.search.slice(1).split('&'), decodeURIComponent ),
	ngindex = $.inArray("noglobals", GETParams),
	noglobals = ngindex !== -1;

if( noglobals )
	GETParams.splice( ngindex, 1 );
	
var config = {
	stats: {
		all: 0,
		bad: 0
	},
	queue: [],
	// block until document ready
	blocking: true,
	//restrict modules/tests by get parameters
	filters: GETParams,
	isLocal: !!(window.location.protocol == 'file:')
};

// public API as global methods
$.extend(window, {
	test: test,
	module: module,
	expect: expect,
	ok: ok,
	equals: equals,
	start: start,
	stop: stop,
	reset: reset,
	isLocal: config.isLocal,
	same: function(a, b, message) {
		push(equiv(a, b), a, b, message);
	},
	QUnit: {
		equiv: equiv,
		ok: ok,
		done: function(failures, total){},
		log: function(result, message){}
	},
	// legacy methods below
	isSet: isSet,
	isObj: isObj,
	compare: function() {
		throw "compare is deprecated - use same() instead";
	},
	compare2: function() {
		throw "compare2 is deprecated - use same() instead";
	},
	serialArray: function() {
		throw "serialArray is deprecated - use jsDump.parse() instead";
	},
	q: q,
	t: t,
	url: url,
	triggerEvent: triggerEvent
});

$(window).load(function() {
	$('#userAgent').html(navigator.userAgent);
	var head = $('<div class="testrunner-toolbar"><label for="filter-pass">Hide passed tests</label></div>').insertAfter("#userAgent");
	$('<input type="checkbox" id="filter-pass" />').attr("disabled", true).prependTo(head).click(function() {
		$('li.pass')[this.checked ? 'hide' : 'show']();
	});
	$('<input type="checkbox" id="filter-missing">').attr("disabled", true).appendTo(head).click(function() {
		$("li.fail:contains('missing test - untested code is broken code')").parent('ol').parent('li.fail')[this.checked ? 'hide' : 'show']();
	});
	$("#filter-missing").after('<label for="filter-missing">Hide missing tests (untested code is broken code)</label>');
	runTest();	
});

function synchronize(callback) {
	config.queue.push(callback);
	if(!config.blocking) {
		process();
	}
}

function process() {
	while(config.queue.length && !config.blocking) {
		config.queue.shift()();
	}
}

function stop(timeout) {
	config.blocking = true;
	if (timeout)
		config.timeout = setTimeout(function() {
			QUnit.ok( false, "Test timed out" );
			start();
		}, timeout);
}
function start() {
	// A slight delay, to avoid any current callbacks
	setTimeout(function() {
		if(config.timeout)
			clearTimeout(config.timeout);
		config.blocking = false;
		process();
	}, 13);
}

function validTest( name ) {
	var i = config.filters.length,
		run = false;

	if( !i )
		return true;
	
	while( i-- ){
		var filter = config.filters[i],
			not = filter.charAt(0) == '!';
		if( not ) 
			filter = filter.slice(1);
		if( name.indexOf(filter) != -1 )
			return !not;
		if( not )
			run = true;
	}
	return run;
}

function runTest() {
	config.blocking = false;
	var started = +new Date;
	config.fixture = document.getElementById('main').innerHTML;
	config.ajaxSettings = $.ajaxSettings;
	synchronize(function() {
		$('<p id="testresult" class="result"/>').html(['Tests completed in ',
			+new Date - started, ' milliseconds.<br/>',
			'<span class="bad">', config.stats.bad, '</span> tests of <span class="all">', config.stats.all, '</span> failed.']
			.join(''))
			.appendTo("body");
		$("#banner").addClass(config.stats.bad ? "fail" : "pass");
		QUnit.done( config.stats.bad, config.stats.all );
	});
}

var pollution;

function saveGlobal(){
	pollution = [ ];
	
	if( noglobals )
		for( var key in window )
			pollution.push(key);
}
function checkPollution( name ){
	var old = pollution;
	saveGlobal();
	
	if( pollution.length > old.length ){
		ok( false, "Introduced global variable(s): " + diff(old, pollution).join(", ") );
		config.expected++;
	}
}

function diff( clean, dirty ){
	return $.grep( dirty, function(name){
		return $.inArray( name, clean ) == -1;
	});
}

function test(name, callback) {
	if(config.currentModule)
		name = config.currentModule + " module: " + name;
	var lifecycle = $.extend({
		setup: function() {},
		teardown: function() {}
	}, config.moduleLifecycle);
	
	if ( !validTest(name) )
		return;
	
	synchronize(function() {
		config.assertions = [];
		config.expected = null;
		try {
			if( !pollution )
				saveGlobal();
			lifecycle.setup();
		} catch(e) {
			QUnit.ok( false, "Setup failed on " + name + ": " + e.message );
		}
	})
	synchronize(function() {
		try {
			callback();
		} catch(e) {
			if( typeof console != "undefined" && console.error && console.warn ) {
				console.error("Test " + name + " died, exception and test follows");
				console.error(e);
				console.warn(callback.toString());
			}
			QUnit.ok( false, "Died on test #" + (config.assertions.length + 1) + ": " + e.message );
			// else next test will carry the responsibility
			saveGlobal();
		}
	});
	synchronize(function() {
		try {
			checkPollution();
			lifecycle.teardown();
		} catch(e) {
			QUnit.ok( false, "Teardown failed on " + name + ": " + e.message );
		}
	})
	synchronize(function() {
		try {
			reset();
		} catch(e) {
			if( typeof console != "undefined" && console.error && console.warn ) {
				console.error("reset() failed, following Test " + name + ", exception and reset fn follows");
				console.error(e);
				console.warn(reset.toString());
			}
		}
		
		if(config.expected && config.expected != config.assertions.length) {
			QUnit.ok( false, "Expected " + config.expected + " assertions, but " + config.assertions.length + " were run" );
		}
		
		var good = 0, bad = 0;
		var ol  = $("<ol/>").hide();
		config.stats.all += config.assertions.length;
		for ( var i = 0; i < config.assertions.length; i++ ) {
			var assertion = config.assertions[i];
			$("<li/>").addClass(assertion.result ? "pass" : "fail").text(assertion.message || "(no message)").appendTo(ol);
			assertion.result ? good++ : bad++;
		}
		config.stats.bad += bad;
	
		var b = $("<strong/>").html(name + " <b style='color:black;'>(<b class='fail'>" + bad + "</b>, <b class='pass'>" + good + "</b>, " + config.assertions.length + ")</b>")
		.click(function(){
			$(this).next().toggle();
		})
		.dblclick(function(event) {
			var target = $(event.target).filter("strong").clone();
			if ( target.length ) {
				target.children().remove();
				location.href = location.href.match(/^(.+?)(\?.*)?$/)[1] + "?" + encodeURIComponent($.trim(target.text()));
			}
		});
		
		$("<li/>").addClass(bad ? "fail" : "pass").append(b).append(ol).appendTo("#tests");
	
		if(bad) {
			$("#filter-pass").attr("disabled", null);
			$("#filter-missing").attr("disabled", null);
		}
	});
}

// call on start of module test to prepend name to all tests
function module(name, lifecycle) {
	config.currentModule = name;
	config.moduleLifecycle = lifecycle;
}

/**
 * Specify the number of expected assertions to gurantee that failed test (no assertions are run at all) don't slip through.
 */
function expect(asserts) {
	config.expected = asserts;
}

/**
 * Resets the test setup. Useful for tests that modify the DOM.
 */
function reset() {
	$("#main").html( config.fixture );
	$.event.global = {};
	$.ajaxSettings = $.extend({}, config.ajaxSettings);
}

/**
 * Asserts true.
 * @example ok( $("a").size() > 5, "There must be at least 5 anchors" );
 */
function ok(a, msg) {
	QUnit.log(a, msg);

	config.assertions.push({
		result: !!a,
		message: msg
	});
}

/**
 * Asserts that two arrays are the same
 */
function isSet(a, b, msg) {
	function serialArray( a ) {
		var r = [];
		
		if ( a && a.length )
	        for ( var i = 0; i < a.length; i++ ) {
	            var str = a[i].nodeName;
	            if ( str ) {
	                str = str.toLowerCase();
	                if ( a[i].id )
	                    str += "#" + a[i].id;
	            } else
	                str = a[i];
	            r.push( str );
	        }
	
		return "[ " + r.join(", ") + " ]";
	}
	var ret = true;
	if ( a && b && a.length != undefined && a.length == b.length ) {
		for ( var i = 0; i < a.length; i++ )
			if ( a[i] != b[i] )
				ret = false;
	} else
		ret = false;
	QUnit.ok( ret, !ret ? (msg + " expected: " + serialArray(b) + " result: " + serialArray(a)) : msg );
}

/**
 * Asserts that two objects are equivalent
 */
function isObj(a, b, msg) {
	var ret = true;
	
	if ( a && b ) {
		for ( var i in a )
			if ( a[i] != b[i] )
				ret = false;

		for ( i in b )
			if ( a[i] != b[i] )
				ret = false;
	} else
		ret = false;

    QUnit.ok( ret, msg );
}

/**
 * Returns an array of elements with the given IDs, eg.
 * @example q("main", "foo", "bar")
 * @result [<div id="main">, <span id="foo">, <input id="bar">]
 */
function q() {
	var r = [];
	for ( var i = 0; i < arguments.length; i++ )
		r.push( document.getElementById( arguments[i] ) );
	return r;
}

/**
 * Asserts that a select matches the given IDs
 * @example t("Check for something", "//[a]", ["foo", "baar"]);
 * @result returns true if "//[a]" return two elements with the IDs 'foo' and 'baar'
 */
function t(a,b,c) {
	var f = $(b);
	var s = "";
	for ( var i = 0; i < f.length; i++ )
		s += (s && ",") + '"' + f[i].id + '"';
	isSet(f, q.apply(q,c), a + " (" + b + ")");
}

/**
 * Add random number to url to stop IE from caching
 *
 * @example url("data/test.html")
 * @result "data/test.html?10538358428943"
 *
 * @example url("data/test.php?foo=bar")
 * @result "data/test.php?foo=bar&10538358345554"
 */
function url(value) {
	return value + (/\?/.test(value) ? "&" : "?") + new Date().getTime() + "" + parseInt(Math.random()*100000);
}

/**
 * Checks that the first two arguments are equal, with an optional message.
 * Prints out both actual and expected values.
 *
 * Prefered to ok( actual == expected, message )
 *
 * @example equals( $.format("Received {0} bytes.", 2), "Received 2 bytes." );
 *
 * @param Object actual
 * @param Object expected
 * @param String message (optional)
 */
function equals(actual, expected, message) {
	push(expected == actual, actual, expected, message);
}

function push(result, actual, expected, message) {
	message = message || (result ? "okay" : "failed");
	QUnit.ok( result, result ? message + ": " + expected : message + ", expected: " + jsDump.parse(expected) + " result: " + jsDump.parse(actual) );
}

/**
 * Trigger an event on an element.
 *
 * @example triggerEvent( document.body, "click" );
 *
 * @param DOMElement elem
 * @param String type
 */
function triggerEvent( elem, type, event ) {
	if ( $.browser.mozilla || $.browser.opera ) {
		event = document.createEvent("MouseEvents");
		event.initMouseEvent(type, true, true, elem.ownerDocument.defaultView,
			0, 0, 0, 0, 0, false, false, false, false, 0, null);
		elem.dispatchEvent( event );
	} else if ( $.browser.msie ) {
		elem.fireEvent("on"+type);
	}
}

})(jQuery);

/**
 * jsDump
 * Copyright (c) 2008 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Licensed under BSD (http://www.opensource.org/licenses/bsd-license.php)
 * Date: 5/15/2008
 * @projectDescription Advanced and extensible data dumping for Javascript.
 * @version 1.0.0
 * @author Ariel Flesler
 * @link {http://flesler.blogspot.com/2008/05/jsdump-pretty-dump-of-any-javascript.html}
 */
(function(){
	function quote( str ){
		return '"' + str.toString().replace(/"/g, '\\"') + '"';
	};
	function literal( o ){
		return o + '';	
	};
	function join( pre, arr, post ){
		var s = jsDump.separator(),
			base = jsDump.indent();
			inner = jsDump.indent(1);
		if( arr.join )
			arr = arr.join( ',' + s + inner );
		if( !arr )
			return pre + post;
		return [ pre, inner + arr, base + post ].join(s);
	};
	function array( arr ){
		var i = arr.length,	ret = Array(i);					
		this.up();
		while( i-- )
			ret[i] = this.parse( arr[i] );				
		this.down();
		return join( '[', ret, ']' );
	};
	
	var reName = /^function (\w+)/;
	
	var jsDump = window.jsDump = {
		parse:function( obj, type ){//type is used mostly internally, you can fix a (custom)type in advance
			var	parser = this.parsers[ type || this.typeOf(obj) ];
			type = typeof parser;			
			
			return type == 'function' ? parser.call( this, obj ) :
				   type == 'string' ? parser :
				   this.parsers.error;
		},
		typeOf:function( obj ){
			var type = typeof obj,
				f = 'function';//we'll use it 3 times, save it
			return type != 'object' && type != f ? type :
				!obj ? 'null' :
				obj.exec ? 'regexp' :// some browsers (FF) consider regexps functions
				obj.getHours ? 'date' :
				obj.scrollBy ?  'window' :
				obj.nodeName == '#document' ? 'document' :
				obj.nodeName ? 'node' :
				obj.item ? 'nodelist' : // Safari reports nodelists as functions
				obj.callee ? 'arguments' :
				obj.call || obj.constructor != Array && //an array would also fall on this hack
					(obj+'').indexOf(f) != -1 ? f : //IE reports functions like alert, as objects
				'length' in obj ? 'array' :
				type;
		},
		separator:function(){
			return this.multiline ?	this.HTML ? '<br />' : '\n' : this.HTML ? '&nbsp;' : ' ';
		},
		indent:function( extra ){// extra can be a number, shortcut for increasing-calling-decreasing
			if( !this.multiline )
				return '';
			var chr = this.indentChar;
			if( this.HTML )
				chr = chr.replace(/\t/g,'   ').replace(/ /g,'&nbsp;');
			return Array( this._depth_ + (extra||0) ).join(chr);
		},
		up:function( a ){
			this._depth_ += a || 1;
		},
		down:function( a ){
			this._depth_ -= a || 1;
		},
		setParser:function( name, parser ){
			this.parsers[name] = parser;
		},
		// The next 3 are exposed so you can use them
		quote:quote, 
		literal:literal,
		join:join,
		//
		_depth_: 1,
		// This is the list of parsers, to modify them, use jsDump.setParser
		parsers:{
			window: '[Window]',
			document: '[Document]',
			error:'[ERROR]', //when no parser is found, shouldn't happen
			unknown: '[Unknown]',
			'null':'null',
			undefined:'undefined',
			'function':function( fn ){
				var ret = 'function',
					name = 'name' in fn ? fn.name : (reName.exec(fn)||[])[1];//functions never have name in IE
				if( name )
					ret += ' ' + name;
				ret += '(';
				
				ret = [ ret, this.parse( fn, 'functionArgs' ), '){'].join('');
				return join( ret, this.parse(fn,'functionCode'), '}' );
			},
			array: array,
			nodelist: array,
			arguments: array,
			object:function( map ){
				var ret = [ ];
				this.up();
				for( var key in map )
					ret.push( this.parse(key,'key') + ': ' + this.parse(map[key]) );
				this.down();
				return join( '{', ret, '}' );
			},
			node:function( node ){
				var open = this.HTML ? '&lt;' : '<',
					close = this.HTML ? '&gt;' : '>';
					
				var tag = node.nodeName.toLowerCase(),
					ret = open + tag;
					
				for( var a in this.DOMAttrs ){
					var val = node[this.DOMAttrs[a]];
					if( val )
						ret += ' ' + a + '=' + this.parse( val, 'attribute' );
				}
				return ret + close + open + '/' + tag + close;
			},
			functionArgs:function( fn ){//function calls it internally, it's the arguments part of the function
				var l = fn.length;
				if( !l ) return '';				
				
				var args = Array(l);
				while( l-- )
					args[l] = String.fromCharCode(97+l);//97 is 'a'
				return ' ' + args.join(', ') + ' ';
			},
			key:quote, //object calls it internally, the key part of an item in a map
			functionCode:'[code]', //function calls it internally, it's the content of the function
			attribute:quote, //node calls it internally, it's an html attribute value
			string:quote,
			date:quote,
			regexp:literal, //regex
			number:literal,
			'boolean':literal
		},
		DOMAttrs:{//attributes to dump from nodes, name=>realName
			id:'id',
			name:'name',
			'class':'className'
		},
		HTML:false,//if true, entities are escaped ( <, >, \t, space and \n )
		indentChar:'   ',//indentation unit
		multiline:true //if true, items in a collection, are separated by a \n, else just a space.
	};

})();



//fireunit compat
// http://ejohn.org/blog/fireunit/
if ( typeof fireunit === "object" ) {
        QUnit.log = fireunit.ok;
        QUnit.done = fireunit.testDone;
}


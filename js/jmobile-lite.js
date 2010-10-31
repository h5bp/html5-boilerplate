/*!
 * Autogrowing Textareas
 * http://www.blog.highub.com/
 * by Shi Chuan
 */

(function( $ ){

  $.fn.growingTextarea = function() {
    return this.each(function() {
		var $this = $(this);
		var TEXTAREA_LINE_HEIGHT = 13;
		$this.keyup(function(e){
			var newHeight = $this.attr("scrollHeight");
			var currentHeight = $this.attr("clientHeight");
			if (newHeight > currentHeight) {
				$this.css('height', newHeight + 2 * TEXTAREA_LINE_HEIGHT + 'px');
			}
		});
    });

  };
})( jQuery );


/*!
 * jQuery Mobile
 * http://jquerymobile.com/
 *
 * Copyright 2010, jQuery Project
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 */
// test whether a CSS media type or query applies
$.media = (function() {
	// TODO: use window.matchMedia once at least one UA implements it
	var cache = {},
		$html = $( "html" ),
		testDiv = $( "<div id='jquery-mediatest'>" ),
		fakeBody = $( "<body>" ).append( testDiv );
	
	return function( query ) {
		if ( !( query in cache ) ) {
			var styleBlock = $( "<style type='text/css'>" +
				"@media " + query + "{#jquery-mediatest{position:absolute;}}" +
				"</style>" );
			$html.prepend( fakeBody ).prepend( styleBlock );
			cache[ query ] = testDiv.css( "position" ) === "absolute";
			fakeBody.add( styleBlock ).remove();
		}
		return cache[ query ];
	};
})();

var fakeBody = $( "<body>" ).prependTo( "html" ),
	fbCSS = fakeBody[0].style,
	vendors = ['webkit','moz','o'],
	webos = window.palmGetResource || window.PalmServiceBridge, //only used to rule out scrollTop 
	bb = window.blackberry; //only used to rule out box shadow, as it's filled opaque on BB

//thx Modernizr
function propExists( prop ){
	var uc_prop = prop.charAt(0).toUpperCase() + prop.substr(1),
		props   = (prop + ' ' + vendors.join(uc_prop + ' ') + uc_prop).split(' ');
	for(var v in props){
		if( fbCSS[ v ] !== undefined ){
			return true;
		}
	}
};

$.extend( $.support, {
	orientation: "orientation" in window,
	touch: "ontouchend" in document,
	WebKitAnimationEvent: typeof WebKitTransitionEvent === "object",
	pushState: !!history.pushState,
	mediaquery: $.media('only all'),
	cssPseudoElement: !!propExists('content'),
	boxShadow: !!propExists('boxShadow') && !bb,
	scrollTop: ("pageXOffset" in window || "scrollTop" in document.documentElement || "scrollTop" in fakeBody[0]) && !webos
});

fakeBody.remove();

$.each( "touchstart touchmove touchend orientationchange tap taphold swipe swipeleft swiperight scrollstart scrollstop".split( " " ), function( i, name ) {
	$.fn[ name ] = function( fn ) {
		return fn ? this.bind( name, fn ) : this.trigger( name );
	};
	$.attrFn[ name ] = true;
});

var supportTouch = $.support.touch,
	scrollEvent = "touchmove scroll",
	touchStartEvent = supportTouch ? "touchstart" : "mousedown",
	touchStopEvent = supportTouch ? "touchend" : "mouseup",
	touchMoveEvent = supportTouch ? "touchmove" : "mousemove";

// also handles scrollstop
$.event.special.scrollstart = {
	enabled: true,
	
	setup: function() {
		var thisObject = this,
			$this = $( thisObject ),
			scrolling,
			timer;
		
		function trigger( event, state ) {
			scrolling = state;
			var originalType = event.type;
			event.type = scrolling ? "scrollstart" : "scrollstop";
			$.event.handle.call( thisObject, event );
			event.type = originalType;
		}
		
		// iPhone triggers scroll after a small delay; use touchmove instead
		$this.bind( scrollEvent, function( event ) {
			if ( !$.event.special.scrollstart.enabled ) {
				return;
			}
			
			if ( !scrolling ) {
				trigger( event, true );
			}
			
			clearTimeout( timer );
			timer = setTimeout(function() {
				trigger( event, false );
			}, 50 );
		});
	}
};

// also handles taphold
$.event.special.tap = {
	setup: function() {
		var thisObject = this,
			$this = $( thisObject );
		
		$this
			.bind( touchStartEvent, function( event ) {
				if ( event.which && event.which !== 1 ) {
					return;
				}
				
				var moved = false,
					touching = true,
					originalType,
					timer;
				
				function moveHandler() {
					moved = true;
				}
				
				timer = setTimeout(function() {
					if ( touching && !moved ) {
						originalType = event.type;
						event.type = "taphold";
						$.event.handle.call( thisObject, event );
						event.type = originalType;
					}
				}, 750 );
				
				$this
					.one( touchMoveEvent, moveHandler)
					.one( touchStopEvent, function( event ) {
						$this.unbind( touchMoveEvent, moveHandler );
						clearTimeout( timer );
						touching = false;
						
						if ( !moved ) {
							originalType = event.type;
							event.type = "tap";
							$.event.handle.call( thisObject, event );
							event.type = originalType;
						}
					});
			});
	}
};

// also handles swipeleft, swiperight
$.event.special.swipe = {
	setup: function() {
		var thisObject = this,
			$this = $( thisObject );
		
		$this
			.bind( touchStartEvent, function( event ) {
				var data = event.originalEvent.touches ?
						event.originalEvent.touches[ 0 ] :
						event,
					start = {
						time: (new Date).getTime(),
						coords: [ data.pageX, data.pageY ],
						origin: $( event.target )
					},
					stop;
				
				function moveHandler( event ) {
					if ( !start ) {
						return;
					}
					
					var data = event.originalEvent.touches ?
							event.originalEvent.touches[ 0 ] :
							event;
					stop = {
							time: (new Date).getTime(),
							coords: [ data.pageX, data.pageY ]
					};
					
					// prevent scrolling
					if ( Math.abs( start.coords[0] - stop.coords[0] ) > 10 ) {
						event.preventDefault();
					}
				}
				
				$this
					.bind( touchMoveEvent, moveHandler )
					.one( touchStopEvent, function( event ) {
						$this.unbind( touchMoveEvent, moveHandler );
						if ( start && stop ) {
							if ( stop.time - start.time < 1000 && 
									Math.abs( start.coords[0] - stop.coords[0]) > 30 &&
									Math.abs( start.coords[1] - stop.coords[1]) < 20 ) {
								start.origin
								.trigger( "swipe" )
								.trigger( start.coords[0] > stop.coords[0] ? "swipeleft" : "swiperight" );
							}
						}
						start = stop = undefined;
					});
			});
	}
};

$.event.special.orientationchange = {
	orientation: function( elem ) {
		return document.body && elem.width() / elem.height() < 1.1 ? "portrait" : "landscape";
	},
	
	setup: function() {
		var thisObject = this,
			$this = $( thisObject ),
			orientation = $.event.special.orientationchange.orientation( $this );

		function handler() {
			var newOrientation = $.event.special.orientationchange.orientation( $this );
			
			if ( orientation !== newOrientation ) {
				$.event.handle.call( thisObject, "orientationchange", {
					orientation: newOrientation
				} );
				orientation = newOrientation;
			}
		}

		if ( $.support.orientation ) {
			thisObject.addEventListener( "orientationchange", handler, false );
		} else {
			$this.bind( "resize", handler );
		}
	}
};



$.each({
	scrollstop: "scrollstart",
	taphold: "tap",
	swipeleft: "swipe",
	swiperight: "swipe"
}, function( event, sourceEvent ) {
	$.event.special[ event ] = {
		setup: function() {
			$( this ).bind( sourceEvent, $.noop );
		}
	};
});

(function( jQuery, window, undefined ) {

	var $window = jQuery(window),
		$html = jQuery('html');


	$window.bind( "orientationchange", function( event, data ) {
		$html.removeClass( "portrait landscape" ).addClass( data.orientation );
	});
	
	jQuery(function(){
		//update orientation 
		$html.addClass( jQuery.event.special.orientationchange.orientation( $window ) );
	});
})( jQuery, this );


// Simple list of gesture events (vanilla javascript) for A grade browsers
// Sample Apple documentation: http://developer.apple.com/library/safari/#documentation/appleapplications/reference/SafariWebContent/HandlingEvents/HandlingEvents.html#//apple_ref/doc/uid/TP40006511-SW23

/*
* On touchcancel event
*/ 
document.addEventListener('touchcancel', function(event) {

}, false);

/*
* On gesturestart event
*/
document.addEventListener('gesturestart', function(event) {
	// Usually you'll want to disable the default behoavior
    event.preventDefault(); // Prevent default zoom
	
	// Example of event object
	event.rotation;		// amount of rotation
	event.scale;		// amount of scale
}, false);

/*
* On gesturechange event
*/
document.addEventListener('gesturechange', function(event) {

}, false);

/*
* On gestureend event
*/
document.addEventListener('gestureend', function(event) {

}, false);

/*
* On gesturechange event
*/
document.addEventListener('gesturechange', function(event) {

}, false);

/*
* On orientation change event
*/
document.addEventListener('orientationchange', function(event) {
	
}, false);
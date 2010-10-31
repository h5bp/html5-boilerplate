// Simple list of gesture events (vanilla javascript) for A grade browsers
// Sample Apple documentation: http://developer.apple.com/library/safari/#documentation/appleapplications/reference/SafariWebContent/HandlingEvents/HandlingEvents.html#//apple_ref/doc/uid/TP40006511-SW23

/*
* On touchstart event
*/
document.addEventListener('touchstart', function(event) {
	// Usually you'll want to disable the default behoavior
    event.preventDefault(); // Prevent scrolling on this element
	
	// Examples of the event object:
	var touches 		= event.touches;		// All touch events on page
	var touch 			= event.targetTouches;	// Touch on specific element
	var touchChange 	= event.changedTouches; // Get all changed touches on page
	
	event.touches.length; 	// Num. of touches
	event.touches[1];		// Get the second touch target
	event.touches[0].pageX; // Location of first finger - x
	event.touches[0].pageY; // Location of first finger - y
}, false);

/*
* On touchmove event
*/ 
document.addEventListener('touchmove', function(event) {

}, false);

/*
* On touchend event
*/ 
document.addEventListener('touchend', function(event) {

}, false);

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
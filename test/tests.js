
// documentation on writing tests here: http://docs.jquery.com/QUnit
// example tests: https://github.com/jquery/qunit/blob/master/test/same.js

// below are some general tests but feel free to delete them.

module("example tests");
test('HTML5 Boilerplate is sweet',function(){
  expect(1);
  equals('boilerplate'.replace('boilerplate','sweet'),'sweet','Yes. HTML5 Boilerplate is, in fact, sweet');
  
})

// these test things from plugins.js
test('Environment is good',function(){
  expect(3);
  ok( !!window.log, 'log function present');
  
  var history = log.history && log.history.length || 0;
  log('logging from the test suite.')
  equals( log.history.length - history, 1, 'log history keeps track' )
  
  ok( !!window.Modernizr, 'Modernizr global is present')
})




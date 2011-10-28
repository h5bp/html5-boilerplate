var path = require('path');
var fs   = require('fs');
var exec = require('child_process').exec;
var lib  = path.join(path.dirname(fs.realpathSync(__filename)), '../lib');

// Use this script while node-inspector is running.
//
// Usage:
//
//    node cakedebug.js --debug [task]
//
// Set a `debugger` statement and make sure to have node-inspector
// running in background. This will allow you to debug the script,
// pretty neat.


// mac only: tweak this to match your environment
exec('open http://localhost:8080', function(err) {
  if(err) throw err;
  require('coffee-script/lib/cake').run();
});


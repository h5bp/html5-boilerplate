var zombie = require('zombie'),
    colors = require('colors'),
    connect = require('connect'),
    path = require('path'),
    child = require('child_process'),
    exec = require('child_process').exec,
    EventEmitter = require('events').EventEmitter;

// ## macros
//
// and vows helpers. defines a few macros to help in tests
var macros = module.exports = {};

// **extendContext**: private module scope helper. copy over the properties from vows to context.
//
// borrowed to [hook.io macros](https://github.com/hookio/hook.io/blob/master/test/helpers/macros.js#170)
var extendContext = function extendContext (context, vows) {
  if (vows && vows.topic) {
    console.error('Cannot include topic at top-level of nested vows:'.red);
    process.exit(1);
  }

  Object.keys(vows).forEach(function (key) {
    context[key] = vows[key];
  });

  return context;
};

var spawn = function spawn(cmd, args, callback) {
  var stderr = [], stdout = [],
      ch = child.spawn(cmd, args);

  ch.stdout.pipe(process.stdout, {end: false});
  ch.stderr.pipe(process.stderr);
  ch.stdout.on('data', function(data) { stdout[stdout.length] = data; });
  ch.stderr.on('data', function(data) { stderr[stderr.length] = data; });
  ch.on('exit', (callback || function (code) {
    ch.emit('end', code, stdout.join('\n'), stderr.join('\n'));
  }));

  return ch;
};


// **assertListen**: macro to start and listen to the port provided.
// Starts up a new connect server with very basic middleware setup,
// logger and static configured to serve the publish dir
//
// Now, does the entire integration with build script,
// cloning the repo if not done yet, making the build
// and runing the test
//
// todo: break this up in another macro
macros.assertListen = function (port, root, vows) {
  var context = {
    topic: function () {
      var em = new EventEmitter,
          build, server, stderr = [];

      root = path.join(__dirname, '../..', root);

      server = connect.createServer()
        .use(connect.static(root));

      // prior to the whole test suite to run, ensure the root dir is there
      // otherwise, call the main build task and continue
      var ok = path.existsSync(root);
      if(ok) {
        server.listen(port, em.emit.bind(em, 'success'));
        return em;
      }

      console.log(('  » ' + root + ' needs to be there, going to execute cake build...').grey);

      process.chdir(path.resolve(__dirname, '../../'));

      var build = spawn('cake', ['build']);

      build.on('end', function (code, stdout, stderr) {
        var createproject = /createproject/.test(stderr);
        if(code > 0 && !createproject) throw new Error(('cake build exited with code ' + code + '\n ' + stderr).red);

        // if there's no error, continue to vows at this point
        if(!createproject) return server.listen(port, em.emit.bind(em, 'success'));

        // otherwise, run the createproject task without prompt and rerun the build

        // grab the dir.source value from the error output
        var output = stderr.match(/\/[^\s]+/)[0].split('/').reverse()[0];

        // end run the cake project task
        spawn('cake', ['-o', output, 'createproject'])
          .on('end', function(code, stdout, stderr) {
            // finally, we can go on with build and test

            // rerun the build, this time should be all good
            spawn('cake', ['build'])
              .on('end', function(code, stdout, stderr) {
                if (code > 0) throw new Error(stderr || stderr);
                server.listen(port, em.emit.bind(em, 'success'));
              });
          });
      });

      return em;
    }
  };

  return extendContext(context, vows);
};


// **assertZombie**: tell zombie to visit the page host:8080.
macros.assertZombie = function(host, port, vows) {
  var context = {
    topic: function() {
      zombie.visit('http://' + host + ':' + port, {runScripts: false}, this.callback.bind(this))
    }
  };

  return extendContext(context, vows);
};


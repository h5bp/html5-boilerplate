
var exec = require('child_process').exec;

task('test.jstask', 'Dummy task for testing autoloaded tasks (js)', function(options, em) {
  var commands = [
    'echo "dummy task"',
    'echo "for testing the autoload"',
    'echo "should be able to require() and exec stuff for instance"'
  ].join(' && ');

  em.emit('log', 'Dummy task for testing autoloaded tasks (js)');

  em.emit('data', this);

  return exec(commands, function(err, stdout) {
    if (err) {
      return error(err);
    }
    em.emit('log', '\n  » ' + stdout.trim().split('\n').join('\n  » '));
    return em.emit('end');
  });
});

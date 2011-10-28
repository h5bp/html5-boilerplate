
fs              = require 'fs'
path            = require 'path'
{spawn, exec}   = require 'child_process'

helper = require './tasks/util/helper'

# ## jshint
# run the `dir.js` folder through jshint with default options. Exits and reports in case of lint errors.
#
# Run separately
task 'jshint', 'jshint task, run jshint on any non min.js file in dir.js', (options, em) ->
  helper.fileset "#{dir.source}/#{dir.js}/", "**/*.min.js #{dir.source}/#{dir.js.libs}", (err, files) ->
    return error err if err
    exec 'jshint ' + files.join(' '), (err, stdout) -> 
      return em.emit 'log', '  ✔ Congrats! Lint Free!'.green unless err

      if err.message is 'Command failed: '
        em.emit 'warn', [
          "jshint returns the following errors \n"
          stdout.split('\n').map((line) -> return "  ✗ #{line}").join('\n')
        ].join('\n')

# ## csslint
# run the `dir.css` folder through csslint with default options. Reports in case of lint errors.
#
# Run separately
task 'csslint', 'csslint task, run csslint on dir.css and ommit *.min.css one', (options, em) ->
  helper.fileset "#{dir.source}/#{dir.css}/", "**/*.min.css", (err, files) ->
    return error err if err
    for file in files then do (file) ->
      exec 'csslint ' + file, (err, stdout, stderr) ->
        return em.emit 'log', "  ✔ Congrats! Lint Free! --> #{file}".green if stdout.match(/no\serrors/i)

        em.emit 'warn', [
          "  ✗ csslint returns the following errors"
          stdout.split('\n').map((line) -> return "    #{line}").join('\n')
        ].join('\n')


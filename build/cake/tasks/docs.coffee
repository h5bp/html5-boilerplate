
{spawn, exec}   = require 'child_process'

# ### cake docs
# Generates the source docco documentation of this cake script.
#
# added as a conveniency
task 'docs', 'Generates the source documentation of this cake script', (options, em) ->

  commands = [
    "rm -rf documentation/*.html"
    "cp Cakefile Cakefile.coffee"
    "docco conf/*.coffee *.coffee tasks/*.coffee tasks/*.js"
    "cp -vr docs/*.html documentation"
    "rm -rf docs Cakefile.coffee"
  ].join(' && ')

  exec commands, (err, stdout) ->
    return error err if err

    em.emit 'log', '\n  » ' + stdout.trim().split('\n').join('\n  » ')
    em.emit 'log', ' ✔ Documentation generated » docs/ → documentation/'
    em.emit 'end'

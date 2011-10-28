
fs              = require 'fs'
path            = require 'path'
{spawn, exec}   = require 'child_process'

helper = require './tasks/util/helper'

base = process.cwd()

# ## IMG tasks
#
# These tasks try to runoptipng on png files in `dir.img` and 
# handle the  the revving of img filenames
#

# ### cake img.optimize
# mainly done using optipng and  by spawning child process, so you'll need
# optipng in yout PATH for this to work
#
# no jpg optimization for now
task 'img.optimize', 'Run optipng', (options, em) ->

  invoke 'mkdirs'

  gem.once 'end:mkdirs', ->
    em.emit 'log', 'Optimizing images...'
    em.emit 'log', 'This part might take a while. But everything else is most likely already done.'

    em.emit 'log', 'Run optipng on the .png files'

    # check that we have actual png files before runing optipng
    helper.fileset "#{base}/#{dir.intermediate}/#{dir.images}/*.png", (err, files) ->
      return erorr err if err

      # prevent optipng from returning with error if no files to process
      return em.emit 'end' unless files.length

      # run optipng with default options (make this configurable)
      exec "optipng #{base}/#{dir.intermediate}/#{dir.images}/*.png", (err, stdout, stderr) ->
        return error new Error( (stderr || stdout).trim().split('\n').join('\n  » ') ) if err

        em.emit 'log', '\n  » ' + stdout.trim().split('\n').join('\n  » ').grey, '\n\n'
        em.emit 'end'

# ### cake img.ref
#
# should we do this before, or after img.optimization?
task 'img.rev', 'handle the automatic revving of image filenames', (options, em) ->
  invoke 'img.optimize'

  gem.once 'end:img.rev', (chk) ->
    em.emit 'log', chk

  gem.once 'end:img.optimize', ->
    em.emit 'log', 'Going to rev image filenames'

    helper.fileset "#{base}/#{dir.intermediate}/#{dir.images}/*.png", (err, files) ->
      return error err if err

      checksums = []

      return em.emit 'end' unless files.length
      remaining = files.length
      for file in files then do (file) ->
        helper.checksum file, (err, checksum) ->
          checksum = checksum.substring 0, hash.length
          em.emit 'log', "#{file} checksum is #{checksum}"

          filename = file.split('/').reverse()[0]
          checksum = "#{checksum}.#{filename}"
          em.emit 'log', "copying #{filename} to #{checksum}"

          helper.copy file, file.replace(filename, checksum), (err) ->
            return error err if err

            # once copy done, also keep reference to filename -> sha, to use in `usemin`
            # probably not the best way to do this, relying on module-scoped variable
            checksums.push(checksum)
            em.emit 'end', checksums if --remaining is 0

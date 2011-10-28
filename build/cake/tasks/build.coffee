
fs              = require 'fs'
path            = require 'path'
{spawn, exec}   = require 'child_process'
mkdirp          = require 'mkdirp'

helper = require './tasks/util/helper'

base = process.cwd()

# ## Main tasks
#
# * combining and minifying CSS
# * combining and minifying JS
# * image optimization


# ### cake build
# Build with defaults configuration the main tasks: js, css and img optimiaztion. Depends on:
#
# * js
# * css
# * img
# * usemin
# * usecssmin
task 'build', 'Build with defaults configuration the main tasks: js, css and img optimiaztion', (option, em) ->

  start = +new Date

  invoke 'js'
  invoke 'css'
  invoke 'img'
  invoke 'usemin'
  invoke 'usecssmin'

  remaining = 0
  handle = (name) ->
    remaining++
    return ->
      return unless --remaining is 0

      em.emit 'log', "Build done, now copy the #{dir.intermediate} folder over to #{dir.publish}"

      em.emit 'log', 'minify html before copy...'
      invoke 'htmlclean'
      # gem.emit 'end:htmlclean'


  gem.on 'end:js', handle()
  gem.on 'end:css', handle()
  gem.on 'end:img', handle()
  gem.on 'end:usemin', handle()
  gem.on 'end:usecssmin', handle()


  gem.on 'end:htmlclean', ->
    commands = [
      "cp -r #{base}/#{dir.intermediate} #{base}/#{dir.publish}",
      "rm -rf #{base}/#{dir.intermediate}"
    ].join(' && ')

    exec commands, (err, stdout, stderr) ->
      return error err if err
      elapsed = (+new Date - start) / 1000
      em.emit 'log', "✔ Build Script successful (#{elapsed}s). Check your #{dir.publish}/ folder"
      em.emit 'end'


# ### cake js
# Combines and minifies JS
task 'js', 'Combines and minifies JS', (options, em) ->

  invoke 'js.scripts.concat'

  gem.on 'end:js.scripts.concat', em.emit.bind(em, 'end')

# ### cake css
# Combines and minifies CSS
task 'css', 'Combines and minifies CSS', (options, em) ->

  invoke 'css.concat'

  gem.on 'end:css.concat', em.emit.bind(em, 'end')

# ### cake img
# Performs img optimization
task 'img', 'Performs img optimization', (options, em) ->

  # img.rev depends on img.optimize, which runs optipng on img/*.png with
  # standards options. img.rev handle the automatic revving of img
  # filenames.
  invoke 'img.rev'

  gem.on 'end:img.rev', em.emit.bind(em, 'end')

# ## Support tasks

# ### cake intro
#
# Output the intro message.
#
task 'intro', 'Kindly inform the developer about the impending magic', (options, em) ->
  message = """

    ====================================================================
    Welcome to the ★ HTML5 Boilerplate Build Script! ★

    We're going to get your site all ship-shape and ready for prime time.

    This should take somewhere between 15 seconds and a few minutes,
    mostly depending on how many images we're going to compress.

    Feel free to come back or stay here and follow along.
    =====================================================================
  """

  em.emit 'log', message.split('\n').join('\n  ')
  em.emit 'end', message.grey

# ### cake check
#
# Performs few validations upon the current repo, outputing errors if any
task 'check', 'Performs few validations upon the current repo, outputing errors if any', (options, em) ->
  # check few configuration values, namely dir.source
  # Test whether or not the dir.source path exists.
  exists = path.existsSync "#{base}/#{dir.source}"

  return error new Error("#{base}/#{dir.source} does not exist, change the dir.source config or run cake createproject and enter #{dir.source} when prompted") unless exists

# ### cake clean
#
# Wipe the previous build
task 'clean', 'Wipe the previous build', (options, em) ->
  invoke 'intro'
  invoke 'check'

  em.emit 'log', 'Cleaning up previous build directory...'.grey

  exec "rm -rf #{dir.intermediate} #{dir.publish}", (err, stdout, stderr) ->
    return error err if err

    em.emit 'end', stdout

# ### cake mkdirs
#
# Create the directory structure and
# copy the whole `dir.source` to `dir.intermediate`.
#
task 'mkdirs', 'Create the directory intermediate structure', (options, em) ->

  invoke 'clean'

  gem.on 'end:clean', ->
    failmsg = "Your dir.publish folder is set to #{dir.publish} which could delete your entire site or worse. Change it in project.properties"
    dangerousPath = !!~['..', '.', '/', './', '../'].indexOf(dir.publish)
    return error new Error(failmsg) if dangerousPath

    process.chdir path.join(base, "#{dir.source}")
    helper.fileset(".", [file.default.exclude, file.exclude].join(' '))
      .on('error', console.error.bind(console))
      .on('end', (files) ->
        em.emit 'log', "Copying #{files.length} files over to #{dir.intermediate} and #{dir.publish} from #{dir.source}".grey
        destinations = [dir.intermediate]
        remaining = files.length * destinations.length
        for to in destinations then do (to) ->
          for file in files then do(file) ->
            fragment = file.split '/'
            dirname = '/' + file.split('/')[1..-2].join('/')
            dirname = dirname.replace(dirname.split(base)[1].split('/')[1..][0], to)
            filename = file.split('/')[-1..][0]

            mkdirp dirname, 0755, (err) ->
              return error err if err
              to = path.join(dirname, filename)
              exec "cp -v #{file} #{to}", (err, stdout, stderr) ->
                return error err if err
                em.emit 'end', 'done' if --remaining is 0
      )

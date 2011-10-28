
path            = require 'path'
{spawn, exec}   = require 'child_process'
prompt          = require 'prompt'
mkdirp          = require 'mkdirp'

helper = require './tasks/util/helper'

base = process.cwd()

repo =
  # use http here, better support with corp proxies...
  h5bp: 'https://github.com/h5bp/html5-boilerplate.git'

# ## cake createproject 
#
# Generate a new project from your HTML5 Boilerplate repo clone
#
# - by: Rick Waldron & Michael Cetrulo
#
# The terminal will prompt with this message:
#
#     To create a new html5-boilerplate project, 
#     enter a new directory name:
#
# Type the name of the new project you are creating, ideally in lowercase letters,
# with no spaces - this will be the directory name that your new project lives in. 
# Press Enter to continue.
#
# If you attempt to create a directory that already exists, createproject.sh will warn you and stop running.
#
# If all goes smoothly, you will see the following messages:
#
#     Created Directory: [name]
#
#     [ A list of all the html5-boilerplate files being copied ]
#
#     Created Project: [name]
# Success! You now have a clean project to begin making the next HTML5 wunderkind demo!
#

task 'createproject', 'a simple create project task', (options, em) ->

  src = path.join base, repo.h5bp.split('/').reverse()[0].replace(/\.git/, '')

  exists = path.existsSync src

  gitcmd = if exists then 'pull' else 'clon'

  em.emit 'log', "#{gitcmd}ing #{repo.h5bp}..."

  args = (if exists then 'pull origin master' else "clone #{repo.h5bp}").split(' ')

  process.chdir src if exists
  helper.spawn 'git', args, (code, stdout, stderr) ->
    return error new Error('err') if code > 0
    stdout = stdout.replace(/\n/gm, '')
    em.emit 'log', "  ✔  #{stdout}"

    em.emit 'log', '  - To create a new html5-boilerplate project, enter a new directory name:'

    prompt.message = "    ↩ "
    prompt.delimiter = ''
    prompt.override = {directory: options.output}

    prompt.start() unless prompt.override.directory
    prompt.get ['directory'], (err, result) ->
      return error err if err
      return error new Error("please provide a directory name") unless result.directory
      dest = path.join(base, result.directory)
      mkdirp dest, 0755, (err) ->
        return error err if err
        em.emit 'log', "  ✔  Created Directory: #{dest}"
        exec ["cd #{src}", "cp -vr css js img build *.html *.xml *.txt *.png *.ico .htaccess #{dest}"].join(' && '), (err, stdout, stderr) ->
          return error stderr if err
          output = stdout.split(/\n/)

          output.forEach (line) -> em.emit "    » #{line}", 'log'
          em.emit 'log', "  ✔  Created Project: #{dest}"
          process.chdir base



fs              = require 'fs'
path            = require 'path'
{spawn, exec}   = require 'child_process'
cssmin          = require 'clean-css'

helper = require './tasks/util/helper'

base = process.cwd()

# ## CSS tasks
#
# These tasks are related to css optimizations, mainly concat, `@import` inlining
# and minification (using [clean-css](https://github.com/GoalSmashers/clean-css#readme))

# ### css.concat
#
# Concat the CSS files depending on the @imports in your file.root.stylesheet
#
# `@import` should be fortmated like so
#
#     @import url('style.bar.css')
#     @import url("style.foo.css")
#
task 'css.concat', 'Concat the CSS files depending on the @imports in your file.root.stylesheet', (options, em) ->

  invoke 'mkdirs'

  gem.once 'end:mkdirs', ->
    em.emit 'log', 'Copy source file to intermediate directory'
    from = path.join dir.source, dir.css, file.root.stylesheet
    to = path.join dir.intermediate, dir.css, file.root.stylesheet
    return em.emit 'copy', from, to

  # called once the source to intermediate copy is done
  em.on 'copy', (from, to) ->
    em.emit 'log', 'Concatenating any @imports'

    # replace imports with h5bp-import tags (part 1) this one wraps @media types
    file = fs.readFile path.join(base, to), 'utf8', (err, body) ->

      # go sync during the process of replace to ease the process
      body = body.replace /@import url\([^\)]+\)/gi, (match) ->
        file = match.match(/@import url\(([^\)]+)\)/)?[1].replace(/['|"]/g, '')
        filepath = path.join base, dir.intermediate, dir.css, file

        # test if the url property is valid and match an actual file in the repo
        ok = path.existsSync filepath
        return error new Error("@import-ed #{filepath} does not exist") unless ok

        em.emit 'log', "replacing #{match} with #{file} content"
        return "/* h5bp-import --> #{file} */\n" + fs.readFileSync filepath, 'utf8'

      # now minify the whole css file, done using clean-css
      # may just opt to use yuicompressor instead by spawning a java process
      # (make it configurable)
      em.emit 'log', "Minify #{to} file..."
      body = cssmin.process body
      em.emit 'log', 'Done'.green
      # write the file to the intermediate dir
      to = path.join base, to

      checksum = helper.checksum(body).substring 0, hash.length

      em.emit 'log', "Cheskum for this file is #{checksum}"
      to = to.replace(/style\.css/, "#{checksum}.style.min.css")

      # set the global style.css for future reference in usemin
      style = { css: to.split('/').reverse()[0] }

      em.emit 'log', "Write the min css file to #{to}"
      fs.writeFile to, body, (err) ->
        return error err if err
        em.emit 'end', style


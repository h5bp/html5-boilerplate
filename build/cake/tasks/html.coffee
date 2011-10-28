
fs              = require 'fs'
path            = require 'path'
{spawn, exec}   = require 'child_process'
htmlmin         = require 'html-minifier'

helper = require './tasks/util/helper'

base = process.cwd()

# ## HTML tasks
#
# tasks related to html manipulation such as cleaning
# and updating script/css references, html minification and so on


# ### cake htmlclean
#
# using the fantastic html minifier tool by kangax:: https://github.com/kangax/html-minifier
task 'htmlclean', 'Peforms basic to aggresive minification', (options, em) ->
  em.emit 'log', 'Run html-minifier on the HTML with standard options'

  gem.once 'end:mkdirs', ->
    # get the file to min
    em.emit 'log', "Run on #{file.pages.default.include}"

    process.chdir path.join(base, dir.intermediate)
    helper.fileset "#{file.pages.default.include}", (err, pages) ->
      return error err if err

      remaining = pages.length
      for page in pages then do (page) ->
       fs.readFile page, 'utf8', (err, body) ->
        return error err if err

        # todo: move the configuration over to config files
        # going with most aggresive minification for now

        output = htmlmin.minify body, {
          removeComments: true
          removeCommentsFromCDATA: true
          removeEmptyAttributes: true
          cleanAttributes: true
          removeAttributeQuotes: true
          removeRedundantAttributes: true
          removeScriptTypeAttributes: true
          removeStyleLinkTypeAttributes: true
          collapseWhitespace: true

          # tests no longer pass when set to true, stripping some scripts
          # removeEmptyElements: true
          collapseBooleanAttributes: true
          removeOptionalTags: true
        }

        fs.writeFile page, output, (err) ->
          return error err if err
          em.emit 'end' if --remaining is 0

  invoke 'mkdirs'


# ### cake usemin
# Replaces references to non-minified scripts/styles in HTML files.
#
task 'usemin', 'Replaces references to non-minified scripts/styles', (options, em) ->
  remaining = 0
  scripts = {}
  style = {}
  checksums = []
  handle = (from) ->
    remaining++
    return (result) ->
      scripts = result if from is 'js' and result
      style = result if from is 'css' and result
      checksums = result if from is 'img' and result
      return unless --remaining is 0

      em.emit 'log', 'Switching to minified js files...'

      process.chdir path.join(base, dir.intermediate)
      helper.fileset "#{file.pages.default.include}", (err, pages) ->
        return error err if err

        pagesCount = pages.length
        for page in pages then do (page) ->

          fs.readFile page, 'utf8', (err, body) ->
            return error err if err

            # * switch from a regular jquery to minified
            em.emit 'log', 'switch from a regular jquery to minified'
            body = body.replace /jquery-(\d|\d(\.\d)+)\.js/g, (file, version) ->
              return "jquery-#{version}.min.js"

            # * switch any google CDN reference to minified'
            em.emit 'log', 'switch any google CDN reference to minified'
            body = body.replace /(\d|\d(\.\d)+)\/jquery\.js/g, (match, version) ->
              return "#{version}/jquery.min.js"

            # * Kill off those versioning flags: ?v=2'
            em.emit 'log', 'Kill off those versioning flags: ?v=2'
            body = body.replace /\?v=\d+/g, (match) ->
              return ""

            # * Remove favicon.ico reference if it is pointing to the root
            em.emit 'log', 'Remove favicon.ico reference if it is pointing to the root'
            body = body.replace /<link rel=["']shortcut icon["'] href=["']\/favicon\.ico["']>/g, (match) ->
              return ""

            # Update the HTML to reference our concatenated script file.
            em.emit 'log', "Update the HTML to reference our concatenated script file: #{scripts.js}"
            body = body.replace /<!-- scripts concatenated[\d\w\s\W]*<!-- end scripts -->/gm, ->
              return "<script defer src=\"#{dir.js}/#{scripts.js}\"></script>"

            # Update the HTML with the new css filenames.
            em.emit 'log', "Update the HTML with the new css filenames: #{style.css}"
            body = body.replace /<link rel=["']?stylesheet["']?\shref=["']?(.*)\/style.css["']?\s*>/gm, (match, prefix) ->
              return "<link rel=\"stylesheet\" href=\"#{prefix}/#{style.css}\">"

            # Update the HTML with the new img filenames.
            em.emit 'log', "Update the HTML with the new img filenames: ", checksums.join(' - ')
            checksums.forEach (file) ->
              parts = file.split('.')
              filename = parts[1..].join('.')
              em.emit 'log', "update html files #{filename} with #{file}"
              reg = new RegExp(filename)
              body = body.replace /<img.+src=['"](.+)["'].+\/>/gm, (match, img) ->
                em.emit 'log', 'replace ', img, ' on -->', match
                return if reg.test img then match.replace(filename, file) else match

            fs.writeFile page, body, (err) ->
              return error err if err
              em.emit 'log', "#{page} now referencing minified files"
              em.emit 'end' if --pagesCount is 0


  gem.on 'end:js', handle('js')
  gem.on 'end:css', handle('css')
  gem.on 'end:img', handle('img')

  invoke 'js'
  invoke 'css'
  invoke 'img'

# ### cake usecssmin
# update revved img in CSS files. Depends on both css/img taks and replaced any 
# img references by their revved img:
#
#    48c7c33.cheesecake.png 
task 'usecssmin', 'update rev img in CSS files', (options, em) ->

  checksums = []

  invoke 'css'
  invoke 'img'

  remaining = 0
  handle = (from) ->
    remaining++
    return (result) ->
      checksums = result if from is 'img' and result
      return unless --remaining is 0

      helper.fileset "#{base}/#{dir.intermediate}/#{dir.css}/**.css", (err, styles) ->
        return error err if err

        ln = styles.length
        for style in styles then do(style) ->
          fs.readFile style, 'utf8', (err, body) ->
            return error err if err

            em.emit 'log', "Update the CSS with the new img filenames: ", checksums.join(' - ')
            checksums.forEach (file) ->
              parts = file.split('.')
              filename = parts[1..].join('.')
              em.emit 'log', "updating #{filename} with #{file}"
              body = body.replace new RegExp(filename, 'g'), file

            fs.writeFile style, body, (err) ->
              return error err if err
              em.emit 'log', "#{style} now referencing rev files"
              em.emit 'end' if --ln is 0



  gem.once 'end:css', handle('css')
  gem.once 'end:img', handle('img')

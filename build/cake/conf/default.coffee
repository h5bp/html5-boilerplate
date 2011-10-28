#
# Default Build Settings
#
# This file is a close port to the build/config/default.properties file
# for the ant build script. Some configuration properties (tools, ...)
# are not used in the cake script and probably won't be, some others are
# not used while they should be. This needs clarification.
#

# bunch of messy obj namespace definition
# todo: change this, quite ugly now.
dir = exports.dir = {}; file = exports.file = {}; build = exports.build = {}; tool = exports.tool = {}; scripts = exports.script = {}; images = exports.images = {}; hash = exports.hash = {}
file.pages = {}; file.pages.default = {}; file.default = {}; file.root = {}; file.default.js = {}
build.concat = {}; build.version = {}; build.scripts = {}
scripts.compilation = {}
images.strip = {}


#
# Directory Paths
#
dir.source          = "_test"
dir.intermediate    = "intermediate"
dir.publish         = "publish"
dir.build           = "build"
dir.build.tools     = "#{dir.build}/tools"
dir.test            = "test"
dir.demo            = "demo"
dir.js              = { main: 'js', toString: -> 'js'}
# scripts in the lib directory will only be minified, not concatenated together
dir.js.libs         = "#{dir.js}/libs"
dir.js.mylibs       = "#{dir.js}/mylibs"
dir.css             = "css"
dir.images          = "img"


#
# HTML, PHP, etc files to clean and update script/css references
#
file.pages.default.include  = "index.html, 404.html"

# You will need to include the property file.pages.include in your project.properties file
# and add any extra pages you want to be updated by the scripts in a comma separated list


# the server configuration you're going with. If you don't use apache,
#   get a different one here:  github.com/paulirish/html5-boilerplate-server-configs

file.serverconfig           = ".htaccess"

#
# Files not to be copied over by the script to the publish directory

#file.default.exclude = "node_modules"
file.default.exclude        = ".gitignore .project .settings README.markdown, README.md, **/.git/**, **/.svn/**, #{dir.test}/**, #{dir.demo}/**, #{dir.intermediate}/**, #{dir.publish}/**, #{dir.build}/**, **/nbproject/**, *.komodoproject, **/.komodotools/**, **/dwsync.xml, **_notes, **/.hg/**, **/.idea/**"
# Declare the file.exclude property in your project.properties file if you want to exclude files / folders you have added
# Note: you cannot declare an empty file.exclude property

#
# Bypass Optimization for these files
#
file.default.js.bypass = ""
# If set, these files will not be optimized (minifications, concatinations, image optimizations will not be applied)
# Note: you cannot declare an empty file.default.bypass property

#
# Root Script file
# this is the file that will be swapped for the concatenated and minified javascript.
#
file.root.script    = "script.js"

#
# Root Stylesheet
# this is the file that contains the @import directives
#
file.root.stylesheet    = "style.css"

#
# Default Stylesheet
#
file.default.stylesheets    = ""

#
# Script Optimisation
#
# If set, concat libraries with main scripts file, producing single script file
build.concat.scripts        = true

# default options for closure compiler.
scripts.compilation.level = "SIMPLE_OPTIMIZATIONS"
scripts.compilation.warninglevel = "QUIET"

#
# Image Optimisation
#
images.strip.metadata       = true
# Seting this to true will strip the metadata from all jpeg files.
# YOU SHOULD ONLY DO THIS IF YOU OWN THE COPYRIGHT TO ALL THE IMAGES IN THE BUILD

#
# Bypass Optimization for these image files or folders
#
# images.default.bypass
# If set, these images will not be optimized
# Note: you cannot declare an empty images.default.bypass property


# Build Info
build.version.info          = "buildinfo.properties"
build.scripts.dir           = "#{dir.build}/build-scripts"

# Tools
tool.yuicompressor          = "yuicompressor-2.4.5.jar"
tool.htmlcompressor         = "htmlcompressor-1.4.3.jar"
tool.csscompressor          = "css-compressor/cli.php"
tool.rhino                  = "rhino.jar"
tool.jslint                 = "fulljslint.js"
tool.jshint                 = "fulljshint.js"
tool.csslint                = "csslint-rhino.js"

# Default Lint Utils Options
tool.jshint.opts            = "maxerr=25,eqeqeq=true"
tool.jslint.opts            = "maxerr=25,evil=true,browser=true,eqeqeq=true,immed=true,newcap=true,nomen=true,es5=true,rhino=true,undef=true,white=false,devel=true"
tool.csslint.opts           = ""

# Default hash length
hash.length                 = 7


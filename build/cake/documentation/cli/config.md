cake-config(1) -- cake h5bp build script
========================================

## SYNOPSIS

    cake config
    cake -k <key> config

## DESCRIPTION


the cake script gets its configuration from 1 source:

* the default.coffee file in conf/

not yet implemented: this will surely change and evolve to something
better, probably letting user to use set configuration from a set of
source (command line args, a $HOME/.h5bprc, a $PWD/.h5bprc, default configs).

## INTRO

The `cake config` task allow one to output to the console the state of the current configuration. Optionnaly, one may specifiy a key parameter in its short (`-k`) or long(`--key`) format option.

### Example

If you run the following

    cake -k dir config


should output the dir configuration read from the different config sources:

    verbose: start config  »
    data:   {
    data:       source: '_test',
    data:       intermediate: 'intermediate',
    data:       publish: 'publish',
    data:       build: 'build',
    data:       test: 'test',
    data:       demo: 'demo',
    data:       js: {
    data:           main: 'js',
    data:           toString: [Function],
    data:           libs: 'js/libs',
    data:           mylibs: 'js/mylibs'
    data:       },
    data:       css: 'css',
    data:       images: 'img'
    data:   }

If you ommit the key value, or provide an unknown one, the task will output the whole config:

    verbose: start config  »
    warn:   No undefined in config
    data:   {
    data:       dir: {
    data:           source: '_test',
    data:           intermediate: 'intermediate',
    data:           publish: 'publish',
    data:           build: 'build',
    data:           test: 'test',
    data:           demo: 'demo',
    data:           js: {
    data:               main: 'js',
    data:               toString: [Function],
    data:               libs: 'js/libs',
    data:               mylibs: 'js/mylibs'
    data:           },
    data:           css: 'css',
    data:           images: 'img'
    data:       },
    data:       file: {
    data:           pages: {
    data:               default: { include: 'index.html, 404.html' }
    data:           },
    data:           default: {
    data:               js: { bypass: '' },
    data:               exclude: '.gitignore .project .settings README.markdown, README.md, **/.git/**, **/.svn/**, test/**, demo/**, intermediate/**, publish/**, build/**, **/nbproject/**, *.komodoproject, **/.komodotools/**, **/dwsync.xml, **_notes, **/.hg/**, **/.idea/**',
    data:               stylesheets: ''
    data:           },
    data:           root: { script: 'script.js', stylesheet: 'style.css' },
    data:           serverconfig: '.htaccess'
    data:       },
    data:       build: {
    data:           concat: { scripts: true },
    data:           version: { info: 'buildinfo.properties' },
    data:           scripts: { dir: 'build/build-scripts' }
    data:       },
    data:       tool: {
    data:           yuicompressor: 'yuicompressor-2.4.5.jar',
    data:           htmlcompressor: 'htmlcompressor-1.4.3.jar',
    data:           csscompressor: 'css-compressor/cli.php',
    data:           rhino: 'rhino.jar',
    data:           jslint: 'fulljslint.js',
    data:           jshint: 'fulljshint.js',
    data:           csslint: 'csslint-rhino.js'
    data:       },
    data:       script: {
    data:           compilation: { level: 'SIMPLE_OPTIMIZATIONS', warninglevel: 'QUIET' }
    data:       },
    data:       images: {
    data:           strip: { metadata: true }
    data:       },
    data:       hash: { length: 7 }
    data:   }


**todo there: extensive documentation on each configuration key**

## dir

## file

## build

## tool

## script

## images

## hash 

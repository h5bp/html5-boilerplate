## install

In the root of this folder (build/cake), run

    npm install

It'll get the dependencies as defined in the `package.json` file (they're quite a few, this may take a while)

    mkdirp@0.0.6 ./node_modules/mkdirp 
    colors@0.5.0 ./node_modules/colors 
    html-minifier@0.4.5 ./node_modules/html-minifier 
    coffee-script@1.1.2 ./node_modules/coffee-script 
    uglify-js@1.0.7 ./node_modules/uglify-js 
    clean-css@0.2.4 ./node_modules/clean-css 
      └── optimist@0.1.9
    vows@0.5.11 ./node_modules/vows 
      └── eyes@0.1.6
    connect@1.7.1 ./node_modules/connect 
      ├── mime@1.2.3
      └── qs@0.3.1
    zombie@0.10.1 ./node_modules/zombie 
      ├── mime@1.2.3
      ├── websocket-client@1.0.0
      ├── contextify@0.0.5
      └── jsdom@0.2.4
    prompt@0.1.8 ./node_modules/prompt 
      ├── pkginfo@0.2.2
      ├── async@0.1.9
      └── winston@0.5.0
    fileset@0.0.1 ./node_modules/fileset 
      ├── glob@2.0.8
      └── findit@0.1.1


### h5bp

cd to `build/cake` and run `cake` to get the following output

    cake docs                 # Generates the source documentation of this cake script
    cake build                # Build with defaults configuration the main tasks: js, css and img optimiaztion
    cake js                   # Combines and minifies JS
    cake css                  # Combines and minifies CSS
    cake img                  # Performs img optimization
    cake createproject        # a simple create project task
    cake intro                # Kindly inform the developer about the impending magic
    cake check                # Performs few validations upon the current repo, outputing errors if any
    cake clean                # Wipe the previous build
    cake mkdirs               # Create the directory intermediate structure
    cake js.main.concat       # Concatenates the JS files in dir.js
    cake js.mylibs.concat     # Concatenates the JS files in dir.js.mylibs
    cake js.scripts.concat    # Concatenating library file with main script file
    cake js.all.minify        # Minifies the *-concat.js files in intermediate/js
    cake jshint               # jshint task, run jshint on any non min.js file in dir.js
    cake csslint              # csslint task, run csslint on dir.css and ommit *.min.css one
    cake css.concat           # Concat the CSS files depending on the @imports in your file.root.stylesheet
    cake img.optimize         # Run optipng
    cake usemin               # Replaces references to non-minified scripts/styles
    cake htmlclean            # Peforms basic to aggresive minification

      -o, --output       directory for the createproject task

This is a quick and dirty implementation, but the following tasks may (or may not) work

* js: concat libs/mylibs files, calculates a new checksum and uglify the file
* css: a basic @import inline is made, calculates a new checksum then minify
* img: execute optipng over the .png files in dir.images
* lint: jshint/csslint
* usemin: replaces references to non-minified scripts/styles
* htmlclean: html minification

#### test

    npm test

it'll trigger a first clone/pull/build if needed, and run the vows/zombie test suite.

Check the [tests/build.js](https://github.com/mklabs/cakes/blob/master/h5bp/tests/build.js) file to see the basic asserts



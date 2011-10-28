cake-js(1) -- cake JS tasks
================================

## DESCRIPTION

Set of JS related tasks.

These tasks are related to JS optimizations, mainly concat and minification 
(using [uglify-js](https://github.com/mishoo/UglifyJS#readme)).

## Tasks

### js.main.concat

Concatenates the JS files in dir.js. depends on `mkdirs` task.

### js.mylibs.concat

Concatenates the JS files in dir.js.mylibs. depends on `mkdirs` task.

### js.scripts.concat

* Concatenates library file with the main script file. 
* Calculates an md5 checksum, prefix the script name, and copy over to the js folder

Example:

    #{dir.publish}/#{dir.js}/publish/js/e816baa.scripts-concat.min.js

### js.all.concat

Minifies the scripts.js files in #{dir.intermediate}/#{dir.js}. depends
on `mkdirs` task. Ugliy-JS is used as a minifier, with default options.

## SEE ALSO

* cake help
* cake -h css help
* cake -h html help


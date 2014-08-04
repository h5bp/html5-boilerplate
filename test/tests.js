/* global describe, it */

var assert = require('assert');
var fs = require('fs');
var path = require('path');

var pkg = require('./../package.json');
var dirs = pkg['h5bp-configs'].directories;

var expectedFilesInArchiveDir= [
    pkg.name + '_v' + pkg.version + '.zip'
];

var expectedFilesInDistDir = [

    '.editorconfig',
    '.gitattributes',
    '.gitignore',
    '.htaccess',
    '404.html',
    'apple-touch-icon-precomposed.png',
    'browserconfig.xml',
    'crossdomain.xml',

    'css/', // for directories, a '/' character
            // should be included at the end
        'css/main.css',
        'css/normalize.css',

    'doc/',
        'doc/TOC.md',
        'doc/css.md',
        'doc/extend.md',
        'doc/faq.md',
        'doc/html.md',
        'doc/js.md',
        'doc/misc.md',
        'doc/usage.md',

    'favicon.ico',
    'humans.txt',

    'img/',
        'img/.gitignore',

    'index.html',

    'js/',
        'js/main.js',
        'js/plugins.js',
        'js/vendor/',
            'js/vendor/jquery-' + pkg.devDependencies.jquery + '.min.js',
            'js/vendor/modernizr-2.8.0.min.js',

    'robots.txt',
    'tile-wide.png',
    'tile.png'

];

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function checkFiles(directory, expectedFiles) {

    // Get the list of files from the specified directory
    var files = require('glob').sync('**/*', {
        'cwd': directory,
        'dot': true,      // include hiddent files
        'mark': true      // add a '/' character to directory matches
    });

    // Check if all expected files are present in the
    // specified directory, and are of the expected type
    expectedFiles.forEach(function (file) {

        var ok = false;
        var expectedFileType = (file.slice(-1) !== '/' ? 'regular file' : 'directory');

        // If file exists
        if ( files.indexOf(file) !== -1 ) {

            // Check if the file is of the correct type
            if ( file.slice(-1) !== '/' ) {
                // Check if the file is really a regular file
                ok = fs.statSync(path.resolve(directory, file)).isFile();
            } else {
                // Check if the file is a directory
                // (Since glob adds the `/` character to directory matches,
                // we can simply check if the `/` character is present)
                ok = (files[files.indexOf(file)].slice(-1) === '/');
            }

        }

        it('"' + file + '" should be present and it should be a ' + expectedFileType, function () {
            assert.equal(true, ok);
        });

    });

    // List all files that should be NOT
    // be present in the specified directory
    (files.filter(function (file) {
        return expectedFiles.indexOf(file) === -1;
    })).forEach(function (file) {
        it('"' + file + '" should NOT be present', function () {
            assert(false);
        });
    });

}

function checkString(file, string, done) {

    var character = '';
    var matchFound = false;
    var matchedPositions = 0;
    var readStream = fs.createReadStream(file, {'encoding': 'utf8'});

    readStream.on('close', done);
    readStream.on('error', done);
    readStream.on('readable', function () {

        // Read file until the string is found
        // or the whole file has been read
        while ( matchFound !== true &&
                ( character = readStream.read(1) ) !== null ) {

            if ( character === string.charAt(matchedPositions) ) {
                matchedPositions += 1;
            } else {
                matchedPositions = 0;
            }

            if ( matchedPositions === string.length ) {
                matchFound = true;
            }

        }

        assert.equal(true, matchFound);
        this.close();

    });

}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function runTests() {

    describe('Test if all the expected files are present in the "' + dirs.archive + '", and only them', function () {
        checkFiles(dirs.archive, expectedFilesInArchiveDir);
    });

    describe('Test if all the expected files are present in the "' + dirs.dist + '", and only them', function () {
        checkFiles(dirs.dist, expectedFilesInDistDir);
    });

    describe('Test if files have the expected content', function () {

        it('".htaccess" should have the "ErrorDocument..." line uncommented', function (done) {
            var string = '\n\nErrorDocument 404 /404.html\n\n';
            checkString(path.resolve(dirs.dist, '.htaccess'), string, done);
        });

        it('"index.html" should contain the correct jQuery version', function (done) {
            var string = pkg.devDependencies.jquery + '/jquery.min.js"></script>\n' +
                        '        <script>window.jQuery || document.write(\'<script ' +
                        'src="js/vendor/jquery-' + pkg.devDependencies.jquery + '.min.js';
            checkString(path.resolve(dirs.dist, 'index.html'), string, done);
        });

        it('"main.css" should contain a custom banner', function (done) {
            var string = '/*! HTML5 Boilerplate v' + pkg.version +
                         ' | ' + pkg.license.type + ' License' +
                         ' | ' + pkg.homepage + ' */\n\n/*\n';
            checkString(path.resolve(dirs.dist, 'css/main.css'), string, done);
        });

    });

}

runTests();

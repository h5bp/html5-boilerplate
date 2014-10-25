var fs = require('fs');
var path = require('path');

var async = require('async');
var gulp = require('gulp');
var gutil = require('gulp-util');
var logSymbols = require('log-symbols');
var plugins = require('gulp-load-plugins')(); // Load all gulp plugins
                                              // automatically and attach
                                              // them to the `plugins` object

var runSequence = require('run-sequence');    // Temporary solution until gulp 4
                                              // https://github.com/gulpjs/gulp/issues/355

var pkg = require('./package.json');
var dirs = pkg['h5bp-configs'].directories;

// ---------------------------------------------------------------------
// | Helper functions                                                  |
// ---------------------------------------------------------------------

function logError(msg) {
    gutil.log(logSymbols.error + ' ' + msg);
}

function logSuccess(msg) {
    gutil.log(logSymbols.success + ' ' + msg);
}

function createArchive(dirToArchive, archiveLocation, done) {

    var archiver = require('archiver')('zip');
    var files = require('glob').sync('**/*.*', {
        'cwd': dirToArchive,
        'dot': true // include hidden files
    });
    var output = fs.createWriteStream(archiveLocation);

    files.forEach(function (file) {

        var filePath = path.resolve(dirToArchive, file);

        // `archiver.bulk` does not maintain the file
        // permissions, so we need to add files individually
        archiver.append(fs.createReadStream(filePath), {
            'name': file,
            'mode': fs.statSync(filePath)
        });

    });

    archiver.pipe(output);
    archiver.on('error', function (error) {
        done();
        throw error;
    });
    archiver.finalize();

    output.on('close', done);

}

function copyHtaccessFile(dir, done) {
    gulp.src('node_modules/apache-server-configs/dist/.htaccess')
               .pipe(plugins.replace(/# ErrorDocument/g, 'ErrorDocument'))
               .pipe(gulp.dest(dir))
               .on('error', function () { logError(dir + '.htaccess'); })
               .on('end', function () { logSuccess(dir + '.htaccess'); done(); });
}

function copyIndexFile(dir, done) {
    gulp.src(dirs.src + '/index.html')
               .pipe(plugins.replace(/{{jquery_version}}/g, pkg.devDependencies.jquery))
               .pipe(gulp.dest(dir))
               .on('error', function () { logError(dir + 'index.html'); })
               .on('end', function () { logSuccess(dir + 'index.html'); done(); });
}

function copyjQuery(dir, done) {
    gulp.src(['node_modules/jquery/dist/jquery.min.js'])
               .pipe(plugins.rename('jquery-' + pkg.devDependencies.jquery + '.min.js'))
               .pipe(gulp.dest(dir + '/js/vendor'))
               .on('error', function () { logError(dir + 'js/vendor'); })
               .on('end', function () { logSuccess(dir + 'js/vendor'); done(); });
}

function copyMainCssFile(dir, done) {

    var banner = '/*! HTML5 Boilerplate v' + pkg.version +
                    ' | ' + pkg.license.type + ' License' +
                    ' | ' + pkg.homepage + ' */\n\n';

    gulp.src(dirs.src + '/css/main.css')
               .pipe(plugins.header(banner))
               .pipe(gulp.dest(dir + '/css'))
               .on('error', function () { logError(dir + 'css/main.css'); })
               .on('end', function () { logSuccess(dir + 'css/main.css'); done(); });

}

function copyNormalize(dir, done) {
    gulp.src('node_modules/normalize.css/normalize.css')
               .pipe(gulp.dest(dir + '/css'))
               .on('error', function () { logError(dir + 'css/normalize'); })
               .on('end', function () { logSuccess(dir + 'css/normalize'); done(); });
}

function copyOtherFiles(dir, done) {
    gulp.src([

        // Copy all files
        dirs.src + '/**/*',

        // Exclude the following files
        // (other tasks will handle the copying of these files)
        '!' + dirs.src + '/css/main.css',
        '!' + dirs.src + '/index.html'

    ], {

        // Include hidden files by default
        dot: true

    }).pipe(gulp.dest(dir))
      .on('error', function () { logError(dir + '...'); })
      .on('end', function () { logSuccess(dir + '...'); done(); });
}

function copyBaseFiles(dir, done) {
    async.parallel([
        async.apply(copyIndexFile, dir),
        async.apply(copyjQuery, dir),
        async.apply(copyMainCssFile, dir),
        async.apply(copyNormalize, dir),
        async.apply(copyOtherFiles, dir)
    ], function() {
        done();
    });
}

function getArchiveFileName(dir) {

    var suffix = dir.replace(/^.*h5bp\+?/, '');

    if (suffix !== '') {
        suffix = '_with_' + suffix + '_configs';
    }

    return pkg.name + '_v' + pkg.version + suffix + '.zip';
}

// ---------------------------------------------------------------------
// | Helper tasks                                                      |
// ---------------------------------------------------------------------

gulp.task('archive:create_archives', function (done) {

    var distDirs = dirs.dist;

    async.parallel([
        async.apply(createArchive, distDirs.base, path.resolve(dirs.archive, getArchiveFileName(distDirs.base))),
        async.apply(createArchive, distDirs.apache, path.resolve(dirs.archive, getArchiveFileName(distDirs.apache)))
    ], function() {
        done();
    });

});

gulp.task('archive:create_archive_dir', function () {
    fs.mkdirSync(path.resolve(dirs.archive), '0755');
});

gulp.task('build:h5bp', function (done) {
    copyBaseFiles(dirs.dist.base, done);
});

gulp.task('build:h5bp+apache', function (done) {

    var dir = dirs.dist.apache;

    async.parallel([
        async.apply(copyHtaccessFile, dir),
        async.apply(copyBaseFiles, dir)
    ], function () {
        done();
    });

});

gulp.task('clean', function (done) {
    require('del')([
        dirs.archive,
        dirs.dist.base,
        dirs.dist.apache
    ], done);
});

gulp.task('lint:js', function () {
    return gulp.src([
        'gulpfile.js',
        dirs.src + '/js/*.js',
        dirs.test + '/*.js'
    ]).pipe(plugins.jscs())
      .pipe(plugins.jshint())
      .pipe(plugins.jshint.reporter('jshint-stylish'))
      .pipe(plugins.jshint.reporter('fail'));
});

// ---------------------------------------------------------------------
// | Main tasks                                                        |
// ---------------------------------------------------------------------

gulp.task('archive', function (done) {
    runSequence(
        'build',
        'archive:create_archive_dir',
        'archive:create_archives',
    done);
});

gulp.task('build', function (done) {
    runSequence(
        ['clean', 'lint:js'],
        ['build:h5bp', 'build:h5bp+apache'],
    done);
});

gulp.task('default', ['build']);

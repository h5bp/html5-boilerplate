// Dependencies
import gulp from 'gulp';
import requireDir from 'require-dir';
import runSequence from 'run-sequence';
import livereload from 'gulp-livereload';
import connect from 'gulp-connect';
import pkg from './package.json';
const dirs = pkg['h5bp-configs'].directories;

// Include tasks/ folder
requireDir('./tasks', {recurse: true});

// Tasks
gulp.task('build', () => {
	global.production = false;
	runSequence("html", "css", "js", "misc", "watch");
});

gulp.task('production', () => {
    global.production = true;
    runSequence("html", "css", "js", "misc", "watch", 'img');
});

// Watcher
gulp.task('watch', () => {
    gulp.watch(`${dirs.src}/css/**/*.css`, ["css"]);
    gulp.watch(`${dirs.src}/css/**/*.html`, ["html"]);
    gulp.watch(`${dirs.src}/css/**/*.js`, ["js"]);
});

// Server
gulp.task('connect', () => {
    connect.server({
        root: dirs.dist,
        livereload: true
    });
});

gulp.task('default', ['build']);

import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;


gulp.task('lint:js', () =>
    gulp.src([
        'gulpfile.js',
        `${dirs.src}/js/*.js`,
        `${dirs.test}/*.js`
    ]).pipe(plugins().jscs())
      .pipe(plugins().jshint())
      .pipe(plugins().jshint.reporter('jshint-stylish'))
      .pipe(plugins().jshint.reporter('fail'))
);

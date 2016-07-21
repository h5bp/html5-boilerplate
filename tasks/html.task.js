import gulp from 'gulp';
import htmlmin from 'gulp-htmlmin';
import connect from 'gulp-connect';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;

gulp.task('html', () => {
    gulp.src(`${dirs.src}/**/*.html`)
        .pipe(htmlmin({ collapseWhitespace: true }))
        .pipe(gulp.dest(`${dirs.dist}`))
        .pipe(connect.reload());
});

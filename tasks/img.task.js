import gulp from 'gulp';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;
// Images
import imagemin from 'gulp-imagemin';
import pngquant from 'imagemin-pngquant';

gulp.task('img', () => {
    gulp.src(`${dirs.src}/img/**/*`)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [ pngquant() ]
        }))
        .pipe(gulp.dest(`${dirs.dist}/img/`))
});

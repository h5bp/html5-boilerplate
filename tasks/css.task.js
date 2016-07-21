import gulp from 'gulp';
import gulpif from 'gulp-if';
import addsrc from 'gulp-add-src';
import connect from 'gulp-connect';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;
// CSS
import csso from 'gulp-csso';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import autoprefixer from 'gulp-autoprefixer';
import cssvariables from 'postcss-css-variables';
import cssImport from 'postcss-partial-import';

gulp.task('css', () => {
    const production = global.production;

    gulp.src(`${dirs.src}/css/*.css`)
        .pipe(gulpif(!production, sourcemaps.init()))
        .pipe( postcss([
            cssImport(),
            cssvariables()
        ]) )
        .pipe(gulpif(production, autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        })))
        .pipe(gulpif(production, csso({
            sourceMap: false
        })))
        .pipe(gulpif(!production, addsrc(`${dirs.src}/css/abstracts/variables.css`)))
        .pipe(gulpif(!production, sourcemaps.write()))
        .pipe(gulp.dest(`${dirs.dist}/css/`))
        .pipe(connect.reload());
});

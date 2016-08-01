import gulp from 'gulp';
import speck from 'gulp-speckjs';
import foreach from 'gulp-foreach';
import rename from 'gulp-rename';
import path from 'path';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;

gulp.task('speck', ['speck:tape', 'speck:jasmine', 'speck:mocha']);

gulp.task('speck:tape', () => {
    gulp.src(`${dirs.dist}/**/*.js`)
        .pipe(foreach((stream, file) => {
            return stream
                .pipe(speck({
                    testFW: 'tape',
                    logs: true,
                    relPath: `${dirs.dist}/${$path.basename(file.path)}`
                }))
                .pipe(rename({
                    suffix : '_tapeSpec'
                }));
        }))
        .pipe(gulp.dest(`../${dirs.tests}`));
});

gulp.task('speck:jasmine', () => {
    gulp.src(`${dirs.dist}/**/*.js`)
        .pipe(foreach(function(stream, file) {
            return stream
                .pipe(speck({
                    testFW: 'jasmine',
                    logs: true,
                    relPath: `${dirs.dist}/${$path.basename(file.path)}`
                }))
                .pipe(rename({
                    suffix : '_jasmineSpec'
                }));
        }))
        .pipe(gulp.dest(`../${dirs.tests}`));
});

gulp.task('speck:mocha',function() {
    gulp.src(`${dirs.dist}/**/*.js`)
        .pipe(foreach(function(stream, file) {
            return stream
                .pipe(speck({
                    testFW: 'mocha-chai',
                    logs: true,
                    relPath: `${dirs.dist}/${$path.basename(file.path)}`
                }))
                .pipe(rename({
                    suffix : '_mochaChaiSpec'
                }));
        }))
        .pipe(gulp.dest(`../${dirs.tests}`));
});

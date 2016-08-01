import gulp from 'gulp';
import pkg from '../package.json';
import plugins from 'gulp-load-plugins';
const dirs = pkg['h5bp-configs'].directories;

gulp.task('misc', ['copy:.htaccess', 'copy:license'], () => {
    gulp.src([
                    // Copy all files
                    `${dirs.src}/**/*`,

                    // Exclude the following files
                    // (other tasks will handle the copying of these files)
                    `!${dirs.src}/css/**/*`,
                    `!${dirs.src}/js/**/*`,
                    `!${dirs.src}/img/**/*`,
                    `!${dirs.src}/**/*.html`
                ],{

            // Include hidden files by default
            dot: true

        })
        .pipe(gulp.dest(dirs.dist))
});


gulp.task('copy:.htaccess', () =>
    gulp.src('node_modules/apache-server-configs/dist/.htaccess')
        .pipe(plugins().replace(/# ErrorDocument/g, 'ErrorDocument'))
        .pipe(gulp.dest(dirs.dist))
);

gulp.task('copy:license', () =>
    gulp.src('LICENSE.txt')
        .pipe(gulp.dest(dirs.dist))
);

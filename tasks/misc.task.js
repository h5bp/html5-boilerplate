import gulp from 'gulp';
import pkg from '../package.json';
const dirs = pkg['h5bp-configs'].directories;

gulp.task('misc', () => {
    console.log(`!${dirs.src}/css/**/*.css`);
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

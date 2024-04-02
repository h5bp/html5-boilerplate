import fs from 'fs';
import path from 'path';
import gulp from 'gulp';
import gulpAutoPrefixer from 'gulp-autoprefixer';
import gulpEslint from 'gulp-eslint';
import gulpHeader from 'gulp-header';
import gulpRename from 'gulp-rename';
import archiver from 'archiver';
import { globSync } from 'glob';
import { deleteSync } from 'del';
import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const pkg = require('./package.json');

const dirs = pkg['h5bp-configs'].directories;

// ---------------------------------------------------------------------
// | Helper tasks                                                      |
// ---------------------------------------------------------------------

gulp.task('archive:create_archive_dir', (done) => {
  fs.mkdirSync(path.resolve(dirs.archive), '0755');
  done();
});

gulp.task('archive:zip', (done) => {
  const archiveName = path.resolve(
    dirs.archive,
    `${pkg.name}_v${pkg.version}.zip`,
  );
  const zip = archiver('zip');
  const files = globSync('**/*.*', {
    cwd: dirs.dist,
    ignore: [
      '**/node_modules/**',
      'package-lock.json',
      '**/dist/**',
      '**/.cache/**',
    ],
    dot: true, // include hidden files
  });
  const output = fs.createWriteStream(archiveName);

  zip.on('error', (error) => {
    done();
    throw error;
  });

  output.on('close', done);

  files.forEach((file) => {
    const filePath = path.resolve(dirs.dist, file);

    // `zip.bulk` does not maintain the file
    // permissions, so we need to add files individually
    zip.append(fs.createReadStream(filePath), {
      name: file,
      mode: fs.statSync(filePath).mode,
    });
  });

  zip.pipe(output);
  zip.finalize();
  done();
});

gulp.task('clean', (done) => {
  deleteSync([dirs.archive, dirs.dist]);
  done();
});

gulp.task('copy:index.html', () => {
  return gulp.src(`${dirs.src}/index.html`).pipe(gulp.dest(dirs.dist));
});

gulp.task('copy:license', () =>
  gulp.src('LICENSE.txt').pipe(gulp.dest(dirs.dist)),
);

gulp.task('copy:style', () => {
  const banner = `/*! HTML5 Boilerplate v${pkg.version} | ${pkg.license} License | ${pkg.homepage} */\n\n`;

  return gulp
    .src('node_modules/main.css/dist/main.css')
    .pipe(gulpHeader(banner))
    .pipe(
      gulpAutoPrefixer({
        cascade: false,
      }),
    )
    .pipe(
      gulpRename({
        basename: 'style',
      }),
    )
    .pipe(gulp.dest(`${dirs.dist}/css`));
});

gulp.task('copy:misc', () =>
  gulp
    .src(
      [
        // Copy all files
        `${dirs.src}/**/*`,

        // Exclude the following files
        // (other tasks will handle the copying of these files)
        `!${dirs.src}/css/main.css`,
        `!${dirs.src}/index.html`,
        `!**/.DS_Store`
      ],
      {
        encoding: false,
        // Include hidden files by default
        dot: true,
      },
    )
    .pipe(gulp.dest(dirs.dist)),
);

gulp.task('lint:js', () =>
  gulp
    .src([`${dirs.src}/js/*.js`, `${dirs.src}/*.js`, `${dirs.test}/*.mjs`])
    .pipe(gulpEslint())
    .pipe(gulpEslint.failOnError()),
);

// ---------------------------------------------------------------------
// | Main tasks                                                        |
// ---------------------------------------------------------------------
gulp.task(
  'copy',
  gulp.series('copy:index.html', 'copy:license', 'copy:style', 'copy:misc'),
);

gulp.task('build', gulp.series(gulp.parallel('clean', 'lint:js'), 'copy'));

gulp.task(
  'archive',
  gulp.series('build', 'archive:create_archive_dir', 'archive:zip'),
);

gulp.task('default', gulp.series('build'));

import fs from 'fs';
import path from 'path';

import gulp from 'gulp';

// Load all gulp plugins automatically
// and attach them to the `plugins` object
import plugins from 'gulp-load-plugins';

import archiver from 'archiver';
import glob from 'glob';
import del from 'del';
import modernizr from 'modernizr';

import pkg from './package.json';
import modernizrConfig from './modernizr-config.json';

const dirs = pkg['h5bp-configs'].directories;

// ---------------------------------------------------------------------
// | Helper tasks                                                      |
// ---------------------------------------------------------------------

gulp.task('archive:create_archive_dir', (done) => {
  fs.mkdirSync(path.resolve(dirs.archive), '0755');
  done();
});

gulp.task('archive:zip', (done) => {
  const archiveName = path.resolve(dirs.archive, `${pkg.name}_v${pkg.version}.zip`);
  const zip = archiver('zip');
  const files = glob.sync('**/*.*', {
    'cwd': dirs.dist,
    'ignore': [
      '**/node_modules/**',
      'package-lock.json',
      '**/dist/**',
      '**/.cache/**',
    ],
    'dot': true // include hidden files
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
      'name': file,
      'mode': fs.statSync(filePath).mode
    });
  });

  zip.pipe(output);
  zip.finalize();
  done();
});

gulp.task('clean', (done) => {
  del([
    dirs.archive,
    dirs.dist
  ]).then(() => {
    done();
  });
});

gulp.task('copy:.htaccess', () =>
  gulp.src('node_modules/apache-server-configs/dist/.htaccess')
    .pipe(plugins().replace(/# ErrorDocument/g, 'ErrorDocument'))
    .pipe(gulp.dest(dirs.dist))
);

gulp.task('copy:index.html', () => {

  let modernizrVersion = pkg.devDependencies.modernizr;

  return gulp.src(`${dirs.src}/index.html`)
    .pipe(plugins().replace(/{{MODERNIZR_VERSION}}/g, modernizrVersion))
    .pipe(gulp.dest(dirs.dist));
});

gulp.task('copy:license', () =>
  gulp.src('LICENSE.txt')
    .pipe(gulp.dest(dirs.dist))
);

gulp.task('copy:main.css', () => {
  const banner = `/*! HTML5 Boilerplate v${pkg.version} | ${pkg.license} License | ${pkg.homepage} */\n\n`;

  return gulp.src('node_modules/main.css/dist/main.css')
    .pipe(plugins().header(banner))
    .pipe(plugins().autoprefixer({
      cascade: false
    }))
    .pipe(gulp.dest(`${dirs.dist}/css`));
});

gulp.task('copy:misc', () =>
  gulp.src([
    // Copy all files
    `${dirs.src}/**/*`,

    // Exclude the following files
    // (other tasks will handle the copying of these files)
    `!${dirs.src}/css/main.css`,
    `!${dirs.src}/index.html`
  ], {
    // Include hidden files by default
    dot: true
  }).pipe(gulp.dest(dirs.dist))
);

gulp.task('copy:normalize', () =>
  gulp.src('node_modules/normalize.css/normalize.css')
    .pipe(gulp.dest(`${dirs.dist}/css`))
);

gulp.task('modernizr', (done) => {
  // TODO: rework this flow instead of just reacting to the fact that the jQuery step is gone
  if (!fs.existsSync(`${dirs.dist}/js/vendor/`)){
    fs.mkdirSync(`${dirs.dist}/js/vendor/`);
  } 
  
  modernizr.build(modernizrConfig, (code) => {
    fs.writeFile(`${dirs.dist}/js/vendor/modernizr-${pkg.devDependencies.modernizr}.min.js`, code, done);
  });
});

gulp.task('lint:js', () =>
  gulp.src([
    `${dirs.src}/js/*.js`,
    `${dirs.test}/*.js`
  ]).pipe(plugins().eslint())
    .pipe(plugins().eslint.failOnError())
);

// ---------------------------------------------------------------------
// | Main tasks                                                        |
// ---------------------------------------------------------------------
gulp.task(
  'copy',
  gulp.series(
    'copy:.htaccess',
    'copy:index.html',
    'copy:license',
    'copy:main.css',
    'copy:misc',
    'copy:normalize'
  )
);

gulp.task(
  'build',
  gulp.series(
    gulp.parallel('clean', 'lint:js'),
    'copy',
    'modernizr'
  )
);

gulp.task(
  'archive',
  gulp.series(
    'build',
    'archive:create_archive_dir',
    'archive:zip'
  )
);

gulp.task('default', gulp.series('build'));

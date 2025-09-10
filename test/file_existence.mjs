import assert from 'assert';
import fs from 'fs';
import path from 'path';
import { globSync } from 'glob';
import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const pkg = require('../package.json');
const dirs = pkg['h5bp-configs'].directories;

const expectedFilesInArchiveDir = [`${pkg.name}_v${pkg.version}.zip`];

const expectedFilesInDistDir = [
  '.editorconfig',
  '.gitattributes',
  '.gitignore',
  '404.html',
  'package.json',

  'webpack.common.js',
  'webpack.config.dev.js',
  'webpack.config.prod.js',

  'css/', // for directories, a `/` character
  // should be included at the end
  'css/style.css',

  'favicon.ico',

  'icon.png',
  'icon.svg',

  'img/',
  'img/.gitkeep',

  'index.html',

  'eslint.config.mjs',
  'js/',
  'js/app.js',
  'js/vendor/',
  'js/vendor/.gitkeep',
  'LICENSE.txt',
  'robots.txt',
  'site.webmanifest',
];

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function checkFiles(directory, expectedFiles) {
  // Get the list of files from the specified directory
  const files = globSync('**/*', {
    cwd: directory,
    ignore: [
      '**/node_modules/**',
      'package-lock.json',
      '**/dist/**',
      '**/.cache/**',
    ],
    dot: true, // include hidden files
    mark: true, // add a `/` character to directory matches,
    posix: true, //https://github.com/isaacs/node-glob/issues/467
  });

  // Check if all expected files are present in the
  // specified directory, and are of the expected type
  expectedFiles.forEach((file) => {
    let ok = false;
    const expectedFileType =
      file.slice(-1) !== '/' ? 'regular file' : 'directory';

    // If file exists
    if (files.indexOf(file) !== -1) {
      // Check if the file is of the correct type
      if (file.slice(-1) !== '/') {
        // Check if the file is really a regular file
        ok = fs.statSync(path.resolve(directory, file)).isFile();
      } else {
        // Check if the file is a directory
        // (Since glob adds the `/` character to directory matches,
        // we can simply check if the `/` character is present)
        ok = files[files.indexOf(file)].slice(-1) === '/';
      }
    }

    it(`"${file}" should be present and it should be a ${expectedFileType}`, () => {
      assert.equal(true, ok);
    });
  });

  // List all files that should be NOT
  // be present in the specified directory
  files
    .filter((file) => {
      return expectedFiles.indexOf(file) === -1;
    })
    .forEach((file) => {
      it(`"${file}" should NOT be present`, () => {
        assert(false);
      });
    });
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function runTests() {
  describe('Test if all the expected files, and only them, are present in the build directories', () => {
    describe(dirs.archive, () => {
      checkFiles(dirs.archive, expectedFilesInArchiveDir);
    });

    describe(dirs.dist, () => {
      checkFiles(dirs.dist, expectedFilesInDistDir);
    });
  });
}

runTests();

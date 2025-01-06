import assert from 'assert';
import fs from 'fs';
import path from 'path';
import { createRequire } from 'module';
const require = createRequire(import.meta.url);
const pkg = require('../package.json');
const dirs = pkg['h5bp-configs'].directories;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function checkString(file, string, done) {
  let character = '';
  let matchFound = false;
  let matchedPositions = 0;
  const readStream = fs.createReadStream(file, { encoding: 'utf8' });

  readStream.on('close', done);
  readStream.on('error', done);
  readStream.on('readable', function () {
    // Read file until the string is found
    // or the whole file has been read
    while (matchFound !== true && (character = readStream.read(1)) !== null) {
      if (character === string.charAt(matchedPositions)) {
        matchedPositions += 1;
      } else {
        matchedPositions = 0;
      }

      if (matchedPositions === string.length) {
        matchFound = true;
      }
    }

    assert.equal(true, matchFound);
    this.close();
  });
}

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

function runTests() {
  const dir = dirs.dist;

  describe(`Test if the files from the "${dir}" directory have the expected content`, () => {

    before(() => {
      console.log('Starting tests...');
    });

    after(() => {
      console.log('Tests complete.');
    });
    
    it('"style.css" should contain a custom banner', function (done) {
      const string = `/*! HTML5 Boilerplate v${pkg.version} | ${pkg.license} License | ${pkg.homepage} */\n`;
      checkString(path.resolve(dir, 'css/style.css'), string, done);
    });
  });
}

runTests();

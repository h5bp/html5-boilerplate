var assert = require('assert'),
  path = require('path'),
  fs = require('fs'),
  vows = require('vows');

// error helper, assert fails, output err.message to the console
// and exists process with exit code > 0
var error = function(err) {
  console.error(err.message);
  process.exit(1);
};

var build = path.join(__dirname, '..', process.env.npm_package_config_root);

var assertFile = function(files, expect) {
  var count = expect;
  return function(file, i) {
    files.forEach(function(f) {
      if(f.file !== file) return;
      count--;
      assert.ok(true);
    });

    if(i === (expect - 1) && count !== 0) {
      assert.ok(false, 'Missing files or folders')
    }
  }
};

vows.describe("build/basics").addBatch({
  "build folder should have generated files": {
    topic: fs.readdirSync(build),

    "css/ js/ img/ 404.html index.html robots.txt ...": function(files) {
      // test a few files/folders
      var buildFiles = {
        folders: 'css js img'.split(' '),
        files: '404.html index.html robots.txt'.split(' ')
      };

      assert.ok(files.length > 0);

      files = files.map(function(file) {
        return {
          file: file,
          isFile: fs.statSync(path.join(build, file)).isFile()
        }
      });

      // check folders
      buildFiles.folders.forEach(assertFile(files, 3));
      buildFiles.files.forEach(assertFile(files, 3));
    }
  }
}).export(module);


var zombie = require('zombie'),
    colors = require('colors'),
    assert = require('assert'),
    vows = require('vows'),
    macros = require('./helpers/macros');

// basic configuration value
var port = process.env.npm_package_config_port || 8080,
    host = process.env.npm_package_config_host || 'localhost',
    root = process.env.npm_package_config_root || 'publish';

// error helper, assert fails, output err.message to the console
// and exists process with exit code > 0
var error = function(err) {
  console.error(err.message);
  process.exit(1);
};

vows.describe("build/basics").addBatch({
  "when hitting localhost:8080": macros.assertListen(port, root, {
    "and using zombie.js": macros.assertZombie(host, port, {
      "to so some tests on these scripts/links": function(err, browser, status) {
        // Load the page from localhost
        if(err) return error(err);

        var $ = function qsa(selector) {
          return Array.prototype.slice.call(browser.querySelectorAll(selector));
        };

        var scripts = $('script[src]');

        assert.ok($('script[src*=modernizr]').length, 'modernizr');
        assert.ok(scripts.length, 'should have some script with src attribute'.red.bold);
        assert.ok($('link[href]').length, 'should have some links with href attribute'.red.bold);

        scripts.forEach(function(item) {
          var text = item.outerHTML;
          // prevent assert on ga.js
          assert.ok(text.match(/\.min.js/), text.red.bold + ' does not reference min file'.red.bold);
        });
      }
    })
  })
}).export(module);


[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Frequently asked questions

* [Why is the URL for jQuery without
   `http`?](#why-is-the-url-for-jquery-without-http)
* [Why don't you automatically load the latest version of jQuery from the Google
  CDN?](#why-dont-you-automatically-load-the-latest-version-of-jquery-from-the-google-cdn)
* [Why is the Google Analytics code at the bottom? Google recommends it be
  placed the `<head>`.](#why-is-the-google-analytics-code-at-the-bottom-google-recommends-it-be-placed-the-head)
* [How can I integrate Bootstrap with HTML5
  Boilerplate?](#how-can-i-integrate-bootstrap-with-html5-boilerplate)
* [Do I need to upgrade my sites each time a new version of HTML5 Boilerplate is
  released?](#do-i-need-to-upgrade-my-sites-each-time-a-new-version-of-html5-boilerplate-is-released)
* [Where can I get help with support
  questions?](#where-can-i-get-help-with-support-questions)

--

### Why is the URL for jQuery without `http`?

It is because of the use of [protocol-relative
URLs](http://paulirish.com/2010/the-protocol-relative-url/).

**N.B.** Using protocol-relative URLs for assets can be problematic when you try
to view the local web page directly, as the browser will attempt to fetch these
assets from your local file system. We recommend that you use a local server to
test your web pages (or a hosting service, such as
[Dropbox](https://www.dropbox.com/)). Setting up a local server can be done
using:

* Python 2.x by running `python -m SimpleHTTPServer` from your local directory
* Python 3.x by running  `python -m http.server` from your local directory
* Ruby by installing and running [asdf](https://rubygems.org/gems/asdf)
* [LAMP](http://en.wikipedia.org/wiki/LAMP_%28software_bundle%29),
  [MAMP](http://www.mamp.info/en/index.html),
  [WAMP](http://www.wampserver.com/en/), or
  [XAMPP](http://www.apachefriends.org/index.html)


### Why don't you automatically load the latest version of jQuery from the Google CDN?

1. Version updating should alway be an intentional decision, as the latest
   version of jQuery may not be compatible with the existing plugins/code
   on the website.
2. The latest version has a very short cache time (1 hour) compare to the
   specific version (1 year), which means that users won't get the benefits
   of long-term caching.


### Why is the Google Analytics code at the bottom? Google recommends it be placed the `<head>`.

The main advantage to placing it in the `<head>` is that you will track a user's
pageview even if they leave the page before it has been fully loaded. However,
putting the code at the bottom of the page [helps improve the website's
performance](http://developer.yahoo.com/blogs/ydn/high-performance-sites-rule-6-move-scripts-bottom-7200.html).


### How can I integrate [Bootstrap](http://getbootstrap.com/) with HTML5 Boilerplate?

One simple way is to use [Initializr](http://initializr.com) to create a custom
build that includes both HTML5 Boilerplate with Bootstrap.

Read more about how [HTML5 Boilerplate and Bootstrap complement each
other](http://www.quora.com/Is-Bootstrap-a-complement-OR-an-alternative-to-HTML5-Boilerplate-or-viceversa/answer/Nicolas-Gallagher).


### Do I need to upgrade my sites each time a new version of HTML5 Boilerplate is released?

No, same as you don't normally replace the foundations of a house once it has
been built. However, there is nothing stopping you from trying to work in the
latest changes, but you'll have to assess the costs/benefits of doing so.


### Where can I get help with support questions?

Please ask for help on
[StackOverflow](http://stackoverflow.com/questions/tagged/html5boilerplate).

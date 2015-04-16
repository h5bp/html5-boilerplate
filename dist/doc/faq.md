[HTML5 Boilerplate homepage](https://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Frequently asked questions

* [Why don't you automatically load the latest version of jQuery from the Google
  CDN?](#why-dont-you-automatically-load-the-latest-version-of-jquery-from-the-google-cdn)
* [Why is the Google Analytics code at the bottom? Google recommends it be
  placed in the `<head>`.](#why-is-the-google-analytics-code-at-the-bottom-google-recommends-it-be-placed-in-the-head)
* [How can I integrate Bootstrap with HTML5
  Boilerplate?](#how-can-i-integrate-bootstrap-with-html5-boilerplate)
* [Do I need to upgrade my site each time a new version of HTML5 Boilerplate is
  released?](#do-i-need-to-upgrade-my-site-each-time-a-new-version-of-html5-boilerplate-is-released)
* [Where can I get help with support
  questions?](#where-can-i-get-help-with-support-questions)

--

### Why don't you automatically load the latest version of jQuery from the Google CDN?

The [file](https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js) to which
the Google [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) points
to is [no longer updated and will stay locked at version `1.11.1` in order to
prevent inadvertent web
breakage](http://blog.jquery.com/2014/07/03/dont-use-jquery-latest-js/).

In general, version updating should be an intentional decision! You shouldn't
include a URL that will always point to the latest version, as that version:

 * may not be compatible with the existing plugins/code on the site
 * will have a very short cache time compare to the specific version,
   which means that users won't get the benefits of long-term caching

### Why is the Google Analytics code at the bottom? Google recommends it be placed in the `<head>`.

The main advantage of placing it in the `<head>` is that you will track the
user's `pageview` even if they leave the page before it has been fully loaded.
However, having the code at the bottom of the page [helps improve
performance](https://stevesouders.com/efws/inline-scripts-bottom.php).


### How can I integrate [Bootstrap](http://getbootstrap.com/) with HTML5 Boilerplate?

One simple way is to use [Initializr](http://www.initializr.com/) and create a
custom build that includes both HTML5 Boilerplate and
[Bootstrap](http://getbootstrap.com/).

Read more about how [HTML5 Boilerplate and Bootstrap complement each
other](https://www.quora.com/Is-Bootstrap-a-complement-or-an-alternative-to-HTML5-Boilerplate-or-viceversa/answer/Nicolas-Gallagher).


### Do I need to upgrade my site each time a new version of HTML5 Boilerplate is released?

No, same as you don't normally replace the foundation of a house once it
was built. However, there is nothing stopping you from trying to work in the
latest changes, but you'll have to assess the costs/benefits of doing so.


### Where can I get help with support questions?

Please ask for help on
[StackOverflow](https://stackoverflow.com/questions/tagged/html5boilerplate).

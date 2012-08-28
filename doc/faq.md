[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](README.md)

# Frequently asked questions

### Why is the URL for jQuery without "http"?

This is an intentional use of [protocol-relative
URLs](http://paulirish.com/2010/the-protocol-relative-url/)

**N.B.** Using a protocol-relative URL for files that exist on a CDN is
problematic when you try to view your local files directly in the browser. The
browser will attempt to fetch the file from your local file system. We
recommend that you use a local server to test your pages (or Dropbox). This can
be done using Python by running `python -m SimpleHTTPServer` from your local
directory, using Ruby by installing and running
[asdf](https://rubygems.org/gems/asdf), and by installing any one of XAMPP,
MAMP, or WAMP.


### Why don't you automatically load the latest version of jQuery from the Google CDN?

1. The latest version of jQuery may not be compatible with the existing
   plugins/code on the site. Version updating should be an intentional
   decision.
2. The latest version has a very short `max-age=3600` compares to the specific
   version of `max-age=31536000`, which means you won't get the benefits of
   long-term caching.


### Why is the Google Analytics code at the bottom? Google recommends it be placed the `head`.

The advantage to placing it in the `head` is that you will track a user's
pageview even if they leave the page before it has been fully loaded. However,
putting the code at the bottom keeps all the scripts together and reinforces
that scripts at the bottom are the right move.


### How can I integrate [Twitter Bootstrap](http://twitter.github.com/bootstrap/) with HTML5 Boilerplate?

You can use [Initializr](http://initializr.com) to create a custom build that
includes HTML5 Boilerplate with Twitter Bootstrap.

Read more about how [HTML5 Boilerplate and Twitter Bootstrap complement each
other](http://www.quora.com/Is-Bootstrap-a-complement-OR-an-alternative-to-HTML5-Boilerplate-or-viceversa/answer/Nicolas-Gallagher).


### How do I prevent phone numbers looking twice as large and having a Skype highlight?

If this is occurring, it is because a user has the Skype browser extension
installed.

Use the following CSS to prevent Skype from formatting the numbers on your
page:

```css
span.skype_pnh_container {
    display: none !important;
}

span.skype_pnh_print_container {
    display: inline !important;
}
```


### Do I need to upgrade my sites each time a new version of HTML5 Boilerplate is released?

No. You don't normally replace the foundations of a house once it has been
built. There is nothing stopping you from trying to work in the latest changes
but you'll have to assess the costs/benefits of doing so.


### Where can I get help for support questions?

Please ask for help on
[StackOverflow](http://stackoverflow.com/questions/tagged/html5boilerplate).

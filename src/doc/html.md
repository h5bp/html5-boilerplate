[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# The HTML

By default, HTML5 Boilerplate provides two `html` pages:

* [`index.html`](#indexhtml) - a default HTML skeleton that should form the
  basis of all pages on your website
* [`404.html`](#404html) - a placeholder 404 error page


## `index.html`


### The `no-js` class

The `no-js` class is provided in order to allow you to more easily and
explicitly add custom styles based on whether JavaScript is disabled
(`.no-js`) or enabled (`.js`). Using this technique also helps [avoid the
FOUC](http://paulirish.com/2009/avoiding-the-fouc-v3/).


## Language attribute

Please consider specifying the language of your content by adding the `lang`
attribute to `<html>` as in this example:

```html
<html class="no-js" lang="en">
```

### The order of the `<title>` and `<meta>` tags

The order in which the `<title>` and the `<meta>` tags are specified is
important because:

1) the charset declaration (`<meta charset="utf-8">`):

   * must be included completely within the [first 1024 bytes of the
     document](https://www.whatwg.org/specs/web-apps/current-work/multipage/semantics.html#charset)

   * should be specified as early as possible (before any content that could
     be controlled by an attacker, such as a `<title>` element) in order to
     avoid a potential [encoding-related security
     issue](https://code.google.com/p/doctype-mirror/wiki/ArticleUtf7) in
     Internet Explorer

2) the meta tag for compatibility mode
   (`<meta http-equiv="X-UA-Compatible" content="IE=edge">`):

   * [needs to be included before all other tags except for the `<title>` and
     the other `<meta>`
     tags](http://msdn.microsoft.com/en-us/library/cc288325.aspx)


### `X-UA-Compatible`

Internet Explorer 8/9/10 support [document compatibility
modes](http://msdn.microsoft.com/en-us/library/cc288325.aspx) that affect the
way webpages are interpreted and displayed. Because of this, even if your site's
visitor is using, let's say, Internet Explorer 9, it's possible that IE will not
use the latest rendering engine, and instead, decide to render your page using
the Internet Explorer 5.5 rendering engine.

Specifying the `X-UA-Compatible` meta tag:

```html
<meta http-equiv="X-UA-Compatible" content="IE=edge">
```

or sending the page with the following HTTP response header

```
X-UA-Compatible: IE=edge
```

will force Internet Explorer 8/9/10 to render the webpage in the highest
available mode in [the various cases when it may
not](https://hsivonen.fi/doctype/#ie8), and therefore, ensure that anyone
browsing your site is treated to the best possible user experience that
browser can offer.

If possible, we recommend that you remove the `meta` tag and send only the
HTTP response header as the `meta` tag will not always work if your site is
served on a non-standard port, as Internet Explorer's preference option
`Display intranet sites in Compatibility View` is checked by default.

If you are using Apache as your webserver, including the
[`.htaccess`](https://github.com/h5bp/server-configs-apache) file takes care of
the HTTP header. If you are using a different server, check out our [other
server config](https://github.com/h5bp/server-configs).

Starting with Internet Explorer 11, [document modes are
deprecated](http://msdn.microsoft.com/en-us/library/ie/bg182625.aspx#docmode).
If your business still relies on older web apps and services that were
designed for older versions of Internet Explorer, you might want to consider
enabling [Enterprise Mode](http://blogs.msdn.com/b/ie/archive/2014/04/02/stay-up-to-date-with-enterprise-mode-for-internet-explorer-11.aspx) throughout your company.


## Mobile viewport

There are a few different options that you can use with the [`viewport` meta
tag](https://docs.google.com/present/view?id=dkx3qtm_22dxsrgcf4 "Viewport and
Media Queries - The Complete Idiot's Guide"). You can find out more in [the
Apple developer docs](https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariWebContent/UsingtheViewport/UsingtheViewport.html).
HTML5 Boilerplate comes with a simple setup that strikes a good balance for general use cases.

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

## Favicons and Touch Icon

The shortcut icons should be put in the root directory of your site. HTML5
Boilerplate comes with a default set of icons (include favicon and one Apple
Touch Icon) that you can use as a baseline to create your own.

Please refer to the more detailed description in the [Extend section](extend.md)
of these docs.

## Modernizr

HTML5 Boilerplate uses a custom build of Modernizr.

[Modernizr](http://modernizr.com) is a JavaScript library which adds classes to
the `html` element based on the results of feature test and which ensures that
all browsers can make use of HTML5 elements (as it includes the HTML5 Shiv).
This allows you to target parts of your CSS and JavaScript based on the
features supported by a browser.

In general, in order to keep page load times to a minimum, it's best to call
any JavaScript at the end of the page because if a script is slow to load
from an external server it may cause the whole page to hang. That said, the
Modernizr script *needs* to run *before* the browser begins rendering the page,
so that browsers lacking support for some of the new HTML5 elements are able to
handle them properly. Therefore the Modernizr script is the only JavaScript
file synchronously loaded at the top of the document.

## What about polyfills?

If you need to include [polyfills](https://remysharp.com/2010/10/08/what-is-a-polyfill)
in your project, you must make sure those load before any other JavaScript. If you're
using some polyfill CDN service, like [cdn.polyfill.io](http://cdn.polyfill.io/),
just put it before the other scripts in the bottom of the page:

```html
    <script src="//cdn.polyfill.io/v1/polyfill.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
```

If you like to just include the polyfills yourself, you could include them in
`js/plugins.js`. When you have a bunch of polyfills to load in, you could
also create a `polyfills.js` file in the `js/vendor` directory. Also using
this technique, make sure the polyfills are all loaded before any other
Javascript.

There are some misconceptions about Modernizr and polyfills. It's important
to understand that Modernizr just handles feature checking, not polyfilling
itself. The only thing Modernizr does regarding polyfills is that the team
maintains [a huge list of cross Browser polyfills](https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-Browser-Polyfills).

## The content area

The central part of the boilerplate template is pretty much empty. This is
intentional, in order to make the boilerplate suitable for both web page and
web app development.

### Browser Upgrade Prompt

The main content area of the boilerplate includes a prompt to install an up to
date browser for users of IE 6/7. If you intended to support IE 6/7, then you
should remove the snippet of code.

### Google CDN for jQuery

The Google CDN version of the jQuery JavaScript library is referenced towards
the bottom of the page using a protocol-independent path (read more about this
in the [FAQ](faq.md)). A local fallback of jQuery is included for rare instances
when the CDN version might not be available, and to facilitate offline
development.

The Google CDN version is chosen over other [potential candidates (like the
jQuery CDN](https://jquery.com/download/#using-jquery-with-a-cdn)) because
it's fast in absolute terms and it has the best overall
[penetration](http://httparchive.org/trends.php#perGlibs) which increases the
odds of having a copy of the library in your user's browser cache.

While the Google CDN is a strong default solution your site or application may
require a different configuration. Testing your site with services like
[WebPageTest](http://www.webpagetest.org/) and browser tools like
[PageSpeed Insights](https://developers.google.com/speed/pagespeed/insights/) or
[YSlow](https://developer.yahoo.com/yslow/) will help you examine the real
world performance of your site and can show where you can optimize your specific
site or application.


### Google Universal Analytics Tracking Code

Finally, an optimized version of the Google Universal Analytics tracking code is
included. Google recommends that this script be placed at the top of the page.
Factors to consider: if you place this script at the top of the page, you’ll
be able to count users who don’t fully load the page, and you’ll incur the max
number of simultaneous connections of the browser.

Further information:

* [Optimizing the Google Universal Analytics
  Snippet](https://mathiasbynens.be/notes/async-analytics-snippet#universal-analytics)
* [Introduction to
  Analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs/)
* [Google Analytics Demos & Tools](https://ga-dev-tools.appspot.com/)

**N.B.** The Google Universal Analytics snippet is included by default mainly
because Google Analytics is [currently one of the most popular tracking
solutions](https://trends.builtwith.com/analytics/Google-Analytics) out there.
However, its usage isn't set in stone, and you SHOULD consider exploring the
[alternatives](https://en.wikipedia.org/wiki/List_of_web_analytics_software)
and use whatever suits your needs best!

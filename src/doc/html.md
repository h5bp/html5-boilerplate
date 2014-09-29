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


## X-UA-Compatible

This makes sure the latest version of IE is used in versions of IE that contain
multiple rendering engines. Even if a site visitor is using IE8 or IE9, it's
possible that they're not using the latest rendering engine their browser
contains. To fix this, use:

```html
<meta http-equiv="X-UA-Compatible" content="IE=edge">
```

The `meta` tag tells the IE rendering engine it should use the latest, or edge,
version of the IE rendering environment.

This `meta` tag ensures that anyone browsing your site in IE is treated to the
best possible user experience that their browser can offer.

This line breaks validation. To avoid this edge case issue it is recommended
that you **remove this line and use the
[`.htaccess`](https://github.com/h5bp/server-configs-apache)** (or [other server
config](https://github.com/h5bp/server-configs)) to send these headers instead.
You also might want to read [Validating:
X-UA-Compatible](https://groups.google.com/group/html5boilerplate/browse_thread/thread/6d1b6b152aca8ed2).

If you are serving your site on a non-standard port, you will need to set this
header on the server-side. This is because the IE preference option 'Display
intranet sites in Compatibility View' is checked by default.


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

**N.B.** The Google Universal Analytics snippet is included by default mainly
because Google Analytics is [currently one of the most popular tracking
solutions](https://trends.builtwith.com/analytics/Google-Analytics) out there.
However, its usage isn't set in stone, and you SHOULD consider exploring the
[alternatives](https://en.wikipedia.org/wiki/List_of_web_analytics_software)
and use whatever suits your needs best!

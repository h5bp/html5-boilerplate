[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# The HTML

By default, HTML5 Boilerplate provides two `html` pages:

* [`index.html`](#indexhtml) - a default HTML skeleton that should form the
  basis of all pages on your website
* `404.html` - a placeholder 404 error page


## `index.html`


### The `no-js` Class

The `no-js` class is provided in order to allow you to more easily and
explicitly add custom styles based on whether JavaScript is disabled
(`.no-js`) or enabled (`.js`). Using this technique also helps [avoid the
FOUC](https://www.paulirish.com/2009/avoiding-the-fouc-v3/).


## Language Attribute

Please consider specifying the language of your content by adding a [value](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry) to the `lang`
attribute in the `<html>` as in this example:

```html
<html class="no-js" lang="en">
```

### The order of the `<title>` and `<meta>` tags

The charset declaration (`<meta charset="utf-8">`) must be included completely 
within the [first 1024 bytes of the document](https://www.whatwg.org/specs/web-apps/current-work/multipage/semantics.html#charset)
and should be specified as early as possible (before any content that could
be controlled by an attacker, such as a `<title>` element) in order to avoid a 
potential [encoding-related security issue](https://code.google.com/archive/p/doctype-mirror/wikis/ArticleUtf7.wiki)
in Internet Explorer

## Meta Description

The `description` meta tag provides a short description of the page. 
In some situations this description is used as a part of the snippet 
shown in the search results.

```html
<meta name="description" content="This is a description">
```

Google's [Create good meta descriptions](https://support.google.com/webmasters/answer/35624?hl=en#meta-descriptions)
documentation has useful tips on creating an effective description.

## Mobile Viewport

There are a few different options that you can use with the [`viewport` meta
tag](https://docs.google.com/present/view?id=dkx3qtm_22dxsrgcf4 "Viewport and
Media Queries - The Complete Idiot's Guide"). You can find out more in [the
MDN Web Docs](https://developer.mozilla.org/en-US/docs/Mozilla/Mobile/Viewport_meta_tag).
HTML5 Boilerplate comes with a simple setup that strikes a good balance for general use cases.

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

If you want to take advantage of edge-to-edge displays of iPhone X/XS/XR you can do
so with additional viewport parameters. [Check the WebKit blog](https://webkit.org/blog/7929/designing-websites-for-iphone-x/) 
for details.

## Web App Manifest

HTML5 Boilerplate includes a simple web app manifest file. 

The web app manifest is a simple JSON file that allows you to control how your 
app appears on a device's home screen, what it looks like when it launches
in that context and what happens when it is launched. This allows for much greater
control over the UI of a saved site or web app on a mobile device. 

It's linked to from the HTML as follows:

```html
        <link rel="manifest" href="site.webmanifest">
```
Our [site.webmanifest](https://github.com/h5bp/html5-boilerplate/blob/master/src/site.webmanifest) contains a very skeletal "app" definition, just to show the basic usage. 
You should fill this file out with [more information about your site or application](https://developer.mozilla.org/en-US/docs/Web/Manifest)

## Favicons and Touch Icon

The shortcut icons should be put in the root directory of your site. `favicon.ico` 
is automatically picked up by browsers if it's placed in the root.  HTML5
Boilerplate comes with a default set of icons (include favicon and one Apple
Touch Icon) that you can use as a baseline to create your own.

Please refer to the more detailed description in the [Extend section](extend.md)
of these docs.

## The Content Area

The central part of the boilerplate template is pretty much empty. This is
intentional, in order to make the boilerplate suitable for both web page and
web app development.

### Browser Upgrade Prompt

The main content area of the boilerplate includes a prompt to install an up to
date browser for users of IE 9 and lower. If you intended to support IE, then you
should edit or remove the snippet of code.

## Modernizr

HTML5 Boilerplate uses a custom build of Modernizr.

[Modernizr](https://modernizr.com/) is a JavaScript library which adds classes to
the `html` element based on the results of feature test and which ensures that
all browsers can make use of HTML5 elements (as it includes the HTML5 Shiv).
This allows you to target parts of your CSS and JavaScript based on the
features supported by a browser.

Starting with version 3 Modernizr can be customized using the [modernizr-config.json](https://github.com/h5bp/html5-boilerplate/blob/master/modernizr-config.json) and the
[Modernizr command line utility](https://www.npmjs.com/package/modernizr-cli). 

## What About Polyfills?

If you need to include [polyfills](https://remysharp.com/2010/10/08/what-is-a-polyfill)
in your project, you must make sure those load before any other JavaScript. If you're
using a polyfill CDN service, like [cdn.polyfill.io](https://cdn.polyfill.io/),
just put it before the other scripts in the bottom of the page:

```html
    <script src="js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="https://cdn.polyfill.io/v3/polyfill.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
```

If you like to just include the polyfills yourself, you could include them in
`js/plugins.js`. When you have a bunch of polyfills to load in, you could
also create a `polyfills.js` file in the `js/vendor` directory or include the files 
individually and combine them using a build tool. Always ensure that the polyfills 
are all loaded before any other JavaScript.

There are some misconceptions about Modernizr and polyfills. It's important
to understand that Modernizr just handles feature checking, not polyfilling
itself. The only thing Modernizr does regarding polyfills is that the team
maintains [a huge list of cross Browser polyfills](https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-Browser-Polyfills).

### jQuery CDN for jQuery

The jQuery CDN version of the jQuery JavaScript library is referenced towards
the bottom of the page. A local fallback of jQuery is included for rare instances
when the CDN version might not be available, and to facilitate offline
development.

The jQuery CDN version was chosen over other potential candidates
([like Google's Hosted Libraries](https://developers.google.com/speed/libraries/))
because it's fast ([comparable or faster than Google by some
measures](https://www.cdnperf.com/#jsdelivr,cdnjs,google,yandex,microsoft,jquery,bootstrapcdn/https/90))
and, (unlike Google's CDN) is available to China's hundreds of millions of internet users.
For many years we [chose](https://github.com/h5bp/html5-boilerplate/issues/1191)
the Google Hosted version over the jQuery CDN because it was available
over HTTPS (the jQuery CDN was not,) and it offered a better chance of
hitting the cache lottery owing to the popularity of the Google CDN.
The first issue is no longer valid and the second is far outweighed by
being able to serve jQuery to users in China.

While the jQuery CDN is a strong default solution your site or application may
require a different configuration. Testing your site with services like
[WebPageTest](https://www.webpagetest.org/) and browser tools like
[PageSpeed Insights](https://developers.google.com/speed/pagespeed/insights/) will help you examine the real
world performance of your site and can show where you can optimize your specific
site or application.

### Google Universal Analytics Tracking Code

Finally, an optimized version of the Google Universal Analytics tracking code is
included.

We use `analytics.js` rather than the newer `gtag.js` as 
[it's faster and supports tasks and plugins](https://github.com/philipwalton/analyticsjs-boilerplate/issues/19#issuecomment-333714370)

The beacon transport mechanism is used to send all hits [which saves HTTP requests and improves performance](https://philipwalton.com/articles/the-google-analytics-setup-i-use-on-every-site-i-build/#loading-analytics.js).

Google recommends that this script be placed at the top of the page.
Factors to consider: if you place this script at the top of the page, you’ll
be able to count users who don’t fully load the page, and you’ll incur the max
number of simultaneous connections of the browser.

Further information:

- [Introduction to
  Analytics.js](https://developers.google.com/analytics/devguides/collection/analyticsjs/)
- [Google Analytics Demos & Tools](https://ga-dev-tools.appspot.com/)

**N.B.** The Google Analytics snippet is included by default mainly
because Google Analytics is [currently one of the most popular tracking
solutions](https://trends.builtwith.com/analytics/Google-Analytics) out there.
However, its usage isn't set in stone, and you SHOULD consider exploring the
[alternatives](https://en.wikipedia.org/wiki/List_of_web_analytics_software)
and use whatever suits your needs best.



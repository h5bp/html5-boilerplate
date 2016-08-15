[HTML5 Boilerplate homepage](https://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Extend and customise HTML5 Boilerplate

Here is some useful advice for how you can make your project with HTML5
Boilerplate even better. We don't want to include it all by default, as
not everything fits with everyone's needs.


* [App Stores](#app-stores)
* [DNS prefetching](#dns-prefetching)
* [Google Universal Analytics](#google-universal-analytics)
* [Internet Explorer](#internet-explorer)
* [Miscellaneous](#miscellaneous)
* [News Feeds](#news-feeds)
* [Search](#search)
* [Social Networks](#social-networks)
* [URLs](#urls)
* [Web Apps](#web-apps)


## App Stores

### Install a Chrome Web Store app

Users can install a Chrome app directly from your website, as long as
the app and site have been associated via Google's Webmaster Tools.
Read more on [Chrome Web Store's Inline Installation
docs](https://developer.chrome.com/webstore/inline_installation).

```html
<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/APP_ID">
```

### Smart App Banners in iOS 6+ Safari

Stop bothering everyone with gross modals advertising your entry in the
App Store. Include the following [meta tag](https://developer.apple.com/library/IOS/documentation/AppleApplications/Reference/SafariWebContent/PromotingAppswithAppBanners/PromotingAppswithAppBanners.html#//apple_ref/doc/uid/TP40002051-CH6-SW2)
will unintrusively allow the user the option to download your iOS app,
or open it with some data about the user's current state on the website.

```html
<meta name="apple-itunes-app" content="app-id=APP_ID,app-argument=SOME_TEXT">
```

## DNS prefetching

In short, DNS Prefetching is a method of informing the browser of domain names
referenced on a site so that the client can resolve the DNS for those hosts,
cache them, and when it comes time to use them, have a faster turn around on
the request.

### Implicit prefetches

There is a lot of prefetching done for you automatically by the browser. When
the browser encounters an anchor in your html that does not share the same
domain name as the current location the browser requests, from the client OS,
the IP address for this new domain. The client first checks its cache and
then, lacking a cached copy, makes a request from a DNS server. These requests
happen in the background and are not meant to block the rendering of the
page.

The goal of this is that when the foreign IP address is finally needed it will
already be in the client cache and will not block the loading of the foreign
content. Fewer requests result in faster page load times. The perception of this
is increased on a mobile platform where DNS latency can be greater.

#### Disable implicit prefetching

```html
<meta http-equiv="x-dns-prefetch-control" content="off">
```

Even with X-DNS-Prefetch-Control meta tag (or http header) browsers will still
prefetch any explicit dns-prefetch links.

**_WARNING:_** THIS MAY MAKE YOUR SITE SLOWER IF YOU RELY ON RESOURCES FROM
FOREIGN DOMAINS.

### Explicit prefetches

Typically the browser only scans the HTML for foreign domains. If you have
resources that are outside of your HTML (a javascript request to a remote
server or a CDN that hosts content that may not be present on every page of
your site, for example) then you can queue up a domain name to be prefetched.

```html
<link rel="dns-prefetch" href="//example.com">
<link rel="dns-prefetch" href="https://ajax.googleapis.com">
```

You can use as many of these as you need, but it's best if they are all
immediately after the [Meta
Charset](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta#attr-charset)
element (which should go right at the top of the `head`), so the browser can
act on them ASAP.

#### Common Prefetch Links

Amazon S3:

```html
<link rel="dns-prefetch" href="//s3.amazonaws.com">
```

Google APIs:

```html
<link rel="dns-prefetch" href="https://ajax.googleapis.com">
```

Microsoft Ajax Content Delivery Network:

```html
<link rel="dns-prefetch" href="//ajax.microsoft.com">
<link rel="dns-prefetch" href="//ajax.aspnetcdn.com">
```

### Further reading about DNS prefetching

* https://developer.mozilla.org/en-US/docs/Controlling_DNS_prefetching
* https://dev.chromium.org/developers/design-documents/dns-prefetching
* https://blogs.msdn.microsoft.com/ie/2011/03/17/internet-explorer-9-network-performance-improvements/
* http://dayofjs.com/videos/22158462/web-browsers_alex-russel


## Google Universal Analytics

### More tracking settings

The [optimized Google Universal Analytics
snippet](https://mathiasbynens.be/notes/async-analytics-snippet#universal-analytics)
included with HTML5 Boilerplate includes something like this:

```js
ga('create', 'UA-XXXXX-X', 'auto'); ga('send', 'pageview');
```

To customize further, see Google's [Advanced
Setup](https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced),
[Pageview](https://developers.google.com/analytics/devguides/collection/analyticsjs/pages),
and [Event](https://developers.google.com/analytics/devguides/collection/analyticsjs/events) Docs.

### Anonymize IP addresses

In some countries, no personal data may be transferred outside jurisdictions
that do not have similarly strict laws (i.e. from Germany to outside the EU).
Thus a webmaster using the Google Universal Analytics may have to ensure that
no personal (trackable) data is transferred to the US. You can do that with
[the `ga('set', 'anonymizeIp', true);`
parameter](https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced#anonymizeip)
before sending any events/pageviews. In use it looks like this:

```js
ga('create', 'UA-XXXXX-X', 'auto');
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');
```

### Track jQuery AJAX requests in Google Analytics

An article by @JangoSteve explains how to [track jQuery AJAX requests in Google
Analytics](https://www.alfajango.com/blog/track-jquery-ajax-requests-in-google-analytics/).

Add this to `plugins.js`:

```js
/*
 * Log all jQuery AJAX requests to Google Analytics
 * See: https://www.alfajango.com/blog/track-jquery-ajax-requests-in-google-analytics/
 */
if (typeof ga !== "undefined" && ga !== null) {
    $(document).ajaxSend(function(event, xhr, settings){
        ga('send', 'pageview', settings.url);
    });
}
```

### Track JavaScript errors in Google Analytics

Add this function after `ga` is defined:

```js
(function(window){
    var undefined,
        link = function (href) {
            var a = window.document.createElement('a');
            a.href = href;
            return a;
        };
    window.onerror = function (message, file, line, column) {
        var host = link(file).hostname;
        ga('send', {
          'hitType': 'event',
          'eventCategory': (host == window.location.hostname || host == undefined || host == '' ? '' : 'external ') + 'error',
          'eventAction': message,
          'eventLabel': (file + ' LINE: ' + line + (column ? ' COLUMN: ' + column : '')).trim(),
          'nonInteraction': 1
        });
    };
}(window));
```

### Track page scroll

Add this function after `ga` is defined:

```js
$(function(){
    var isDuplicateScrollEvent,
        scrollTimeStart = new Date,
        $window = $(window),
        $document = $(document),
        scrollPercent;

    $window.scroll(function() {
        scrollPercent = Math.round(100 * ($window.height() + $window.scrollTop())/$document.height());
        if (scrollPercent > 90 && !isDuplicateScrollEvent) { //page scrolled to 90%
            isDuplicateScrollEvent = 1;
            ga('send', 'event', 'scroll',
                'Window: ' + $window.height() + 'px; Document: ' + $document.height() + 'px; Time: ' + Math.round((new Date - scrollTimeStart )/1000,1) + 's'
            );
        }
    });
});
```

## Internet Explorer

### Prompt users to switch to "Desktop Mode" in IE10 Metro

IE10 does not support plugins, such as Flash, in Metro mode. If
your site requires plugins, you can let users know that via the
`x-ua-compatible` meta element, which will prompt them to switch
to Desktop Mode.

```html
<meta http-equiv="x-ua-compatible" content="requiresActiveX=true">
```

Here's what it looks like alongside H5BP's default `x-ua-compatible`
values:

```html
<meta http-equiv="x-ua-compatible" content="ie=edge,requiresActiveX=true">
```

You can find more information in [Microsoft's IEBlog post about prompting for
plugin use in IE10 Metro
Mode](https://blogs.msdn.microsoft.com/ie/2012/01/31/web-sites-and-a-plug-in-free-web/).

### IE Pinned Sites (IE9+)

Enabling your application for pinning will allow IE9 users to add it to their
Windows Taskbar and Start Menu. This comes with a range of new tools that you
can easily configure with the elements below. See more [documentation on IE9
Pinned Sites](https://msdn.microsoft.com/en-us/library/gg131029.aspx).

### Name the Pinned Site for Windows

Without this rule, Windows will use the page title as the name for your
application.

```html
<meta name="application-name" content="Sample Title">
```

### Give your Pinned Site a tooltip

You know — a tooltip. A little textbox that appears when the user holds their
mouse over your Pinned Site's icon.

```html
<meta name="msapplication-tooltip" content="A description of what this site does.">
```

### Set a default page for your Pinned Site

If the site should go to a specific URL when it is pinned (such as the
homepage), enter it here. One idea is to send it to a special URL so you can
track the number of pinned users, like so:
`http://www.example.com/index.html?pinned=true`

```html
<meta name="msapplication-starturl" content="http://www.example.com/index.html?pinned=true">
```

### Recolor IE's controls manually for a Pinned Site

IE9+ will automatically use the overall color of your Pinned Site's favicon to
shade its browser buttons. UNLESS you give it another color here. Only use
named colors (`red`) or hex colors (`#ff0000`).

```html
<meta name="msapplication-navbutton-color" content="#ff0000">
```

### Manually set the window size of a Pinned Site

If the site should open at a certain window size once pinned, you can specify
the dimensions here. It only supports static pixel dimensions. 800x600
minimum.

```html
<meta name="msapplication-window" content="width=800;height=600">
```

### Jump List "Tasks" for Pinned Sites

Add Jump List Tasks that will appear when the Pinned Site's icon gets a
right-click. Each Task goes to the specified URL, and gets its own mini icon
(essentially a favicon, a 16x16 .ICO). You can add as many of these as you
need.

```html
<meta name="msapplication-task" content="name=Task 1;action-uri=http://host/Page1.html;icon-uri=http://host/icon1.ico">
<meta name="msapplication-task" content="name=Task 2;action-uri=http://microsoft.com/Page2.html;icon-uri=http://host/icon2.ico">
```

### (Windows 8) High quality visuals for Pinned Sites

Windows 8 adds the ability for you to provide a PNG tile image and specify the
tile's background color. [Full details on the IE
blog](https://blogs.msdn.microsoft.com/ie/2012/06/08/high-quality-visuals-for-pinned-sites-in-windows-8/).

* Create a 144x144 image of your site icon, filling all of the canvas, and
  using a transparent background.
* Save this image as a 32-bit PNG and optimize it without reducing
  colour-depth. It can be named whatever you want (e.g. `metro-tile.png`).
* To reference the tile and its color, add the HTML `meta` elements described
  in the IE Blog post.

### (Windows 8) Badges for Pinned Sites

IE10 will poll an XML document for badge information to display on your app's
tile in the Start screen. The user will be able to receive these badge updates
even when your app isn't actively running. The badge's value can be a number,
or one of a predefined list of glyphs.

* [Tutorial on IEBlog with link to badge XML schema](https://blogs.msdn.microsoft.com/ie/2012/04/03/pinned-sites-in-windows-8/)
* [Available badge values](https://msdn.microsoft.com/en-us/library/ie/br212849.aspx)

```html
<meta name="msapplication-badge" value="frequency=NUMBER_IN_MINUTES;polling-uri=http://www.example.com/path/to/file.xml">
```

### Disable link highlighting upon tap in IE10

Similar to [-webkit-tap-highlight-color](https://davidwalsh.name/mobile-highlight-color)
in iOS Safari. Unlike that CSS property, this is an HTML meta element, and its
value is boolean rather than a color. It's all or nothing.

```html
<meta name="msapplication-tap-highlight" content="no" />
```

You can read about this useful element and more techniques in
[Microsoft's documentation on adapting WebKit-oriented apps for IE10](https://blogs.windows.com/buildingapps/2012/11/15/adapting-your-webkit-optimized-site-for-internet-explorer-10/)

## Search

### Direct search spiders to your sitemap

[Learn how to make a sitemap](http://www.sitemaps.org/protocol.html)

```html
<link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
```

### Hide pages from search engines

According to Heather Champ, former community manager at Flickr, you should not
allow search engines to index your "Contact Us" or "Complaints" page if you
value your sanity. This is an HTML-centric way of achieving that.

```html
<meta name="robots" content="noindex">
```

**_WARNING:_** DO NOT INCLUDE ON PAGES THAT SHOULD APPEAR IN SEARCH ENGINES.

### Firefox and IE Search Plugins

Sites with in-site search functionality should be strongly considered for a
browser search plugin. A "search plugin" is an XML file which defines how your
plugin behaves in the browser. [How to make a browser search
plugin](https://www.google.com/search?ie=UTF-8&q=how+to+make+browser+search+plugin).

```html
<link rel="search" title="" type="application/opensearchdescription+xml" href="">
```


## Miscellaneous

* Use [polyfills](https://github.com/Modernizr/Modernizr/wiki/HTML5-Cross-browser-Polyfills).

* Use [Microformats](http://microformats.org/wiki/Main_Page) (via
  [microdata](http://microformats.org/wiki/microdata)) for optimum search
  results
  [visibility](https://webmasters.googleblog.com/2009/05/introducing-rich-snippets.html).

* If you're building a web app you may want [native style momentum scrolling in
  iOS 5+](http://www.johanbrook.com/articles/native-style-momentum-scrolling-to-arrive-in-ios-5/)
  using `-webkit-overflow-scrolling: touch`.

* If you want to disable the translation prompt in Chrome or block Google
  Translate from translating your web page, use [`<meta name="google"
  value="notranslate">`](https://support.google.com/translate/?hl=en#2641276).
  To disable translation for a particular section of the web page, add
  [`class="notranslate"`](https://support.google.com/translate/?hl=en#2641276).

* If you want to disable the automatic detection and formatting of possible
  phone numbers in Safari on iOS, use [`<meta name="format-detection"
  content="telephone=no">`](https://developer.apple.com/library/safari/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html/#//apple_ref/doc/uid/TP40008193-SW5).

* Avoid development/stage websites "leaking" into SERPs (search engine results
  page) by [implementing X-Robots-tag
  headers](https://github.com/h5bp/html5-boilerplate/issues/804).

* Screen readers currently have less-than-stellar support for HTML5 but the JS
  script [accessifyhtml5.js](https://github.com/yatil/accessifyhtml5.js) can
  help increase accessibility by adding ARIA roles to HTML5 elements.


## News Feeds

### RSS

Have an RSS feed? Link to it here. Want to [learn how to write an RSS feed from
scratch](http://www.rssboard.org/rss-specification)?

```html
<link rel="alternate" type="application/rss+xml" title="RSS" href="/rss.xml">
```

### Atom

Atom is similar to RSS, and you might prefer to use it instead of or in
addition to it. [See what Atom's all
about](http://www.atomenabled.org/developers/syndication/).

```html
<link rel="alternate" type="application/atom+xml" title="Atom" href="/atom.xml">
```

### Pingbacks

Your server may be notified when another site links to yours. The href
attribute should contain the location of your pingback service.

```html
<link rel="pingback" href="">
```

* High-level explanation: https://codex.wordpress.org/Introduction_to_Blogging#Pingbacks
* Step-by-step example case: http://www.hixie.ch/specs/pingback/pingback-1.0#TOC5
* PHP pingback service: https://web.archive.org/web/20131211032834/http://blog.perplexedlabs.com/2009/07/15/xmlrpc-pingbacks-using-php/



## Social Networks

### Facebook Open Graph data

You can control the information that Facebook and others display when users
share your site. Below are just the most basic data points you might need. For
specific content types (including "website"), see [Facebook's built-in Open
Graph content
templates](https://developers.facebook.com/docs/opengraph/objects/builtin/).
Take full advantage of Facebook's support for complex data and activity by
following the [Open Graph
tutorial](https://developers.facebook.com/docs/opengraph/tutorial/).

For a reference of Open Graph's markup and properties, you may check
[Facebook's Open Graph Protocol reference](http://ogp.me/). Finally,
you can validate your markup with the [Facebook Object
Debugger](https://developers.facebook.com/tools/debug/) (needs
registration to Facebook).

```html
<meta property="fb:app_id" content="123456789">
<meta property="og:url" content="http://www.example.com/path/to/page.html">
<meta property="og:type" content="website">
<meta property="og:title" content="">
<meta property="og:image" content="http://www.example.com/path/to/image.jpg">
<meta property="og:description" content="">
<meta property="og:site_name" content="">
<meta property="article:author" content="">
```

### Twitter Cards

Twitter provides a snippet specification that serves a similar purpose to Open
Graph. In fact, Twitter will use Open Graph when Cards is not available. Note
that, as of this writing, Twitter requires that app developers activate Cards
on a per-domain basis. You can read more about the various snippet formats
and application process in the [official Twitter Cards
documentation](https://dev.twitter.com/docs/cards), and you can validate
your markup with the [Card validator](https://cards-dev.twitter.com/validator)
(needs registration to Twitter).

```html
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@site_account">
<meta name="twitter:creator" content="@individual_account">
<meta name="twitter:url" content="http://www.example.com/path/to/page.html">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="http://www.example.com/path/to/image.jpg">
```

### Google+ / Schema.org

Google also provides a snippet specification that serves a similar
purpose to Facebook's Open Graph or Twitter Cards. While it helps you
to control information displayed on Google+, this metadata is a subset
of [schema.org's microdata vocabulary](https://schema.org/), which
covers many other schemas that can describe the content of your pages
to search engines. For this reason, this metadata is more generic for
SEO, notably for Google's search-engine, although this vocabulary is
also used by Microsoft, Pinterest or Yandex.

You can validate your markup with the [Structured Data Testing
Tool](https://developers.google.com/structured-data/testing-tool/).
Also, please note that this markup requires to add attributes to your
top `html` tag.

```html
<html class="no-js" lang="" itemscope itemtype="http://schema.org/Article">
    <head>

        <link rel="author" href="">
        <link rel="publisher" href="">
        <meta itemprop="name" content="">
        <meta itemprop="description" content="">
        <meta itemprop="image" content="">
```

## URLs

### Canonical URL

Signal to search engines and others "Use this URL for this page!" Useful when
parameters after a `#` or `?` is used to control the display state of a page.
`http://www.example.com/cart.html?shopping-cart-open=true` can be indexed as
the cleaner, more accurate `http://www.example.com/cart.html`.

```html
<link rel="canonical" href="">
```

### Official shortlink

Signal to the world "This is the shortened URL to use this page!" Poorly
supported at this time. Learn more by reading the [article about shortlinks on
the Microformats wiki](http://microformats.org/wiki/rel-shortlink).

```html
<link rel="shortlink" href="h5bp.com">
```

### Separate mobile URLs

If you use separate URLs for desktop and mobile users, you should consider
helping search engine algorithms better understand the configuration on your
web site.

This can be done by adding the following annotations in your HTML pages:

* on the desktop page, add the `link rel="alternate"` tag pointing to the
  corresponding mobile URL, e.g.:

  `<link rel="alternate" media="only screen and (max-width: 640px)" href="http://m.example.com/page.html" >`

* on the mobile page, add the `link rel="canonical"` tag pointing to the
  corresponding desktop URL, e.g.:

  `<link rel="canonical" href="http://www.example.com/page.html">`

For more information please see:

* https://developers.google.com/webmasters/smartphone-sites/details#separateurls
* https://developers.google.com/webmasters/smartphone-sites/feature-phones


## Web Apps

There are a couple of meta tags that provide information about a web app when
added to the Home Screen on iOS:

* Adding `apple-mobile-web-app-capable` will make your web app chrome-less and
provide the default iOS app view. You can control the color scheme of the
default view by adding `apple-mobile-web-app-status-bar-style`.

  ```html
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
```

* You can use `apple-mobile-web-app-title` to add a specific sites name for the
Home Screen icon. This works since iOS 6.

  ```html
<meta name="apple-mobile-web-app-title" content="">
```

For further information please read the [official
documentation](https://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html)
on Apple's site.


### Apple Touch Icons

The Apple touch icons can be seen as the favicons of iOS devices.

The main sizes of the Apple touch icons are:

* `57×57px` – iPhone with @1x display and iPod Touch
* `72×72px` – iPad and iPad mini with @1x display running iOS ≤ 6
* `76×76px` – iPad and iPad mini with @1x display running iOS ≥ 7
* `114×114px` – iPhone with @2x display running iOS ≤ 6
* `120×120px` – iPhone with @2x and @3x display running iOS ≥ 7
* `144×144px` – iPad and iPad mini with @2x display running iOS ≤ 6
* `152×152px` – iPad and iPad mini with @2x display running iOS 7
* `180×180px` – iPad and iPad mini with @2x display running iOS 8

Displays meaning:

* @1x - non-Retina
* @2x - Retina
* @3x - Retina HD

More information about the displays of iOS devices can be found
[here](https://en.wikipedia.org/wiki/List_of_iOS_devices#Display).

In most cases, one `180×180px` touch icon named `apple-touch-icon.png`
and including:

```html
<link rel="apple-touch-icon" href="apple-touch-icon.png">
```

in the `<head>` of the page is enough. If you use art-direction and/or
want to have different content for each device, you can add more touch
icons as written above.

For a more comprehensive overview, please refer to Mathias' [article on Touch
Icons](https://mathiasbynens.be/notes/touch-icons).


### Apple Touch Startup Image

Apart from that it is possible to add start-up screens for web apps on iOS. This
basically works by defining `apple-touch-startup-image` with an according link
to the image. Since iOS devices have different screen resolutions it is
necessary to add media queries to detect which image to load. Here is an
example for a retina iPhone:

```html
<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="img/startup-retina.png">
```

However, it is possible to detect which start-up image to use with JavaScript.
The Mobile Boilerplate provides a useful function for this. Please see
[helpers.js](https://github.com/h5bp/mobile-boilerplate/blob/v4.1.0/js/helper.js#L336-L383)
for the implementation.


### Chrome Mobile web apps

Chrome Mobile has a specific meta tag for making apps [installable to the
homescreen](https://developer.chrome.com/multidevice/android/installtohomescreen)
which tries to be a more generic replacement to Apple's proprietary meta tag:

```html
<meta name="mobile-web-app-capable" content="yes">
```

Same applies to the touch icons:

```html
<link rel="icon" sizes="192x192" href="highres-icon.png">
```

### Theme Color

You can add the [`theme-color` meta extension](https://html.spec.whatwg.org/multipage/semantics.html#meta-theme-color)
in the `<head>` of your pages to suggest the color that browsers and
OSes should use if they customize the display of individual pages in
their UIs with varying colors.

```html
<meta name="theme-color" content="#ff69b4">
```

The `content` attribute extension can take any valid CSS color.

Currently, the `theme-color` meta extension is supported by [Chrome 39+
for Android Lollipop](https://developers.google.com/web/updates/2014/11/Support-for-theme-color-in-Chrome-39-for-Android)
and [Firefox OS 2.1+](https://twitter.com/ahmednefzaoui/status/492344698493997057).

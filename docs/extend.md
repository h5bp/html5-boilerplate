[HTML5 Boilerplate homepage](https://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Extend and customize HTML5 Boilerplate

Here is some useful advice for how you can make your project with HTML5
Boilerplate even better. We don't want to include it all by default, as not
everything fits with everyone's needs.

- [Server Configuration](#server-configuration)
- [App Stores](#app-stores)
- [DNS prefetching](#dns-prefetching)
- [Miscellaneous](#miscellaneous)
- [News Feeds](#news-feeds)
- [Search](#search)
- [Social Networks](#social-networks)
- [URLs](#urls)
- [Web Apps](#web-apps)
- [security.txt](#securitytxt)

## Server Configuration

We no longer include a [`.htaccess`](#htaccess) file for the [Apache HTTP
server](https://httpd.apache.org/docs/) in HTML5 Boilerplate by default, however if you are
using a web server, then we encourage you to checkout out the [server configuration](https://github.com/h5bp/server-configs)
that corresponds to your web server and environment.

These repos offer a collection of configuration snippets that can help your server improve the
website's performance and security, while also ensuring that resources are served with the
correct content-type and are accessible, if needed, even cross-domain.

## App Stores

### Smart App Banners in iOS 6+ Safari

Stop bothering everyone with gross modals advertising your entry in the App
Store. Including the following [meta
tag](https://developer.apple.com/documentation/webkit/promoting_apps_with_smart_app_banners)
will unobtrusively give the user the option to download your iOS app, or open it
with some data about the user's current state on the website.

```html
<meta name="apple-itunes-app" content="app-id=APP_ID,app-argument=SOME_TEXT">
```

## DNS prefetching

In short, DNS Prefetching is a method of informing the browser of domain names
referenced on a site so that the client can resolve the DNS for those hosts,
cache them, and when it comes time to use them, have a faster turn around on the
request.

### Implicit prefetches

There is a lot of prefetching done for you automatically by the browser. When
the browser encounters an anchor in your HTML that does not share the same
domain name as the current location the browser requests, from the client OS,
the IP address for this new domain. The client first checks its cache and then,
lacking a cached copy, makes a request from a DNS server. These requests happen
in the background and are not meant to block the rendering of the page.

The goal of this is that when the foreign IP address is finally needed it will
already be in the client cache and will not block the loading of the foreign
content. Fewer requests result in faster page load times. The perception of this
is increased on a mobile platform where DNS latency can be greater.

### Explicit prefetches

Typically the browser only scans the HTML for foreign domains. If you have
resources that are outside of your HTML (a JavaScript request to a remote server
or a CDN that hosts content that may not be present on every page of your site,
for example) then you can queue up a domain name to be prefetched.

```html
<link rel="dns-prefetch" href="//example.com">
<link rel="dns-prefetch" href="https://ajax.googleapis.com">
```

You can use as many of these as you need, but it's best if they are all
immediately after the [Meta
Charset](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/meta#attr-charset)
element (which should go right at the top of the `head`), so the browser can act
on them ASAP.

### Further reading about DNS prefetching

- https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-DNS-Prefetch-Control
- https://dev.chromium.org/developers/design-documents/dns-prefetching

## Search

### Direct search spiders to your sitemap

After creating a [sitemap](https://www.sitemaps.org/protocol.html)

Submit it to search engine tool:

- [Google](https://www.google.com/webmasters/tools/sitemap-list)
- [Bing](https://www.bing.com/toolbox/webmaster)
- [Yandex](https://webmaster.yandex.com/)
- [Baidu](https://zhanzhang.baidu.com/) OR Insert the following line anywhere in
  your robots.txt file, specifying the path to your sitemap:

```
Sitemap: https://example.com/sitemap_location.xml
```

### Hide pages from search engines

According to Heather Champ, former community manager at Flickr, you should not
allow search engines to index your "Contact Us" or "Complaints" page if you
value your sanity. This is an HTML-centric way of achieving that.

```html
<meta name="robots" content="noindex">
```

**_WARNING:_** DO NOT INCLUDE ON PAGES THAT SHOULD APPEAR IN SEARCH ENGINES.

### Search Plugins

Sites with in-site search functionality should be strongly considered for a
browser search plugin. A "search plugin" is an XML file which defines how your
plugin behaves in the browser. [How to make a browser search
plugin](https://developer.mozilla.org/en-US/docs/Web/OpenSearch).

```html
<link rel="search" title="" type="application/opensearchdescription+xml" href="">
```

## Miscellaneous

- Use [Microformats](https://microformats.org/wiki/Main_Page) (via
  [microdata](https://microformats.org/wiki/microdata)) for optimum search
  results
  [visibility](https://developers.google.com/search/blog/2009/05/introducing-rich-snippets).

- If you want to disable the translation prompt in Chrome or block Google
  Translate from translating your web page, use [`<meta name="google"
content="notranslate">`](https://developers.google.com/search/docs/crawling-indexing/special-tags).
  To disable translation for a particular section of the web page, add
  [`class="notranslate"`](https://support.google.com/translate/?hl=en#2641276).

- If you want to disable the automatic detection and formatting of possible
  phone numbers in Safari on iOS, use [`<meta name="format-detection"
content="telephone=no">`](https://developer.apple.com/library/archive/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html).

- Avoid development/stage websites "leaking" into SERPs (search engine results
  page) by [implementing X-Robots-tag
  headers](https://github.com/h5bp/html5-boilerplate/issues/804).

- Apply JavaScript-dependent CSS styles using [the `scripting` media
  feature](https://developer.mozilla.org/en-US/docs/Web/CSS/@media/scripting).
  Use `@media (scripting: none) { ... }` to target browsers with JavaScript
  disabled, or `@media (scripting: enabled) { ... }` to target browsers with
  JavaScript enabled. Using this technique also helps [avoid the
  FOUC](https://www.paulirish.com/2009/avoiding-the-fouc-v3/).

## News Feeds

### RSS

Have an RSS feed? Link to it here. Want to [learn how to write an RSS feed from
scratch](https://www.rssboard.org/rss-specification)?

```html
<link rel="alternate" type="application/rss+xml" title="RSS" href="/rss.xml">
```

### Atom

Atom is similar to RSS, and you might prefer to use it instead of or in addition
to it. [See what Atom's all
about](<https://en.wikipedia.org/wiki/Atom_(Web_standard)>).

```html
<link rel="alternate" type="application/atom+xml" title="Atom" href="/atom.xml">
```

### Pingbacks

Your server may be notified when another site links to yours. The href attribute
should contain the location of your pingback service.

```html
<link rel="pingback" href="">
```

- High-level explanation:
  https://codex.wordpress.org/Introduction_to_Blogging#Pingbacks
- Step-by-step example case:
  https://www.hixie.ch/specs/pingback/pingback-1.0#TOC5
- PHP pingback service:
  https://web.archive.org/web/20131211032834/http://blog.perplexedlabs.com/2009/07/15/xmlrpc-pingbacks-using-php/

## Social Networks

### Facebook Open Graph data

You can control the information that Facebook and others display when users
share your site. Below are just the most basic data points you might need. For
specific content types (including "website"), see [Facebook's built-in Open
Graph content
templates](https://developers.facebook.com/docs/sharing/opengraph/using-objects).
Take full advantage of Facebook's support for complex data and activity by
following the [Open Graph
tutorial](https://developers.facebook.com/docs/sharing/webmasters/getting-started).

For a reference of Open Graph's markup and properties, you may check [Facebook's
Open Graph Protocol reference](https://ogp.me). Finally, you can validate your
markup with the [Facebook Object
Debugger](https://developers.facebook.com/tools/debug/) (needs registration to
Facebook).

```html
<meta property="fb:app_id" content="123456789">
<meta property="og:url" content="https://www.example.com/path/to/page.html">
<meta property="og:type" content="website">
<meta property="og:title" content="">
<meta property="og:image" content="https://www.example.com/path/to/image.jpg">
<!-- Empty for decorative images. -->
<meta property="og:image:alt" content="Example image depicting...">
<meta property="og:description" content="">
<meta property="og:site_name" content="">
<meta property="article:author" content="">
```

### Twitter Cards

Twitter provides a snippet specification that serves a similar purpose to Open
Graph. In fact, Twitter will use Open Graph when Cards is not available. You can
read more about the various snippet formats in the
[official Twitter Cards
documentation](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards).

```html
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@site_account">
<meta name="twitter:creator" content="@individual_account">
<meta name="twitter:url" content="https://www.example.com/path/to/page.html">
<meta name="twitter:title" content="">
<meta name="twitter:description" content="">
<meta name="twitter:image" content="https://www.example.com/path/to/image.jpg">
```

### Schema.org

Google also provides a snippet specification that serves a similar purpose to
Facebook's Open Graph or Twitter Cards. This metadata is a subset of
[schema.org's microdata vocabulary](https://schema.org/), which covers many
other schemas that can describe the content of your pages to search engines. For
this reason, this metadata is more generic for SEO, notably for Google's
search-engine, although this vocabulary is also used by Microsoft, Pinterest and
Yandex.

You can validate your markup with the [Structured Data Testing
Tool](https://developers.google.com/search/docs/appearance/structured-data). Also, please
note that this markup requires to add attributes to your top `html` tag.

```html
<html lang="" itemscope itemtype="https://schema.org/Article">
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
`https://www.example.com/cart.html?shopping-cart-open=true` can be indexed as
the cleaner, more accurate `https://www.example.com/cart.html`.

```html
<link rel="canonical" href="">
```

## Web Apps

There are a couple of meta tags that provide information about a web app when
added to the Home Screen on iOS:

- Adding `apple-mobile-web-app-capable` will make your web app chrome-less and
  provide the default iOS app view. You can control the color scheme of the
  default view by adding `apple-mobile-web-app-status-bar-style`.

```html
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
```

- You can use `apple-mobile-web-app-title` to add a specific sites name for the
  Home Screen icon.

```html
<meta name="apple-mobile-web-app-title" content="">
```

For further information please read the [official
documentation](https://developer.apple.com/library/archive/documentation/AppleApplications/Reference/SafariHTMLRef/Articles/MetaTags.html)
on Apple's site.

### Apple Touch Icons

Apple touch icons are used as icons when a user adds your webapp to the home
screen of an iOS devices.

Though the dimensions of the icon can vary between iOS devices and versions one
`180×180px` touch icon named `icon.png` and including the following in the
`<head>` of the page is enough:

```html
<link rel="apple-touch-icon" href="icon.png">
```

For a more comprehensive overview, please refer to Mathias' [article on Touch
Icons](https://mathiasbynens.be/notes/touch-icons).

### Apple Touch Startup Image

Apart from that it is possible to add start-up screens for web apps on iOS. This
basically works by defining `apple-touch-startup-image` with an according link
to the image. Since iOS devices have different screen resolutions it maybe
necessary to add media queries to detect which image to load. Here is an example
for an iPhone:

```html
<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="img/startup.png">
```

### Theme Color

You can add the [`theme-color` meta
extension](https://html.spec.whatwg.org/multipage/semantics.html#meta-theme-color)
in the `<head>` of your pages to suggest the color that browsers and OSes should
use if they customize the display of individual pages in their UIs with varying
colors.

```html
<meta name="theme-color" content="#ff69b4">
```

The `content` attribute extension can take any valid CSS color.

For browser support details, refer to [Can I Use](https://caniuse.com/meta-theme-color).

### security.txt

When security risks in web services are discovered by users they often lack the
channels to disclose them properly. As a result, security issues may be left
unreported.

Security.txt defines a standard to help organizations define the process for
users to disclose security vulnerabilities securely. Include a text file on your
server at `.well-known/security.txt` with the relevant contact details.

Check [https://securitytxt.org/](https://securitytxt.org/) for more details.

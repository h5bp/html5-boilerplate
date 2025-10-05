[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# The HTML

By default, HTML5 Boilerplate provides two `html` pages:

- [`index.html`](#indexhtml) - a default HTML skeleton that should form the
  basis of all pages on your website
- `404.html` - a placeholder 404 error page

## `index.html`

### Language Attribute

Please consider specifying the language of your content by adding a
[value](https://www.iana.org/assignments/language-subtag-registry/language-subtag-registry)
to the `lang` attribute in the `<html>` as in this example:

```html
<html lang="en">
```

### The order of the `<title>` and `<meta>` tags

The charset declaration (`<meta charset="utf-8">`) must be included completely
within the
[first 1024 bytes of the document](https://html.spec.whatwg.org/multipage/semantics.html#charset)
and should be specified as early as possible.

### Meta Description

The `description` meta tag provides a short description of the page. In some
situations this description is used as a part of the snippet shown in the search
results.

```html
<meta name="description" content="This is a description">
```

Google's
[Create good meta descriptions](https://support.google.com/webmasters/answer/35624?hl=en#meta-descriptions)
documentation has useful tips on creating an effective description.

### Mobile Viewport

There are a few different options that you can use with the
[`viewport` meta tag](https://docs.google.com/present/view?id=dkx3qtm_22dxsrgcf4 "Viewport and Media Queries - The Complete Idiot's Guide").
You can find out more in [
the MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/HTML/Viewport_meta_tag).
HTML5 Boilerplate comes with a simple setup that strikes a good balance for general use cases.

```html
<meta name="viewport" content="width=device-width, initial-scale=1">
```

If you want to take advantage of edge-to-edge displays of iPhone X/XS/XR you
can do so with additional viewport parameters.
[Check the WebKit blog](https://webkit.org/blog/7929/designing-websites-for-iphone-x/) for
details.

### Open Graph Metadata

The [Open Graph Protocol](https://ogp.me) allows you to define the way your
site is presented when referenced on third party sites and applications
(Facebook, Twitter, LinkedIn). The protocol provides a series of meta elements
that define the details of your site. The required attributes define the title,
preview image, URL, and [type](https://ogp.me/#types) (e.g., video, music,
website, article).

```html
<meta property="og:title" content="">
<meta property="og:type" content="">
<meta property="og:url" content="">
<meta property="og:image" content="">
<meta property="og:image:alt" content="">
```

In addition to these four attributes there are many more attributes you can use
to add more richness to the description of your site. This just represents the
most basic implementation.

To see a working example, the following is the open graph metadata for the HTML5
Boilerplate site. In addition to the required fields we add `og:description` to
describe the site in more detail.

```html
<meta property="og:url" content="https://html5boilerplate.com/">
<meta property="og:title" content="HTML5 ★ BOILERPLATE">
<meta property="og:type" content="website">
<meta property="og:description" content="The web’s most popular front-end template which helps you build fast, robust, and adaptable web apps or sites.">
<meta property="og:image" content="https://html5boilerplate.com/icon.png">
<!-- Empty for decorative images. -->
<meta property="og:image:alt" content="">
```

### Web App Manifest

HTML5 Boilerplate includes a simple web app manifest file.

The web app manifest is a simple JSON file that allows you to control how your
app appears on a device's home screen, what it looks like when it launches in
that context and what happens when it is launched. This allows for much greater
control over the UI of a saved site or web app on a mobile device.

It's linked to from the HTML as follows:

```html
<link rel="manifest" href="site.webmanifest">
```

Our
[site.webmanifest](https://github.com/h5bp/html5-boilerplate/blob/main/src/site.webmanifest)
contains a very skeletal "app" definition, just to show the basic usage. You
should fill this file out with
[more information about your site or application](https://developer.mozilla.org/en-US/docs/Web/Manifest)

### Favicons and Touch Icon

The shortcut icons should be put in the root directory of your site.
`favicon.ico` is automatically picked up by browsers if it's placed in the root.
HTML5 Boilerplate comes with a default set of icons (include favicon and one
Apple Touch Icon) that you can use as a baseline to create your own.

Please refer to the more detailed description in the [Extend section](extend.md)
of these docs.

### The Content Area

The central part of the boilerplate template is pretty much empty. This is
intentional, in order to make the boilerplate suitable for both web page and web
app development.

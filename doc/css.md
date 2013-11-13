[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# The CSS

The HTML5 Boilerplate starting CSS includes:

* [Normalize.css](https://github.com/necolas/normalize.css).
* Useful HTML5 Boilerplate defaults.
* Placeholder media queries.
* Print styles.

This starting CSS does not rely on the presence of conditional classnames,
conditional style sheets, or Modernizr. It is ready to use whatever your
development preferences happen to be.


## Normalize.css

Normalize.css is a modern, HTML5-ready alternative to CSS resets. It contains
extensive inline documentation. Please refer to the [Normalize.css
project](http://necolas.github.com/normalize.css/) for more information.


## HTML5 Boilerplate defaults

This project includes a handful of base styles that build upon Normalize.css.
These include:

* Basic typography settings to provide improved text readability by default.
* Protection against unwanted `text-shadow` during text highlighting.
* Tweaks to default image alignment, fieldsets, and textareas.
* A pretty prompt to update your browser if you are on an outdated browser.

You are free to modify or add to these base styles as your project requires.


## Media Queries

The boilerplate makes it easy to get started with a "Mobile First" and
[Responsive Web
Design](http://www.alistapart.com/articles/responsive-web-design/) approach to
development. But it's worth remembering that there are [no silver
bullets](http://www.cloudfour.com/css-media-query-for-mobile-is-fools-gold/).

We include a placeholder Media Queries to build up your mobile styles for wider
viewports and high-resolution displays. It's recommended that you adapt these
Media Queries based on the content of your site rather than mirroring the fixed
dimensions of specific devices.

If you do not want to take a "Mobile First" approach, you can simply edit or
remove these placeholder Media Queries. One possibility would be to work from
wide viewports down and use `max-width` MQs instead, e.g., `@media only screen
and (max-width: 480px)`.

Take a look into the [Mobile
Boilerplate](https://github.com/h5bp/mobile-boilerplate) for features that are
useful when developing mobile web apps.


## Print styles

* Print styles are inlined to [reduce the number of page
  requests](http://www.phpied.com/delay-loading-your-print-css/).
* We strip all background colors, change the font color to black and remove
  text-shadow. This is meant to [help save printer ink and make the printing
  process much faster](http://www.sanbeiji.com/archives/953).
* Anchors do not need colors to indicate they are linked. They are underlined
  to indicate so.
* Anchors and Abbreviations are expanded to indicate where users reading the
  printed page can refer to.
* But we do not want to show link text for image replaced elements (given that
  they are primarily images).

### Paged media styles

* Paged media is supported only in a [few
  browsers](http://en.wikipedia.org/wiki/Comparison_of_layout_engines_%28Cascading_Style_Sheets%29#Grammar_and_rules).
* Paged media support means browsers would know how to interpret instructions
  on breaking content into pages and on orphans/widows.
* We use `page-break-inside: avoid;` to prevent an image and table row from
  being split into two different pages, so use the same `page-break-inside:
  avoid;` for that as well.
* Headings should always appear with the text they are titles for. So, we
  ensure headings never appear in a different page than the text they describe
  by using `page-break-after: avoid;`.
* We also apply a default margin for the page specified in `cm`.
* We do not want [orphans and
  widows](http://en.wikipedia.org/wiki/Widows_and_orphans) to appear on pages
  you print. So, by defining `orphans: 3` and `widows: 3` you define the minimal
  number of words that every line should contain.


## Helper Classes

With HTML5 Boilerplate v5 we decided to remove all helper classes in CSS
because we don't think they are much useful for developers that build upon the
HTML5 Boilerplate template.
Please feel free to check out branch
[`v4`](https://github.com/h5bp/html5-boilerplate/tree/v4) which includes the
helper classes.

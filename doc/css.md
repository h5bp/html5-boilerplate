[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# The CSS

The HTML5 Boilerplate starting CSS includes:

* [Normalize.css](https://github.com/necolas/normalize.css).
* Useful HTML5 Boilerplate defaults.
* Common helpers.
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


## Common helpers

#### `.hidden`

Add the `.hidden` class to any elements that you want to hide from all
presentations, including screen readers. It could be an element that will be
populated later with JavaScript or an element you will hide with JavaScript. Do
not use this for SEO keyword stuffing. That is just not cool.

#### `.visuallyhidden`

Add the `.visuallyhidden` class to hide text from browsers but make it
available for screen readers. You can use this to hide text that is specific to
screen readers but that other users should not see. [About invisible
content](http://www.webaim.org/techniques/css/invisiblecontent/), [Hiding
content for
accessibility](http://snook.ca/archives/html_and_css/hiding-content-for-accessibility),
[HTML5 Boilerplate
issue/research](https://github.com/h5bp/html5-boilerplate/issues/194/).

#### `.invisible`

Add the `.invisible` class to any element you want to hide without affecting
layout. When you use `display: none` an element is effectively removed from the
layout. But in some cases you want the element to simply be invisible while
remaining in the flow and not affecting the positioning of surrounding
content.

#### `.clearfix`

Adding `.clearfix` to an element will ensure that it always fully contains its
floated children. There have been many variants of the clearfix hack over the
years, and there are other hacks that can also help you to contain floated
children, but the HTML5 Boilerplate currently uses the [micro
clearfix](http://nicolasgallagher.com/micro-clearfix-hack/).


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

[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# The CSS

HTML5 Boilerplate's CSS includes:

* [Normalize.css](#normalizecss)
* [Useful defaults](#useful-defaults)
* [Common helpers](#common-helpers)
* [Placeholder media queries](#media-queries)
* [Print styles](#print-styles)

This starting CSS does not rely on the presence of conditional class names,
conditional style sheets, or Modernizr, and it is ready to use no matter what
your development preferences happen to be.


## Normalize.css

In order to make browsers render all elements more consistently and in line
with modern standards, we include
[Normalize.css](http://necolas.github.io/normalize.css/) — a modern, HTML5-ready
alternative to CSS resets.

As opposed to CSS resets, Normalize.css:

* targets only the styles that need normalizing
* preserves useful browser defaults rather than erasing them
* corrects bugs and common browser inconsistencies
* improves usability with subtle improvements
* doesn't clutter the debugging tools
* has better documentation

For more information about Normalize.css, please refer to its [project
page](http://necolas.github.com/normalize.css/), as well as this
[blog post](http://nicolasgallagher.com/about-normalize-css/).


## Useful defaults

Several base styles are included that build upon `Normalize.css`. These
styles:

* provide basic typography settings that improve text readability
* protect against unwanted `text-shadow` during text highlighting
* tweak the default alignment of some elements (e.g.: `img`, `video`,
  `fieldset`, `textarea`)
* style the prompt that is displayed to users using an outdated browser

You are free and even encouraged to modify or add to these base styles as your
project requires.


## Common helpers

Along with the base styles, we also provide some commonly used helper classes.

#### `.hidden`

The `hidden` class can be added to any element that you want to hide visually
and from screen readers. It could be an element that will be populated and
displayed later, or an element you will hide with JavaScript.

#### `.visuallyhidden`

The `visuallyhidden` class can be added to any element that you want to hide
visually, while still have its content accessible to screen readers.

See also:

* [CSS in Action: Invisible Content Just for Screen Reader
  Users](http://www.webaim.org/techniques/css/invisiblecontent/)
* [Hiding content for
  accessibility](http://snook.ca/archives/html_and_css/hiding-content-for-accessibility)
* [HTML5 Boilerplate - Issue #194](https://github.com/h5bp/html5-boilerplate/issues/194/).

#### `.invisible`

The `invisible` class can be added to any element that you want to hide
visually and from screen readers, but without affecting the layout.

As opposed to the `hidden` class that effectively removes the element from the
layout, the `invisible` class will simply make the element invisible while
keeping it in the flow and not affecting the positioning of the surrounding
content.

__N.B.__ Try to stay away from, and don't use the classes specified above for
[keyword stuffing](http://en.wikipedia.org/wiki/Keyword_stuffing) as you will
harm your site's ranking!

#### `.clearfix`

The `clearfix` class can be added to any element to ensure that it always fully
contains its floated children.

Over the years there have been many variants of the clearfix hack, but currently,
we use the [micro clearfix](http://nicolasgallagher.com/micro-clearfix-hack/).


## Media Queries

HTML5 Boilerplate makes it easy for you to get started with a
[_mobile first_](http://www.lukew.com/presos/preso.asp?26) and [_responsive web
design_](http://www.alistapart.com/articles/responsive-web-design/) approach to
development. But it's worth remembering that there are [no silver
bullets](http://www.cloudfour.com/css-media-query-for-mobile-is-fools-gold/).

We include placeholder media queries to help you build up your mobile styles for
wider viewports and high-resolution displays. It's recommended that you adapt
these media queries based on the content of your site rather than mirroring the
fixed dimensions of specific devices.

If you do not want to take the _mobile first_ approach, you can simply edit or
remove these placeholder media queries. One possibility would be to work from
wide viewports down, and use `max-width` media queries instead (e.g.:
`@media only screen and (max-width: 480px)`).

For more features that can help you in your mobile web development, take a look
into our [Mobile Boilerplate](https://github.com/h5bp/mobile-boilerplate).


## Print styles

Lastly, we provide some useful print styles that will optimize the printing
process, as well as make the printed pages easier to read.

At printing time, these styles will:

* strip all background colors, change the font color to black, and remove the
  `text-shadow` — done in order to [help save printer ink and speed up the
  printing process](http://www.sanbeiji.com/archives/953)
* underline and expand links to include the URL — done in order to allow users
  to know where to refer to<br>
  (exceptions to this are: the links that are
  [fragment identifiers](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/a#attr-href),
  or use the
  [`javascript:` pseudo protocol](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/void#JavaScript_URIs))
* expand abbreviations to include the full description — done in order to allow
  users to know what the abbreviations stands for
* provide instructions on how browsers should break the content into pages and
  on [orphans/widows](http://en.wikipedia.org/wiki/Widows_and_orphans), namely,
  we instruct
  [supporting browsers](http://en.wikipedia.org/wiki/Comparison_of_layout_engines_%28Cascading_Style_Sheets%29#Grammar_and_rules)
  that they should:

  * ensure the table header (`<thead>`) is [printed on each page spanned by the
    table](http://css-discuss.incutio.com/wiki/Printing_Tables)
  * prevent block quotations, preformatted text, images and table rows from
    being split onto two different pages
  * ensure that headings never appear on a different page than the text they
    are associated with
  * ensure that
    [orphans and widows](http://en.wikipedia.org/wiki/Widows_and_orphans) do
    [not appear on printed pages](http://css-tricks.com/almanac/properties/o/orphans/)

The print styles are included along with the other `css` to [avoid the
additional HTTP request](http://www.phpied.com/delay-loading-your-print-css/).
Also, they should always be included last, so that the other styles can be
overwritten.

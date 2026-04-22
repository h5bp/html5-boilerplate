[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Accessibility

HTML5 Boilerplate includes useful accessibility-friendly defaults, such as a
configurable `lang` attribute in the HTML template and helper classes in
`style.css`. The accessibility of the finished site still depends on the
structure, labels, and interactions you add on top of those defaults.

## Start with semantic HTML

Prefer native HTML elements before ARIA whenever possible. Elements such as
`<header>`, `<nav>`, `<main>`, `<footer>`, `<button>`, and `<label>` already
communicate meaning to browsers and assistive technology without extra roles.

Keep the page outline predictable by using a single `<h1>` for the page title
and nesting headings in order for each section of content.

```html
<header>...</header>
<nav aria-label="Primary">...</nav>

<main id="main">
  <h1>Page title</h1>

  <section aria-labelledby="news-heading">
    <h2 id="news-heading">Latest news</h2>
    ...
  </section>
</main>

<footer>...</footer>
```

## Add a skip link for keyboard users

Pages with repeated navigation should offer a way to jump straight to the main
content. HTML5 Boilerplate already includes `.visually-hidden` and
`.visually-hidden.focusable`, which makes a skip link available to keyboard and
screen-reader users without leaving it visible all the time.

```html
<a class="visually-hidden focusable" href="#main">Skip to main content</a>

<header>...</header>
<nav aria-label="Primary">...</nav>
<main id="main">
  ...
</main>
```

## Label controls and keep instructions visible

Every form control needs an accessible name. Use a visible `<label>` whenever
possible, and keep important guidance outside of placeholder text so it remains
available after the user starts typing.

Use `aria-describedby` to connect an input with additional hint or error text.

```html
<form>
  <label for="email">Email address</label>
  <p id="email-help">Use an address you check regularly.</p>
  <input id="email" name="email" type="email" aria-describedby="email-help">
</form>
```

## Write text alternatives that match the content

Use `alt` text for informative images and `alt=""` for decorative images that
do not add meaning. If an image is purely decorative, consider adding it with
CSS instead of an `<img>` element.

The `og:image:alt` metadata in the default template improves social sharing
previews, but it does not replace `alt` text for images in the page content.

```html
<img src="team-photo.jpg" alt="Support team standing in front of the office">
<img src="divider.svg" alt="">
```

## Preserve visible focus styles

Do not remove the browser's focus indicator unless you replace it with an
equally visible style. Keyboard users need a clear indication of which element
is currently focused.

```css
:focus-visible {
  outline: 3px solid #0a84ff;
  outline-offset: 2px;
}
```

## Use ARIA to supplement HTML, not replace it

ARIA can fill gaps when native HTML cannot express a relationship or accessible
name, but it is not a substitute for semantic markup. Start with correct HTML
first, then add ARIA only where it improves the experience.

## Quick checks before shipping

- Set the document `lang` attribute as described in [The HTML](html.md).
- Verify that the page can be used with only a keyboard.
- Check that visible text labels match the accessible names of controls.
- Confirm that headings, landmarks, and skip links reflect the page structure.
- Test zoomed text and responsive layouts to ensure content remains usable.

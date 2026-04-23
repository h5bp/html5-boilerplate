[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Accessibility

HTML5 Boilerplate includes a few accessibility-friendly starting points, such
as a configurable `lang` attribute in the HTML template and helper classes in
`style.css`. This guide focuses on a few first steps you can take to make a
site easier to use with keyboards, screen readers, and zoomed text.

## Set the page language

Start by setting the `lang` attribute on the root `<html>` element. This helps
screen readers choose the right pronunciation rules and gives browsers better
information about the page.

```html
<html lang="en">
```

The [HTML documentation](html.md#language-attribute) covers this in the default
template.

## Use semantic HTML first

Prefer native HTML elements before adding extra attributes. Elements such as
`<header>`, `<nav>`, `<main>`, `<footer>`, `<button>`, and `<label>` already
carry meaning for browsers and assistive technology.

Keep the page outline predictable by using a single `<h1>` for the page title
and nesting headings in order for each section of content.

```html
<header>...</header>
<nav>...</nav>

<main id="main">
  <h1>Page title</h1>

  <section>
    <h2>Latest news</h2>
    ...
  </section>
</main>

<footer>...</footer>
```

## Add a skip link for keyboard users

Pages with repeated navigation should offer a way to jump straight to the main
content. HTML5 Boilerplate already includes `.visually-hidden` and
`.visually-hidden.focusable`, which can be used to hide a skip link until it
receives keyboard focus.

```html
<a class="visually-hidden focusable" href="#main">Skip to main content</a>

<header>...</header>
<nav>...</nav>
<main id="main">
  ...
</main>
```

## Label controls and keep instructions visible

Every form control needs an accessible name. Use a visible `<label>` whenever
possible, and keep important guidance outside of placeholder text so it remains
available after the user starts typing.

```html
<form>
  <label for="email">Email address</label>
  <p>Use an address you check regularly.</p>
  <input id="email" name="email" type="email">
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

## Use ARIA only when HTML is not enough

ARIA stands for Accessible Rich Internet Applications. It adds extra meaning to
elements when plain HTML cannot express a name, state, or relationship on its
own.

In practice, ARIA should be used sparingly. Start with semantic HTML first, and
only add ARIA when it solves a specific problem. For example, ARIA can help
associate hint or error text with a form control, but it is not a replacement
for real labels, headings, and buttons.

## Quick checks before shipping

- Set the document `lang` attribute as described in [The HTML](html.md).
- Verify that the page can be used with only a keyboard.
- Check that visible text labels match the accessible names of controls.
- Confirm that headings, landmarks, and skip links reflect the page structure.
- Test zoomed text and responsive layouts to ensure content remains usable.

[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Frequently asked questions

* [Why is the Google Analytics code at the bottom? Google recommends it be
  placed in the `<head>`.](#why-is-the-google-analytics-code-at-the-bottom-google-recommends-it-be-placed-in-the-head)
* [Do I need to upgrade my site each time a new version of HTML5 Boilerplate is
  released?](#do-i-need-to-upgrade-my-site-each-time-a-new-version-of-html5-boilerplate-is-released)
* [Where can I get help with support
  questions?](#where-can-i-get-help-with-support-questions)

---

### Why is the Google Analytics code at the bottom? Google recommends it be placed in the `<head>`.

The main advantage of placing it in the `<head>` is that you will track the
user's `pageview` even if they leave the page before it has been fully loaded.

Here's a handy quote from [Mathias Bynens](https://mathiasbynens.be/notes/async-analytics-snippet#comment-50) about our placement choice.
>I should point out that it’s Google — not me — recommending to place this
script before all other scripts in the document. The only real advantage is to
catch a pageView call if your page fails to load completely (for example, if
the user aborts loading, or quickly closes the page, etc.). Personally, I
wouldn’t count that as a page view, so I actually prefer to place this script
at the bottom, after all other scripts. This keeps all the scripts together and
reinforces that scripts at the bottom are the right move. (Usually I
concatenate and minify all my scripts into one .js file — the GA snippet being
the suffix.)

### Do I need to upgrade my site each time a new version of HTML5 Boilerplate is released?

No, just as you don't normally replace the foundation of a house once it
was built. However, there is nothing stopping you from trying to work in the
latest changes, but you'll have to assess the costs/benefits of doing so.

### Where can I get help with support questions?

Please ask for help on
[StackOverflow](https://stackoverflow.com/questions/tagged/html5boilerplate).

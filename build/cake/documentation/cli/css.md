cake-css(1) -- cake CSS tasks
===========================


## DESCRIPTION

These tasks are related to css optimizations, mainly concat, `@import`
inlining and minification (using
[clean-css](https://github.com/GoalSmashers/clean-css#readme))

## Tasks

### css.concat

Concat the CSS files depending on the @imports in your
file.root.stylesheet. `@import` should be fortmated like so:

    @import url('style.bar.css') @import url("style.foo.css")


This task is called once the source to intermediate copy is done. It
then tries to:

* replace `@imports` with h5bp-import tags (part 1)
* test if the url property is valid and match an actual file in the repo
* minify the whole css file, done using clean-css
* generate a new checksum to prefix the filename (eg.
  c2ceef4.style.min.css)
* then it writes the file to the intermediate dir

## SEE ALSO

* cake help
* cake -h css help
* cake -h html help


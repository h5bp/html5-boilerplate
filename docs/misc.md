[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Miscellaneous

* [.gitignore](#gitignore)
* [.editorconfig](#editorconfig)
* [Server Configuration](#server-configuration)
* [robots.txt](#robotstxt)
* [package.json](#packagejson)

--

## .gitignore

HTML5 Boilerplate includes a basic project-level `.gitignore`. This should
primarily be used to avoid certain project-level files and directories from
being kept under source control. Different development-environments will
benefit from different collections of ignores.

OS-specific and editor-specific files should be ignored using a "global
ignore" that applies to all repositories on your system.

For example, add the following to your `~/.gitconfig`, where the `.gitignore`
in your HOME directory contains the files and directories you'd like to
globally ignore:

```gitignore
[core]
    excludesfile = ~/.gitignore
```

* More on global ignores: [https://help.github.com/articles/ignoring-files/](https://help.github.com/en/github/using-git/ignoring-files)
* Comprehensive set of ignores on GitHub: https://github.com/github/gitignore

## .editorconfig

The `.editorconfig` file is provided in order to encourage and help you and
your team define and maintain consistent coding styles between different
editors and IDEs.

By default, `.editorconfig` includes some basic
[properties](https://editorconfig.org/#supported-properties) that reflect the
coding styles from the files provided by default, but you can easily change
them to better suit your needs.

In order for your editor/IDE to apply the
[properties](https://editorconfig.org/#supported-properties) from the
`.editorconfig` file, you may need to [install a
plugin]( https://editorconfig.org/#download).

__N.B.__ If you aren't using the server configurations provided by HTML5
Boilerplate, we highly encourage you to configure your server to block
access to `.editorconfig` files, as they can disclose sensitive information!

For more details, please refer to the [EditorConfig
project](https://editorconfig.org/).

## robots.txt

The `robots.txt` file is used to give instructions to web robots on what can
be crawled from the website.

By default, the file provided by this project includes the next two lines:

* `User-agent: *` -  the following rules apply to all web robots
* `Disallow:` - everything on the website is allowed to be crawled

If you want to disallow certain pages you will need to specify the path in a
`Disallow` directive (e.g.: `Disallow: /path`) or, if you want to disallow
crawling of all content, use `Disallow: /`.

The `/robots.txt` file is not intended for access control, so don't try to
use it as such. Think of it as a "No Entry" sign, rather than a locked door.
URLs disallowed by the `robots.txt` file might still be indexed without being
crawled, and the content from within the `robots.txt` file can be viewed by
anyone, potentially disclosing the location of your private content! So, if
you want to block access to private content, use proper authentication instead.

For more information about `robots.txt`, please see:

* [robotstxt.org](https://www.robotstxt.org/)
* [How Google handles the `robots.txt` file](https://developers.google.com/search/reference/robots_txt)

## package.json

`package.json` is used to define attributes of your site or application for
use in modern JavaScript development. [The full documentation is available](https://docs.npmjs.com/files/package.json)
if you're interested. The fields we provide are as follows:

* `title` - the title of your project. If you expect to publish your application
  to npm, then the name needs to follow [certain guidelines](https://docs.npmjs.com/files/package.json#name)
  and be unique.
* `version` - indicates the version of your site application using semantic
  versioning ([SemVer](https://semver.org/))
* `description` - describes your site.
* `scripts` - is a JavaScript object containing commands that can be run in a
  node environment. There are many [built-in keys](https://docs.npmjs.com/misc/scripts)
  related to the package lifecycle that node understands automatically. You can
  also define custom scripts for use with your application development. We
  provide three custom scripts that work with webpack to get you up and running
  quickly with a bundler for your assets and a simple development server.

  * `start` serves your `index.html` with a simple development server

* `keywords` - an array of keywords used to discover your app in the npm
  registry
* `author` - defines the author of a package. There is also an alternative
  [contributors](https://docs.npmjs.com/files/package.json#people-fields-author-contributors)
  field if there's more than one author.
* `license` - the license for your application. Must conform to
  [specific rules](https://docs.npmjs.com/files/package.json#license)
* `devDependencies` - development dependencies for your package. In our case
 we have several dependencies used by webpack, which we use as a simple development server.

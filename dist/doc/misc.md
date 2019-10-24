[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Miscellaneous

* [.gitignore](#gitignore)
* [.editorconfig](#editorconfig)
* [Server Configuration](#server-configuration)
* [robots.txt](#robotstxt)
* [humans.txt](#humanstxt)
* [browserconfig.xml](#browserconfigxml)

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

* More on global ignores: https://help.github.com/articles/ignoring-files/
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


## Server Configuration

H5BP includes a [`.htaccess`](#htaccess) file for the [Apache HTTP
server](https://httpd.apache.org/docs/). If you are not using Apache
as your web server, then you are encouraged to download a
[server configuration](https://github.com/h5bp/server-configs) that
corresponds to your web server and environment.

A `.htaccess` (hypertext access) file is an [Apache HTTP server
configuration file](https://github.com/h5bp/server-configs-apache).
The `.htaccess` file is mostly used for:

* Rewriting URLs
* Controlling cache
* Authentication
* Server-side includes
* Redirects
* Gzipping

If you have access to the main server configuration file (usually called
`httpd.conf`), you should add the logic from the `.htaccess` file in, for
example, a <Directory> section in the main configuration file. This is usually
the recommended way, as using .htaccess files slows down Apache!

To enable Apache modules locally, please see:
https://github.com/h5bp/server-configs-apache#enable-apache-httpd-modules.

In the repo the `.htaccess` is used for:

* Allowing cross-origin access to web fonts
* CORS header for images when browsers request it
* Enable `404.html` as 404 error document
* Making the website experience better for IE users better
* Media UTF-8 as character encoding for `text/html` and `text/plain`
* Enabling the rewrite URLs engine
* Forcing or removing the `www.` at the begin of a URL
* It blocks access to directories without a default document
* It blocks access to files that can expose sensitive information.
* It reduces MIME type security risks
* It forces compressing (gzipping)
* It tells the browser whether they should request a specific file from the
  server or whether they should grab it from the browser's cache

When using `.htaccess` we recommend reading all inline comments (the rules after
a `#`) in the file once. There is a bunch of optional stuff in it.

If you want to know more about the `.htaccess` file check out the
[Apache HTTP server docs](https://httpd.apache.org/docs/) or more
specifically the [htaccess
section](https://httpd.apache.org/docs/current/howto/htaccess.html).

Notice that the original repo for the `.htaccess` file is [this
one](https://github.com/h5bp/server-configs-apache).


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
  * [How Google handles the `robots.txt` file](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt)

## humans.txt

The `humans.txt` file is used to provide information about people involved with
the website.

The provided file contains three sections:

  * `TEAM` - this is intended to list the group of people responsible for the website
  * `THANKS` - this is intended to list the group of people that have contributed
  to the website
  * `TECHNOLOGY COLOPHON` - the section lists technologies used to make the website
  
For more information about `humans.txt`, please see: http://humanstxt.org/


## browserconfig.xml

The `browserconfig.xml` file is used to customize the tile displayed when users
pin your site to the Windows 8.1 start screen. In there you can define custom
tile colors, custom images or even [live tiles](https://msdn.microsoft.com/library/dn455106.aspx#CreatingLiveTiles).

By default, the file points to 2 placeholder tile images:

* `tile.png` (558x558px): used for `Small`, `Medium` and `Large` tiles.
  This image resizes automatically when necessary.
* `tile-wide.png` (558x270px): user for `Wide` tiles.

Notice that IE11 uses the same images when adding a site to the `favorites`.

For more in-depth information about the `browserconfig.xml` file, please
see [MSDN](https://docs.microsoft.com/en-us/previous-versions/windows/internet-explorer/ie-developer/platform-apis/dn320426(v=vs.85)).

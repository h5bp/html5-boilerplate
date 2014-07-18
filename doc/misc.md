[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Miscellaneous

* [.gitignore](#gitignore)
* [.editorconfig](#editorconfig)
* [.htaccess](#htaccess)
* [crossdomain.xml](#crossdomainxml)

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

* More on global ignores: https://help.github.com/articles/ignoring-files
* Comprehensive set of ignores on GitHub: https://github.com/github/gitignore


## .editorconfig

The `.editorconfig` file is provided in order to encourage and help you and
your team define and maintain consistent coding styles between different
editors and IDEs.

By default, `.editorconfig` includes some basic
[properties](http://editorconfig.org/#supported-properties) that reflect the
coding styles from the files provided by default, but you can easily change
them to better suit your needs.

In order for your editor/IDE to apply the
[properties](http://editorconfig.org/#supported-properties) from the
`.editorconfig` file, you will need to [install a
plugin]( http://editorconfig.org/#download).

__N.B.__ If you aren't using the server configurations provided by HTML5
Boilerplate, we highly encourage you to configure your server to block
access to `.editorconfig` files, as they can disclose sensitive information!

For more details, please refer to the [EditorConfig
project](http://editorconfig.org/).


### .htaccess

A `.htaccess` (hypertext access) file is a Apache HTTP server configuration
file. The `.htaccess` file is mostly used for:

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
https://github.com/h5bp/server-configs-apache/wiki/How-to-enable-Apache-modules.

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

If you want to know more about the `.htaccess` file check out
http://httpd.apache.org/docs/current/howto/htaccess.html.

Notice that the original repo for the `.htaccess` file is [this
one](https://github.com/h5bp/server-configs-apache/blob/master/src/.htaccess).


### crossdomain.xml

The _cross-domain policy file_ is an XML document that gives a web client —
such as Adobe Flash Player, Adobe Reader, etc. — permission to handle data
across multiple domains, by:

 * granting read access to data
 * permitting the client to include custom headers in cross-domain requests
 * granting permissions for socket-based connections

__e.g.__ If a client hosts content from a particular source domain and that
content makes requests directed towards a domain other than its own, the remote
domain would need to host a cross-domain policy file in order to grant access
to the source domain and allow the client to continue with the transaction.

For more in-depth information, please see Adobe's [cross-domain policy file
specification](http://www.adobe.com/devnet/articles/crossdomain_policy_file_spec.html).

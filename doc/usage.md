[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Usage

Once you have cloned or downloaded HTML5 Boilerplate, creating a website or web app
usually involves the following:

1. Setting up the basic structure of the website.
2. Adding some content, style, and functionality.
3. Running your website locally to see how it looks.
4. Optionally: Running a build script to automate the optimization of your website.
5. Deploying your website.


## Basic structure

The initial structure offered by HTML5 Boilerplate is the following:

```
.
├── css
│   ├── main.css
│   └── normalize.css
├── doc
├── img
├── js
│   ├── main.js
│   ├── plugins.js
│   └── vendor
│       ├── jquery.min.js
│       └── modernizr.min.js
├── .gitattributes
├── .gitignore
├── .htaccess
├── 404.html
├── apple-touch-icon-precomposed.png
├── browserconfig.xml
├── crossdomain.xml
├── favicon.ico
├── humans.txt
├── index.html
├── robots.txt
├── tile.png
└── tile-wide.png
```


## General overview

### `css/`

The `css` directory contains some initial CSS to help you get started from a
solid foundation. All your project's style sheets should be included in
this directory.

For more in-depth information about the CSS, please see [`css.md`](css.md).


### `doc/`

The `doc` directory contains all the HTML5 Boilerplate documentation. You can
use it as the location and basis for your own project's documentation.


### `js/`

The `js` directory contains some initial JavaScript to help you get started. All
your project's JavaScript files (libraries, plugins, and custom code) should be
included in this directory.

For more in-depth information about the JavaScript, please see [`js.md`](js.md).













TODO:


### `.htaccess`

The `.htaccess` file contains Apache boilerplate configurations that can help
your server improve the web site's performance and security, while also ensuring
that resources are served with the correct content type and are accessible, if
needed, even cross-domain.

For more in-depth information about the `.htaccess` file, please refer to the
[Apache Server Configs repository](https://github.com/h5bp/server-configs-apache).

If you're hosting your web site on a server different than Apache, check our
[Server Configs repository](https://github.com/h5bp/server-configs#readme), as
you're likely to find the corresponding server configs project in there.

### `404.html`

The `404.html` is a helpful custom 404 page to get you started.


### `index.html`

The `index.html` file contains the default HTML skeleton that should form the
basis of all pages on your site. If you are using a server-side templating
framework, you will need to integrate this starting HTML with your setup.

If you modify the directory structure, make sure you update the URLs that
reference the CSS style sheets and JavaScript files. Also, if you are using
Google Universal Analytics, don't forget to edit the corresponding snippet to
include your analytics ID.




### `humans.txt`

The `humans.txt` file

information about the different people who have contributed to building the site / web app, as
well as the technology powering it

### `robots.txt`

Edit this file to include any pages you need hidden from search engines.

### `crossdomain.xml`

The `crossdomain.xml` is an XML template for working with cross-domain request


that can help you get started with managing the permission to handle data across multiple domains for web client - such as Adobe Flash Player, Adobe Reader.



### Icons

This project comes with some default icons:
  * `apple-touch-icon-precomposed.png`
  * `favicon.ico`

They are provided as placeholder icons, so don't forget to replace them with your own!

For more in-depth information, about the Apple Touch Icons, please see [`extend.md#apple-touch-icon`](extend.md#apple-touch-icon).


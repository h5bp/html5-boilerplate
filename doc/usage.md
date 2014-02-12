[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Usage

Once you have cloned or downloaded HTML5 Boilerplate, creating a site or web app
usually involves the following:

1. Setting up the basic structure of the site.
2. Adding some content, style, and functionality.
3. Running your site locally to see how it looks.
4. Optionally: Running a build script to automate the optimization of your site.
5. Deploying your site.


## Basic structure

The basic structure offered by HTML5 Boilerplate looks like this:

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
├── .htaccess
├── 404.html
├── apple-touch-icon-precomposed.png
├── index.html
├── humans.txt
├── robots.txt
├── crossdomain.xml
└── favicon.ico
```


## General overview

### css/

The `css` directory contains some initial CSS to help you get started from a
solid foundation. All your project's CSS style sheets should be included in it.

For more in-depth information, please see [`css.md`](css.md).


### doc/

The `doc` directory contains all the HTML5 Boilerplate documentation. You can
use it as the location and basis for your own project's documentation.


### js/

The `js` directory contains some initial JavaScript to help you get started. All
your project's JavaScript files (libraries, plugins, and custom code) should be
included in it.

For more in-depth information, please see [`js.md`](js.md).


### .htaccess

The `.htaccess` file contains Apache boilerplate configurations that can help
your server improve the web site's performance and security, while also ensuring
that resources are served with the correct content type and are accessible, if
needed, even cross-domain.

For more in-depth information, please refer to the [Apache Server Configs
repository](https://github.com/h5bp/server-configs-apache).

If you're hosting your site on a server different than Apache, check our [Server
Configs repository](https://github.com/h5bp/server-configs#readme), as you're
likely to find the corresponding server configs project in there.


### 404.html

The `404.html` is a helpful custom 404 page to get you started.


### index.html

The `index.html` file contains the default HTML skeleton that should form the
basis of all pages on your site. If you are using a server-side templating
framework, you will need to integrate this starting HTML with your setup.

If you modify the directory structure, make sure you update the URLs that
reference the CSS style sheets and JavaScript files. Also, if you are using
Google Analytics, don't forget to edit the corresponding snippet to include
your analytics ID.



# TODO:

### humans.txt

The `humans.txt`

information about the different people who have contributed to building the site / web app, as
well as the technology powering it

### robots.txt

Edit this file to include any pages you need hidden from search engines.

### crossdomain.xml

A template for working with cross-domain requests. [About
crossdomain.xml](crossdomain.md).

### Icons

The `apple-touch-icon-precomposed.png` and the `favicon.ico` are provided as placeholder icons. You should replace them with your own!

For more in-depth information, about the Apple Touch Icons, please see [`extend.md#apple-touch-icon`](extend.md#apple-touch-icon).

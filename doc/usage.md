[HTML5 Boilerplate homepage](http://html5boilerplate.com) | [Documentation
table of contents](TOC.md)

# Usage

Once you have cloned or downloaded HTML5 Boilerplate, creating a site or app
usually involves the following:

1. Set up the basic structure of the site.
2. Add some content, style, and functionality.
3. Run your site locally to see how it looks.
4. (Optionally run a build script to automate the optimization of your site -
   e.g. [ant build script](https://github.com/h5bp/ant-build-script) or [node
   build script](https://github.com/h5bp/node-build-script)).
5. Deploy your site.


## Basic structure

A basic HTML5 Boilerplate site initially looks something like this:

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

What follows is a general overview of each major part and how to use them.

### css

This directory should contain all your project's CSS files. It includes some
initial CSS to help get you started from a solid foundation. [About the
CSS](css.md).

### doc

This directory contains all the HTML5 Boilerplate documentation. You can use it
as the location and basis for your own project's documentation.

### js

This directory should contain all your project's JS files. Libraries, plugins,
and custom code can all be included here. It includes some initial JS to help
get you started. [About the JavaScript](js.md).

### .htaccess

The default web server configs are for Apache. For more information, please
refer to the [Apache Server Configs
documentation](https://github.com/h5bp/server-configs-apache/tree/master/doc).

Host your site on a server other than Apache? You're likely to find the
corresponding server configs project listed in our [Server Configs
](https://github.com/h5bp/server-configs/blob/master/README.md) repository.

### 404.html

A helpful custom 404 to get you started.

### index.html

This is the default HTML skeleton that should form the basis of all pages on
your site. If you are using a server-side templating framework, then you will
need to integrate this starting HTML with your setup.

Make sure that you update the URLs for the referenced CSS and JavaScript if you
modify the directory structure at all.

If you are using Google Analytics, make sure that you edit the corresponding
snippet at the bottom to include your analytics ID.

### humans.txt

Edit this file to include the team that worked on your site/app, and the
technology powering it.

### robots.txt

Edit this file to include any pages you need hidden from search engines.

### crossdomain.xml

A template for working with cross-domain requests. [About
crossdomain.xml](crossdomain.md).

### Icons

Replace the default `favicon.ico` and Apple Touch Icon with your own.

If you want to use different Apple Touch Icons for different resolutions please
refer to the [according documentation](extend.md#apple-touch-icons).

You might want to check out Hans' handy [HTML5 Boilerplate Favicon and Apple
Touch Icon
PSD-Template](http://drublic.de/blog/html5-boilerplate-favicons-psd-template/).

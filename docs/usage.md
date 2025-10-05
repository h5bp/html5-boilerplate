[HTML5 Boilerplate homepage](https://html5boilerplate.com/) | [Documentation
table of contents](TOC.md)

# Usage

The most basic usage of HTML5 Boilerplate is to create a static site or simple
app. Once you've downloaded or cloned the project, that process looks something
like this:

1. Set up the basic structure of the site.
2. Add some content, style, and functionality.
3. Run your site locally to see how it looks.
4. Deploy your site.

Cool, right? _It is_. That said, the smart defaults, baseline elements, default
attribute values and various other utilities that HTML5 Boilerplate offers can
serve as the foundation for whatever you're interested in building.

Even the basic use-case of a simple static site can be enhanced by manipulating
the code through an automated build process. Moving up in complexity HTML5
Boilerplate can be integrated with whatever front-end framework, CMS or
e-commerce platform you're working with. Mix-and-match to your heart's content.
Use what you need (toss it in a blender if you need to) and discard the rest.
HTML5 Boilerplate is a starting point, not a destination.

## Basic structure

A basic HTML5 Boilerplate site initially looks something like this:

```
.
├── css
│   └── style.css
├── doc
├── img
├── js
│   ├── app.js
    └── vendor
├── .editorconfig
├── 404.html
├── favicon.ico
├── icon.png
├── icon.svg
├── index.html
├── package.json
├── robots.txt
├── site.webmanifest
└── webpack.common.js
└── webpack.config.dev.js
└── webpack.config.prod.js
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

### 404.html

A helpful custom 404 to get you started.

### .editorconfig

The `.editorconfig` file is provided in order to encourage and help you and your
team to maintain consistent coding styles between different editors and IDEs.
[Read more about the `.editorconfig` file](misc.md#editorconfig).

### index.html

This is the default HTML skeleton that should form the basis of all pages on
your site. If you are using a server-side templating framework, then you will
need to integrate this starting HTML with your setup.

Make sure that you update the URLs for the referenced CSS and JavaScript if you
modify the directory structure at all.

### package.json

Edit this file to describe your application, add dependencies, scripts and
other properties related to node based development and the npm registry

### robots.txt

Edit this file to include any pages you need hidden from search engines.

### Icons

Replace the default `favicon.ico` and Apple Touch Icon with your own.

If you want to use different Apple Touch Icons for different resolutions please
refer to the [according documentation](extend.md#apple-touch-icons).

### Webpack

The project contains a simple [webpack](https://webpack.js.org/) configuration.

To get started developing a site with a development server, run the following
commands from within the `/dist/` folder in the project's repo or within the
root folder of the dowloaded project files, the folder created by `npm install`
or the project folder created by running [create\-html5\-boilerplate](https://github.com/h5bp/create-html5-boilerplate)

```
npm install
npm run start
```

This will start a Webpack development server with hot reloading of edited files.

To package a site for production run

```
npm run build
```

This command will bundle up the site's JavaScript and copy over static assets to
the newly created `dist` folder.

There are three files:

#### webpack.common.js

Both the production and development scripts inherit from this common script.

#### webpack.config.dev.js

This development configuration defines the behavior of development server.

#### webpack.config.prod.js

This production configuration defines the behavior of the production build.

It copies the following files and folders to the dist folder:

- css
- img
- js/vendor
- 404.html
- favicon.ico
- icon.png
- icon.svg
- index.html
- robots.txt
- site.webmanifest

`js/vendor` is copied over in order to allow you to use unprocessed JS files
in addition to the files bundled based on the project's entry point `app.js.`

# [HTML5 Boilerplate](https://html5boilerplate.com/)

[![Build status](https://github.com/h5bp/html5-boilerplate/workflows/Build%20status/badge.svg)](https://github.com/h5bp/html5-boilerplate/actions?query=workflow%3A%22Build+status%22+branch%3Amaster)
[![LICENSE](https://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/h5bp/html5-boilerplate/blob/master/LICENSE.txt)
[![devDependency Status](https://david-dm.org/h5bp/html5-boilerplate/dev-status.svg)](https://david-dm.org/h5bp/html5-boilerplate#info=devDependencies)
[![NPM Downloads](https://img.shields.io/npm/dt/html5-boilerplate.svg)](https://www.npmjs.com/package/html5-boilerplate)
[![github-stars-image](https://img.shields.io/github/stars/h5bp/html5-boilerplate.svg?label=github%20stars)](https://github.com/h5bp/html5-boilerplate)

HTML5 Boilerplate is a professional front-end template for building
fast, robust, and adaptable web apps or sites.

This project is the product of over 10 years of iterative development and
community knowledge. It does not impose a specific development
philosophy or framework, so you're free to architect your code in the
way that you want.

* Homepage: [https://html5boilerplate.com/](https://html5boilerplate.com/)
* Source: [https://github.com/h5bp/html5-boilerplate](https://github.com/h5bp/html5-boilerplate)
* Twitter: [@h5bp](https://twitter.com/h5bp)

## Quick start

Choose one of the following options:

* Download the latest stable release from
  [html5boilerplate.com](https://html5boilerplate.com/). This zip file is a
  snapshot of the `dist` folder. On Windows, Mac and from the file manager on
  Linux unzipping this folder will output to a folder named something like
  `html5-boilerplate_v7.3.0`. From the command line will need to create a
  folder and unzip the contents into that folder.

  ```bash
  mkdir html5-boilerplate
  unzip html5-boilerplate*.zip -d html5-boilerplate
  ```

* Clone the git repo — `git clone
  https://github.com/h5bp/html5-boilerplate.git` - and checkout the
  [tagged release](https://github.com/h5bp/html5-boilerplate/releases)
  you'd like to use. The `dist` folder represents the latest version of the
  project for end users.

* Install with [npm](https://www.npmjs.com/): `npm install html5-boilerplate`
  or [yarn](https://yarnpkg.com/): `yarn add html5-boilerplate`. The resulting
  `node_modules/html5-boilerplate/dist` folder represents the latest version of
  the project for end users. Depending on what you want to use and how you want
  to use it, you may have to copy and paste the contents of that folder into
  your project directory.

* Using our new [create-html5-boilerplate](https://github.com/h5bp/create-html5-boilerplate)
  project, instantly fetch the latest npm published package (or any version
  available on npm) with `npx`, `npm init` or `yarn create` without having to
  install any dependencies. Running the following `npx` command installs the
  latest version into a folder called `new-site`

  ```
  npx create-html5-boilerplate new-site
  cd new-site
  npm install
  npm start
  ```

## Features

* A finely-tuned starter template. Reap the benefits of 10 years of analysis,
  research and experimentation by over 200 contributors.
* Designed with progressive enhancement in mind.
* Includes:
  * [`Normalize.css`](https://necolas.github.com/normalize.css/)
    for CSS normalizations and common bug fixes
  * A custom build of [`Modernizr`](https://modernizr.com/) for feature
    detection
  * [`Apache Server Configs`](https://github.com/h5bp/server-configs-apache)
    that improve the web site's performance and security
* Placeholder Open Graph elements and attributes.
* An example package.json file with [Parcel](https://parceljs.org/) commands
  built in to jumpstart application development
* Placeholder CSS Media Queries.
* Useful CSS helper classes.
* Default print styles, performance optimized.
* An optimized version of the Google Universal Analytics snippet.
* Protection against any stray `console` statements causing JavaScript
  errors in older browsers.
* "Delete-key friendly." Easy to strip out parts you don't need.
* Extensive documentation.

## Browser support

* Chrome *(latest 2)*
* Edge *(latest 2)*
* Firefox *(latest 2)*
* Internet Explorer 11
* Opera *(latest 2)*
* Safari *(latest 2)*

*This doesn't mean that HTML5 Boilerplate cannot be used in older browsers,
just that we'll ensure compatibility with the ones mentioned above.*

If you need legacy browser support you can use [HTML5 Boilerplate v6](https://github.com/h5bp/html5-boilerplate/releases/tag/6.1.0) (IE9/IE10)
or [HTML5 Boilerplate v5](https://github.com/h5bp/html5-boilerplate/releases/tag/5.3.0)
(IE 8). They are no longer actively developed.

## Documentation

Take a look at the [documentation table of contents](dist/doc/TOC.md). This
documentation is bundled with the project which makes it available for offline
reading and provides a useful starting point for any documentation you want to
write about your project.

## Contributing

Hundreds of developers have helped to make the HTML5 Boilerplate. Anyone is
welcome to [contribute](.github/CONTRIBUTING.md), however, if you decide to get
involved, please take a moment to review the [guidelines](.github/CONTRIBUTING.md):

* [Bug reports](.github/CONTRIBUTING.md#bugs)
* [Feature requests](.github/CONTRIBUTING.md#features)
* [Pull requests](.github/CONTRIBUTING.md#pull-requests)

## License

The code is available under the [MIT license](LICENSE.txt).

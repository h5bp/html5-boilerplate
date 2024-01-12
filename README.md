# [HTML5 Boilerplate](https://html5boilerplate.com/)

[![Build status](https://github.com/h5bp/html5-boilerplate/workflows/Build%20status/badge.svg)](https://github.com/h5bp/html5-boilerplate/actions?query=workflow%3A%22Build+status%22+branch%3Amain)
[![LICENSE](https://img.shields.io/badge/license-MIT-lightgrey.svg)](https://github.com/h5bp/html5-boilerplate/blob/main/LICENSE.txt)
[![NPM Downloads](https://img.shields.io/npm/dt/html5-boilerplate.svg)](https://www.npmjs.com/package/html5-boilerplate)
[![github-stars-image](https://img.shields.io/github/stars/h5bp/html5-boilerplate.svg?label=github%20stars)](https://github.com/h5bp/html5-boilerplate)

HTML5 Boilerplate is a professional front-end template for building
fast, robust, and adaptable web apps or sites.

This project is the product of over 10 years of iterative development and
community knowledge. It does not impose a specific development
philosophy or framework, so you're free to architect your code in the
way that you want.

- [Homepage](https://html5boilerplate.com/)
- [Source Code](https://github.com/h5bp/html5-boilerplate)

## About This Repository

This repository is where HTML5-Boilerplate is authored. Some of the tools,
files and processes that you see here are solely for the _production_ of
HTML5 Boilerplate and are not _part_ of HTML5 Boilerplate. For one example, the
[gulpfile.mjs](https://github.com/h5bp/html5-boilerplate/blob/main/gulpfile.mjs)
script is used to _build_ the project. It's not part of the project itself.

The project we publish is represented by the contents of the `/dist/`
folder. Everything else in this repository is used to author the project.

Think of it this way, in the same way that you don't clone [vuejs/core](https://github.com/vuejs/core)
to create a Vue.js app, you don't need to clone this repository to start a new
site or app based on HTML5 Boilerplate.

So, if you're looking for a quick start template to build a website or
application, look at the options in the
[Quick Start](https://github.com/h5bp/html5-boilerplate#quick-start) section of this document.

If you want to help us _improve_ HTML5 Boilerplate then you can start with the documentation [here](.github/CONTRIBUTING.md), which includes steps to clone this repo in order to get it set up for development.

## Quick Start

Choose one of the following options:

- Using the [create-html5-boilerplate](https://github.com/h5bp/create-html5-boilerplate)
  script, instantly fetch the latest npm published package (or any version
  available on npm) with `npx`, `npm init` or `yarn create` without having to
  install any dependencies. Running the following `npx` command installs the
  latest version into a folder called `new-site`

  ```bash
  npx create-html5-boilerplate new-site
  cd new-site
  npm install
  npm run start
  ```

- Using our new [Template Repository](https://github.com/h5bp/html5-boilerplate-template)
  create a new GitHub repository based on the latest code from the main branch of HTML5
  Boilerplate.

- Install with [npm](https://www.npmjs.com/): `npm install html5-boilerplate`
  or [yarn](https://yarnpkg.com/): `yarn add html5-boilerplate`. The resulting
  `node_modules/html5-boilerplate/dist` folder represents the latest version of
  the project for end users. Depending on what you want to use and how you want
  to use it, you may have to copy and paste the contents of that folder into
  your project directory.

- Download the latest stable release from
  [here](https://github.com/h5bp/html5-boilerplate/releases/download/v9.0.0/html5-boilerplate_v9.0.0.zip). This zip file is a
  snapshot of the `dist` folder. On Windows, Mac and from the file manager on
  Linux unzipping this folder will output to a folder named something like
  `html5-boilerplate_v9.0.0`. From the command-line, you will need to create a
  folder and unzip the contents into that folder.

  ```bash
  mkdir html5-boilerplate
  unzip html5-boilerplate*.zip -d html5-boilerplate
  ```

## Features

- A finely-tuned starter template: Reap the benefits of 10 years of analysis,
  research and experimentation by over 200 contributors.
- Designed with progressive enhancement in mind.
- Includes:
  - Placeholder Open Graph elements and attributes.
  - An example package.json file with [WebPack](https://webpack.js.org/) commands
    built in to jumpstart application development.
  - Placeholder CSS Media Queries.
  - Useful CSS helper classes.
  - Default print styles, performance optimized.
  - "Delete-key friendly." Easy to strip out parts you don't need.
  - Extensive documentation.

## Browser Support

HTML5-Boilerplate supports the latest, stable releases of all major browsers.

Check the `default` configuration from [Browserslist](https://browsersl.ist/#q=defaults)
for more details on browsers and versions covered.

## Documentation

Take a look at the [documentation table of contents](docs/TOC.md). This
documentation is bundled with the project which makes it available for offline
reading and provides a useful starting point for any documentation you want to
write about your project.

## Contributing

Hundreds of developers have helped to make the HTML5 Boilerplate. Anyone is
welcome to [contribute](.github/CONTRIBUTING.md). However, if you decide to get
involved, please take a moment to review the [guidelines](.github/CONTRIBUTING.md):

- [Bug reports](.github/CONTRIBUTING.md#bugs)
- [Feature requests](.github/CONTRIBUTING.md#features)
- [Pull requests](.github/CONTRIBUTING.md#pull-requests)

## License

The code is available under the [MIT license](LICENSE.txt).

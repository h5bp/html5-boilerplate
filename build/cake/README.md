# cake script

h5bp build script cake implementation.

## install

In `build/cake/` folder, run

    npm install

It'll get the dependencies as defined in the `package.json` file
(they're quite a few, this may take a while)

## Synopsis

    cake [options] <task>

## Description

**Cake, and Cakefiles**: quoting http://jashkenas.github.com/coffee-script/#cake

> CoffeeScript includes a (very) simple build system similar to Make and
Rake. Naturally, it's called Cake, and is used for the tasks that build
and test the CoffeeScript language itself. Tasks are defined in a file
named Cakefile, and can be invoked by running cake [task] from within
the directory. To print a list of all the tasks and options, just type
cake.

> Task definitions are written in CoffeeScript, so you can put arbitrary
code in your Cakefile. Define a task with a name, a long description,
and the function to invoke when the task is run. If your task takes a
command-line option, you can define the option with short and long
flags, and it will be made available in the options object.

Run `cake` to get a list of available commands. Run `cake -h <topic>
help` to show the appropriate documentation page.

## Introduction

There's a bunch of tasks defined, but you'll probably want to run the
main one: `cake build`.

The cake script is somehow "sandboxed" in its own folder, eg. the script
doesn't apply on the main repo. It is designed to work with the `cake
createproject` task. This may change.

The build script relies on a project's folder (`dir.source` in
configuration). This one may be created using the `cake creatproject`
task (you'll be prompted if no `--output` option is provided).

### Running tests

The tests are a good way to get a better insight of what the build
script can do, and how to use it.

Here is the npm script you can trigger by running `npm test`.

    "scripts": {
      "pretest": "cake -o _test createproject && cake -l silly build",
      "test": "vows tests/basic.js --spec"
    }

The createproject task will clone the remote repository (or pull if the
h5bp folder is there), and create a new project folder named `_test`.
Then the build is triggered by running `cake build` with the lowest
loglevel).

By default, `publish/` is where the build script generates the final
result.


## Tasks

Tasks can be written in CoffeeScript or pure JavaScript. The main
Cakefile includes a simple loading mechanism (relying on the
[vm](http://nodejs.org/docs/v0.5.10/api/vm.html) module, which
automatically loads the tasks files under tasks/ folder).

Creating/Removing tasks is simply a matter of creating new tasks files
in the tasks/ folder. Tasks files are written very much the same way as
the main Cakefile, simply define a task with:

* a name
* a long description
* and a function to be called when the task is run

Any `.coffee` or `.js` file in `tasks/` gets loaded and made available
as if their content was in the Cakefile. Each tasks is added in the
order they're defined, sorted by the task filename.

A coffeescript file is compiled before running in a vm context. This
system allows both coffee-script and JS files to be used to create or
maintain cake tasks.

## Logs

The cake script uses [Winston](https://github.com/indexzero/winston) to
easily manage logging statements used during the overall build process.
Log levels can be setup via cli options to only log messages with level
higher than the supplied `loglevel` option.

Available log levels are, from lowest to highest: silly, input, verbose,
prompt, info, data, help, warn, debug, error and silent.

The default loglevel is set to `input`. If you want a build to be run
with a different log level, simply run the following:

    cake -l info <task>
    cake --loglevel silly <task>

Log levels can be provided with the short (`-l`) or long (`--loglevel`)
option format.

## Configuration

It may evolve to something a bit different but the configuration is now
managed using the `conf/default.coffee` file. It basically matches the
default properties file of the h5bp ant build script.

see `cake -h config help` for more informations.

## Get Help

A special `cake help` task, if supplied a topic, shows the appropriate
documentation page.

If the topic does not exist, then it attempts to read the documentation,
parsed from markdown content in tasks source files. If neither of the
topic or tasks file exist, then it'll show the README documentation
page.

    cake help

These are matching markdown files in documentation/cli:

    cake -h config help
    cake -h css help
    cake -h intro help
    cake -h js help

These are matching tasks files in tasks/

    cake -h build help
    cake -h createproject help
    cake -h docs help
    cake -h html help
    cake -h img help
    cake -h test help

## CAKE++

quoting the CoffeeScript website:

> Cake tasks are a minimal way to expose your CoffeeScript functions to
the command line, so don't expect any fanciness built-in. If you need
dependencies, or async callbacks, it's best to put them in your code
itself — not the cake task.

Indeed, with complex scenarios, where a lot of tasks are involved, with
potential async code and probably tasks dependency with each other, we
need a way to ensure a given tasks is run only when the list of its
dependencies are done.

This is done using a modified version of cake's task function, where a
second parameter is available: a task-scopped event emitter.

Basically, tasks can notify the build system they're done by emitting a
`end` event, with optional arguments other tasks may consume.

*more docs to come soon on this subject*

It's expected to change a little bit, with a more convenient api to work
with.

### Tasks dependencies

A tasks may invoke another tasks, and so forth express their
dependencies by using the `invoke` method Cake provides.

A given tasks can only be run once, any tasks that tries to invoke a
task which was already run previously will do basically nothing, and
just ensure the `end` event is emitted.

A task that relies on others should wrap its main code using the `gem`
variable (automatically made available by the tasks loading) which
stands for Global EventEmitter. It works with the tasks scopped event
emitter and will emit a special event tasks could listen to. This event
emitted by the `gem` will take the form of `end:taskname`.

### Local EventEmitter

A "local" `EventEmitter` is created and passed in as a second parameter
to tasks' functions.

Namely provides a few logging helpers:

    em.emit 'log', 'Something to log'
    em.emit 'warn', 'Something to warn'
    em.emit 'error', 'Error to log, and exit program'
    em.emit 'data', {foo: 'bar'}

Tasks in `tasks/` does not gain access to the logger instance, they
could instead use the emitter to provide logs scopped to the current
running task.

The special `end` event allows tasks to run asynchronously and still be
able to depends on each other. Once ended, a task notify its status to
the global EventEmitter by emitting an `end:taskname` event.

This (simple) async system and task dependency ensures that a task is
only executed once. We emit the end event and prevent action call if the
task is already done.

## Diretories

In particular, the cake build folder has the following directories:

* conf: configuration folders, includes default.coffee
* docs: the docs for the build script, markdown format
* tasks: where the Cakefile lookup tasks to load
* tests: the vows test suite, ensuring everything works fine

### Tests

Tests are written in [vows](http://vowsjs.org/). Simply type `npm test`
to run them.

Here is the npm scripts:

    "scripts": {
      "pretest": "cd h5bp/ && cake -o _test createproject && cake -l silly build",
      "test": "vows h5bp/tests/basic.js --spec"
    }

First, we ensure we have the local repository available and trigger a
new build (good sanity check on the tasks too).

Then, the test suites in `tests/` are executed and perform a series of
basic test on the output folder. The test coverage should improve soon.



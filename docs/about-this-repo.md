# About This Repo

This document outlines the configuration of this repo as well as the basic
process we use to manage the project. As Github has matured as a platform
and HTML5 Boilerplate has matured as a project there are a lot of lessons
to be learned from the way we run the show here.

## GitHub configuration

This section will go through the way we configure the repo in GitHub.
Open source projects get the full power of the platform  and as a project
we like to experiment with new GitHub features. Our current configuration
might help you figure out some things you want to do in your own projects. 

### General Configuration

This section outlines the basic configuration options we use. 

* We have a stub of a Wiki still, so we have wikis turned on. The most
interesting page that remains is a history of the project written several
years ago.
* We use the Issues feature heavily. We don't yet have Issue Templates set
up, but we do have adding them as an issue, so we'll take advantage of them
at some point.
* Discussions are enabled, but they haven't been very useful so far. 

### Pull Requests

The most visible portion of our configuration is the way we handle pull 
requests. At the most basic level, we require pull requests to add code 
to the repo and require a review to merge code. In addition we run several
code quality checks on every pull request to make sure we're not introducing
anything we don't want into the codebase. 

We take advantage of the "draft" feature for PRs. This way we have visibility
throughout the life of the PR.

Let's take a look at how we configure our `main` branch. 

#### `main`

`main` is the default branch and is our only protected branch. We use feature
branches to add features and/or fix issues in the codebase. Other project
configurations might require a long-running, similarly protected, `development`
branch but for us the single protected `main` branch is enough for our
purposes.


Our branch protection rules are as follows:

* We require a pull request (PR) with one approving reviewer to merge code
* In addition to the PR and approving reviewer, we require three status checks
to pass before code can be merged
    * Build with Node 16
    * Build with Node 14
    * LGTM analysis: JavaScript
* We *allow* force pushes for project admins. While force pushes can create
some head scratching moments for people who have cloned the repo and update
before and after the force push, the ability to clean up the `HEAD` of a
public branch like this in an emergency is useful.

#### Github Actions and Other Checks That Run on `main`

* We run a simle *build status* check. This is the most basic test you can run
and is absolutely vital. If you can't build your porject you're in trouble.
Currently we're testing against Node 14 and 16.  
* We take advantage of our access to *CodeQL analysis* Free for research and
open source don't you know :) We don't have a ton of surface area to cover, 
but it's nice to have this powerful code scanning tool available to us. 
* We run a *dependency review* scan to see if any newly added dependencies add 
known security flaws. This is important for even us, but for a project that 
uses a larger number of third party dependencies, this sort of check is vital. 
* Since we're fan of the "belt and suspenders" approach to security, we also 
run a *LGTM.com* scan as well as the CodeQL scans. This tool, built on top of
CodeQl can shake out different issues so it's nice to have the pair. 









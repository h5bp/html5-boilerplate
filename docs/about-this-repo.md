# About This Repo

This document outlines the configuration of this repo as well as the basic
process we use to manage the project. As GitHub has matured as a platform
and HTML5 Boilerplate has matured as a project there are a lot of lessons
to be learned from the way we run the show here.

## GitHub configuration

This section will go through the way we configure the repo in GitHub.
Open source projects get the full power of the platform and as a project
we like to experiment with new GitHub features. Our current configuration
might help you figure out some things you want to do in your own projects.

### General Configuration

This section outlines the basic configuration options we use.

- We have a stub of a Wiki still, so we have wikis turned on. The most
  interesting page that remains is a history of the project written several
  years ago.
- We use the Issues feature heavily. We don't yet have Issue Templates set
  up, but we do have adding them as an issue, so we'll take advantage of them
  at some point.
- Discussions are enabled, but they haven't been very useful so far.

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

- We require a pull request (PR) with one approving reviewer to merge code
- In addition to the PR and approving reviewer, we require three status checks
  to pass before code can be merged
  _ Build with Node 20
  _ Build with Node 18
- We _allow_ force pushes for project admins. While force pushes can create
  some head scratching moments for people who have cloned the repo and update
  before and after the force push, the ability to clean up the `HEAD` of a
  public branch like this in an emergency is useful.

#### GitHub Actions and Other Checks That Run on `main`

- We run a simple _build status_ check. This is the most basic test you can run
  and is absolutely vital. If you can't build your project you're in trouble.
  Currently we're testing against Node 16 and 18.
- We take advantage of our access to _CodeQL analysis_ Free for research and
  open source don't you know :) We don't have a ton of surface area to cover,
  but it's nice to have this powerful code scanning tool available to us.
- We run a _dependency review_ scan to see if any newly added dependencies add
  known security flaws. This is important for even us, but for a project that
  uses a larger number of third party dependencies, this sort of check is vital.
- We also run a CodeQL scans to check for security issues and problems.
- We push any changes to `main` to our [HTML5\-Boilerplate Template Repo](https://github.com/h5bp/html5-boilerplate-template)

Since we've talked about some of our Actions, let's look at the full configuration
of our `.github` folder.

### .github Folder

- workflows
  - `build-dist.yml` is currently broken. We can't push to `main` without a
    code review, so this task is blocked. What I would like, (are you there,
    GitHub, it's me, Rob) is to allow Actions to bypass branch protection
    rules. I think we'll have to basically write a mini-bot that opens a PR
    whenever there are changes to `main` and then pushes to the same branch
    until the PR is closed. In some ways that will be better as it will be less
    noisy in terms of bot pushes to main.
  - `codeql-analysis.yml` controls our CodeQL action. We use the defaults. If
    you're building something with more JavaScript footprint, you can tweak
    the settings for this job.
  - `dependency-review.yml` does what it says on the tin- it tests newly
    introduced dependencies for vulnerabilities.
  - `publish.yml` is the action that publishes all the various versions of
    the project. When we create a new tag and push it to GitHub, this script
    publishes our npm package and creates a GitHub release and attaches a zip
    file of our `dist` folder.
  - `push-to-template.yml` pushes the `HEAD` of `main` to our template repo
  - `spellcheck.yml` automatically checks markdown files for typos with cSpell.
  - `test.yml` runs our test suite.
- `CODE_OF_CONDUCT.md` is our Code of Conduct, based on
  [Contributor Covenant.](https://www.contributor-covenant.org/)
- `CONTRIBUTING.md` contains our contribution guidelines.
- `ISSUE_TEMPLATE.md` is our new issue boilerplate.
- `PULL_REQUEST_TEMPLATE.md` is our new PR boilerplate.
- `SUPPORT.md` points people to different (non-HTML5-Boilerplate) support
  resources
- `dependabot.yml` is our Dependabot configuration. We do `npm`, monthly on
  two separate `package.json` files, one in `src` and one in project root.

---

That covers most of the interesting GitHub features and functionality that we
use. We're going to continue to keep this document up to date as we change
things or new GitHub features.

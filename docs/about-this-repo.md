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

### Pull Requests

The most visible portion of our configuration is the way we handle pull 
requests. At the most basic level, we require pull requests to add code 
to the repo and require a review to merge code. In addition we run several
code quality checks on every pull request to make sure we're not introducing
anything we don't want into the codebase. 

Let's take a look at how we configure our `main` branch. 

#### `main`


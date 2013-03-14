# Contributing to HTML5 Boilerplate

♥ [HTML5 Boilerplate](http://html5boilerplate.com) and want to get involved?
Thanks! There are plenty of ways you can help!


## Bugs

A bug is a _demonstrable problem_ that is caused by the code in the
repository. Good bug reports are extremely helpful - thank you!

Guidelines for bug reports:

1. **Use the GitHub issue search** &mdash; check if the issue has already been
   reported.

2. **Check if the issue has been fixed** &mdash; try to reproduce it using the
   latest `master` branch in the repository.

3. **Isolate the problem** &mdash; ideally create a [reduced test
   case](http://css-tricks.com/6263-reduced-test-cases/) and a live example.

A good bug report shouldn't leave others needing to chase you up for more
information. Please try to be as detailed as possible in your report. What is
your environment? What steps will reproduce the issue? What browser(s) and OS
experience the problem? What would you expect to be the outcome? All these
details will help people to fix any potential bugs.

Example:

> Short and descriptive example bug report title
>
> A summary of the issue and the browser/OS environment in which it occurs. If
> suitable, include the steps required to reproduce the bug.
>
> 1. This is the first step
> 2. This is the second step
> 3. Further steps, etc.
>
> `<url>` (a link to the reduced test case)
>
> Any other information you want to share that is relevant to the issue being
> reported. This might include the lines of code that you have identified as
> causing the bug, and potential solutions (and your opinions on their
> merits).

**[File a bug report](https://github.com/h5bp/html5-boilerplate/issues/)**


## Pull requests

Good pull requests - patches, improvements, new features - are a fantastic
help. They should remain focused in scope and avoid containing unrelated
commits. If your contribution involves a significant amount of work or substantial
changes to any part of the project, please open an issue to discuss it first.

Make sure to adhere to the coding conventions used throughout a project
(indentation, accurate comments, etc.). Please update any documentation that is
relevant to the change you're making.

Please follow this process; it's the best way to get your work included in the
project:

1. [Fork](http://help.github.com/fork-a-repo/) the project, clone your fork,
   and configure the remotes:

   ```bash
   # Clones your fork of the repo into the current directory in terminal
   git clone https://github.com/<your-username>/html5-boilerplate.git
   # Navigate to the newly cloned directory
   cd html5-boilerplate
   # Assigns the original repo to a remote called "upstream"
   git remote add upstream https://github.com/h5bp/html5-boilerplate.git
   ```

2. If you cloned a while ago, get the latest changes from upstream:

   ```bash
   git checkout master
   git pull upstream master
   ```

3. Create a new topic branch to contain your feature, change, or fix:

   ```bash
   git checkout -b <topic-branch-name>
   ```

4. Commit your changes in logical chunks. Please adhere to these [git commit
   message
   guidelines](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html)
   or your pull request is unlikely be merged into the main project. Use git's
   [interactive rebase](https://help.github.com/articles/interactive-rebase)
   feature to tidy up your commits before making them public.

5. Locally merge (or rebase) the upstream development branch into your topic branch:

   ```bash
   git pull [--rebase] upstream master
   ```

6. Push your topic branch up to your fork:

   ```bash
   git push origin <topic-branch-name>
   ```

10. [Open a Pull Request](https://help.github.com/articles/using-pull-requests) with a
    clear title and description.


## Do not…

Please **do not** use the issue tracker for personal support requests (use
[StackOverflow](http://stackoverflow.com/questions/tagged/html5boilerplate) or IRC).

Please **do not** derail or troll issues. Keep the
discussion on topic and respect the opinions of others.

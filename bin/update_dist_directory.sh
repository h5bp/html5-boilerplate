#!/bin/bash

# [!] This script is intended for Travis. If the tests pass, Travis will
# automatically execute this script, regenerating the `dist` directory and
# committing any new changes to the `master` branch.
# Details: github.com/h5bp/html5-boilerplate/commit/a3baca2367fab2d

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

commit_and_push_changes() {

    # Check if there are unstaged changes, and
    # if there are, commit and push them upstream

    if [ $(git diff --exit-code > /dev/null; printf $?;) -eq 1 ]; then
        git config --global user.email ${GH_USER_EMAIL} \
            && git config --global user.name ${GH_USER_NAME} \
            && git checkout master &> /dev/null \
            && git add -A \
            && git commit --message "Update content from the \`dist\` directory [skip ci]" > /dev/null \
            && git push --quiet "$(get_repository_url)" master > /dev/null
        print_result $? "Commit and push changes"
    fi

}

get_repository_url() {
    printf "https://${GH_TOKEN}@$(git config --get remote.origin.url | sed 's/git:\/\///g')"
}

print_error() {
    # Print output in red
    printf "\e[0;31m [✖] $1\e[0m\n"
}

print_result() {
    [ $1 -eq 0 ] \
        && print_success "$2" \
        || print_error "$2"

    if [ $1 -ne 0 ]; then
        exit 1
    fi
}

print_success() {
    # Print output in green
    printf "\e[0;32m [✔] $1\e[0m\n"
}

update_content() {
    npm -q install \
        && npm run build > /dev/null
    print_result $? "Update content"
}

# - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

main() {

    # Only execute the following if the
    # changes were made in the `master` branch

    if [ "$TRAVIS_BRANCH" == "master" ]; then
        update_content
        commit_and_push_changes
    fi

}

main

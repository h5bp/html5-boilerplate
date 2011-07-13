Feature: Build the HTML5 Boilerplate
  In order to customize my HTML5 Boilerplate base
  As a developer
  I should be able to use Rake to facilitate builds

  @wip
  Scenario: Perform a basic build
    When I run `rake build:basics`
    Then the output should contain "build:"
    And the output should contain "Building a Production Environment..."
    And the output should contain "Creating directory structure..."
    And the output should contain "js.all.minify"
    And the output should contain "js.main.concat"
    And the output should contain "Concatenating css..."
    And the output should contain "Minifying css..."
    And the output should contain "Optimizing images..."
    And the output should contain "Now, we clean up those jpgs..."
    And the output should contain "A copy of all non-dev files are now in: ./publish"
    And the output should contain "BUILD SUCCESSFUL"
    And the exit status should be 0

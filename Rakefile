require "rubygems"
require "rake/clean"

require "bundler/setup"
Bundler.require(:test)

# Define our variables
H5BP_BUILD_CONFIG = {
  "dir" => {
    "intermediate" => "intermediate",
    "publish" => "publish"
  }
}

# Things to clean/clobber
# TODO: What's different for H5BP in clean and clobber?
CLEAN.include([H5BP_BUILD_CONFIG["dir"].values])
CLOBBER.include([H5BP_BUILD_CONFIG["dir"].values])

# Import all of our build tasks
Dir.glob("lib/tasks/*.rake").each { |r| import r }

task :default => ["build:build"]

require "rubygems"

require "bundler/setup"
Bundler.require(:test)

require "./config"

# Import all of our build tasks
Dir.glob("lib/tasks/*.rake").each { |r| import r }

task :default => ["build:basics"]

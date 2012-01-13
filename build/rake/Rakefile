require 'rubygems'
require 'rake/clean'

# Require the default set of config values.
require 'conf/default'

# Load all of the Rake tasks.
Dir.glob('tasks/*.rake').each { |r| import r }

CLOBBER.include(CONF['dir']['publish'])
CLEAN.include(CONF['dir']['intermediate'])

desc "The default set of tasks"
task :default => [:test]

task :test do
  # Do nothing.
end

require "html5_boilerplate"

namespace :build do
  task :build    => ["build:basics", "html:minor_optimizations",
                     "image:optimizations"]
  task :buildkit => ["build:basics"]
  task :minify   => ["build:build", "html:full_minification"]

  desc "The default basic build"
  task :basics do
    HTML5Boilerplate::Builder.new.run
  end

  namespace :script do
    task :minified do
      puts "js.all.minify"
    end
  end

  namespace :html do
    task :minor_optimizations
    task :full_minification
  end

  namespace :image do
    task :optimizations
  end
end

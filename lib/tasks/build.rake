namespace :build do
  task :build    => ["build:basics", "html:minor_optimizations",
                     "image:optimizations"]
  task :buildkit => ["build:basics"]
  task :minify   => ["build:build", "html:full_minification"]

  desc "The default basic build"
  task :basics do
    puts "build:"
    puts "Building a Production Environment..."
    # TODO: Make this task list process cleaner
    ["build:script:minified"].each { |t|
      # "invoke" execs task if not already exec'd
      Rake::Task[t].invoke
    }
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

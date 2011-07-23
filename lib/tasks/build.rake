namespace :build do
  task :build    => ["build:basics", "html:minor_optimizations",
                     "image:optimizations"]
  task :buildkit => ["build:basics"]
  task :basics   => ["script:minified"]
  task :minify   => ["build:build", "html:full_minification"]

  desc "The default basic build"
  task :basics do
    puts "build:"
    puts "Building a Production Environment..."
    Rake::Task["build:mkdir"].invoke
  end

  namespace :dir do
    task :intermediate do
      mkdir H5BP_BUILD_CONFIG["dir"]["intermediate"]
    end

    task :publish do
      mkdir H5BP_BUILD_CONFIG["dir"]["publish"]
    end
  end

  namespace :script do
    task :minified
  end

  namespace :html do
    task :minor_optimizations
    task :full_minification
  end

  namespace :image do
    task :optimizations
  end

  desc "Crate the directory structure required for building"
  task :mkdir do
    puts "Creating directory structure..."
    Rake::Task["build:dir:intermediate"].invoke
    Rake::Task["build:dir:publish"].invoke
  end
end

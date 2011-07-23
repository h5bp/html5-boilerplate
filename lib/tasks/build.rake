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
    ["build:mkdir", "build:script:minified"].each { |t|
      # "invoke" execs task if not already exec'd
      Rake::Task[t].invoke
    }
  end

  namespace :dir do
    task :intermediate do
      mkdir_if_not_exists(H5BP_BUILD_CONFIG["dir"]["intermediate"])
    end

    task :publish do
      mkdir_if_not_exists(H5BP_BUILD_CONFIG["dir"]["publish"])
    end
  end

  namespace :script do
    task :minified => "build:mkdir" do
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

  desc "Crate the directory structure required for building"
  task :mkdir do
    puts "Creating directory structure..."
    Rake::Task["build:dir:intermediate"].invoke
    Rake::Task["build:dir:publish"].invoke
  end
end

def mkdir_if_not_exists(dir)
  if !File.exist? dir
    mkdir dir
  end
end

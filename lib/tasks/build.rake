namespace :build do
  task :build    => ["build:basics", "html:minor_optimizations", "image:optimizations"]
  task :buildkit => ["build:basics"]
  task :basics   => ["script:minified"]
  task :minify   => ["build:build", "html:full_minification"]

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
end

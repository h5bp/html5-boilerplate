require 'set'

namespace :core do
  desc "makes any required directories"
  task :mkdir do
    inter = CONF['dir']['intermediate']
    publish = CONF['dir']['publish']

    danger_paths = ['.','..','/','./','../'].to_s

    raise "Your dir.publish folder is set to #{publish} which could delete your entire site or worse. Change it in conf/default.rb" if danger_paths.include? publish

    # Invoke a clobber if it hasn't occurred already.
    Rake::Task["clobber"].invoke

    puts "Creating directory structure..."
    mkdir inter
    mkdir publish
  end
end

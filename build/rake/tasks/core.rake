require 'set'

namespace :core do
  desc "makes any required directories"
  task :mkdir do
    inter = CONF['dir']['intermediate']
    publish = CONF['dir']['publish']

    danger_paths = ['.','..','/','./','../'].to_s

    raise "Your dir.publish folder is set to #{publish} which could delete your entire site or worse. Change it in conf/default.rb" if danger_paths.include? publish

    puts "Creating directory structure..."
    mkdir inter if not File.exist? inter
    mkdir publish if not File.exist? publish
  end

  desc "copies files into the publish directory"
  task :copy => :mkdir do
    inter = CONF['dir']['intermediate']
    publish = CONF['dir']['publish']
    source = CONF['dir']['source']
    build = CONF['dir']['build']
    js = CONF['dir']['js']
    css = CONF['dir']['css']

    puts "Copying over new files..."

    # TODO: Find a nicer way to do this exclusion.
    files = Dir["#{source}/**/*"]
    files = files.reject { |file| file.index(/#{css}\/.*\/.*\.css/) != nil }
    files = files.reject { |file| file.index(/#{js}\/.*\/.*\.js/) != nil }
    files = files.reject { |file| file.index(/#{build}.*/) != nil }
    files = files.reject { |file| file.index(/#{publish}.*/) != nil }
    files = files.reject { |file| file.index(/#{inter}.*/) != nil }

    files.each { |file|
      if File.directory? file
        mkdir_p "#{publish}/#{file}"
      else
        FileUtils.uptodate?("#{publish}/#{file}", file) or cp file, publish
      end
    }
  end
end

require 'pathname'  
require Pathname(__FILE__).ascend{|d| h=d+'config.rb'; break h if h.file?}

Then /^the correct directories have been created$/ do
  H5BP_BUILD_CONFIG["dir"].values { |dirs|
    File.directory?(dirs)
  }
end

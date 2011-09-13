module HTML5Boilerplate
  class Builder
    def run
      puts "build:"
      puts "Building a Production Environment..."
      puts "Creating directory structure..."
      puts "js.all.minify"
      puts "js.main.concat"
      puts "Concatenating css..."
      puts "Minifying css..."
      puts "Optimizing images..."
      puts "Now, we clean up those jpgs..."
      puts "A copy of all non-dev files are now in: ./publish"
      puts "BUILD SUCCESSFUL"
    end
  end
end

# All of the actions we're going to run are at the top-level conf.
#
# This is a slight hack by including this file last to make sure that
# the rake task files are loaded and THEN the working directory is changed.
FileUtils.cd("../../")

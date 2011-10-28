
winston         = require 'winston'
optparse        = require 'coffee-script/lib/optparse'
levels          = winston.config.cli.levels

# options parsing, needs this to be able to parse command line arguments and used them outside of a cake task
# mainly for the loglevel options
switches = [
  ['-l', '--loglevel [level]', 'What level of logs to report. Values → ' + Object.keys(levels).join(', ') + ' or silent'],
  ['-o', '--output [DIR]', 'directory for the createproject task']
  ['-k', '--key [key]', 'Key configuration for config task']
  ['-h', '--help [task]', 'Output documentation for the cake help task, generated from source']
]

oparse = new optparse.OptionParser switches
options = oparse.parse process.argv.slice(2)

# still call option to make cake keep track of these options too
option.apply this, opt for opt in switches

if options.loglevel and options.loglevel isnt 'silent' and levels[options.loglevel] is undefined
  throw new Error('Unrecognized loglevel option: ' + options.loglevel + ' \n instead of → ' + Object.keys(levels).join(', '))

# export parsed options from cli
module.exports = options

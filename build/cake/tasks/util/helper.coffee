
# `helpers` expose a basic wrapper around node-glob by isaacs and 
# findit by substack. Enable multiple pattern matching, and include
# exlude ability.


# External dependency
{EventEmitter}  = require 'events'
path            = require 'path'
fs              = require 'fs'
crypto          = require 'crypto'
child           = require 'child_process'

# ## fileset
# expose filset module as helper method
exports.fileset = require 'fileset'

# ## extend
# Extend a source object with the properties of another object (shallow copy).
exports.extend = (object, properties) ->
  for key, val of properties
    object[key] = val
  object

# ## concat
# ease the concatenation process by taking a list of absolute path, and returning
# an array of Buffers. There is no order management yet.
exports.concat = (files, callback) ->
  return callback new Error('concat: Files array is empty') unless files.length

  output = []
  remaining = files.length
  onFile = (err, body) ->
    return callback err if err
    output.push body
    callback null, output if --remaining is 0

  fs.readFile file, onFile for file in files

# ## checksum
# Simple checksum helper, takes an absolute path, open a fileStream,
# and generates back the according `md5` hash, `hex` encoded.
exports.checksum = (file, callback) ->
  md5 = crypto.createHash 'md5'

  # assume file is the actual content if no callback is provided
  unless callback
    md5.update file
    return md5.digest 'hex'

  fs.createReadStream(file)
    .on('error', (err) -> callback err)
    .on('data', (data) -> md5.update data)
    .on('end', () -> callback null, md5.digest('hex'))



# ## copy
#
# Takes two path parameters: from and to, opens a ReadStream on from, a WriteStream on to,
# and pipes the ReadStream to the WriteStream. **files must exists**
#
exports.copy = (from, to, callback) ->
  fstream = fs.createReadStream(from)
  wstream = fs.createWriteStream(to)

  fstream.pipe wstream
  fstream
    .on('end', -> callback null )
    .on('error', (err) -> callback err)


exports.spawn = (cmd, args, callback) ->
  stderr = []
  stdout = []
  ch = child.spawn(cmd, args)

  ch.stdout.pipe process.stdout, {end: false}
  ch.stderr.pipe process.stderr
  ch.stdout.on 'data', (data) -> stdout[stdout.length] = data
  ch.stderr.on 'data', (data) -> stderr[stderr.length] = data

  ch.on 'exit', (code) ->
    stdout = stdout.join '\n'
    stderr = stderr.join '\n'

    callback code, stdout, stderr if callback
    ch.emit 'end', code,  stdout, stderr

  return ch

CONF = Hash.new
CONF['dir'] = Hash.new

CONF['dir']['source']       = '.'
CONF['dir']['publish']      = 'publish'
CONF['dir']['intermediate'] = 'intermediate'

CONF['dir']['build']        = 'build'
CONF['dir']['build.tools']  = CONF['dir']['build'] + '/tools'

CONF['dir']['test']         = 'test'
CONF['dir']['demo']         = 'demo'

CONF['dir']['js']           = 'js'
CONF['dir']['css']          = 'css'
CONF['dir']['images']       = 'img'

# scripts in the lib CONFectory will only be minified, not
# concatenated together.
CONF['dir']['js.libs']      = CONF['dir']['js'] + '/libs'
CONF['dir']['js.mylibs']    = CONF['dir']['js'] + 'mylibs'

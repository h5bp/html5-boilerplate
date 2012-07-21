module.exports = function(grunt) {
    grunt.initConfig({
        pkg: '<json:package.json>',
        meta: {
            banner: '/*! HTML5 Boilerplate v<%= pkg.version %> - <%= pkg.homepage %> */'
        },
        concat: {
            dist: {
                src: [
                    '<banner>',
                    'css/_normalize.css',
                    'css/_base.css',
                    'css/_helpers.css',
                    'css/_media.css'
                ],
                dest: 'css/main.css',
                separator: '\n'
            }
        },
        watch: {
            files: ['css/_*.css'],
            tasks: ['concat']
        }
    });

    grunt.registerTask('default', 'concat');
};

module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        /*less: {
            "admin-css": {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: '<%= pkg.name %>.css.map',
                    sourceMapFilename: 'dist/css/admin-less.css.map'
                },
                src: 'bower_components/less/bootstrap.less',
                dest: 'dist/css/<%= pkg.name %>.css'
            }
        },*/
        concat: {
            options: {
                // define a string to put between each file in the concatenated output
                separator: ''
            },
            "admin-js": {
                // the files to concatenate
                src: [
                    'bower_components/jquery/dist/jquery.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js',
                    'modules/Core/Resources/js/mesour.grid.js',
                    'modules/Core/Resources/js/main.js'
                ],
                // the location of the resulting JS file
                dest: 'public/dist/js/admin.js'
            },
            "admin-css": {
                // the files to concatenate
                src: [
                    'bower_components/bootstrap/dist/css/bootstrap.css',
                    'bower_components/font-awesome/css/font-awesome.css',
                    'modules/Core/Resources/css/mesour.grid.css'
                ],
                // the location of the resulting JS file
                dest: 'public/dist/css/admin.css'
            }
        },
        copy: {
            main: {
                files: [
                    {
                        expand: true,
                        flatten: true,
                        src: ['bower_components/bootstrap/dist/fonts/*','bower_components/font-awesome/fonts/*'],
                        dest: 'public/dist/fonts'
                    }
                ]
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['concat:admin-js','concat:admin-css','copy:main']);

};
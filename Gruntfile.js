module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            dist: {
                src: [
                    'assets/js/modernizr.custom.04582.js',
                    'assets/js/placeholder_polyfill.jquery.js',
                    'assets/js/app.js',
                ],
                dest: 'assets/js/production.js'
            }
        },

        uglify: {
            build: {
                src: 'assets/js/production.js',
                dest: 'assets/js/production.min.js'
            }
        },

        imagemin: {
            options: {
                optimizationLevel: 5
            },
            dynamic: {
                files: [{
                    expand: true,
                    cwd: 'assets/images/',
                    src: ['*/*.{png,jpg,gif}'],
                    dest: 'assets/images/'
                }]
            }
        },

        compass: {
            dist: {
                options: {
                    sassDir: 'assets/css/sass',
                    cssDir: 'assets/css/stylesheets'
                }
            }
        },

        watch: {
            options: {
                livereload: true,
            },
            css: {
                files: '**/*.scss',
                tasks: ['compass']
            },
            html: {
                files: '**/*.html'
            },
            php: {
                files: '**/*.php'
            },
            javascripts: {
                files: 'assets/js/*.js'
            }
        },

        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                eqnull: true,
                browser: true,
                indent: 4,
                unused: true,
                trailing: true,
                strict: false,
                globals: {
                    jQuery: true
                }
            },
            all: ['assets/js/app.js']
        },

        cssmin: {
            combine: {
                files: {
                     'assets/css/stylesheets/production.min.css': 'assets/css/stylesheets/app.css',
                     'assets/css/stylesheets/ie8.min.css': 'assets/css/stylesheets/ie8.css',
                     'assets/css/stylesheets/ie7.min.css': 'assets/css/stylesheets/ie7.css'
                }
            }
        },

        cacheBust: {
            options: {
                encoding: 'utf8',
                algorithm: 'md5',
                length: 16
            },
            assets: {
                files: [{
                    src: ['assets/js/production.min.js']
                }]
            }
        },

        sprites: {
            mainSprite: {
                base: '/assets',
                src: ['assets/images/sprites/src/*.png'],
                css: 'assets/css/sass/_sprite.scss',
                map: 'assets/images/sprites/sprite.png',
                margin: 10
            }
        }

    });


    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-cache-bust');
    grunt.loadNpmTasks('grunt-imagine');

    //use grunt watch to auto compile scss files
    grunt.registerTask('default', ['watch']);

    grunt.registerTask('js', ['jshint']);

    //use grunt production to concat, minify, lint, optimize everything
    grunt.registerTask('production', ['imagemin', 'compass', 'concat', 'uglify', 'jshint', 'cssmin', 'cacheBust']);

};
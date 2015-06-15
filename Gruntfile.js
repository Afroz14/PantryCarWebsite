/*
 Author : Afroz Alam,
 Date   : 18 May 2015
 Copyright : None
*/

var Oven = Oven || {};


//All server related configurations must be put here
Oven.config = {

    cssDir: "public/css/less",
    jsDir: "public/js",
    buildCssDir: "public/css/build",
    buildJsDir: "public/js/build",
    buildImgDir:"public/img",
    privateKeyPath:"/Users/afroz/Downloads/main-website.pem", // gets changed : Depending on the machine from where you are deploying
    websiteLocationOnServer :'/var/www/PantryCarWebsite/',
    websiteLocationOnServerTemp :'/var/www/PantryCarWebsiteTemp/',
    websiteLocationOnServerBackup :'/var/www/PantryCarWebsiteBackup/',
    HostName : '52.10.140.143',
    userName :'ubuntu'
};



module.exports = function(grunt) {

  var _privateKey = grunt.file.exists(Oven.config.privateKeyPath) ? grunt.file.read(Oven.config.privateKeyPath) : '';

  // Load all modules here
   grunt.loadNpmTasks('grunt-ssh');
   grunt.loadNpmTasks('grunt-contrib-cssmin');
   grunt.loadNpmTasks('grunt-contrib-less');
   grunt.loadNpmTasks('grunt-shell');
   grunt.loadNpmTasks('grunt-contrib-uglify');
   grunt.loadNpmTasks('grunt-hashres');
   grunt.loadNpmTasks('grunt-contrib-imagemin');
  

   grunt.initConfig({

    pkg: grunt.file.readJSON("package.json"),
    config: Oven.config,

    less: {
            production: {
                options: {
                    cleancss: false
                },
                files: {
                  '<%= config.buildCssDir %>/app.css' : '<%= config.cssDir %>/app.less',
                }
            }
      },

    // Take the processed style.css file and minify
    cssmin: {
      build: {
        files: {
          '<%= config.buildCssDir %>/app.min.css': '<%= config.buildCssDir %>/app.css'
        }
      }
    },


    uglify: {
        options: {
                 mangle: true,
                  compress: {
                        evaluate: false
                    }
        },
        build: {
            files: {
                '<%= config.buildJsDir %>/app.min.js': [ '<%= config.jsDir %>/jquery-2.1.3.min.js',
                                                                                   '<%= config.jsDir %>/bootstrap.min.js',
                                                                                   '<%= config.jsDir %>/bootbox.min.js',
                                                                                   '<%= config.jsDir %>/jquery-ui.min.js',
                                                                                   '<%= config.jsDir %>/bootstrap-datepicker.min.js',
                                                                                   '<%= config.jsDir %>/nanobar.min.js',
                                                                                   '<%= config.jsDir %>/typehead.min.js',
                                                                                   '<%= config.jsDir %>/main.js',
                                                                                   
                                                                                    ],
                '<%= config.buildJsDir %>/cart.min.js':  ['<%= config.jsDir %>/cart.js']
            }
        }
   },

  imagemin: {
            png: {
                options: {
                    optimizationLevel: 7
                },
                files: [{
                    expand: true,
                    cwd: '<%= config.buildImgDir %>',
                    src: ['**/*.png'],
                    dest: '<%= config.buildImgDir %>',
                    ext: '.png'
                }]
            },
            jpg: {
                options: {
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: '<%= config.buildImgDir %>',
                    src: ['**/*.jpg'],
                    dest: '<%= config.buildImgDir %>',
                    ext: '.jpg'
                }]
            }
    },

   sshconfig:{
       
        prodServer: {
            host: "<%= config.HostName %>",
            username: "<%= config.userName %>",
            privateKey: _privateKey,
            agent: process.env.SSH_AUTH_SOCK
      }

    },


   shell: {

     cleanBuilds: {
                command: [
                    'rm -rf <%= config.buildCssDir %>/*',
                    'rm -rf <%= config.buildJsDir %>/*'
                ].join(' && ')
      },
      pull:{
        command:[
                    'git stash',
                    'git checkout master',
                    'git pull origin master',
          ].join(' && ')
       },
       readyToShip:{
           command:[
                'echo "--------------------------------------------------"',
                'echo "--------------------------------------------------\n"',
                'echo "             Ship it \\m\/"',
                'echo "\n--------------------------------------------------"',
                'echo "--------------------------------------------------"',
            ].join(' && ')
       }
   },

   sshexec: {    
         deploy: {
                command: [
                    'sudo cp --preserve=mode,ownership,timestamps -r <%= config.websiteLocationOnServer %> <%= config.websiteLocationOnServerTemp %>',
                    'sudo chmod -R 777 <%= config.websiteLocationOnServerTemp %>',
                    'cd <%= config.websiteLocationOnServerTemp %>',
                    'sudo git stash',
                    'sudo git checkout master',
                    'sudo git pull origin master',
                    'echo "Cleaning Css build directory ..." ;rm -rf <%= config.websiteLocationOnServerTemp %>/<%= config.buildCssDir %>/*',
                    'echo "Cleaning Js build directory ..." ;rm -rf <%= config.websiteLocationOnServerTemp %>/<%= config.buildJsDir %>/*',
                    'sudo chmod 777 resources/views/footer.blade.php',
                    'sudo chmod 777 resources/views/meta.blade.php',
                    'sudo chmod 777 resources/views/restaurant-page.blade.php',
                    'sudo chmod 777 resources/views/user-cart.blade.php',
                    'grunt unlock;grunt build'
                ].join(' && '),    
            options:{
                config: 'prodServer'
            }
          },
        makeBuildLive: {
                command: [
                'sudo mv <%= config.websiteLocationOnServer %> <%= config.websiteLocationOnServerBackup %>',
                'sudo mv <%= config.websiteLocationOnServerTemp %> <%= config.websiteLocationOnServer %>',
                'sudo rm -rf <%= config.websiteLocationOnServerBackup %> || mv <%= config.websiteLocationOnServerBackup %> <%= config.websiteLocationOnServer %>'
                ].join(' && '),    
            options:{
                config: 'prodServer'
            }
          },
     } , 

     hashres: {
        options: {
            encoding: 'utf8',
            fileNameFormat: '${name}.${hash}.${ext}',
            renameFiles: true
        },

        stage: {
            
            options: {
                // You can override encoding, fileNameFormat or renameFiles
            },
            
            src: [
                 '<%= config.buildCssDir %>/app.min.css' ,
                 '<%= config.buildJsDir %>/app.min.js',
                 '<%= config.buildJsDir %>/cart.min.js',
            ],
            dest: ['resources/views/footer.blade.php','resources/views/meta.blade.php','resources/views/restaurant-page.blade.php','resources/views/user-cart.blade.php']
        }
   },     

    watch: {
      styles: {
        files: ['<%= config.cssDir %>**/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }

  });

   grunt.registerTask('lock', function() {
        var isLocked = grunt.file.exists('.lock');
        if(isLocked) {
            grunt.fail.fatal("Another deployment in progress. Please wait until it is finished for next deployment");
        } else {
            grunt.file.write('.lock', "1");
        }
    });

   grunt.registerTask('unlock', function() {
        grunt.file.delete('.lock');
    });



    grunt.registerTask('default' ,'localbuild');
    grunt.registerTask('localbuild', ['lock','shell:cleanBuilds','less:production','cssmin','uglify','shell:readyToShip','unlock']);
    grunt.registerTask('deploy',['lock','sshexec:deploy','unlock'])
    grunt.registerTask('build', ['lock','shell:cleanBuilds','less:production','cssmin','uglify','hashres','imagemin','shell:readyToShip','unlock']);
    grunt.registerTask('shipit',['lock','sshexec:makeBuildLive','unlock']);
    grunt.registerTask('imageminify' ,'imagemin');


};

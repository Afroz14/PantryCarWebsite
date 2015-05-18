/*
 Author : Afroz Alam,
 Date   : 18 May 2015
 Copyright : None
*/

var Oven = Oven || {};

//All server related configurations must be put here
Oven.config = {
    cssDir: "public/css/less",
    buildCssDir: "public/css/build",
    buildJsDir: "public/js/build",
    privateKeyPath:"~/Downloads/main-website.pem", // gets change depending on the machine you are deploying
    websiteLocationOnServer :'/var/www/PantryCarWebsite/',
    HostName : '52.25.132.48',
    userName :'ubuntu',
};


module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  // Load all modules here
  grunt.loadNpmTasks('grunt-ssh');
  grunt.loadNpmTasks('grunt-shell');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  

  grunt.initConfig({

    pkg: grunt.file.readJSON("package.json"),
    config: Oven.config,

    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "<%= config.buildCssDir %>/app.css": "<%= config.cssDir %>/app.less" // destination file and source file
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
                '<%= config.buildJsDir %>/app.min.js': ['public/js/jquery-2.1.3.min.js', 'public/js/bootstrap.min.js','public/js/bootbox.min.js','public/js/jquery-ui.min.js','public/js/bootstrap-datepicker.min.js','public/js/main.js','public/js/nanobar.min.js','public/js/typehead.min.js'],
            }
        }
  },

  sshconfig:{
      prodServer: {
          host: "<%= config.HostName %>",
          username: "<%= config.userName %>",
          agent: process.env.SSH_AUTH_SOCK
    }
  },


   shell: {
       deployOnServer: {
           command: ['eval `ssh-agent -s`', 'ssh-add <%= config.privateKeyPath %>', 'grunt sshexec:pullAndClean'].join(' && ')
       },
       cleanBuilds: {
                command: [
                    'rm -rf <%= config.buildCssDir %>/*',
                    'rm -rf <%= config.buildJsDir %>/*'
                ].join(' && ')
      },
       publishBuild:{
           command:['scp -i <%= config.privateKeyPath %> <%= config.buildCssDir %>/app.min.css <%= config.userName %>@<%= config.HostName %>:<%= config.websiteLocationOnServer %>/<%= config.buildCssDir %>',
                    'scp -i <%= config.privateKeyPath %> <%= config.buildJsDir %>/app.min.js <%= config.userName %>@<%= config.HostName %>:<%= config.websiteLocationOnServer %>/<%= config.buildJsDir %>',
                  ].join(' && ')
       }
   },

  sshexec: {    
         pullAndClean: {
                command: [
                    'cd <%= config.websiteLocationOnServer %>',
                    'sudo git stash',
                    'sudo git checkout master',
                    'sudo git pull origin master',
                    'echo "Cleaning Css build directory ..." ;rm -rf <%= config.websiteLocationOnServer %>/<%= config.buildCssDir %>/*',
                    'echo "Cleaning Js build directory ..." ;rm -rf <%= config.websiteLocationOnServer %>/<%= config.buildJsDir %>/*'
                ].join(' && '),    
            options:{
                config: 'prodServer'
            }
          },
     } ,      

    watch: {
      styles: {
        files: ['<%= pkg.cssdir %>**/*.less'], // which files to watch
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

   grunt.registerTask('deploy', ['lock','shell:cleanBuilds','less','cssmin','uglify','shell:deployOnServer','shell:publishBuild','unlock']);

};

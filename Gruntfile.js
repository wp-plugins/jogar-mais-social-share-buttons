module.exports = function(grunt) {
	var config = {
		package : grunt.file.readJSON( 'package.json' ),

		concat : {
		    options : {
				separator : ';'
		    },
		    site : {
				src : [
					'<%= package.scriptroot %>/boot.js',
					'<%= package.scriptroot %>/app/*.js'
				],
				dest : '<%= package.scriptroot %>/script.min.js',
		    },
		    admin : {
				src : [
					'<%= package.scriptroot %>/admin/boot.js',
					'<%= package.scriptroot %>/admin/theme-options.js'
				],
				dest : '<%= package.scriptroot %>/admin/script-admin.min.js',
		    },
  		},

		compass : {
			site : {
				options : {
					sassDir     : '<%= package.cssroot %>',
					cssDir      : '<%= package.cssroot %>',
					environment : 'production'
				},
				files : {
					'style.css' : '<%= package.cssroot %>/style.scss',
					'admin.css' : '<%= package.cssroot %>/admin.scss'
				}
			},
		},


  		uglify : {
			site : {
				files : {
					'<%= concat.site.dest %>'  : '<%= concat.site.dest %>',
					'<%= concat.admin.dest %>' : '<%= concat.admin.dest %>'
				}
			}
    	},

		watch: {
			css : {
				files : ['assets/stylesheet/**/*.scss'],
				tasks : ['compass']
			},
		    script : {
		    	files : ['<%= concat.site.src %>', '<%= concat.admin.src %>'],
		    	tasks : ['concat', 'uglify']
		    }
  		}
	};

	grunt.initConfig( config );

	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-compass' );

	grunt.registerTask( 'jsmin', ['concat', 'uglify'] );
	grunt.registerTask( 'deploy', ['jsmin', 'compass'] );
};
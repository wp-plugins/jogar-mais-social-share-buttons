module.exports = function(grunt) {

	function getObjectConcat(folder) {
		return {
			src : [
				'<%= package.scripstroot %>/base/*.js',
				'<%= package.scripstroot %>/' + folder + '/libs/*.js',
				'<%= package.scripstroot %>/vendor/*.js',
				'<%= package.scripstroot %>/' + folder + '/vendor/*.js',
				'<%= package.scripstroot %>/' + folder + '/app/*.js',
				'<%= package.scripstroot %>/' + folder + '/boot.js'
			],
			dest : '<%= package.scripstroot %>/built.' + folder + '.js',
		};
	}

	var config = {
		package : grunt.file.readJSON( 'package.json' ),

		concat : {
		    options : {
				separator : ';'
		    },
		    admin : getObjectConcat( 'admin' ),
		    front : getObjectConcat( 'front' )
  		},

		sass: {
			site: {
				options: {
					style: 'compressed',
					'sourcemap=none': '',
				},
				files: {
					'<%= package.cssroot %>/admin.css': '<%= package.cssadmin %>/admin.scss',
					'<%= package.cssroot %>/style.css': '<%= package.cssfront %>/style.scss'
				}
			},
		},

  		jshint: {
			options: {
				jshintrc : true
			},
    		beforeconcat : ['<%= concat.admin.src %>', '<%= concat.front.src %>']
  		},

  		uglify : {
			site : {
				files : {
					'<%= concat.admin.dest %>' : '<%= concat.admin.dest %>',
					'<%= concat.front.dest %>' : '<%= concat.front.dest %>'
				}
			}
    	},

		watch: {
		    site : {
		    	files : ['<%= concat.admin.src %>', '<%= concat.front.src %>'],
		    	tasks : ['jshint', 'concat', 'uglify']
		    },
			css : {
				files : ['<%= package.cssroot %>/**/*.scss'],
				tasks : ['sass:site']
			},
  		}
	};

	grunt.initConfig( config );

	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );

	grunt.registerTask( 'js', ['jshint', 'concat'] );
	grunt.registerTask( 'jsmin', ['jshint', 'concat', 'uglify'] );
	grunt.registerTask( 'deploy', ['jsmin', 'sass:site'] );
};
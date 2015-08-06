module.exports = function(grunt) {
	var config = {
		package : grunt.file.readJSON( 'package.json' ),

		concat : {
		    options : {
				separator : ';'
		    },
		    site : {
				src : [
					'<%= package.webroot %>/libs/*.js',
					'<%= package.webroot %>/app/*.js',
					'<%= package.webroot %>/boot.js'
				],
				dest : '<%= package.webroot %>/script.min.js',
		    },
		    admin : {
				src : [
					'<%= package.webroot %>/libs/*.js',
					'<%= package.webroot %>/admin/application.js',
					'<%= package.webroot %>/admin/script-admin.js',
					'<%= package.webroot %>/boot.js'
				],
				dest : '<%= package.webroot %>/admin/script-admin.min.js',
		    },
  		},

  		uglify : {
			site : {
				files : {
					'<%= concat.site.dest %>' : '<%= concat.site.dest %>',
					'<%= concat.admin.dest %>' : '<%= concat.admin.dest %>'
				}
			}
    	},

		watch: {
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

	grunt.registerTask( 'jsmin', ['concat', 'uglify'] );
	grunt.registerTask( 'deploy', ['jsmin'] );
};
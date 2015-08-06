Module( 'SHARE.Application', function( Application ) {
	Application.fn.initialize = function( container ) {
		this.container = container;
		this.init();
	};

	Application.fn.init = function() {
		SHARE.themeOptions( this.container );
	};
});
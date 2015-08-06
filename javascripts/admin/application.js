Module( 'SHARE.Application', function( Application ) {
	Application.fn.initialize = function( container ) {
		this.container = container;
		SHARE.themeOptions( this.container );
	};
});
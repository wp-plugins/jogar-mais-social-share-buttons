Module( 'SHARE.HideElements', function( HideElements ) {
	HideElements.fn.initialize = function( container ) {
		this.container     = container;
		this.themeTwo      = this.container.find( '.jm-ssb-container-theme-two' );
		this.elementCount  = this.themeTwo.find( '.count' );
		this.themeTwoWidth = this.themeTwo.css( 'width' );
		this.linkedin      = this.themeTwo.find( '.linkedin-share' );
		this.init();
	};

	HideElements.fn.init = function() {
		this.hideElement();
	};

	HideElements.fn.hideElement = function() {
		if ( 450 > parseFloat( this.themeTwoWidth ) ) {
			this.linkedin.addClass( 'jm-ssb-hide' );
		}

		if ( 655 > parseFloat( this.themeTwoWidth ) ) {
			this.elementCount.addClass( 'jm-ssb-hide' );
		}
	};
});
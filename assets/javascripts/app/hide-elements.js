Module( 'SHARE.HideElements', function( HideElements ) {
	HideElements.fn.initialize = function( container ) {
		this.container       = container;
		this.themeLarge      = this.container.find( '.jm-ssb-container-theme-two' );
		this.elementCount    = this.themeLarge.find( '.count' );
		this.themeLargeWidth = this.themeLarge.css( 'width' );
		this.linkedin        = this.themeLarge.find( '.linkedin-share' );
		this.init();
	};

	HideElements.fn.init = function() {
		this.hideElement();
	};

	HideElements.fn.hideElement = function() {
		if ( 650 >= parseFloat( this.themeLargeWidth ) ) {
			this.elementCount.hide();

		} else if ( 450 > parseFloat( this.themeLargeWidth ) ) {
			this.linkedin.hide();
		}
	};

});
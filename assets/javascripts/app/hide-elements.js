;(function(context) {

	'use strict';

	function HideElements( container ) {
		this.container     = container;
		this.themeTwo      = this.container.find( '.jm-share-container-theme-two' );
		this.elementCount  = this.themeTwo.find( '.count' );
		this.themeTwoWidth = this.themeTwo.css( 'width' );
		this.linkedin      = this.themeTwo.find( '.linkedin-share' );
		this.init();
	};

	HideElements.prototype.init = function() {
		this.hideElement();
	};

	HideElements.prototype.hideElement = function() {
		if ( 450 > parseFloat( this.themeTwoWidth ) ) {
			this.linkedin.addClass( 'jm-share-hide' );
		}

		if ( 655 > parseFloat( this.themeTwoWidth ) ) {
			this.elementCount.addClass( 'jm-share-hide' );
		}
	};

	context.HideElements = HideElements;

})( window );
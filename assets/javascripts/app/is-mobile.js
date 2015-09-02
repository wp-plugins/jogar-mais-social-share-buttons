;(function(context) {

	'use strict';

	function isMobile( container ) {
		this.container = container;
		this.element   = this.container.find( '.jm-share-social' );
		this.reference = window.innerWidth;
		this.checkMobile();
	};

  	isMobile.prototype.checkMobile = function() {
		if  ( 'ontouchstart' in window ) {
			this.element.find( '.jm-share-whatsapp' ).addClass( 'jm-share-show' );
			this.element.find( '.jm-share-gmail' ).addClass( 'jm-share-hide' );
			this.element.find( '.jm-share-email' ).addClass( 'jm-share-hide' );
			this.element.find( '.jm-share-print-friendly' ).addClass( 'jm-share-hide' );
		}
  	};

	context.isMobile = isMobile;

})( window );
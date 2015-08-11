Module( 'SHARE.isMobile', function( isMobile ) {
	isMobile.fn.initialize = function( container ) {
		this.container = container;
		this.element   = this.container.find( '.jm-ssb-social' );
		this.reference = window.innerWidth;
		this.checkMobile();
	};

  	isMobile.fn.checkMobile = function() {
		if  ( 'ontouchstart' in window ) {
			this.element.find( '.jm-ssb-whatsapp' ).addClass( 'jm-ssb-show' );
			this.element.find( '.jm-ssb-sms' ).addClass( 'jm-ssb-show' );
			this.element.find( '.jm-ssb-gmail' ).addClass( 'jm-ssb-hide' );
			this.element.find( '.jm-ssb-email' ).addClass( 'jm-ssb-hide' );
			this.element.find( '.jm-ssb-print-friendly' ).addClass( 'jm-ssb-hide' );
		}
  	};
});
Module( 'SHARE.isMobile', function( isMobile ) {
	isMobile.fn.initialize = function( container ) {
		this.container = container;
		this.dWhatsApp = this.container.find( '.jm-ssb-social' );
		this.reference = window.innerWidth;
		this.checkMobile();
	};

  	isMobile.fn.checkMobile = function() {
		if  ( 'ontouchstart' in window ) {
			this.dWhatsApp.find( '.jm-ssb-whatsapp' ).css({ 'display' : 'inline-block' });
			this.dWhatsApp.find( '.jm-ssb-sms' ).css({ 'display' : 'inline-block' });
			this.dWhatsApp.find( '.jm-ssb-gmail' ).hide();
			this.dWhatsApp.find( '.jm-ssb-email' ).hide();
			this.dWhatsApp.find( '.jm-ssb-print-friendly' ).hide();
		}
  	};
});
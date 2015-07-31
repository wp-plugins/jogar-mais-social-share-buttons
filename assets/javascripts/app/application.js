Module( 'SHARE.Application', function( Application ) {
	Application.fn.initialize = function( container ) {
		this.container        = container;
		this.buttonsContainer = jQuery( '[data-element-jm-ssb]' );

		this.jmPopupOpen();
		SHARE.isMobile( this.container );
		SHARE.CounterSocialShare( this.buttonsContainer );
	};

	Application.fn.jmPopupOpen = function() {
		var self = this;
		
		this.container.on( 'click', '[data-action=open-popup]', function(event) {
			event.preventDefault();

			var target = jQuery( this )
			  , width  = '600'
			  , height = '400';

			self.jmPopupCenter(
				target.data( 'attr-url' ),
				'Compartilhar',
				width,
				height
			);
		});
	};

	Application.fn.jmPopupCenter = function( url, title, width, height ) {
		var left
		  , top;
		width  = ( width  || screen.width );
		height = ( height || screen.height );
		left   = ( screen.width * 0.5 ) - ( width * 0.5 );
		top    = ( screen.height * 0.5 ) - ( height * 0.5 );

		return window.open(
			url,
			title,
			'menubar=no,toolbar=no,status=no,width=' + width + ',height=' + height + ',toolbar=no,left=' + left + ',top=' + top
		);
	};

});
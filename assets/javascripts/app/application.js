;(function(context) {

	'use strict';

	function Application( container ) {
		this.container = container;
		this.init();
	};

	Application.prototype.init = function() {
		this.popupOpen();
	};

	Application.prototype.popupOpen = function() {
		var self = this;

		this.container.on( 'click', '[data-action=open-popup]', function(event) {
			event.preventDefault();

			var target = jQuery( event.currentTarget )
			  , width  = '685'
			  , height = '500';

			self.popupCenter(
				target.data( 'attr-url' ),
				'Compartilhar',
				width,
				height
			);
		});
	};

	Application.prototype.popupCenter = function( url, title, width, height ) {
		var left
		  , top;
		width  = ( width  || screen.width );
		height = ( height || screen.height );
		left   = ( screen.width * 0.5 ) - ( width * 0.5 );
		top    = ( screen.height * 0.5 ) - ( height * 0.5 );

		return window.open(
			  url
			, title
			, 'menubar=no,toolbar=no,status=no,width=' + width + ',height=' + height + ',toolbar=no,left=' + left + ',top=' + top
		);
	};

	context.Application = Application;

})( window );
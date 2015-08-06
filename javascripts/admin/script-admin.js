Module( 'SHARE.themeOptions', function( themeOptions ) {
	themeOptions.fn.initialize = function( container ) {
		this.container = container;
		this.iconsDefault = this.container.find( '.jm-ssb-icons-default' );
		this.iconsTwo     = this.container.find( '.option-theme-secondary' );
		this.themeCounter = this.container.find( '.option-theme-total-counter' );
		this.init();
	};

	themeOptions.fn.init = function() {
		this.addEventListener();
	};

	themeOptions.fn.addEventListener = function() {
		this.container.on( 'change', '.setting-buttons-themes', this._onChange.bind( this ) );
	};

	themeOptions.fn._onChange = function( event ) {

		if ( event.originalEvent.target.value == 0 ) {
		 	this.iconsDefault.toggle('slow').css({display: 'block' });
		 	this.iconsTwo.fadeOut('fast');
		 	this.themeCounter.fadeOut('fast');
		}

		if ( event.originalEvent.target.value == 1 ) {
		 	this.iconsTwo.toggle('slow').css({display: 'block' });
		 	this.iconsDefault.fadeOut('fast');
		 	this.themeCounter.fadeOut('fast');
		}

		if ( event.originalEvent.target.value == 2 ) {
		 	this.themeCounter.toggle('slow').css({display: 'block' });
		 	this.iconsDefault.fadeOut('fast');
		 	this.iconsTwo.fadeOut('fast');
		}
	};
});
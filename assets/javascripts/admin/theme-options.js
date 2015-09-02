;(function(context) {

	'use strict';

	function ThemeOptions( container ) {
		this.container    = container;
		this.iconsDefault = this.container.find( '.jm-share-icons-default' );
		this.iconsTwo     = this.container.find( '.option-theme-secondary' );
		this.themeCounter = this.container.find( '.option-theme-total-counter' );
		this.addEventListener();
	};

	ThemeOptions.prototype.addEventListener = function() {
		this.container.on( 'change', '.setting-buttons-themes', this._onChange.bind( this ) );
	};

	ThemeOptions.prototype._onChange = function( event ) {
		var value = parseFloat( event.originalEvent.target.value );

		return this.hasValue( value );
	};

	ThemeOptions.prototype.hasValue = function(value) {
		switch( value ) {
			case 0 :
				return this.displayImage0();
				break;
			case 1 :
				return this.displayImage1();
				break;
			case 2 :
				return this.displayImage2();
				break;
		}
	};

	ThemeOptions.prototype.displayImage0 = function() {
	 	this.iconsDefault.toggle('slow').css({display: 'block' });
	 	this.iconsTwo.fadeOut('fast');
	 	this.themeCounter.fadeOut('fast');
	};

	ThemeOptions.prototype.displayImage1 = function() {
	 	this.iconsTwo.toggle('slow').css({display: 'block' });
	 	this.iconsDefault.fadeOut('fast');
	 	this.themeCounter.fadeOut('fast');
	};

	ThemeOptions.prototype.displayImage2 = function() {
	 	this.themeCounter.toggle('slow').css({display: 'block' });
	 	this.iconsDefault.fadeOut('fast');
	 	this.iconsTwo.fadeOut('fast');
	};

	context.ThemeOptions = ThemeOptions;

})( window );
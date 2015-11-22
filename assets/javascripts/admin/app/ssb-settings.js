;(function($, context) {

	"use strict";

	var SsbSettings = function(container) {
		this.container     = container;
		this.prefix        = window.ssbPrefix;
		this.positionFixed = container.find( '.' + this.prefix + '-position-fixed' );
		this.positionCheck = this.positionFixed.find( 'input[type="checkbox"]' );
		this.layoutOptions = container.find( '.' + this.prefix + '-layout-options' );
		this.inputLayouts  = container.find( 'input[type="radio"]' );
		this.layoutChecked = this.layoutOptions.find( 'input:checked' );
		this.layoutButtons = this.layoutOptions.find( '#' + this.prefix + '-buttons' );
		this.init();
	};

	SsbSettings.prototype.init = function() {
		this.addEventListener();
	};

	SsbSettings.prototype.addEventListener = function() {
		this.positionCheck.on( 'change', this._onChangeFixed.bind( this ) );
		this.inputLayouts.on( 'change', this._onChangeLayout.bind( this ) );
	};

	SsbSettings.prototype._onChangeFixed = function(event) {
		var oldChecked    = this.layoutChecked.attr( 'id' )
		  , layoutChecked = this.layoutOptions.find( '#' + oldChecked )
		;

		if( event.currentTarget.checked ) {
			this.layoutButtons.prop( 'checked', true );
			return;
		}

		layoutChecked.prop( 'checked', true );
	};

	SsbSettings.prototype._onChangeLayout = function(event) {
		var layoutButtons = event.currentTarget.value;

		if( this.positionCheck.is( ':checked' ) ) {
			this.positionCheck.prop( 'checked', false );
		}
	};

	context.SsbSettings = SsbSettings;

})( jQuery, window );
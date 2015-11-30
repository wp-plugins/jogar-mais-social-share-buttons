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
		this.contentBefore = container.find( '#' + this.prefix + '-before:checked' );
		this.contentAfter  = container.find( '#' + this.prefix + '-after:checked' );
		this.contentFixed  = container.find( '#' + this.prefix + '-fixed' );
		this.before        = container.find( '#' + this.prefix + '-before' );
		this.after         = container.find( '#' + this.prefix + '-after' );
		this.init();
	};

	SsbSettings.prototype.init = function() {
		this.addEventListener();
	};

	SsbSettings.prototype.addEventListener = function() {
		this.before.on( 'change', this._beforeAfter.bind( this ) );
		this.after.on( 'change', this._beforeAfter.bind( this ) );
		this.positionCheck.on( 'change', this._onChangeFixed.bind( this ) );
		this.inputLayouts.on( 'change', this._onChangeLayout.bind( this ) );
		this.contentFixed.on( 'change', this._onChangeFixed.bind( this ) );
	};

	SsbSettings.prototype._onChangeFixed = function(event) {
		var oldChecked    = this.layoutChecked.attr( 'id' )
		  , layoutChecked = this.layoutOptions.find( '#' + oldChecked )
		;

		if( event.currentTarget.checked ) {
			this.placesAvaiable( false, true );
			this.layoutButtons.prop( 'checked', true );
			this.positionCheck.prop( 'checked', true );
			return;
		}

		this.placesAvaiable( true, false );
		layoutChecked.prop( 'checked', true );
		this.positionCheck.prop( 'checked', false );
	};

	SsbSettings.prototype._onChangeLayout = function(event) {
		var layoutButtons = event.currentTarget.value;

		if( this.positionCheck.is( ':checked' ) ) {
			this.content( true );
			this.contentFixed.prop( 'checked', false );
			this.positionCheck.prop( 'checked', false );
		}
	};

	SsbSettings.prototype._beforeAfter = function(event) {
		this.positionCheck.prop( 'checked', false );
		this.contentFixed.prop( 'checked', false );
	};

	SsbSettings.prototype.placesAvaiable = function( status, fixed ) {
		this.content( status );
		this.contentFixed.prop( 'checked', fixed );
	};

	SsbSettings.prototype.content = function( status ) {
		if ( this.before.is( ':checked' ) || this.after.is( ':checked' ) ) {
			this.after.prop( 'checked', status );
			this.before.prop( 'checked', status );
		}

		this.contentAfter.prop( 'checked', status );
		this.contentBefore.prop( 'checked', status );
	};

	context.SsbSettings = SsbSettings;

})( jQuery, window );
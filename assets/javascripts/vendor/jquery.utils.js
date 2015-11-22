;(function($) {

	$.prototype.byElement = function(name) {
		return this.find( '[data-element="' + name + '"]' );
	};

	$.prototype.byData = function(name) {
		return this.find( '[data-' + name + ']');
	};

	$.prototype.byAction = function(name) {
		return this.find( '[data-action="' + name + '"]' );
	};

	$.prototype.byComponent = function(name) {
		return this.find( '[data-component="' + name + '"]' );
	};

	$.prototype.isExist = function(selector, callback) {
		var element = this.find( selector );

		if ( element.length && typeof callback == 'function' ) {
			callback.call( null, element, this );
		}

		return element.length;
	};

	$.prototype.compileHandlebars = function() {
		return Handlebars.compile( this.html() );
	};

	$.prototype.fadeOutRemove = function(time) {
		this.fadeOut(time, function() {
			this.remove();
		}.bind( this ) );
	};

	$.prototype.isEmptyValue = function() {
		return !( $.trim( this.val() ) );
	};

	$.prototype.valInt = function() {
		return parseInt( this.val(), 10 );
	};

	$.prototype.addClassReFlow = function(name) {
		this.css( 'display', 'block' );
		this[0].offsetWidth;
		this.addClass( name );
	};

	$.prototype.getUrlAjax = function() {
		return ( window.PluginGlobalVars || {} ).urlAjax;
	};

})( jQuery );

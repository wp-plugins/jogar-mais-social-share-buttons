;(function($) {

	$.fn.getUrlAjax = function() {
		return ( window.PluginGlobalVars || {} ).urlAjax;
	};

	$.fn.byData = function(dataAttr) {
		return $(this).find( '[data-' + dataAttr + ']' );
	};

 }) ( jQuery );
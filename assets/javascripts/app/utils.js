Module( 'SHARE.Utils', function(Utils) {

	Utils.toTitleCase = function(text) {
	    text = text.replace(/(?:^|-)\w/g, function(match) {
	        return match.toUpperCase();
	    });

	    return text.replace(/-/g, '');
	};

	Utils.getTime = function() {
		return ( new Date() ).getTime();
	};

	Utils.getUrlAjax = function() {
		return ( window.PluginGlobalVars || {} ).urlAjax;
	};

}, {} );

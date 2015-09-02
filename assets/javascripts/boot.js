function VfSocialShare(container) {
	var buttonsGeneral = container.byData( 'element-jm-share' );

	if ( buttonsGeneral.length ) {
		var application        = new Application( container );
		var countersocialshare = new CounterSocialShare( buttonsGeneral );
		var ismobile           = new isMobile( container );
		var hideelements       = new HideElements( container );
	}
};

jQuery(function() {
  VfSocialShare( jQuery( 'body' ) );
});
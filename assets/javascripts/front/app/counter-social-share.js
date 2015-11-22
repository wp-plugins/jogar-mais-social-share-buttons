;(function(context) {

	'use strict';

	var requests = {};

	var CounterSocialShare = function(container) {
		this.container        = container;
		this.reference        = this.container.data( 'attr-reference' );
		this.nonce            = this.container.data( 'attr-nonce' );
		this.url              = this.container.data( 'element-url' );
		this.facebook         = this.container.byElement( 'facebook' );
		this.twitter          = this.container.byElement( 'twitter' );
		this.google           = this.container.byElement( 'google-plus' );
		this.pinterest        = this.container.byElement( 'pinterest' );
		this.linkedin         = this.container.byElement( 'linkedin' );
		this.totalShare       = this.container.byElement( 'total-share' );
		this.totalCounter     = 0;
		this.facebookCounter  = 0;
		this.twitterCounter   = 0;
		this.googleCounter    = 0;
		this.linkedinCounter  = 0;
		this.pinterestCounter = 0;
		this.max              = 5;
		this.doubleMax        = 10;
		this.init();
	};

	CounterSocialShare.prototype.init = function() {
		this.request();
		this.addEventListeners();
	};

	CounterSocialShare.prototype.addEventListeners = function() {
		var openPopup = this.container.byAction( 'open-popup' );
		openPopup.on( 'click', this._onClickSendRequest.bind( this ) );
	};

	CounterSocialShare.prototype._onClickSendRequest = function(event) {
		this.sendRequest();
	};

	CounterSocialShare.prototype.request = function() {
		var items = [
			{
				reference : 'facebookCounter',
				element   : 'facebook',
				url       : 'http://graph.facebook.com/?id=' + this.url
			},
			{
				reference : 'twitterCounter',
				element   : 'twitter',
				url	      : 'http://cdn.api.twitter.com/1/urls/count.json?url=' + this.url
			},
			{
				reference : 'googleCounter',
				element   : 'google',
				url       : this.container.getUrlAjax(),
				data      : this.getParamsGoogle()
			},
			{
				reference : 'linkedinCounter',
				element   : 'linkedin',
				url       : 'http://www.linkedin.com/countserv/count/share?url=' + this.url
			},
			{
				reference : 'pinterestCounter',
				element   : 'pinterest',
				url       : 'http://api.pinterest.com/v1/urls/count.json?url=' + this.url
			}
		];

		this._eachAjaxSocial( items );
	};

	CounterSocialShare.prototype._eachAjaxSocial = function(items) {
		items.forEach( this._iterateItems.bind( this ) );
	};

	CounterSocialShare.prototype._iterateItems = function(item) {
		this.doubleMax -= 1;

		if ( requests[item.element] && this.doubleMax ) {
			return;
		}

		this._getJSON( item );
		this._setNewRequest( item );
	};

	CounterSocialShare.prototype._getJSON = function(request) {
		var args = jQuery.extend({
			data     : {},
			dataType : 'jsonp',
  			cache    : false
		}, request )
		  , ajax = jQuery.ajax( args )
	    ;

		ajax.done( jQuery.proxy( this, '_done', request ) );
		ajax.fail( jQuery.proxy( this, '_fail', request ) );
	};

	CounterSocialShare.prototype._done = function(request, response) {
		var number              = this.getNumberByData( response );
		this[request.reference] = number;
		this.max               -= 1;
		this.totalCounter      += parseFloat( number );
		this[request.element].text( number );

		if ( 0 === this.max ) {
			this.totalShare.text( this.totalCounter );
		}
	};

	CounterSocialShare.prototype._fail = function(request, throwError, status) {
		this[request.reference] = 0;
		this[request.element].text( 0 );
	};

	CounterSocialShare.prototype._setNewRequest = function(item) {
		requests[item.element] = true;
	};

	CounterSocialShare.prototype.getNumberByData = function(data) {
		return ( parseFloat( data['shares'] ) + parseFloat( data['comments'] ) || data['shares'] || data['count'] || 0 );
	};

	CounterSocialShare.prototype.getParamsGoogle = function() {
		return {
			action : 'get_plus_google',
			url    : this.url
		};
	};

	CounterSocialShare.prototype.sendRequest = function() {
		jQuery.ajax({
	       method : 'POST',
	       url    : this.container.getUrlAjax(),
	       data   : {
	       	action          : 'global_counts_social_share',
		    reference       : this.reference,
		    count_facebook  : this.facebookCounter,
		    count_twitter   : this.twitterCounter,
		    count_google    : this.googleCounter,
		    count_linkedin  : this.linkedinCounter,
		    count_pinterest : this.pinterestCounter,
		    nonce           : this.nonce
	      }
	   });
	};

	context.CounterSocialShare = CounterSocialShare;

})( window );
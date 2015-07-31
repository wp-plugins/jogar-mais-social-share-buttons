<?php
/**
 *
 * @package Social Share Buttons | Ajax
 * @author  Victor Freitas
 * @subpackage Ajax Controller
 * @version 1.0.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

class Ajax_Controller
{
	/**
	* Nonce
	*
	* @since 1.0
	* @var string
	* @return string
	*/
	const AJAX_VERIFY_NONCE_COUNTER = 'jm-counter-social-share';

	public static function get_plus_google()
	{
		$url = Utils_Helper::request( 'url', false, 'esc_url' );

		if ( ! $url ) :
			http_response_code( 500 );
			Utils_Helper::error_server_json( 'url_is_empty' );
			exit(0);
		endif;

		$posts_fiels = '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';

        $cheader = curl_init();
        //set option curl
        curl_setopt($cheader, CURLOPT_URL, "https://clients6.google.com/rpc");
        curl_setopt($cheader, CURLOPT_POST, 1);
        curl_setopt($cheader, CURLOPT_POSTFIELDS, $posts_fiels);
        curl_setopt($cheader, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $cheader, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $cheader, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($cheader, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $curl_results = curl_exec($cheader);
        curl_close ($cheader);

		$results = json_decode( $curl_results, true );
		$results = json_encode( self::_get_global_counts_google( $results ) );
		
		header( 'Content-Type: application/javascript; charset=utf-8' );
		echo $_REQUEST[ 'callback' ] . "({$results})";
		exit(1);
	}

	private static function _get_global_counts_google( $results )
	{
		$global_count = $results[0]['result']['metadata']['globalCounts'];

		if ( empty( $global_count ) OR is_null( $global_count ) )
			return array( 'count' => 0 );

		return $global_count;
	}

	public static function global_counts_social_share()
	{
		$post_id         = Utils_Helper::request( 'reference', false, 'intval' );
		$count_facebook  = Utils_Helper::request( 'count_facebook', 0, 'intval' );
		$count_twitter   = Utils_Helper::request( 'count_twitter', 0, 'intval' );
		$count_google    = Utils_Helper::request( 'count_google', 0, 'intval' );
		$count_linkedin  = Utils_Helper::request( 'count_linkedin', 0, 'intval' );
		$count_pinterest = Utils_Helper::request( 'count_pinterest', 0, 'intval' );
		$nonce 		     = Utils_Helper::request( 'nonce', false, 'esc_html' );

		if ( ! $post_id ) :
			Utils_Helper::error_server_json( 'reference_not_found' );
			http_response_code( 500 );
			exit(0);
		endif;

		if ( ! wp_verify_nonce( $nonce, self::AJAX_VERIFY_NONCE_COUNTER ) ) :
			Utils_Helper::error_server_json( 'nonce_not_found' );
			http_response_code( 500 );
			exit(0);
		endif;

		update_post_meta( $post_id, Service::POST_META_SHARE_COUNT_FACEBOOK, $count_facebook );
		update_post_meta( $post_id, Service::POST_META_SHARE_COUNT_TWITTER, $count_twitter );
		update_post_meta( $post_id, Service::POST_META_SHARE_COUNT_GOOGLE, $count_google );
		update_post_meta( $post_id, Service::POST_META_SHARE_COUNT_LINKEDIN, $count_linkedin );
		update_post_meta( $post_id, Service::POST_META_SHARE_COUNT_PINTEREST, $count_pinterest );
		exit(1);
	}
}
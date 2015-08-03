<?php
/**
 *
 * @package Social Share Buttons | Ajax
 * @author  Victor Freitas
 * @subpackage Ajax Controller
 * @version 1.0.2
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Ajax_Controller
{
	/**
	* Nonce
	*
	* @since 1.0
	* @var string
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

	    $args = array(
			'method'  => 'POST',
			'headers' => array(
		        'Content-Type' => 'application/json'
		    ),
		    'body' => json_encode(
		    	array(
					'method'     => 'pos.plusones.get',
					'id'         => 'p',
					'method'     => 'pos.plusones.get',
					'jsonrpc'    => '2.0',
					'key'        => 'p',
					'apiVersion' => 'v1',
			        'params' => array(
						'nolog'   =>true,
						'id'      => $url,
						'source'  =>'widget',
						'userId'  =>'@viewer',
						'groupId' =>'@self',
		        	) 
		     	)
		    ),
		    'sslverify' => false
		);

	    $response = wp_remote_request( 'https://clients6.google.com/rpc', $args );
	    $plusones = json_decode( $response['body'], true );
		$results  = json_encode( self::_get_global_counts_google( $plusones, $response ) );
		
		header( 'Content-Type: application/javascript; charset=utf-8' );
		echo $_REQUEST[ 'callback' ] . "({$results})";
		exit(1);
	}

	/**
	 * Quantity shares google plus
	 * 
	 * @since 1.0
	 * @param Array $results
	 * @return Array
	 */
	private static function _get_global_counts_google( $results, $response )
	{
		if ( is_wp_error( $response ) )
			return array( 'count' => 0 );

		$global_count = $results['result']['metadata']['globalCounts'];

		if ( empty( $global_count ) || is_null( $global_count ) )
			return array( 'count' => 0 );

		return $global_count;
	}

	/**
	 * Update post meta share posts
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
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
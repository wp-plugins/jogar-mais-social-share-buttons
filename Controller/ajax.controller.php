<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Ajax Controller
 * @version 2.0
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

	/**
	 * Quantity shares google plus
	 *
	 * @since 1.1
	 * @param null
	 * @return void
	 */
	public static function get_plus_google()
	{
		header( 'Content-Type: application/javascript; charset=utf-8' );

		//Cache 10 minutes
		$cache = get_transient( Setting::SSB_TRANSIENT_GOOGLE_PLUS );
		$url   = Utils_Helper::request( 'url', false, 'esc_url' );

		if ( false !== $cache && isset( $cache[$url] ) ) :
			echo Utils_Helper::esc_html( $_REQUEST[ 'callback' ] ) . '(' . $cache[$url] . ')';
			exit(1);
		endif;

		Utils_Helper::ajax_verify_request( $url, 500, 'url_is_empty' );

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
						'nolog'   => true,
						'id'      =>  $url,
						'source'  => 'widget',
						'userId'  => '@viewer',
						'groupId' => '@self',
		        	)
		     	)
		    ),
		    'sslverify' => false
		);

	    $response = wp_remote_request( 'https://clients6.google.com/rpc', $args );

	    if ( is_wp_error( $response ) ) :
	    	return static::_error_request();
	    endif;

	    $plusones = json_decode( $response['body'], true );
		$results  = json_encode( static::_get_global_counts_google( $plusones, $response, $url ) );

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
	private static function _get_global_counts_google( $results, $response, $url )
	{
		$global_count = $results['result']['metadata']['globalCounts'];
		$cache        = array();

		if ( empty( $global_count ) || is_null( $global_count ) ) :
			return array( 'count' => 0 );
		endif;

		$cache[$url] = json_encode( $global_count );

		set_transient(
			Setting::SSB_TRANSIENT_GOOGLE_PLUS,
			$cache,
			apply_filters( Setting::SSB_TRANSIENT_GOOGLE_PLUS, 10 * MINUTE_IN_SECONDS )
		);

		return $global_count;
	}

	/**
	 * Return count 0 if exist error
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	private static function _error_request()
	{
		$results = json_encode( array( 'count' => 0 ) );
		echo $_REQUEST[ 'callback' ] . "({$results})";
		exit(1);
	}

	/**
	 * Retrieve the requests
	 *
	 * @since 1.2
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	public static function global_counts_social_share()
	{
		global $wpdb;

		$post_id         = Utils_Helper::request( 'reference', false, 'intval' );
		$post_title      = get_the_title( $post_id );
		$count_facebook  = Utils_Helper::request( 'count_facebook', 0, 'intval' );
		$count_twitter   = Utils_Helper::request( 'count_twitter', 0, 'intval' );
		$count_google    = Utils_Helper::request( 'count_google', 0, 'intval' );
		$count_linkedin  = Utils_Helper::request( 'count_linkedin', 0, 'intval' );
		$count_pinterest = Utils_Helper::request( 'count_pinterest', 0, 'intval' );
		$total           = ( $count_facebook + $count_twitter + $count_google + $count_linkedin + $count_pinterest );
		$nonce           = Utils_Helper::request( 'nonce', false, 'esc_html' );
		$table           = $wpdb->prefix . Setting::TABLE_NAME;

		if ( static::_verify_request( $post_id, $nonce ) )
			exit(0);

		if ( $total > 0 )
			static::_select(
				$table,
				array(
					'post_id'         => $post_id,
					'post_title'      => $post_title,
					'count_facebook'  => $count_facebook,
					'count_twitter'   => $count_twitter,
					'count_google'    => $count_google,
					'count_linkedin'  => $count_linkedin,
					'count_pinterest' => $count_pinterest,
					'total'           => $total,
				)
			);
		exit(1);
	}

	/**
	 * Select the table and check for records
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _select( $table, $data = array() )
	{
		global $wpdb;

		$query     = $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE `post_id` = %d", $data['post_id'] );
		$row_count = $wpdb->get_var( $query );
		$row_count = intval( $row_count );

		if ( 1 === $row_count )
			static::_update( $table, $data );

		if ( 0 === $row_count )
			static::_insert( $table, $data );

		exit(1);
	}

	/**
	 * Update records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _update( $table, $data = array() )
	{
		global $wpdb;

		$wpdb->update(
			$table,
			array(
				'post_title' => $data['post_title'],
				'facebook'   => $data['count_facebook'],
				'twitter'    => $data['count_twitter'],
				'google'     => $data['count_google'],
				'linkedin'   => $data['count_linkedin'],
				'pinterest'  => $data['count_pinterest'],
				'total'      => $data['total'],
			),
			array(
				'post_id' => $data['post_id'],
			),
			array(
				'%s',
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
				'%d',
			),
			array(
				'%d',
			)
		);

		exit(1);
	}

	/**
	 * Insert records in the table
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param String $table
	 * @param Array $data
	 * @return Void
	 */
	private static function _insert( $table, $data = array() )
	{
		global $wpdb;

		$wpdb->insert(
			$table,
			array(
				'post_id'    => $data['post_id'],
				'post_title' => $data['post_title'],
				'facebook'   => $data['count_facebook'],
				'twitter'    => $data['count_twitter'],
				'google'     => $data['count_google'],
				'linkedin'   => $data['count_linkedin'],
				'pinterest'  => $data['count_pinterest'],
				'total'      => $data['total'],
			)
		);

		exit(1);
	}

	/**
	 * Verify json requests
	 *
	 * @since 1.0
	 * @param Integer $post_id
	 * @param String $nonce
	 * @return Boolean
	 */
	private static function _verify_request( $post_id, $nonce )
	{
		if ( ! $post_id ) :
			Utils_Helper::error_server_json( 'reference_not_found' );
			http_response_code( 500 );
			return true;
		endif;

		if ( ! wp_verify_nonce( $nonce, self::AJAX_VERIFY_NONCE_COUNTER ) ) :
			Utils_Helper::error_server_json( 'nonce_not_found' );
			http_response_code( 500 );
			return true;
		endif;

		return false;
	}
}
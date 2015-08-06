<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Controller Sharing Report
 * @version 1.0.3
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
Init::uses( 'sharing-report', 'View' );
//Model
Init::uses( 'service', 'Model' );

class Sharing_Report_Controller
{
	/**
	 * Number for posts per page
	 * 
	 * @since 1.0
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 20;

	/**
	 * Name for transient function
	 * 
	 * @since 1.0
	 * @var string
	 */
	const JM_TRANSIENT = 'jm-transient-sharing-report';

	public function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'menu' ) );
	}

	/**
	 * Search in database results relative share posts 
	 * 
	 * @since 1.0
	 * @param Int $page
	 * @param String $orderby
	 * @param String $order
	 * @return Object
	 */
	private function _get_sharing_report( $page, $orderby, $order )
	{
		global $wpdb;

		$offset     = ( ( $page - 1 ) * self::POSTS_PER_PAGE );
		$cache      = get_transient( self::JM_TRANSIENT );
		$cache_time = Utils_Helper::option( '_report_cache_time', 'intval', 10 );

		if ( false !== $cache && isset( $cache[$page][$orderby][$order] ) )
			return $cache[$page][$orderby][$order];

		$query = $wpdb->prepare(
			"SELECT
			    posts.ID,
				posts.post_title                     AS title,
			    CAST( meta1.meta_value AS UNSIGNED ) AS facebook,
			    CAST( meta2.meta_value AS UNSIGNED ) AS twitter,
			    CAST( meta3.meta_value AS UNSIGNED ) AS google,
			    CAST( meta4.meta_value AS UNSIGNED ) AS linkedin,
			    CAST( meta5.meta_value AS UNSIGNED ) AS pinterest,
				(
			        COALESCE( meta1.meta_value, 0 ) +
			        COALESCE( meta2.meta_value, 0 ) +
			        COALESCE( meta3.meta_value, 0 ) +
			        COALESCE( meta4.meta_value, 0 ) +
			        COALESCE( meta5.meta_value, 0 )
			    ) AS total

			FROM $wpdb->posts AS posts

			LEFT JOIN $wpdb->postmeta AS meta1 ON
				( meta1.post_id  = posts.ID )
			AND ( meta1.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta AS meta2 ON
				( meta2.post_id  = posts.ID )
			AND ( meta2.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta AS meta3 ON
				( meta3.post_id  = posts.ID )
			AND ( meta3.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta AS meta4 ON
				( meta4.post_id  = posts.ID )
			AND ( meta4.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta AS meta5 ON
				( meta5.post_id  = posts.ID )
			AND ( meta5.meta_key = '%s' )

			WHERE posts.post_type   = 'post'
			AND   posts.post_status = 'publish'
			AND   COALESCE( meta1.meta_value, 0 ) +
		          COALESCE( meta2.meta_value, 0 ) +
		          COALESCE( meta3.meta_value, 0 ) +
		          COALESCE( meta4.meta_value, 0 ) +
		          COALESCE( meta5.meta_value, 0 ) > 0

			ORDER BY {$orderby} {$order}

			LIMIT {$offset}, %d",
			Service::POST_META_SHARE_COUNT_FACEBOOK,
			Service::POST_META_SHARE_COUNT_TWITTER,
			Service::POST_META_SHARE_COUNT_GOOGLE,
			Service::POST_META_SHARE_COUNT_LINKEDIN,
			Service::POST_META_SHARE_COUNT_PINTEREST,
			self::POSTS_PER_PAGE
		);

		$cache[$page][$orderby][$order] = $wpdb->get_results( $query );

		set_transient( self::JM_TRANSIENT, $cache, $cache_time * MINUTE_IN_SECONDS );

		return $cache[$page][$orderby][$order];
	}

	/**
	 * Create submenu page
	 * 
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	public function menu()
	{
	  	add_submenu_page(
	  		Init::PLUGIN_SLUG,
	  		'Relatório de compartilhamento | Social Share Buttons',
	  		'Relatório de compartilhamento',
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-sharing-report',
	  		array( &$this, 'report' )
	  	);
	}

	/**
	 * Set report page view
	 * 
	 * @since 1.0
	 * @param null
	 * @return Void
	 */
	public function report()
	{
		$page       = Utils_Helper::request( 'report_page', 1, 'intval' );
		$orderby    = Utils_Helper::request( 'orderby', 'total', 'sanitize_sql_orderby' );
		$order_type = Utils_Helper::request( 'order', 'desc', 'sanitize_sql_orderby' );
		$reference  = $this->_verify_sql_orderby( $orderby, 'total' );
		$order      = $this->_verify_sql_order( $order_type, 'desc' );
		$posts      = $this->_get_sharing_report( $page, $reference, $order );
		$next_page  = $this->_get_next_link( $page, count( $posts ) );
		$prev_page  = $this->_get_prev_link( $page );

		Sharing_Report_View::render_sharing_report( $posts, $prev_page, $next_page );
	}

	/**
	 * Verify sql orderby param
	 * 
	 * @since 1.0
	 * @param String $orderby
	 * @param String $default
	 * @return String
	 */
	private function _verify_sql_orderby( $orderby, $default = '' )
	{
			$permissions = array( 'title', 'facebook', 'twitter', 'google', 'linkedin', 'pinterest', 'total' );

			if ( in_array( $orderby, $permissions ) )
				return $orderby;

		return $default;
	}

	/**
	 * Verify sql order param
	 * 
	 * @since 1.0
	 * @param String $order
	 * @param String $default
	 * @return String
	 */
	private function _verify_sql_order( $order, $default = '' )
	{
		if ( $order === 'desc' || $order === 'asc' )
			return strtoupper( $order );

		return $default;
	}

	/**
	 * Next page sharing report
	 * 
	 * @since 1.0
	 * @param Int $page
	 * @param Int $rows
	 * @return String
	 */
	private function _get_next_link( $page, $rows )
	{
		$orderby  = Utils_Helper::request( 'orderby', false, 'sanitize_sql_orderby' );
		$order    = Utils_Helper::request( 'order', false, 'sanitize_sql_orderby' );
		$page_url = 'admin.php?page=' . Init::PLUGIN_SLUG . '-sharing-report';

		if ( $rows < self::POSTS_PER_PAGE )
			return '#';

		$page += 1;

		if ( $order )
			return get_admin_url( null, "{$page_url}&orderby={$orderby}&order={$order}&report_page={$page}" );

		return get_admin_url( null, "{$page_url}&report_page={$page}" );
	}

	/**
	 * Prev page sharing report
	 * 
	 * @since 1.0
	 * @param Int $page
	 * @return String
	 */
	private function _get_prev_link( $page )
	{
		$orderby  = Utils_Helper::request( 'orderby', false, 'sanitize_sql_orderby' );
		$order    = Utils_Helper::request( 'order', false, 'sanitize_sql_orderby' );
		$page_url = 'admin.php?page=' . Init::PLUGIN_SLUG . '-sharing-report';

		if ( 1 === $page )
			return '#';

		$page -= 1;

		if ( $order )
			return get_admin_url( null, "{$page_url}&orderby={$orderby}&order={$order}&report_page={$page}" );

		return get_admin_url( null, "{$page_url}&report_page={$page}" );
	}
}
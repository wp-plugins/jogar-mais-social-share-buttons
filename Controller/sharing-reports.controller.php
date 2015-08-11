<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Controller Sharing Report
 * @version 1.2.2
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
Init::uses( 'sharing-report', 'View' );

class Sharing_Reports_Controller
{
	/**
	 * Number for posts per page
	 * 
	 * @since 1.0
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 20;

	public function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'menu' ) );
	}

	/**
	 * Search in database results relative share posts 
	 * 
	 * @since 1.3
	 * @global $wpdb
	 * @param Int $page
	 * @param String $orderby
	 * @param String $order
	 * @return Object
	 */
	private function _get_sharing_report( $page, $orderby, $order )
	{
		global $wpdb;

		$offset     = ( ( $page - 1 ) * self::POSTS_PER_PAGE );
		$cache      = get_transient( Settings::JM_TRANSIENT );
		$cache_time = Utils_Helper::option( '_report_cache_time', 'intval', 10 );
		$table      = $wpdb->prefix . Settings::TABLE_NAME;

		if ( false !== $cache && isset( $cache[$page][$orderby][$order] ) )
			return $cache[$page][$orderby][$order];

		if ( ! $wpdb->query( "SHOW TABLES LIKE '{$table}'" ) )
			return;

		$query = $wpdb->prepare(
			"SELECT * FROM `{$table}`
			 ORDER BY {$orderby} {$order}
			 LIMIT {$offset}, %d",
			 self::POSTS_PER_PAGE
		);

		$cache[$page][$orderby][$order] = $wpdb->get_results( $query );

		set_transient( Settings::JM_TRANSIENT, $cache, $cache_time * MINUTE_IN_SECONDS );

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
	 * @since 1.2
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
	 * @since 1.2
	 * @param String $orderby
	 * @param String $default
	 * @return String
	 */
	private function _verify_sql_orderby( $orderby, $default = '' )
	{
			$permissions = array( 'post_title', 'facebook', 'twitter', 'google', 'linkedin', 'pinterest', 'total' );

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
	 * @since 1.2
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
			return false;

		$page += 1;

		if ( $order )
			return get_admin_url( null, "{$page_url}&orderby={$orderby}&order={$order}&report_page={$page}" );

		return get_admin_url( null, "{$page_url}&report_page={$page}" );
	}

	/**
	 * Prev page sharing report
	 * 
	 * @since 1.2
	 * @param Int $page
	 * @return String
	 */
	private function _get_prev_link( $page )
	{
		$orderby  = Utils_Helper::request( 'orderby', false, 'sanitize_sql_orderby' );
		$order    = Utils_Helper::request( 'order', false, 'sanitize_sql_orderby' );
		$page_url = 'admin.php?page=' . Init::PLUGIN_SLUG . '-sharing-report';

		if ( 1 === $page )
			return false;

		$page -= 1;

		if ( $order )
			return get_admin_url( null, "{$page_url}&orderby={$orderby}&order={$order}&report_page={$page}" );

		return get_admin_url( null, "{$page_url}&report_page={$page}" );
	}

	/**
	 * Create table sharing reports.
	 * 
	 * @since 1.0
	 * @global $wpdb
	 * @param Null
	 * @global $wpdb
	 * @return Void
	 */
	public function create_table()
	{
		global $wpdb;
		
		$charset    = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . Settings::TABLE_NAME;

		$sql = "
			CREATE TABLE IF NOT EXISTS $table_name (
				id         BIGINT(20) NOT NULL AUTO_INCREMENT,
				post_id    BIGINT(20) UNSIGNED NOT NULL,
				post_title TEXT       NOT NULL,
				facebook   BIGINT(20) UNSIGNED NOT NULL,
				twitter    BIGINT(20) UNSIGNED NOT NULL,
				google     BIGINT(20) UNSIGNED NOT NULL,
				linkedin   BIGINT(20) UNSIGNED NOT NULL,
				pinterest  BIGINT(20) UNSIGNED NOT NULL,
				total      BIGINT(20) UNSIGNED NOT NULL,
				PRIMARY KEY id ( id ),
				UNIQUE( post_id )
			)   {$charset};";
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
		Utils_Helper::add_or_update_option( Settings::TABLE_NAME . '_db_version' );
	}
}
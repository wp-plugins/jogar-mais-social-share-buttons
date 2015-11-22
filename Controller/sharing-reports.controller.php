<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Controller Sharing Report
 * @version 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
Init::uses( 'sharing-report', 'View' );

if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

if ( ! class_exists( 'WP_Screen' ) )
	require_once( ABSPATH . 'wp-admin/includes/screen.php' );

if ( ! class_exists( 'Walker_Category_Checklist' ) )
	require_once(ABSPATH . 'wp-admin/includes/template.php' );

class Sharing_Reports_Controller extends \WP_List_Table
{
	/**
	 * Number for posts per page
	 *
	 * @since 1.1
	 * @var Integer
	 */
	const POSTS_PER_PAGE = 15;

	/**
	 * Number for cache time
	 *
	 * @since 1.2
	 * @var Integer
	 */
	private $cache_time;

	public function __construct()
	{
		$this->cache_time = Utils_Helper::option( 'report_cache_time', 10, 'intval' );

		add_action( 'admin_menu', array( &$this, 'menu' ) );
		parent::__construct(
			array(
				'singular' => 'social-share-report',
				'plural'   => 'social-sharing-reports',
				'screen'   => 'interval-list',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Search in database results relative share posts
	 *
	 * @since 1.4
	 * @global $wpdb
	 * @param Int $page
	 * @param String $orderby
	 * @param String $order
	 * @return Object
	 */
	private function _get_sharing_report( $posts_per_page, $current_page, $orderby, $order )
	{
		global $wpdb;

		$offset = ( ( $current_page - 1 ) * self::POSTS_PER_PAGE );
		$cache  = get_transient( Setting::SSB_TRANSIENT );
		$table  = $wpdb->prefix . Setting::TABLE_NAME;

		if ( false !== $cache && isset( $cache[$current_page][$orderby][$order] ) )
			return $cache[$current_page][$orderby][$order];

		if ( ! $wpdb->query( "SHOW TABLES LIKE '{$table}'" ) )
			return;

		$query = $wpdb->prepare(
			"SELECT * FROM `{$table}`
			 ORDER BY {$orderby} {$order}
			 LIMIT %d OFFSET {$offset}",
			 $posts_per_page
		);

		$cache[$current_page][$orderby][$order] = $wpdb->get_results( $query );

		set_transient( Setting::SSB_TRANSIENT, $cache, $this->cache_time * MINUTE_IN_SECONDS );

		return $cache[$current_page][$orderby][$order];
	}

	/**
	 * Get total results in wp list table for records
	 *
	 * @since 1.0
	 * @global $wpdb
	 * @param Null
	 * @return Integer
	 */
	private function _total_results()
	{
		global $wpdb;

		$cache = get_transient( Setting::SSB_TRANSIENT_SELECT_COUNT );
		$table = $wpdb->prefix . Setting::TABLE_NAME;

		if ( false !== $cache )
			return $cache;

		if ( ! $wpdb->query( "SHOW TABLES LIKE '{$table}'" ) )
			return 0;

		$query        = "SELECT COUNT(*) FROM {$table}";
		$row_count    = $wpdb->get_var( $query );
		$total_result = intval( $row_count );

		set_transient( Setting::SSB_TRANSIENT_SELECT_COUNT, $total_result,  $this->cache_time * MINUTE_IN_SECONDS );

		return $total_result;
	}

	/**
	 * Insert results in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Mixed String/Integer
	 */
	public function column_default( $items, $column )
	{
		$column = strtolower( $column );

		switch ( $column ) :

			case 'title' :
				return Sharing_Report_View::add_permalink_title( $items->post_id, $items->post_title );
				break;

			case 'facebook'  :
			case 'twitter'   :
			case 'google'    :
			case 'linkedin'  :
			case 'pinterest' :
			case 'total'     :
				return Utils_Helper::number_format( $items->$column );
				break;

		endswitch;
	}

	/**
	 * Set column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_columns()
	{
		$columns = array(
			'Title'     => __( 'Title', Init::PLUGIN_SLUG ),
			'Facebook'  => __( 'Facebook', Init::PLUGIN_SLUG ),
			'Google'    => __( 'Google+', Init::PLUGIN_SLUG ),
			'Twitter'   => __( 'Twitter', Init::PLUGIN_SLUG ),
			'Linkedin'  => __( 'Linkedin', Init::PLUGIN_SLUG ),
			'Pinterest' => __( 'Pinterest', Init::PLUGIN_SLUG ),
			'Total'     => __( 'Total', Init::PLUGIN_SLUG ),
		);

		return $columns;
	}

	/**
	 * Set orderby in column wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_sortable_columns()
	{
		$sortable_columns = array(
			'Title'     => array( 'post_title', false ),
			'Facebook'  => array( 'facebook', false ),
			'Google'    => array( 'google', false ),
			'Twitter'   => array( 'twitter', false ),
			'Linkedin'  => array( 'linkedin', false ),
			'Pinterest' => array( 'pinterest', false ),
			'Total'     => array( 'total', false ),
		);

		return $sortable_columns;
	}

	/**
	 * Prepare item for record add in wp list table
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function prepare_items()
	{
		$orderby               = Utils_Helper::request( 'orderby', 'total', 'sanitize_sql_orderby' );
		$order_type            = Utils_Helper::request( 'order', 'desc', 'sanitize_sql_orderby' );
		$reference             = $this->_verify_sql_orderby( $orderby, 'total' );
		$order                 = $this->_verify_sql_order( $order_type, 'desc' );
		$posts_per_page        = $this->get_items_per_page( 'ssb_posts_per_page', self::POSTS_PER_PAGE );
		$current_page          = $this->get_pagenum();
		$total_results         = self::_total_results();
		$this->_column_headers = $this->get_column_info();

		$this->set_pagination_args(
			array(
				'total_items' => $total_results,
				'total_pages' => ( $total_results / $posts_per_page ),
				'per_page'    => $posts_per_page,
			)
		);

		$this->items = self::_get_sharing_report( $posts_per_page, $current_page, $reference, $order );
	}

	/**
	 * Return message in wp list table case empty records
	 *
	 * @since 1.0
	 * @param Null
	 * @return String
	 */
	public function no_items()
	{
		_e( 'There is no record available at the moment!', Init::PLUGIN_SLUG );
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
	  		__( 'Sharing Report | Social Sharing Buttons', Init::PLUGIN_SLUG ),
	  		__( 'Sharing Report', Init::PLUGIN_SLUG ),
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-sharing-report',
	  		array( &$this, 'report' )
	  	);
	}

	/**
	 * Set report page view
	 *
	 * @since 1.3
	 * @param null
	 * @return Void
	 */
	public function report()
	{
		Sharing_Report_View::render_sharing_report( $this );
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
	 * Create table sharing reports.
	 *
	 * @since 1.1
	 * @global $wpdb
	 * @param Null
	 * @global $wpdb
	 * @return Void
	 */
	public function create_table()
	{
		global $wpdb;

		$charset    = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . Setting::TABLE_NAME;

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
		Utils_Helper::add_update_option( Setting::TABLE_NAME . '_db_version' );
	}
}
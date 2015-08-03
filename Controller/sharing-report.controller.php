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
	 * @return Object
	 */
	public function get_sharing_report( $page )
	{
		global $wpdb;

		$offset = ( ( $page - 1 ) * self::POSTS_PER_PAGE );
		$cache  = get_transient( self::JM_TRANSIENT );

		if ( false !== $cache && isset( $cache[$page] ) )
			return $cache[$page];

		$query = $wpdb->prepare(
			"SELECT
			    posts.ID,
				posts.post_title,
			    COALESCE( meta1.meta_value, 0 ) AS facebook,
			    COALESCE( meta2.meta_value, 0 ) AS twitter,
			    COALESCE( meta3.meta_value, 0 ) AS google,
			    COALESCE( meta4.meta_value, 0 ) AS linkedin,
			    COALESCE( meta5.meta_value, 0 ) AS pinterest,
				(
			        COALESCE( meta1.meta_value, 0 ) +
			        COALESCE( meta2.meta_value, 0 ) +
			        COALESCE( meta3.meta_value, 0 ) +
			        COALESCE( meta4.meta_value, 0 ) +
			        COALESCE( meta5.meta_value, 0 )
			    ) AS total

			FROM $wpdb->posts posts

			LEFT JOIN $wpdb->postmeta meta1 ON
				( meta1.post_id  = posts.ID )
			AND ( meta1.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta meta2 ON
				( meta2.post_id  = posts.ID )
			AND ( meta2.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta meta3 ON
				( meta3.post_id  = posts.ID )
			AND ( meta3.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta meta4 ON
				( meta4.post_id  = posts.ID )
			AND ( meta4.meta_key = '%s' )

			LEFT JOIN $wpdb->postmeta meta5 ON
				( meta5.post_id  = posts.ID )
			AND ( meta5.meta_key = '%s' )

			WHERE posts.post_type   = 'post'
			AND   posts.post_status = 'publish'
			AND   COALESCE( meta1.meta_value, 0 ) +
			      COALESCE( meta2.meta_value, 0 ) +
			      COALESCE( meta3.meta_value, 0 ) +
			      COALESCE( meta4.meta_value, 0 ) +
			      COALESCE( meta5.meta_value, 0 ) > 0

			ORDER BY total DESC

			LIMIT {$offset}, %d",
			Service::POST_META_SHARE_COUNT_FACEBOOK,
			Service::POST_META_SHARE_COUNT_TWITTER,
			Service::POST_META_SHARE_COUNT_GOOGLE,
			Service::POST_META_SHARE_COUNT_LINKEDIN,
			Service::POST_META_SHARE_COUNT_PINTEREST,
			self::POSTS_PER_PAGE
		);

		$cache[$page] = $wpdb->get_results( $query );

		set_transient( self::JM_TRANSIENT, $cache, 10 * MINUTE_IN_SECONDS );

		return $cache[$page];
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
		$page      = Utils_Helper::request( 'report_page', 1, 'intval' );
		$posts     = $this->get_sharing_report( $page );
		$next_page = $this->get_next_link( $page, count( $posts ) );
		$prev_page = $this->get_prev_link( $page );

		Sharing_Report_View::render_sharing_report( $posts, $prev_page, $next_page );
	}

	/**
	 * Next page sharing report
	 * 
	 * @since 1.0
	 * @param Int $page
	 * @param Int $rows
	 * @return String
	 */
	public function get_next_link( $page, $rows )
	{
		if ( $rows < self::POSTS_PER_PAGE )
			return '#';

		$page += 1;

		return Utils_Helper::admin_url( "&report_page={$page}" );
	}

	/**
	 * Prev page sharing report
	 * 
	 * @since 1.0
	 * @param Int $page
	 * @return String
	 */
	public function get_prev_link( $page )
	{
		if ( $page == 1 )
			return '#';

		$page -= 1;

		return Utils_Helper::admin_url( "&report_page={$page}" );
	}
}
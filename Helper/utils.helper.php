<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 1.2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Utils_Helper
{
	/**
	 * Escape string conter XSS attack
	 * 
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function esc_html( $string = '' )
	{
		$string = (string) $string;

		if ( ! strlen( $string ) )
			return '';

		if ( ! preg_match( '/[&<>"\']/', $string ) )
			return $string;
		
		$string = htmlentities( $string, ENT_QUOTES );

		return $string;
	}

	/**
	 * Sanitize value from methods post or get
	 * 
	 * @since 1.0
	 * @param String $key Relative as request method
	 * @param Mixed Int/String/Array $default return this function
	 * @param String $sanitize Relative function
	 * @return String
	*/
	public static function request( $key, $default = '', $sanitize = 'esc_html' )
	{
		if ( ! isset( $_REQUEST[ $key ] ) OR empty( $_REQUEST[ $key ] ) )
			return $default;

		return self::sanitize_type( $_REQUEST[ $key ], $sanitize );
	}

	/**
	 * Sanitize requests 
	 * 
	 * @since 1.0
	 * @param String $value Relative sanitize
	 * @param String $function_name Relative function to use
	 * @return String
	*/
	public static function sanitize_type( $value, $function_name )
	{
		if ( ! is_callable( $function_name ) || 'esc_html' === $function_name )
			return self::esc_html( $value );

		return call_user_func( $function_name, $value );
	}

	/**
	 * Post title
	 * 
	 * @since 1.0
	 * @param null
	 * @return String title posts
	 */
	public static function get_title()
	{
		global $post;

		$the_title = '';

		if ( isset( $post->ID ) )
			$the_title = get_the_title( $post->ID );

		return $the_title;
	}

	/**
	 * Post ID
	 * 
	 * @since 1.0
	 * @param null
	 * @return Integer
	 */
	public static function get_id()
	{
		global $post;

		if ( isset( $post->ID ) )
			return $post->ID;

		return 0;
	}

	/**
	 * Permalinks posts
	 * 
	 * @since 1.0
	 * @param null
	 * @return String
	 */
	public static function get_permalink()
	{
		global $post;

		$permalink = '';

		if ( isset( $post->ID ) )
			$permalink = get_permalink( $post->ID );

		return $permalink;
	}

	/**
	 * Thumbnail posts
	 * 
	 * @since 1.0
	 * @param null
	 * @return String thumbnail
	 */
	public static function get_image()
	{
		global $post;

		$thumbnail = '';

		if ( isset( $post->ID ) && has_post_thumbnail() )
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );

		if ( ! $thumbnail )
			return '';

		return $thumbnail[0];
	}

	/**
	 * Get content posts
	 * 
	 * @since 1.0
	 * @param null
	 * @return String content post
	 */
	public static function body_mail()
	{
		global $post;

		if ( isset( $post->post_content ) )
			return wp_kses( $post->post_content, array() );

		if ( isset( $post->post_excerpt ) )
			return wp_kses( $post->post_excerpt, array() );

		if ( isset( $post->post_title ) )
			return wp_kses( $post->post_title, array() );

		return '';
	}

	/**
	 * Plugin base name
	 * 
	 * @since 1.0
	 * @param null
	 * @return String link base file
	 */
	public static function base_name()
	{
		return plugin_basename( plugin_dir_path( __DIR__ ) . Init::PLUGIN_SLUG . '.php' );
	}

	/**
	 * Descode html entityes UTF-8
	 * 
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function html_decode( $string )
	{
		return html_entity_decode( $string, ENT_NOQUOTES, 'UTF-8' );
	}

	/**
	 * Plugin file url in assets directory
	 * 
	 * @since 1.0
	 * @param String $file
	 * @param String $path
	 * @return String
	 */
	public static function plugin_url( $file, $path = 'assets/' )
	{
		return plugins_url( $path . $file, __DIR__ );
	}

	/**
	 * Plugin file path in assets directory
	 * 
	 * @since 1.0
	 * @param String $file
	 * @return String
	 */
	public static function file_path( $file )
	{
		return plugin_dir_path( dirname( __FILE__ ) ) . Settings::DS . 'assets/' . $file;
	}

	/**
	 * Generate file time style and scripts
	 * 
	 * @since 1.0
	 * @param Int $path
	 * @return Integer
	 */
	public static function filetime( $path )
	{
		return date( 'dmYHi', filemtime( $path ) );
	}

	/**
	 * Get option unique and sanitize
	 * 
	 * @since 1.0
	 * @param String $option Relative option name
	 * @param String $sanitize Relative function
	 * @return String
	 */
	public static function option( $option, $sanitize = 'esc_html', $default = '' )
	{
		$model   = new Settings();
		$options = $model->get_options();

		if ( isset( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option] ) )
			return self::sanitize_type( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option], $sanitize );

		return $default;
	}

	/**
	 * response error server json
	 * 
	 * @since 1.0
	 * @param Int $code
	 * @param String $message
	 * @param Boolean $echo
	 * @return json
	 */
	public static function error_server_json( $code, $message = 'Message Error', $echo = true )
	{
		$response = json_encode(
			array(
				'status' 	=> 'error',
				'code'   	=> $code,
				'message'	=> $message,
			)
		);

		if ( ! $echo )
			return $response;

		echo $response;
	}

	/**
	 * Convert array in objects
	 * 
	 * @since 1.0
	 * @param Array $arguments
	 * @return Object
	 */
	public static function array_to_object( array $arguments = array() )
	{
        foreach( $arguments as $key => $value )
        	$object[$key] = (object) $value;

		return (object) $object;
	}

	/**
	 * Retrieves the url to the admin area for orderby page.
	 * 
	 * @since 1.0
	 * @param String $reference Relative orderby
	 * @param String $page_url Relative url orderby params
	 * @return String Admin url link
	 */
	public static function get_url_orderby_page( $reference = '', $page_url )
	{
		$orderby = Utils_Helper::request( 'orderby', false, 'sanitize_sql_orderby' );
		$order   = Utils_Helper::request( 'order', false, 'sanitize_sql_orderby' );
		$paged   = Utils_Helper::request( 'report_page', 0, 'intval' );
		$order   = ( $order === 'asc' ) ? 'desc' : 'asc';

		if ( ! $orderby && ! $paged )
			return get_admin_url( null, "{$page_url}&orderby={$reference}&order=asc" );

		if ( ( $orderby && ! $paged ) && ( $orderby !== $reference ) )
			return get_admin_url( null, "{$page_url}&orderby={$reference}&order=asc" );

		if ( ( $orderby && ! $paged ) && ( $orderby === $reference ) )
			return get_admin_url( null, "{$page_url}&orderby={$reference}&order={$order}" );

		if ( ( $orderby && $paged ) && ( $orderby === $reference ) )
			return get_admin_url( null, "{$page_url}&report_page={$paged}&orderby={$reference}&order={$order}" );

		if ( ( $orderby && $paged ) && ( $orderby !== $reference ) )
			return get_admin_url( null, "{$page_url}&report_page={$paged}&orderby={$reference}&order=asc" );

		if ( ! $orderby && $paged )
			return get_admin_url( null, "{$page_url}&report_page={$paged}&orderby={$reference}&order=asc" );
	}

	/**
	 * Retrieves the class name sortable
	 * 
	 * @since 1.0
	 * @param String $reference Relative orderby
	 * @return String class name sortable pagination
	 */
	public static function sortable_order( $reference = '' )
	{
		$orderby = Utils_Helper::request( 'orderby', false, 'sanitize_sql_orderby' );
		$order   = Utils_Helper::request( 'order', false, 'sanitize_sql_orderby' );

		if ( $order && $reference === $orderby )
			return "sorted {$order}";

		return 'sortable desc';
	}

	/**
	 * Disable pagination in attribute class
	 * 
	 * @since 1.0
	 * @param String $disabled
	 * @return String
	 */
	public static function class_disable_pagination( $disabled )
	{
		if ( '#' == $disabled )
			return 'disabled';

		return '';
	}

	/**
	 * Verify option exists and update option
	 * 
	 * @since 1.0
	 * @param String $option_name
	 * @return String
	 */
	public static function add_or_update_option( $option_name )
	{
		$option = get_site_option( $option_name );

		if ( $option )
			return update_option( $option_name, Settings::SHARING_REPORT_DB_VERSION );

		return add_option( $option_name, Settings::SHARING_REPORT_DB_VERSION );
	}
}
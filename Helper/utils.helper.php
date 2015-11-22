<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 2.0
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
	public static function esc_html( $string, $type = 'html' )
	{
		$string = (string) $string;

		if ( ! strlen( $string ) )
			return '';

		return self::esc_xss( $string, $type );
	}

	/**
	 * Escape string conter XSS attack
	 *
	 * @since 1.0
	 * @param String $value
	 * @param String $type
	 * @return String
	 */
	private static function esc_xss( $value, $type )
	{
        switch ( $type ) :
            case 'html' :
				$value = self::rip_tags( $value );
                break;

            case 'code' :
				$value = htmlentities2( $value );
				break;
        endswitch;

        return $value;
	}

	/**
	 * RIP tags html
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	private static function rip_tags( $string )
	{
	    $string = preg_replace( '/[<[^>]*>]/', '', $string );
	    $string = str_replace( "\r", '', $string );
	    $string = str_replace( "\n", ' ', $string );
	    $string = str_replace( "\t", ' ', $string );
	    $string = preg_replace( '/ {2,}/', ' ', $string );
	    $string = strip_tags( $string );
	    $string = trim( $string );

	    return $string;
	}

	/**
	 * Escape string for atribute class
	 *
	 * @since 1.0
	 * @param String $string
	 * @return String
	 */
	public static function esc_class( $class )
	{
		$class = (string) $class;

		if ( ! strlen( $class ) )
			return '';

        $class = self::rip_tags( $class );
        $class = str_replace( '_', '-', $class );
        $class = preg_replace( "/[^a-zA-Z0-9\s-]/", '', $class );
        $class = preg_replace( "/[\s-]+/", '-', $class );
        $class = strtolower( $class );

        return $class;
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
		if ( ! isset( $_REQUEST[$key] ) OR empty( $_REQUEST[$key] ) )
			return $default;

		return self::sanitize_type( $_REQUEST[$key], $sanitize );
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
		if ( ! is_callable( $function_name ) || 'esc_html' == $function_name )
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

		$post_title = '';

		if ( isset( $post->ID ) )
			$post_title = get_the_title( $post->ID );

		return $post_title;
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

		$content = '';

		if ( isset( $post->post_content ) )
			$content = $post->post_content;

		$content = self::rip_tags( $content );
		$content = preg_replace( '/\[.*\]/', null, $content );

		return $content;
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
		return plugin_basename( plugin_dir_path( __DIR__ ) . basename( Init::FILE ) );
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
		return plugins_url( "{$path}{$file}", __DIR__ );
	}

	/**
	 * Plugin file path in assets directory
	 *
	 * @since 1.0
	 * @param String $file
	 * @return String
	 */
	public static function file_path( $file = '', $path = 'assets/' )
	{
		return plugin_dir_path( dirname( __FILE__ ) ) . "{$path}{$file}";
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
	public static function option( $option, $default = '', $sanitize = 'esc_html' )
	{
		$model   = new Setting();
		$options = $model->get_options();

		if ( isset( $options[$option] ) )
			return self::sanitize_type( $options[$option], $sanitize );

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

		if ( $echo ) :
			echo $response;
			exit(0);
		endif;

		return $response;
	}

	/**
	 * Request not found
	 *
	 * @since 1.0
	 * @param Array/String/Bool/Int $request
	 * @param Int $code
	 * @param String $message
	 * @return Void
	 */
	public static function ajax_verify_request( $request, $code = 500, $message = 'server_error' )
	{
		if ( ! $request ) :
			http_response_code( $code );
			self::error_server_json( $code, $message );
			exit(0);
		endif;
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
	 * Verify option exists and update option
	 *
	 * @since 1.0
	 * @param String $option_name
	 * @return String
	 */
	public static function add_update_option( $option_name )
	{
		$option = get_site_option( $option_name );

		if ( $option )
			return update_option( $option_name, Setting::DB_VERSION );

		return add_option( $option_name, Setting::DB_VERSION );
	}

	/**
	 * Format number
	 *
	 * @since 1.0
	 * @param Integer $number
	 * @return String
	 */
	public static function number_format( $number )
	{
		$number = (double) $number;

		if ( ! $number )
			return $number;

		return number_format( $number, 0, '.', '.' );
	}

	/**
	 * Verify index in array and set
	 *
	 * @since 1.0
	 * @param Array $args
	 * @param String/int $index
	 * @return String
	 */
	public static function isset_set( $args = array(), $index )
	{
		if ( isset( $args[$index] ) )
			return $args[$index];

		return '';
	}
}
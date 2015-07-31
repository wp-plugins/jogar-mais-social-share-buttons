<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Utils Helper
 * @version 1.0.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

class Utils_Helper
{
	/**
	 * @since 1.0
	 * @param Escape string conter XSS attack
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
	* @since 1.0
	* @param request event
	* @return String
	*/
	public static function request( $key, $default = '', $sanitize = 'esc_html' )
	{
		if ( ! isset( $_REQUEST[ $key ] ) OR empty( $_REQUEST[ $key ] ) )
			return $default;

		return self::sanitize_type( $_REQUEST[ $key ], $sanitize );
	}

	/**
	* @since 1.0
	* @param Sanitize requests, strings
	* @return String
	*/
	public static function sanitize_type( $value, $name_function )
	{
		if ( ! is_callable( $name_function ) || 'esc_html' === $name_function )
			return self::esc_html( $value );

		return call_user_func( $name_function, $value );
	}

	/**
	 * @since 1.0
	 * @param Title posts
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
	 * @since 1.0
	 * @param Post ID
	 * @return Integer
	 */
	public static function get_id()
	{
		global $post;

		if ( isset( $post->ID ) )
			return $post->ID;

		//return get_the_id();
	}

	/**
	 * @since 1.0
	 * @param Permalinks posts
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
	 * @since 1.0
	 * @param Thumbnail posts
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
	 * @since 1.0
	 * @param Get content global $post
	 * @return String content
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
	 * @since 1.0
	 * @param Plugin base file
	 * @return String
	 */
	public static function base_name()
	{
		$plugin_base = plugin_basename( plugin_dir_path( __DIR__ ) . Init::PLUGIN_SLUG . '.php' );

		return $plugin_base;
	}

	/**
	 * @since 1.0
	 * @param Convert entityes
	 * @return String
	 */
	public static function html_decode( $string )
	{
		return html_entity_decode( $string, ENT_NOQUOTES, 'UTF-8' );
	}

	/**
	 * @since 1.0
	 * @param Replaces
	 * @return String
	 */
	public static function replace( $search, $replace, $subject )
	{
		return str_replace( $search, $replace, $subject );
	}

	/**
	 * @since 1.0
	 * @param Plugin file url in assets directory
	 * @return String
	 */
	public static function plugin_url( $file )
	{
		$file_url = plugins_url( 'assets/' . $file, __DIR__ );

		return $file_url;
	}

	/**
	 * @since 1.0
	 * @param Plugin file path in assets directory
	 * @return String
	 */
	public static function file_path( $file )
	{
		$path = plugin_dir_path( dirname( __FILE__ ) ) . Settings::DS . 'assets/' . $file;

		return $path;
	}

	/**
	 * @since 1.0
	 * @param Generate file time style and scripts
	 * @return Integer
	 */
	public static function filetime( $path )
	{
		$file_time = date( 'dmYHi', filemtime( $path ) );

		return $file_time;
	}

	/**
	 * @since 1.0
	 * @param Get option unique and sanitize
	 * @return String
	 */
	public static function option( $option, $sanitize = 'esc_html' )
	{
		$model   = new Settings();
		$options = $model->get_options();

		if ( isset( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option] ) )
			return self::sanitize_type( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option], $sanitize );

		return '';
	}

	/**
	 * @since 1.0
	 * @param response error server json
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
	 * @since 1.0
	 * @param Convert array in objects
	 * @return Object
	 */
	public static function array_to_object( array $arguments = array() )
	{
        foreach( $arguments as $key => $value )
        	$object[$key] = (object) $value;

		return (object) $object;
	}
}

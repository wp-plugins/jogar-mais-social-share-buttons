<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Functions
 * @author  Victor Freitas
 * @version 1.0
 */

namespace JM\Share_Buttons;

Init::uses( 'option', 'Controller' );
Init::uses( 'share', 'Controller' );
Init::uses( 'settings', 'Model' );

class Core
{
	public static $option_controller;

	public static $share_controller;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0
	 */
	public function __construct()
	{
		self::$share_controller  = new Share_Controller();
		self::$option_controller = new Option_Controller();

		add_filter( 'plugin_action_links_' . self::_base_name(), array(  __CLASS__, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_css' ) );
		add_action( 'admin_menu', array( __CLASS__, 'show_menu_page' ) );
		register_activation_hook( Settings::FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( Settings::FILE, array( __CLASS__, 'deactivate' ) );
	}

	/**
	 * @since 1.0
	 * @package Register Activation Hook
	 * @return Void
	 */
	public static function activate()
	{

	}

	/**
	 * @since 1.0
	 * @package Register Deactivation Hook
	 * @return Void
	 */
	public static function deactivate()
	{

	}

	/**
	 * @since 1.0
	 * @package Adds links page plugin action
	 * @return Array links action plugins
	 */
	public static function plugin_link( $links )
	{
		$settings_link = '<a href="admin.php?page=' . Init::PLUGIN_SLUG . '">Configurações</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * @since 1.0
	 * @package Title posts
	 * @return String title posts
	 */
	protected static function _get_title()
	{
		global $post;

		$the_title = '';

		if ( isset( $post->ID ) )
			$the_title = get_the_title( $post->ID );

		return $the_title;
	}

	/**
	 * @since 1.0
	 * @package Permalinks posts
	 * @return String permalinks
	 */
	protected static function _get_permalink()
	{
		global $post;

		$the_permalink = '';

		if ( isset( $post->ID ) )
			$the_permalink = get_permalink( $post->ID );

		return $the_permalink;
	}

	/**
	 * @since 1.0
	 * @package Thumbnail posts
	 * @return String thumbnail
	 */
	protected static function _get_image()
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
	 * @package Get content global $post
	 * @return String content
	 */
	protected static function _body_mail()
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
	 * @package Plugin base file
	 * @return String
	 */
	private static function _base_name()
	{
		$plugin_base = plugin_basename( plugin_dir_path( __DIR__ ) . Init::PLUGIN_SLUG . '.php' );

		return $plugin_base;
	}

	/**
	 * @since 1.0
	 * @package Convert entityes
	 * @return String
	 */
	protected static function _jm_decode( $string )
	{
		return html_entity_decode( $string, ENT_NOQUOTES, 'UTF-8' );
	}

	/**
	 * @since 1.0
	 * @package Replaces
	 * @return String
	 */
	protected static function _jm_replace( $search, $replace, $subject )
	{
		return str_replace( $search, $replace, $subject );
	}

	/**
	 * @since 1.0
	 * @package Generate data all social icons
	 * @return Object all data links
	 */
	protected static function _services()
	{
		$options = self::$option_controller->get_options();

		$title       = rawurlencode( '"' . self::_jm_decode( self::_get_title() . '" ' ) );
		$url         = rawurlencode( self::_get_permalink() );
		$tracking    = rawurlencode( '?utm_source=whatsapp&utm_medium=social_media&utm_campaign=whatsapp' );
		$thumbnail   = rawurlencode( self::_get_image() );
		$get_content = rawurlencode( self::_body_mail() );
		$caracter    = rawurlencode( '➜ ' );
		$sms_title   = rawurlencode( self::_jm_replace( '&', 'e', self::_jm_decode( self::_get_title() ) ) . ' ' );
		$twitter_via = ( ( ! empty( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'] ) ) ? '&via=' . esc_html( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'] ) : '' );

		$data_action    = 'data-action="open-popup"';
		$share_services = ( object ) array(

			'facebook' => ( object ) array(
				'name'  => 'Facebook',
				'link'  => "https://www.facebook.com/sharer/sharer.php?u={$url}",
				'title' => 'Compartilhar no Facebook',
				'icon'  => 'facebook.svg',
				'class' => Settings::PLUGIN_PREFIX . '-facebook',
				'popup' => $data_action,
				'img'   => 'icon-facebook',
			),
			'twitter' => ( object ) array(
				'name'  => 'Twitter',
				'link'  => "https://twitter.com/share?url={$url}&text=Acabei de ver {$title} - Clique pra ver também {$caracter}{$twitter_via}",
				'title' => 'Compartilhar no Twitter',
				'icon'  => 'twitter.svg',
				'class' => Settings::PLUGIN_PREFIX . '-twitter',
				'popup' => $data_action,
				'img'   => 'icon-twitter',
			),
			'google_plus' => ( object ) array(
				'name'  => 'Google',
				'link'  => "https://plus.google.com/share?url={$url}",
				'title' => 'Compartilhar no Google+',
				'icon'  => 'google_plus.svg',
				'class' => Settings::PLUGIN_PREFIX . '-google-plus',
				'popup' => $data_action,
				'img'   => 'icon-google',
			),
			'whatsapp' => ( object ) array(
				'name'  => 'Whatsapp',
				'link'  => "whatsapp://send?text={$title}{$caracter}{$url}{$tracking}",
				'title' => 'Compartilhar no WhatsApp',
				'icon'  => 'whatsapp.svg',
				'class' => Settings::PLUGIN_PREFIX . '-whatsapp',
				'popup' => '',
				'img'   => 'icon-whatsapp',
			),
			'sms' => ( object ) array(
				'name'  => 'Sms',
				'link'  => "sms:?body={$sms_title}{$caracter}{$url}",
				'title' => 'Enviar via SMS',
				'icon'  => 'sms.svg',
				'class' => Settings::PLUGIN_PREFIX . '-sms',
				'popup' => '',
				'img'   => 'icon-sms',
			),
			'pinterest' => ( object ) array(
				'name'  => 'Pinterest',
				'link'  => "https://pinterest.com/pin/create/button/?url={$url}&media={$thumbnail}&description={$title}",
				'title' => 'Compartilhar no Pinterest',
				'icon'  => 'pinterest.png',
				'class' => Settings::PLUGIN_PREFIX . '-pinterest',
				'popup' => $data_action,
				'img'   => 'icon-pinterest',
			),
			'linkedin' => ( object ) array(
				'name'  => 'Linkedin',
				'link'  => "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$title}",
				'title' => 'Compartilhar no Linkedin',
				'icon'  => 'linkedin.svg',
				'class' => Settings::PLUGIN_PREFIX . '-linkedin',
				'popup' => $data_action,
				'img'   => 'icon-linkedin',
			),
			'tumblr' => ( object ) array(
				'name'  => 'Tumblr',
				'link'  => 'http://www.tumblr.com/share',
				'title' => 'Compartilhar no Tumblr',
				'icon'  => 'tumblr.svg',
				'class' => Settings::PLUGIN_PREFIX . '-tumblr',
				'popup' => $data_action,
				'img'   => 'icon-tumblr',
			),
			'gmail' => ( object ) array(
				'name'  => 'Gmail',
				'link'  => "https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su={$title}&body={$get_content}\n{$url}",
				'title' => 'Enviar via Gmail',
				'icon'  => 'gmail.svg',
				'class' => Settings::PLUGIN_PREFIX . '-gmail',
				'popup' => $data_action,
				'img'   => 'icon-gmail',
			),
			'email' => ( object ) array(
				'name'  => 'Email',
				'link'  => "mailto:?subject={$title}&body={$url}",
				'title' => 'Enviar por email',
				'icon'  => 'email.svg',
				'class' => Settings::PLUGIN_PREFIX . '-email',
				'popup' => $data_action,
				'img'   => 'icon-email',
			),
			'printfriendly' => ( object ) array(
				'name'  => 'PrintFriendly',
				'link'  => "http://www.printfriendly.com/print?url={$url}&partner=whatsapp",
				'title' => 'Imprimir via Print Friendly',
				'icon'  => 'printfriendly.svg',
				'class' => Settings::PLUGIN_PREFIX . '-print-friendly',
				'popup' => $data_action,
				'img'   => 'icon-printfriendly',
			),
		);

		return $share_services;
	}

	/**
	 * @since 1.0
	 * @package Enqueue scripts and styles
	 * @return Void
	 */
	public static function scripts()
	{
		$options = self::$option_controller->get_options();

		wp_enqueue_script(
			Settings::PLUGIN_PREFIX . '-theme-scripts',
			self::_plugin_url( 'javascripts/script.min.js' ),
			array( 'jquery' ),
			self::_filetime( self::_file_path( 'javascripts/script.min.js' ) ),
			true
		);

		if ( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'] === 'off' )
			return;

		wp_enqueue_style(
			Settings::PLUGIN_PREFIX . '-theme-style',
			self::_plugin_url( 'stylesheet/style.css' ),
			array(),
			self::_filetime( self::_file_path( 'stylesheet/style.css' ) )
		);
	}

	/**
	 * @since 1.0
	 * @package Enqueue scripts and styles for admin page
	 * @return Void
	 */
	public static function admin_css()
	{
		wp_enqueue_style(
			Settings::PLUGIN_PREFIX . '-theme-admin-style',
			self::_plugin_url( 'stylesheet/admin.css' ),
			array(),
			self::_filetime( self::_file_path( 'stylesheet/admin.css' ) )
		);
	}

	/**
	 * @since 1.0
	 * @package Register menu page plugin
	 * @return void
	 */
	public static function show_menu_page()
	{
		add_menu_page(
			'Social Share Buttons by Jogar Mais | Settings',
			'Share Buttons',
			'manage_options',
			Init::PLUGIN_SLUG,
			array( 'JM\Share_Buttons\Setting_View', 'options' ),
			'dashicons-share-alt2'
	  	);
	}

	/**
	 * @since 1.0
	 * @package Plugin file url in assets directory
	 * @return String
	 */
	protected static function _plugin_url( $file )
	{
		$file_url = plugins_url( 'assets/' . $file, __DIR__ );

		return $file_url;
	}

	/**
	 * @since 1.0
	 * @package Plugin file path in assets directory
	 * @return String
	 */
	protected static function _file_path( $file )
	{
		$path = plugin_dir_path( dirname( __FILE__ ) ) . Settings::DS . 'assets/' . $file;

		return $path;
	}

	/**
	 * @since 1.0
	 * @package Generate file time style and scripts
	 * @return Integer
	 */
	protected static function _filetime( $path )
	{
		$file_time = date( 'dmYHi', filemtime( $path ) );

		return $file_time;
	}

	/**
	 * @since 1.0
	 * @package Convert string for lowercase
	 * @return String
	 */
	protected static function _strtolower( $string )
	{
		return strtolower( $string );
	}

	/**
	 * @since 1.0
	 * @package Convert string for uppercase
	 * @return String
	 */
	protected static function _strtoupper( $string )
	{
		return strtoupper( $string );
	}
}
<?php
/**
 *
 * @package Social Sharing Buttons
 * @subpackage Functions
 * @author  Victor Freitas
 * @version 1.7
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//Controller
Init::uses( 'ajax', 'Controller' );
Init::uses( 'shares', 'Controller' );
Init::uses( 'options', 'Controller' );
Init::uses( 'sharing-reports', 'Controller' );
Init::uses( 'settings', 'Controller' );

//Utils
Init::uses( 'utils', 'Helper' );

class Core
{
	/**
	 * Intance class share report controller
	 *
	 * @since 1.0
	 * @var Object
	 */
	private static $report;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.2
	 */
	public function __construct()
	{
		register_activation_hook( Init::FILE, array( __CLASS__, 'activate' ) );
		register_deactivation_hook( Init::FILE, array( __CLASS__, 'deactivate' ) );
		register_uninstall_hook( Init::FILE, array( __CLASS__, 'uninstall' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'sharing_report_update_db_check' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'load_text_domain' ) );

		$settings       = new Settings_Controller();
		$share          = new Shares_Controller();
		$option         = new Options_Controller();
		static::$report = new Sharing_Reports_Controller();

	}

	/**
	 * Generate object all social icons
	 *
	 * @since 1.3
	 * @param String $title
	 * @param String $url
	 * @param String $tracking
	 * @param String $thumbnail
	 * @param String $body_mail
	 * @param String $caracter
	 * @param String $twitter_via
	 * @return Object all data links
	 */
	private static function _set_elements( $title, $url, $tracking, $thumbnail, $body_mail, $caracter, $twitter_via )
	{
		$action         = 'data-action="open-popup"';
		$prefix         = Setting::PREFIX;
		$item           = "{$prefix}-item";
		$class_button   = "{$prefix}-button";
		$twitter_text_a = __( 'I just saw', Init::PLUGIN_SLUG );
		$twitter_text_b = __( 'Click to see also', Init::PLUGIN_SLUG );
		$share_services = array(
			'facebook' => array(
				'name'        => 'Facebook',
				'element'     => 'facebook',
				'link'        => "https://www.facebook.com/sharer/sharer.php?u={$url}{$tracking}",
				'title'       => __( 'Share on Facebook', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-facebook",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-facebook",
 				'popup'       => $action,
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => true,
			),
			'twitter' => array(
				'name'        => 'Twitter',
				'element'     => 'twitter',
				'link'        => "https://twitter.com/share?url={$url}&text={$twitter_text_a} {$title} - {$twitter_text_b} {$caracter}&via={$twitter_via}",
				'title'       => 'Tweetar',
				'class'       => "{$prefix}-twitter",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-twitter",
				'popup'       => $action,
				'inside'      => __( 'Tweet', Init::PLUGIN_SLUG ),
				'has_counter' => true,
			),
			'google_plus' => array(
				'name'        => 'Google Plus',
				'element'     => 'google-plus',
				'link'        => "https://plus.google.com/share?url={$url}{$tracking}",
				'title'       => __( 'Share on Google+', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-google-plus",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-google-plus",
				'popup'       => $action,
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => true,
			),
			'whatsapp' => array(
				'name'        => 'WhatsApp',
				'element'     => 'whatsapp',
				'link'        => "whatsapp://send?text={$title}{$caracter}{$url}{$tracking}",
				'title'       => __( 'Share on WhatsApp', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-whatsapp",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-whatsapp",
				'popup'       => '',
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => false,
			),
			'pinterest' => array(
				'name'        => 'Pinterest',
				'element'     => 'pinterest',
				'link'        => "https://pinterest.com/pin/create/button/?url={$url}{$tracking}&media={$thumbnail}&description={$title}",
				'title'       => __( 'Share on Pinterest', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-pinterest",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-pinterest",
				'popup'       => $action,
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => true,
			),
			'linkedin' => array(
				'name'        => 'Linkedin',
				'element'     => 'linkedin',
				'link'        => "https://www.linkedin.com/shareArticle?mini=true&url={$url}{$tracking}&title={$title}",
				'title'       => __( 'Share on Linkedin', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-linkedin",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-linkedin",
				'popup'       => $action,
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => true,
			),
			'tumblr' => array(
				'name'        => 'Tumblr',
				'element'     => 'tumblr',
				'link'        => 'http://www.tumblr.com/share',
				'title'       => __( 'Share on Tumblr', Init::PLUGIN_SLUG ),
				'class'       => "{$prefix}-tumblr",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-tumblr",
				'popup'       => $action,
				'inside'      => __( 'Share', Init::PLUGIN_SLUG ),
				'has_counter' => false,
			),
			'email' => array(
				'name'        => 'Email',
				'element'     => 'email',
				'link'        => "mailto:?subject={$title}&body={$url}{$body_mail}",
				'title'       => 'Enviar por email',
				'class'       => "{$prefix}-email",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-email",
				'popup'       => $action,
				'inside'      => 'Email',
				'has_counter' => false,
			),
			'printfriendly' => array(
				'name'        => 'PrintFriendly',
				'element'     => 'printer',
				'link'        => "http://www.printfriendly.com/print?url={$url}&partner=whatsapp",
				'title'       => 'Imprimir via Print Friendly',
				'class'       => "{$prefix}-printer",
				'class_item'  => $item,
				'class_link'  => $class_button,
				'class_icon'  => "{$prefix}-icon-printer",
				'popup'       => $action,
				'inside'      => __( 'Print', Init::PLUGIN_SLUG ),
				'has_counter' => false,
			),
		);

		$share_services = apply_filters( Init::PLUGIN_SLUG . 'social-share-args', $share_services );

		return Utils_Helper::array_to_object( $share_services );
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	private static function _get_elements_encode()
	{
		$arguments = self::_get_arguments();
		$tracking  = Utils_Helper::option( 'tracking' );
		$tracking  = Utils_Helper::html_decode( $tracking );
		$elements  = self::_set_elements(
			rawurlencode( $arguments['title'] ),
			rawurlencode( $arguments['link'] ),
			rawurlencode( $tracking ),
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] ),
			rawurlencode( '➜ ' ),
			Utils_Helper::option( 'twitter_via' )
		);

		return $elements;
	}

	/**
	 * Get arguments for social url elements
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private static function _get_arguments()
	{
		$title     = Utils_Helper::get_title();
		$body_mail = Utils_Helper::body_mail();
		$arguments = array(
			'title'     => "\"{$title} \"",
			'link'      => Utils_Helper::get_permalink(),
			'thumbnail' => Utils_Helper::get_image(),
			'body_mail' => "\n\n{$title}\n\n{$body_mail}\n",
		);

		return $arguments;
	}

	/**
	 * Encode all items from data services
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	public static function social_media_objects()
	{
		return self::_get_elements_encode();
	}

	/**
	 * Register Activation Hook
	 *
	 * @since 1.1
	 * @param Null
	 * @return Void
	 */
	public static function activate()
	{
		self::$report->create_table();
	}

	/**
	 * Register Deactivation Hook
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function deactivate()
	{

	}

	/**
	 * Register Uninstall Hook
	 *
	 * @since 1.3
	 * @global $wpdb
	 * @param Null
	 * @return Void
	 */
	public static function uninstall()
	{
		global $wpdb;
		$prefix = Setting::PREFIX_UNDERSCORE;

		// Options
		delete_option( $prefix );
		delete_option( "{$prefix}_settings" );
		delete_option( "{$prefix}_style_settings" );

		// Transients
		delete_transient( Setting::SSB_TRANSIENT );
		delete_transient( Setting::SSB_TRANSIENT_SELECT_COUNT );
		delete_transient( Setting::SSB_TRANSIENT_GOOGLE_PLUS );

		//Options multisite
		if ( is_multisite() ) :
			delete_site_option(  );
			delete_site_option( "{$prefix}_settings" );
			delete_site_option( "{$prefix}_style_settings" );
		endif;

		$table = $wpdb->prefix . Setting::TABLE_NAME;
		$sql   = "DROP TABLE IF EXISTS `{$table}`";

		$wpdb->query( $sql );
	}

	/**
	 * Verify database version and update database
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function sharing_report_update_db_check()
	{
		$option = get_site_option( Setting::TABLE_NAME . '_db_version' );

	    if ( $option !== Setting::DB_VERSION )
	        self::activate();
	}

	/**
	 * Initialize text domain hook, plugin translate
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public static function load_text_domain()
	{
		$plugin_dir = basename( dirname( Init::FILE ) );
		load_plugin_textdomain( Init::PLUGIN_SLUG, false, "{$plugin_dir}/languages/" );
	}
}
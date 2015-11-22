<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Settings Model
 * @version 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Setting
{
	/**
	 * Full Options
	 *
	 * @since 1.0
	 * @var Array
	 */
	private $full_options;

	/**
	 * Single value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $single;

	/**
	 * Before value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $before;

	/**
	 * After value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $after;

	/**
	 * Pages value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pages;

	/**
	 * Home value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $home;

	/**
	 * Class value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $class;

	/**
	 * Print friendly value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $printer;

	/**
	 * Google value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $google_plus;

	/**
	 * Pinterest value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $pinterest;

	/**
	 * Linkedin value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $linkedin;

	/**
	 * Facebook value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $facebook;

	/**
	 * Whatsapp value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $whatsapp;

	/**
	 * Twitter value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter;

	/**
	 * Tumblr value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tumblr;

	/**
	 * Email value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $email;

	/**
	 * Disabled css value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_css;

	/**
	 * Disabled scripts value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $disable_js;

	/**
	 * Layout value verify option
	 *
	 * @since 1.0
	 * @var String
	 */
	private $layout;

	/**
	 * Twitter username value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $twitter_username;

	/**
	 * UTM Tracking value verify option
	 *
	 * @since 1.0
	 * @var string
	 */
	private $tracking;

	/**
	 * Report cache time value verify option
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $report_cache_time;

	/**
	 * Social Media active
	 *
	 * @since 1.0
	 * @var Array
	 */
	private $social_media;

	/**
	 * Remove count buttons
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $remove_count;

	/**
	 * Remove inside buttons name
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $remove_inside;

	/**
	 * Elements position fixed
	 *
	 * @since 1.0
	 * @var String
	 */
	private $position_fixed;

	/**
	 * ID of post
	 *
	 * @since 1.0
	 * @var Integer
	 */
	private $ID;

	/**
	 * Plugin general prefix
	 *
	 * @since 1.0
	 * @var string
	 */
	const PREFIX = 'ssb-share';
	const PREFIX_UNDERSCORE = 'ssb_share';


	/**
	 * Sharing report db version
	 *
	 * @since 1.0
	 * @var string
	 */
	const DB_VERSION = '1.0';

	/**
	 * Sharing report table name
	 *
	 * @since 1.0
	 * @var string
	 */
	const TABLE_NAME = 'sharing_report';

	/**
	 * Directory separator AND File name
	 *
	 * @since 1.0
	 * @var string
	 */
	const DS = DIRECTORY_SEPARATOR;

	/**
	 * Name for transient function
	 *
	 * @since 1.0
	 * @var string
	 */
	const SSB_TRANSIENT = 'ssb-transient-sharing-report';
	const SSB_TRANSIENT_SELECT_COUNT = 'ssb-transient-sharing-report-select-count';
	const SSB_TRANSIENT_GOOGLE_PLUS = 'ssb-transient-google-plus';

	public function __construct( $ID = false )
	{
		if ( false !== $ID )
			$this->ID = abs( intval( $ID ) );
	}

	/**
	 * Magic function to retrieve the value of the attribute more easily.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed The attribute value
	 */
	public function __get( $prop_name )
	{
		if ( isset( $this->$prop_name ) )
			return $this->$prop_name;

		return $this->_get_property( $prop_name );
	}

	/**
	 * Use in __get() magic method to retrieve the value of the attribute
	 * on demand. If the attribute is unset get his value before.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed String/Integer The value of the attribute
	 */
	private function _get_property( $prop_name )
	{
		switch ( $prop_name ) :

			case 'full_options' :
				if ( ! isset( $this->full_options ) )
					$this->full_options = $this->get_options();
				break;

			case 'single' :
				if ( ! isset( $this->single ) )
					$this->single = Utils_Helper::option( 'single' );
				break;

			case 'before' :
				if ( ! isset( $this->before ) )
					$this->before = Utils_Helper::option( 'before' );
				break;

			case 'after' :
				if ( ! isset( $this->after ) )
					$this->after = Utils_Helper::option( 'after' );
				break;

			case 'pages' :
				if ( ! isset( $this->pages ) )
					$this->pages = Utils_Helper::option( 'pages' );
				break;

			case 'home' :
				if ( ! isset( $this->home ) )
					$this->home = Utils_Helper::option( 'home' );
				break;

			case 'class' :
				if ( ! isset( $this->class ) )
					$this->class = Utils_Helper::option( 'class' );
				break;

			case 'printer' :
				if ( ! isset( $this->printer ) )
					$this->printer = Utils_Helper::option( 'printer' );
				break;

			case 'google_plus' :
				if ( ! isset( $this->google_plus ) )
					$this->google_plus = Utils_Helper::option( 'google-plus' );
				break;

			case 'pinterest' :
				if ( ! isset( $this->pinterest ) )
					$this->pinterest = Utils_Helper::option( 'pinterest' );
				break;

			case 'linkedin' :
				if ( ! isset( $this->linkedin ) )
					$this->linkedin = Utils_Helper::option( 'linkedin' );
				break;

			case 'facebook' :
				if ( ! isset( $this->facebook ) )
					$this->facebook = Utils_Helper::option( 'facebook' );
				break;

			case 'whatsapp' :
				if ( ! isset( $this->whatsapp ) )
					$this->whatsapp = Utils_Helper::option( 'whatsapp' );
				break;

			case 'twitter' :
				if ( ! isset( $this->twitter ) )
					$this->twitter = Utils_Helper::option( 'twitter' );
				break;

			case 'tumblr' :
				if ( ! isset( $this->tumblr ) )
					$this->tumblr = Utils_Helper::option( 'tumblr' );
				break;

			case 'email' :
				if ( ! isset( $this->email ) )
					$this->email = Utils_Helper::option( 'email' );
				break;

			case 'disable_css' :
				if ( ! isset( $this->disable_css ) )
					$this->disable_css = Utils_Helper::option( 'disable_css' );
				break;

			case 'disable_js' :
				if ( ! isset( $this->disable_js ) )
					$this->disable_js = Utils_Helper::option( 'disable_js' );
				break;

			case 'layout' :
				if ( ! isset( $this->layout ) )
					$this->layout = Utils_Helper::option( 'layout', 'default', 'esc_html' );
				break;

			case 'twitter_username' :
				if ( ! isset( $this->twitter_username ) )
					$this->twitter_username = Utils_Helper::option( 'twitter_via' );
				break;

			case 'tracking' :
				if ( ! isset( $this->tracking ) )
					$this->tracking = Utils_Helper::option( 'tracking', '?utm_source=share_button&utm_medium=social_media&utm_campaign=social_share' );
				break;

			case 'report_cache_time' :
				if ( ! isset( $this->report_cache_time ) )
					$this->report_cache_time = Utils_Helper::option( 'report_cache_time', 10, 'intval' );
				break;

			case 'social_media' :
				if ( ! isset( $this->social_media ) )
					$this->social_media = get_option( self::PREFIX_UNDERSCORE . '_social_media' );
				break;

			case 'remove_count' :
				if ( ! isset( $this->remove_count ) )
					$this->remove_count = Utils_Helper::option( 'remove_count', 0, 'intval' );
				break;

			case 'remove_inside' :
				if ( ! isset( $this->remove_inside ) )
					$this->remove_inside = Utils_Helper::option( 'remove_inside', 0, 'intval' );
				break;

			case 'position_fixed' :
				if ( ! isset( $this->position_fixed ) )
					$this->position_fixed = Utils_Helper::option( 'position_fixed' );
				break;

			default :
				return false;
				break;

		endswitch;

		return $this->$prop_name;
	}

	/**
 	 * Merge array all options
 	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private function _merge_options()
	{
		$prefix_underscore = self::PREFIX_UNDERSCORE;
		$settings          = "{$prefix_underscore}_settings";
		$social_media      = "{$prefix_underscore}_social_media";
		$settings_extra    = "{$prefix_underscore}_extra_settings";

		$options = array_merge(
			(array) get_option( $settings ),
			(array) get_option( $social_media ),
			(array) get_option( $settings_extra )
		);

		return $options;
	}

	/**
	 * Get all options
	 *
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	public function get_options()
	{
		return $this->_merge_options();
	}
}
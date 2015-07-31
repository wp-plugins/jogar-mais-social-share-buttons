<?php
/**
 *
 * @package Social Share Buttons | Settings
 * @author  Victor Freitas
 * @subpackage Settings Model
 * @version 1.0.1
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

class Settings
{
	/**
	 * Total Options
	 *
	 * @since 1.0
	 * @var string
	 * @return array
	 */
	private $total_options;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $excerpt;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $single;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $before;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $after;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $pages;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $home;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $class;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $printfriendly;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $google;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $pinterest;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $linkedin;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $facebook;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $whatsapp;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $sms;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $twitter;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $tumblr;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $gmail;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $email;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $disable_css;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $icons_size;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var Integer
	 * @return Integer
	 */
	private $icons_style;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var Integer
	 * @return Integer
	 */
	private $desktop;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $twitter_username;
	
	/**
	 * Option
	 *
	 * @since 1.0
	 * @var string
	 * @return string
	 */
	private $tracking;

	const PLUGIN_PREFIX = 'jm-ssb';

	const PLUGIN_PREFIX_UNDERSCORE = 'jm_ssb';

	const DS = DIRECTORY_SEPARATOR;

	const FILE = __FILE__;

	const PLUGIN_NAME = 'Social Share Buttons';

	const PLUGIN_DESC = 'Adiciona os botões de compartilhamento automáticamente em posts e páginas';

	public function __construct()
	{

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
	 * @return mixed The value of the attribute
	 */
	private function _get_property( $prop_name )
	{
		switch ( $prop_name ) :

			case 'total_options' :
				if ( ! isset( $this->total_options ) )
					$this->total_options = $this->get_options();
				break;

			case 'excerpt' :
				if ( ! isset( $this->excerpt ) )
					$this->excerpt = $this->option( '_excerpt' );
				break;

			case 'single' :
				if ( ! isset( $this->single ) )
					$this->single = $this->option( '_single' );
				break;

			case 'before' :
				if ( ! isset( $this->before ) )
					$this->before = $this->option( '_before' );
				break;

			case 'after' :
				if ( ! isset( $this->after ) )
					$this->after = $this->option( '_after' );
				break;

			case 'pages' :
				if ( ! isset( $this->pages ) )
					$this->pages = $this->option( '_pages' );
				break;

			case 'home' :
				if ( ! isset( $this->home ) )
					$this->home = $this->option( '_home' );
				break;

			case 'class' :
				if ( ! isset( $this->class ) )
					$this->class = $this->option( '_class' );
				break;

			case 'printfriendly' :
				if ( ! isset( $this->printfriendly ) )
					$this->printfriendly = $this->option( '_PrintFriendly' );
				break;

			case 'google' :
				if ( ! isset( $this->google ) )
					$this->google = $this->option( '_Google' );
				break;

			case 'pinterest' :
				if ( ! isset( $this->pinterest ) )
					$this->pinterest = $this->option( '_Pinterest' );
				break;

			case 'linkedin' :
				if ( ! isset( $this->linkedin ) )
					$this->linkedin = $this->option( '_Linkedin' );
				break;

			case 'facebook' :
				if ( ! isset( $this->facebook ) )
					$this->facebook = $this->option( '_Facebook' );
				break;

			case 'whatsapp' :
				if ( ! isset( $this->whatsapp ) )
					$this->whatsapp = $this->option( '_Whatsapp' );
				break;

			case 'sms' :
				if ( ! isset( $this->sms ) )
					$this->sms = $this->option( '_Sms' );
				break;

			case 'twitter' :
				if ( ! isset( $this->twitter ) )
					$this->twitter = $this->option( '_Twitter' );
				break;

			case 'tumblr' :
				if ( ! isset( $this->tumblr ) )
					$this->tumblr = $this->option( '_Tumblr' );
				break;

			case 'gmail' :
				if ( ! isset( $this->gmail ) )
					$this->gmail = $this->option( '_Gmail' );
				break;

			case 'email' :
				if ( ! isset( $this->email ) )
					$this->email = $this->option( '_Email' );
				break;

			case 'disable_css' :
				if ( ! isset( $this->disable_css ) )
					$this->disable_css = $this->option( '_remove_style' );
				break;

			case 'icons_size' :
				if ( ! isset( $this->icons_size ) )
					$this->icons_size = $this->option( '_icons_style_size', 'intval' );
				break;

			case 'icons_style' :
				if ( ! isset( $this->icons_style ) )
					$this->icons_style = $this->option( '_icons_style' );
				break;

			case 'desktop' :
				if ( ! isset( $this->desktop ) )
					$this->desktop = $this->option( '_desktop', 'intval' );
				break;

			case 'twitter_username' :
				if ( ! isset( $this->twitter_username ) )
					$this->twitter_username = $this->option( '_twitter_via' );
				break;

			case 'tracking' :
				if ( ! isset( $this->tracking ) )
					$this->tracking = $this->option( '_tracking' );
				break;

			default :
				return false;
				break;

		endswitch;

		return $this->$prop_name;
	}

/**
	 * @since 1.0
	 * @param Show this options plugins
	 * @return Array all options this plugin
	 */
	private function _merge_options()
	{
		$options = array_merge(
			  (array) get_option( 'jm_ssb' )
			, (array) get_option( 'jm_ssb_settings' )
			, (array) get_option( 'jm_ssb_style_settings' )
		);

		return $options;
	}

	/**
	 * @since 1.0
	 * @param Return this options
	 * @return Array
	 */
	public function get_options()
	{
		return $this->_merge_options();
	}

	/**
	 * @since 1.0
	 * @param Get option unique and sanitize
	 * @return String
	 */
	private function option( $option, $sanitize = 'esc_html' )
	{
		$options = $this->get_options();

		if ( isset( $options[self::PLUGIN_PREFIX_UNDERSCORE . $option] ) )
			return Utils_Helper::sanitize_type( $options[self::PLUGIN_PREFIX_UNDERSCORE . $option], $sanitize );

		return '';
	}
}
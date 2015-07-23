<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Register Options
 * @author  Victor Freitas
 * @subpackage Social Buttons Options Admin Page
 * @since 1.0
 */

namespace JM\Share_Buttons;

Init::uses( 'share', 'View' );
Init::uses( 'setting', 'View' );

class Option_Controller
{
	/**
	 * Adds needed actions
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __construct()
	{
		add_action( 'admin_init', array( &$this, 'register_options' ) );
		add_action( 'admin_init', array( &$this, 'register_options_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_options_style_settings' ) );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin
	 * @return void
	 */
	public function register_options()
	{
		register_setting( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb' );

		$new_options = array(
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_single'  => 'on',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_before'  => 'on',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_after'   => 'off',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_pages'   => 'off',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_home'    => 'off',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_excerpt' => 'off',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_class'   => '',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_desktop' => 0,
		);
		add_option( 'jm_ssb', $new_options );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin
	 * @return void
	 */
	public function register_options_settings()
	{
		register_setting( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb_settings' );

		$new_options_settings = array(
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Facebook'      => 'Facebook',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Twitter'       => 'Twitter',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Google'        => 'Google',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Whatsapp'      => 'Whatsapp',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Sms'           => 'Sms',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Pinterest'     => 'Pinterest',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Linkedin'      => 'Linkedin',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Tumblr'        => 'Tumblr',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Gmail'         => 'Gmail',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_Email'         => 'Email',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_PrintFriendly' => 'PrintFriendly',
		);
		add_option( 'jm_ssb_settings', $new_options_settings );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin style configurations
	 * @return void
	 */
	public function register_options_style_settings()
	{
		register_setting( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb_style_settings' );

		$new_options_settings = array(
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'     => 'on',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_icons_style_size' => 32,
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_icons_style'      => 'default',
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'      => '',

		);
		add_option( 'jm_ssb_style_settings', $new_options_settings );
	}

	/**
	 * @since 1.0
	 * @package Show this options plugins
	 * @return Array all options this plugin
	 */
	public function options()
	{
		$option                 = get_option( 'jm_ssb' );
		$options_settings       = get_option( 'jm_ssb_settings' );
		$options_settings_style = get_option( 'jm_ssb_style_settings' );
		$get_options            = array_merge( (array) $option, (array) $options_settings, (array) $options_settings_style );

		return $get_options;
	}

	/**
	 * @since 1.0
	 * @package Check this options
	 * @return Array
	 */
	private function check_options()
	{
		$options = self::options();

		$array_options = array(
			0  => 'excerpt',
			1  => 'single',
			2  => 'before',
			3  => 'after',
			4  => 'pages',
			5  => 'home',
			6  => 'class',
			7  => 'PrintFriendly',
			8  => 'Google',
			9  => 'Pinterest',
			10 => 'Linkedin',
			11 => 'Facebook',
			12 => 'Whatsapp',
			13 => 'Sms',
			14 => 'Twitter',
			15 => 'Tumblr',
			16 => 'Gmail',
			17 => 'Email',
			18 => 'remove_style',
			19 => 'icons_style_size',
			20 => 'icons_style',
			21 => 'desktop',
			22 => 'twitter_via',
		);

		foreach ( $array_options as $value ) :

			if ( ! isset( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_' . $value] ) )
				$options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_' . $value] = '';

		endforeach;

		return $options;
	}

		/**
	 * @since 1.0
	 * @package Return this options
	 * @return Array
	 */
	public function get_options()
	{
		return $this->check_options();
	}
}
<?php
/**
 *
 * @package Jogar Mais - Social Share Buttons | Register Options
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
		add_action( 'admin_init', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_register_options' ) );
		add_action( 'admin_init', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_register_options_settings' ) );
		add_action( 'admin_init', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_register_options_style_settings' ) );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin
	 * @return void
	 */
	public function jm_ssb_register_options()
	{
		register_setting( Init::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb' );

		$new_options = array(
			Init::PLUGIN_PREFIX_UNDERSCORE . '_single'  => 'on',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_before'  => 'on',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_after'   => 'off',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_pages'   => 'off',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_home'    => 'off',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_excerpt' => 'off',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_class'   => '',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_desktop' => 0,
		);
		add_option( 'jm_ssb', $new_options );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin
	 * @return void
	 */
	public function jm_ssb_register_options_settings()
	{
		register_setting( Init::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb_settings' );

		$new_options_settings = array(
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Facebook'      => 'Facebook',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Twitter'       => 'Twitter',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Google'        => 'Google',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Whatsapp'      => 'Whatsapp',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Sms'           => 'Sms',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Pinterest'     => 'Pinterest',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Linkedin'      => 'Linkedin',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Tumblr'        => 'Tumblr',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Gmail'         => 'Gmail',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_Email'         => 'Email',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_PrintFriendly' => 'PrintFriendly',
		);
		add_option( 'jm_ssb_settings', $new_options_settings );
	}

	/**
	 * @since 1.0
	 * @package Register options plugin style configurations
	 * @return void
	 */
	public function jm_ssb_register_options_style_settings()
	{
		register_setting( Init::PLUGIN_PREFIX_UNDERSCORE . '_options_page', 'jm_ssb_style_settings' );

		$new_options_settings = array(
			Init::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'     => 'on',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_icons_style_size' => 32,
			Init::PLUGIN_PREFIX_UNDERSCORE . '_icons_style'      => 'default',
			Init::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'      => '',

		);
		add_option( 'jm_ssb_style_settings', $new_options_settings );
	}

	/**
	 * @since 1.0
	 * @package Show this options plugins
	 * @return Array all options this plugin
	 */
	public function jm_ssb_options()
	{
		$option                 = get_option( 'jm_ssb' );
		$options_settings       = get_option( 'jm_ssb_settings' );
		$options_settings_style = get_option( 'jm_ssb_style_settings' );
		$get_options            = array_merge( (array) $option, (array) $options_settings, (array) $options_settings_style );

		return $get_options;
	}

	/**
	 * @since 1.0
	 * @package Check this options plugins
	 * @return Array all options plugin
	 */
	public function jm_ssb_check_options()
	{
		$options = self::jm_ssb_options();

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

			if ( ! isset( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_' . $value] ) )
				$options[Init::PLUGIN_PREFIX_UNDERSCORE . '_' . $value] = '';

		endforeach;

		return $options;
	}
}
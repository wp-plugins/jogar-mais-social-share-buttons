<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Register Options
 * @author  Victor Freitas
 * @subpackage Social Buttons Options Admin Page
 * @since 1.0.2
 */

namespace JM\Share_Buttons;

//View
Init::uses( 'share', 'View' );
Init::uses( 'setting', 'View' );
//Model
Init::uses( 'settings', 'Model' );

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
	 * @param Register options plugin
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
	 * @param Register options plugin
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
	 * @param Register options plugin style configurations
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
			Settings::PLUGIN_PREFIX_UNDERSCORE . '_tracking'         => '?utm_source=share_buttons&utm_medium=social_media&utm_campaign=social_share',
		);
		add_option( 'jm_ssb_style_settings', $new_options_settings );
	}
}
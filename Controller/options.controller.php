<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Options Admin Page
 * @since 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Options_Controller
{
	/**
	 * Adds needed actions initialize class
	 *
	 * @since 1.0
	 * @return void
	 */
	public function __construct()
	{
		add_action( 'admin_init', array( &$this, 'register_options_settings' ) );
		add_action( 'admin_init', array( &$this, 'register_options_social_media' ) );
		add_action( 'admin_init', array( &$this, 'register_options_extra_settings' ) );
	}

	/**
	 * Register options plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function register_options_settings()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_name       = "{$prefix_underscore}_settings";
		$option_group      = "{$option_name}_group";

		register_setting( $option_group, $option_name );

		$value = array(
			'single'  => 'on',
			'before'  => 'on',
			'after'   => 'off',
			'pages'   => 'off',
			'home'    => 'off',
			'class'   => '',
			'layout'  => 'default',
		);

		add_option( $option_name, $value );
	}

	/**
	 * Register options social media plugin
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function register_options_social_media()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_group      = "{$prefix_underscore}_settings_group";
		$option_name       = "{$prefix_underscore}_social_media";

		register_setting( $option_group, $option_name );

		$value = array(
			'facebook'    => 'facebook',
			'twitter'     => 'twitter',
			'google_plus' => 'google-plus',
			'whatsapp'    => 'whatsapp',
			'pinterest'   => 'pinterest',
			'linkedin'    => 'linkedin',
			'tumblr'      => 'tumblr',
			'email'       => 'email',
			'printer'     => 'printer',
		);

		add_option( $option_name, $value );
	}

	/**
	 * Register options plugin extra configurations
	 *
	 * @since 1.1
	 * @param Null
	 * @return void
	 */
	public function register_options_extra_settings()
	{
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$option_name       = "{$prefix_underscore}_extra_settings";
		$option_group      = "{$option_name}_group";

		register_setting( $option_group, $option_name );

		$value = array(
			'disable_css'       => 'off',
			'disable_js'        => 'off',
			'twitter_via'       => '',
			'remove_count'      => 0,
			'remove_inside'     => 0,
			'tracking'          => '?utm_source=share_buttons&utm_medium=social_media&utm_campaign=social_share',
			'report_cache_time' => 10,
		);

		add_option( $option_name, $value );
	}
}
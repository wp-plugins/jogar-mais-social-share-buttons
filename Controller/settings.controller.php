<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais
 * @author  Victor Freitas
 * @subpackage Social Settings Controller
 * @version 1.0.2
 */

namespace JM\Share_Buttons;

class Settings_Controller
{
	public function __construct()
	{
		add_filter( 'plugin_action_links_' . Utils_Helper::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_style' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );		
		register_activation_hook( Settings::FILE, array( &$this, 'activate' ) );
		register_deactivation_hook( Settings::FILE, array( &$this, 'deactivate' ) );
	}

	/**
	 * @since 1.0
	 * @param Adds links page plugin action
	 * @return Array links action plugins
	 */
	public function plugin_link( $links )
	{
		$page_link     = get_admin_url( null,  'admin.php?page=' . Init::PLUGIN_SLUG );
		$settings_link = "<a href=\"{$page_link}\">Configurações</a>";
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * @since 1.0
	 * @param Enqueue scripts and styles
	 * @return Void
	 */
	public function scripts()
	{
		wp_enqueue_script(
			Settings::PLUGIN_PREFIX . '-theme-scripts',
			Utils_Helper::plugin_url( 'javascripts/script.min.js' ),
			array( 'jquery' ),
			Utils_Helper::filetime( Utils_Helper::file_path( 'javascripts/script.min.js' ) ),
			true
		);

		if ( 'off' === Utils_Helper::option( 'remove_style' ) )
			return;

		wp_enqueue_style(
			Settings::PLUGIN_PREFIX . '-theme-style',
			Utils_Helper::plugin_url( 'stylesheet/style.css' ),
			array(),
			Utils_Helper::filetime( Utils_Helper::file_path( 'stylesheet/style.css' ) )
		);
	}

	/**
	 * @since 1.0
	 * @param Enqueue scripts and styles for admin page
	 * @return Void
	 */
	public function admin_style()
	{
		wp_enqueue_style(
			Settings::PLUGIN_PREFIX . '-theme-admin-style',
			Utils_Helper::plugin_url( 'stylesheet/admin.css' ),
			array(),
			Utils_Helper::filetime( Utils_Helper::file_path( 'stylesheet/admin.css' ) )
		);
	}

	/**
	 * @since 1.0
	 * @param Register menu page plugin
	 * @return void
	 */
	public function menu_page()
	{
		add_menu_page(
			'Social Share Buttons by Jogar Mais | Settings',
			'Share Buttons',
			'manage_options',
			Init::PLUGIN_SLUG,
			array( 'JM\Share_Buttons\Setting_View', 'render_settings_page' ),
			'dashicons-share-alt2'
	  	);
	}

	/**
	 * @since 1.0
	 * @param Register Activation Hook
	 * @return Void
	 */
	public function activate()
	{

	}

	/**
	 * @since 1.0
	 * @param Register Deactivation Hook
	 * @return Void
	 */
	public function deactivate()
	{

	}
}
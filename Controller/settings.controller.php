<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Settings Controller
 * @version 1.0.3
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

Init::uses( 'ajax', 'Controller' );

class Settings_Controller
{
	public function __construct()
	{
		register_activation_hook( Settings::FILE, array( &$this, 'activate' ) );
		register_deactivation_hook( Settings::FILE, array( &$this, 'deactivate' ) );
		add_filter( 'plugin_action_links_' . Utils_Helper::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_style' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );		
		add_action( 'wp_ajax_nopriv_get_plus_google', array( 'JM\Share_Buttons\Ajax_Controller', 'get_plus_google' ) );
		add_action( 'wp_ajax_get_plus_google', array( 'JM\Share_Buttons\Ajax_Controller', 'get_plus_google' ) );
		add_action( 'wp_ajax_nopriv_global_counts_social_share', array( 'JM\Share_Buttons\Ajax_Controller', 'global_counts_social_share' ) );
		add_action( 'wp_ajax_global_counts_social_share', array( 'JM\Share_Buttons\Ajax_Controller', 'global_counts_social_share' ) );
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

		wp_localize_script(
			Settings::PLUGIN_PREFIX . '-theme-scripts',
			'PluginGlobalVars',
			array(
				'urlAjax' => admin_url( 'admin-ajax.php' ),
			)
		);

		if ( 'off' === Utils_Helper::option( '_remove_style' ) )
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
			'Social Share Buttons',
			'Share Buttons',
			'manage_options',
			Init::PLUGIN_SLUG,
			array( 'JM\Share_Buttons\Setting_View', 'render_settings_page' ),
			'dashicons-share-alt2'
	  	);

	  	add_submenu_page(
	  		Init::PLUGIN_SLUG,
	  		'Extra Settings | Social Share Buttons',
	  		'Configurações extra',
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-extra-settings',
	  		array( 'JM\Share_Buttons\Setting_View', 'render_extra_settings_page' )
	  	);

	  	add_submenu_page(
	  		Init::PLUGIN_SLUG,
	  		'Opções de uso | Social Share Buttons',
	  		'Opções de uso',
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-faq',
	  		array( 'JM\Share_Buttons\Setting_View', 'render_page_faq' )
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
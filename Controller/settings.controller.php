<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Settings Controller
 * @version 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//View
Init::uses( 'settings', 'View' );
Init::uses( 'settings-extra', 'View' );
Init::uses( 'settings-faq', 'View' );

//Model
Init::uses( 'setting', 'Model' );

class Settings_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_filter( 'plugin_action_links_' . Utils_Helper::base_name(), array( &$this, 'plugin_link' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts' ) );
		add_action( 'admin_menu', array( &$this, 'menu_page' ) );
		add_action( 'wp_ajax_nopriv_get_plus_google', array( 'JM\Share_Buttons\Ajax_Controller', 'get_plus_google' ) );
		add_action( 'wp_ajax_get_plus_google', array( 'JM\Share_Buttons\Ajax_Controller', 'get_plus_google' ) );
		add_action( 'wp_ajax_nopriv_global_counts_social_share', array( 'JM\Share_Buttons\Ajax_Controller', 'global_counts_social_share' ) );
		add_action( 'wp_ajax_global_counts_social_share', array( 'JM\Share_Buttons\Ajax_Controller', 'global_counts_social_share' ) );
	}

	/**
	 * Adds links page plugin action
	 *
	 * @since 1.0
	 * @param Array $links
	 * @return Array links action plugins
	 */
	public function plugin_link( $links )
	{
		$page_link     = get_admin_url( null,  'admin.php?page=' . Init::PLUGIN_SLUG );
		$settings      = __( 'Settings', Init::PLUGIN_SLUG );
		$settings_link = "<a href=\"{$page_link}\">{$settings}</a>";
		array_unshift( $links, $settings_link );

		return $links;
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public function scripts()
	{
		if ( 'on' !== Utils_Helper::option( 'disable_js' ) ) :
			wp_enqueue_script(
				Setting::PREFIX . '-scripts',
				Utils_Helper::plugin_url( 'javascripts/built.front.js' ),
				array( 'jquery' ),
				Utils_Helper::filetime( Utils_Helper::file_path( 'javascripts/built.front.js' ) ),
				true
			);

			wp_localize_script(
				Setting::PREFIX . '-scripts',
				'PluginGlobalVars',
				array(
					'urlAjax' => admin_url( 'admin-ajax.php' ),
				)
			);
		endif;

		if ( 'on' !== Utils_Helper::option( 'disable_css' ) ) :
			wp_enqueue_style(
				Setting::PREFIX . '-style',
				Utils_Helper::plugin_url( 'stylesheets/style.css' ),
				array(),
				Utils_Helper::filetime( Utils_Helper::file_path( 'stylesheets/style.css' ) )
			);
		endif;
	}

	/**
	 * Enqueue scripts and stylesheets on admin
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void
	 */
	public function admin_scripts()
	{
		wp_enqueue_script(
			Setting::PREFIX . '-admin-scripts',
			Utils_Helper::plugin_url( 'javascripts/built.admin.js' ),
			array( 'jquery' ),
			Utils_Helper::filetime( Utils_Helper::file_path( 'javascripts/built.admin.js' ) ),
			true
		);

		wp_enqueue_style(
			Setting::PREFIX . '-admin-style',
			Utils_Helper::plugin_url( 'stylesheets/admin.css' ),
			array(),
			Utils_Helper::filetime( Utils_Helper::file_path( 'stylesheets/admin.css' ) )
		);
	}

	/**
	 * Register menu page and submenus
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function menu_page()
	{
		add_menu_page(
			__( 'Social Sharing Buttons', Init::PLUGIN_SLUG ),
			__( 'Sharing Buttons', Init::PLUGIN_SLUG ),
			'manage_options',
			Init::PLUGIN_SLUG,
			array( 'JM\Share_Buttons\Settings_View', 'render_settings_page' ),
			'dashicons-share-alt2'
	  	);

	  	add_submenu_page(
	  		Init::PLUGIN_SLUG,
	  		__( 'Extra Settings | Social Sharing Buttons', Init::PLUGIN_SLUG ),
	  		__( 'Extra Settings', Init::PLUGIN_SLUG ),
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-extra-settings',
	  		array( 'JM\Share_Buttons\Settings_Extra_View', 'render_settings_extra' )
	  	);

	  	add_submenu_page(
	  		Init::PLUGIN_SLUG,
	  		__( 'Use options | Social Sharing Buttons', Init::PLUGIN_SLUG ),
	  		__( 'Use options', Init::PLUGIN_SLUG ),
	  		'manage_options',
	  		Init::PLUGIN_SLUG . '-faq',
	  		array( 'JM\Share_Buttons\Settings_Faq_View', 'render_page_faq' )
	  	);
	}
}
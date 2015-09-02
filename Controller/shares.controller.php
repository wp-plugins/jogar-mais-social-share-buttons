<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 1.2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Shares_Controller
{
	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_shortcode( 'JM_SHARE', array( 'JM\Share_Buttons\Share_View', 'links' ) );
		add_shortcode( 'JM_SHARE_WHATSAPP', array( 'JM\Share_Buttons\Share_View', 'whatsapp' ) );
		add_filter( 'the_content', array( &$this, 'content' ), 100 );
		add_action( 'init', array( &$this, 'custom_excerpt' ) );
		add_filter( 'wp_head', array( 'JM\Share_Buttons\Share_View', 'icons_style' ) );
	}

	/**
	 * Verifies that is active buttons to the_excerpt
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Void
	 */
	public function custom_excerpt()
	{
		if ( $this->option( '_excerpt' ) === 'on' )
			add_filter( 'the_excerpt', array( &$this, 'content' ), 100 );
	}

	/**
	 * The content check insertions
	 * 
	 * @since 1.0
	 * @param Null
	 * @return string
	 */
	protected function _check_new_content()
	{
		$position = '';

		if ( $this->option( '_before' ) === 'on' && $this->option( '_after' ) === 'on' )
			$position = 'full';

		if ( $this->option( '_before' ) === 'on' && $this->option( '_after' ) !== 'on' )
			$position = 'before';

		if ( $this->option( '_before' ) !== 'on' && $this->option( '_after' ) === 'on' )
			$position = 'after';

		return $position;
	}

	/**
	 * The content after it is finished processing
	 * 
	 * @since 1.0
	 * @param String $the_content
	 * @return String content single, pages, home
	 */
	public function content( $the_content )
	{
		$buttons     = Share_View::links();
		$new_content = '';

		if ( $this->_is_single() || $this->_is_page() || $this->_is_home() ) :

			switch ( $this->_check_new_content() ) :
				case 'full' :
		      		$new_content .= $buttons;
		      		$new_content .= $the_content;
		      		$new_content .= $buttons;
		      		$the_content = $new_content;
					break;

				case 'before' :
					$new_content .= $buttons;
					$new_content .= $the_content;
					$the_content = $new_content;
					break;

				case 'after' :
					$new_content .= $the_content;
					$new_content .= $buttons;
					$the_content = $new_content;
					break;
			endswitch;

	    	return $the_content;

		endif;

		return $the_content;
	}

	/**
	 * Make sure is activated the sharing buttons in singles
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_single()
	{
		if ( is_single() && $this->option( '_single' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * Make sure is activated the sharing buttons in pages
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_page()
	{
		if ( is_page() && $this->option( '_pages' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * make sure is activated the sharing buttons in home
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Boolean
	 */
	protected function _is_home()
	{
		if ( ( is_home() || is_front_page() ) && $this->option( '_home' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * Get unique option result
	 * 
	 * @since 1.0
	 * @param String $Option
	 * @return string
	 */
	private function option( $option )
	{
		$model   = new Settings();
		$options = $model->total_options;

		if ( isset( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option] ) )
			return $options[Settings::PLUGIN_PREFIX_UNDERSCORE . $option];

		return '';
	}
}
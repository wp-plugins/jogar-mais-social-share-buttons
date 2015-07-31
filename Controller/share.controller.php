<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 1.0.3
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) ) :
	exit(0);
endif;

class Share_Controller
{
	public function __construct()
	{
		add_shortcode( 'JMSSB', array( 'JM\Share_Buttons\Share_View', 'links' ) );
		add_shortcode( 'JMSSBWHATSAPP', array( 'JM\Share_Buttons\Share_View', 'whatsapp' ) );
		add_filter( 'the_content', array( &$this, 'content' ), 100 );
		add_action( 'init', array( &$this, 'custom_excerpt' ) );
		add_filter( 'wp_head', array( 'JM\Share_Buttons\Share_View', 'icons_style' ) );
	}

	/**
	 * @since 1.0
	 * @param Verifies that is active buttons to the_excerpt
	 * @return Void
	 */
	public function custom_excerpt()
	{
		if ( $this->option( '_excerpt' ) === 'on' )
			add_filter( 'the_excerpt', array( &$this, 'content' ), 100 );
	}

	/**
	 * @since 1.0
	 * @param The content check insertions
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
	 * @since 1.0
	 * @param The content after it is finished processing
	 * @return String the_content single, pages, home
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
	 * @since 1.0
	 * @param Make sure is activated the sharing buttons in singles
	 * @return Bool
	 */
	protected function _is_single()
	{
		if ( is_single() && $this->option( '_single' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * @since 1.0
	 * @param Make sure is activated the sharing buttons in pages
	 * @return Bool
	 */
	protected function _is_page()
	{
		if ( is_page() && $this->option( '_pages' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * @since 1.0
	 * @param make sure is activated the sharing buttons in home
	 * @return Bool
	 */
	protected function _is_home()
	{
		if ( ( is_home() || is_front_page() ) && $this->option( '_home' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * @since 1.0
	 * @param Option
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
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

//View
Init::uses( 'shares', 'View' );

class Shares_Controller
{
	private $_fixed = false;

	/**
	* Initialize the plugin by setting localization, filters, and administration functions.
	*
	* @since 1.2
	*/
	public function __construct()
	{
		add_shortcode( 'SSB_SHARE', array( 'JM\Share_Buttons\Shares_View', 'ssb_share' ) );
		add_filter( 'the_content', array( &$this, 'content' ), 100 );
		add_action( 'wp_footer', array( &$this, 'footer' ), 100 );
	}

	/**
	 * The content check insertions
	 *
	 * @since 1.0
	 * @param Null
	 * @return string
	 */
	protected function _check_position()
	{
		$position = '';
		$before   = Utils_Helper::option( 'before' );
		$after    = Utils_Helper::option( 'after' );
		$fixed    = Utils_Helper::option('fixed');

		if ( 'on' === $before &&  'on' === $after )
			$position = 'full';

		if ( 'on' === $before && 'on' !== $after )
			$position = 'before';

		if ( 'on' !== $before && 'on' === $after )
			$position = 'after';

		if ( 'on' === $fixed )
			$position = 'fixed';

		return $position;
	}

	/**
	 * The content after it is finished processing
	 *
	 * @since 1.0
	 * @param String $content
	 * @return String content single, pages, home
	 */
	public function content( $content )
	{
		if ( $this->_is_single() || $this->_is_page() || $this->_is_home() ) :
			$buttons = Shares_View::buttons_share();

			switch ( $this->_check_position() ) :
				case 'full' :
		      		$new_content  = $buttons;
		      		$new_content .= $content;
		      		$new_content .= $buttons;
		      		$content      = $new_content;
					break;

				case 'before' :
					$new_content  = $buttons;
					$new_content .= $content;
					$content      = $new_content;
					break;

				case 'after' :
					$new_content  = $content;
					$new_content .= $buttons;
					$content      = $new_content;
					break;

				case 'fixed' :
					$this->_fixed = true;
					break;
			endswitch;

	    	return $content;
		endif;

		return $content;
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
		if ( is_single() && Utils_Helper::option( 'single' ) === 'on' )
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
		if ( ( is_page() || is_page_template() )  && Utils_Helper::option( 'pages' ) === 'on' )
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
		if ( ( is_home() || is_front_page() ) && Utils_Helper::option( 'home' ) === 'on' )
			return true;

		return false;
	}

	/**
	 * Add buttons on footer case selected layout fixed
	 *
	 * @since 1.0
	 * @param Null
	 * @return void
	 */
	public function footer()
	{
		if ( ! $this->_fixed )
			return;

		echo Shares_View::buttons_share();
	}
}
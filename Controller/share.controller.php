<?php
/**
 *
 * @package Jogar Mais - Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 */

namespace JM\Share_Buttons;

class Share_Controller
{
	public $options_controller;

	public function __construct()
	{
		$this->options_controller = new Option_Controller();

		add_shortcode( 'JMSSB', array( 'JM\Share_Buttons\Share_View', Init::PLUGIN_PREFIX_UNDERSCORE . '_links' ) );
		add_shortcode( 'JMSSBWHATSAPP', array( 'JM\Share_Buttons\Share_View', Init::PLUGIN_PREFIX_UNDERSCORE . '_whatsapp' ) );
		add_filter( 'the_content', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_content' ), 100 );
		add_action( 'init', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_custom_excerpt' ) );
		add_filter( 'wp_head', array( 'JM\Share_Buttons\Share_View', Init::PLUGIN_PREFIX_UNDERSCORE . '_icons_style' ) );
	}

	/**
	 * @since 1.0
	 * @package Verifies that is active buttons to the_excerpt
	 * @return Void
	 */
	public function jm_ssb_custom_excerpt()
	{
		$options = $this->options_controller->jm_ssb_check_options();

		if ( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_excerpt'] === 'on' )
			add_filter( 'the_excerpt', array( &$this, Init::PLUGIN_PREFIX_UNDERSCORE . '_content' ), 100 );
	}

	/**
	 * @since 1.0
	 * @package The content check insertions
	 * @return string
	 */
	protected function _jm_ssb_check_new_content()
	{
		$options  = $this->options_controller->jm_ssb_check_options();
		$position = '';

		if ( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_before'] === 'on' && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_after'] === 'on' )
			$position = 'full';

		if ( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_before'] === 'on' && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_after'] !== 'on' )
			$position = 'before';

		if ( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_before'] !== 'on' && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_after'] === 'on' )
			$position = 'after';

		return $position;
	}

	/**
	 * @since 1.0
	 * @package The content after it is finished processing
	 * @return String the_content single, pages, home
	 */
	public function jm_ssb_content( $the_content )
	{
		$buttons     = Share_View::jm_ssb_links();
		$options     = $this->options_controller->jm_ssb_check_options();
		$new_content = '';

		if ( $this->_jm_ssb_is_single() || $this->_jm_ssb_is_page() || $this->_jm_ssb_is_home() ) :

	      	if ( $this->_jm_ssb_check_new_content() === 'full' ) :
	      		$new_content .= $buttons;
	      		$new_content .= $the_content;
	      		$new_content .= $buttons;
	      		$the_content = $new_content;
	      	endif;

	      	if ( $this->_jm_ssb_check_new_content() === 'before' ) :
				$new_content .= $buttons;
				$new_content .= $the_content;
				$the_content = $new_content;
	      	endif;

	      	if ( $this->_jm_ssb_check_new_content() === 'after' ) :
				$new_content .= $the_content;
				$new_content .= $buttons;
				$the_content = $new_content;
	      	endif;

	    	return $the_content;

		endif;

		return $the_content;
	}

	/**
	 * @since 1.0
	 * @package Make sure is activated the sharing buttons in singles
	 * @return Bool
	 */
	protected function _jm_ssb_is_single()
	{
		$options = $this->options_controller->jm_ssb_check_options();

		if ( is_single() && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_single'] === 'on' )
			return true;

		return false;
	}

	/**
	 * @since 1.0
	 * @package Make sure is activated the sharing buttons in pages
	 * @return Bool
	 */
	protected function _jm_ssb_is_page()
	{
		$options = $this->options_controller->jm_ssb_check_options();

		if ( is_page() && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_pages'] === 'on' )
			return true;

		return false;
	}

	/**
	 * @since 1.0
	 * @package make sure is activated the sharing buttons in home
	 * @return Bool
	 */
	protected function _jm_ssb_is_home()
	{
		$options = $this->options_controller->jm_ssb_check_options();

		if ( ( is_home() || is_front_page() ) && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_home'] === 'on' )
			return true;

		return false;
	}
}
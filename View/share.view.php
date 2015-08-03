<?php
/**
 *
 * @package Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 1.1.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Share_View extends Core
{
	/**
	 * Generate all icons sharing
	 * 
	 * @since 1.0
	 * @param Array $atts
	 * @return HTML
	 *
	 */
	public static function links( $atts = array() )
	{
		$model = new Settings();

		if ( 1 === $model->desktop )
			return self::theme_secondary();

		if ( 2 === $model->desktop )
			return self::theme_total_counter();

		extract(
			shortcode_atts(
				array(
					'class_ul'   => '',
					'class_li'   => '',
					'class_link' => '',
					'class_icon' => '',
				),
				$atts, 'JMSSB'
			)
		);

		$options            = $model->get_options();
		$services           = parent::_get_elements();
		$prefix             = Settings::PLUGIN_PREFIX;
		$class_default      = "{$prefix}-shared ";
		$class_default_icon = "{$prefix}-icon ";
		$class_icon         = Utils_Helper::esc_html( $class_icon );
		$class_link         = Utils_Helper::esc_html( $class_link );
		$class_li           = Utils_Helper::esc_html( $class_li );
		$buttons_content    = self::_start_buttons_content(
			Utils_Helper::get_permalink(),
			Utils_Helper::esc_html( $class_ul ),
			$model->class
		);

		foreach ( $services as $key => $social ) :

			if ( ! in_array( $social->name, (array) $options ) )
				continue;

			$attr_href        = self::_add_attr_link( $social->name, $social->link );
			$buttons_content .= "<div class=\"{$class_default} {$social->class} {$class_li}\">";
			$buttons_content .= "<a {$attr_href} {$social->popup} class=\"{$class_link}\" title=\"{$social->title}\">";
			$buttons_content .= "<i class=\"{$class_default_icon} {$prefix}-{$social->img} {$class_icon}\"></i>";
			$buttons_content .= '</a>';
			$buttons_content .= self::_add_counter( $social->name );
			$buttons_content .= '</div>';

		endforeach;

		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * Display icons theme secondary ( Facebook; Google Plus; Twitter; Linkedin )
	 * 
	 * @since 1.0
	 * @param Null
	 * @return HTML 
	 *
	 */
	public static function theme_secondary()
	{
		$nonce            = wp_create_nonce( Ajax_Controller::AJAX_VERIFY_NONCE_COUNTER );
		$services         = parent::_get_elements();
		$prefix           = Settings::PLUGIN_PREFIX;
		$post_id          = Utils_Helper::get_id();
		$permalink        = Utils_Helper::get_permalink();
		$buttons_content  = "<div class=\"{$prefix}-container-theme-two\" data-element-{$prefix} data-attr-nonce=\"{$nonce}\"";
		$buttons_content .= " data-attr-reference=\"{$post_id}\" data-element-url=\"{$permalink}\">";
		$buttons_content .= self::_change_button( $services->facebook, $prefix );
		$buttons_content .= self::_change_button( $services->google_plus, $prefix );
		$buttons_content .= self::_change_button( $services->twitter, $prefix );
		$buttons_content .= self::_change_button( $services->whatsapp, $prefix );
		$buttons_content .= self::_change_button( $services->linkedin, $prefix );
		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * Create HTML dinamic from icons
	 * 
	 * @since 1.0
	 * @param Array $reference
	 * @param String $prefix
	 * @return HTML
	 *
	 */
	private static function _change_button( $reference = array(), $prefix )
	{
		$element  = strtolower( $reference->name );
		$content  = "<div class=\"jm-ssb-theme-two {$element}-share\">";		
		$content .= "<a data-attr-url=\"{$reference->link}\" {$reference->popup} title=\"{$reference->title}\">";
		$content .= "<i class=\"{$prefix}-icons-align {$prefix}-{$reference->img}\"></i>";
		$content .= ( $element == 'twitter' ) ? 'tweetar' : 'Compartilhar';
		$content .= '</a>';
		$content .= "<span class=\"count\" data-counter-{$element}>...</span>";
		$content .= '</div>';

		return $content;
	}

	/**
	 * Display icons theme total counter ( Facebook; Google Plus; Twitter; Linkedin; whatsapp )
	 * 
	 * @since 1.0
	 * @param Null
	 * @return HTML 
	 *
	 */
	public static function theme_total_counter()
	{
		$nonce            = wp_create_nonce( Ajax_Controller::AJAX_VERIFY_NONCE_COUNTER );
		$services         = parent::_get_elements();
		$prefix           = Settings::PLUGIN_PREFIX;
		$post_id          = Utils_Helper::get_id();
		$permalink        = Utils_Helper::get_permalink();
		$buttons_content  = "<div class=\"{$prefix}-theme-total-share\" data-element-{$prefix} data-attr-nonce=\"{$nonce}\"";
		$buttons_content .= " data-attr-reference=\"{$post_id}\" data-element-url=\"{$permalink}\">";	
		$buttons_content .= "<div class=\"{$prefix}-total-share-counter\">";
		$buttons_content .= '<aside data-counter-total-share>...</aside>';
		$buttons_content .= '<aside>SHARES</aside>';
		$buttons_content .= '<aside class="slash">|</aside>';
		$buttons_content .= '</div>';
		$buttons_content .= self::_change_button_theme_total_counter( $services->facebook, $prefix );
		$buttons_content .= self::_change_button_theme_total_counter( $services->twitter, $prefix );
		$buttons_content .= self::_change_button_theme_total_counter( $services->google_plus, $prefix );
		$buttons_content .= self::_change_button_theme_total_counter( $services->whatsapp, $prefix );
		$buttons_content .= self::_change_button_theme_total_counter( $services->linkedin, $prefix );
		$buttons_content .= self::_change_button_theme_total_counter( $services->pinterest, $prefix );
		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * Create HTML dinamic from button total share counter
	 * 
	 * @since 1.0
	 * @param Array $reference
	 * @param String $prefix
	 * @return HTML
	 *
	 */
	private static function _change_button_theme_total_counter( $reference = array(), $prefix )
	{
		$element  = strtolower( $reference->name );
		$content  = "<div class=\"{$prefix}-total-share\">";
		$content .= "<div class=\"{$prefix}-total-share-btn {$element}\">";
		$content .= "<a data-attr-url=\"{$reference->link}\" {$reference->popup} title=\"{$reference->title}\">";
		$content .= "<i class=\"{$prefix}-{$reference->img}\"></i>";
		$content .= ( $element == 'facebook' ) ? "<span>{$element}</span>" : '';
		$content .= '</a>';
		$content .= '</div>';
		$content .= '</div>';

		return $content;
	}

	/**
	 * Generate icon sharing for WhatsApp shortcode
	 * 
	 * @since 1.0
	 * @param Array $atts
	 * @return Void
	 */
	public static function whatsapp( $atts = array() )
	{
		$shortcode = shortcode_atts(
			array( 'class' => '' ),
			$atts,
			'JMSSBWHATSAPP'
		);

		$elements  = parent::_get_elements();
		$prefix    = Settings::PLUGIN_PREFIX;
		$class     = Utils_Helper::esc_html( $shortcode['class'] );
		$content   = "<div class=\"{$prefix}-whatsapp-unique {$class}\">";
		$content  .= "<a href=\"{$elements->whatsapp->link}\" title=\"{$elements->whatsapp->title}\">";
		$content  .= '<i class="icon-whatsapp"></i>';
		$content  .= '</a>';
		$content  .= '</div>';

		return $content;
	}

	/**
	 * Create custom class from icons
	 * 
	 * @since 1.0
	 * @param Array $atts
	 * @return Array
	 */
	public static function jm_ssb( $atts = array() )
	{
		$class_ul   = ( isset( $atts[0] ) ) ? $atts[0] : '';
		$class_li   = ( isset( $atts[1] ) ) ? $atts[1] : '';
		$class_link = ( isset( $atts[2] ) ) ? $atts[2] : '';
		$class_icon = ( isset( $atts[3] ) ) ? $atts[3] : '';
		$attrs      = array(
			'class_ul'   => $class_ul,
			'class_li'   => $class_li,
			'class_link' => $class_link,
			'class_icon' => $class_icon,
		);

		return self::links( $attrs );
	}

	/**
	 * Change size from icons
	 * 
	 * @since 1.0
	 * @param Null
	 * @return String HTML
	 */
	public static function icons_style()
	{
		$model    = new Settings();
		$size     = $model->icons_size;
		$prefix   = Settings::PLUGIN_PREFIX;
		$sizeCalc = $size + 4;
		$style    = "<style type=\"text/css\" media=\"screen\">\n";
		$style   .= ".{$prefix}-shared a .{$prefix}-icon{ width: {$size}px; height: {$size}px; background-size: cover; font-size: {$size}px; }\n";
		$style   .= ".{$prefix}-shared a .{$prefix}-icon-tumblr{ position: relative; top: 1px; }\n";
		$style   .= ".{$prefix}-shared a .{$prefix}-icon-tumblr:before{ font-size: {$sizeCalc}px; }\n";
		$style   .= ".{$prefix}-shared a .{$prefix}-icon-email:before{ font-size: {$sizeCalc}px; }\n";
		$style   .= "</style>\n";

		if ( ( $size != 32 && $size ) && 'off' !== $model->disable_css )
			echo $style;
	}

	/**
	 * Set social name for counter shares
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private static function _elements_active()
	{
		$social_name = array(
			'Facebook',
			'Twitter',
			'Pinterest',
			'Linkedin',
			'Google',
		);

		return $social_name;
	}

	/**
	 * Adds attribute class counters social
	 * 
	 * @since 1.0
	 * @param String $social_name
	 * @return String
	 */
	private static function _add_counter( $element )
	{
		$content = '';

		if ( in_array( $element, self::_elements_active() ) )
			$content = '<span data-counter-' . strtolower( $element ) . ' class="' . Settings::PLUGIN_PREFIX . '-counter">...</span>';

		return $content;
	}

	/**
	 * Verfy and return links from icons
	 * 
	 * @since 1.0
	 * @param String $social_name
	 * @param String $social_link
	 * @return String
	 */
	private static function _add_attr_link( $element, $element_link )
	{
		$attr_link = "data-attr-url=\"{$element_link}\" ";

		if ( $element === 'Whatsapp' || $element === 'Sms' )
			$attr_link = "href=\"{$element_link}\" ";

		return $attr_link;
	}

	/**
	 * Verfy and return first buttons content
	 * 
	 * @since 1.0
	 * @param String $permalink
	 * @param String $class_ul
	 * @param String $class_option
	 * @return String
	 */
	private static function _start_buttons_content( $permalink, $class_ul = '', $class_option = '' )
	{
		$nonce    = wp_create_nonce( Ajax_Controller::AJAX_VERIFY_NONCE_COUNTER );
		$post_id  = Utils_Helper::get_id();
		$prefix   = Settings::PLUGIN_PREFIX;
		$content  = "<div data-element-{$prefix} data-attr-reference=\"{$post_id}\" data-attr-nonce=\"{$nonce}\"";
		$content .= " data-element-url=\"{$permalink}\" class=\"{$prefix}-social {$class_ul} {$class_option}\">";

		return $content;
	}
}
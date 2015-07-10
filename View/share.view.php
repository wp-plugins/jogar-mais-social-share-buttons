<?php
/**
 *
 * @package Jogar Mais - Social Share Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 */

namespace JM\Share_Buttons;

class Share_View extends Core
{
	/**
	 * @since 1.0
	 * @package Generate all icons sharing
	 * @return String HTML the icons sharing
	 *
	 */
	public static function jm_ssb_links( $atts = array() )
	{
		$service = parent::_jm_ssb_services();
		$options = parent::$option_controller->jm_ssb_check_options();

		if ( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_desktop'] )
			return self::jm_ssb_buttons_ftg();

		extract(
			shortcode_atts(
				array(
					'class_ul'   => '',
					'class_li'   => '',
					'class_link' => '',
					'class_icon' => '',
				),
				$atts, 'jmSSB'
			)
		);

		$buttons_content = self::_jm_ssb_start_buttons_content( parent::_jm_ssb_get_permalink(), esc_html( $class_ul ), esc_html( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_class'] ) );

		foreach ( $service as $key => $social ) :

			if ( ! in_array( $social->name, (array) $options ) )
				continue;

			$add_link   = self::_jm_ssb_add_link( $social->name, $social->link );
			$class_link = ( $class_link !== '' ) ? 'class=' . $class_link : '';

			$buttons_content .= '<div class="' . Init::PLUGIN_PREFIX . '-shared ' . $social->class . ' ' . esc_html( $class_li ) . '">';
			$buttons_content .= '<a ' . $add_link . $social->popup . esc_html( $class_link ) . ' title="' . $social->title . '">';
			$buttons_content .= '<span class="' . Init::PLUGIN_PREFIX . '-icon ' . Init::PLUGIN_PREFIX . '-' . $social->img . ' ' . esc_html( $class_icon ) . '"></span>';
			$buttons_content .= '</a>';
			$buttons_content .= self::_jm_ssb_add_counter( $social->name );
			$buttons_content .= '</div>';

		endforeach;

		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * @since 1.0
	 * @package Display icons Facebook, Google Plus and Twitter
	 * @return String HTML
	 *
	 */
	public static function jm_ssb_buttons_ftg()
	{
		$social_reference = parent::_jm_ssb_services();

		$buttons_content  = '<div class="' . Init::PLUGIN_PREFIX . '-social-ftg" data-' . Init::PLUGIN_PREFIX . ' data-element-url="' . parent::_jm_ssb_get_permalink() . '">';
		$buttons_content .= self::_jm_ssb_create_html( $social_reference->facebook );
		$buttons_content .= self::_jm_ssb_create_html( $social_reference->google_plus );
		$buttons_content .= self::_jm_ssb_create_html( $social_reference->twitter );
		$buttons_content .= self::_jm_ssb_create_html( $social_reference->linkedin );
		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * @since 1.0
	 * @package Create HTML from icons dinamic
	 * @return String HTML
	 *
	 */
	private static function _jm_ssb_create_html( $reference_name = array() )
	{
		$social_name = parent::_jm_ssb_strtolower( $reference_name->name );

		$create_buttons_content  = '<div class="' . $social_name . '-share">';		
		$create_buttons_content .= '<a data-attr-url="' . $reference_name->link . '" ' . $reference_name->popup . ' title="' . $reference_name->title . '">';
		$create_buttons_content .= '<span class="icons-align ' . $reference_name->img . '"></span>';
		$create_buttons_content .= 'Compartilhar';
		$create_buttons_content .= '</a>';
		$create_buttons_content .= '<span class="count" data-counter-' . $social_name . '>...</span>';
		$create_buttons_content .= '</div>';

		return $create_buttons_content;

	}

	/**
	 * @since 1.0
	 * @package Generate icon sharing for WhatsApp shortcode
	 * @return Void
	 */
	public static function jm_ssb_whatsapp( $atts = array() )
	{
		$plugins_url      = parent::_jm_ssb_plugin_url( 'icons/' );
		$social_reference = parent::_jm_ssb_services();

		extract(
			shortcode_atts(
				array(
					'class' => '',
				),
				$atts, 'JMSSBWHATSAPP'
			)
		);

		printf( '<div class="%s-whatsapp-unique %s">
					<a href="%s" title="%s">
						<span class="icon-whatsapp"></span>
					</a>
				</div>',
				Init::PLUGIN_PREFIX,
				esc_html( $class ),
				$social_reference->whatsapp->link,
				$social_reference->whatsapp->title
		);
	}

	/**
	 * @since 1.0
	 * @package Create method from icons
	 * @return String/Array
	 */
	public static function jm_ssb( $atts = '' )
	{
		$attrs = array( 'class_ul' => $atts );

		if ( is_array( $atts ) ) :
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
		endif;

		return self::jm_ssb_links( $attrs );
	}

	/**
	 * @since 1.0
	 * @package Change size from icons
	 * @return String
	 */
	public static function jm_ssb_icons_style()
	{
		$options = parent::$option_controller->jm_ssb_check_options();
		$option  = $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_icons_style_size'];

		if ( ( $option != 32 && $option != '' ) && $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'] != 'off' )
			printf( '<style>.' . Init::PLUGIN_PREFIX . '-shared a .' . Init::PLUGIN_PREFIX . '-icon{width: %spx; height: %spx; background-size: cover;}</style>' . "\n", $option, $option );
	}

	/**
	 * @since 1.0
	 * @package Set social name for counter shares
	 * @return Array
	 */
	private static function _jm_ssb_social_name_active()
	{
		$social_name = array(
			'Facebook',
			'Twitter',
			'Pinterest',
			'Linkedin',
		);

		return $social_name;
	}

	/**
	 * @since 1.0
	 * @package Adds attribute counters social
	 * @return String
	 */
	private static function _jm_ssb_add_counter( $social_name )
	{
		$add_count = '';

		if ( in_array( $social_name, self::_jm_ssb_social_name_active() ) )
			$add_count = '<span data-counter-' . parent::_jm_ssb_strtolower( $social_name ) . ' class="' . Init::PLUGIN_PREFIX . '-counter">...</span>';

		return $add_count;
	}

	/**
	 * @since 1.0
	 * @package Verfy and return links from icons
	 * @return String
	 */
	private static function _jm_ssb_add_link( $social_name, $social_link )
	{
		$add_link = 'data-attr-url="' . $social_link . '" ';

		if ( $social_name === 'Whatsapp' || $social_name === 'Sms' )
			$add_link = 'href="' . $social_link . '" ';

		return $add_link;
	}

	/**
	 * @since 1.0
	 * @package Verfy and return first buttons content
	 * @return String
	 */
	private static function _jm_ssb_start_buttons_content( $permalink, $class_ul = '', $class_option = '' )
	{
		if ( ! empty( $class_ul ) )
			$class_ul = " {$class_ul}";

		if ( ! empty( $class_option ) )
			$class_option = " {$class_option}";

		$start_buttons_content = "<div data-" . Init::PLUGIN_PREFIX . " data-element-url=\"{$permalink}\" class=\"" . Init::PLUGIN_PREFIX . "-social{$class_ul}{$class_option}\">";

		return $start_buttons_content;
	}
}
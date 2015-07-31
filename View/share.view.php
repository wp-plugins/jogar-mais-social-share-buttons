<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 1.0.2
 */

namespace JM\Share_Buttons;

class Share_View extends Core
{
	/**
	 * @since 1.0
	 * @param Generate all icons sharing
	 * @return string/HTML
	 *
	 */
	public static function links( $atts = array() )
	{
		$model    = new Settings();
		$options  = $model->get_options();
		$services = parent::_get_services();

		if ( $model->desktop && ! wp_is_mobile() )
			return self::_theme_two();

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

		$buttons_content = self::_start_buttons_content( Utils_Helper::get_permalink(), Utils_Helper::esc_html( $class_ul ), $model->class );

		foreach ( $services as $key => $social ) :

			if ( ! in_array( $social->name, (array) $options ) )
				continue;

			$attr_link  = self::_add_link( $social->name, $social->link );

			$buttons_content .= '<div class="' . Settings::PLUGIN_PREFIX . '-shared ' . $social->class . ' ' . Utils_Helper::esc_html( $class_li ) . '">';
			$buttons_content .= '<a ' . $attr_link . $social->popup . 'class="' . Utils_Helper::esc_html( $class_link ) . '" title="' . $social->title . '">';
			$buttons_content .= '<span class="' . Settings::PLUGIN_PREFIX . '-icon ' . Settings::PLUGIN_PREFIX . '-' . $social->img . ' ' . Utils_Helper::esc_html( $class_icon ) . '"></span>';
			$buttons_content .= '</a>';
			$buttons_content .= self::_add_counter( $social->name );
			$buttons_content .= '</div>';

		endforeach;

		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * @since 1.0
	 * @param Display icons Facebook, Google Plus and Twitter
	 * @return String/HTML
	 *
	 */
	private static function _theme_two()
	{
		$services = parent::_get_services();

		$buttons_content  = '<div class="' . Settings::PLUGIN_PREFIX . '-container-theme-two" data-' . Settings::PLUGIN_PREFIX . ' data-element-url="' . Utils_Helper::get_permalink() . '">';
		$buttons_content .= self::_change_button( $services->facebook );
		$buttons_content .= self::_change_button( $services->google_plus );
		$buttons_content .= self::_change_button( $services->twitter );
		$buttons_content .= self::_change_button( $services->linkedin );
		$buttons_content .= '</div>';

		return $buttons_content;
	}

	/**
	 * @since 1.0
	 * @param Create HTML from icons dinamic
	 * @return String/HTML
	 *
	 */
	private static function _change_button( $reference_name = array() )
	{
		$social_name = Utils_Helper::strtolower( $reference_name->name );

		$create_buttons_content  = '<div class="jm-ssb-theme-two ' . $social_name . '-share">';		
		$create_buttons_content .= '<a data-attr-url="' . $reference_name->link . '" ' . $reference_name->popup . ' title="' . $reference_name->title . '">';
		$create_buttons_content .= '<span class="icons-align ' . $reference_name->img . '"></span>';
		$create_buttons_content .= ( $social_name == 'twitter' ) ? 'tweetar' : 'Compartilhar';
		$create_buttons_content .= '</a>';
		$create_buttons_content .= '<span class="count" data-counter-' . $social_name . '>...</span>';
		$create_buttons_content .= '</div>';

		return $create_buttons_content;

	}

	/**
	 * @since 1.0
	 * @param Generate icon sharing for WhatsApp shortcode
	 * @return Void
	 */
	public static function whatsapp( $atts = array() )
	{
		$plugins_url = Utils_Helper::plugin_url( 'icons/' );
		$services    = parent::_get_services();

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
				Settings::PLUGIN_PREFIX,
				Utils_Helper::esc_html( $class ),
				$services->whatsapp->link,
				$services->whatsapp->title
		);
	}

	/**
	 * @since 1.0
	 * @param Create method from icons
	 * @return Mixed String/Array
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

		return self::links( $attrs );
	}

	/**
	 * @since 1.0
	 * @param Change size from icons
	 * @return String
	 */
	public static function icons_style()
	{
		$model      = new Settings();
		$icons_size = $model->icons_size;

		if ( ( $icons_size != 32 && $icons_size != '' ) && $model->remove_style != 'off' )
			printf( '<style>.' . Settings::PLUGIN_PREFIX . '-shared a .' . Settings::PLUGIN_PREFIX . '-icon{width: %spx; height: %spx; background-size: cover;}</style>' . "\n", $icons_size, $icons_size );
	}

	/**
	 * @since 1.0
	 * @param Set social name for counter shares
	 * @return Array
	 */
	private static function _social_name_active()
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
	 * @param Adds attribute counters social
	 * @return String
	 */
	private static function _add_counter( $social_name )
	{
		$count_content = '';

		if ( in_array( $social_name, self::_social_name_active() ) )
			$count_content = '<span data-counter-' . Utils_Helper::strtolower( $social_name ) . ' class="' . Settings::PLUGIN_PREFIX . '-counter">...</span>';

		return $count_content;
	}

	/**
	 * @since 1.0
	 * @param Verfy and return links from icons
	 * @return String
	 */
	private static function _add_link( $social_name, $social_link )
	{
		$attr_link = "data-attr-url=\"{$social_link}\" ";

		if ( $social_name === 'Whatsapp' || $social_name === 'Sms' )
			$attr_link = "href=\"{$social_link}\" ";

		return $attr_link;
	}

	/**
	 * @since 1.0
	 * @param Verfy and return first buttons content
	 * @return String
	 */
	private static function _start_buttons_content( $permalink, $class_ul = '', $class_option = '' )
	{
		if ( '' !== $class_ul )
			$class_ul = " {$class_ul}";

		if ( '' !== $class_option )
			$class_option = " {$class_option}";

		$start_buttons_content = "<div data-" . Settings::PLUGIN_PREFIX . " data-element-url=\"{$permalink}\" class=\"" . Settings::PLUGIN_PREFIX . "-social{$class_ul}{$class_option}\">";

		return $start_buttons_content;
	}
}
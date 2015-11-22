<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage Social Icons Display
 * @version 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Shares_View extends Core
{
	private static $count_elements = 0;

	/**
	 * Generate all icons sharing
	 *
	 * @since 1.0
	 * @param Array $atts
	 * @return HTML
	 *
	 */
	public static function ssb_share( $atts = array() )
	{
		$atts =	shortcode_atts(
			array(
				'class_first'    => '',
				'class_second'   => '',
				'class_link'     => '',
				'class_icon'     => '',
				'layout'         => '',
				'remove_inside'  => 0,
				'remove_counter' => 0,
			),
			$atts, 'SSB_SHARE'
		);

		$atts = array_map( array( 'JM\Share_Buttons\Utils_Helper', 'esc_class' ), $atts );
		$args = array(
			'class_first'  => $atts['class_first'],
			'class_second' => $atts['class_second'],
			'class_link'   => $atts['class_link'],
			'class_icon'   => $atts['class_icon'],
			'layout'       => $atts['layout'],
			'elements'     => array(
				'remove_inside'  => $atts['remove_inside'],
				'remove_counter' => $atts['remove_counter']
			),
		);

		return self::get_buttons( $args );
	}

	/**
	 * Get buttons
	 *
	 * @since 2.0
	 * @param array $args
	 * @return String HTML
	 *
	 */
	public static function get_buttons( $args = array() )
	{
		$model    = new Setting();
		$elements = Core::social_media_objects();
		$layout   = ( $args['layout'] ? $args['layout'] : $model->layout );
		$buttons  = static::_get_buttons_start( $args['class_first'], $model, $layout );

		foreach ( $elements as $key => $social ) :
			if ( ! in_array( $social->element, (array) $model->social_media ) )
				continue;

			static::$count_elements++;

			$buttons .= static::_set_buttons_args( $social, $args, $layout );
		endforeach;

		$buttons .= static::_end_buttons_html();

		return $buttons;
	}

	/**
	 * Get buttons start
	 *
	 * @since 2.0
	 * @param string $class_first
	 * @param object $model
	 * @param string $layout
	 * @return String HTML
	 *
	 */
	private static function _get_buttons_start( $class_first, $model, $layout )
	{
		$prefix  = Setting::PREFIX;
		$buttons = static::_start_buttons_html(
			(object) array(
				'class_first'    => $class_first,
				'custom_class'   => $model->class,
				'layout'         => $layout ? $layout : 'default',
				'prefix'         => $prefix,
				'position_fixed' => ( $model->position_fixed ) ? "{$prefix}-{$model->position_fixed}" : ''
			)
		);

		return $buttons;
	}

	/**
	 * Set buttons args
	 *
	 * @since 2.0
	 * @param object $social
	 * @param array $args
	 * @param string $layout
	 * @return String HTML
	 *
	 */
	private static function _set_buttons_args( $social, $args, $layout )
	{
		$buttons = static::_set_buttons(
			array(
				'social'       => $social,
				'class_second' => $args['class_second'],
				'class_icon'   => $args['class_icon'],
				'class_link'   => $args['class_link'],
				'layout'       => $layout,
				'elements'     => $args['elements'],
			)
		);

		return $buttons;
	}

	/**
	 * Verfy and return first buttons content
	 *
	 * @since 1.0
	 * @param Object $arga
	 * @return String HTML
	 */
	private static function _start_buttons_html( \stdClass $args )
	{
		$nonce     = wp_create_nonce( Ajax_Controller::AJAX_VERIFY_NONCE_COUNTER );
		$permalink = Utils_Helper::get_permalink();
		$post_id   = Utils_Helper::get_id();
		$content   = "<div data-element-url=\"{$permalink}\" data-component=\"{$args->prefix}\"";
		$content  .= " data-attr-reference=\"{$post_id}\" class=\"{$args->prefix}";
		$content  .= " {$args->prefix}-{$args->layout} {$args->position_fixed}";
		$content  .= " {$args->class_first} {$args->custom_class}\" data-attr-nonce=\"{$nonce}\">\n";

		if ( ! empty( $args->position_fixed ) || 'square-plus' == $args->layout )
			$content .= static::_total_count( $args->prefix, $args->layout, $args->position_fixed );

		return $content;
	}

	/**
	 * Set and verify buttons
	 *
	 * @since 1.0
	 * @param Object/Array $args
	 * @return String HTML
	 *
	 */
	private static function _set_buttons( $args = array() )
	{
		$prefix     = Setting::PREFIX;
		$share_full = '';

		if ( static::$count_elements == 1 && $args['layout'] == 'square-plus' )
			$share_full = "{$prefix}-full";

		$buttons = self::_button_html(
			(object) array(
				'reference'    => $args['social'],
				'prefix'       => $prefix,
				'class_second' => $args['class_second'],
				'class_icon'   => $args['class_icon'],
				'class_link'   => $args['class_link'],
				'layout'       => $args['layout'],
				'elements'     => $args['elements'],
				'share_full'   => $share_full,
			)
		);

		return $buttons;
	}

	/**
	 * Create HTML dinamic from icons
	 *
	 * @since 1.0
	 * @param Array/Object $reference
	 * @return String HTML
	 *
	 */
	private static function _button_html( $args = OBJECT )
	{
		$link_type  = self::_link_type( $args->reference->popup, $args->reference->link );
		$class_link = ( $args->layout == 'square-plus' ) ? "{$args->prefix}-link" : $args->reference->class_link;
		$content    = "<div class=\"{$args->reference->class_item} {$args->reference->class} {$args->share_full} {$args->class_second}\">";
		$content   .= "<a {$link_type} {$args->reference->popup} class=\"{$class_link}";
		$content   .= " {$args->class_link}\" title=\"{$args->reference->title}\">";
		$content   .= "<i class=\"{$args->reference->class_icon}-{$args->layout} {$args->class_icon}\"></i>";
		$content   .= self::_inside(
			$args->reference,
			$args->elements['remove_inside'],
			$args->layout
		);
		$content   .= '</a>';
		$content   .= self::_add_count(
			$args->reference->has_counter,
			$args->reference->element,
			$args->prefix,
			$args->elements['remove_counter'],
			$args->layout
		);
		$content   .= '</div>';

		return $content;
	}

	/**
	 * Adds attribute class counters social
	 *
	 * @since 1.0
	 * @param Bool $has_counter
	 * @param String $element
	 * @param String $prefix
	 * @return String HTML
	 */
	private static function _add_count( $has_counter, $element, $prefix, $set_count, $layout )
	{
		$remove_count   = Utils_Helper::option( 'remove_count', false, 'intval' );
		$counter        = ( $set_count ? $set_count : $remove_count );
		$position_fixed = Utils_Helper::option( 'position_fixed' );
		$use_counter    = ( $set_count ? $set_count : $position_fixed );

		if ( ( ! $has_counter || $counter ) || $use_counter )
			return;

		if ( $layout == 'square-plus' || $position_fixed )
			return;

		return "<span data-element=\"{$element}\" class=\"{$prefix}-count\">...</span>";
	}

	/**
	 * Adds total counter
	 *
	 * @since 1.0
	 * @param String $prefix
	 * @param String $layout
	 * @return String HTML
	 */
	private static function _total_count( $prefix, $layout, $layout_fixed )
	{
		if ( Utils_Helper::option( 'remove_count', false, 'intval' ) )
			return;

		$items    = static::_items_total_counter( $prefix, $layout, $layout_fixed );
		$content  = "<div class=\"{$prefix}-item {$items->class}\">";
		$content .= $items->before;
		$content .= "<span {$items->class_count} data-element=\"total-share\">...</span>";
		$content .= $items->after;
		$content .= $items->after_square;
		$content .= '</div>';

		return $content;
	}

	/**
	 * Adds items class total counter
	 *
	 * @since 1.0
	 * @param empty
	 * @return Object
	 */
	private static function _items_total_counter( $prefix, $layout, $layout_fixed )
	{
		$square_plus   = ( $layout == 'square-plus' ) ? true : false;
		$square_plus   = ( $layout_fixed ) ? false : $square_plus;
		$class         = ( $square_plus ) ? "{$prefix}-counter" : "{$prefix}-total-share" ;
		$class_count   = ( $square_plus ) ? "class=\"{$prefix}-counter\"" : '';
		$before        = ( $square_plus ) ? '' : "<div class=\"{$prefix}-button\">";
		$after         = ( $square_plus ) ? '' : '</div>';
		$square_count  = "<span class=\"{$prefix}-text\">Shares</span>";
		$square_count .= "<div class=\"{$prefix}-slash\"></div>";
		$after_square  = ( $square_plus ) ? $square_count : '';
		$items         = (object) array(
			'class'        => $class,
			'class_count'  => $class_count,
			'before'       => $before,
			'after'        => $after,
			'after_square' => $after_square,
		);

		return $items;
	}

	/**
	 * Verfy and return first buttons content
	 *
	 * @since 1.0
	 * @param Null
	 * @return String HTML
	 */
	private static function _end_buttons_html()
	{
		$content = '</div>';

		return $content;
	}

	/**
	 * Verifies is set sharing name
	 *
	 * @since 1.0
	 * @param String $title
	 * @return String HTML
	 *
	 */
	private static function _inside( $title, $set_inside, $layout )
	{
		$remove_inside = Utils_Helper::option( 'remove_inside', false, 'intval' );
		$position_left = Utils_Helper::option( 'position_fixed', false, 'esc_html' );
		$inside        = ( $set_inside ? $set_inside : $remove_inside );
		$title         = ( $layout == 'square-plus' ) ? $title->name : $title->inside;
		$content       = '';

		if ( ( static::$count_elements > 1 && $layout == 'square-plus' ) || $position_left )
			return $content;

		if ( ! $inside )
			$content = "<span>{$title}</span>";

		return $content;
	}

	/**
	 * Verfy type and return links from icons
	 *
	 * @since 1.0
	 * @param String $popup
	 * @param String $element_link
	 * @return String
	 */
	private static function _link_type( $popup, $element_link )
	{
		$attr_link = "data-attr-url=\"{$element_link}\"";

		if ( '' === $popup || 'on' === Utils_Helper::option( 'disable_js' ) )
			$attr_link = "href=\"{$element_link}\" target=\"_blank\"";

		return $attr_link;
	}

	/**
	 * Create custom class from icons
	 *
	 * @since 1.0
	 * @param Array $args
	 * @return HTML
	 */
	public static function buttons_share( $atts = array() )
	{
		$atts = array_map( array( 'JM\Share_Buttons\Utils_Helper', 'esc_class' ), $atts );
		$args = array(
			'class_first'  => Utils_Helper::isset_set( $atts, 'class_first' ),
			'class_second' => Utils_Helper::isset_set( $atts, 'class_second' ),
			'class_link'   => Utils_Helper::isset_set( $atts, 'class_link' ),
			'class_icon'   => Utils_Helper::isset_set( $atts, 'class_icon' ),
			'layout'       => Utils_Helper::isset_set( $atts, 'layout' ),
			'elements'     => array(
				'remove_inside'  => Utils_Helper::isset_set( $atts, 'remove_inside' ),
				'remove_counter' => Utils_Helper::isset_set( $atts, 'remove_counter' ),
			),
		);

		return self::get_buttons( $args );
	}
}
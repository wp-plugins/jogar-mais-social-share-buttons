<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 2.0
 */

namespace JM\Share_Buttons;

if ( ! function_exists( 'add_action' ) )
	exit(0);

class Settings_Faq_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq()
	{
		$prefix = Setting::PREFIX;
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo "{$prefix}-title"; ?>">
				<?php _e( 'Use options', Init::PLUGIN_SLUG ); ?>
			</span>
			<div class="<?php echo "{$prefix}-wrap-faq"; ?>">
				<blockquote>
					<strong><?php _e( 'Via shortcode', Init::PLUGIN_SLUG ); ?>: </strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="<?php echo "{$prefix}"; ?>-code-align"><span class="gn">[SSB_SHARE class_first="" class_second="" class_link="" class_icon="" layout="default" remove_inside="0" remove_counter="0"]</span></div>
						</div>
					</div>
					<strong><?php _e( 'Via', Init::PLUGIN_SLUG ); ?> PHP</strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="<?php echo "{$prefix}"; ?>-code-align"><span class="k">echo</span> do_shortcode( <span class="s1">'[SSB_SHARE class_first="" class_second="" class_link="" class_icon="" layout="default" remove_inside="0" remove_counter="0"]'</span> );</div>
						</div>
					</div>
					<p class="description <?php echo $prefix; ?>-faq"><?php _e( 'Returns all the buttons and the use of classes is optional', Init::PLUGIN_SLUG  ); ?></p>
				</blockquote>
				<blockquote>
					<strong><?php _e( 'Via method PHP:', Init::PLUGIN_SLUG ); ?></strong>
						<div class="<?php echo "{$prefix}"; ?>-pre">
							<div class="<?php echo "{$prefix}"; ?>-code">
								<div class="<?php echo "{$prefix}"; ?>-code-align">
									$args <span class="nc">=</span> <span class="k">array</span>(
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_first'</span><span class="nc">&nbsp;&nbsp;=></span> <span class="s1">''</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_second'</span><span class="nc">&nbsp;=></span> <span class="s1">''</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_link'</span><span class="nc">&nbsp;&nbsp;&nbsp;=></span> <span class="s1">''</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_icon'</span><span class="nc">&nbsp;&nbsp;&nbsp;=></span> <span class="s1">''</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'layout'</span><span class="nc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=></span> <span class="s1">'default'</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'elements'</span><span class="nc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=></span> <span class="k">array</span>(
										<span class="s1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'remove_inside'</span><span class="nc">&nbsp;&nbsp;=></span> <span class="mi">false</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'remove_counter'</span><span class="nc">&nbsp;=></span> <span class="mi">false</span>,
										&nbsp;&nbsp;&nbsp;),
									);
									<span class="sp start-method">
										<span class="nc">if</span> ( <span class="k">class_exists</span>( <span class="s1">'JM\Share_Buttons\Shares_View'</span> ) ) :
										<span class="alr">
											<span class="k">echo</span> <span class="mi">JM\Share_Buttons\</span><span class="k">Shares_View</span><span class="nc">::</span>buttons_share( $args );
										</span>
										<span class="end-method">
											<span class="nc">endif</span>;
										</span>
									</span>
								</div>
							</div>
						</div>
				</blockquote>
				<div class="<?php echo $prefix; ?>-faq-footer">
					<p class="description <?php echo $prefix; ?>-faq"><?php _e( 'Returns according to the parameters sharing buttons', Init::PLUGIN_SLUG ); ?></p>
					<div class="<?php echo "{$prefix}"; ?>-method-args">
						<dt><strong>$args</strong> &nbsp; (<i>Array</i>)  (<i><?php _e( 'optional', Init::PLUGIN_SLUG ); ?></i>)<dt>
						<dt> <?php _e( 'Layout options', Init::PLUGIN_SLUG ); ?>: <i>default, buttons, rounded, square</i></dt>
					</div>
				</dt>
			</div>
		</div>
	<?php
	}
}
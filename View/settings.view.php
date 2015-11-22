<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 2.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Settings_View extends Shares_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_settings_page()
	{
		$model               = new Setting();
		$prefix              = Setting::PREFIX;
		$prefix_underscore   = Setting::PREFIX_UNDERSCORE;
		$option_name         = "{$prefix_underscore}_settings";
		$option_social_media = "{$prefix_underscore}_social_media";
	?>
		<div class="wrap" data-component="<?php echo $prefix; ?>">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo "{$prefix}-title"; ?>"><?php _e( 'Settings', Init::PLUGIN_SLUG ); ?></span>
			<div class="<?php echo "{$prefix}-wrap"; ?>">
				<form action="options.php" method="post">
					<table class="form-table <?php echo "{$prefix}-table"; ?>" data-table="configurations">
						<tbody>
							<tr class="<?php echo $prefix; ?>-items-available">
								<th scope="row">
									<label><?php _e( 'Places available', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
					                <input id="<?php echo $prefix; ?>-single" type="checkbox"
					                	   value="on" name="<?php echo "{$option_name}[single]"; ?>"
					                	   <?php checked( 'on', $model->single ); ?>>
					                <label for="<?php echo $prefix; ?>-single">
					                	<span><?php _e( 'Single', Init::PLUGIN_SLUG ); ?></span>
					                </label>
					            </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-pages" type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[pages]"; ?>"
				                		   <?php checked( 'on', $model->pages ); ?>>
					                <label for="<?php echo $prefix; ?>-pages">
					                	<span><?php _e( 'Pages', Init::PLUGIN_SLUG ); ?></span>
					                </label>
					            </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-home" type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[home]"; ?>"
				                		   <?php checked( 'on', $model->home ); ?>>
					                <label for="<?php echo $prefix; ?>-home">
					                	<span><?php _e( 'Page home', Init::PLUGIN_SLUG ); ?></span>
					                </label>
				                </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-before" type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[before]"; ?>"
				                	       <?php checked( 'on', $model->before ); ?>>
					                <label for="<?php echo $prefix; ?>-before">
					                	<span><?php _e( 'Before content', Init::PLUGIN_SLUG ); ?></span>
					                </label>
				                </td>
								<td>
				                	<input id="<?php echo $prefix; ?>-after" type="checkbox"
				                	       value="on" name="<?php echo "{$option_name}[after]"; ?>"
				                	       <?php checked( 'on', $model->after ); ?>>
					                <label for="<?php echo $prefix; ?>-after">
					                	<span><?php _e( 'After content', Init::PLUGIN_SLUG ); ?></span>
					                </label>
				                </td>
							</tr>
							<tr class="<?php echo $prefix; ?>-social-networks">
								<th scope="row">
									<label for="social-media"><?php _e( 'Social networks available', Init::PLUGIN_SLUG ); ?></label>
								</th>
									<?php
									foreach ( Core::social_media_objects() as $key => $social ) :
										$content  = '<td>';
										$content .= sprintf( "<input id=\"%s\" type=\"checkbox\" name=\"{$option_social_media}[%s]\" value=\"%s\" %s>",
											$social->class,
											$social->element,
											$social->element,
											checked( $social->element, Utils_Helper::option( $social->element ), false )
										);
										$content .= sprintf( '<label for="%s" class="%s"></label>', $social->class, "{$prefix}-icon {$social->class}-icon" );
										$content .= '</td>';

										echo $content;
									endforeach;
									?>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-class">
										<?php _e( 'Custom class', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-class" class="large-text" type="text"
										   placeholder="<?php _e( 'Custom class for primary div', Init::PLUGIN_SLUG ); ?>"
									       name="<?php echo "{$option_name}[class]"; ?>"
										   value="<?php echo $model->class; ?>">
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-layout-options">
								<th scope="row">
									<?php _e( 'Layout options', Init::PLUGIN_SLUG ); ?>
									<p class="description">
										<?php _e( 'All layout supports responsive', Init::PLUGIN_SLUG ); ?>
									</p>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-default" type="radio"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="default"
										   <?php checked( 'default', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-default">
										<span><?php _e( 'Default', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-buttons" type="radio"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="buttons"
										   <?php checked( 'buttons', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-buttons">
										<span><?php _e( 'Button', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-rounded" type="radio"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="rounded"
										   <?php checked( 'rounded', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-rounded">
										<span><?php _e( 'Rounded', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-square" type="radio"
										   name="<?php echo "{$option_name}[layout]"; ?>"
										   value="square"
										   <?php checked( 'square', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-square">
										<span><?php _e( 'Square', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
								<td>
									<input id="<?php echo $prefix; ?>-square-plus" type="radio"
									       name="<?php echo "{$option_name}[layout]"; ?>"
									       value="square-plus"
									       <?php checked( 'square-plus', $model->layout ); ?>>
									<label for="<?php echo $prefix; ?>-square-plus">
										<span><?php _e( 'Square plus', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-position-fixed">
								<th scope="row">
									<?php _e( 'Position fixed', Init::PLUGIN_SLUG ); ?>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-fixed-left" type="checkbox"
										   name="<?php echo "{$option_name}[position_fixed]"; ?>"
										   value="fixed-left"
										   <?php checked( 'fixed-left', $model->position_fixed ); ?>>
									<label for="<?php echo $prefix; ?>-fixed-left">
										<span><?php _e( 'Fixed left', Init::PLUGIN_SLUG ); ?></span>
									</label>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( "{$option_name}_group" );
						submit_button( __( 'Save Changes', Init::PLUGIN_SLUG ) );
					?>
				</form>
			</div>
		</div>
	<?php
	}
}
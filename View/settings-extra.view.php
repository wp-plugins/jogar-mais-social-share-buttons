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

class Settings_Extra_View
{
	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void, Display page
	 */
	public static function render_settings_extra()
	{
		$model             = new Setting();
		$prefix            = Setting::PREFIX;
		$prefix_underscore = Setting::PREFIX_UNDERSCORE;
		$extra_setting     = "{$prefix_underscore}_extra_settings";
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo "{$prefix}-title"; ?>"><?php _e( 'Extra Settings', Init::PLUGIN_SLUG ); ?></span>
			<div class="<?php echo "{$prefix}-wrap"; ?>">
				<form action="options.php" method="post">
					<table class="form-table table-extras" data-table="extras">
						<tbody>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-cache-time">
										<?php _e( 'Cache time', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-cache-time" step="1" min="1" max="60" type="number"
									       name="<?php echo "{$extra_setting}[report_cache_time]"; ?>"
										   value="<?php echo $model->report_cache_time; ?>">
									<?php _e( 'Minute', Init::PLUGIN_SLUG ); ?>(s)
									<p class="description">
										<?php _e( 'Set the time in minutes that will be cached in the Sharing report page', Init::PLUGIN_SLUG ); ?>
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-twitter-username">
										<?php _e( 'Twitter username', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-twitter-username" class="large-text" type="text"
										   placeholder="<?php _e( 'Twitter username', Init::PLUGIN_SLUG ); ?>"
									       name="<?php echo "{$extra_setting}[twitter_via]"; ?>"
										   value="<?php echo $model->twitter_username; ?>">
									<p class="description"><?php _e( 'Your twitter username', Init::PLUGIN_SLUG ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="<?php echo $prefix; ?>-tracking-analytics">
										<?php _e( 'UTM de tracking', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-tracking-analytics" class="large-text" type="text"
										   placeholder="<?php _e( 'Add UTM tracking (Analytics)', Init::PLUGIN_SLUG ); ?>"
									       name="<?php echo "{$extra_setting}[tracking]"; ?>"
										   value="<?php echo $model->tracking; ?>">
									<p class="description">
										<?php _e( 'Use the encode', Init::PLUGIN_SLUG ); ?> <code>&amp;</code>
										<?php _e( 'to add parameters to your tracking.', Init::PLUGIN_SLUG ); ?>
										(Facebook; Google Plus; Whatsapp; Pinterest; Linkedin)
									</p>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-remove-elements">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-remove-count">
										<?php _e( 'Remove counter', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-remove-count" type="checkbox" value="1"
										   name="<?php echo "{$extra_setting}[remove_count]"; ?>"
										   <?php checked( 1, $model->remove_count ); ?>>
									<label for="<?php echo $prefix; ?>-remove-count" class="<?php echo $prefix; ?>-icon"></label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-remove-elements">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-remove-inside">
										<?php _e( 'Remove button title', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-remove-inside" type="checkbox" value="1"
										   name="<?php echo "{$extra_setting}[remove_inside]"; ?>"
										   <?php checked( 1, $model->remove_inside ); ?>>
									<label for="<?php echo $prefix; ?>-remove-inside" class="<?php echo $prefix; ?>-icon"></label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-remove-elements">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-disable-css">
										<?php _e( 'Disable CSS', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-disable-css" type="checkbox" value="on"
										   name="<?php echo "{$extra_setting}[disable_css]"; ?>"
										   <?php checked( 'on', $model->disable_css ); ?>>
									<label for="<?php echo $prefix; ?>-disable-css" class="<?php echo $prefix; ?>-icon"></label>
								</td>
							</tr>
							<tr class="<?php echo $prefix; ?>-remove-elements">
								<th scope="row">
									<label for="<?php echo $prefix; ?>-disable-script">
										<?php _e( 'Disable JS', Init::PLUGIN_SLUG ); ?>
									</label>
								</th>
								<td>
									<input id="<?php echo $prefix; ?>-disable-script" type="checkbox" value="on"
										   name="<?php echo "{$extra_setting}[disable_js]"; ?>"
										   <?php checked( 'on', $model->disable_js ); ?>>
									<label for="<?php echo $prefix; ?>-disable-script" class="<?php echo $prefix; ?>-icon"></label>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( "{$extra_setting}_group" );
						submit_button( __( 'Save Changes', Init::PLUGIN_SLUG ) );
					?>
				</form>
			</div>
		</div>
	<?php
	}
}
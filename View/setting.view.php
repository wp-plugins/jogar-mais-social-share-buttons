<?php
/**
 *
 * @package Social Sharing Buttons
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.4.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Setting_View extends Share_View
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
		$model = new Settings();
		$icons = array(
			0 => 'facebook',
			1 => 'twitter',
			2 => 'google',
			3 => 'whatsapp',
			4 => 'linkedin',
			5 => 'pinterest',
			6 => 'tumblr',
			7 => 'gmail',
			8 => 'email',
			9 => 'printer',
		);
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically in posts and pages.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title"><?php _e( 'Settings', Init::PLUGIN_SLUG ); ?></span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<form action="options.php" method="post">
					<table class="form-table table-configurations" data-table-configurations>
						<tbody>
							<tr class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-placements">
								<th scope="row">
									<label><?php _e( 'Places available', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
					                <label for="single">
					                	<span><?php _e( 'Single Post', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="single" type="checkbox" value="on"
					                		   name="jm_ssb[jm_ssb_single]"
					                		   <?php checked( 'on', $model->single ); ?> />
					                </label>
					            </td>
								<td>
					                <label for="pages">
					                	<span><?php _e( 'Pages', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="pages" type="checkbox" value="on"
					                		   name="jm_ssb[jm_ssb_pages]"
					                		   <?php checked( 'on', $model->pages ); ?> />
					                </label>
					            </td>
								<td>
					                <label for="home">
					                	<span><?php _e( 'Page Home', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="home" type="checkbox" value="on"
					                		   name="jm_ssb[jm_ssb_home]"
					                		   <?php checked( 'on', $model->home ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="before">
					                	<span><?php _e( 'Before Contents', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="before" type="checkbox" value="on"
					                	       name="jm_ssb[jm_ssb_before]"
					                	       <?php checked( 'on', $model->before ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="after">
					                	<span><?php _e( 'After Contents', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="after" type="checkbox" value="on"
					                	       name="jm_ssb[jm_ssb_after]"
					                	       <?php checked( 'on', $model->after ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="jm-excerpt">
					                	<span><?php _e( 'View short content', Init::PLUGIN_SLUG ); ?></span>
					                	<input id="jm-excerpt" type="checkbox" value="on"
					                	       name="jm_ssb[jm_ssb_excerpt]"
					                	       <?php checked( 'on', $model->excerpt ); ?> />
					                </label>
				                </td>
							</tr>
							<tr class="<?php echo Settings::PLUGIN_PREFIX; ?>-icons-settings">
								<th scope="row">
									<label for="custom-class"><?php _e( 'Social networks available', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<?php

									foreach ( self::_icons_settings() as $key => $button ) :

										printf( '<label for="%s">', $button->class );
										printf( '<img src="' . Utils_Helper::plugin_url( 'icons/%s' ) . '" class="%s">', $button->icon, $button->class );
										printf( '<input id="%s" type="checkbox" name="jm_ssb[' . Settings::PLUGIN_PREFIX_UNDERSCORE . '_%s]" value="%s" %s>',
											$button->class,
											$button->name,
											$button->name,
											checked( $button->name, Utils_Helper::option( "_{$button->name}" ), false )
										);
										echo '</label>';

									endforeach;
									?>
								 <em class="description"><?php _e( 'Available options only for the main theme.', Init::PLUGIN_SLUG ); ?></em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="custom-class"><?php _e( 'Custom class', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<input id="custom-class" class="large-text" type="text"
										   placeholder="<?php _e( 'Custom class for primary div', Init::PLUGIN_SLUG ); ?>"
									       name="jm_ssb[jm_ssb_class]"
										   value="<?php echo $model->class; ?>">
								</td>
							</tr>
							<tr>
								<th scope="row"><?php _e( 'Appearance options', Init::PLUGIN_SLUG ); ?></th>
								<td class="setting-buttons-themes">
									<p>
										<label for="setting-buttons-theme-main">
											<input id="setting-buttons-theme-main" type="radio"
											       name="jm_ssb[jm_ssb_desktop]"
												   value="0"
												   <?php checked( 0, $model->desktop ); ?>>
											<?php _e( 'Main theme', Init::PLUGIN_SLUG ); ?>
										</label>
										<span  class="<?php echo Settings::PLUGIN_PREFIX; ?>-icons-default">
										<?php foreach( $icons as $key => $reference ) : ?>
											<i class="<?php echo Settings::PLUGIN_PREFIX; ?>-icon <?php echo Settings::PLUGIN_PREFIX; ?>-icon-<?php echo $reference; ?>"></i>
										<?php endforeach; ?>
										</span>
									</p>
									<p>
										<label for="setting-buttons-theme-secondary">
											<input id="setting-buttons-theme-secondary" type="radio"
											       name="jm_ssb[jm_ssb_desktop]"
												   value="1"
												   <?php checked( 1, $model->desktop ); ?>>
											<span>
												<?php _e( 'Theme', Init::PLUGIN_SLUG ); ?> 2 <em>(Facebook; Google Plus; Twitter; Linkedin; WhatsApp)</em>
											</span>
										</label>
										<span class="option-theme-secondary">
											<img src="<?php echo plugins_url( '/assets/images/theme-2.png', __DIR__ ); ?>" width="614" height="30">
										</span>
									</p>
									<p>
										<label for="setting-buttons-theme-total-counter">
											<input id="setting-buttons-theme-total-counter" type="radio"
											       name="jm_ssb[jm_ssb_desktop]"
												   value="2"
												   <?php checked( 2, $model->desktop ); ?>>
											<span>
												<?php _e( 'Theme', Init::PLUGIN_SLUG ); ?> 3 <em>(Facebook; Google Plus; Twitter; Linkedin; WhatsApp; Pinterest)</em>
											</span>
										</label>
									</p>
									<span class="option-theme-total-counter">
										<img src="<?php echo plugins_url( '/assets/images/theme-3.png', __DIR__ ); ?>" width="231" height="30">
									</span>
									<p class="description"><?php _e( 'All themes supports responsive.', Init::PLUGIN_SLUG ); ?></p>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page' );
						submit_button( __( 'Save Changes', Init::PLUGIN_SLUG ) );
					?>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Display page setting
	 *
	 * @since 1.2
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_extra_settings_page()
	{
		$model = new Settings();
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically in posts and pages.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title"><?php _e( 'Extra Settings', Init::PLUGIN_SLUG ); ?></span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<form action="options.php" method="post">
					<table class="form-table table-extras" data-table-extras>
						<tbody>
							<tr>
								<th scope="row">
									<label for="icons-size"><?php _e( 'Size of Icons', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<input id="icons-size" step="1" min="15" max="60" type="number"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_icons_style_size]"
										   value="<?php echo $model->icons_size; ?>">px
									<em class="description"><?php _e( 'Just for the main theme', Init::PLUGIN_SLUG ); ?></em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="report-cache-time"><?php _e( 'Cache time', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<input id="report-cache-time" step="1" min="1" max="60" type="number"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_report_cache_time]"
										   value="<?php echo $model->report_cache_time; ?>"> <?php _e( 'Minute', Init::PLUGIN_SLUG ); ?>(s)
									<em class="description"><?php _e( 'Set the time in minutes that will be cached in the Sharing report page', Init::PLUGIN_SLUG ); ?></em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="twitter-username"><?php _e( 'Twitter username', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<input id="twitter-username" class="large-text" type="text"
										   placeholder="<?php _e( 'Twitter username', Init::PLUGIN_SLUG ); ?>"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_twitter_via]"
										   value="<?php echo $model->twitter_username; ?>">
									<p class="description"><?php _e( 'Your twitter username', Init::PLUGIN_SLUG ); ?></p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="tracking-analytics"><?php _e( 'UTM de tracking', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<input id="tracking-analytics" class="large-text" type="text"
										   placeholder="<?php _e( 'Add UTM tracking (Analytics)', Init::PLUGIN_SLUG ); ?>"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_tracking]"
										   value="<?php echo $model->tracking; ?>">
									<p class="description">
										<?php _e( 'Use the encode', Init::PLUGIN_SLUG ); ?> <code>&amp;</code> <?php _e( 'to add parameters to your tracking.', Init::PLUGIN_SLUG ); ?> (Facebook; Google Plus; Whatsapp; Pinterest; Linkedin)
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="disable-css"><?php _e( 'Disable CSS', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<label for="disable-css">
										<input id="disable-css" type="checkbox" value="off"
										       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_remove_style]"
											   <?php checked( 'off', $model->disable_css ); ?>>
										<?php _e( 'Check to disable', Init::PLUGIN_SLUG ); ?>
									</label>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="disable-script"><?php _e( 'Disable Scripts', Init::PLUGIN_SLUG ); ?></label>
								</th>
								<td>
									<label for="disable-script">
										<input id="disable-script" type="checkbox" value="off"
										       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_remove_script]"
											   <?php checked( 'off', $model->disable_script ); ?>>
										<?php _e( 'Check to disable', Init::PLUGIN_SLUG ); ?>
									</label>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( Settings::PLUGIN_PREFIX_UNDERSCORE . '_extra_options_page' );
						submit_button( __( 'Save Changes', Init::PLUGIN_SLUG ) );
					?>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Display page setting
	 *
	 * @since 1.3
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq()
	{
		$prefix = Settings::PLUGIN_PREFIX;
	?>
		<div class="wrap">
			<h2><?php _e( 'Social Sharing Buttons', Init::PLUGIN_SLUG ); ?></h2>
			<p class="description"><?php _e( 'Add the sharing buttons automatically in posts and pages.', Init::PLUGIN_SLUG ); ?></p>
			<span class="<?php echo $prefix; ?>-settings-title">
				<?php _e( 'Use options', Init::PLUGIN_SLUG ); ?>
			</span>
			<div class="<?php echo $prefix; ?>-settings-wrap">
				<blockquote>
					<strong><?php _e( 'Via shortcode', Init::PLUGIN_SLUG ); ?>: </strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="code-align"><span class="gn">[JM_SHARE primary_button="true" class_ul="my-class" class_li="my-class" class_link="my-class" class_icon="my-class"]</span></div>
						</div>
					</div>
					<strong><?php _e( 'Via', Init::PLUGIN_SLUG ); ?> PHP</strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="code-align"><span class="k">echo</span> do_shortcode( <span class="s1">'[JM_SHARE primary_button="true" class_ul="my-class" class_li="my-class" class_link="my-class" class_icon="my-class"]'</span> );</div>
						</div>
					</div>
					<p class="description <?php echo $prefix; ?>-faq"><?php _e( 'Returns all the buttons and the use of classes is optional', Init::PLUGIN_SLUG  ); ?></p>
					<strong><?php _e( 'Via shortcode', Init::PLUGIN_SLUG ); ?>: </strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="code-align"><span class="gn">[JM_SHARE_WHATSAPP class="my-class"]</span></div>
						</div>
					</div>
					<strong><?php _e( 'Via', Init::PLUGIN_SLUG ); ?> PHP</strong>
					<div class="<?php echo $prefix; ?>-pre">
						<div class="<?php echo $prefix; ?>-code <?php echo $prefix; ?>-code-shortcode">
							<div class="code-align"><span class="k">echo</span> do_shortcode( <span class="s1">'[JM_SHARE_WHATSAPP class="my-class"]'</span> );</div>
						</div>
					</div>
					<p class="description <?php echo $prefix; ?>-faq"><?php _e( 'Returns only WhatsApp button and use the class is optional', Init::PLUGIN_SLUG ); ?></p>
				</blockquote>
				<blockquote>
					<strong><?php _e( 'Via', Init::PLUGIN_SLUG ); ?> metódo PHP: </strong>
						<div class="<?php echo $prefix; ?>-pre">
							<div class="<?php echo $prefix; ?>-code">
								<div class="code-align">
									$args <span class="nc">=</span> <span class="k">array</span>(
										<span class="s1">&nbsp;&nbsp;&nbsp;'theme'</span>      <span class="nc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;=></span> <span class="mi">&nbsp;2</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_ul'</span>   <span class="nc">&nbsp;&nbsp;=></span> <span class="s1">'my-custom-class'</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_li'</span>   <span class="nc">&nbsp;&nbsp;=></span> <span class="s1">'my-custom-class'</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_link'</span> <span class="nc">=></span> <span class="s1">'my-custom-class'</span>,
										<span class="s1">&nbsp;&nbsp;&nbsp;'class_icon'</span> <span class="nc">=></span> <span class="s1">'my-custom-class'</span>,
									);
									<span class="sp">
										<span class="nc">if</span> ( <span class="k">class_exists</span>( <span class="s1">'JM\Share_Buttons\Share_View'</span> ) )
										<span class="alr">
											<span class="k">echo</span> <span class="mi">JM\Share_Buttons\</span><span class="k">Share_View</span><span class="nc">::</span>jm_ssb( $args );
										</span>
									</span>
								</div>
							</div>
						</div>
					<p class="description <?php echo $prefix; ?>-faq"><?php _e( 'Returns according to the parameters sharing buttons', Init::PLUGIN_SLUG ); ?></p>	
					<div class="method-args">
						<dt><strong>$args</strong> &nbsp; (<i>Array</i>)  (<i><?php _e( 'optional', Init::PLUGIN_SLUG ); ?></i>)<dt>
						<dt> <?php _e( 'Options theme', Init::PLUGIN_SLUG ); ?>: <i>1, 2 ou 3</i></dt>
						<dt> Default: <i>empty</i></dt>
					</div>
				</blockquote>
			</div>
		</div>
	<?php
	}

	/**
	 * Generate data all social icons
	 *
	 * @since 1.2
	 * @param Null
	 * @return Object
	 */
	protected static function _icons_settings()
	{
		$icons_settings = array(

			'facebook' => array(
				'name'  => 'Facebook',
				'icon'  => 'facebook.svg',
				'class' => Settings::PLUGIN_PREFIX . '-facebook',
			),
			'twitter' => array(
				'name'  => 'Twitter',
				'icon'  => 'twitter.svg',
				'class' => Settings::PLUGIN_PREFIX . '-twitter',
			),
			'google_plus' => array(
				'name'  => 'Google',
				'icon'  => 'google_plus.svg',
				'class' => Settings::PLUGIN_PREFIX . '-google-plus',
			),
			'whatsapp' => array(
				'name'  => 'Whatsapp',
				'icon'  => 'whatsapp.svg',
				'class' => Settings::PLUGIN_PREFIX . '-whatsapp',
			),
			'pinterest' => array(
				'name'  => 'Pinterest',
				'icon'  => 'pinterest.png',
				'class' => Settings::PLUGIN_PREFIX . '-pinterest',
			),
			'linkedin' => array(
				'name'  => 'Linkedin',
				'icon'  => 'linkedin.svg',
				'class' => Settings::PLUGIN_PREFIX . '-linkedin',
			),
			'tumblr' => array(
				'name'  => 'Tumblr',
				'icon'  => 'tumblr.svg',
				'class' => Settings::PLUGIN_PREFIX . '-tumblr',
			),
			'gmail' => array(
				'name'  => 'Gmail',
				'icon'  => 'gmail.svg',
				'class' => Settings::PLUGIN_PREFIX . '-gmail',
			),
			'email' => array(
				'name'  => 'Email',
				'icon'  => 'email.svg',
				'class' => Settings::PLUGIN_PREFIX . '-email',
			),
			'printfriendly' => array(
				'name'  => 'PrintFriendly',
				'icon'  => 'printfriendly.svg',
				'class' => Settings::PLUGIN_PREFIX . '-print-friendly',
			),
		);

		return Utils_Helper::array_to_object( $icons_settings );
	}
}
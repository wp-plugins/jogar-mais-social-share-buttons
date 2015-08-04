<?php
/**
 *
 * @package Social Share Buttons | Admin
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.1.0
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
	 * @since 1.0
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
			9 => 'printer'
		);
	?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p class="description"><?php echo Settings::PLUGIN_DESC; ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title">Configurações</span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<form action="options.php" method="post">
					<table class="form-table table-configurations" data-table-configurations>
						<tbody>
							<tr class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-placements">
								<th scope="row">
									<label>Locais disponíveis</label>
								</th>
								<td>
					                <label for="single">
					                	<span>Single Post</span>
					                	<input id="single" type="checkbox" value="on"
					                		   name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_single]"
					                		   <?php checked( 'on', $model->single ); ?> />
					                </label>
					            </td>								
								<td>
					                <label for="pages">
					                	<span>Páginas</span>
					                	<input id="pages" type="checkbox" value="on"
					                		   name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_pages]"
					                		   <?php checked( 'on', $model->pages ); ?> />
					                </label>
					            </td>
								<td>
					                <label for="home">
					                	<span>Página Home</span>
					                	<input id="home" type="checkbox" value="on"
					                		   name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_home]"
					                		   <?php checked( 'on', $model->home ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="before">
					                	<span>Antes do Conteúdo</span>
					                	<input id="before" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_before]"
					                	       <?php checked( 'on', $model->before ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="after">
					                	<span>Depois do Conteúdo</span>
					                	<input id="after" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_after]"
					                	       <?php checked( 'on', $model->after ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="jm-excerpt">
					                	<span>Exibir em conteúdo curto</span>
					                	<input id="jm-excerpt" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_excerpt]"
					                	       <?php checked( 'on', $model->excerpt ); ?> />
					                </label>
				                </td>
							</tr>
							<tr class="<?php echo Settings::PLUGIN_PREFIX; ?>-icons-settings">
								<th scope="row">
									<label for="custom-class">Redes sociais disponíveis</label>
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
								 <em class="description">Opções disponíveis apenas para o tema princípal.</em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="custom-class">Classe personalizada</label>
								</th>
								<td>
									<input id="custom-class" class="large-text" type="text"
										   placeholder="Classe personalizada para div princípal"
									       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_class]"
										   value="<?php echo $model->class; ?>">
								</td>
							</tr>
							<tr>
								<th scope="row">
									Opções de aparência
								</th>
								<td class="setting-buttons-themes">
									<p>
										<label for="setting-buttons-theme-main">
											<input id="setting-buttons-theme-main" type="radio"
											       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
												   value="0"
												   <?php checked( 0, $model->desktop ); ?>>
											Tema princípal
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
											       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
												   value="1"
												   <?php checked( 1, $model->desktop ); ?>>
											<span>
												Tema 2 <em>(Facebook; Google Plus; Twitter; Linkedin; WhatsApp)</em>
											</span>
										</label>
										<span class="option-theme-secondary">
											<img src="<?php echo plugins_url( '/assets/images/theme-2.png', __DIR__ ); ?>" width="614" height="30">
										</span>
									</p>
									<p>
										<label for="setting-buttons-theme-total-counter">
											<input id="setting-buttons-theme-total-counter" type="radio"
											       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
												   value="2"
												   <?php checked( 2, $model->desktop ); ?>>
											<span>
												Tema 3 <em>(Facebook; Twitter; Google Plus; WhatsApp; Linkedin; Pinterest)</em>
											</span>
										</label>
									</p>
									<span class="option-theme-total-counter">
										<img src="<?php echo plugins_url( '/assets/images/theme-3.png', __DIR__ ); ?>" width="231" height="30">
									</span>
									<p class="description">Todos os temas tem suporte para responsivo</p>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page' );
						do_settings_sections( Settings::PLUGIN_PREFIX_UNDERSCORE . '_options_page' );
						submit_button( 'Salvar Alterações' );
					?>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Display page setting
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_extra_settings_page()
	{
		$model = new Settings();
	?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p class="description"><?php echo Settings::PLUGIN_DESC; ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title">Configurações Extras</span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<form action="options.php" method="post">
					<table class="form-table table-extras" data-table-extras>
						<tbody>
							<tr>
								<th scope="row">
									<label for="icons-size">Tamanho dos Ícones</label>
								</th>
								<td>
									<input id="icons-size" step="1" min="15" max="60" type="number"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_icons_style_size]"
										   value="<?php echo $model->icons_size; ?>">px
									<em class="description">Apenas para o tema princípal</em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="report-cache-time">Tempo de cache</label>
								</th>
								<td>
									<input id="report-cache-time" step="1" min="1" max="60" type="number"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_report_cache_time]"
										   value="<?php echo $model->report_cache_time; ?>"> Minuto(s)
									<em class="description">Defina o tempo em minutos que terá o cache na página relatório de compartilhamento</em>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="twitter-username">Twitter username</label>
								</th>
								<td>
									<input id="twitter-username" class="large-text" type="text"
										   placeholder="Seu nome de usuário do Twitter"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_twitter_via]"
										   value="<?php echo $model->twitter_username; ?>">
									<p class="description">via @username</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="tracking-analytics">UTM de tracking</label>
								</th>
								<td>									
									<input id="tracking-analytics" class="large-text" type="text"
										   placeholder="Adicione UTM tracking (Analytics)"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_tracking]"
										   value="<?php echo $model->tracking; ?>">
									<p class="description">
										Utilize o encode <code>&amp;</code> para adicionar parâmetros em seu tracking. (Facebook; Google Plus; Whatsapp; Pinterest; Linkedin)
									</p>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="disable-css">Desabilitar CSS</label>
								</th>
								<td>
									<label for="disable-css">
										<input id="disable-css" type="checkbox" value="off"
										       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_remove_style]"
											   <?php checked( 'off', $model->disable_css ); ?>>
										Marque para desabilitar
									</label>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
						settings_fields( Settings::PLUGIN_PREFIX_UNDERSCORE . '_extra_options_page' );
						do_settings_sections( Settings::PLUGIN_PREFIX_UNDERSCORE . '_extra_options_page' );
						submit_button( 'Salvar Alterações' );
					?>
				</form>
			</div>
		</div>
	<?php
	}

	/**
	 * Display page setting
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Void Display page
	 */
	public static function render_page_faq()
	{
	?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p class="description"><?php echo Settings::PLUGIN_DESC; ?></p>
			<span class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-title">
				Opções de uso
			</span>
			<div class="<?php echo Settings::PLUGIN_PREFIX; ?>-settings-wrap">
				<blockquote>
					<strong>Via shortcode: </strong>
					<code>[JMSSB class_ul="" class_li="" class_link="" class_icon=""]</code>
					//Retorna todos os botões //Classes são opcionais
				</blockquote>
				<blockquote>
					<strong>Via shortcode: </strong>
					<code>[JMSSBWHATSAPP class=""]</code>
					//Retorna apenas o botão do WhatsApp //Classe é opcional
				</blockquote>
				<blockquote>
					<strong>Via metódo PHP: </strong>
					<code>JM\Share_Buttons\Share_View::jm_ssb()</code>
					//Retorna todos os botões do tema princípal
				</blockquote>
				<blockquote>
					<strong>Via metódo PHP: </strong>
					<code>JM\Share_Buttons\Share_View::theme_secondary()</code>
					//Retorna os botões do tema secundário
				</blockquote>
				<blockquote>
					<strong>Via metódo PHP: </strong>
					<code>JM\Share_Buttons\Share_View::theme_total_counter()</code>
					//Retorna os botões do tema contador geral
				</blockquote>
			</div>
		</div>
	<?php
	}

	/**
	 * Generate data all social icons
	 * 
	 * @since 1.0
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
			'sms' => array(
				'name'  => 'Sms',
				'icon'  => 'sms.svg',
				'class' => Settings::PLUGIN_PREFIX . '-sms',
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
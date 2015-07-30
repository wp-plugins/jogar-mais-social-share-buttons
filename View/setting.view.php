<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Admin
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.0.2
 */

namespace JM\Share_Buttons;

class Setting_View extends Share_View
{
	/**
	 * @since 1.0
	 * @param Show options admin page
	 */
	public static function render_settings_page()
	{
		$model = new Settings();
	?>
		<div class="wrap">
			<h2><?php echo Settings::PLUGIN_NAME; ?></h2>
			<p><?php echo Settings::PLUGIN_DESC; ?></p>
			<div class="jm-ssb-settings-wrap">
				<form action="options.php" method="post">
					<table class="form-table table-configurations" data-table-configurations>
						<span class="jm-ssb-settings-title">Configurações</span>
						<tbody>
							<tr class="jm-ssb-settings-placements">
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
										printf( '<img src="' . Utils_Helper::plugin_url( "icons/%s" ) . '" class="%s">', $button->icon, $button->class );
										printf( '<input id="%s" type="checkbox" name="jm_ssb[' . Settings::PLUGIN_PREFIX_UNDERSCORE . '_%s]" value="%s" %s>',
											$button->class,
											$button->name,
											$button->name,
											checked( $button->name, Utils_Helper::option( '_' . $button->name ), false )
										);
										echo '</label>';

									endforeach;
									?>
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
								<td>
									<label for="setting-buttons-theme-main">
										<input id="setting-buttons-theme-main" type="radio"
										       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
											   value="0"
											   <?php checked( 0, $model->desktop ); ?>>
										Tema princípal
									</label>
									<hr>
									<label for="setting-buttons-theme-secondary">
										<input id="setting-buttons-theme-secondary" type="radio"
										       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
											   value="1"
											   <?php checked( 1, $model->desktop ); ?>>
										<span title="Obs.: Marcando esta opção o tema princípal será exibido automáticamente para usuários em dispositivos mobile">Tema secundário</span>
									</label>
								</td>
							</tr>
						</tbody>
					</table>
					<table class="form-table table-extras" data-table-extras>
						<span class="jm-ssb-settings-title">Configurações Extras</span>
						<tbody>
							<tr>
								<th scope="row">
									<label for="icons-size">Tamanho dos Ícones</label>
								</th>
								<td>
									<input id="icons-size" step="1" min="15" max="60" type="number"
									       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_icons_style_size]"
										   value="<?php echo $model->icons_size; ?>">px
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
									<p class="description">Utilize o encode <code>&amp;</code> para adicionar parâmetros em seu tracking. (Facebook; Google Plus; Whatsapp; Pinterest; Linkedin)</p>
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
					<div class="options-use">
						<span class="jm-ssb-settings-title">Opções de uso</span>
						<blockquote>Via shortcode: <code>[JMSSB class_ul="" class_li="" class_link="" class_icon=""]</code> //Retorna todos os botões || Obs.: As classes são opcionais</blockquote>
						<blockquote>Via shortcode: <code>[JMSSBWHATSAPP class=""]</code> //Retorna apenas o botão do WhatsApp</blockquote>
						<blockquote>Via metódo PHP: <code>JM\Share_Buttons\Share_View::jm_ssb()</code> //Retorna todos os botões</blockquote>
					</div>
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
	 * @since 1.0
	 * @param Generate data all social icons display
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
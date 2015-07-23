<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Admin
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.0
 */

namespace JM\Share_Buttons;

class Setting_View extends Share_View
{
	/**
	 * @since 1.0
	 * @package Show options admin page
	 */
	public static function options()
	{
		$model   = new Settings();
		$options = $model->options->get_options();
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
					                		   <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_single'] ); ?> />
					                </label>
					            </td>								
								<td>
					                <label for="pages">
					                	<span>Páginas</span>
					                	<input id="pages" type="checkbox" value="on"
					                		   name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_pages]"
					                		   <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_pages'] ); ?> />
					                </label>
					            </td>
								<td>
					                <label for="home">
					                	<span>Página Home</span>
					                	<input id="home" type="checkbox" value="on"
					                		   name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_home]"
					                		   <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_home'] ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="before">
					                	<span>Antes do Conteúdo</span>
					                	<input id="before" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_before]"
					                	       <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_before'] ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="after">
					                	<span>Depois do Conteúdo</span>
					                	<input id="after" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_after]"
					                	       <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_after'] ); ?> />
					                </label>
				                </td>
								<td>
					                <label for="jm-excerpt">
					                	<span>Exibir em conteúdo curto</span>
					                	<input id="jm-excerpt" type="checkbox" value="on"
					                	       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_excerpt]"
					                	       <?php checked( 'on', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_excerpt'] ); ?> />
					                </label>
				                </td>
							</tr>
							<tr class="<?php echo Settings::PLUGIN_PREFIX; ?>-icons-settings">
								<th scope="row">
									<label for="custom-class">Redes sociais disponíveis</label>
								</th>
								<td>
									<?php
									foreach ( self::_buttons_settings() as $key => $button ) :

										printf( '<label for="%s">', $button->class );
										printf( '<img src="' . parent::_plugin_url( "icons/%s" ) . '" class="%s">', $button->icon, $button->class );
										printf( '<input id="%s" type="checkbox" name="jm_ssb[' . Settings::PLUGIN_PREFIX_UNDERSCORE . '_%s]" value="%s" %s>',
											$button->class,
											$button->name,
											$button->name,
											checked( $button->name, $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_' . $button->name], false )
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
										   value="<?php echo esc_html( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_class'] ); ?>">
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
											   <?php checked( 0, $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_desktop'] ); ?>>
										Tema princípal
									</label>
									<hr>
									<label for="setting-buttons-theme-secondary">
										<input id="setting-buttons-theme-secondary" type="radio"
										       name="jm_ssb[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
											   value="1"
											   <?php checked( 1, $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_desktop'] ); ?>>
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
										   value="<?php echo intval( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_icons_style_size'] ); ?>">px
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
										   value="<?php echo esc_html( $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'] ); ?>">
									via @username
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="disable-css">Desabilitar CSS</label>
								</th>
								<td>
									<label for="disable-css">
										<input id="disable-css" type="checkbox"
										       name="jm_ssb_style_settings[<?php echo Settings::PLUGIN_PREFIX_UNDERSCORE; ?>_remove_style]"
											   value="off"
											   <?php checked( 'off', $options[Settings::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'] ); ?>>
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
						submit_button( 'Salvar Alterações' );
					?>
				</form>
			</div>
		</div>
	<?php
	}

	protected static function _buttons_settings()
	{
		$buttons_settings = ( object ) array(

			'facebook' => ( object ) array(
				'name'  => 'Facebook',
				'icon'  => 'facebook.svg',
				'class' => Settings::PLUGIN_PREFIX . '-facebook',
			),
			'twitter' => ( object ) array(
				'name'  => 'Twitter',
				'icon'  => 'twitter.svg',
				'class' => Settings::PLUGIN_PREFIX . '-twitter',
			),
			'google_plus' => ( object ) array(
				'name'  => 'Google',
				'icon'  => 'google_plus.svg',
				'class' => Settings::PLUGIN_PREFIX . '-google-plus',
			),
			'whatsapp' => ( object ) array(
				'name'  => 'Whatsapp',
				'icon'  => 'whatsapp.svg',
				'class' => Settings::PLUGIN_PREFIX . '-whatsapp',
			),
			'sms' => ( object ) array(
				'name'  => 'Sms',
				'icon'  => 'sms.svg',
				'class' => Settings::PLUGIN_PREFIX . '-sms',
			),
			'pinterest' => ( object ) array(
				'name'  => 'Pinterest',
				'icon'  => 'pinterest.png',
				'class' => Settings::PLUGIN_PREFIX . '-pinterest',
			),
			'linkedin' => ( object ) array(
				'name'  => 'Linkedin',
				'icon'  => 'linkedin.svg',
				'class' => Settings::PLUGIN_PREFIX . '-linkedin',
			),
			'tumblr' => ( object ) array(
				'name'  => 'Tumblr',
				'icon'  => 'tumblr.svg',
				'class' => Settings::PLUGIN_PREFIX . '-tumblr',
			),
			'gmail' => ( object ) array(
				'name'  => 'Gmail',
				'icon'  => 'gmail.svg',
				'class' => Settings::PLUGIN_PREFIX . '-gmail',
			),
			'email' => ( object ) array(
				'name'  => 'Email',
				'icon'  => 'email.svg',
				'class' => Settings::PLUGIN_PREFIX . '-email',
			),
			'printfriendly' => ( object ) array(
				'name'  => 'PrintFriendly',
				'icon'  => 'printfriendly.svg',
				'class' => Settings::PLUGIN_PREFIX . '-print-friendly',
			),
		);

		return $buttons_settings;
	}
}
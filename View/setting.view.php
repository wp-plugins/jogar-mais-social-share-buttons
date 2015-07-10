<?php
/**
 *
 * @package Jogar Mais - Social Share Buttons | Admin
 * @author  Victor Freitas
 * @subpackage View Admin Page
 * @version 1.0
 */

namespace JM\Share_Buttons;

class Setting_View extends Share_View
{
	public static $options_controller;

	/**
	 * @since 1.0
	 * @package Show options admin page
	 */
	public static function jm_ssb_options()
	{
		self::$options_controller = Core::$option_controller;
		$options                  = self::$options_controller->jm_ssb_check_options();
	?>
		<div class="<?php echo Init::PLUGIN_PREFIX; ?>-admin-wrap">
			<form action="options.php" method="post" class="<?php echo Init::PLUGIN_PREFIX; ?>-db-form">
		    	
		    	<div class="<?php echo Init::PLUGIN_PREFIX; ?>-admin-right">
		    		<span class="<?php echo Init::PLUGIN_PREFIX; ?>-title">Configurações Extras</span>

			    		<label for="remove-style">
			    			<span>Desabilitar CSS</span>
			    			<input id="remove-style" type="checkbox" value="off" <?php checked( 'off', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_remove_style'] ); ?>
			    			       name="jm_ssb_style_settings[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_remove_style]" />
			    		</label>

						<label for="icons-style-size">
			    			<span class="size">Tamanho dos Ícones</span>
			    			<input id="icons-style-size" type="number" step="1" min="15" max="60" class="small-text"
			    			       value="<?php echo intval( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_icons_style_size'] ); ?>"
			    			       name="jm_ssb_style_settings[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_icons_style_size]" />px
			    		</label>

						<label for="<?php echo Init::PLUGIN_PREFIX; ?>-twitter-username">
			    			<span class="size">Nome de usuário do Twitter</span>
			    			<input id="<?php echo Init::PLUGIN_PREFIX; ?>-twitter-username" type="text" class="medium-text"
			    			       value="<?php echo esc_html( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_twitter_via'] ); ?>"
			    			       name="jm_ssb_style_settings[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_twitter_via]" />
			    		</label>

		    	</div>

		        <div class="<?php echo Init::PLUGIN_PREFIX; ?>-admin-top-desc">
		            <h1><?php echo Init::JOGAR_MAIS_SOCIAL_BUTTONS_NAME; ?><small> - <?php echo Init::JOGAR_MAIS_SOCIAL_BUTTONS_DESC; ?></small></h1>
		        </div>

				<div class="<?php echo Init::PLUGIN_PREFIX; ?>-admin-content">
			      <div class="<?php echo Init::PLUGIN_PREFIX; ?>-admin-main">
			        <div class="thead">

		                <label for="single">
		                	<span>Single Post</span>
		                	<input id="single" type="checkbox" value="on"
		                		   name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_single]"
		                		   <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_single'] ); ?> />
		                </label>

		                <label for="pages">
		                	<span>Páginas</span>
		                	<input id="pages" type="checkbox" value="on"
		                		   name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_pages]"
		                		   <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_pages'] ); ?> />
		                </label>

		                <label for="home">
		                	<span>Página Home</span>
		                	<input id="home" type="checkbox" value="on"
		                		   name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_home]"
		                		   <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_home'] ); ?> />
		                </label>

		                <label for="before">
		                	<span>Antes do Conteúdo</span>
		                	<input id="before" type="checkbox" value="on"
		                	       name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_before]"
		                	       <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_before'] ); ?> />
		                </label>

		                <label for="after">
		                	<span>Depois do Conteúdo</span>
		                	<input id="after" type="checkbox" value="on"
		                	       name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_after]"
		                	       <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_after'] ); ?> />
		                </label>

		                <label for="jm-excerpt">
		                	<span>Exibir em conteúdo curto</span>
		                	<input id="jm-excerpt" type="checkbox" value="on"
		                	       name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_excerpt]"
		                	       <?php checked( 'on', $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_excerpt'] ); ?> />
		                </label>

			        </div>

			        <div class="<?php echo Init::PLUGIN_PREFIX; ?>-custom-class">
			        	<div class="ssb-custom-title">
			        		<h2>Classes customizadas para o plugin</h2>
			        	</div>
		                <label for="jm-custom-class">
		                	<span>Classe princípal</span>
		                	<input id="jm-custom-class" class="regular-text" placeholder="Infome sua classe customizada"
		                	       name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_class]"
		                	       value="<?php echo esc_html( $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_class'] ); ?>">
		                </label>
		            </div>

			      </div>
				</div>

				<div class="<?php echo Init::PLUGIN_PREFIX; ?>-icons-settings">
					<div class="ssb-custom-title">
						<h3>Marque ou remova as redes para compartilhar seus posts</h3>
					</div>
					<div class="<?php echo Init::PLUGIN_PREFIX; ?>-icons-social">
					<?php
					foreach ( self::_jm_ssp_buttons_settings() as $key => $icons ) :

						echo '<label for="' . $icons->class . '">';

						printf( '<img src="' . parent::_jm_ssb_plugin_url( "icons/%s" ) . '" class="%s">', $icons->icon, $icons->class );
						printf( '<input id="%s" type="checkbox" name="jm_ssb[' . Init::PLUGIN_PREFIX_UNDERSCORE . '_%s]" value="%s"
						 ' . checked( $icons->name, $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_' . $icons->name], false ) . ' />',
							$icons->class, $icons->name, $icons->name );

						echo '</label>';

					endforeach;
					?>
					</div>
				</div>

		        <div class="<?php echo Init::PLUGIN_PREFIX; ?>-custom-code">
		        	<div class="ssb-custom-title">
		        		<h4>Estilo para desktop</h4>
		        	</div>
		        	<div class="style-buttons-settings">
		        		<blockquote>Obs.: Marcando esta opção o estilo padrão será exibido apenas para usuários em dispositivos móveis.</blockquote>						
						<span class="icons-settings">
							
							<label for="setting-buttons-desktop">
								<input type="hidden" name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]" value="0">
								<input type="checkbox" id="setting-buttons-desktop" value="1"
									   name="jm_ssb[<?php echo Init::PLUGIN_PREFIX_UNDERSCORE; ?>_desktop]"
									   <?php checked( 1, $options[Init::PLUGIN_PREFIX_UNDERSCORE . '_desktop'] ); ?>>
								<img src="<?php echo parent::_jm_ssb_plugin_url( 'images/options-setting-buttons.png' ); ?>" width="360px" height="25px">
							</label>

						</span>
					</div>
		        </div>

		        <div class="<?php echo Init::PLUGIN_PREFIX; ?>-custom-code">
		        	<div class="ssb-custom-title">
		        		<h5>Usando shortcode</h5>
		        	</div>
		        	<blockquote>Classes são opcionais</blockquote>
		        	<blockquote><code>[JMSSB class_ul="" class_li="" class_icon="" class_link=""]</code> //Retorna todos os botões</blockquote>
		        	<blockquote><code>[JMSSBWHATSAPP class=""]</code> //Retorna apenas o botão do WhatsApp</blockquote>
		        </div>

				<?php
			        settings_fields( Init::PLUGIN_PREFIX_UNDERSCORE . '_options_page' );
			    ?>
				<span class="btn-<?php echo Init::PLUGIN_PREFIX; ?>-db">
					<input type="submit" class="button-primary" value="<?php _e( 'Salvar Alterações' ); ?>" />
				</span>

		    </form>
		</div>
	<?php
	}

	protected static function _jm_ssp_buttons_settings()
	{
		$buttons_settings = ( object ) array(

			'facebook' => ( object ) array(
				'name'  => 'Facebook',
				'icon'  => 'facebook.svg',
				'class' => Init::PLUGIN_PREFIX . '-facebook',
			),
			'twitter' => ( object ) array(
				'name'  => 'Twitter',
				'icon'  => 'twitter.svg',
				'class' => Init::PLUGIN_PREFIX . '-twitter',
			),
			'google_plus' => ( object ) array(
				'name'  => 'Google',
				'icon'  => 'google_plus.svg',
				'class' => Init::PLUGIN_PREFIX . '-google-plus',
			),
			'whatsapp' => ( object ) array(
				'name'  => 'Whatsapp',
				'icon'  => 'whatsapp.svg',
				'class' => Init::PLUGIN_PREFIX . '-whatsapp',
			),
			'sms' => ( object ) array(
				'name'  => 'Sms',
				'icon'  => 'sms.svg',
				'class' => Init::PLUGIN_PREFIX . '-sms',
			),
			'pinterest' => ( object ) array(
				'name'  => 'Pinterest',
				'icon'  => 'pinterest.png',
				'class' => Init::PLUGIN_PREFIX . '-pinterest',
			),
			'linkedin' => ( object ) array(
				'name'  => 'Linkedin',
				'icon'  => 'linkedin.svg',
				'class' => Init::PLUGIN_PREFIX . '-linkedin',
			),
			'tumblr' => ( object ) array(
				'name'  => 'Tumblr',
				'icon'  => 'tumblr.svg',
				'class' => Init::PLUGIN_PREFIX . '-tumblr',
			),
			'gmail' => ( object ) array(
				'name'  => 'Gmail',
				'icon'  => 'gmail.svg',
				'class' => Init::PLUGIN_PREFIX . '-gmail',
			),
			'email' => ( object ) array(
				'name'  => 'Email',
				'icon'  => 'email.svg',
				'class' => Init::PLUGIN_PREFIX . '-email',
			),
			'printfriendly' => ( object ) array(
				'name'  => 'PrintFriendly',
				'icon'  => 'printfriendly.svg',
				'class' => Init::PLUGIN_PREFIX . '-print-friendly',
			),
		);

		return $buttons_settings;
	}
}
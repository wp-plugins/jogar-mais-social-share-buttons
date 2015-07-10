<?php
/*
	Plugin Name: Jogar Mais - Social Share Buttons
	Plugin URI: http://share.jogarmais.com.br
	Version: 1.0.0
	Author: Victor Freitas
	Author URI: http://jogarmais.com.br
	License: GPL2
	Text Domain: jm-ssb
	Description: Insere botões de compartilhamento das redes sociais. Os botões podem ser inseridos via shortcode ou método php.
*/

namespace JM\Share_Buttons;

class Init
{
	const PLUGIN_SLUG = 'jm-ssb';
	const PLUGIN_PREFIX = 'jm-ssb';
	const PLUGIN_PREFIX_UNDERSCORE = 'jm_ssb';

	const CONFIG_NAME = 'Configurações';

	const DS = DIRECTORY_SEPARATOR;
	const FILE = __FILE__;

	const JOGAR_MAIS_SOCIAL_BUTTONS_NAME = 'Jogar Mais - Social Share Buttons';

	const JOGAR_MAIS_SOCIAL_BUTTONS_DESC = 'Adiciona os botões de compartilhamento para seus posts e páginas';

	public static function uses( $class_name, $location )
	{
		$extension = 'php';

		if ( in_array( $location, array( 'Model', 'View', 'Controller',	) ) )
			$extension = strtolower( $location ) . '.php';

		require_once( "{$location}" . self::DS . "{$class_name}.{$extension}" );
	}
}

Init::uses( 'core', 'Config' );

$core = new Core();
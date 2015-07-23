<?php
/**
 * @package Social Share Buttons by Jogar Mais
 */
/*
Plugin Name: Social Share Buttons by Jogar Mais
Plugin URI: http://jogarmais.com.br
Version: 1.0.1
Author: Victor Freitas
Author URI: http://jogarmais.com.br
License: GPL2
Text Domain: jm-ssb
Description: Insere botões de compartilhamento das redes sociais. Os botões são inseridos automáticamente ou podem ser chamados via shortcode ou método php.
*/

namespace JM\Share_Buttons;

class Init
{
	const PLUGIN_SLUG = 'jm-ssb';

	public static function uses( $class_name, $location )
	{
		$extension = 'php';

		if ( in_array( $location, array( 'View', 'Controller',	) ) )
			$extension = strtolower( $location ) . '.php';

		require_once( "{$location}" . DIRECTORY_SEPARATOR . "{$class_name}.{$extension}" );
	}
}

Init::uses( 'core', 'Config' );

$core = new Core();
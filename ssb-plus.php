<?php
/**
 * @package Social Sharing Buttons
 */
/*
Plugin Name: Social Sharing Buttons
Plugin URI: http://jogarmais.com.br
Version: 2.0.1
Author: Victor Freitas
Author URI: http://jogarmais.com.br
License: GPL2
Text Domain: ssb-plus
Domain Path: /languages
Description: Insere botões de compartilhamento das redes sociais. Os botões são inseridos automáticamente ou podem ser chamados via shortcode ou método php.
*/

/*
 *      Copyright 2015 Victor Freitas <dev@jogarmais.com.br>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Init
{
	const PLUGIN_SLUG = 'ssb-plus';

	const FILE = __FILE__;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0
	 * @return Void
	 */
	public static function uses( $class_name, $location )
	{
		$extension = 'php';

		if ( in_array( $location, array( 'View', 'Controller', 'Helper', ) ) )
			$extension = strtolower( $location ) . '.php';

		require_once( "{$location}" . DIRECTORY_SEPARATOR . "{$class_name}.{$extension}" );
	}
}

Init::uses( 'core', 'Config' );

$core = new Core();
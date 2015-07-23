<?php
/**
 *
 * @package Social Share Buttons by Jogar Mais | Settings
 * @author  Victor Freitas
 * @subpackage Settings Model
 * @version 1.0
 */

namespace JM\Share_Buttons;

class Settings
{
	private $options;

	const PLUGIN_PREFIX = 'jm-ssb';

	const PLUGIN_PREFIX_UNDERSCORE = 'jm_ssb';

	const DS = DIRECTORY_SEPARATOR;

	const FILE = __FILE__;

	const PLUGIN_NAME = 'Social Share Buttons by Jogar Mais';

	const PLUGIN_DESC = 'Adiciona os botões de compartilhamento automáticamente em posts e páginas';

	public function __construct()
	{

	}

	public function __get( $prop_name )
	{
		return $this->_get_property( $prop_name );
	}

	private function _get_property( $prop_name )
	{
		switch ( $prop_name ) :
			case 'options' :
				if ( ! isset( $this->options ) )
					$this->options = Core::$option_controller;
				break;			
			default :
				return false;
				break;
		endswitch;

		return $this->$prop_name;
	}
}
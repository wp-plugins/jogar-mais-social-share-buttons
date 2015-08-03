<?php
/**
 *
 * @package Social Share Buttons | Functions
 * @author  Victor Freitas
 * @version 1.0.3
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

//Controller
Init::uses( 'settings', 'Controller' );
Init::uses( 'option', 'Controller' );
Init::uses( 'share', 'Controller' );
Init::uses( 'sharing-report', 'Controller' );
//Utils
Init::uses( 'utils', 'Helper' );

class Core
{
	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0
	 */
	public function __construct()
	{
		$settings     = new Settings_Controller();
		$share        = new Share_Controller();
		$option       = new Option_Controller();
		$share_report = new Sharing_Report_Controller();
	}

	/**
	 * Generate object all social icons
	 * 
	 * @since 1.0
	 * @param String $title
	 * @param String $url
	 * @param String $tracking
	 * @param String $thumbnail
	 * @param String $content
	 * @param String $caracter
	 * @param String $sms_title
	 * @param String $twitter_via
	 * @return Object all data links
	 */
	private static function _set_elements( $title, $url, $tracking, $thumbnail, $content, $caracter, $sms_title, $twitter_via )
	{
		$data_action    = 'data-action="open-popup"';
		$share_services = array(
			'facebook' => array(
				'name'  => 'Facebook',
				'link'  => "https://www.facebook.com/sharer/sharer.php?u={$url}{$tracking}",
				'title' => 'Compartilhar no Facebook',
				'icon'  => 'facebook.svg',
				'class' => Settings::PLUGIN_PREFIX . '-facebook',
				'popup' => $data_action,
				'img'   => 'icon-facebook',
			),
			'twitter' => array(
				'name'  => 'Twitter',
				'link'  => "https://twitter.com/share?url={$url}&text=Acabei de ver {$title} - Clique pra ver também {$caracter}&via={$twitter_via}",
				'title' => 'Compartilhar no Twitter',
				'icon'  => 'twitter.svg',
				'class' => Settings::PLUGIN_PREFIX . '-twitter',
				'popup' => $data_action,
				'img'   => 'icon-twitter',
			),
			'google_plus' => array(
				'name'  => 'Google',
				'link'  => "https://plus.google.com/share?url={$url}{$tracking}",
				'title' => 'Compartilhar no Google+',
				'icon'  => 'google_plus.svg',
				'class' => Settings::PLUGIN_PREFIX . '-google-plus',
				'popup' => $data_action,
				'img'   => 'icon-google',
			),
			'whatsapp' => array(
				'name'  => 'Whatsapp',
				'link'  => "whatsapp://send?text={$title}{$caracter}{$url}{$tracking}",
				'title' => 'Compartilhar no WhatsApp',
				'icon'  => 'whatsapp.svg',
				'class' => Settings::PLUGIN_PREFIX . '-whatsapp',
				'popup' => '',
				'img'   => 'icon-whatsapp',
			),
			'sms' => array(
				'name'  => 'Sms',
				'link'  => "sms:?body={$sms_title}{$caracter}{$url}",
				'title' => 'Enviar via SMS',
				'icon'  => 'sms.svg',
				'class' => Settings::PLUGIN_PREFIX . '-sms',
				'popup' => '',
				'img'   => 'icon-sms',
			),
			'pinterest' => array(
				'name'  => 'Pinterest',
				'link'  => "https://pinterest.com/pin/create/button/?url={$url}{$tracking}&media={$thumbnail}&description={$title}",
				'title' => 'Compartilhar no Pinterest',
				'icon'  => 'pinterest.png',
				'class' => Settings::PLUGIN_PREFIX . '-pinterest',
				'popup' => $data_action,
				'img'   => 'icon-pinterest',
			),
			'linkedin' => array(
				'name'  => 'Linkedin',
				'link'  => "https://www.linkedin.com/shareArticle?mini=true&url={$url}{$tracking}&title={$title}",
				'title' => 'Compartilhar no Linkedin',
				'icon'  => 'linkedin.svg',
				'class' => Settings::PLUGIN_PREFIX . '-linkedin',
				'popup' => $data_action,
				'img'   => 'icon-linkedin',
			),
			'tumblr' => array(
				'name'  => 'Tumblr',
				'link'  => 'http://www.tumblr.com/share',
				'title' => 'Compartilhar no Tumblr',
				'icon'  => 'tumblr.svg',
				'class' => Settings::PLUGIN_PREFIX . '-tumblr',
				'popup' => $data_action,
				'img'   => 'icon-tumblr',
			),
			'gmail' => array(
				'name'  => 'Gmail',
				'link'  => "https://mail.google.com/mail/u/0/?ui=2&view=cm&fs=1&tf=1&su={$title}&body={$content}\n{$url}",
				'title' => 'Enviar via Gmail',
				'icon'  => 'gmail.svg',
				'class' => Settings::PLUGIN_PREFIX . '-gmail',
				'popup' => $data_action,
				'img'   => 'icon-gmail',
			),
			'email' => array(
				'name'  => 'Email',
				'link'  => "mailto:?subject={$title}&body={$url}",
				'title' => 'Enviar por email',
				'icon'  => 'email.svg',
				'class' => Settings::PLUGIN_PREFIX . '-email',
				'popup' => $data_action,
				'img'   => 'icon-email',
			),
			'printfriendly' => array(
				'name'  => 'PrintFriendly',
				'link'  => "http://www.printfriendly.com/print?url={$url}&partner=whatsapp",
				'title' => 'Imprimir via Print Friendly',
				'icon'  => 'printfriendly.svg',
				'class' => Settings::PLUGIN_PREFIX . '-print-friendly',
				'popup' => $data_action,
				'img'   => 'icon-printfriendly',
			),
		);

		return Utils_Helper::array_to_object( $share_services );
	}

	/**
	 * Encode all items from data services
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Object
	 */
	protected static function _get_elements()
	{
		$arguments = self::_get_arguments();
		$tracking  = Utils_Helper::option( '_tracking' );
		$elements  = self::_set_elements(
			rawurlencode( $arguments['title'] ),
			rawurlencode( $arguments['link'] ),
			rawurlencode( $tracking ),
			rawurlencode( $arguments['thumbnail'] ),
			rawurlencode( $arguments['body_mail'] ),
			rawurlencode( '➜ ' ),
			rawurlencode( $arguments['sms_title'] ),
			Utils_Helper::option( '_twitter_via' )
		);

		return $elements;
	}

	/**
	 * Get arguments for social url elements
	 * 
	 * @since 1.0
	 * @param Null
	 * @return Array
	 */
	private static function _get_arguments()
	{
		$title        = Utils_Helper::get_title();
		$title_decode = Utils_Helper::html_decode( $title );
		$arguments    = array(
			'title'     => '"' . $title_decode . '" ',
			'link'      => Utils_Helper::get_permalink(),
			'thumbnail' => Utils_Helper::get_image(),
			'body_mail' => Utils_Helper::body_mail(),
			'sms_title' => str_replace( '&', 'e', $title_decode ) . ' ',
		);

		return $arguments;
	}
}
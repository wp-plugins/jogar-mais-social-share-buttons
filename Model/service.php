<?php
/**
 *
 * @package Social Share Buttons | Service
 * @author  Victor Freitas
 * @subpackage Service Model
 * @version 1.0.0
 */

namespace JM\Share_Buttons;

// Avoid that files are directly loaded
if ( ! function_exists( 'add_action' ) )
	exit(0);

class Service
{
	/**
	 * ID
	 *
	 * @since 1.0
	 * @var string
	 */
	private $ID;

	/**
	* Metas name counts shares
	*
	* @since 1.0
	* @var string
	*/
	private $share_count_facebook;
	private $share_count_twitter;
	private $share_count_google;
	private $share_count_linkedin;
	private $share_count_pinterest;

	/**
	* Socia shares counts
	*
	* @since 1.0
	* @var string
	*/
	const POST_META_SHARE_COUNT_FACEBOOK = 'jm-share-count-facebook';
	const POST_META_SHARE_COUNT_TWITTER = 'jm-share-count-twitter';
	const POST_META_SHARE_COUNT_GOOGLE = 'jm-share-count-google';
	const POST_META_SHARE_COUNT_LINKEDIN = 'jm-share-count-linkedin';
	const POST_META_SHARE_COUNT_PINTEREST = 'jm-share-count-pinterest';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since 1.0
	 */
	public function __construct( $ID = false )
	{
		if ( false !== $ID )
			$this->ID = $ID;
	}

	/**
	 * Magic function to retrieve the value of the attribute more easily.
	 *
	 * @since 1.0
	 * @param string $prop_name The attribute name
	 * @return mixed The attribute value
	 */
	public function __get( $prop_name )
	{
		if ( isset( $this->$prop_name ) )
			return $this->$prop_name;

		return $this->_get_meta_property( $prop_name );
	}

	/**
	 * Get Property share count per name
	 *
	 * @since 1.0
	 * @return mixed String/Integer The value of the attribute
	*/
	private function _get_meta_property( $prop_name )
	{
		switch ( $prop_name ) :

			case 'share_count_facebook' : 
				if ( ! isset( $this->share_count_facebook ) )
					$this->share_count_facebook = get_post_meta( $this->ID, self::POST_META_SHARE_COUNT_FACEBOOK, true );
				break;

			case 'share_count_twitter' :
				if ( ! isset( $this->share_count_twitter ) )
					$this->share_count_twitter = get_post_meta( $this->ID, self::POST_META_SHARE_COUNT_TWITTER, true );
				break;

			case 'share_count_google' :
				if ( ! isset( $this->share_count_google ) )
					$this->share_count_google = get_post_meta( $this->ID, self::POST_META_SHARE_COUNT_GOOGLE, true );
				break;

			case 'share_count_linkedin' :
				if ( ! isset( $this->share_count_linkedin ) )
					$this->share_count_linkedin = get_post_meta( $this->ID, self::POST_META_SHARE_COUNT_LINKEDIN, true );
				break;

			case 'share_count_pinterest' :
				if ( ! isset( $this->share_count_pinterest ) )
					$this->share_count_pinterest = get_post_meta( $this->ID, self::POST_META_SHARE_COUNT_PINTEREST, true );
				break;

			default :
				return $this->get_property( $prop_name );
				break;
		
		endswitch;

		return $this->$prop_name;
	}

}
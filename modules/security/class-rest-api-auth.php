<?php
/**
 * Api Auth
 *
 * @package ASVZ
 */

namespace BD\Security;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use WP_Error;

/**
 * Api Auth class
 */
class Rest_API_Auth {

	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_filter( 'rest_authentication_errors', [ $this, 'disable_rest_api' ] );
	}

	/**
	 * Disable REST API
	 *
	 * @param ? $access ?.
	 */
	public function disable_rest_api( $access ) {
		return new WP_Error(
			rest_authorization_required_code(),
			__( 'REST API is disabled.', 'asvz' ),
			array( 'status' => 'rest_cannot_access' )
		);
	}
}

new Rest_API_Auth();

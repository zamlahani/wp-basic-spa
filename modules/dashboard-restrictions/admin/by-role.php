<?php
/**
 * Restrict dashboard by role
 *
 * @package ASVZ
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

$allowed      = false;
$total_roles  = absint( get_option( 'options_allowed_roles' ) );
$current_user = wp_get_current_user();

if ( ! $total_roles || in_array( 'administrator', $current_user->roles, true ) || in_array( 'manager', $current_user->roles, true ) ) {
	return;
}

// Start of looping allowed role(s).
for ( $i = 0; $i < $total_roles; $i++ ) {
	$allowed_role = get_option( 'options_allowed_roles_' . $i . '_role' );

	// if current user has one of allowed roles.
	if ( in_array( $allowed_role, $current_user->roles, true ) ) {
		$allowed = true;
		break;
	}
} // End of looping allowed role(s).

if ( ! $allowed ) {
	$this->redirect();
}

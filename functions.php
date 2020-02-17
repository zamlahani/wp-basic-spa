<?php
/**
 * Setting up theme
 *
 * @package ASVZ
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

require_once __DIR__ . '/setup/class-theme.php';

/**
 * The main function responsible for returning the one true theme Instance to functions everywhere.
 * Use this function like you would a global variable, except without needing to declare the global.
 *
 * @since 1.0.0
 * @return object main object of theme
 */
function setup_theme() {
	global $asvz_theme;

	if ( ! isset( $asvz_theme ) ) {
		$asvz_theme = new Theme();
		$asvz_theme->initialize();
	}

	return $asvz_theme;
}

// initialize!
setup_theme();

<?php
/**
 * Autoloading
 *
 * @package Asvz
 */

namespace Asvz\Feedback;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// helper constants.
if ( ! defined( 'ENABLE_ASVZ_FEEDBACK' ) ) {
	// change this into false to turn off the whole feature (except the helper constants).
	define( 'ENABLE_ASVZ_FEEDBACK', true );
}

if ( ! defined( 'ASVZ_FEEDBACK_URL' ) ) {
	define( 'ASVZ_FEEDBACK_URL', get_stylesheet_directory_uri() . '/modules/feedback' );
}

if ( ! defined( 'ASVZ_FEEDBACK_DIR' ) ) {
	define( 'ASVZ_FEEDBACK_DIR', __DIR__ );
}

if ( ! ENABLE_ASVZ_FEEDBACK ) {
	return;
}

// helper classes.
require __DIR__ . '/helpers/class-base.php';
require __DIR__ . '/helpers/class-feedback.php';

// ajax classes.
require __DIR__ . '/ajax/class-submit-feedback.php';

// setup classes.
require __DIR__ . '/class-setup.php';

// init classes.
new Setup( true );
new Ajax\Submit_Feedback( true );

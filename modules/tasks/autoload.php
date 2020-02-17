<?php
namespace Asvz\Tasks;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// helper constants.
if ( ! defined( 'ENABLE_ASVZ_TASKS' ) ) {
	// change this into false to turn off the whole feature (except the helper constants).
	define( 'ENABLE_ASVZ_TASKS', true );
}

if ( ! defined( 'ASVZ_TASKS_URL' ) ) {
	define( 'ASVZ_TASKS_URL', get_stylesheet_directory_uri() . '/modules/tasks' );
}

if ( ! defined( 'ASVZ_TASKS_DIR' ) ) {
	define( 'ASVZ_TASKS_DIR', __DIR__ );
}

if ( ! ENABLE_ASVZ_TASKS ) {
	return;
}

// helper classes.
require __DIR__ . '/helpers/class-base.php';
require __DIR__ . '/helpers/class-category.php';
require __DIR__ . '/helpers/class-step.php';
require __DIR__ . '/helpers/class-task.php';

// ajax classes.

// setup classes.
require __DIR__ . '/class-setup.php';

// init classes.
new Setup( true );

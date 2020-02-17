<?php
/**
 * Autoloading
 *
 * @package Asvz
 */

namespace Asvz\Material;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// helper classes.
require __DIR__ . '/helpers/class-base.php';
require __DIR__ . '/helpers/class-material.php';

// ajax classes.

// setup classes.
require __DIR__ . '/class-setup.php';

// init classes.
new Setup( true );

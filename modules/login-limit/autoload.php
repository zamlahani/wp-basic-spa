<?php
/**
 * Autoloading
 *
 * @package ASVZ
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Disable module.
return;

require_once __DIR__ . '/admin/class-login-limit.php';
require_once __DIR__ . '/admin/class-lockdown.php';
require_once __DIR__ . '/admin/class-notification.php';
require_once __DIR__ . '/admin/class-settings.php';

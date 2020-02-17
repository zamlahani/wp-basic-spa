<?php
/**
 * Autoloading
 *
 * @package Asvz
 */

namespace Asvz\Contact;

defined( 'ABSPATH' ) || die( "Can't access directly" );

// ajax classes.
require __DIR__ . '/ajax/class-submit-contact.php';

// setup classes.
require __DIR__ . '/class-setup.php';

// init classes.
new Setup();
new Ajax\Submit_Contact();

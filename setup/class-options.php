<?php
/**
 * Setting up theme options
 *
 * @package ASVZ
 */

namespace BD_Theme\Setup;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Options class to setup theme options
 */
class Options {
	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_action( 'acf/init', [ $this, 'add_theme_option' ], 10 );
	}

	/**
	 * This function to create theme option menu under themas
	 */
	public function add_theme_option() {

		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		$option_page = acf_add_options_page(
			array(
				'page_title' => __( 'Site Options', 'asvz' ),
				'menu_title' => __( 'Site Options', 'asvz' ),
				'menu_slug'  => 'site-options',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-welcome-widgets-menus',
			)
		);

	}

}

new Options();

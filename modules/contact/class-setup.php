<?php
/**
 * Setting up backend
 *
 * @package ASVZ
 */

namespace Asvz\Contact;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Setup backend
 */
class Setup {
	/**
	 * Setup actions & filters
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'setup_post_types' ], 20 );
		add_action( 'acf/init', [ $this, 'set_options_page' ] );
	}

	/**
	 * Setup ACF options pages.
	 */
	public function set_options_page() {
		if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
			return;
		}

		acf_add_options_sub_page(
			[
				'page_title'  => 'Settings',
				'menu_slug'   => 'cleaning-contact-settings',
				'parent_slug' => 'edit.php?post_type=cleaning_contact',
			]
		);
	}

	/**
	 * Setup necessary post types.
	 */
	public function setup_post_types() {
		$labels = [
			'name'                  => _x( 'Contacts', 'Post type general name', 'asvz' ),
			'singular_name'         => _x( 'Contact', 'Post type singular name', 'asvz' ),
			'menu_name'             => _x( 'Contact', 'Admin Menu text', 'asvz' ),
			'name_admin_bar'        => _x( 'Contacts', 'Add New on Toolbar', 'asvz' ),
			'add_new'               => __( 'Add New', 'asvz' ),
			'add_new_item'          => __( 'Add New Contact', 'asvz' ),
			'new_item'              => __( 'New Contact', 'asvz' ),
			'edit_item'             => __( 'Edit Contact', 'asvz' ),
			'view_item'             => __( 'View Contact', 'asvz' ),
			'all_items'             => __( 'All Submissions', 'asvz' ),
			'search_items'          => __( 'Search Contacts', 'asvz' ),
			'parent_item_colon'     => __( 'Parent Contacts:', 'asvz' ),
			'not_found'             => __( 'No Contacts found.', 'asvz' ),
			'not_found_in_trash'    => __( 'No Contacts found in Trash.', 'asvz' ),
			'featured_image'        => _x( 'Contact Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'asvz' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'archives'              => _x( 'Contact archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'asvz' ),
			'insert_into_item'      => _x( 'Insert into Contact', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'asvz' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this Contact', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'asvz' ),
			'filter_items_list'     => _x( 'Filter Contacts list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'asvz' ),
			'items_list_navigation' => _x( 'Contacts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'asvz' ),
			'items_list'            => _x( 'Contacts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'asvz' ),
		];

		$args = [
			'labels'    => $labels,
			'menu_icon' => 'dashicons-admin-users',
			'show_ui'   => true,
			'supports'  => array( 'title' ),
		];

		register_post_type( 'cleaning_contact', $args );
	}
}

<?php
/**
 * Setting up backend
 *
 * @package ASVZ
 */

namespace Asvz\Faq;

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
	}

	/**
	 * Setup necessary post types.
	 */
	public function setup_post_types() {
		$labels = [
			'name'                  => _x( 'FAQs', 'Post type general name', 'asvz' ),
			'singular_name'         => _x( 'FAQ', 'Post type singular name', 'asvz' ),
			'menu_name'             => _x( 'FAQ', 'Admin Menu text', 'asvz' ),
			'name_admin_bar'        => _x( 'FAQs', 'Add New on Toolbar', 'asvz' ),
			'add_new'               => __( 'Add New', 'asvz' ),
			'add_new_item'          => __( 'Add New FAQ', 'asvz' ),
			'new_item'              => __( 'New FAQ', 'asvz' ),
			'edit_item'             => __( 'Edit FAQ', 'asvz' ),
			'view_item'             => __( 'View FAQ', 'asvz' ),
			'all_items'             => __( 'All FAQs', 'asvz' ),
			'search_items'          => __( 'Search FAQs', 'asvz' ),
			'parent_item_colon'     => __( 'Parent FAQs:', 'asvz' ),
			'not_found'             => __( 'No FAQs found.', 'asvz' ),
			'not_found_in_trash'    => __( 'No FAQs found in Trash.', 'asvz' ),
			'featured_image'        => _x( 'FAQ Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'asvz' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'archives'              => _x( 'FAQ archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'asvz' ),
			'insert_into_item'      => _x( 'Insert into FAQ', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'asvz' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this FAQ', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'asvz' ),
			'filter_items_list'     => _x( 'Filter FAQs list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'asvz' ),
			'items_list_navigation' => _x( 'FAQs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'asvz' ),
			'items_list'            => _x( 'FAQs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'asvz' ),
		];

		$args = [
			'labels'    => $labels,
			'menu_icon' => 'dashicons-admin-users',
			'show_ui'   => true,
			'supports'  => array( 'title', 'editor' ),
		];

		register_post_type( 'cleaning_faq', $args );
	}
}

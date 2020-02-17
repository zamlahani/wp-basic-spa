<?php
/**
 * Setting up backend
 *
 * @package ASVZ
 */

namespace Asvz\Feedback;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Setup backend
 */
class Setup {
	/**
	 * Class construct
	 *
	 * @param bool $run_setup Whether to run setup or not.
	 */
	public function __construct( $run_setup = false ) {
		if ( ! $run_setup ) {
			return;
		}

		$this->setup();
	}

	/**
	 * Setup actions & filters
	 *
	 * @return void
	 */
	public function setup() {
		add_action( 'init', [ $this, 'setup_post_types' ], 20 );
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
				'menu_slug'   => 'cleaning-feedback-settings',
				'parent_slug' => 'edit.php?post_type=cleaning_feedback',
			]
		);
	}

	/**
	 * Setup necessary post types.
	 */
	public function setup_post_types() {
		$labels = [
			'name'                  => _x( 'Feedbacks', 'Post type general name', 'asvz' ),
			'singular_name'         => _x( 'Feedback', 'Post type singular name', 'asvz' ),
			'menu_name'             => _x( 'Feedbacks', 'Admin Menu text', 'asvz' ),
			'name_admin_bar'        => _x( 'Feedbacks', 'Add New on Toolbar', 'asvz' ),
			'add_new'               => __( 'Add New', 'asvz' ),
			'add_new_item'          => __( 'Add New Feedback', 'asvz' ),
			'new_item'              => __( 'New Feedback', 'asvz' ),
			'edit_item'             => __( 'Edit Feedback', 'asvz' ),
			'view_item'             => __( 'View Feedback', 'asvz' ),
			'all_items'             => __( 'Feedbacks', 'asvz' ),
			'search_items'          => __( 'Search Feedbacks', 'asvz' ),
			'parent_item_colon'     => __( 'Parent Feedbacks:', 'asvz' ),
			'not_found'             => __( 'No Feedbacks found.', 'asvz' ),
			'not_found_in_trash'    => __( 'No Feedbacks found in Trash.', 'asvz' ),
			'featured_image'        => _x( 'Feedback Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'asvz' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'archives'              => _x( 'Feedback archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'asvz' ),
			'insert_into_item'      => _x( 'Insert into Feedback', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'asvz' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this Feedback', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'asvz' ),
			'filter_items_list'     => _x( 'Filter Feedbacks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'asvz' ),
			'items_list_navigation' => _x( 'Feedbacks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'asvz' ),
			'items_list'            => _x( 'Feedbacks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'asvz' ),
		];

		$args = [
			'labels'       => $labels,
			'menu_icon'    => 'dashicons-admin-comments',
			'show_ui'      => true,
			'show_in_menu' => 'edit.php?post_type=cleaning_task',
			'supports'     => array( 'title' ),
		];

		register_post_type( 'cleaning_feedback', $args );
	}
}

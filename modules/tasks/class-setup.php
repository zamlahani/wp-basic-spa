<?php
/**
 * Setting up backend
 *
 * @package ASVZ
 */

namespace Asvz\Tasks;

use Asvz\Tasks\Helpers\Category;
use Asvz\Tasks\Helpers\Task;

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
		add_action( 'acf/init', [ $this, 'set_options_page' ] );
		add_action( 'init', [ $this, 'setup_post_types' ] );
		add_action( 'init', [ $this, 'setup_taxonomies' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enable_post_type_order' ], 5 );

		// custom column.
		add_filter( 'manage_cleaning_task_posts_columns', [ $this, 'task_columns' ] );
		add_action( 'manage_cleaning_task_posts_custom_column', [ $this, 'task_column_values' ], 10, 2 );

		// sortable column.
		add_filter( 'manage_edit-cleaning_task_sortable_columns', [ $this, 'make_sortable_category_column' ] );

		// filter.
		add_action( 'restrict_manage_posts', [ $this, 'add_category' ] );
		add_filter( 'parse_query', [ $this, 'manage_query' ] );
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
				'menu_slug'   => 'cleaning-task-settings',
				'parent_slug' => 'edit.php?post_type=cleaning_task',
			]
		);
	}

	/**
	 * Setup necessary post types.
	 */
	public function setup_post_types() {
		$labels = [
			'name'                  => _x( 'Tasks', 'Post type general name', 'asvz' ),
			'singular_name'         => _x( 'Task', 'Post type singular name', 'asvz' ),
			'menu_name'             => _x( 'Tasks', 'Admin Menu text', 'asvz' ),
			'name_admin_bar'        => _x( 'Tasks', 'Add New on Toolbar', 'asvz' ),
			'add_new'               => __( 'Add New', 'asvz' ),
			'add_new_item'          => __( 'Add New Task', 'asvz' ),
			'new_item'              => __( 'New Task', 'asvz' ),
			'edit_item'             => __( 'Edit Task', 'asvz' ),
			'view_item'             => __( 'View Task', 'asvz' ),
			'all_items'             => __( 'All Tasks', 'asvz' ),
			'search_items'          => __( 'Search Tasks', 'asvz' ),
			'parent_item_colon'     => __( 'Parent Tasks:', 'asvz' ),
			'not_found'             => __( 'No Tasks found.', 'asvz' ),
			'not_found_in_trash'    => __( 'No Tasks found in Trash.', 'asvz' ),
			'featured_image'        => _x( 'Task Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'asvz' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'asvz' ),
			'archives'              => _x( 'Task archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'asvz' ),
			'insert_into_item'      => _x( 'Insert into Task', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'asvz' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this Task', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'asvz' ),
			'filter_items_list'     => _x( 'Filter Tasks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'asvz' ),
			'items_list_navigation' => _x( 'Tasks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'asvz' ),
			'items_list'            => _x( 'Tasks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'asvz' ),
		];

		$args = [
			'labels'    => $labels,
			'menu_icon' => 'dashicons-list-view',
			'show_ui'   => true,
			'supports'  => array( 'title' ),
		];

		register_post_type( 'cleaning_task', $args );
	}

	/**
	 * Setup taxonomies
	 */
	public function setup_taxonomies() {
		$labels = [
			'name'              => _x( 'Categories', 'taxonomy general name', 'asvz' ),
			'singular_name'     => _x( 'Category', 'taxonomy singular name', 'asvz' ),
			'search_items'      => __( 'Search Categories', 'asvz' ),
			'all_items'         => __( 'All Categories', 'asvz' ),
			'parent_item'       => __( 'Parent Category', 'asvz' ),
			'parent_item_colon' => __( 'Parent Category:', 'asvz' ),
			'edit_item'         => __( 'Edit Category', 'asvz' ),
			'update_item'       => __( 'Update Category', 'asvz' ),
			'add_new_item'      => __( 'Add New Category', 'asvz' ),
			'new_item_name'     => __( 'New Category Name', 'asvz' ),
			'menu_name'         => __( 'Categories', 'asvz' ),
		];

		$args = [
			'labels'            => $labels,
			'description'       => __( "Cleaning task's categories", 'asvz' ),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_admin_column' => false,
			'hierarchical'      => true,
			'meta_box_cb'       => false,
		];

		register_taxonomy( 'task_category', 'cleaning_task', $args );
	}

	/**
	 * Manage task's columns
	 *
	 * @param array $columns The columns.
	 */
	public function task_columns( $columns ) {
		$columns['category'] = __( 'Category', 'asvz' );

		return $columns;
	}

	/**
	 * Manage task's column values
	 *
	 * @param array $column The column.
	 * @param int   $post_id The post ID.
	 */
	public function task_column_values( $column, $post_id ) {
		switch ( $column ) {
			case 'category':
				$link     = '';
				$category = get_field( 'category', $post_id );

				if ( is_numeric( $category ) ) {
					$category = absint( $category );
					$category = get_term( $category );
				}

				if ( $category ) {
					unset(
						$category->term_group,
						$category->parent,
						$category->filter,
						$category->term_taxonomy_id,
						$category->taxonomy
					);

					$edit_url = admin_url( 'term.php?taxonomy=task_category&tag_ID=' . $category->term_id . '&post_type=cleaning_task' );
					$link     = '<a href="' . esc_url( $edit_url ) . '">' . esc_html( $category->name ) . '</a>';
				}

				echo $link;

				break;
			case 'referred':
				$email          = get_post_meta( $post_id, 'referred_user__email', true );
				$has_registered = get_post_meta( $post_id, 'referred_user__registered', true );
				$referred       = $has_registered ? get_user_by( 'email', $email ) : $email;

				if ( $referred && is_object( $referred ) ) {
					$display_name = $referred->first_name ? $referred->first_name : ( $referred->display_name ? $referred->display_name : $referred->user_email );
					$edit_url     = admin_url( 'user-edit.php?user_id=' ) . $referred->ID;
					$referred     = '<a href="' . esc_url( $edit_url ) . '">' . esc_html( $display_name ) . '</a>';
				}

				echo $referred; // phpcs:ignore -- is ok.
				break;
			case 'referred_status':
				$has_registered    = get_post_meta( $post_id, 'referred_user__registered', true );
				$has_played_game   = get_post_meta( $post_id, 'referred_user__played_game', true );
				$has_finished_game = get_post_meta( $post_id, 'referred_user__finished_game', true );

				echo esc_html( $has_finished_game ? __( 'Has finished the game', 'fastforward' ) : ( $has_played_game ? __( 'Has played the game', 'fastforward' ) : ( $has_registered ? __( 'Has been registered', 'fastforward' ) : '-' ) ) );
				break;
		}
	}

	/**
	 * Turn category column to be sortable.
	 *
	 * @param array $columns The available columns.
	 * @return array
	 */
	public function make_sortable_category_column( $columns ) {
		$columns['category'] = 'category';
		return $columns;
	}

	/**
	 * Add category filter
	 */
	public function add_category() {
		global $wpdb, $table_prefix;

		$post_type = ( isset( $_GET['post_type'] ) ) ? sanitize_text_field( $_GET['post_type'] ) : 'post';

		// only add filter to post type you want.
		if ( 'cleaning_task' === $post_type ) {
			$categories = Category::all();

			// give a unique name in the select field.
			?>
			<select name="category">
				<option value="">All Categories</option>

				<?php
				$current_cat_id = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : ''; // phpcs:ignore
				$current_cat_id = absint( $current_cat_id );

				foreach ( $categories as $category ) {
					?>
					<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $category->term_id, $current_cat_id ); ?>><?php echo esc_html( $category->name ); ?></option>';
					<?php
				}
				?>
			</select>
			<?php
		}
	}

	/**
	 * Manage query
	 *
	 * @param object $query The query.
	 */
	public function manage_query( $query ) {
		global $pagenow;

		$post_type = ( isset( $_GET['post_type'] ) ) ? sanitize_text_field( $_GET['post_type'] ) : 'post';

		if ( 'cleaning_task' === $post_type && 'edit.php' === $pagenow && isset( $_GET['category'] ) && ! empty( $_GET['category'] ) ) {
			$category_id = absint( sanitize_text_field( $_GET['category'] ) );

			$query->set( 'meta_key', 'category' );
			$query->set( 'meta_value', $category_id );
		}
	}

	/**
	 * This function exists because "post-types-order" plugin disable
	 * the functionality when there's post_status filter.
	 */
	public function enable_post_type_order() {
		if ( ! isset( $_GET['post_status'] ) ) {
			return;
		}

		unset( $_GET['post_status'] );
	}
}

<?php
/**
 * Task helper
 *
 * @since      1.0.0
 *
 * @package    Asvz
 */

namespace Asvz\Tasks\Helpers;

/**
 * Task helper class
 *
 * @since      1.0.0
 * @package    Asvz
 */
class Task extends Base {
	/**
	 * Item's id
	 *
	 * @var int
	 */
	protected $id = -1;

	/**
	 * Item's container
	 *
	 * @var array
	 */
	protected $item = [];

	/**
	 * Class constructor
	 *
	 * @param object|int $post The post object or ID to be set as default.
	 */
	public function __construct( $post = 0 ) {
		parent::__construct();

		$post = $this->get_post_param( $post );

		if ( ! $post ) {
			return;
		}

		$this->id++;

		$this->item[ $this->id ] = [];

		$this->item[ $this->id ]['post_id'] = $post->ID;
		$this->item[ $this->id ]['post']    = $post;
	}

	/**
	 * Get a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return object Modified post object.
	 */
	public function get_item( $task_id ) {
		$task = get_post( $task_id );
		$task = $this->modify_post_object( $task );

		return $task;
	}

	/**
	 * Get all tasks
	 *
	 * @return array Array of modified post objects.
	 */
	public function get_all() {
		$posts = get_posts(
			[
				'post_type'      => 'cleaning_task',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
			]
		);

		if ( ! $posts ) {
			return [];
		}

		foreach ( $posts as &$post ) {
			$post = $this->modify_post_object( $post );
		}

		return $posts;
	}

	/**
	 * Modify post object
	 *
	 * @param object $task The post to modify.
	 */
	public function modify_post_object( $task ) {
		$task->category              = get_field( 'category', $task->ID );
		$task->frequency             = get_field( 'frequency', $task->ID );
		$task->slide_image           = get_field( 'slide_image', $task->ID );
		$task->slide_image           = $task->slide_image && isset( $task->slide_image['url'] ) ? $task->slide_image['url'] : '';
		$task->cover_type            = absint( get_field( 'cover_type', $task->ID ) );
		$task->cover_image           = get_field( 'cover_image', $task->ID );
		$task->cover_image           = $task->cover_image && isset( $task->cover_image['url'] ) ? $task->cover_image['url'] : '';
		$task->cover_video           = get_field( 'cover_video', $task->ID );
		$task->cover_video_thumbnail = get_field( 'cover_video_thumbnail', $task->ID );
		$task->cover_video_thumbnail = $task->cover_video_thumbnail ? $task->cover_video_thumbnail['url'] : '';
		$task->cover_embed           = get_field( 'embed_snippet', $task->ID );
		$task->materials             = get_field( 'materials', $task->ID );

		$task = $this->unset_post_props( $task );

		if ( $task->category ) {
			unset(
				$task->category->term_group,
				$task->category->parent,
				$task->category->filter,
				$task->category->term_taxonomy_id,
				$task->category->taxonomy
			);
		}

		if ( property_exists( $task, 'steps' ) ) {
			foreach ( $task->steps as &$step ) {
				$step->image    = $step->image && is_array( $step->image ) ? $step->image['url'] : '';
				$step->material = $step->material ? $this->unset_post_props( $step->material ) : '';
				$step           = $this->unset_post_props( $step );
			}
		}

		return $task;
	}

	/**
	 * Static utility to get a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return object A modified post object.
	 */
	public static function get( $task_id ) {
		$task_helper = new Task();
		return $task_helper->get_item( $task_id );
	}

	/**
	 * Static utility to get all tasks
	 *
	 * @return array Array of modified post objects.
	 */
	public static function all() {
		$task = new Task();
		return $task->get_all();
	}
}

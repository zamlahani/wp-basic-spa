<?php
/**
 * Feedback helper
 *
 * @since      1.0.0
 *
 * @package    Asvz
 */

namespace Asvz\Feedback\Helpers;

/**
 * Feedback helper class
 *
 * @since      1.0.0
 * @package    Asvz
 */
class Feedback extends Base {
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
	 * Get a feedback
	 *
	 * @param int|object $feedback_id The post ID.
	 * @return object Modified post object.
	 */
	public function get_item( $feedback_id ) {
		$feedback = get_post( $feedback_id );
		$feedback = $this->modify_post_object( $feedback );

		return $feedback;
	}

	/**
	 * Get all feedbacks
	 *
	 * @return array Array of modified post objects.
	 */
	public function get_all() {
		$posts = get_posts(
			[
				'post_type'      => 'cleaning_feedback',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
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
	 * @param object $feedback The post to modify.
	 */
	public function modify_post_object( $feedback ) {
		$feedback->task_id = get_field( 'task_id', $feedback->ID );
		$feedback->review  = get_field( 'review', $feedback->ID );
		$feedback->rating  = get_field( 'rating', $feedback->ID );

		$feedback = $this->unset_post_props( $feedback );

		return $feedback;
	}

	/**
	 * Static utility to get a feedback
	 *
	 * @param int|object $feedback_id The post ID.
	 * @return object A modified post object.
	 */
	public static function get( $feedback_id ) {
		$feedback_helper = new Feedback();
		return $feedback_helper->get_item( $feedback_id );
	}

	/**
	 * Static utility to get all feedbacks
	 *
	 * @return array Array of modified post objects.
	 */
	public static function all() {
		$feedback = new Feedback();
		return $feedback->get_all();
	}
}

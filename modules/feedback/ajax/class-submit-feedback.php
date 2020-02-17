<?php
/**
 * Submit Feedback
 *
 * @since   1.0.0
 * @package Asvz
 */

namespace Asvz\Feedback\Ajax;

use Asvz\Feedback\Helpers\Feedback;
use Asvz\Tasks\Helpers\Task;

/**
 * Class to handle submit feedback
 */
class Submit_Feedback {
	/**
	 * Available fields
	 *
	 * @var array
	 */
	private $fields = [ 'task_id', 'review', 'rating' ];

	/**
	 * Required fields
	 *
	 * @var array
	 */
	private $required = [ 'task_id', 'review', 'rating' ];

	/**
	 * Nonce
	 *
	 * @var string
	 */
	private $nonce;

	/**
	 * Construct
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
		add_action( 'wp_ajax_submit_feedback', [ $this, 'ajax' ], 1 );
		add_action( 'wp_ajax_nopriv_submit_feedback', [ $this, 'ajax' ], 1 );
	}

	/**
	 * The flow.
	 */
	public function ajax() {
		$this->sanitize();
		$this->validate();
		$this->save();
	}

	/**
	 * Sanitize
	 */
	private function sanitize() {
		// phpcs:disable -- is ok
		$this->nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : false;

		// data.
		foreach ( $this->fields as $field ) {
			$_POST[ $field ] = isset( $_POST[ $field ] ) ? sanitize_text_field( $_POST[ $field ] ) : '';
			$_POST[ $field ] = 'task_id' === $field ? absint( $_POST[ $field ] ) : $_POST[ $field ];
		}
		// phpcs:enable
	}

	/**
	 * Validation list:
	 * - Check if nonce is invalid
	 * - Check if fields are empty
	 *
	 * @return void
	 */
	private function validate() {
		$nonce_is_correct = wp_verify_nonce( $this->nonce, 'ASVZ_Submit_Feedback' );

		// check if nonce is invalid.
		if ( ! $nonce_is_correct ) {
			wp_send_json_error( __( 'Wrong token', 'gbs' ) );
		}

		// check if fields are empty.
		foreach ( $this->required as $field ) {
			if ( ! isset( $_POST[ $field ] ) || ! $_POST[ $field ] ) {
				$field_name = str_ireplace( '_', ' ', $field );
				$field_name = ucfirst( $field_name );

				wp_send_json_error( $field_name . __( ' is empty', 'gbs' ) );
			}
		}
	}

	/**
	 * Save into post
	 */
	private function save() {
		$task_id = $_POST['task_id'];
		$task    = Task::get( $task_id );
		$review  = $_POST['review'];
		$rating  = $_POST['rating'];
		$time    = current_time( 'mysql' );

		$post_id = wp_insert_post(
			[
				'post_date'   => $time,
				'post_type'   => 'cleaning_feedback',
				'post_title'  => wp_strip_all_tags( 'Feedback on ' . $task->post_title . ' task' ),
				'post_status' => 'publish',
				'post_author' => 1,
				'meta_input'  => [
					'task_id' => $task_id,
					'review'  => $review,
					'rating'  => $rating,
				],
			]
		);

		wp_send_json_success( get_field( 'cleaning_feedback__success_message', 'option' ) );
	}
}

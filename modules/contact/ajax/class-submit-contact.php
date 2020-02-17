<?php
/**
 * Submit Contact
 *
 * @since   1.0.0
 * @package Asvz
 */

namespace Asvz\Contact\Ajax;

/**
 * Class to handle submit contact
 */
class Submit_Contact {
	/**
	 * Available fields
	 *
	 * @var array
	 */
	private $fields = [ 'name', 'email', 'subject', 'body' ];

	/**
	 * Required fields
	 *
	 * @var array
	 */
	private $required = [ 'name', 'email', 'subject', 'body' ];

	/**
	 * Nonce
	 *
	 * @var string
	 */
	private $nonce;

	/**
	 * Setup actions & filters
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_ajax_submit_contact', [ $this, 'ajax' ], 1 );
		add_action( 'wp_ajax_nopriv_submit_contact', [ $this, 'ajax' ], 1 );
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
		}
		// phpcs:enable
	}

	/**
	 * Validation list:
	 * - Check if nonce is invalid
	 * - Check if fields are empty
	 * - Check if email format is invalid
	 *
	 * @return void
	 */
	private function validate() {
		$nonce_is_correct = wp_verify_nonce( $this->nonce, 'ASVZ_Submit_Contact' );

		// Check if nonce is invalid.
		if ( ! $nonce_is_correct ) {
			wp_send_json_error( __( 'Wrong token', 'gbs' ) );
		}

		// Check if fields are empty.
		foreach ( $this->required as $field ) {
			if ( ! isset( $_POST[ $field ] ) || ! $_POST[ $field ] ) {
				$field_name = str_ireplace( '_', ' ', $field );
				$field_name = ucfirst( $field_name );

				wp_send_json_error( $field_name . __( ' is empty', 'gbs' ) );
			}
		}

		// Check if email format is invalid.
		if ( ! is_email( $_POST['email'] ) ) {
			wp_send_json_error( __( 'Email format is invalid', 'gbs' ) );
		}
	}

	/**
	 * Get recipient email
	 *
	 * @return string Recipient email.
	 */
	public function get_recipient_email() {
		$recipient_type  = get_field( 'cleaning_contact__destination__recipient_type', 'option' );
		$recipient_type  = absint( $recipient_type );
		$recipient_email = get_option( 'admin_email' );

		switch ( $recipient_type ) {
			case 1:
				$recipient_user  = get_field( 'cleaning_contact__destination__recipient_user', 'option' );
				$recipient_email = ! empty( $recipient_user ) && property_exists( $recipient_user, 'user_email' ) ? $recipient_user->user_email : $recipient_email;
				break;

			case 2:
				$recipient_email = get_field( 'cleaning_contact__destination__recipient_email', 'option' );
				break;
			default:
				// code...
				break;
		}

		return $recipient_email;
	}

	/**
	 * Save into post
	 */
	private function save() {
		$input_name    = $_POST['name'];
		$input_email   = $_POST['email'];
		$input_subject = $_POST['subject'];
		$input_body    = $_POST['body'];

		$recipient = $this->get_recipient_email();
		$subject   = get_field( 'cleaning_contact__email__subject', 'option' );
		$body      = get_field( 'cleaning_contact__email__body', 'option' );

		$post_id = wp_insert_post(
			[
				'post_date'    => current_time( 'mysql' ),
				'post_type'    => 'cleaning_contact',
				'post_title'   => wp_strip_all_tags( 'Contact submission from ' . $input_name ),
				'post_content' => '',
				'post_status'  => 'publish',
				'post_author'  => 1,
				'meta_input'   => [
					'name'    => $input_name,
					'email'   => $input_email,
					'subject' => $input_subject,
					'body'    => $input_body,
				],
			]
		);

		$find = [
			'{name}',
			'{email}',
			'{subject}',
			'{body}',
			'{detail_link}',
		];

		$replacement = [
			$input_name,
			$input_email,
			$input_subject,
			$input_body,
			admin_url( 'post.php?post=' . $post_id . '&action=edit' ),
		];

		$subject = str_ireplace( $find, $replacement, $subject );
		$body    = str_ireplace( $find, $replacement, $body );

		wp_mail( $recipient, $subject, $body );

		wp_send_json_success( get_field( 'cleaning_contact__success_message', 'option' ) );
	}
}

<?php
/**
 * Step helper
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
class Step extends Base {
	/**
	 * Get all task IDs
	 *
	 * @return array Array of all task IDs.
	 */
	public function get_all_task_ids() {
		$ids = get_posts(
			[
				'post_type'      => 'cleaning_task',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			]
		);

		return $ids;
	}

	/**
	 * Get steps of a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return object Step object.
	 */
	public function get_item( $task_id ) {
		$steps = get_field( 'steps', $task_id );

		if ( ! empty( $steps ) && is_array( $steps ) ) {
			foreach ( $steps as &$step ) {
				$step['image'] = $step['image'] && is_array( $step['image'] ) ? $step['image']['sizes']['medium_rectangle'] : '';
			}
		}

		$celebratory = $this->get_celebratory_data( $task_id );
		$intro       = $this->get_intro_data( $task_id );

		return [
			'task_id'     => $task_id,
			'intro'       => [
				'header' => $intro['header'],
				'body'   => $intro['body'],
				'footer' => $intro['footer'],
			],
			'steps'       => $steps,
			'celebratory' => [
				'image' => $celebratory['image'],
				'text'  => $celebratory['text'],
			],
		];
	}

	/**
	 * Get intro data of a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return array Intro data.
	 */
	public function get_intro_data( $task_id ) {
		/* 	OLD CODE
		$header = get_field( 'steps_intro__header', $task_id );
		$header = $header ? $header : get_field( 'steps_intro__header', 'option' );
		$body   = get_field( 'steps_intro__body', $task_id );
		$body   = $body ? $body : get_field( 'steps_intro__body', 'option' );
		$footer = get_field( 'steps_intro__footer', $task_id );
		$footer = $footer ? $footer : get_field( 'steps_intro__footer', 'option' ); */

		$header = get_field('steps_intro__header', 'option');
		$body   = get_field('steps_intro__body', 'option');
		$footer = get_field( 'steps_intro__footer', 'option' );
		
		return [
			'header' => $header,
			'body'   => $body,
			'footer' => $footer,
		];
	}

	/**
	 * Get celebratory data of a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return array Celebratory data.
	 */
	public function get_celebratory_data($task_id)
	{
		/*	OLD
		$text = get_field( 'steps_celebratory__text', $task_id );
		$text = $text ? $text : get_field( 'steps_celebratory__text', 'option' );

		$image = get_field( 'steps_celebratory__image', $task_id );
		$image = isset( $image['sizes'] ) && isset( $image['sizes']['medium_rectangle'] ) ? $image['sizes']['medium_rectangle'] : '';

		if ( ! $image ) {
			$image = get_field( 'steps_celebratory__image', 'option' );
			$image = isset( $image['sizes'] ) && isset( $image['sizes']['medium_rectangle'] ) ? $image['sizes']['medium_rectangle'] : '';
		} */

		$text = get_field('steps_celebratory__text', 'option');
		$image = get_field('steps_celebratory__image', 'option');
		$image = isset($image['sizes']) && isset($image['sizes']['medium_rectangle']) ? $image['sizes']['medium_rectangle'] : '';

		return [
			'image' => $image,
			'text'  => $text,
		];
	}

	/**
	 * Get steps of all tasks
	 *
	 * @return array Array of step objects.
	 */
	public function get_all() {
		$ids = $this->get_all_task_ids();

		if ( ! $ids ) {
			return [];
		}

		$steps = [];

		foreach ( $ids as $id ) {
			array_push( $steps, $this->get_item( $id ) );
		}

		return $steps;
	}

	/**
	 * Static utility to get steps of a task
	 *
	 * @param int|object $task_id The post ID.
	 * @return object Step object.
	 */
	public static function get( $task_id ) {
		$step_helper = new Step();
		return $step_helper->get_item( $task_id );
	}

	/**
	 * Static utility to get steps of all tasks
	 *
	 * @return array Array of step objects.
	 */
	public static function all() {
		$step_helper = new Step();
		return $step_helper->get_all();
	}
}

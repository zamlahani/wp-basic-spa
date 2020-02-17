<?php
/**
 * Category helper
 *
 * @package ASVZ
 */

namespace Asvz\Tasks\Helpers;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Category helper class
 */
class Category extends Base {
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
	 * @param object|int $term The term object or ID to be set as default.
	 */
	public function __construct( $term = 0 ) {
		parent::__construct();

		$term = $this->get_term_param( $term );

		if ( ! $term ) {
			return;
		}

		$this->id++;

		$id = $this->id;

		$this->item[ $id ] = [];

		$this->item[ $id ]['term_id'] = $term_id;
		$this->item[ $id ]['term']    = get_term( $term_id );
	}

	/**
	 * Get a category
	 *
	 * @param int|object $term_id The term id.
	 * @return array Modified term object.
	 */
	public function get_item( $term_id ) {
		$term = get_term( $term_id );
		$term = $this->modify_term_object( $term );

		return $term;
	}

	/**
	 * Get all categories
	 *
	 * @return array Array of modified term objects.
	 */
	public function get_all() {
		$terms = get_terms(
			[
				'taxonomy'   => 'task_category',
				'hide_empty' => false,
			]
		);

		if ( ! $terms ) {
			return [];
		}

		foreach ( $terms as &$term ) {
			$term = $this->modify_term_object( $term );
		}

		return $terms;
	}

	/**
	 * Modify term object
	 *
	 * @param object $term The term to modify.
	 */
	public function modify_term_object( $term ) {
		$term->icon = get_field( 'icon', 'task_category_' . $term->term_id );
		$term->icon = isset( $term->icon['sizes'] ) && isset( $term->icon['sizes']['thumbnail'] ) ? $term->icon['sizes']['thumbnail'] : '';

		$term->header_image = get_field( 'header_image', 'task_category_' . $term->term_id );
		$term->header_image = isset( $term->header_image['sizes'] ) && isset( $term->header_image['sizes']['medium_rectangle'] ) ? $term->header_image['sizes']['medium_rectangle'] : '';

		$term->bg_color = get_field( 'bg_color', 'task_category_' . $term->term_id );
		$term->bg_color = ! $term->bg_color ? '#044488' : $term->bg_color;
		$term->tips     = get_field( 'category_tips', 'task_category_' . $term->term_id );
		$term->tips     = ! $term->tips ? [] : $term->tips;

		unset(
			$term->term_group,
			$term->parent,
			$term->filter,
			$term->term_taxonomy_id,
			$term->taxonomy
		);

		return $term;
	}

	/**
	 * Static utility to get a category
	 *
	 * @param int|object $term_id The term id.
	 * @return object A term object.
	 */
	public static function get( $term_id ) {
		$category_helper = new Category();
		return $category_helper->get_item( $term_id );
	}

	/**
	 * Static utility to get all categories
	 *
	 * @return array Array of term objects.
	 */
	public static function all() {
		$category_helper = new Category();
		return $category_helper->get_all();
	}
}

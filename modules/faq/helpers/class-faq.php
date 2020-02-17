<?php
/**
 * FAQ helper
 *
 * @since      1.0.0
 *
 * @package    Asvz
 */

namespace Asvz\Faq\Helpers;

/**
 * FAQ helper class
 *
 * @since      1.0.0
 * @package    Asvz
 */
class Faq extends Base {
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
	 * Get a faq
	 *
	 * @param int|object $faq_id The post ID.
	 * @return object Modified post object.
	 */
	public function get_item( $faq_id ) {
		$faq = get_post( $faq_id );
		$faq = $this->modify_post_object( $faq );

		return $faq;
	}

	/**
	 * Get all faqs
	 *
	 * @return array Array of modified post objects.
	 */
	public function get_all() {
		$posts = get_posts(
			[
				'post_type'      => 'cleaning_faq',
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
	 * @param object $faq The post to modify.
	 */
	public function modify_post_object( $faq ) {
		$faq = $this->unset_post_props( $faq );

		$faq->post_content = apply_filters( 'the_content', $faq->post_content );

		return $faq;
	}

	/**
	 * Static utility to get an faq
	 *
	 * @param int|object $faq_id The post ID.
	 * @return object A modified post object.
	 */
	public static function get( $faq_id ) {
		$faq_helper = new Faq();
		return $faq_helper->get_item( $faq_id );
	}

	/**
	 * Static utility to get all faqs
	 *
	 * @return array Array of modified post objects.
	 */
	public static function all() {
		$faq = new Faq();
		return $faq->get_all();
	}
}

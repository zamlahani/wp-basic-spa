<?php
/**
 * Material helper
 *
 * @since      1.0.0
 *
 * @package    Asvz
 */

namespace Asvz\Material\Helpers;

/**
 * Material helper class
 *
 * @since      1.0.0
 * @package    Asvz
 */
class Material extends Base {
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
	 * Get a material
	 *
	 * @param int|object $material_id The post ID.
	 * @return object Modified post object.
	 */
	public function get_item( $material_id ) {
		$material = get_post( $material_id );
		$material = $this->modify_post_object( $material );

		return $material;
	}

	/**
	 * Get all materials
	 *
	 * @return array Array of modified post objects.
	 */
	public function get_all() {
		$posts = get_posts(
			[
				'post_type'      => 'cleaning_material',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'order'          => 'ASC',
				'orderby'        => 'title',
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
	 * @param object $material The post to modify.
	 */
	public function modify_post_object( $material ) {
		$material = $this->unset_post_props( $material );

		$material->thumbnail       = get_the_post_thumbnail_url( $material, 'medium' );
		$material->description     = get_field( 'description', $material->ID );
		$material->product_number  = get_field( 'product_number', $material->ID );
		$material->is_dangerous    = get_field( 'is_dangerous', $material->ID );
		$material->risks           = get_field( 'risks', $material->ID );
		$material->risks           = ! $material->risks ? [] : $material->risks;
		$material->stores          = get_field( 'stores', $material->ID );
		$material->alternatives    = get_field( 'alternatives', $material->ID );
		$material->alternatives    = ! $material->alternatives ? [] : $material->alternatives;
		$material->carousel_images = get_field( 'images', $material->ID );
		$material->carousel_images = ! $material->carousel_images ? [] : $material->carousel_images;
		$material->carousel_images = $this->simplify_carousel_images( $material->carousel_images );

		return $material;
	}

	/**
	 * Simplify the "carousel images" format
	 *
	 * @param array $images The array format from ACF repeater.
	 * @return array $carousel_images The simplified array.
	 */
	public function simplify_carousel_images( $images ) {
		if ( ! is_array( $images ) || empty( $images ) ) {
			return;
		}

		$carousel_images = [];

		foreach ( $images as $image ) {
			array_push(
				$carousel_images,
				[
					'sizes'     => [
						'thumbnail'        => $image['sizes']['thumbnail'],
						'medium'           => $image['sizes']['medium'],
						'medium_square'    => $image['sizes']['medium_square'],
						'medium_rectangle' => $image['sizes']['medium_rectangle'],
						'medium_large'     => $image['sizes']['medium_large'],
						'large'            => $image['sizes']['large'],
					],
					'url'       => $image['url'],
					'title'     => $image['title'],
					'mime_type' => $image['mime_type'],
				]
			);
		}

		return $carousel_images;
	}

	/**
	 * Static utility to get a material
	 *
	 * @param int|object $material_id The post ID.
	 * @return object A modified post object.
	 */
	public static function get( $material_id ) {
		$material_helper = new Material();
		return $material_helper->get_item( $material_id );
	}

	/**
	 * Static utility to get all materials
	 *
	 * @return array Array of modified post objects.
	 */
	public static function all() {
		$material_helper = new Material();
		return $material_helper->get_all();
	}
}

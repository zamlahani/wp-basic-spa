<?php
/**
 * Base functionality
 *
 * @package ASVZ
 */

namespace Asvz\Material\Helpers;

/**
 * Base functionality class
 */
class Base {
	/**
	 * Current module url
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Current module directory
	 *
	 * @var string
	 */
	protected $dir;

	/**
	 * Setup variables
	 */
	public function __construct() {
		$this->url = THEME_URL . '/feedback/helpers';
		$this->dir = THEME_DIR . '/feedback/helpers';
	}

	/**
	 * Determine where the post object/ id should be taken from
	 *
	 * @param  object|int $post Param to check. Accept post object or ID.
	 * @return mixed
	 */
	protected function get_post_param( $post, $return_format = 'object' ) {
		if ( ! $post ) {
			if ( isset( $this->item[ $this->id ] ) ) {
				return ( 'object' === $return_format ? $this->item[ $this->id ]['post'] : $this->item[ $this->id ]['post_id'] );
			} else {
				return ( 'object' === $return_format ? null : 0 );
			}
		} else {
			if ( ! is_object( $post ) || ! property_exists( $post, 'ID' ) ) {
				if ( is_numeric( $post ) ) {
					return ( 'object' === $return_format ? get_post( absint( $post ) ) : absint( $post ) );
				}
			}

			return $post;
		}
	}

	/**
	 * Determine where the term object/ term_id should be taken from
	 *
	 * @param  object|int $term Param to check. Accept term object or term_id.
	 * @return mixed
	 */
	protected function get_term_param( $term, $return_format = 'object' ) {
		if ( ! $term ) {
			if ( isset( $this->item[ $this->id ] ) ) {
				return ( 'object' === $return_format ? $this->item[ $this->id ]['term'] : $this->item[ $this->id ]['term_id'] );
			} else {
				return ( 'object' === $return_format ? null : 0 );
			}
		} else {
			if ( ! is_object( $term ) || ! property_exists( $term, 'term_id' ) ) {
				if ( is_numeric( $term ) ) {
					return ( 'object' === $return_format ? get_term( absint( $term ) ) : absint( $term ) );
				}
			}

			return $term;
		}
	}

	/**
	 * Determine where the user object/ id should be taken from
	 *
	 * @param  object|int $user Param to check. Accept user object or ID.
	 * @return mixed
	 */
	protected function get_user_param( $user, $return_format = 'object' ) {
		if ( ! $user ) {
			if ( isset( $this->item[ $this->id ] ) ) {
				if ( 'object' === $return_format ) {
					if ( ! isset( $this->item[ $this->id ]['user'] ) ) {
						return get_userdata( $this->item[ $this->id ]['user_id'] );
					} else {
						return $this->item[ $this->id ]['user'];
					}
				} else {
					return $this->item[ $this->id ]['user_id'];
				}
			} else {
				return ( 'object' === $return_format ? wp_get_current_user() : get_current_user_id() );
			}
		} else {
			if ( ! is_object( $user ) || ! property_exists( $user, 'ID' ) ) {
				if ( is_numeric( $user ) ) {
					return ( 'object' === $return_format ? get_userdata( absint( $user ) ) : absint( $user ) );
				}
			}

			return $user;
		}
	}

	/**
	 * Unset post object properties
	 *
	 * @param object $post Post object to modify.
	 */
	public function unset_post_props( $post ) {
		unset(
			$post->post_date_gmt,
			$post->post_content,
			$post->post_excerpt,
			$post->post_status,
			$post->comment_status,
			$post->ping_status,
			$post->post_password,
			$post->to_ping,
			$post->pinged,
			$post->post_modified_gmt,
			$post->post_content_filtered,
			$post->post_parent,
			$post->guid,
			$post->menu_order,
			$post->post_type,
			$post->post_mime_type,
			$post->comment_count
		);

		return $post;
	}
}

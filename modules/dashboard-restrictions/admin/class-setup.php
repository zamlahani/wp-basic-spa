<?php
/**
 * Restrict some pages
 *
 * @package ASVZ
 */

namespace BD\Dashboard\Restrictions\Admin;

/**
 * Setup class
 */
class Setup {
	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_filter( 'acf/load_field/key=field_5bbc188c5c8e7', array( $this, 'acf_load_role_selection_field_choices' ) );
	}

	/**
	 * Role selection field.
	 */
	public function acf_load_role_selection_field_choices( $field ) {
		global $wp_roles;

		$all_roles      = $wp_roles->roles;
		$editable_roles = apply_filters( 'editable_roles', $all_roles );
		$select_options = array();

		if ( ! empty( $editable_roles ) ) {
			foreach ( $editable_roles as $role_key => $role ) {
				// Exclude andminitrator and manager from select options.
				if ( 'administrator' !== $role_key && 'manager' !== $role_key ) {
					$select_options[ $role_key ] = $role['name'];
				}
			}
		}

		$field['choices'] = $select_options;
		return $field;
	}
}

new Setup();

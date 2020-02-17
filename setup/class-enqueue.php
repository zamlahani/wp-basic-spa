<?php
/**
 * Setting up enqueue
 *
 * @package ASVZ
 */

namespace BD_Theme\Setup;

use Asvz\Tasks\Helpers\Category;
use Asvz\Tasks\Helpers\Step;
use Asvz\Tasks\Helpers\Task;
use Asvz\Material\Helpers\Material;
use Asvz\Faq\Helpers\Faq;

/**
 * Enqueue class to setup assets enqueue
 */
class Enqueue {
	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'editor_enqueue' ] );

		add_filter( 'style_loader_src', [ $this, 'support_autoversion' ] );
		add_filter( 'script_loader_src', [ $this, 'support_autoversion' ] );

		add_action( 'login_enqueue_scripts', [ $this, 'login_enqueue' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'theme_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_scripts' ] );
	}

	/**
	 * Add autoversion support to style & script's "src"
	 *
	 * @param string $src Non-raw url from style/ script enqueue.
	 * @return string
	 */
	public function support_autoversion( $src ) {
		if ( strpos( $src, 'ver=auto' ) ) {
			$src = remove_query_arg( 'ver', $src );

			if ( false === strpos( $src, BASE_URL ) ) {
				return $src;
			}

			$dir = str_replace( BASE_URL, BASE_DIR, $src );

			if ( ! file_exists( $dir ) ) {
				$last_modifed = '0';
			} else {
				$last_modifed = date( 'YmdHis', filemtime( $dir ) );
			}

			$src = add_query_arg( 'ver', $last_modifed, $src );
		}

		return $src;
	}

	/**
	 * Enqueue all styles & scripts to adjust editor's content
	 *
	 * @return void
	 */
	public function editor_enqueue() {
		add_editor_style( 'assets/css/editor.css' );
	}

	/**
	 * Enqueue all styles and scripts to enhance login screen
	 *
	 * @return void
	 */
	public function login_enqueue() {
		wp_enqueue_style(
			'style',
			THEME_URL . '/assets/css/login.css',
			[],
			'auto'
		);

		wp_enqueue_script(
			'loginjs',
			THEME_URL . '/assets/js/login.js',
			[ 'jquery' ],
			'auto',
			true
		);
	}

	/**
	 * Enqueue all styles and scripts to custom admin style and behaviour
	 *
	 * @return void
	 */
	public function admin_enqueue() {
		// styles.
	}

	/**
	 * Enqueue all style that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_styles() {
		/* wp_enqueue_style(
			'flexdatalist',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.min.css',
			[],
			'auto'
		); */
		wp_enqueue_style(
			'font-awesome',
			THEME_URL . '/assets/font-awesome/css/all.min.css',
			[],
			'auto'
		);
		wp_enqueue_style(
			'owl-carousel',
			THEME_URL . '/assets/owl-carousel/assets/owl.carousel.min.css',
			[],
			'auto'
		);
		wp_enqueue_style(
			'owl-theme',
			THEME_URL . '/assets/owl-carousel/assets/owl.theme.default.min.css',
			[],
			'auto'
		);
		wp_enqueue_style(
			'jquery-ui',
			THEME_URL . '/assets/css/jquery-ui.css',
			[],
			'auto'
		);
		wp_enqueue_style(
            'simplebar',
            'https://cdn.jsdelivr.net/npm/simplebar@4.1.0/dist/simplebar.css',
            [],
            'auto'
        );
		wp_enqueue_style(
			'mcustomscrollbar',
			THEME_URL . '/assets/css/jquery.mCustomScrollbar.css',
			[],
			'auto'
		);
		wp_enqueue_style(
			'style',
			THEME_URL . '/assets/css/style.min.css',
			[ 'mediaelement' ],
			'auto'
		);
	}

	/**
	 * Enqueue all scripts that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_scripts() {
		/* wp_enqueue_script(
			'flexdatalist',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-flexdatalist/2.2.4/jquery.flexdatalist.min.js',
			[ 'jquery' ],
			'auto',
			true
		); */
		wp_enqueue_script(
			'owl-carousel',
			THEME_URL . '/assets/owl-carousel/owl.carousel.min.js',
			[ 'jquery' ],
			'auto',
			true
		);
		wp_enqueue_script(
			'handlebars',
			THEME_URL . '/assets/js/handlebars.js',
			[],
			'auto',
			true
		);
		wp_enqueue_script(
			'jquery-ui',
			THEME_URL . '/assets/js/jquery-ui.js',
			[ 'jquery' ],
			'auto',
			true
		);
		wp_enqueue_script(
            'simplebar',
            'https://cdn.jsdelivr.net/npm/simplebar@4.1.0/dist/simplebar.min.js',
            [],
            'auto',
            true
        );
		wp_enqueue_script(
			'mcustomscrollbar',
			THEME_URL . '/assets/js/jquery.mCustomScrollbar.js',
			[ 'jquery' ],
			'auto',
			true
		);
		wp_enqueue_script(
			'navigo',
			THEME_URL . '/assets/js/navigo.min.js',
			'auto',
			true
		);
		wp_enqueue_script(
			'submit-feedback',
			THEME_URL . '/assets/js/submit-feedback.js',
			[ 'jquery' ],
			'auto',
			true
		);
		wp_enqueue_script(
			'submit-contact',
			THEME_URL . '/assets/js/submit-contact.js',
			[ 'jquery' ],
			'auto',
			true
		);
		// phpcs:ignore -- load in header, after jQuery.
		wp_enqueue_script(
			'tracking',
			THEME_URL . '/assets/js/tracking.js',
			[ 'jquery' ],
			'auto'
		);
		wp_enqueue_script(
			'theme',
			THEME_URL . '/assets/js/theme.js',
			[ 'jquery', 'mediaelement', 'submit-feedback' ],
			'auto',
			true
		);
		/* wp_enqueue_script(
			'search',
			THEME_URL . '/assets/js/search.js',
			[ 'flexdatalist' ],
			'1.0.0',
			true
		); */
		$error_messages = [
			'required'    => __( 'This field is required. Please be sure to check.', 'asvz' ),
			'email'       => __( 'Your E-mail address appears to be invalid. Please be sure to check.', 'asvz' ),
			'number'      => __( 'You can enter only numbers in this field.', 'asvz' ),
			'maxLength'   => __( 'Maximum {count} characters allowed!', 'asvz' ),
			'minLength'   => __( 'Minimum {count} characters allowed!', 'asvz' ),
			'maxChecked'  => __( 'Maximum {count} options allowed. Please be sure to check.', 'asvz' ),
			'minChecked'  => __( 'Please select minimum {count} options.', 'asvz' ),
			'maxSelected' => __( 'Maximum {count} selection allowed. Please be sure to check.', 'asvz' ),
			'minSelected' => __( 'Minimum {count} selection allowed. Please be sure to check.', 'asvz' ),
			'notEqual'    => __( 'Fields do not match. Please be sure to check.', 'asvz' ),
			'different'   => __( 'Fields cannot be the same as each other', 'asvz' ),
			'creditCard'  => __( 'Invalid credit card number. Please be sure to check.', 'asvz' ),
		];

		/* $menu_items = [
			'categories' => [
				'text' => get_field( 'menu__categories__text', 'option' ),
				'icon' => get_field( 'menu__categories__icon', 'option' ),
			],
			'materials'  => [
				'text' => get_field( 'menu__materials__text', 'option' ),
				'icon' => get_field( 'menu__materials__icon', 'option' ),
			],
			'tips'       => [
				'text' => get_field( 'menu__tips__text', 'option' ),
				'icon' => get_field( 'menu__tips__icon', 'option' ),
			],
			'faq'        => [
				'text' => get_field( 'menu__faq__text', 'option' ),
				'icon' => get_field( 'menu__faq__icon', 'option' ),
			],
			'contact'    => [
				'text' => get_field( 'menu__contact__text', 'option' ),
				'icon' => get_field( 'menu__contact__icon', 'option' ),
			],
		]; */

		/* $type_icons = [
			'category' => get_field( 'type_icon__category', 'option' ),
			'task'     => get_field( 'type_icon__task', 'option' ),
			'step'     => get_field( 'type_icon__step', 'option' ),
			'material' => get_field( 'type_icon__material', 'option' ),
			'faq'      => get_field( 'type_icon__faq', 'option' ),
		]; */

		/* foreach ( $type_icons as $key => $value ) {
			if ( $type_icons[ $key ] ) {
				$type_icons[ $key ] = $type_icons[ $key ]['sizes']['thumbnail'];
			}
		} */

		$asvz_objects = [
			'themeUrl'       => THEME_URL,
			/*'ajaxUrl'        => admin_url( 'admin-ajax.php' ),
			'nonces'         => [
				'submit_feedback' => wp_create_nonce( 'ASVZ_Submit_Feedback' ),
				'submit_contact'  => wp_create_nonce( 'ASVZ_Submit_Contact' ),
			],
			'categories'     => Category::all(),
			'materials'      => Material::all(),
			'tasks'          => Task::all(),
			'steps'          => Step::all(),
			'faqs'           => Faq::all(),
			'pages'          => [
				'welcome' => [
					'title'       => get_field( 'welcome_page__title', 'option' ),
					'subtitle'    => get_field( 'welcome_page__subtitle', 'option' ),
					'thumbnail'   => get_field( 'welcome_page__thumbnail', 'option' ),
					'description' => get_field( 'welcome_page__description', 'option' ),
					'cta_button'  => [
						'text' => get_field( 'welcome_page__cta_button__text', 'option' ),
					],
				],
			],
			'feedback_form'  => [
				'intro'       => get_field( 'cleaning_feedback__intro', 'option' ),
				'title'       => get_field( 'cleaning_feedback__title', 'option' ),
				'subtitle'    => get_field( 'cleaning_feedback__subtitle', 'option' ),
				'placeholder' => get_field( 'cleaning_feedback__placeholder', 'option' ),
				'messages'    => [
					'success' => get_field( 'cleaning_feedback__success_message', 'option' ),
				],
			],
			'contact_form'   => [
				'labels'       => [
					'name'    => get_field( 'cleaning_contact__label__name', 'option' ),
					'email'   => get_field( 'cleaning_contact__label__email', 'option' ),
					'subject' => get_field( 'cleaning_contact__label__subject', 'option' ),
					'body'    => get_field( 'cleaning_contact__label__body', 'option' ),
					'button'  => get_field( 'cleaning_contact__label__button', 'option' ),
				],
				'placeholders' => [
					'name'    => get_field( 'cleaning_contact__placeholder__name', 'option' ),
					'email'   => get_field( 'cleaning_contact__placeholder__email', 'option' ),
					'subject' => get_field( 'cleaning_contact__placeholder__subject', 'option' ),
					'body'    => get_field( 'cleaning_contact__placeholder__body', 'option' ),
				],
				'messages'     => [
					'success' => [
						'title'       => get_field( 'cleaning_contact__success_message__title', 'option' ),
						'description' => get_field( 'cleaning_contact__success_message__description', 'option' ),
					],
				],
			],
			'menu_items'     => $menu_items,
			'page_titles'    => [
				'categories' => __( 'Categorieën', 'asvz' ),
				'products'   => __( 'Producten', 'asvz' ),
				'tasks'      => __( 'Takenlijst', 'asvz' ),
				'tips'       => __( 'Tips', 'asvz' ),
				'contact'    => __( 'Contact', 'asvz' ),
				'faq'        => __( 'Veelgestelde vragen', 'asvz' ),
			],
			'general_labels' => [
				'menu_header'        => __( 'Poets!', 'asvz' ),
				'powered_by'         => __( 'Powered By ASVZ', 'asvz' ),
				'search_placeholder' => __( 'Search keyword...', 'asvz' ),
				'tips_title'         => __( 'Poets tips', 'asvz' ),
				'material_needed'    => __( 'Bekijk hier wat je allemaal nodig hebt', 'asvz' ),
				'menu_header'        => __( '', 'asvz' ),
				'completed_material' => __( 'Your material is complete!', 'asvz' ),
			],
			'popup'          => [
				'trigger' => [
					'tips_icon'   => get_field( 'tips_popup__trigger_icon', 'option' ),
					'wizard_icon' => get_field( 'wizard_popup__trigger_icon', 'option' ),
				],
			],
			'type_icons'     => $type_icons,*/
		];

		wp_localize_script(
			'theme',
			'asvzObj',
			$asvz_objects
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

new Enqueue();

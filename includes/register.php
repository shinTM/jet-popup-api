<?php
/**
 * Jet Popup post type template
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Popup_Api_Register' ) ) {

	/**
	 * Define Jet_Popup_Post_Type class
	 */
	class Jet_Popup_Api_Register {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * [$post_type description]
		 * @var string
		 */
		protected $post_type = 'jet-popup';

		/**
		 * Constructor for the class
		 */
		public function __construct() {

			$this->register_taxonomy();
		}

		/**
		 * [register_taxonomy description]
		 * @return [type] [description]
		 */
		public function register_taxonomy() {

			$category_taxonomy_args = [
				'labels'        => [
					'name'          => __( 'Popup Categories', 'jet-popup-api' ),
					'label'         => __( 'Categories', 'jet-popup-api' ),
					'singular_name' => __( 'Category', 'jet-popup-api' ),
					'menu_name'     => __( 'Categories', 'jet-popup-api' ),
				],
				'hierarchical'  => true,
				'rewrite'       => true,
				'query_var'     => true
			];

			register_taxonomy(
				$this->slug() . '_category',
				$this->slug(),
				$category_taxonomy_args
			);

		}

		/**
		 * Returns post type slug
		 *
		 * @return string
		 */
		public function slug() {
			return $this->post_type;
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

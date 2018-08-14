<?php
/**
 * Plugin Name: Jet Popup Api
 * Plugin URI:  http://jetelements.zemez.io/
 * Description: Jet Popup Api
 * Version:     1.0.0
 * Author:      Zemez
 * Author URI:  https://zemez.io/wordpress/
 * Text Domain: jet-elements
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 *
 * @package jet-popup-api
 * @author  Zemez
 * @version 1.0.0
 * @license GPL-2.0+
 * @copyright  2018, Zemez
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

// If class `Jet_Popup_Api` doesn't exists yet.
if ( ! class_exists( 'Jet_Popup_Api' ) ) {

	/**
	 * Sets up and initializes the plugin.
	 */
	class Jet_Popup_Api {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		private $version = '1.0.0';

		/**
		 * Holder for base plugin URL
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_url = null;

		/**
		 * Holder for base plugin path
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    string
		 */
		private $plugin_path = null;

		/**
		 * Sets up needed actions/filters for the plugin to initialize.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function __construct() {

			if ( $this->has_jet_popup() ) {
				return false;
			}

			// Load files.
			add_action( 'after_setup_theme', array( $this, 'init' ), 0 );

			// Register activation  hook.
			register_activation_hook( __FILE__, array( $this, 'activation' ) );

			// Register deactivation hook.
			register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
		}

		/**
		 * Returns plugin version
		 *
		 * @return string
		 */
		public function get_version() {
			return $this->version;
		}

		/**
		 * Check if theme has jet popup
		 *
		 * @return boolean
		 */
		public function has_jet_popup() {
			return class_exists( 'Jet_Popup' );
		}

		/**
		 * Manually init required modules.
		 *
		 * @return void
		 */
		public function init() {

			$this->load_files();

			$this->register = new Jet_Popup_Api_Register();
			$this->api_controller = new Jet_Popup_API_Controller();

			if ( is_admin() ) { }

		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require $this->plugin_path( 'includes/register.php' );
			require $this->plugin_path( 'includes/api-controller.php' );
		}

		/**
		 * Returns path to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_path( $path = null ) {

			if ( ! $this->plugin_path ) {
				$this->plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
			}

			return $this->plugin_path . $path;
		}
		/**
		 * Returns url to file or dir inside plugin folder
		 *
		 * @param  string $path Path inside plugin dir.
		 * @return string
		 */
		public function plugin_url( $path = null ) {

			if ( ! $this->plugin_url ) {
				$this->plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );
			}

			return $this->plugin_url . $path;
		}

		/**
		 * Get the template path.
		 *
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'jet-popup-api/template-path', 'jet-popup-api/' );
		}

		/**
		 * Returns path to template file.
		 *
		 * @return string|bool
		 */
		public function get_template( $name = null ) {

			$template = locate_template( $this->template_path() . $name );

			if ( ! $template ) {
				$template = $this->plugin_path( 'templates/' . $name );
			}

			if ( file_exists( $template ) ) {
				return $template;
			} else {
				return false;
			}
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function activation() {
		}

		/**
		 * Do some stuff on plugin activation
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function deactivation() {
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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

if ( ! function_exists( 'jet_popup_api' ) ) {

	/**
	 * Returns instanse of the plugin class.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	function jet_popup_api() {
		return Jet_Popup_Api::get_instance();
	}
}

jet_popup_api();

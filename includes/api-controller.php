<?php

/**
 * API controller class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Jet_Popup_API_Controller class
 */
class Jet_Popup_API_Controller {

	public $api_namespace = '/croco/v1';

	// Here initialize our namespace and resource name.
	public function __construct() {

		require jet_popup_api()->plugin_path( 'includes/endpoints/base.php' );
		require jet_popup_api()->plugin_path( 'includes/endpoints/endpoint-preset.php' );
		require jet_popup_api()->plugin_path( 'includes/endpoints/endpoint-presets.php' );
		require jet_popup_api()->plugin_path( 'includes/endpoints/endpoint-presets-categories.php' );

		add_action( 'rest_api_init', array( $this, 'register_routes' ) );

	}

	/**
	 * [register_routes description]
	 * @return [type] [description]
	 */
	public function register_routes() {

		$endpoints = [
			new Endpoint_Preset(),
			new Endpoint_Presets(),
			new Endpoint_Presets_Categories(),
		];

		foreach ( $endpoints as $endpoint ) {

			$args = array(
				'methods'  => 'GET',
				'callback' => array( $endpoint, 'callback' ),
			);

			if ( ! empty( $endpoint->get_args() ) ) {
				$args['args'] = $endpoint->get_args();
			}

			$route = '/' . $endpoint->get_name() . '/' . $endpoint->get_query_params();

			register_rest_route( $this->api_namespace, $route, $args );

		}

	}

}

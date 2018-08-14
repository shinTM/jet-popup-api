<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Endpoint_Presets class
 */
class Endpoint_Presets extends Endpoint_Base {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'presets';
	}

	/**
	 * Get query param
	 *
	 * @return [type] [description]
	 */
	public function get_query_params() {
		return false;
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {
		return false;
	}

	/**
	 * Check if is route requires key validation
	 *
	 * @return boolean
	 */
	public function is_private() {
		return false;
	}

	/**
	 * API callback
	 * @return void
	 */
	public function callback( $request ) {

		$plugins  = ['asd'];

		if ( ! is_array( $plugins ) ) {
			$plugins = array();
		}

		if ( ! empty( $plugins ) ) {
			$plugins = array_values( $plugins );
		}

		$result = array(
			'success' => true,
			'plugins' => $plugins,
		);

		return rest_ensure_response( $result );

	}

}

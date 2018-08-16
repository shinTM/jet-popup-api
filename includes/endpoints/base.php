<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Endpoint_Base class
 */
abstract class Endpoint_Base {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	abstract function get_name();

	/**
	 * API callback
	 * @return void
	 */
	abstract function callback( $request );

	/**
	 * Get query param
	 * @return [type] [description]
	 */
	public function get_query_params() {
		return '(?P<type>[a-zA-Z0-9-_]+)';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {
		return array(
			'type' => array(
				'default'  => '',
				'required' => false,
			),
		);
	}

}

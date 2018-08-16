<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Endpoint_Presets_Categories class
 */
class Endpoint_Presets_Categories extends Endpoint_Base {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'presets-categories';
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
	 * API callback
	 * @return void
	 */
	public function callback( $request ) {

		$categories = [];

		$terms = get_terms( [
			'taxonomy'   => jet_popup_api()->register->slug() . '_category',
			'hide_empty' => false,
		] );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $key => $term_data ) {
				$categories[$term_data->slug] = $term_data->name;
			}
		} else {
			return rest_ensure_response( [
				'success' => true,
			] );
		}

		$result = [
			'success'    => true,
			'categories' => $categories,
		];

		return rest_ensure_response( $result );

	}

}

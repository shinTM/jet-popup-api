<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Endpoint_Presets class
 */
class Endpoint_Preset extends Endpoint_Base {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'preset';
	}

	/**
	 * Get query param
	 *
	 * @return [type] [description]
	 */
	public function get_query_params() {
		return '(?P<id>\d+)';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {
		return array(
			'id' => array(
				'default'  => 0,
				'required' => true,
			),
		);
	}

	/**
	 * API callback
	 * @return void
	 */
	public function callback( $request ) {

		$params = $request->get_params();

		$popup_id = isset( $params['id'] ) ? absint( $params['id'] ) : false;

		if ( ! $popup_id ) {

			$result = array(
				'success' => false,
				'message' => __( 'Popup ID is missing', 'jet-popup' ),
			);

			return rest_ensure_response( $result );
		}

		$db = Elementor\Plugin::$instance->db;

		$content = $db->get_builder( $popup_id );

		$export_data = [
			'version' => Elementor\DB::DB_VERSION,
			'title'   => get_the_title( $popup_id ),
		];

		$export_data['content'] = $content;

		if ( get_post_meta( $popup_id, '_elementor_page_settings', true ) ) {

			$page_settings = get_post_meta( $popup_id, '_elementor_page_settings', true );

			if ( ! empty( $page_settings ) ) {
				$export_data['page_settings'] = $page_settings;
			}
		}

		$result = array(
			'success' => true,
			'data'    => json_encode( $export_data ),
		);

		return rest_ensure_response( $result );

	}

}

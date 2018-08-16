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

		// The Query.
		$popup_query = new WP_Query( [
			'post_type'      => jet_popup_api()->register->slug(),
			'order'          => 'DESC',
			'orderby'        => 'date',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		] );

		if ( is_wp_error( $popup_query ) ) {
			$result = [
				'success' => false
			];

			return rest_ensure_response( $result );
		}

		$popups = [];

		if ( $popup_query->have_posts() ) {
			while ( $popup_query->have_posts() ) : $popup_query->the_post();
				$popup_id = $popup_query->post->ID;

				$popup_title = $popup_query->post->post_title;

				$popup_thumbnail = get_the_post_thumbnail_url( $popup_id, 'full' );

				$categories = [];

				$terms = get_the_terms( $popup_id, jet_popup_api()->register->slug() . '_category' );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $key => $term_data ) {
						$categories[] = $term_data->slug;
					}
				}

				$popups[ 'jet-popup-' . $popup_id ] = [
					'id'       => $popup_id,
					'title'    => $popup_title,
					'thumb'    => $popup_thumbnail ? $popup_thumbnail : \Elementor\Utils::get_placeholder_image_src(),
					'category' => $categories
				];
			endwhile;
		}

		$result = array(
			'success' => true,
			'presets' => $popups,
		);

		return rest_ensure_response( $result );

	}

}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Возвращает список [значение => подпись] для price-фильтра — единственного,
 * который не является атрибутом товара, поэтому не тянется из таксономии.
 */
function wh_get_price_filter_ranges() {
	return array(
		'0-90'    => '€0 – €90',
		'90-180'  => '€90 – €180',
		'180-999' => '€180+',
	);
}

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() || ! $query->is_main_query() || ! is_shop() ) {
			return;
		}

		$tax_query = $query->get( 'tax_query' ) ?: array();

		$attribute_filters = array(
			'size'     => 'pa_size',
			'color'    => 'pa_color',
			'material' => 'pa_material',
		);

		foreach ( $attribute_filters as $param => $taxonomy ) {
			if ( empty( $_GET[ $param ] ) ) {
				continue;
			}

			$tax_query[] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => sanitize_title( wp_unslash( $_GET[ $param ] ) ),
			);
		}

		if ( ! empty( $tax_query ) ) {
			$query->set( 'tax_query', $tax_query );
		}

		if ( ! empty( $_GET['price'] ) ) {
			$ranges = wh_get_price_filter_ranges();
			$range  = sanitize_text_field( wp_unslash( $_GET['price'] ) );

			if ( isset( $ranges[ $range ] ) ) {
				list( $min, $max ) = array_map( 'floatval', explode( '-', $range ) );

				$meta_query = $query->get( 'meta_query' ) ?: array();
				$meta_query[] = array(
					'key'     => '_price',
					'value'   => array( $min, $max ),
					'type'    => 'DECIMAL',
					'compare' => 'BETWEEN',
				);
				$query->set( 'meta_query', $meta_query );
			}
		}
	}
);

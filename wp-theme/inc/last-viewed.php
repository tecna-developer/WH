<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WH_LAST_VIEWED_COOKIE', 'wh_last_viewed' );
define( 'WH_LAST_VIEWED_MAX', 4 );

function wh_get_last_viewed_ids() {
	if ( empty( $_COOKIE[ WH_LAST_VIEWED_COOKIE ] ) ) {
		return array();
	}

	$ids = explode( ',', wp_unslash( $_COOKIE[ WH_LAST_VIEWED_COOKIE ] ) );
	return array_filter( array_map( 'absint', $ids ) );
}

// Работает независимо от того, какой шаблон в итоге рендерит одиночный товар
// (сейчас — дефолтный WooCommerce, до фазы «Страница товара»), потому что
// template_redirect срабатывает раньше выбора шаблона.
add_action(
	'template_redirect',
	function () {
		if ( ! is_product() ) {
			return;
		}

		// Не полагаемся на global $product — WooCommerce заполняет его через
		// wc_setup_product_data() на хуке the_post(), который срабатывает
		// внутри цикла шаблона, позже, чем template_redirect.
		$product_id = get_queried_object_id();
		if ( ! $product_id ) {
			return;
		}

		$ids = wh_get_last_viewed_ids();
		$ids = array_diff( $ids, array( $product_id ) );
		array_unshift( $ids, $product_id );
		$ids = array_slice( $ids, 0, WH_LAST_VIEWED_MAX );

		setcookie( WH_LAST_VIEWED_COOKIE, implode( ',', $ids ), time() + MONTH_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN );
	}
);

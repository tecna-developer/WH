<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require get_template_directory() . '/inc/class-wh-nav-walker.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/subscribe.php';
require get_template_directory() . '/inc/catalog-filters.php';
require get_template_directory() . '/inc/last-viewed.php';

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		// Без поддержки штатной галереи (zoom/lightbox/slider) — на странице
		// товара свой переключатель миниатюр (product-detail.js), а не
		// woocommerce_show_product_images().
		add_theme_support( 'woocommerce' );

		register_nav_menus(
			array(
				'menu-desktop'   => __( 'Desktop menu', 'wh' ),
				'menu-mobile'    => __( 'Mobile menu', 'wh' ),
				'footer-info'    => __( 'Footer: Info', 'wh' ),
				'footer-service' => __( 'Footer: Customer service', 'wh' ),
				'footer-useful'  => __( 'Footer: Useful information', 'wh' ),
			)
		);
	}
);

/**
 * Читает build/.vite/manifest.json (собирается `npm run build:theme` /
 * `npm run watch:theme` из vite.theme.config.js) и подключает CSS/JS по их
 * настоящим хешированным именам вместо жёстко прописанных путей.
 */
function wh_enqueue_assets() {
	$manifest_path = get_template_directory() . '/build/.vite/manifest.json';

	if ( ! file_exists( $manifest_path ) ) {
		return;
	}

	$manifest = json_decode( file_get_contents( $manifest_path ), true );
	$entry    = $manifest['src/main.js'] ?? null;

	if ( ! $entry ) {
		return;
	}

	$build_uri = get_template_directory_uri() . '/build/';

	if ( ! empty( $entry['file'] ) ) {
		wp_enqueue_script( 'wh-main', $build_uri . $entry['file'], array(), null, true );
		wp_localize_script(
			'wh-main',
			'whSubscription',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wh_subscribe' ),
			)
		);
	}

	foreach ( $entry['css'] ?? array() as $css_file ) {
		wp_enqueue_style( 'wh-main', $build_uri . $css_file, array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'wh_enqueue_assets' );

function wh_cart_contents_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return WC()->cart->get_cart_contents_count();
}

/**
 * Оба .cart__count (в шапке и в мобильном меню) обновляются этим же
 * фрагментом: jQuery(selector).replaceWith() у wc-cart-fragments заменяет
 * все элементы, подходящие под селектор, а не только первый.
 */
add_filter(
	'woocommerce_add_to_cart_fragments',
	function ( $fragments ) {
		ob_start();
		?>
		<span class="cart__count" data-cart-count aria-hidden="true"><?php echo esc_html( wh_cart_contents_count() ); ?></span>
		<?php
		$fragments['.cart__count'] = trim( ob_get_clean() );
		return $fragments;
	}
);

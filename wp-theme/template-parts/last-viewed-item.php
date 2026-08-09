<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * load_template() в текущем WP не делает extract() для $args из
 * get_template_part() — только $wp_query->query_vars. Поэтому передаём
 * товар через $GLOBALS, а не через args.
 *
 * Сознательно отдельный, более простой компонент, а не content-product.php:
 * тут нет ни названия, ни цены — только картинка и кнопка quick-add.
 */
global $wh_last_viewed_product;

if ( empty( $wh_last_viewed_product ) ) {
	return;
}

$product = $wh_last_viewed_product;
$sizes   = wc_get_product_terms( $product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
$variant = ! empty( $sizes ) ? $sizes[0] : '';
?>
<div class="last-viewed__item">
	<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="last-viewed__bg">
		<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) ); ?>
	</a>
	<button type="button" class="last-viewed__add" data-quick-add
		data-id="<?php echo esc_attr( $product->get_id() ); ?>"
		data-name="<?php echo esc_attr( $product->get_name() ); ?>"
		data-variant="<?php echo esc_attr( $variant ); ?>"
		data-price="<?php echo esc_attr( $product->get_price() ); ?>"
		data-image="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ); ?>"
		aria-label="<?php echo esc_attr( 'Add ' . $product->get_name() . ' to cart' ); ?>">
		<svg width="20" height="20" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
			<path d="M19 36L19 2M36 19L2 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
		</svg>
	</button>
</div>

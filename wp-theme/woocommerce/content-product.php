<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Каноническая карточка — вариант из каталога: у него есть __color,
// __description и __list-extra, которых нет на главной. .product__list-extra
// скрыт в сетке и показывается только в списочном виде (catalog.scss).
$sizes  = wc_get_product_terms( $product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
$colors = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'names' ) );

$variant = ! empty( $sizes ) ? $sizes[0] : '';
$color   = ! empty( $colors ) ? $colors[0] : '';

$description = $product->get_short_description();
if ( ! $description ) {
	$description = wp_trim_words( $product->get_description(), 24 );
}
?>
<div <?php wc_product_class( 'product', $product ); ?>>
	<div class="product__bg">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) ); ?>
		</a>
	</div>
	<footer class="product__footer">
		<h4 class="title__h4">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="product__link"><?php echo esc_html( get_the_title() ); ?></a>
		</h4>
		<button type="button" class="product__add" data-quick-add
			data-id="<?php echo esc_attr( $product->get_id() ); ?>"
			data-name="<?php echo esc_attr( get_the_title() ); ?>"
			data-variant="<?php echo esc_attr( $variant ); ?>"
			data-price="<?php echo esc_attr( $product->get_price() ); ?>"
			data-image="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ); ?>"
			aria-label="<?php echo esc_attr( 'Add ' . get_the_title() . ' to cart' ); ?>">
			<svg width="20" height="20" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"
				aria-hidden="true">
				<path d="M19 36L19 2M36 19L2 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
			</svg>
		</button>
		<div class="product__footer_bottom">
			<p><?php echo esc_html( $variant ); ?></p>
			<p><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
		</div>
		<div class="product__list-extra">
			<?php if ( $description ) : ?>
				<p class="product__description"><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
			<?php if ( $color ) : ?>
				<p class="product__color"><?php echo esc_html( 'Color: ' . $color ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
				data-quantity="1"
				data-product_id="<?php echo esc_attr( $product->get_id() ); ?>"
				data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>"
				class="btn btn-shop product__add-btn add_to_cart_button ajax_add_to_cart"
				aria-label="<?php echo esc_attr( 'Add ' . get_the_title() . ' to cart' ); ?>">Add to cart</a>
		</div>
	</footer>
</div>

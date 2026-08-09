<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

if ( ! $product->is_in_stock() ) {
	echo wp_kses_post( wc_get_stock_html( $product ) );
	return;
}
?>
<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
	method="post" enctype="multipart/form-data">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	<div class="product-detail__actions">
		<div class="product-detail__counter">
			<button type="button" class="product-detail__counter_btn" data-counter-decrease
				aria-label="Decrease quantity">−</button>
			<span class="product-detail__counter_value" data-counter-value>1</span>
			<input type="hidden" name="quantity" value="1" data-counter-input>
			<button type="button" class="product-detail__counter_btn" data-counter-increase
				aria-label="Increase quantity">+</button>
		</div>
		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
			class="btn btn-shop product-detail__add" data-add-to-cart>
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>
	</div>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

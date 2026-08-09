<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<aside class="cart-summary" data-cart-summary>
	<h2 class="cart-summary__title"><?php esc_html_e( 'Order summary', 'woocommerce' ); ?></h2>
	<div class="cart-summary__row">
		<span><?php esc_html_e( 'Subtotal:', 'woocommerce' ); ?></span>
		<span data-cart-subtotal><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>
	<div class="cart-summary__row">
		<span><?php esc_html_e( 'Shipping:', 'woocommerce' ); ?></span>
		<span>
			<?php
			echo WC()->cart->needs_shipping()
				? esc_html__( 'calculated at checkout', 'woocommerce' )
				: esc_html__( 'free shipping', 'woocommerce' );
			?>
		</span>
	</div>
	<div class="cart-summary__row cart-summary__row--total">
		<span><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
		<span data-cart-total><?php wc_cart_totals_order_total_html(); ?></span>
	</div>
	<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-shop cart-summary__checkout"><?php esc_html_e( 'Checkout', 'woocommerce' ); ?></a>
</aside>

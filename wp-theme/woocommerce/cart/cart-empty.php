<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="cart-page__main">
	<p class="cart-page__empty" data-cart-empty>
		<?php esc_html_e( 'Your cart is empty.', 'woocommerce' ); ?>
		<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Continue shopping', 'woocommerce' ); ?></a>
	</p>
</div>

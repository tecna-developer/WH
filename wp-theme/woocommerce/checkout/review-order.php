<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Список строк заказа — те же классы .cart-item__*, что и в cart.php:
// разметка одного и того же понятия «строка товара», незачем заводить
// вторую. woocommerce_checkout_payment() (шлюзы + кнопка place order)
// вызывается отдельно, следом за этим шаблоном, тем же родительским
// действием woocommerce_checkout_order_review — тут её нарочно нет.
?>
<ul class="cart-page__list checkout-summary__list">
	<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

	<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
		<?php
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0
			|| ! apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			continue;
		}

		$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
		$name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
		?>
		<li class="cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
			<div class="cart-item__product">
				<div class="cart-item__thumb"><?php echo wp_kses_post( $thumbnail ); ?></div>
				<div class="cart-item__meta">
					<p class="cart-item__name"><?php echo wp_kses_post( $name ); ?></p>
					<p class="cart-item__variant"><?php echo wp_kses_post( sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) ); ?></p>
				</div>
			</div>
			<p class="cart-item__price">
				<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) ); ?>
			</p>
		</li>
	<?php endforeach; ?>

	<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>
</ul>

<div class="checkout-summary__totals">
	<div class="cart-summary__row">
		<span><?php esc_html_e( 'Subtotal:', 'woocommerce' ); ?></span>
		<span><?php wc_cart_totals_subtotal_html(); ?></span>
	</div>

	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<div class="cart-summary__row cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
			<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
			<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
		<?php wc_cart_totals_shipping_html(); ?>
		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
	<?php else : ?>
		<div class="cart-summary__row">
			<span><?php esc_html_e( 'Shipping:', 'woocommerce' ); ?></span>
			<span><?php esc_html_e( 'free shipping', 'woocommerce' ); ?></span>
		</div>
	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<div class="cart-summary__row fee">
			<span><?php echo esc_html( $fee->name ); ?></span>
			<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
		</div>
	<?php endforeach; ?>

	<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
		<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
			<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
				<div class="cart-summary__row tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span><?php echo esc_html( $tax->label ); ?></span>
					<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="cart-summary__row tax-total">
				<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
				<span><?php wc_cart_totals_taxes_total_html(); ?></span>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

	<div class="cart-summary__row cart-summary__row--total">
		<span><?php esc_html_e( 'Total:', 'woocommerce' ); ?></span>
		<span><?php wc_cart_totals_order_total_html(); ?></span>
	</div>

	<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>

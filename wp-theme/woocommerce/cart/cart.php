<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_cart' );
?>

<div class="container">
	<h1 class="title__h1 cart-page__title"><?php esc_html_e( 'Shopping cart', 'woocommerce' ); ?></h1>
</div>

<section class="cart-page">
	<div class="container">
		<?php if ( WC()->cart->is_empty() ) : ?>

			<?php wc_get_template( 'cart/cart-empty.php' ); ?>

		<?php else : ?>

			<form class="cart-page__wrapper" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<div class="cart-page__main">
					<ul class="cart-page__list" data-cart-list>
						<?php do_action( 'woocommerce_before_cart_contents' ); ?>
						<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) : ?>
							<?php
							$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

							if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0
								|| ! apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								continue;
							}

							$product_permalink = apply_filters(
								'woocommerce_cart_item_permalink',
								$_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
								$cart_item,
								$cart_item_key
							);

							$sizes   = wc_get_product_terms( $_product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
							$colors  = wc_get_product_terms( $_product->get_id(), 'pa_color', array( 'fields' => 'names' ) );
							$variant = trim( implode( ', ', array_filter( array( $sizes[0] ?? '', $colors[0] ?? '' ) ) ) );

							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail' ), $cart_item, $cart_item_key );
							?>
							<li class="cart-item" data-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
								<div class="cart-item__product">
									<div class="cart-item__thumb">
										<?php if ( $product_permalink ) : ?>
											<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $thumbnail ); ?></a>
										<?php else : ?>
											<?php echo wp_kses_post( $thumbnail ); ?>
										<?php endif; ?>
									</div>
									<div class="cart-item__meta">
										<p class="cart-item__name">
											<?php if ( $product_permalink ) : ?>
												<a href="<?php echo esc_url( $product_permalink ); ?>"><?php echo wp_kses_post( $_product->get_name() ); ?></a>
											<?php else : ?>
												<?php echo wp_kses_post( $_product->get_name() ); ?>
											<?php endif; ?>
										</p>
										<?php if ( $variant ) : ?>
											<p class="cart-item__variant"><?php echo esc_html( $variant ); ?></p>
										<?php endif; ?>
									</div>
								</div>
								<div class="cart-item__counter">
									<button type="button" class="cart-item__counter_btn" data-decrease aria-label="Decrease quantity">−</button>
									<span class="cart-item__counter_value" data-counter-value><?php echo esc_html( $cart_item['quantity'] ); ?></span>
									<input type="number" class="screen-reader-text" aria-hidden="true" tabindex="-1"
										name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
										value="<?php echo esc_attr( $cart_item['quantity'] ); ?>" min="0" data-counter-input>
									<button type="button" class="cart-item__counter_btn" data-increase aria-label="Increase quantity">+</button>
								</div>
								<p class="cart-item__price">
									<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) ); ?>
								</p>
								<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="cart-item__remove"
									aria-label="<?php echo esc_attr( sprintf( 'Remove %s from cart', $_product->get_name() ) ); ?>"
									data-product_id="<?php echo esc_attr( $_product->get_id() ); ?>"
									data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>">
									<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M1 1L13 13M13 1L1 13" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round" />
									</svg>
								</a>
							</li>
						<?php endforeach; ?>
						<?php do_action( 'woocommerce_after_cart_contents' ); ?>
					</ul>
					<input type="hidden" name="update_cart" value="1">
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>

				<?php wc_get_template( 'cart/cart-totals.php' ); ?>
			</form>

		<?php endif; ?>
	</div>
</section>

<?php do_action( 'woocommerce_after_cart' ); ?>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	global $product;

	if ( empty( $product ) || ! $product->is_visible() ) {
		continue;
	}

	// Своя галерея вместо штатной WooCommerce (см. functions.php — темой
	// сознательно не заявлена поддержка wc-product-gallery-*): главное фото +
	// миниатюры, переключение — product-detail.js по data-photo/data-main-photo.
	$gallery_ids = array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );
	$gallery_ids = array_values( $gallery_ids );

	$sizes  = wc_get_product_terms( $product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
	$colors = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'names' ) );
	?>

	<div class="container">
		<?php
		woocommerce_breadcrumb(
			array(
				'wrap_before' => '<nav class="breadcrumbs" aria-label="Breadcrumb"><ol class="breadcrumbs__list"><li class="breadcrumbs__item">',
				'wrap_after'  => '</li></ol></nav>',
				'before'      => '',
				'after'       => '',
				'delimiter'   => '</li><li class="breadcrumbs__item" aria-hidden="true">/</li><li class="breadcrumbs__item">',
				'home'        => 'Home',
			)
		);
		?>
	</div>

	<main>
		<section class="product-detail">
			<div class="container">
				<div class="product-detail__wrapper">
					<div class="product-detail__gallery">
						<div class="product-detail__main-photo">
							<?php if ( ! empty( $gallery_ids ) ) : ?>
								<img data-main-photo src="<?php echo esc_url( wp_get_attachment_image_url( $gallery_ids[0], 'woocommerce_single' ) ); ?>"
									alt="<?php echo esc_attr( get_the_title() . ' blanket' ); ?>">
							<?php else : ?>
								<?php echo wp_kses_post( wc_placeholder_img( 'woocommerce_single' ) ); ?>
							<?php endif; ?>
						</div>
						<?php if ( count( $gallery_ids ) > 1 ) : ?>
							<div class="product-detail__thumbs">
								<?php foreach ( $gallery_ids as $index => $image_id ) : ?>
									<button type="button" class="product-detail__thumb<?php echo 0 === $index ? ' is-active' : ''; ?>"
										data-photo="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'woocommerce_single' ) ); ?>"
										aria-label="<?php echo esc_attr( sprintf( 'Show photo %d', $index + 1 ) ); ?>">
										<?php echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail' ); ?>
									</button>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="product-detail__info">
						<div class="product-detail__heading">
							<h1 class="product-detail__name"><?php the_title(); ?></h1>
							<p class="product-detail__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
						</div>
						<div class="product-detail__tabs">
							<?php
							// Реальные вкладки WooCommerce (Description, Additional
							// information, Reviews...), а не 3 захардкоженные — набор
							// зависит от того, что подключено фильтрами.
							$tabs = apply_filters( 'woocommerce_product_tabs', array() );
							if ( ! empty( $tabs ) ) :
								?>
								<div class="product-detail__tablist" role="tablist">
									<?php
									$i = 0;
									foreach ( $tabs as $key => $tab ) :
										++$i;
										?>
										<button type="button" class="product-detail__tab<?php echo 1 === $i ? ' is-active' : ''; ?>"
											role="tab" aria-selected="<?php echo 1 === $i ? 'true' : 'false'; ?>"
											aria-controls="tab-<?php echo esc_attr( $key ); ?>" id="tab-<?php echo esc_attr( $key ); ?>-btn">
											<?php echo esc_html( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ); ?>
										</button>
									<?php endforeach; ?>
								</div>
								<?php
								$i = 0;
								foreach ( $tabs as $key => $tab ) :
									++$i;
									?>
									<div class="product-detail__tabpanel" role="tabpanel" id="tab-<?php echo esc_attr( $key ); ?>"
										aria-labelledby="tab-<?php echo esc_attr( $key ); ?>-btn" <?php echo 1 === $i ? '' : 'hidden'; ?>>
										<?php call_user_func( $tab['callback'], $key, $tab ); ?>
									</div>
								<?php endforeach; ?>
							<?php endif; ?>
						</div>
						<div class="product-detail__details">
							<?php if ( ! empty( $sizes ) ) : ?>
								<p>Size: <strong><?php echo esc_html( implode( ', ', $sizes ) ); ?></strong></p>
							<?php endif; ?>
							<?php if ( ! empty( $colors ) ) : ?>
								<p>Color: <strong><?php echo esc_html( implode( ', ', $colors ) ); ?></strong></p>
							<?php endif; ?>
						</div>
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>
				</div>
			</div>
		</section>

		<?php
		$related_ids = wc_get_related_products( $product->get_id(), 3 );
		if ( ! empty( $related_ids ) ) :
			?>
			<section class="popular product-detail__like">
				<div class="container">
					<h2 class="title__h2 popular__title">You may also like</h2>
					<div class="slider popular__slider">
						<div class="slider_track" data-slider-track>
							<?php
							foreach ( $related_ids as $related_id ) :
								$related_product = wc_get_product( $related_id );
								if ( ! $related_product ) {
									continue;
								}
								$related_sizes = wc_get_product_terms( $related_id, 'pa_size', array( 'fields' => 'names' ) );
								?>
								<div class="product" data-slide>
									<div class="product__bg">
										<a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>">
											<?php echo wp_kses_post( $related_product->get_image( 'woocommerce_thumbnail' ) ); ?>
										</a>
									</div>
									<footer class="product__footer">
										<h4 class="title__h4">
											<a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="product__link"><?php echo esc_html( $related_product->get_name() ); ?></a>
										</h4>
										<div class="product__footer_bottom">
											<p><?php echo esc_html( ! empty( $related_sizes ) ? $related_sizes[0] : '' ); ?></p>
											<p><?php echo wp_kses_post( $related_product->get_price_html() ); ?></p>
										</div>
									</footer>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="slider__pagination"></div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php
		$last_viewed_ids      = array_diff( wh_get_last_viewed_ids(), array( $product->get_id() ) );
		$last_viewed_products = array();
		if ( ! empty( $last_viewed_ids ) ) {
			$last_viewed_products = wc_get_products(
				array(
					'include' => $last_viewed_ids,
					'orderby' => 'post__in',
					'limit'   => -1,
					'status'  => 'publish',
				)
			);
		}
		?>
		<?php if ( ! empty( $last_viewed_products ) ) : ?>
			<section class="last-viewed">
				<div class="container">
					<h2 class="title__h2">Last viewed</h2>
					<div class="last-viewed__grid">
						<?php
						global $wh_last_viewed_product;
						foreach ( $last_viewed_products as $wh_last_viewed_product ) {
							get_template_part( 'template-parts/last-viewed-item' );
						}
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</main>

	<?php
endwhile;

get_footer();

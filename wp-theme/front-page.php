<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$hero_slides_query = new WP_Query(
	array(
		'post_type'      => 'hero_slide',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);

$hero_slides = array();

if ( $hero_slides_query->have_posts() ) {
	while ( $hero_slides_query->have_posts() ) {
		$hero_slides_query->the_post();
		$hero_slides[] = array(
			'alt' => get_the_title(),
			'src' => get_the_post_thumbnail_url( get_the_ID(), 'large' ),
		);
	}
	wp_reset_postdata();
}

// Пока в «Hero slides» (Товары → нет, это отдельный пункт меню Hero slides)
// ничего не добавлено — показываем те же карточки, что были в статике.
if ( empty( $hero_slides ) ) {
	$wh_products_uri = get_template_directory_uri() . '/assets/image/products';
	$hero_slides      = array(
		array(
			'alt' => 'Gerhild soft plaid',
			'src' => $wh_products_uri . '/product(1).webp',
		),
		array(
			'alt' => 'Gultall soft plaid',
			'src' => $wh_products_uri . '/product(2).webp',
		),
		array(
			'alt' => 'Rovaror soft plaid',
			'src' => $wh_products_uri . '/product(3).webp',
		),
		array(
			'alt' => 'Gerhild soft plaid',
			'src' => $wh_products_uri . '/product(4).webp',
		),
		array(
			'alt' => 'Gerhild soft plaid',
			'src' => $wh_products_uri . '/product(5).webp',
		),
		array(
			'alt' => 'Gerhild soft plaid',
			'src' => $wh_products_uri . '/product(6).webp',
		),
	);
}

$popular_products = wc_get_products(
	array(
		'status'   => 'publish',
		'featured' => true,
		'limit'    => 9,
	)
);

// Пока ни один товар не отмечен как Featured (товар → Featured product) —
// показываем последние опубликованные, чтобы секция не была пустой
if ( empty( $popular_products ) ) {
	$popular_products = wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 9,
			'orderby' => 'date',
			'order'   => 'DESC',
		)
	);
}
?>

	<main>
		<section class="hero">
			<div class="container">
				<div class="hero__wrapper">
					<div class="hero__content">
						<h1 class="title__h1">Soft plaids for your comfort</h1>
						<p>Throw a blanket over your shoulders or place it on the arm of the sofa, and the atmosphere in
							the
							house will be warmer.</p>
						<a class="btn btn-shop" href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop now</a>
					</div>

					<div class="hero__slider-wrap">
						<svg class="hero__arc hero__arc--top" width="100" height="100" viewBox="0 0 100 100" fill="none"
							xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M10 90 Q10 10 90 10" stroke="currentColor" stroke-width="1.5"
								stroke-linecap="round" />
						</svg>
						<svg class="hero__arc hero__arc--bottom" width="100" height="100" viewBox="0 0 100 100"
							fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M10 90 Q10 10 90 10" stroke="currentColor" stroke-width="1.5"
								stroke-linecap="round" />
						</svg>
						<div class="swiper hero__slider">
							<div class="swiper-wrapper">
								<?php foreach ( $hero_slides as $slide ) : ?>
									<div class="swiper-slide hero__slider_product">
										<img src="<?php echo esc_url( $slide['src'] ); ?>"
											alt="<?php echo esc_attr( $slide['alt'] ); ?>" class="product__img">
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<!-- Pagination: вне .swiper, чтобы её можно было
							 позиционировать независимо от слайдов -->
						<div class="swiper-pagination hero__slider_pagination"></div>
					</div>
				</div>
			</div>
		</section>
		<section class="popular">
			<div class="container">
				<h2 class="title__h2 popular__title">Popular products</h2>
				<div class="slider popular__slider">
					<div class="slider_track" data-slider-track>
						<?php foreach ( $popular_products as $product ) :
							$sizes   = wc_get_product_terms( $product->get_id(), 'pa_size', array( 'fields' => 'names' ) );
							$variant = ! empty( $sizes ) ? $sizes[0] : '';
							?>
							<div class="product" data-slide>
								<div class="product__bg">
									<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
										<?php echo wp_kses_post( $product->get_image( 'woocommerce_thumbnail' ) ); ?>
									</a>
								</div>
								<footer class="product__footer">
									<h4 class="title__h4">
										<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="product__link"><?php echo esc_html( $product->get_name() ); ?></a>
									</h4>
									<button type="button" class="product__add" data-quick-add
										data-id="<?php echo esc_attr( $product->get_id() ); ?>"
										data-name="<?php echo esc_attr( $product->get_name() ); ?>"
										data-variant="<?php echo esc_attr( $variant ); ?>"
										data-price="<?php echo esc_attr( $product->get_price() ); ?>"
										data-image="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ); ?>"
										aria-label="<?php echo esc_attr( 'Add ' . $product->get_name() . ' to cart' ); ?>">
										<svg width="20" height="20" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"
											aria-hidden="true">
											<path d="M19 36L19 2M36 19L2 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
										</svg>
									</button>
									<div class="product__footer_bottom">
										<p><?php echo esc_html( $variant ); ?></p>
										<p><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
									</div>
								</footer>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="slider__pagination"></div>
				</div>
			</div>
		</section>

		<?php get_template_part( 'template-parts/presentation' ); ?>
		<?php get_template_part( 'template-parts/eco' ); ?>
		<?php get_template_part( 'template-parts/follow' ); ?>

		<section class="subscription">
			<div class="container">
				<div class="subscription__wrapper">
					<div class="subscription__block">
						<h2 class="title__h2">Get 20% off your first purchase</h2>
						<p>Subscribe to our newsletter and get a promo code for a 20% discount! You will receive only
							the
							most
							important
							and relevant news.</p>
					</div>
					<form class="form" method="post">
						<label for="email"></label>
						<input type="email" id="email" class="form__input" placeholder="Email address"
							autocomplete="email" required>
						<button type="submit" value="submit" class="btn form__btn">Submit</button>
					</form>
				</div>
			</div>

		</section>
	</main>

<?php
get_footer();

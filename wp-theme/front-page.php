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

// Те же 9 карточек, что и в каталоге — временная статика. Настоящий запрос к
// WooCommerce (популярные/featured товары) появится вместе с content-product.php
// в фазе «Каталог», чтобы не переносить разметку карточки дважды.
$wh_popular_products = array(
	array(
		'id'      => 'gerhild',
		'name'    => 'Gerhild',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(1).webp',
	),
	array(
		'id'      => 'gultall',
		'name'    => 'Gultall',
		'variant' => '130x170 cm',
		'price'   => 180,
		'image'   => 'product(2).webp',
	),
	array(
		'id'      => 'rovaror',
		'name'    => 'Rovaror',
		'variant' => '150x200 cm',
		'price'   => 85,
		'image'   => 'product(3).webp',
	),
	array(
		'id'      => 'gerhild-4',
		'name'    => 'Gerhild',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(4).webp',
	),
	array(
		'id'      => 'ingrun',
		'name'    => 'Ingrun',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(5).webp',
	),
	array(
		'id'      => 'mialotta',
		'name'    => 'Mialotta',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(6).webp',
	),
	array(
		'id'      => 'luddmalla',
		'name'    => 'Luddmalla',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(7).webp',
	),
	array(
		'id'      => 'vivianna',
		'name'    => 'Vivianna',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(8).webp',
	),
	array(
		'id'      => 'evali',
		'name'    => 'Evali',
		'variant' => '130x170 cm',
		'price'   => 90,
		'image'   => 'product(9).webp',
		'circled' => true,
	),
);

$wh_products_uri = get_template_directory_uri() . '/assets/image/products';
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
						<?php foreach ( $wh_popular_products as $product ) : ?>
							<div class="product" data-slide>
								<div class="product__bg<?php echo ! empty( $product['circled'] ) ? ' product__bg_circled' : ''; ?>">
									<img src="<?php echo esc_url( $wh_products_uri . '/' . $product['image'] ); ?>"
										alt="<?php echo esc_attr( $product['name'] ); ?> blanket">
								</div>
								<footer class="product__footer">
									<h4 class="title__h4">
										<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="product__link"><?php echo esc_html( $product['name'] ); ?></a>
									</h4>
									<button type="button" class="product__add" data-quick-add
										data-id="<?php echo esc_attr( $product['id'] ); ?>"
										data-name="<?php echo esc_attr( $product['name'] ); ?>"
										data-variant="<?php echo esc_attr( $product['variant'] ); ?>"
										data-price="<?php echo esc_attr( $product['price'] ); ?>"
										data-image="<?php echo esc_url( $wh_products_uri . '/' . $product['image'] ); ?>"
										aria-label="<?php echo esc_attr( 'Add ' . $product['name'] . ' to cart' ); ?>">
										<svg width="20" height="20" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"
											aria-hidden="true">
											<path d="M19 36L19 2M36 19L2 19" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
										</svg>
									</button>
									<div class="product__footer_bottom">
										<p><?php echo esc_html( $product['variant'] ); ?></p>
										<p>€<?php echo esc_html( $product['price'] ); ?></p>
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

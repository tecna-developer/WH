<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$wh_filter_taxonomies = array(
	'size'     => 'pa_size',
	'color'    => 'pa_color',
	'material' => 'pa_material',
);

$wh_current_filters = array();
foreach ( array_keys( $wh_filter_taxonomies ) as $wh_param ) {
	$wh_current_filters[ $wh_param ] = isset( $_GET[ $wh_param ] ) ? sanitize_title( wp_unslash( $_GET[ $wh_param ] ) ) : '';
}
$wh_current_filters['price'] = isset( $_GET['price'] ) ? sanitize_text_field( wp_unslash( $_GET['price'] ) ) : '';

// Для чипов — человекочитаемые подписи активных фильтров.
$wh_active_filters = array();
foreach ( $wh_filter_taxonomies as $param => $taxonomy ) {
	if ( empty( $wh_current_filters[ $param ] ) ) {
		continue;
	}
	$term = get_term_by( 'slug', $wh_current_filters[ $param ], $taxonomy );
	if ( $term ) {
		$wh_active_filters[ $param ] = $term->name;
	}
}
$wh_price_ranges = wh_get_price_filter_ranges();
if ( ! empty( $wh_current_filters['price'] ) && isset( $wh_price_ranges[ $wh_current_filters['price'] ] ) ) {
	$wh_active_filters['price'] = $wh_price_ranges[ $wh_current_filters['price'] ];
}

global $wp_query;
$wh_products_total = $wp_query->found_posts;
?>

	<main>
		<section class="shop__about" id="shop_section">
			<div class="container">
				<div class="shop__about_block">
					<h1 class="title__h1">Shop</h1>
					<p>In our store you will find a large number of high-quality blankets that will help make your home
						more comfortable and warm your life.</p>
				</div>
			</div>
		</section>
		<section class="filters">
			<div class="container">
				<form class="filters__bar" method="get">
					<input type="checkbox" id="filters_toggler" class="filters__toggler">
					<label for="filters_toggler" class="filters__trigger">
						<svg class="filters__trigger_icon" width="20" height="14" viewBox="0 0 20 14" fill="none"
							xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<line x1="0" y1="2" x2="20" y2="2" stroke="#2C2C2C" stroke-width="1.5" />
							<circle cx="7" cy="2" r="2.5" fill="#FDFBF9" stroke="#2C2C2C" stroke-width="1.5" />
							<line x1="0" y1="12" x2="20" y2="12" stroke="#2C2C2C" stroke-width="1.5" />
							<circle cx="14" cy="12" r="2.5" fill="#FDFBF9" stroke="#2C2C2C" stroke-width="1.5" />
						</svg>
						Filter
					</label>
					<div class="filters__group">
						<label class="filters__dropdown">
							<select class="filters__select" name="size" onchange="this.form.submit()">
								<option value="">Size</option>
								<?php foreach ( get_terms( array( 'taxonomy' => 'pa_size', 'hide_empty' => true ) ) as $term ) : ?>
									<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $wh_current_filters['size'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
								<?php endforeach; ?>
							</select>
							<svg class="filters__chevron" width="12" height="8" viewBox="0 0 12 8" fill="none"
								xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M1 1L6 6L11 1" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</label>
						<label class="filters__dropdown">
							<select class="filters__select" name="color" onchange="this.form.submit()">
								<option value="">Color</option>
								<?php foreach ( get_terms( array( 'taxonomy' => 'pa_color', 'hide_empty' => true ) ) as $term ) : ?>
									<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $wh_current_filters['color'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
								<?php endforeach; ?>
							</select>
							<svg class="filters__chevron" width="12" height="8" viewBox="0 0 12 8" fill="none"
								xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M1 1L6 6L11 1" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</label>
						<label class="filters__dropdown">
							<select class="filters__select" name="material" onchange="this.form.submit()">
								<option value="">Material</option>
								<?php foreach ( get_terms( array( 'taxonomy' => 'pa_material', 'hide_empty' => true ) ) as $term ) : ?>
									<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $wh_current_filters['material'], $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
								<?php endforeach; ?>
							</select>
							<svg class="filters__chevron" width="12" height="8" viewBox="0 0 12 8" fill="none"
								xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M1 1L6 6L11 1" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</label>
						<label class="filters__dropdown">
							<select class="filters__select" name="price" onchange="this.form.submit()">
								<option value="">Price</option>
								<?php foreach ( $wh_price_ranges as $value => $label ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $wh_current_filters['price'], $value ); ?>><?php echo esc_html( $label ); ?></option>
								<?php endforeach; ?>
							</select>
							<svg class="filters__chevron" width="12" height="8" viewBox="0 0 12 8" fill="none"
								xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M1 1L6 6L11 1" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round"
									stroke-linejoin="round" />
							</svg>
						</label>
					</div>
					<div class="filters__meta">
						<span class="filters__count"><?php echo esc_html( sprintf( '%d products', (int) $wh_products_total ) ); ?></span>
						<div class="filters__view-toggle" role="group" aria-label="Switch product view">
							<button type="button" class="filters__view-btn is-active" data-view="grid"
								aria-label="Grid view" aria-pressed="true">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
									xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect x="2" y="2" width="7" height="7" rx="1.5" fill="currentColor" />
									<rect x="11" y="2" width="7" height="7" rx="1.5" fill="currentColor" />
									<rect x="2" y="11" width="7" height="7" rx="1.5" fill="currentColor" />
									<rect x="11" y="11" width="7" height="7" rx="1.5" fill="currentColor" />
								</svg>
							</button>
							<button type="button" class="filters__view-btn" data-view="list" aria-label="List view"
								aria-pressed="false">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
									xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<rect x="2" y="3" width="16" height="3" rx="1.5" fill="currentColor" />
									<rect x="2" y="8.5" width="16" height="3" rx="1.5" fill="currentColor" />
									<rect x="2" y="14" width="16" height="3" rx="1.5" fill="currentColor" />
								</svg>
							</button>
						</div>
					</div>
				</form>
				<?php if ( ! empty( $wh_active_filters ) ) : ?>
					<ul class="filters__chips">
						<?php foreach ( $wh_active_filters as $param => $label ) : ?>
							<li class="filters__chip">
								<a class="filters__chip_remove" href="<?php echo esc_url( remove_query_arg( $param ) ); ?>"
									aria-label="<?php echo esc_attr( 'Remove ' . $label . ' filter' ); ?>">
									<svg width="10" height="10" viewBox="0 0 10 10" fill="none"
										xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M1 1L9 9M9 1L1 9" stroke="#2C2C2C" stroke-width="1.5" stroke-linecap="round" />
									</svg>
								</a>
								<?php echo esc_html( $label ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</section>
		<section class="catalog">
			<div class="container">
				<?php do_action( 'woocommerce_before_shop_loop' ); ?>
				<?php if ( woocommerce_product_loop() ) : ?>
					<?php woocommerce_product_loop_start(); ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'product' ); ?>
					<?php endwhile; ?>
					<?php woocommerce_product_loop_end(); ?>
					<?php woocommerce_pagination(); ?>
				<?php else : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
				<?php do_action( 'woocommerce_after_shop_loop' ); ?>
			</div>
		</section>

		<?php
		$wh_last_viewed_ids      = wh_get_last_viewed_ids();
		$wh_last_viewed_products = array();
		if ( ! empty( $wh_last_viewed_ids ) ) {
			$wh_last_viewed_products = wc_get_products(
				array(
					'include' => $wh_last_viewed_ids,
					'orderby' => 'post__in',
					'limit'   => -1,
					'status'  => 'publish',
				)
			);
		}
		?>
		<?php if ( ! empty( $wh_last_viewed_products ) ) : ?>
			<section class="last-viewed">
				<div class="container">
					<h2 class="title__h2">Last viewed</h2>
					<div class="last-viewed__grid">
						<?php
						global $wh_last_viewed_product;
						foreach ( $wh_last_viewed_products as $wh_last_viewed_product ) {
							get_template_part( 'template-parts/last-viewed-item' );
						}
						?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</main>

<?php
get_footer();

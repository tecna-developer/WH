<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="container">
				<?php the_title( '<h1 class="title__h1">', '</h1>' ); ?>
			</div>
			<?php
			// Cart/Checkout/My Account держат свои бежевые акцентные блоки
			// (cart-summary, checkout-summary) поверх белого — бежевый фон
			// секции их бы просто растворил
			$is_woocommerce_endpoint = is_cart() || is_checkout() || is_account_page();
			?>
			<section class="<?php echo esc_attr( $is_woocommerce_endpoint ? '' : 'page-section' ); ?>">
				<div class="container page-content">
					<?php the_content(); ?>
				</div>
			</section>
		<?php endwhile; ?>
	</main>

<?php
get_footer();

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
			<section class="page-section">
				<div class="container page-content">
					<?php the_content(); ?>
				</div>
			</section>
		<?php endwhile; ?>
	</main>

<?php
get_footer();

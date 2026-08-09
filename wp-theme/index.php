<?php
get_header();
?>

<main id="site-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<?php the_title( '<h1>', '</h1>' ); ?>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</main>

<?php
get_footer();

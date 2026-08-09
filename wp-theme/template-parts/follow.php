<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wh_assets_uri = get_template_directory_uri() . '/assets/image';
?>
<section id="posts" class="follow">
	<div class="container">
		<h2 class="title__h2">Follow us on instagram</h2>
		<div id="instagram-feed" class="follow__grid">
			<figure class="follow__item follow__item--1">
				<div class="follow__media">
					<img class="follow__img" src="<?php echo esc_url( $wh_assets_uri . '/post.jpg' ); ?>" alt="Warm Heart Instagram post">
				</div>
				<div class="follow__text">
					<a href="#" class="follow__handle follow__handle--mobile">@warm.heart</a>
					<p class="follow__caption">On our Instagram, we regularly share the most interesting news.
						We also tell you about all our
						new
						products.</p>
				</div>
			</figure>
			<figure class="follow__item follow__item--2">
				<div class="follow__media">
					<img class="follow__img" src="<?php echo esc_url( $wh_assets_uri . '/products/product(6).webp' ); ?>"
						alt="Warm Heart Instagram post">
				</div>
				<a href="#" class="follow__handle">@warm.heart</a>
			</figure>
			<figure class="follow__item follow__item--3">
				<div class="follow__media">
					<img class="follow__img" src="<?php echo esc_url( $wh_assets_uri . '/products/product(4).webp' ); ?>"
						alt="Warm Heart Instagram post">
				</div>
				<a href="#" class="follow__handle">@warm.heart</a>
			</figure>
		</div>
	</div>
</section>

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wh_assets_uri = get_template_directory_uri() . '/assets/image';
?>
<section class="presentation">
	<div class="container">
		<div class="presentation__title_block">
			<h2 class="title__h2 presentation__title">Create comfort in home</h2>
			<p class="presentation__pretext">A blanket is a simple and versatile thing that can make relaxing after
				a hard day's work much more comfortable.</p>
		</div>
		<div class="presentation__wrapper">
			<div class="presentation__img-block">
				<img src="<?php echo esc_url( $wh_assets_uri . '/pres_360.avif' ); ?>" alt="Sideneert wool blanket"
					srcset="<?php echo esc_attr( $wh_assets_uri . '/pres_480.avif' ); ?> 480w,<?php echo esc_attr( $wh_assets_uri . '/pres_768.avif' ); ?> 768w, <?php echo esc_attr( $wh_assets_uri . '/pres_1000.avif' ); ?> 1000w">
			</div>
			<div class="presentation__descr">
				<h3 class="title__h3">Sideneert</h3>
				<p class="presentation__descr-text">It is made from soft New Zealand wool, which is naturally
					stain-repellent.</p>
				<p>This bedspread is an easy way to freshen up your bedroom decor. Plus, it can be
					used as an extra blanket if you get
					cold.</p>
				<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="btn btn-presentation">Go to shop</a>
			</div>
		</div>
	</div>
</section>

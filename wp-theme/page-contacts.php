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
		<?php endwhile; ?>

		<section>
			<div class="container">
				<div class="contacts__grid">
					<div class="contacts__map_wrapper">
						<iframe class="contacts__map"
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2442.935821487289!2d-0.8961138244267453!3d52.24454935658799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48770ec38e92bf6d%3A0xac3daeb9624ca9bc!2zMkEgQ3JhdmVuIFN0LCBOb3J0aGFtcHRvbiBOTjEgM0VaLCDQktC10LvQuNC60L7QsdGA0LjRgtCw0L3QuNGP!5e0!3m2!1sru!2see!4v1784108674543!5m2!1sru!2see"
							width="100%" height="575" style="border:0;" allowfullscreen loading="lazy"
							referrerpolicy="strict-origin-when-cross-origin"></iframe>
					</div>
					<div class="contacts__card">
						<h2 class="contacts__card_title">WARM HEART SHOP</h2>
						<address class="contacts__card_list">
							Phone number: <a class="contacts__card_link" href="tel:+443303218754">+44 330 321
								8754</a><br>Address: <a
								href="https://www.google.com/maps/search/?api=1&query=2A+Craven+Street,+Northampton"
								class="contacts__card_link">2A Craven
								Street, Northampton</a><br>Email: <a class="contacts__card_link"
								href="mailto:warmheart.shop@gmail.com">warmheart.shop@gmail.com</a>
						</address>
					</div>
					<div class="contacts__card">
						<h2 class="contacts__card_title">WARM HEART OFFICE</h2>
						<address class="contacts__card_list">
							Phone number: <a href="tel:+443304561425" class="contacts__card_link">+44 330 456 1425</a>
							<br>
							Address: <a
								href="https://www.google.com/maps/search/?api=1&query=70+Edith+Street,+Northampton"
								target="_blank" rel="noopener noreferrer" class="contacts__card_link">70 Edith Street,
								Northampton</a>
							<br>
							Email:<a class="contacts__card_link"
								href="mailto:warmheart.office@gmail.com">warmheart.office@gmail.com</a>
						</address>
					</div>
				</div>
			</div>
		</section>
	</main>

<?php
get_footer();

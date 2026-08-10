<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Обёртка в наших контейнерах вместо голого WooCommerce-вывода —
// navigation.php/dashboard.php/orders.php/form-login.php не переопределены,
// их разметка приходит как есть, стили — по их же штатным классам
// (my-account.scss), тот же приём, что и с полями биллинга на чекауте.
?>
<div class="my-account__wrapper">
	<?php do_action( 'woocommerce_account_navigation' ); ?>

	<div class="woocommerce-MyAccount-content">
		<?php do_action( 'woocommerce_account_content' ); ?>
	</div>
</div>

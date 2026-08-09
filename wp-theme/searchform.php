<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Два места вызова (мобильное меню и модалка в шапке) визуально разные —
// один инпут без кнопки, другой с кнопкой и autofocus — поэтому вариант
// выбирается через $args['variant'], а не через жёстко заданную разметку.
$variant = $args['variant'] ?? 'modal';
$action  = home_url( '/' );
?>
<?php if ( 'mobile' === $variant ) : ?>
	<form class="mobile-menu__form" method="get" action="<?php echo esc_url( $action ); ?>">
		<label for="mobile-menu-search" aria-label="mobile-navigation search"></label>
		<input type="search" id="mobile-menu-search" placeholder="Search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>">
		<input type="hidden" name="post_type" value="product">
	</form>
<?php else : ?>
	<form class="search__form" role="search" method="get" action="<?php echo esc_url( $action ); ?>">
		<input type="search" name="s" placeholder="Search..." class="search__input" value="<?php echo esc_attr( get_search_query() ); ?>" autofocus>
		<input type="hidden" name="post_type" value="product">
		<button type="submit" class="btn search__btn">Search</button>
	</form>
<?php endif; ?>

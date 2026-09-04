<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header class="header">
		<div class="container">
			<div class="header__wrapper">
				<div class="header__left">
					<div class="mobile-menu" aria-label="mobile-navigation">
						<button type="button" popovertarget="mobile-navigation" class="mobile-menu__burger"
							aria-label="open-close mobile-navigation">
							<svg width="44" height="22" viewBox="0 0 42 22" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M1 1H41" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" />
								<path d="M1 11H31" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" />
								<path d="M1 21H41" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" />
							</svg>
						</button>
						<nav class="mobile-menu__block" id="mobile-navigation" popover="auto">
							<button type="button" class="mobile-menu__close" popovertarget="mobile-navigation"
								popovertargetaction="hide" aria-label="close mobile-navigation">
								<svg width="31" height="31" viewBox="0 0 31 31" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path d="M1.00151 29.2843L29.2858 1M29.2858 29.2843L1.00151 1" stroke="#2C2C2C"
										stroke-width="2" stroke-linecap="round" />
								</svg>
							</button>

							<?php
							if ( has_nav_menu( 'menu-mobile' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'menu-mobile',
										'container'      => false,
										'items_wrap'     => '<ul class="menu__list mobile-menu__list">%3$s</ul>',
										'walker'         => new WH_Nav_Walker(),
										'item_class'     => 'menu__item mobile-menu__item',
									)
								);
							} else {
								?>
								<ul class="menu__list mobile-menu__list">
									<li class="menu__item mobile-menu__item"><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop</a></li>
									<li class="menu__item mobile-menu__item"><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
									<li class="menu__item mobile-menu__item"><a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Contacts</a></li>
								</ul>
								<?php
							}
							?>

							<hr class="mobile-menu__divider">

							<?php get_search_form( array( 'variant' => 'mobile' ) ); ?>

							<div class="cart mobile__menu__cart">
								<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart__btn mobile-menu__cart_btn" aria-label="cart">Cart<span
										class="cart__count" data-cart-count aria-hidden="true"><?php echo esc_html( wh_cart_count_label() ); ?></span></a>
							</div>
						</nav>
					</div>
					<div class="menu__desktop">
						<nav class="menu__desktop_nav">
							<?php
							if ( has_nav_menu( 'menu-desktop' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'menu-desktop',
										'container'      => false,
										'items_wrap'     => '<ul class="menu__desktop_list">%3$s</ul>',
										'walker'         => new WH_Nav_Walker(),
										'item_class'     => 'menu__desktop_item',
									)
								);
							} else {
								?>
								<ul class="menu__desktop_list">
									<li class="menu__desktop_item"><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>">Shop</a></li>
									<li class="menu__desktop_item"><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About</a></li>
									<li class="menu__desktop_item"><a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Contacts</a></li>
								</ul>
								<?php
							}
							?>
						</nav>
					</div>
				</div>
				<div class="header__center">
					<a class="header__center_link header__center_link_short" href="<?php echo esc_url( home_url( '/' ) ); ?>"
						aria-label="warm heart logo">
						WH
					</a>
					<a class="header__center_link header__center_link_long" href="<?php echo esc_url( home_url( '/' ) ); ?>"
						aria-label="warm heart logo"> WARM Heart</a>
				</div>
				<div class="header__right">
					<button type="button" class="btn header__right_search" aria-label="Open search"
						popovertarget="search-in-header"><svg class="header__right_icon" width="28" height="28"
							viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M12.8333 22.1667C17.988 22.1667 22.1667 17.988 22.1667 12.8333C22.1667 7.67868 17.988 3.5 12.8333 3.5C7.67868 3.5 3.5 7.67868 3.5 12.8333C3.5 17.988 7.67868 22.1667 12.8333 22.1667Z"
								stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M24.5008 24.5L19.4258 19.425" stroke="#2C2C2C" stroke-width="2"
								stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<span class="header__right_text">Search</span>
					</button>
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn cart__btn" aria-label="cart">
						<svg class="header__right_icon" role="img" focusable="false" width="28" height="28"
							viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<title>Cart</title>
							<path
								d="M7 2.33333L3.5 7V23.3333C3.5 23.9522 3.74583 24.5457 4.18342 24.9833C4.621 25.4208 5.21449 25.6667 5.83333 25.6667H22.1667C22.7855 25.6667 23.379 25.4208 23.8166 24.9833C24.2542 24.5457 24.5 23.9522 24.5 23.3333V7L21 2.33333H7Z"
								stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M3.5 7H24.5" stroke="#2C2C2C" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
							<path
								d="M18.6693 11.6667C18.6693 12.9043 18.1776 14.0913 17.3024 14.9665C16.4273 15.8417 15.2403 16.3333 14.0026 16.3333C12.7649 16.3333 11.5779 15.8417 10.7028 14.9665C9.8276 14.0913 9.33594 12.9043 9.33594 11.6667"
								stroke="#2C2C2C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<span class="header__right_text">Cart</span>
						<span class="cart__count" data-cart-count aria-hidden="true"><?php echo esc_html( wh_cart_count_label() ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</header>

	<div class="search__modal" popover="auto" id="search-in-header">
		<?php get_search_form( array( 'variant' => 'modal' ) ); ?>
	</div>

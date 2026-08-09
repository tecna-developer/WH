<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Меню в дизайне плоские (без вложенных подменю), поэтому вместо
 * стандартных классов menu-item-* просто выводим <li class="{item_class}">
 * с классом, который передаётся через аргумент item_class в wp_nav_menu().
 */
class WH_Nav_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$item_class = ! empty( $args->item_class ) ? $args->item_class : 'menu-item';

		$output .= '<li class="' . esc_attr( $item_class ) . '">';
		$output .= '<a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
		$output .= '</li>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		// Закрывающий </li> уже выведен в start_el.
	}
}

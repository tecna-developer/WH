<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Заменяет вывод WooCommerce по умолчанию (<ul class="products ...">) на
// свой .catalog__wrapper — так catalog-view.js и catalog.scss не пришлось
// переписывать под чужую разметку.
?>
<div class="catalog__wrapper">

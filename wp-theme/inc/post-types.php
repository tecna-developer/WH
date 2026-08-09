<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		register_post_type(
			'hero_slide',
			array(
				'labels'       => array(
					'name'          => __( 'Hero slides', 'wh' ),
					'singular_name' => __( 'Hero slide', 'wh' ),
					'add_new_item'  => __( 'Add hero slide', 'wh' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => true,
				'menu_icon'    => 'dashicons-images-alt2',
				// Заголовок = alt картинки, featured image = сам слайд, порядок —
				// через встроенное поле Order (page-attributes), без плагинов.
				'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
			)
		);

		register_post_type(
			'wh_subscriber',
			array(
				'labels'       => array(
					'name'          => __( 'Newsletter subscribers', 'wh' ),
					'singular_name' => __( 'Subscriber', 'wh' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_menu' => true,
				'menu_icon'    => 'dashicons-email',
				'supports'     => array( 'title' ),
				'capabilities' => array(
					'create_posts' => 'do_not_allow',
				),
				'map_meta_cap' => true,
			)
		);
	}
);

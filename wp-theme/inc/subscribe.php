<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wh_handle_subscribe() {
	check_ajax_referer( 'wh_subscribe', 'nonce' );

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'wh' ) ), 400 );
	}

	$existing = get_posts(
		array(
			'post_type'      => 'wh_subscriber',
			'posts_per_page' => 1,
			'meta_key'       => '_wh_subscriber_email',
			'meta_value'     => $email,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	// Тому, кто уже подписан, не сообщаем об этом отдельно — чтобы форма не
	// превращалась в способ проверить, чей email есть в базе.
	if ( empty( $existing ) ) {
		$post_id = wp_insert_post(
			array(
				'post_type'   => 'wh_subscriber',
				'post_title'  => $email,
				'post_status' => 'publish',
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			wp_send_json_error( array( 'message' => __( 'Could not save your email, please try again.', 'wh' ) ), 500 );
		}

		update_post_meta( $post_id, '_wh_subscriber_email', $email );

		wp_mail(
			get_option( 'admin_email' ),
			__( 'New newsletter signup', 'wh' ),
			sprintf( 'New subscriber: %s', $email )
		);
	}

	wp_send_json_success( array( 'message' => __( 'Thanks — check your inbox for the promo code.', 'wh' ) ) );
}
add_action( 'wp_ajax_wh_subscribe', 'wh_handle_subscribe' );
add_action( 'wp_ajax_nopriv_wh_subscribe', 'wh_handle_subscribe' );

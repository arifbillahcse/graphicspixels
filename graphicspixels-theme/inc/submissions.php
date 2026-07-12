<?php
/**
 * Form submissions: stored as custom post types in wp-admin,
 * optionally forwarded to the Graphics Pixels app.
 *
 * To forward submissions to app.graphicspixels.com, add to wp-config.php:
 *   define( 'GP_APP_WEBHOOK_URL', 'https://app.graphicspixels.com/api/submissions' );
 *   define( 'GP_APP_API_KEY', 'your-secret-key' );
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ── Post types ── */
add_action( 'init', function () {
	$common = array(
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'supports'            => array( 'title' ),
		'capability_type'     => 'post',
		'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'        => true,
	);

	register_post_type( 'gp_trial', array_merge( $common, array(
		'labels'    => array(
			'name'          => 'Trial Requests',
			'singular_name' => 'Trial Request',
		),
		'menu_icon' => 'dashicons-star-filled',
	) ) );

	register_post_type( 'gp_contact', array_merge( $common, array(
		'labels'    => array(
			'name'          => 'Contact Messages',
			'singular_name' => 'Contact Message',
		),
		'menu_icon' => 'dashicons-email-alt',
	) ) );
} );

/* ── AJAX handlers ── */
add_action( 'wp_ajax_gp_submit_trial', 'gp_handle_trial_submission' );
add_action( 'wp_ajax_nopriv_gp_submit_trial', 'gp_handle_trial_submission' );
add_action( 'wp_ajax_gp_submit_contact', 'gp_handle_contact_submission' );
add_action( 'wp_ajax_nopriv_gp_submit_contact', 'gp_handle_contact_submission' );

function gp_verify_form_nonce() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'gp_form_submit' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed. Please reload the page and try again.' ), 403 );
	}
}

function gp_sanitized_field( $key ) {
	return isset( $_POST[ $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) : '';
}

/**
 * Handle the optional file upload. Returns attachment ID or 0.
 */
function gp_handle_file_upload( $post_id ) {
	if ( empty( $_FILES['attachment']['name'] ) ) {
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$allowed = array(
		'jpg|jpeg' => 'image/jpeg',
		'png'      => 'image/png',
		'gif'      => 'image/gif',
		'webp'     => 'image/webp',
		'tif|tiff' => 'image/tiff',
		'psd'      => 'image/vnd.adobe.photoshop',
		'pdf'      => 'application/pdf',
		'zip'      => 'application/zip',
		'rar'      => 'application/vnd.rar',
	);

	if ( $_FILES['attachment']['size'] > 25 * 1024 * 1024 ) {
		return new WP_Error( 'too_large', 'File exceeds 25 MB. Please share it via a cloud link instead.' );
	}

	$attachment_id = media_handle_upload( 'attachment', $post_id, array(), array(
		'test_form' => false,
		'mimes'     => $allowed,
	) );

	return $attachment_id;
}

function gp_save_submission( $post_type, $fields, $form_label ) {
	$post_id = wp_insert_post( array(
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'post_title'  => sprintf( '%s — %s', $fields['name'] ? $fields['name'] : 'Unknown', current_time( 'Y-m-d H:i' ) ),
	), true );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => 'Could not save your submission. Please try again.' ), 500 );
	}

	foreach ( $fields as $key => $value ) {
		if ( '' !== $value ) {
			update_post_meta( $post_id, 'gp_' . $key, $value );
		}
	}

	$attachment = gp_handle_file_upload( $post_id );
	if ( is_wp_error( $attachment ) ) {
		wp_delete_post( $post_id, true );
		wp_send_json_error( array( 'message' => $attachment->get_error_message() ), 400 );
	}
	if ( $attachment ) {
		update_post_meta( $post_id, 'gp_attachment_id', $attachment );
		$fields['attachment_url'] = wp_get_attachment_url( $attachment );
	}

	/* Email notification */
	$body = '';
	foreach ( $fields as $key => $value ) {
		if ( '' !== $value ) {
			$body .= ucwords( str_replace( '_', ' ', $key ) ) . ': ' . $value . "\n";
		}
	}
	wp_mail(
		get_option( 'admin_email' ),
		sprintf( '[%s] New %s from %s', get_bloginfo( 'name' ), $form_label, $fields['name'] ),
		$body
	);

	/* Forward to the app if configured */
	gp_forward_to_app( $form_label, $fields, $post_id );

	return $post_id;
}

function gp_forward_to_app( $form_label, $fields, $post_id ) {
	if ( ! defined( 'GP_APP_WEBHOOK_URL' ) || ! GP_APP_WEBHOOK_URL ) {
		return;
	}

	$headers = array( 'Content-Type' => 'application/json' );
	if ( defined( 'GP_APP_API_KEY' ) && GP_APP_API_KEY ) {
		$headers['Authorization'] = 'Bearer ' . GP_APP_API_KEY;
	}

	$response = wp_remote_post( GP_APP_WEBHOOK_URL, array(
		'timeout' => 8,
		'headers' => $headers,
		'body'    => wp_json_encode( array_merge( $fields, array(
			'form'         => $form_label,
			'submitted_at' => current_time( 'c' ),
			'wp_entry_id'  => $post_id,
		) ) ),
	) );

	if ( is_wp_error( $response ) ) {
		update_post_meta( $post_id, 'gp_app_forward_error', $response->get_error_message() );
	} else {
		update_post_meta( $post_id, 'gp_app_forward_status', wp_remote_retrieve_response_code( $response ) );
	}
}

function gp_handle_trial_submission() {
	gp_verify_form_nonce();

	$fields = array(
		'name'      => gp_sanitized_field( 'name' ),
		'email'     => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'phone'     => gp_sanitized_field( 'phone' ),
		'website'   => esc_url_raw( wp_unslash( $_POST['website'] ?? '' ) ),
		'service'   => gp_sanitized_field( 'service' ),
		'message'   => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'file_link' => esc_url_raw( wp_unslash( $_POST['file_link'] ?? '' ) ),
	);

	if ( ! $fields['name'] || ! is_email( $fields['email'] ) ) {
		wp_send_json_error( array( 'message' => 'Please provide your name and a valid email address.' ), 400 );
	}

	gp_save_submission( 'gp_trial', $fields, 'Free Trial Request' );
	wp_send_json_success( array( 'message' => 'Thank you! Your free trial request has been received. We will get back to you shortly.' ) );
}

function gp_handle_contact_submission() {
	gp_verify_form_nonce();

	$fields = array(
		'name'    => gp_sanitized_field( 'name' ),
		'email'   => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'phone'   => gp_sanitized_field( 'phone' ),
		'company' => gp_sanitized_field( 'company' ),
		'service' => gp_sanitized_field( 'service' ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
	);

	if ( ! $fields['name'] || ! is_email( $fields['email'] ) || ! $fields['message'] ) {
		wp_send_json_error( array( 'message' => 'Please fill in your name, a valid email and a message.' ), 400 );
	}

	gp_save_submission( 'gp_contact', $fields, 'Contact Message' );
	wp_send_json_success( array( 'message' => 'Thank you for your message! We will get back to you as soon as possible.' ) );
}

/* ── Admin list columns ── */
function gp_submission_columns( $columns ) {
	return array(
		'cb'         => $columns['cb'],
		'title'      => 'Entry',
		'gp_email'   => 'Email',
		'gp_phone'   => 'Phone',
		'gp_service' => 'Service',
		'date'       => 'Date',
	);
}
add_filter( 'manage_gp_trial_posts_columns', 'gp_submission_columns' );
add_filter( 'manage_gp_contact_posts_columns', 'gp_submission_columns' );

function gp_submission_column_content( $column, $post_id ) {
	if ( in_array( $column, array( 'gp_email', 'gp_phone', 'gp_service' ), true ) ) {
		echo esc_html( get_post_meta( $post_id, str_replace( 'gp_', 'gp_', $column ), true ) );
	}
}
add_action( 'manage_gp_trial_posts_custom_column', 'gp_submission_column_content', 10, 2 );
add_action( 'manage_gp_contact_posts_custom_column', 'gp_submission_column_content', 10, 2 );

/* ── Detail meta box when viewing an entry ── */
add_action( 'add_meta_boxes', function () {
	foreach ( array( 'gp_trial', 'gp_contact' ) as $type ) {
		add_meta_box( 'gp_submission_details', 'Submission Details', 'gp_render_submission_details', $type, 'normal', 'high' );
	}
} );

function gp_render_submission_details( $post ) {
	$meta = get_post_meta( $post->ID );
	echo '<table class="widefat striped">';
	foreach ( $meta as $key => $values ) {
		if ( 0 !== strpos( $key, 'gp_' ) ) {
			continue;
		}
		$label = ucwords( str_replace( array( 'gp_', '_' ), array( '', ' ' ), $key ) );
		$value = $values[0];
		if ( 'gp_attachment_id' === $key ) {
			$url   = wp_get_attachment_url( (int) $value );
			$value = $url ? '<a href="' . esc_url( $url ) . '" target="_blank">Download attachment</a>' : esc_html( $value );
			echo '<tr><td><strong>' . esc_html( $label ) . '</strong></td><td>' . wp_kses_post( $value ) . '</td></tr>';
			continue;
		}
		echo '<tr><td style="width:180px"><strong>' . esc_html( $label ) . '</strong></td><td>' . esc_html( $value ) . '</td></tr>';
	}
	echo '</table>';
}

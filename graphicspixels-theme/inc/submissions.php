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

/**
 * Normalize a user-typed website/link value into a full URL.
 * Accepts bare domains like "arifbillah.com" (no scheme required by the
 * form field) and prepends https:// so the stored/forwarded value is a
 * valid, clickable link.
 */
function gp_normalize_url( $raw ) {
	$raw = trim( (string) $raw );
	if ( '' === $raw ) {
		return '';
	}
	if ( ! preg_match( '#^https?://#i', $raw ) ) {
		$raw = 'https://' . $raw;
	}
	return esc_url_raw( $raw );
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

/**
 * Best-effort visitor IP, accounting for a reverse proxy/CDN in front of
 * the site. Used only for rate-limiting, never stored publicly.
 */
function gp_get_client_ip() {
	foreach ( array( 'HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR' ) as $key ) {
		if ( ! empty( $_SERVER[ $key ] ) ) {
			$ip = wp_unslash( $_SERVER[ $key ] );
			$ip = trim( explode( ',', $ip )[0] );
			if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
				return $ip;
			}
		}
	}
	return '0.0.0.0';
}

/**
 * Honeypot + rate-limit guard, shared by both forms.
 *
 * The honeypot is a field that's invisible to real visitors (hidden via
 * CSS, not via type="hidden" or display:none, since bots commonly skip
 * those) but that automated bots tend to fill in anyway. If it's
 * non-empty, or the same IP submits too many times in a short window,
 * we pretend the submission succeeded (so the bot doesn't adapt) but
 * never save it, email it, or forward it anywhere.
 */
function gp_is_spam_submission() {
	if ( ! empty( $_POST['gp_hp_optin'] ) ) {
		return true;
	}

	$ip  = gp_get_client_ip();
	$key = 'gp_rl_' . md5( $ip );
	$hits = (int) get_transient( $key );

	if ( $hits >= 5 ) {
		return true;
	}

	set_transient( $key, $hits + 1, 10 * MINUTE_IN_SECONDS );
	return false;
}

function gp_reject_as_spam( $success_message ) {
	// Respond as if it worked, so bots don't learn to adapt.
	wp_send_json_success( array( 'message' => $success_message ) );
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
	if ( gp_notifications_enabled() ) {
		$recipients = gp_notification_recipients();
		if ( ! empty( $recipients ) ) {
			$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
			if ( ! empty( $fields['email'] ) && is_email( $fields['email'] ) ) {
				$headers[] = 'Reply-To: ' . $fields['name'] . ' <' . $fields['email'] . '>';
			}
			wp_mail(
				$recipients,
				sprintf( '[%s] New %s from %s', get_bloginfo( 'name' ), $form_label, $fields['name'] ),
				$body,
				$headers
			);
		}
	}

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

	if ( gp_is_spam_submission() ) {
		gp_reject_as_spam( 'Thank you! Your free trial request has been received. We will get back to you shortly.' );
	}

	$fields = array(
		'name'      => gp_sanitized_field( 'name' ),
		'email'     => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
		'phone'     => gp_sanitized_field( 'phone' ),
		'website'   => gp_normalize_url( wp_unslash( $_POST['website'] ?? '' ) ),
		'service'   => gp_sanitized_field( 'service' ),
		'message'   => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
		'file_link' => gp_normalize_url( wp_unslash( $_POST['file_link'] ?? '' ) ),
	);

	if ( ! $fields['name'] || ! is_email( $fields['email'] ) || ! $fields['website'] ) {
		wp_send_json_error( array( 'message' => 'Please provide your name, a valid email address and your website.' ), 400 );
	}

	gp_save_submission( 'gp_trial', $fields, 'Free Trial Request' );
	wp_send_json_success( array( 'message' => 'Thank you! Your free trial request has been received. We will get back to you shortly.' ) );
}

function gp_handle_contact_submission() {
	gp_verify_form_nonce();

	if ( gp_is_spam_submission() ) {
		gp_reject_as_spam( 'Thank you for your message! We will get back to you as soon as possible.' );
	}

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
			$attachment_id = (int) $value;
			$url           = wp_get_attachment_url( $attachment_id );

			if ( ! $url ) {
				echo '<tr><td><strong>' . esc_html( $label ) . '</strong></td><td>' . esc_html( $value ) . '</td></tr>';
				continue;
			}

			$is_image = wp_attachment_is_image( $attachment_id );
			$cell     = '';

			if ( $is_image ) {
				$thumb = wp_get_attachment_image( $attachment_id, 'medium', false, array( 'style' => 'max-width:260px;height:auto;border-radius:8px;display:block;margin-bottom:8px;' ) );
				$cell .= '<a href="' . esc_url( $url ) . '" target="_blank">' . $thumb . '</a>';
			}

			$cell .= '<a href="' . esc_url( $url ) . '" target="_blank">' . ( $is_image ? 'View full size' : 'Download attachment' ) . '</a>';
			$cell .= ' &nbsp;·&nbsp; <a href="' . esc_url( get_edit_post_link( $attachment_id ) ) . '" target="_blank">Open in Media Library</a>';

			echo '<tr><td><strong>' . esc_html( $label ) . '</strong></td><td>' . wp_kses_post( $cell ) . '</td></tr>';
			continue;
		}
		echo '<tr><td style="width:180px"><strong>' . esc_html( $label ) . '</strong></td><td>' . esc_html( $value ) . '</td></tr>';
	}
	echo '</table>';
}

/* ============================================================
   Notification settings — admin-configurable recipient email(s)
   ============================================================ */

/**
 * Whether email notifications are switched on. Default: on.
 */
function gp_notifications_enabled() {
	return '1' === get_option( 'gp_notify_enabled', '1' );
}

/**
 * Recipient list for notification emails. Falls back to the
 * WordPress admin email if the admin has not set anything.
 * Supports multiple addresses separated by comma or new line.
 *
 * @return string[] Array of valid email addresses.
 */
function gp_notification_recipients() {
	$raw = trim( (string) get_option( 'gp_notify_email', '' ) );
	if ( '' === $raw ) {
		$raw = get_option( 'admin_email' );
	}

	$emails = preg_split( '/[,\r\n]+/', $raw );
	$valid  = array();
	foreach ( $emails as $email ) {
		$email = sanitize_email( trim( $email ) );
		if ( $email && is_email( $email ) ) {
			$valid[] = $email;
		}
	}
	return array_unique( $valid );
}

/* ── Settings page under "Trial Requests" menu ── */
add_action( 'admin_menu', function () {
	add_submenu_page(
		'edit.php?post_type=gp_trial',
		'Form Notifications',
		'Notifications',
		'manage_options',
		'gp-form-settings',
		'gp_render_settings_page'
	);
} );

/* ── Register the settings ── */
add_action( 'admin_init', function () {
	register_setting( 'gp_form_settings', 'gp_notify_enabled', array(
		'type'              => 'string',
		'sanitize_callback' => function ( $v ) {
			return '1' === $v ? '1' : '0';
		},
		'default'           => '1',
	) );

	register_setting( 'gp_form_settings', 'gp_notify_email', array(
		'type'              => 'string',
		'sanitize_callback' => 'gp_sanitize_email_list',
		'default'           => '',
	) );
} );

/**
 * Keep only valid emails from a comma/newline separated list.
 */
function gp_sanitize_email_list( $value ) {
	$emails = preg_split( '/[,\r\n]+/', (string) $value );
	$valid  = array();
	foreach ( $emails as $email ) {
		$email = sanitize_email( trim( $email ) );
		if ( $email && is_email( $email ) ) {
			$valid[] = $email;
		}
	}
	if ( empty( $valid ) && '' !== trim( (string) $value ) ) {
		add_settings_error( 'gp_notify_email', 'gp_notify_email_invalid', 'No valid email address was entered. Notifications will fall back to the site admin email.', 'warning' );
	}
	return implode( ', ', array_unique( $valid ) );
}

function gp_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	/* Handle the "send test email" action */
	if ( isset( $_POST['gp_send_test'] ) && check_admin_referer( 'gp_send_test_email', 'gp_test_nonce' ) ) {
		$recipients = gp_notification_recipients();
		$sent       = ! empty( $recipients ) && wp_mail(
			$recipients,
			sprintf( '[%s] Test notification', get_bloginfo( 'name' ) ),
			"This is a test email from your Graphics Pixels form notification settings.\n\nIf you received this, notifications are working."
		);
		if ( $sent ) {
			echo '<div class="notice notice-success is-dismissible"><p>Test email sent to: ' . esc_html( implode( ', ', $recipients ) ) . '</p></div>';
		} else {
			echo '<div class="notice notice-error is-dismissible"><p>Could not send the test email. Check your server email configuration (an SMTP plugin is often required).</p></div>';
		}
	}

	$current = get_option( 'gp_notify_email', '' );
	$fallback = get_option( 'admin_email' );
	?>
	<div class="wrap">
		<h1>Form Notifications</h1>
		<p>Configure where email alerts are sent when someone submits the <strong>Free Trial</strong> (page &amp; popup) or <strong>Contact</strong> form. Every submission is always saved under <em>Trial Requests</em> and <em>Contact Messages</em> regardless of these settings.</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'gp_form_settings' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">Email notifications</th>
					<td>
						<label>
							<input type="checkbox" name="gp_notify_enabled" value="1" <?php checked( gp_notifications_enabled() ); ?>>
							Send an email when a form is submitted
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_notify_email">Notification email(s)</label></th>
					<td>
						<textarea name="gp_notify_email" id="gp_notify_email" rows="3" class="large-text code" placeholder="<?php echo esc_attr( $fallback ); ?>"><?php echo esc_textarea( $current ); ?></textarea>
						<p class="description">
							Where to send submission alerts. Separate multiple addresses with a comma or new line.<br>
							Leave empty to use the site admin email (<code><?php echo esc_html( $fallback ); ?></code>).
						</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Save Settings' ); ?>
		</form>

		<hr>
		<h2>Send a test email</h2>
		<p>Send a test message to the address(es) above to confirm delivery works.</p>
		<form method="post">
			<?php wp_nonce_field( 'gp_send_test_email', 'gp_test_nonce' ); ?>
			<?php submit_button( 'Send Test Email', 'secondary', 'gp_send_test', false ); ?>
		</form>
	</div>
	<?php
}

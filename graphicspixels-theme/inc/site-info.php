<?php
/**
 * Editable site contact info (address, phone, WhatsApp) — Appearance ->
 * Site Info. Header/footer pull from these options instead of hardcoded
 * values, so an admin can update them without a developer.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gp_site_info_defaults() {
	return array(
		'address'       => 'Unit 4, Storm 12 Plaza Shopping Centre, 54 St Marys Road, Southampton, United Kingdom, SO14 0BH',
		'phone'         => '+44 7462 284915',
		'phone_link'    => '+447462284915',
		'email'         => 'info@graphicspixels.com',
		'whatsapp_link' => 'https://wa.me/8801890373731',
	);
}

/**
 * Get a single site-info value, falling back to the original default.
 */
function gp_site_info( $key ) {
	$defaults = gp_site_info_defaults();
	$saved    = get_option( 'gp_site_info', array() );
	if ( isset( $saved[ $key ] ) && '' !== trim( (string) $saved[ $key ] ) ) {
		return $saved[ $key ];
	}
	return isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
}

add_action( 'admin_menu', function () {
	add_theme_page(
		'Site Info (Address & Phone)',
		'Site Info',
		'manage_options',
		'gp-site-info',
		'gp_render_site_info_page'
	);
} );

add_action( 'admin_init', function () {
	register_setting( 'gp_site_info_group', 'gp_site_info', array(
		'type'              => 'array',
		'sanitize_callback' => 'gp_sanitize_site_info',
		'default'           => array(),
	) );
} );

function gp_sanitize_site_info( $input ) {
	return array(
		'address'       => sanitize_textarea_field( $input['address'] ?? '' ),
		'phone'         => sanitize_text_field( $input['phone'] ?? '' ),
		'phone_link'    => preg_replace( '/[^0-9+]/', '', $input['phone_link'] ?? '' ),
		'email'         => sanitize_email( $input['email'] ?? '' ),
		'whatsapp_link' => esc_url_raw( $input['whatsapp_link'] ?? '' ),
	);
}

function gp_render_site_info_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$v = gp_site_info_defaults();
	$saved = get_option( 'gp_site_info', array() );
	foreach ( $v as $key => $default ) {
		if ( isset( $saved[ $key ] ) && '' !== trim( (string) $saved[ $key ] ) ) {
			$v[ $key ] = $saved[ $key ];
		}
	}
	?>
	<div class="wrap">
		<h1>Site Info</h1>
		<p>Update the address, phone and WhatsApp number shown in the header and footer across the whole site — no developer needed. Leave a field empty to fall back to the original default.</p>

		<form method="post" action="options.php">
			<?php settings_fields( 'gp_site_info_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="gp_address">Address</label></th>
					<td>
						<textarea name="gp_site_info[address]" id="gp_address" rows="2" class="large-text"><?php echo esc_textarea( $v['address'] ); ?></textarea>
						<p class="description">Shown in the footer.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_phone">Phone (displayed)</label></th>
					<td>
						<input type="text" name="gp_site_info[phone]" id="gp_phone" class="regular-text" value="<?php echo esc_attr( $v['phone'] ); ?>" placeholder="+44 7462 284915">
						<p class="description">The text shown to visitors, e.g. <code>+44 7462 284915</code>.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_phone_link">Phone (tel: link)</label></th>
					<td>
						<input type="text" name="gp_site_info[phone_link]" id="gp_phone_link" class="regular-text" value="<?php echo esc_attr( $v['phone_link'] ); ?>" placeholder="+447462284915">
						<p class="description">Digits only (with leading <code>+</code> and country code, no spaces) — used for the tap-to-call link.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_email">Email</label></th>
					<td>
						<input type="email" name="gp_site_info[email]" id="gp_email" class="regular-text" value="<?php echo esc_attr( $v['email'] ); ?>" placeholder="info@graphicspixels.com">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_whatsapp">WhatsApp link</label></th>
					<td>
						<input type="url" name="gp_site_info[whatsapp_link]" id="gp_whatsapp" class="regular-text" value="<?php echo esc_attr( $v['whatsapp_link'] ); ?>" placeholder="https://wa.me/8801890373731">
						<p class="description">Full <code>https://wa.me/&lt;number&gt;</code> link used by the floating WhatsApp button.</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Save Site Info' ); ?>
		</form>
	</div>
	<?php
}

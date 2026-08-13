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

		// Contact page — UK office box
		'uk_address'    => "Unit 4, Storm 12 Plaza Shopping\nCentre, 56 St Marys Road,\nSouthampton, United Kingdom",
		'uk_phone'      => '+44 7462 284915',
		'uk_phone_link' => '+447462284915',
		'uk_email'      => 'info@graphicspixels.com',

		// Contact page — Bangladesh office box
		'bd_address'    => "House # 31, Road # 3 (New),\nDhanmondi, Dhaka-1209\nBangladesh",
		'bd_phone'      => 'Phone number: +880 1890-373731',
		'bd_phone_link' => '+8801890373731',
		'bd_email'      => 'info@graphicspixels.com',
		'bd_skype'      => 'live:csd.rafy23',
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

		'uk_address'    => sanitize_textarea_field( $input['uk_address'] ?? '' ),
		'uk_phone'      => sanitize_text_field( $input['uk_phone'] ?? '' ),
		'uk_phone_link' => preg_replace( '/[^0-9+]/', '', $input['uk_phone_link'] ?? '' ),
		'uk_email'      => sanitize_email( $input['uk_email'] ?? '' ),

		'bd_address'    => sanitize_textarea_field( $input['bd_address'] ?? '' ),
		'bd_phone'      => sanitize_text_field( $input['bd_phone'] ?? '' ),
		'bd_phone_link' => preg_replace( '/[^0-9+]/', '', $input['bd_phone_link'] ?? '' ),
		'bd_email'      => sanitize_email( $input['bd_email'] ?? '' ),
		'bd_skype'      => sanitize_text_field( $input['bd_skype'] ?? '' ),
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
		<p>Update the address, phone and WhatsApp number shown in the header and footer, plus the two office boxes on the Contact page — no developer needed. Leave a field empty to fall back to the original default.</p>

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

			<h2>Office Locations <span class="description" style="font-weight: normal;">(shown on the Contact page)</span></h2>

			<h3>UK Office — Corporate Office</h3>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="gp_uk_address">Address</label></th>
					<td>
						<textarea name="gp_site_info[uk_address]" id="gp_uk_address" rows="3" class="large-text"><?php echo esc_textarea( $v['uk_address'] ); ?></textarea>
						<p class="description">One line per address line — each line break shows as a new line on the Contact page.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_uk_phone">Phone (displayed)</label></th>
					<td><input type="text" name="gp_site_info[uk_phone]" id="gp_uk_phone" class="regular-text" value="<?php echo esc_attr( $v['uk_phone'] ); ?>" placeholder="+44 7462 284915"></td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_uk_phone_link">Phone (tel: link)</label></th>
					<td>
						<input type="text" name="gp_site_info[uk_phone_link]" id="gp_uk_phone_link" class="regular-text" value="<?php echo esc_attr( $v['uk_phone_link'] ); ?>" placeholder="+447462284915">
						<p class="description">Digits only, with leading <code>+</code> and country code, no spaces.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_uk_email">Email</label></th>
					<td><input type="email" name="gp_site_info[uk_email]" id="gp_uk_email" class="regular-text" value="<?php echo esc_attr( $v['uk_email'] ); ?>" placeholder="info@graphicspixels.com"></td>
				</tr>
			</table>

			<h3>Bangladesh Office — Post-Production House</h3>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="gp_bd_address">Address</label></th>
					<td>
						<textarea name="gp_site_info[bd_address]" id="gp_bd_address" rows="3" class="large-text"><?php echo esc_textarea( $v['bd_address'] ); ?></textarea>
						<p class="description">One line per address line — each line break shows as a new line on the Contact page.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_bd_phone">Phone (displayed)</label></th>
					<td><input type="text" name="gp_site_info[bd_phone]" id="gp_bd_phone" class="regular-text" value="<?php echo esc_attr( $v['bd_phone'] ); ?>" placeholder="+880 1890-373731"></td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_bd_phone_link">Phone (tel: link)</label></th>
					<td>
						<input type="text" name="gp_site_info[bd_phone_link]" id="gp_bd_phone_link" class="regular-text" value="<?php echo esc_attr( $v['bd_phone_link'] ); ?>" placeholder="+8801890373731">
						<p class="description">Digits only, with leading <code>+</code> and country code, no spaces.</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_bd_email">Email</label></th>
					<td><input type="email" name="gp_site_info[bd_email]" id="gp_bd_email" class="regular-text" value="<?php echo esc_attr( $v['bd_email'] ); ?>" placeholder="info@graphicspixels.com"></td>
				</tr>
				<tr>
					<th scope="row"><label for="gp_bd_skype">Skype</label></th>
					<td>
						<input type="text" name="gp_site_info[bd_skype]" id="gp_bd_skype" class="regular-text" value="<?php echo esc_attr( $v['bd_skype'] ); ?>" placeholder="live:csd.rafy23">
						<p class="description">Skype username only, e.g. <code>live:csd.rafy23</code> — no need to include "skype:" or "?chat".</p>
					</td>
				</tr>
			</table>

			<?php submit_button( 'Save Site Info' ); ?>
		</form>
	</div>
	<?php
}

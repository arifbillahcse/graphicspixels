<?php
/**
 * Country dial-code selector, shared by every phone field on the site
 * (free trial widgets, contact form, footer modal). Centralizing this
 * here means the country list and markup only need to be maintained in
 * one place.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gp_phone_country_codes() {
	return array(
		'GB' => array( '🇬🇧', 'United Kingdom', '+44' ),
		'BD' => array( '🇧🇩', 'Bangladesh', '+880' ),
		'US' => array( '🇺🇸', 'United States', '+1' ),
		'AU' => array( '🇦🇺', 'Australia', '+61' ),
		'CA' => array( '🇨🇦', 'Canada', '+1' ),
		'DE' => array( '🇩🇪', 'Germany', '+49' ),
		'FR' => array( '🇫🇷', 'France', '+33' ),
		'IT' => array( '🇮🇹', 'Italy', '+39' ),
		'ES' => array( '🇪🇸', 'Spain', '+34' ),
		'NL' => array( '🇳🇱', 'Netherlands', '+31' ),
		'IE' => array( '🇮🇪', 'Ireland', '+353' ),
		'SE' => array( '🇸🇪', 'Sweden', '+46' ),
		'NO' => array( '🇳🇴', 'Norway', '+47' ),
		'DK' => array( '🇩🇰', 'Denmark', '+45' ),
		'FI' => array( '🇫🇮', 'Finland', '+358' ),
		'CH' => array( '🇨🇭', 'Switzerland', '+41' ),
		'BE' => array( '🇧🇪', 'Belgium', '+32' ),
		'AT' => array( '🇦🇹', 'Austria', '+43' ),
		'PT' => array( '🇵🇹', 'Portugal', '+351' ),
		'PL' => array( '🇵🇱', 'Poland', '+48' ),
		'GR' => array( '🇬🇷', 'Greece', '+30' ),
		'NZ' => array( '🇳🇿', 'New Zealand', '+64' ),
		'ZA' => array( '🇿🇦', 'South Africa', '+27' ),
		'AE' => array( '🇦🇪', 'United Arab Emirates', '+971' ),
		'SA' => array( '🇸🇦', 'Saudi Arabia', '+966' ),
		'QA' => array( '🇶🇦', 'Qatar', '+974' ),
		'IN' => array( '🇮🇳', 'India', '+91' ),
		'PK' => array( '🇵🇰', 'Pakistan', '+92' ),
		'LK' => array( '🇱🇰', 'Sri Lanka', '+94' ),
		'NP' => array( '🇳🇵', 'Nepal', '+977' ),
		'CN' => array( '🇨🇳', 'China', '+86' ),
		'JP' => array( '🇯🇵', 'Japan', '+81' ),
		'KR' => array( '🇰🇷', 'South Korea', '+82' ),
		'SG' => array( '🇸🇬', 'Singapore', '+65' ),
		'MY' => array( '🇲🇾', 'Malaysia', '+60' ),
		'ID' => array( '🇮🇩', 'Indonesia', '+62' ),
		'PH' => array( '🇵🇭', 'Philippines', '+63' ),
		'VN' => array( '🇻🇳', 'Vietnam', '+84' ),
		'TH' => array( '🇹🇭', 'Thailand', '+66' ),
		'HK' => array( '🇭🇰', 'Hong Kong', '+852' ),
		'BR' => array( '🇧🇷', 'Brazil', '+55' ),
		'MX' => array( '🇲🇽', 'Mexico', '+52' ),
		'AR' => array( '🇦🇷', 'Argentina', '+54' ),
		'TR' => array( '🇹🇷', 'Turkey', '+90' ),
		'EG' => array( '🇪🇬', 'Egypt', '+20' ),
		'NG' => array( '🇳🇬', 'Nigeria', '+234' ),
		'KE' => array( '🇰🇪', 'Kenya', '+254' ),
		'IL' => array( '🇮🇱', 'Israel', '+972' ),
		'RU' => array( '🇷🇺', 'Russia', '+7' ),
		'UA' => array( '🇺🇦', 'Ukraine', '+380' ),
		'RO' => array( '🇷🇴', 'Romania', '+40' ),
		'CZ' => array( '🇨🇿', 'Czech Republic', '+420' ),
	);
}

/**
 * Echo the full phone field: country-code select + number input, wrapped
 * so they lay out side by side wherever a plain <input type="tel"> used to be.
 *
 * @param bool   $required     Whether the phone number is required.
 * @param string $default_iso2 ISO2 code pre-selected.
 * @param array  $args         Optional: 'id' (applied to the number input, for a <label for="">),
 *                              'style' (inline style applied to both select and input, to match
 *                              a form that styles fields inline rather than via .free-trial-form).
 */
function gp_render_phone_field( $required = true, $default_iso2 = 'GB', $args = array() ) {
	$id    = $args['id'] ?? '';
	$style = $args['style'] ?? '';

	echo '<div class="gp-phone-field">';
	printf( '<select name="phone_cc" class="gp-phone-cc" aria-label="Country code"%s%s>',
		$style ? ' style="' . esc_attr( $style ) . '"' : '',
		$required ? ' required' : ''
	);
	foreach ( gp_phone_country_codes() as $iso2 => $info ) {
		list( $flag, $name, $dial ) = $info;
		printf(
			'<option value="%s"%s>%s %s %s</option>',
			esc_attr( $dial ),
			selected( $iso2, $default_iso2, false ),
			esc_html( $flag ),
			esc_html( $dial ),
			esc_html( $name )
		);
	}
	echo '</select>';
	printf(
		'<input type="tel" name="phone_number"%s placeholder="Phone number%s" pattern="[0-9 \-()]{6,15}" title="Enter a valid phone number (6-15 digits)"%s%s>',
		$id ? ' id="' . esc_attr( $id ) . '"' : '',
		$required ? '*' : '',
		$required ? ' required' : '',
		$style ? ' style="' . esc_attr( $style ) . '"' : ''
	);
	echo '</div>';
}

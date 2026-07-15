<?php
/**
 * Graphics Pixels theme functions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GP_THEME_VERSION', '1.0.6' );

require get_template_directory() . '/inc/submissions.php';
require get_template_directory() . '/inc/auto-pages.php';
require get_template_directory() . '/inc/site-info.php';

/**
 * Base URL for the site's static images.
 *
 * Images live in wp-content/uploads/graphicspixels/ (outside the theme, so
 * the theme package stays lean). Every template references images through
 * this helper, so the origin can be changed in one place — e.g. point it at
 * a CDN by adding to wp-config.php:
 *
 *   define( 'GP_MEDIA_URL', 'https://cdn.example.com/graphicspixels' );
 *
 * Templates append '/images/...' to this base, matching the folder you
 * upload to wp-content/uploads/graphicspixels/images/.
 */
function gp_media_base() {
	if ( defined( 'GP_MEDIA_URL' ) && GP_MEDIA_URL ) {
		return untrailingslashit( GP_MEDIA_URL );
	}
	return content_url( '/uploads/graphicspixels' );
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
} );

/**
 * Per-page-template extra assets. Every page also gets the global bundle below.
 */
function gp_template_assets() {
	return array(
		'front-page'                                    => array( 'js' => array( 'home-animations' ) ),
		'template-about-us.php'                         => array( 'js' => array( 'about-animations' ), 'css' => array( 'about' ) ),
		'template-contact.php'                          => array( 'js' => array( 'contact-animations' ) ),
		'template-pricing.php'                          => array( 'js' => array( 'pricing-animations' ), 'css' => array( 'pricing' ) ),
		'template-video-editing.php'                    => array( 'js' => array( 'video-animations' ) ),
		'template-3d-product-modeling-service.php'      => array( 'js' => array( 'pe-animations', 'model-viewer' ) ),
		'template-3d-rendering-service.php'             => array( 'js' => array( 'pe-animations' ) ),
		'template-ai-generated-image-fixes.php'         => array( 'js' => array( 'pe-animations' ) ),
		'template-background-removal-service.php'       => array( 'js' => array( 'pe-animations' ) ),
		'template-clipping-path-service.php'            => array( 'js' => array( 'pe-animations' ) ),
		'template-color-correction-service.php'         => array( 'js' => array( 'pe-animations' ) ),
		'template-drop-shadow-service.php'              => array( 'js' => array( 'pe-animations' ) ),
		'template-ecommerce-image-editing-services.php' => array( 'js' => array( 'pe-animations' ) ),
		'template-ghost-mannequin-service.php'          => array( 'js' => array( 'pe-animations' ) ),
		'template-headshot-photo-editing.php'           => array( 'js' => array( 'pe-animations' ) ),
		'template-image-masking-service.php'            => array( 'js' => array( 'pe-animations' ) ),
		'template-photo-editing.php'                    => array( 'js' => array( 'pe-animations' ) ),
		'template-photo-restoration-service.php'        => array( 'js' => array( 'pe-animations' ) ),
		'template-photo-retouching-service.php'         => array( 'js' => array( 'pe-animations' ) ),
		'template-portfolio.php'                        => array( 'js' => array( 'pe-animations' ) ),
	);
}

add_action( 'wp_enqueue_scripts', function () {
	$uri = get_template_directory_uri();

	/* ── Global styles ── */
	wp_enqueue_style( 'gp-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'gp-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1' );
	wp_enqueue_style( 'gp-main', $uri . '/css/style.css', array(), GP_THEME_VERSION );
	wp_enqueue_style( 'gp-theme', get_stylesheet_uri(), array( 'gp-main' ), GP_THEME_VERSION );

	/* ── Global scripts ── */
	wp_enqueue_script( 'gp-script', $uri . '/js/script.js', array(), GP_THEME_VERSION, true );
	wp_enqueue_script( 'gp-footer', $uri . '/js/footer.js', array(), GP_THEME_VERSION, true );
	wp_enqueue_script( 'gp-forms', $uri . '/js/wp-forms.js', array(), GP_THEME_VERSION, true );
	wp_localize_script( 'gp-forms', 'gpForms', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'gp_form_submit' ),
	) );

	/* ── Registered (loaded only where needed) ── */
	wp_register_script( 'home-animations', $uri . '/js/home-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'about-animations', $uri . '/js/about-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'contact-animations', $uri . '/js/contact-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'pricing-animations', $uri . '/js/pricing-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'video-animations', $uri . '/js/video-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'pe-animations', $uri . '/js/pe-animations.js', array(), GP_THEME_VERSION, true );
	wp_register_script( 'model-viewer', 'https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js', array(), null, true );
	wp_register_style( 'about', $uri . '/css/about.css', array( 'gp-main' ), GP_THEME_VERSION );
	wp_register_style( 'pricing', $uri . '/css/pricing.css', array( 'gp-main' ), GP_THEME_VERSION );

	/* ── Conditional per-template ── */
	$map    = gp_template_assets();
	$active = null;
	if ( is_front_page() ) {
		$active = 'front-page';
	} else {
		$tpl = get_page_template_slug();
		if ( $tpl && isset( $map[ $tpl ] ) ) {
			$active = $tpl;
		} elseif ( is_page( 'about-us' ) ) {
			// Fallback: guarantees about.css/about-animations still load even if
			// the page's assigned template got reset to Default in wp-admin.
			$active = 'template-about-us.php';
		}
	}
	if ( $active ) {
		foreach ( $map[ $active ]['js'] ?? array() as $handle ) {
			wp_enqueue_script( $handle );
		}
		foreach ( $map[ $active ]['css'] ?? array() as $handle ) {
			wp_enqueue_style( $handle );
		}
	}
} );

/**
 * Fallback thumbnail URL for posts without a featured image.
 *
 * Defaults to the bundled branded placeholder. Override with a specific
 * image (e.g. a Media Library URL) by adding to wp-config.php:
 *   define( 'GP_DEFAULT_THUMB', 'https://example.com/path/to/image.jpg' );
 */
function gp_default_thumb_url() {
	if ( defined( 'GP_DEFAULT_THUMB' ) && GP_DEFAULT_THUMB ) {
		return GP_DEFAULT_THUMB;
	}
	return get_template_directory_uri() . '/assets/blog-placeholder.svg';
}

/**
 * Echo a post's thumbnail <img>, falling back to the default placeholder.
 *
 * @param string $size WordPress image size for the real featured image.
 */
function gp_post_thumbnail( $size = 'medium_large' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $size );
		return;
	}
	printf(
		'<img src="%s" alt="%s" loading="lazy">',
		esc_url( gp_default_thumb_url() ),
		esc_attr( get_the_title() )
	);
}

/* ── Disable comments site-wide (no commenting on posts/pages) ── */
add_action( 'init', function () {
	// Close comments/pings on all post types that support them.
	foreach ( get_post_types() as $type ) {
		if ( post_type_supports( $type, 'comments' ) ) {
			remove_post_type_support( $type, 'comments' );
			remove_post_type_support( $type, 'trackbacks' );
		}
	}
} );
// Refuse new comments and report threads as closed.
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );
// Hide any existing comments.
add_filter( 'comments_array', '__return_empty_array', 20, 2 );
// Remove the admin Comments menu and toolbar item.
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );
add_action( 'wp_before_admin_bar_render', function () {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
} );

/* model-viewer must load as an ES module */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( 'model-viewer' === $handle ) {
		$tag = str_replace( '<script ', '<script type="module" ', $tag );
	}
	return $tag;
}, 10, 2 );

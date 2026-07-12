<?php
/**
 * Auto-create the site's pages (with the correct page template assigned)
 * so they appear under Pages → All Pages without manual setup.
 *
 * Runs once when the theme is activated. Also available on demand via
 * Appearance → Create Pages. It never duplicates or overwrites: a page is
 * only created when no page with that slug already exists.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The full page map: slug => [ title, template ].
 * An empty template means the default (Home uses front-page.php automatically).
 */
function gp_page_definitions() {
	return array(
		'home'                              => array( 'Home', '' ),
		'services'                          => array( 'Services', 'template-services.php' ),
		'clipping-path-service'             => array( 'Clipping Path Service', 'template-clipping-path-service.php' ),
		'photo-retouching-service'          => array( 'Photo Retouching Service', 'template-photo-retouching-service.php' ),
		'ghost-mannequin-service'           => array( 'Ghost Mannequin Service', 'template-ghost-mannequin-service.php' ),
		'headshot-photo-editing'            => array( 'Headshot Photo Editing', 'template-headshot-photo-editing.php' ),
		'background-removal-service'        => array( 'Background Removal Service', 'template-background-removal-service.php' ),
		'color-correction-service'          => array( 'Color Correction Service', 'template-color-correction-service.php' ),
		'drop-shadow-service'               => array( 'Drop Shadow Service', 'template-drop-shadow-service.php' ),
		'image-masking-service'             => array( 'Image Masking Service', 'template-image-masking-service.php' ),
		'ecommerce-image-editing-services'  => array( 'E-commerce Image Editing', 'template-ecommerce-image-editing-services.php' ),
		'photo-restoration-service'         => array( 'Photo Restoration Service', 'template-photo-restoration-service.php' ),
		'ai-generated-image-fixes'          => array( 'AI-generated Image Fixes', 'template-ai-generated-image-fixes.php' ),
		'photo-editing'                     => array( 'Photo Editing', 'template-photo-editing.php' ),
		'3d-service'                        => array( '3D Service', 'template-3d-service.php' ),
		'3d-product-modeling-service'       => array( '3D Product Modeling', 'template-3d-product-modeling-service.php' ),
		'3d-rendering-service'              => array( '3D Rendering', 'template-3d-rendering-service.php' ),
		'video-editing'                     => array( 'Video Editing', 'template-video-editing.php' ),
		'portfolio'                         => array( 'Portfolio', 'template-portfolio.php' ),
		'portfolio2'                        => array( 'Portfolio 2', 'template-portfolio2.php' ),
		'pricing'                           => array( 'Pricing', 'template-pricing.php' ),
		'about-us'                          => array( 'About Us', 'template-about-us.php' ),
		'contact'                           => array( 'Contact', 'template-contact.php' ),
		'free-trial'                        => array( 'Free Trial', 'template-free-trial.php' ),
		'faq'                               => array( 'FAQ', 'template-faq.php' ),
		'blog'                              => array( 'Blog', 'template-blog.php' ),
		'reviews'                           => array( 'Reviews', 'template-reviews.php' ),
		'freistellen-bilder-ecommerce'      => array( 'Clipping Path (DE)', 'template-freistellen-bilder-ecommerce.php' ),
		'recorte-fotografia-ecommerce'      => array( 'Clipping Path (ES)', 'template-recorte-fotografia-ecommerce.php' ),
		'detourage-image-ecommerce'         => array( 'Clipping Path (FR)', 'template-detourage-image-ecommerce.php' ),
		'scontorno-immagini-ecommerce'      => array( 'Clipping Path (IT)', 'template-scontorno-immagini-ecommerce.php' ),
	);
}

/**
 * Create any pages that do not yet exist.
 *
 * @return array List of slugs that were created this run.
 */
function gp_create_pages() {
	$created = array();

	foreach ( gp_page_definitions() as $slug => $def ) {
		list( $title, $template ) = $def;

		// Skip if a page with this slug already exists — never duplicate.
		if ( get_page_by_path( $slug, OBJECT, 'page' ) ) {
			continue;
		}

		$postarr = array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		);
		if ( $template ) {
			$postarr['meta_input'] = array( '_wp_page_template' => $template );
		}

		$page_id = wp_insert_post( $postarr );
		if ( $page_id && ! is_wp_error( $page_id ) ) {
			$created[] = $slug;
		}
	}

	return $created;
}

/* Run once, automatically, when the theme is activated. */
add_action( 'after_switch_theme', 'gp_create_pages' );

/* ── On-demand "Create Pages" button under Appearance ── */
add_action( 'admin_menu', function () {
	add_theme_page(
		'Create Theme Pages',
		'Create Pages',
		'manage_options',
		'gp-create-pages',
		'gp_render_create_pages'
	);
} );

function gp_render_create_pages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$created = null;
	if ( isset( $_POST['gp_create_pages'] ) && check_admin_referer( 'gp_create_pages', 'gp_create_nonce' ) ) {
		$created = gp_create_pages();
	}

	$defs  = gp_page_definitions();
	$total = count( $defs );
	?>
	<div class="wrap">
		<h1>Create Theme Pages</h1>
		<p>This creates all <?php echo (int) $total; ?> Graphics Pixels pages (each already
		linked to its correct template) so they appear under <strong>Pages → All Pages</strong>.
		It is safe to run repeatedly — existing pages are left untouched, nothing is duplicated
		or overwritten.</p>

		<?php if ( is_array( $created ) ) : ?>
			<div class="notice notice-success is-dismissible">
				<?php if ( $created ) : ?>
					<p><strong><?php echo count( $created ); ?></strong> page(s) created: <?php echo esc_html( implode( ', ', $created ) ); ?></p>
				<?php else : ?>
					<p>All pages already exist — nothing to create.</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<form method="post">
			<?php wp_nonce_field( 'gp_create_pages', 'gp_create_nonce' ); ?>
			<?php submit_button( 'Create / Repair Pages', 'primary', 'gp_create_pages' ); ?>
		</form>

		<h2>Current status</h2>
		<table class="widefat striped" style="max-width:760px">
			<thead><tr><th>Title</th><th>Slug</th><th>Template</th><th>Status</th></tr></thead>
			<tbody>
			<?php foreach ( $defs as $slug => $def ) :
				$exists = (bool) get_page_by_path( $slug, OBJECT, 'page' ); ?>
				<tr>
					<td><?php echo esc_html( $def[0] ); ?></td>
					<td><code><?php echo esc_html( $slug ); ?></code></td>
					<td><?php echo $def[1] ? '<code>' . esc_html( $def[1] ) . '</code>' : '<em>default (Home)</em>'; ?></td>
					<td><?php echo $exists ? '<span style="color:#1a7f4e">✓ exists</span>' : '<span style="color:#c0392b">— missing</span>'; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}

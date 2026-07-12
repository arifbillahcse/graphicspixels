<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo esc_url( gp_media_base() ); ?>/images/graphics-pixels-logo-2-HR.png">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- ============ HEADER / NAVIGATION ============ -->
<header class="header" id="header">
    <div class="container nav-container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/graphics-pixels-logo-2-HR.png" alt="Graphics Pixels Logo">
        </a>
        <nav class="nav" id="nav-menu">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="nav-link">Services</a></li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">Photo Editing <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu dropdown-wide">
                        <li><a href="<?php echo esc_url( home_url( '/clipping-path-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Clipping Path service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/photo-retouching-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Photo Retouching service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/ghost-mannequin-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Ghost Mannequin service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/headshot-photo-editing/' ) ); ?>"><i class="fas fa-chevron-right"></i> Headshot photo editing</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/background-removal-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Background Removal service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/color-correction-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Color Correction Service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/drop-shadow-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Drop Shadow Service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/image-masking-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Image Masking service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/ecommerce-image-editing-services/' ) ); ?>"><i class="fas fa-chevron-right"></i> E-commerce Image Editing</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/photo-restoration-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> Photo Restoration Service</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/ai-generated-image-fixes/' ) ); ?>"><i class="fas fa-chevron-right"></i> AI-generated Image Fixes</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link">3D Service <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo esc_url( home_url( '/3d-product-modeling-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> 3D Modeling</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/3d-rendering-service/' ) ); ?>"><i class="fas fa-chevron-right"></i> 3D Rendering</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/video-editing/' ) ); ?>" class="nav-link">Video Editing</a></li>
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/portfolio/' ) ); ?>" class="nav-link">Portfolio</a></li>
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>" class="nav-link">Pricing</a></li>
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="nav-link">Contact</a></li>
            </ul>
            <a href="#free-trial" class="btn btn-primary nav-cta">Free Trial</a>
        </nav>
        <button class="nav-toggle" id="nav-toggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</header>

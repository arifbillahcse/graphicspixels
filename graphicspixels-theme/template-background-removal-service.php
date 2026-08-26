<?php /* Template Name: Background Removal Service */ ?>
<?php get_header(); ?>

<style>
        .ba-slider {
            position: relative; border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow-lg); aspect-ratio: 4 / 3;
            cursor: ew-resize; user-select: none; background: #f4f4f8;
        }
        .ba-before, .ba-after { position: absolute; inset: 0; overflow: hidden; }
        .ba-before img, .ba-after img {
            width: 100%; height: 100%; object-fit: contain; padding: 8px;
            display: block; pointer-events: none;
        }
        .ba-after { clip-path: inset(0 50% 0 0); }
        .ba-label {
            position: absolute; bottom: 12px; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px; color: #fff;
            padding: 4px 10px; border-radius: 100px; backdrop-filter: blur(4px); pointer-events: none;
        }
        .ba-before .ba-label { left: 12px; background: rgba(1,1,94,0.80); }
        .ba-after  .ba-label { right: 12px; background: rgba(195,0,157,0.85); }
        .ba-divider {
            position: absolute; top: 0; bottom: 0; left: 50%;
            width: 3px; background: #fff; transform: translateX(-50%);
            z-index: 3; pointer-events: none;
        }
        .ba-handle {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 44px; height: 44px; border-radius: 50%;
            background: #fff; border: 3px solid var(--navy, #01015E);
            box-shadow: 0 2px 16px rgba(0,0,0,0.3);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; color: var(--navy, #01015E);
            pointer-events: none;
        }
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Background Removal service/graphics-pixels-5.png');
            background-size: auto calc(100% - 100px);
            background-position: right bottom;
            background-repeat: no-repeat;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding-top: 80px;
            box-sizing: border-box;
        }
        .ds-showcase-content {
            position: relative; z-index: 2;
            max-width: 52%;
            padding: 80px 0;
        }
        .ds-showcase-eyebrow {
            display: inline-block;
            background: rgba(1,1,94,0.08);
            color: #01015E; font-size: 12px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 6px 16px; border-radius: 50px;
            margin-bottom: 20px;
        }
        .ds-showcase-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 38px; font-weight: 700;
            color: #01015E; margin-bottom: 16px; line-height: 1.2;
        }
        .ds-showcase-content .ds-lead {
            font-weight: 600; font-size: 17px;
            color: #111;
            margin-bottom: 14px; line-height: 1.6;
        }
        .ds-showcase-content p {
            font-size: 15px; color: #000;
            line-height: 1.75; margin-bottom: 32px;
        }
        .ds-showcase-actions { display: flex; gap: 16px; flex-wrap: wrap; }
        @media (max-width: 768px) {
            .ds-showcase {
                height: auto;
                flex-direction: column;
                background-image: none;
                padding-top: 90px;
                display: flex;
                align-items: stretch;
                justify-content: flex-start;
            }
            .ds-showcase-image {
                display: block;
                width: 100%;
                aspect-ratio: 1108 / 874;
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Background Removal service/graphics-pixels-5.png');
                background-size: contain;
                background-position: center;
                background-repeat: no-repeat;
                margin-bottom: 24px;
            }
            .ds-showcase-content {
                max-width: 100%;
                padding: 0 20px 40px;
                width: 100%;
            }
            .ds-showcase-content h2 { font-size: 26px; }
        }
        @media (min-width: 769px) {
            .ds-showcase-image { display: none; }
        }
        /* Reduce top padding for intro section */
        .cp-intro {
            padding-top: 40px !important;
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Background Removal Service</span>
                <h2>Background Removal Service — Manual Editing, All Product Types</h2>
                <p class="ds-lead">Professional background removal for product photography, e-commerce listings, and portraits — every image edited by hand with clipping path or masking, never automated.</p>
                <p>Pure white for Amazon and eBay compliance, transparent PNG, custom brand colour, or full background replacement. From $0.20/image, 24-hour turnaround, free trial.</p>

                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS BACKGROUND REMOVAL ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">What Is Background Removal?</h2>
                    <p>Background removal is the process of isolating your subject — a product, person, or object — from its original background so it can be placed on any surface: pure white for marketplace listings, transparent PNG for web, custom brand colour for campaigns, or a lifestyle scene for advertising.</p>
                    <p>At Graphics Pixels, every background is removed by hand using the Photoshop pen tool or layer masking depending on the subject type. Hard-edged products like shoes, electronics, and jewellery use clipping path. Soft-edged subjects like hair, fur, or sheer fabric use masking. We choose the right method for each image without you needing to specify.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/07/images.jpg" alt="Background Removal Service Example" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VIDEO ============ -->
    <section class="pe-video-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">See It In Action</span>
                <h2 class="section-title">Watch How We Remove Backgrounds</h2>
                <p class="section-desc">See our hand-editing process from start to finish — pen tool tracing, edge refinement, and final output preparation. Every step done manually for a result automated tools cannot match.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/Mx_LgUToBdw"
                        title="Professional Background Removal Process"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SERVICES LIST ============ -->
    <section class="svc-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">What We Do</span>
                <h2 class="section-title">Our Background Removal Services</h2>
                <p class="section-desc">From transparent PNG cutouts to full scene compositing — we handle every output type your product photography requires, with manual precision and consistent quality across every image in your batch.</p>
            </div>

            <div class="svc-list">

                <!-- 1. Transparent Background -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/1.%20Our%20services%20for%20removing%20backgrounds/graphics%20pixels%20(2).jpg" alt="Before — Transparent Background Removal">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/1.%20Our%20services%20for%20removing%20backgrounds/graphics%20pixels%20(1).jpg" alt="After — Transparent Background Removal">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-chess-board"></i></span>
                        <h3>Transparent Background Removal</h3>
                        <p>Your subject is isolated and delivered as a PNG or layered PSD with a fully transparent background. Drop it onto any colour, template, or scene and it sits cleanly — no edge haze, no residual background pixels, no semi-transparent fringing. Ready to use as delivered, no further cleanup needed.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Delivered as PNG or layered PSD</li>
                            <li><i class="fas fa-check"></i> Zero residual pixels or halo effect</li>
                            <li><i class="fas fa-check"></i> Works on any background or template</li>
                            <li><i class="fas fa-check"></i> Ideal for Shopify, WooCommerce &amp; web use</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Pure White Background -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/2.%20Our%20retouching%20features/graphics%20pixels%20(1).jpg" alt="Pure White Background for E-commerce" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-square"></i></span>
                        <h3>Pure White Background for Marketplace Listings</h3>
                        <p>Amazon, eBay, Walmart, and most major marketplaces require a pure white background — RGB 255,255,255, no off-white, no grey, no gradient. We prepare your product images to meet those specifications exactly, with the subject correctly positioned, edge detail preserved, and the background uniformly white across the entire image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> RGB 255,255,255 — platform compliant</li>
                            <li><i class="fas fa-check"></i> Amazon, eBay &amp; Walmart ready</li>
                            <li><i class="fas fa-check"></i> Consistent across full product catalog</li>
                            <li><i class="fas fa-check"></i> Edge detail preserved at all zoom levels</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Exact Clipping Path Cutouts -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/3.%20Exact%20Clipping%20Path%20Services%20for%20Clean%20Cutouts/graphics%20pixels%20(1).png" alt="Exact Clipping Path for Clean Cutouts" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-pen-nib"></i></span>
                        <h3>Precise Pen Tool Clipping Path</h3>
                        <p>Hard-edged products — footwear, electronics, packaged goods, jewellery, bags, furniture — require a hand-drawn pen tool path for a clean, accurate cutout. We handle all complexity levels: basic single-path products, compound paths for multi-part subjects, super-complex paths for apparel with holes and interiors, and deep etching for advertising and print-ready output.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> All complexity levels covered</li>
                            <li><i class="fas fa-check"></i> Compound &amp; multi-path subjects</li>
                            <li><i class="fas fa-check"></i> Deep etching for print &amp; advertising</li>
                            <li><i class="fas fa-check"></i> Saved as embedded path in PSD</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Background Merging Services -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/4.%20Background%20Merging%20Services/graphics%20pixels%20(2).jpg" alt="Before — Background Replacement">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/4.%20Background%20Merging%20Services/graphics%20pixels%20(1).jpg" alt="After — Background Replacement">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-layer-group"></i></span>
                        <h3>Background Replacement &amp; Scene Compositing</h3>
                        <p>Product isolated and placed into a lifestyle image, studio environment, or branded scene you supply. We match the edge lighting, shading, and depth so the product reads as part of the original photograph, not a cutout placed on a layer. Used for advertising campaigns, social content, and brand imagery where plain white is not the right fit.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Edge lighting matched to scene</li>
                            <li><i class="fas fa-check"></i> Shadow &amp; reflection added where needed</li>
                            <li><i class="fas fa-check"></i> Seamless natural integration</li>
                            <li><i class="fas fa-check"></i> Used for ads, social &amp; brand campaigns</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Get A Standard Image Look -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/5.%20Get%20A%20Standard%20Image%20Look/graphics%20pixels%20(1).png" alt="Consistent Standard Image Look Across Catalog" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-table-cells-large"></i></span>
                        <h3>Consistent Image Look Across Your Catalog</h3>
                        <p>Inconsistent product images — mismatched backgrounds, varying crop sizes, different colour casts — damage trust in a product catalog. We standardise your library: same background treatment, same crop ratio, same edge quality, and same colour temperature across every image. Buyers notice when your catalog looks uniform. It reads as a professional brand.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Uniform crop &amp; background across all images</li>
                            <li><i class="fas fa-check"></i> Colour temperature standardised per batch</li>
                            <li><i class="fas fa-check"></i> Builds trust in marketplace &amp; brand listings</li>
                            <li><i class="fas fa-check"></i> Bulk rates from 100 images</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ============ HOW IT WORKS ============ -->
    <section class="how-works">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Simple Process</span>
                <h2 class="section-title">How It Works in 4 Steps</h2>
                <p class="section-desc">From upload to delivery — we have streamlined the process to make it effortless for you.</p>
            </div>

            <div class="how-timeline reveal" data-reveal="up" data-delay="100">
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-1"><i class="fas fa-folder-open"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Share Your Files</h3>
                        <p>Upload 1–5 images or share a cloud link. We accept JPG, PNG, PSD, and RAW formats.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-2"><i class="fas fa-pen-to-square"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Tell Us What You Need</h3>
                        <p>Specify your output type — transparent, white, custom colour, or scene replacement. Send a reference if you have one.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-3"><i class="fas fa-magic"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>We Deliver Results</h3>
                        <p>Your edited images are returned within 24 hours, fully prepared and ready for your platform.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-4"><i class="fas fa-check-double"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Revisions Until Perfect</h3>
                        <p>Request changes anytime. Unlimited revisions until every image matches your original brief exactly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VIDEO TESTIMONIALS SECTION ============ -->
    <section class="vt-section">
        <div class="vt-wrap">

            <!-- LEFT: Video Slider -->
            <div class="vt-left reveal" data-reveal="left">
                <div class="vt-track" id="vtTrack">

                    <div class="vt-slide active" data-video-id="U_mQ6MHt-wI">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/U_mQ6MHt-wI/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Tyrell Scott video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Tyrell Scott</span>
                                        <span class="vt-card-company">E-commerce Owner</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="An_AGr0jDMQ">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/An_AGr0jDMQ/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Seb Chandler video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Seb Chandler</span>
                                        <span class="vt-card-company">Fashion Brand Manager</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="y23k3pzTGQw">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/y23k3pzTGQw/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Andrew Porfyri video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Andrew Porfyri</span>
                                        <span class="vt-card-company">Product Photographer</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="L9fTaCA_lvI">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/L9fTaCA_lvI/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Saville Coble video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Saville Coble</span>
                                        <span class="vt-card-company">Agency Creative Director</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="QtF0jp6hfbY">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/QtF0jp6hfbY/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play David Okafor video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">David Okafor</span>
                                        <span class="vt-card-company">E-Commerce Agency Owner</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="HdKJDaa8K2Q">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/HdKJDaa8K2Q/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Sophie Laurent video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Sophie Laurent</span>
                                        <span class="vt-card-company">Studio Owner</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="ymumIHlhIJc">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/ymumIHlhIJc/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play James Mitchell video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">James Mitchell</span>
                                        <span class="vt-card-company">Commercial Photographer</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vt-slide" data-video-id="VCtTRd37F2M">
                        <div class="vt-card">
                            <div class="vt-thumb" style="background-image: url('https://img.youtube.com/vi/VCtTRd37F2M/hqdefault.jpg');">
                                <div class="vt-thumb-overlay"></div>
                                <button class="vt-play" aria-label="Play Anika Berg video"><span class="vt-play-icon"></span></button>
                                <div class="vt-card-footer">
                                    <div class="vt-card-info">
                                        <span class="vt-card-name">Anika Berg</span>
                                        <span class="vt-card-company">Studio Owner, Berlin</span>
                                    </div>
                                    <div class="vt-stars">
                                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- /.vt-track -->

                <div class="vt-controls">
                    <button class="vt-arrow vt-prev" id="vtPrev" aria-label="Previous slide">
                        <span class="vt-chevron vt-chevron-left"></span>
                    </button>
                    <span class="vt-counter">
                        <span id="vtCurrent">1</span>
                        <em>/</em>
                        <span id="vtTotal">4</span>
                    </span>
                    <button class="vt-arrow vt-next" id="vtNext" aria-label="Next slide">
                        <span class="vt-chevron vt-chevron-right"></span>
                    </button>
                </div>
            </div><!-- /.vt-left -->

            <!-- RIGHT: Content -->
            <div class="vt-right reveal" data-reveal="right">
                <div class="vt-stars-top">
                    <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                </div>
                <h2 class="vt-heading">
                    What E-commerce Brands, Product Photographers, and Studios Say About Our Background Removal Service
                </h2>

                <div class="vt-avatars" id="vtAvatars">
                    <button class="vt-avatar active" data-index="0" aria-label="Tyrell Scott">
                        <img src="https://img.youtube.com/vi/U_mQ6MHt-wI/hqdefault.jpg" alt="Tyrell Scott">
                    </button>
                    <button class="vt-avatar" data-index="1" aria-label="Seb Chandler">
                        <img src="https://img.youtube.com/vi/An_AGr0jDMQ/hqdefault.jpg" alt="Seb Chandler">
                    </button>
                    <button class="vt-avatar" data-index="2" aria-label="Andrew Porfyri">
                        <img src="https://img.youtube.com/vi/y23k3pzTGQw/hqdefault.jpg" alt="Andrew Porfyri">
                    </button>
                    <button class="vt-avatar" data-index="3" aria-label="Saville Coble">
                        <img src="https://img.youtube.com/vi/L9fTaCA_lvI/hqdefault.jpg" alt="Saville Coble">
                    </button>
                    <button class="vt-avatar" data-index="4" aria-label="David Okafor">
                        <img src="https://img.youtube.com/vi/QtF0jp6hfbY/hqdefault.jpg" alt="David Okafor">
                    </button>
                    <button class="vt-avatar" data-index="5" aria-label="Sophie Laurent">
                        <img src="https://img.youtube.com/vi/HdKJDaa8K2Q/hqdefault.jpg" alt="Sophie Laurent">
                    </button>
                    <button class="vt-avatar" data-index="6" aria-label="James Mitchell">
                        <img src="https://img.youtube.com/vi/ymumIHlhIJc/hqdefault.jpg" alt="James Mitchell">
                    </button>
                    <button class="vt-avatar" data-index="7" aria-label="Anika Berg">
                        <img src="https://img.youtube.com/vi/VCtTRd37F2M/hqdefault.jpg" alt="Anika Berg">
                    </button>
                </div>

                <a href="<?php echo esc_url( home_url('/reviews/') ); ?>" class="vt-cta">
                    REVIEWS
                    <span class="vt-cta-arrow"></span>
                </a>
            </div><!-- /.vt-right -->

        </div><!-- /.vt-wrap -->

        <!-- YouTube Modal -->
        <div class="vt-modal" id="vtModal">
            <div class="vt-modal-backdrop" id="vtBackdrop"></div>
            <div class="vt-modal-box">
                <button class="vt-modal-close" id="vtClose" aria-label="Close video">
                    <span class="vt-close-icon"></span>
                </button>
                <div class="vt-modal-frame">
                    <iframe id="vtIframe" src="" title="Client review video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FREE TRIAL ============ -->
    <section class="free-trial" id="free-trial">
        <div class="container free-trial-container">
            <div class="free-trial-info reveal" data-reveal="left">
                <span class="section-tag light">Get Started</span>
                <h2 class="section-title light">With the FREE TRIAL</h2>
                <p><strong>Try Our Service Free — Results Back in 24 Hours</strong><br>Send 1 to 5 images and we return them edited to your brief within 24 hours at no charge. No payment required. No commitment to continue.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-credit-card"></i> No upfront payment — review the work before paying</li>
                    <li><i class="fas fa-images"></i> 1 to 5 images edited to your exact specification</li>
                    <li><i class="fas fa-clock"></i> Results returned within 24 hours</li>
                    <li><i class="fas fa-rotate"></i> Unlimited revisions on paid orders until output matches your brief</li>
                    <li><i class="fas fa-lock"></i> NDA-compliant — your files are never shared or repurposed</li>
                    <li><i class="fas fa-tag"></i> Bulk discounts from 100 images</li>
                    <li><i class="fas fa-handshake"></i> Dedicated account handling for studios and agencies</li>
                </ul>
            </div>
            <form class="free-trial-form reveal" data-reveal="right" id="trial-form">
                <div class="form-row">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Add Email*" required>
                </div>
                <div class="form-row">
                    <input type="tel" placeholder="Phone*" required>
                    <input type="url" placeholder="Website*" required>
                </div>
                <select required>
                    <option value="" disabled>Select The Service</option>
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option selected>Background Removal</option>
                    <option>Color Correction</option>
                    <option>Drop Shadow</option>
                    <option>Image Masking</option>
                    <option>E-commerce Image Editing</option>
                    <option>Photo Restoration</option>
                    <option>AI-generated Image Fixes</option>
                </select>
                <textarea placeholder="Your message" rows="3"></textarea>
                <div class="file-upload">
                    <label for="file-input"><i class="fas fa-cloud-arrow-up"></i> Choose a file</label>
                    <input type="file" id="file-input">
                    <span class="file-name">No file chosen</span>
                </div>
                <p class="upload-note">If the size is more than 25 MB, share your images via cloud (Google Drive, Dropbox or WeTransfer).</p>
                <input type="url" placeholder="Paste the link here (URL)">
                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>
        </div>
    </section>

    <!-- ============ FAQ ============ -->
    <section class="faq-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Commonly Asked Questions</h2>
            </div>
            <div class="faq-list reveal" data-reveal="up" data-delay="100">
                <div class="faq-item">
                    <button class="faq-q">What is the difference between clipping path and image masking? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Clipping path uses the pen tool to draw a precise vector outline — best for hard-edged products like shoes, electronics, and jewellery. Image masking handles soft or complex edges like hair, fur, transparent fabric, and glass. We assess each image and apply the correct method automatically — you don't need to specify.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What background options can you deliver? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Transparent PNG, pure white (RGB 255,255,255) for marketplace compliance, custom hex colour for brand use, and background replacement with a lifestyle or studio scene you supply. Mention your requirement in the brief and we'll prepare the output accordingly.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can you handle bulk orders with consistent quality? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We have 120+ in-house editors and handle batches from 10 to 10,000+ images. Send a reference image showing the standard you need and we replicate it consistently across every file in the batch.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How long does background removal take? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Standard turnaround is 24 hours. For larger batches or complex subjects, we agree a timeline at the start. Rush delivery is available — mention it in your brief and we'll confirm availability.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What file formats do you accept and deliver? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We accept JPG, PNG, PSD, TIFF, and RAW. Delivery is in your preferred format — transparent PNG, layered PSD, or flattened JPEG depending on output type. Let us know your platform requirements and we'll match the specification.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is the free trial really free? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Send 1–5 images with a brief and we'll return the finished files within 24 hours — no charge, no obligation. It's designed so you can verify the quality before committing to a paid order.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How much does background removal cost? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Pricing starts from $0.20 per image for simple products on a standard white or transparent background. Complex subjects, multi-path products, and scene compositing are priced based on complexity. Bulk discounts apply from 100 images. Contact us for a quote on your specific batch.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->

    <!-- ============ IMAGE LIGHTBOX ============ -->
    <div class="lightbox" id="svcLightbox" role="dialog" aria-modal="true" aria-label="Image preview">
        <div class="lightbox-backdrop" id="svcLightboxBackdrop"></div>
        <div class="lightbox-container">
            <button class="lightbox-close" id="svcLightboxClose" aria-label="Close lightbox">
                <i class="fas fa-times"></i>
            </button>
            <div class="lightbox-content">
                <img id="svcLightboxImg" class="lightbox-image" src="" alt="">
                <p class="lightbox-title" id="svcLightboxCaption"></p>
            </div>
            <button class="lightbox-nav lightbox-prev" id="svcLightboxPrev" aria-label="Previous image">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" id="svcLightboxNext" aria-label="Next image">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
    document.querySelectorAll('.ba-slider').forEach(function (slider) {
        var after   = slider.querySelector('.ba-after');
        var divider = slider.querySelector('.ba-divider');
        var dragging = false;
        function setPos(clientX) {
            var rect = slider.getBoundingClientRect();
            var pct  = Math.min(100, Math.max(0, (clientX - rect.left) / rect.width * 100));
            after.style.clipPath = 'inset(0 ' + (100 - pct) + '% 0 0)';
            divider.style.left   = pct + '%';
        }
        slider.addEventListener('mousedown',  function (e) { dragging = true; setPos(e.clientX); });
        window.addEventListener('mousemove',  function (e) { if (dragging) setPos(e.clientX); });
        window.addEventListener('mouseup',    function ()  { dragging = false; });
        slider.addEventListener('touchstart', function (e) { dragging = true; setPos(e.touches[0].clientX); }, { passive: true });
        window.addEventListener('touchmove',  function (e) { if (dragging) setPos(e.touches[0].clientX); },   { passive: true });
        window.addEventListener('touchend',   function ()  { dragging = false; }, { passive: true });
    });
    </script>

<?php get_footer(); ?>

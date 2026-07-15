<?php /* Template Name: Clipping Path Service */ ?>
<?php get_header(); ?>

<style>
        /* ---- Before / After drag slider ---- */
        .ba-slider {
            position: relative; border-radius: var(--radius); overflow: hidden;
            box-shadow: var(--shadow-lg); aspect-ratio: 4 / 3;
            cursor: ew-resize; user-select: none; background: #f4f4f8;
        }
        .ba-before, .ba-after {
            position: absolute; inset: 0; overflow: hidden;
        }
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
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Clipping Path service/graphics-pixels-1.png');
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
            font-weight: 600; font-size: 15px;
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Clipping Path service/graphics-pixels-1.png');
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
                <span class="ds-showcase-eyebrow">Clipping Path</span>
                <h2>Professional Clipping Path Service — 100% Manual, Every Complexity Level</h2>
                <p class="ds-lead">A clipping path is a closed vector path drawn by hand around a subject in Photoshop. Everything inside stays; everything outside is removed. The result is a clean, isolated subject ready to drop onto any background — no halos, no fringe, no edge artifacts from batch automation.</p>
                <p>Every path at Graphics Pixels is drawn manually with the Photoshop pen tool. We cover all complexity levels: simple single-path shapes, compound paths for multi-part products, complex paths for furniture and apparel, and super-complex paths for jewelry, lacework, and fine-detailed subjects. Starting from $0.39 per image. Turnaround 24–48 hours. Bulk orders discounted.</p>
                <p>Best for: footwear, packaged goods, electronics, jewelry, bags, furniture, and any product with hard, defined edges. For hair, fur, sheer fabric, or transparent materials — image masking is the right technique. We assess every batch and recommend the correct approach.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS CLIPPING PATH ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">What Is a Clipping Path?</h2>
                    <p>A clipping path is a closed vector path drawn by hand around a subject using the Photoshop pen tool. Everything inside the path stays; everything outside is discarded. The output is a clean, isolated subject with no halos, no fringe, and no artefacts left over from automated selection tools.</p>
                    <p>Every path at Graphics Pixels is drawn manually. We cover all complexity levels: simple single-path products, compound paths for multi-part subjects, complex paths for apparel and furniture, and super-complex paths for jewelry, lacework, and fine-detailed items. From $0.39 per image, 24–48 hour turnaround, bulk orders discounted. Best for products with defined, hard edges — for hair, fur, or sheer fabric, image masking is the appropriate technique.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/1.%20White%20and%20Colored%20Backgrounds/1%20graphics%20pixels.jpg" alt="Clipping Path Service Explained" loading="lazy">
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
                <h2 class="section-title">Watch Professional Clipping Path in Practice</h2>
                <p class="section-desc">See how we draw paths by hand around different product types — simple shapes, compound paths, and complex cutout interiors — and deliver clean, isolated subjects ready for any background.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/Vv--U5DYXxo"
                        title="Professional Clipping Path Service"
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
                <h2 class="section-title">Our Clipping Path Services</h2>
                <p class="section-desc">From simple single-path product cutouts to multi-part compound paths and super-complex subjects with fine interior detail — every image is assessed individually and the path type is matched to what it actually needs.</p>
            </div>

            <div class="svc-list">

                <!-- 1. Transparent Background & Clean Cutouts -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/0-transparent-background/graphics-pixels-After-1.jpg" alt="After — Transparent Background Clipping Path">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/0-transparent-background/graphics-pixels-Before-1.jpg" alt="Before — Transparent Background Clipping Path">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-scissors"></i></span>
                        <h3>Transparent Background &amp; Clean Cutouts</h3>
                        <p>The subject is isolated and delivered as a PNG or layered PSD with a fully transparent background. Drop it onto any colour, scene, or template and it sits cleanly without further work. No edge haze, no fringe, no semi-transparent pixels from a poor selection. Every pixel at the boundary is checked manually and the path is closed to precision.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Clean PNG with fully transparent background</li>
                            <li><i class="fas fa-check"></i> Zero fringe or halo artefacts</li>
                            <li><i class="fas fa-check"></i> Layered PSD available on request</li>
                            <li><i class="fas fa-check"></i> Ready to use on any background immediately</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. White & Marketplace-Ready Backgrounds -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/1.%20White%20and%20Colored%20Backgrounds/graphics%20pixels%20%281%29.jpg" alt="Before — White and Colored Background">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/1.%20White%20and%20Colored%20Backgrounds/1%20graphics%20pixels.jpg" alt="After — White and Colored Background">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-palette"></i></span>
                        <h3>White &amp; Coloured Background Application</h3>
                        <p>Pure white background (RGB 255,255,255) applied for Amazon, eBay, Walmart, and platform compliance. Output meets marketplace technical specifications exactly — correct white value, clean edges, no shadow bleed. Custom colour backgrounds for branded catalogs, social campaigns, and advertising are also applied. Send hex codes or brand guidelines and we match them precisely, adjusting edge lighting so the subject sits naturally in the space.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Pure white (255,255,255) for marketplace compliance</li>
                            <li><i class="fas fa-check"></i> Custom brand colours matched to hex or guide</li>
                            <li><i class="fas fa-check"></i> Edge shading adjusted for natural placement</li>
                            <li><i class="fas fa-check"></i> Platform-ready output dimensions available</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Product Placement Into Scenes -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/2.%20Product%20Placement%20Into%20Scenes/graphics%20pixels%20%281%29.jpg" alt="Product Placement Into Scenes" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-layer-group"></i></span>
                        <h3>Product-in-Scene Compositing</h3>
                        <p>Have a lifestyle background, brand environment, or campaign scene in mind? We composite the isolated product into it — adjusting edge lighting, cast shadows, and depth so the result reads as a single photograph, not a cutout placed on a stock image. Used for advertising layouts, social media product content, and e-commerce lifestyle imagery where plain white is not the right fit. Send your background or describe the look and we'll handle the composition.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Product blended naturally into any scene</li>
                            <li><i class="fas fa-check"></i> Edge lighting adjusted to match environment</li>
                            <li><i class="fas fa-check"></i> Cast shadows added for depth and realism</li>
                            <li><i class="fas fa-check"></i> Looks like a single photograph, not a composite</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Catalog Consistency & Visual Impact -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/3.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%282%29.jpg" alt="After — Catalog Consistency">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/3.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%281%29.jpg" alt="Before — Catalog Consistency">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-object-group"></i></span>
                        <h3>Catalog Consistency &amp; Visual Impact</h3>
                        <p>Inconsistent backgrounds, mixed lighting conditions, and varying crop ratios make a product catalog look unprofessional. We standardise your entire batch — isolating each product with the same path precision, applying a consistent background treatment, and delivering uniform framing across every image. The result is a catalog that reads as coherent and professional, increasing buyer confidence and reducing the visual noise that loses conversions.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Consistent background across entire batch</li>
                            <li><i class="fas fa-check"></i> Uniform framing and product sizing</li>
                            <li><i class="fas fa-check"></i> Professional, credible catalog appearance</li>
                            <li><i class="fas fa-check"></i> Bulk pricing scales down with volume</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Bulk E-commerce Processing -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/4.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%281%29.jpg" alt="Bulk E-commerce Clipping Path Processing" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-boxes-stacked"></i></span>
                        <h3>Bulk E-commerce &amp; Studio Processing</h3>
                        <p>Regular high-volume product photography sessions need a reliable editing partner — not a one-off service. We handle ongoing batch clipping path work for studios, photographers, and e-commerce operations, with consistent output quality across every delivery. Dedicated account management, agreed turnaround windows, and pricing that scales with volume. Send your first batch as a free trial and we'll match the standard you need across all future work.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Consistent quality across all batch deliveries</li>
                            <li><i class="fas fa-check"></i> Dedicated account management for studios</li>
                            <li><i class="fas fa-check"></i> Agreed turnaround windows for regular orders</li>
                            <li><i class="fas fa-check"></i> Volume pricing from 100+ images per batch</li>
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
                <p class="section-desc">From upload to delivery — a streamlined workflow designed to handle any batch size efficiently.</p>
            </div>

            <div class="how-timeline reveal" data-reveal="up" data-delay="100">
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-1"><i class="fas fa-folder-open"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Upload Your Images</h3>
                        <p>Send your product images via the form or a cloud link. JPG, PNG, PSD, TIFF, and RAW files all accepted.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-2"><i class="fas fa-pen-to-square"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Specify Your Requirements</h3>
                        <p>Tell us the background you need — transparent PNG, white, custom colour, or scene compositing. Include a reference image if matching an existing style.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-3"><i class="fas fa-magic"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Paths Drawn by Hand</h3>
                        <p>Each path is drawn manually with the Photoshop pen tool. Typically completed within 24–48 hours depending on batch size and complexity.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-4"><i class="fas fa-check-double"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Delivered &amp; Ready to Use</h3>
                        <p>Receive your images in your requested format — PNG, JPG, PSD, or TIFF. Revisions included at no charge until the output matches your brief.</p>
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
                            <div class="vt-thumb" style="background-image: url('https://graphicspixels.com/wp-content/uploads/2026/05/Video-1.jpg');">
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
                            <div class="vt-thumb" style="background-image: url('https://graphicspixels.com/wp-content/uploads/2026/05/Video-2.jpg');">
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
                            <div class="vt-thumb" style="background-image: url('https://graphicspixels.com/wp-content/uploads/2026/05/Video-3.jpg');">
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
                            <div class="vt-thumb" style="background-image: url('https://graphicspixels.com/wp-content/uploads/2026/05/Video-4.jpg');">
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
                    What Photographers, Business Owners, and E-commerce Brands Say About Our Clipping Path Service
                </h2>

                <div class="vt-avatars" id="vtAvatars">
                    <button class="vt-avatar active" data-index="0" aria-label="Tyrell Scott">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/05/Video-1.jpg" alt="Tyrell Scott">
                    </button>
                    <button class="vt-avatar" data-index="1" aria-label="Seb Chandler">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/05/Video-2.jpg" alt="Seb Chandler">
                    </button>
                    <button class="vt-avatar" data-index="2" aria-label="Andrew Porfyri">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/05/Video-3.jpg" alt="Andrew Porfyri">
                    </button>
                    <button class="vt-avatar" data-index="3" aria-label="Saville Coble">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/05/Video-4.jpg" alt="Saville Coble">
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
                <p><strong>Try Our Clipping Path Service Free — Results Back in 24 Hours</strong><br>Send 1 to 5 product images and we return them clipped to your specification within 24 hours at no charge. No payment required. Review quality and edge precision before placing a paid order.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-credit-card"></i> No payment required — review the work before ordering</li>
                    <li><i class="fas fa-images"></i> 1 to 5 images clipped at full quality</li>
                    <li><i class="fas fa-clock"></i> Results returned within 24 hours</li>
                    <li><i class="fas fa-rotate"></i> Unlimited revisions on paid orders</li>
                    <li><i class="fas fa-lock"></i> NDA-compliant — your files are never shared</li>
                    <li><i class="fas fa-tag"></i> Bulk discounts from 100 images</li>
                    <li><i class="fas fa-handshake"></i> Dedicated account management for studios</li>
                </ul>
            </div>
            <form class="free-trial-form reveal" data-reveal="right" id="trial-form">
                <div class="form-row">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Add Email*" required>
                </div>
                <div class="form-row">
                    <input type="tel" placeholder="Phone*" required>
                    <input type="url" placeholder="Website">
                </div>
                <select required>
                    <option value="" disabled>Select The Service</option>
                    <option selected>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option>Background Removal</option>
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
                    <button class="faq-q">What file formats do you accept for clipping path orders? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We accept JPG, PNG, PSD, TIFF, and RAW files including CR2, NEF, and ARW. Delivery in your preferred format — JPG, PNG, PSD, or TIFF. Let us know your platform requirements and we'll ensure compliance.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How fast is the turnaround for a batch order? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Standard turnaround is 24–48 hours for most batch sizes. For large orders over 500 images, we agree a timeline upfront. Rush turnaround is available for urgent requirements — contact us to confirm availability.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What complexity levels do you handle? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>All levels. Simple single-path products (boxes, bottles, simple shoes), compound paths for multi-part items, complex paths for furniture and apparel, and super-complex paths for jewelry, lacework, and fine-detailed subjects. Every image is assessed and priced by complexity.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you offer bulk discounts? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Pricing scales down as batch size increases. From 100 images, bulk rates apply. For studios and e-commerce operations with regular volume, we set up a dedicated account with agreed pricing and turnaround windows.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What is the difference between clipping path and image masking? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Clipping path uses a hard vector path and is best for products with defined, solid edges — footwear, packaged goods, electronics, and furniture. Image masking is better for hair, fur, sheer fabric, or transparent materials where a hard path would produce an unnatural cut. We assess each batch and recommend the right technique.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I get a free trial before placing a large order? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Send 1–5 images and we return them clipped within 24 hours at no charge. It's designed so you can check edge quality and precision before ordering a full batch.</p></div>
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

    <!-- Before/After Slider -->
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

<?php /* Template Name: Photo Retouching Service */ ?>
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
            padding: 4px 10px; border-radius: 100px; backdrop-filter: blur(4px);
            pointer-events: none;
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
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Photo Retouching service/graphics-pixels-2.png');
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
            font-size: 15px; color: #444;
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Photo Retouching service/graphics-pixels-2.png');
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
        .pe-video-section {
            padding-top: 40px !important;
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Photo Editing</span>
                <h2>Professional Photo Retouching Services — Product, Fashion, Beauty &amp; Portrait</h2>
                <p class="ds-lead">Graphics Pixels provides photo retouching for e-commerce brands, photographers, fashion studios, and advertising agencies. We handle product retouching, high-end beauty and portrait work, fashion and apparel retouching, jewelry polishing, and commercial and editorial finishing — all done by human editors in Photoshop, to your brief, with no AI presets.</p>
                <p>Every order is matched against a reference standard before delivery. 120+ trained retouchers, 24-hour turnaround, unlimited revisions. Send 1–5 images for a free trial — returned within 24 hours, no charge.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VIDEO ============ -->
    <section class="pe-video-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">See It In Action</span>
                <h2 class="section-title">Our Retouching Process in Action</h2>
                <p class="section-desc">Watch a real retouching workflow — skin work, tone correction, and finishing — so you know exactly what we do to every image before it leaves our team.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/qjXWMmnTGGg"
                        title="Professional Photo Retouching Process"
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
                <h2 class="section-title">Our Photo Retouching Services</h2>
                <p class="section-desc">From beauty and portrait work to e-commerce product finishing — we cover every retouching requirement with human editors, Photoshop precision, and output matched to your specific brief.</p>
            </div>

            <div class="svc-list">

                <!-- 1. High-End Beauty & Portrait Retouching -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/1.%20High-End%20Beauty%20%26%20Portrait%20Retouching/graphics%20pixels%20(2).jpg" alt="After — High-End Beauty Retouching">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/1.%20High-End%20Beauty%20%26%20Portrait%20Retouching/graphics%20pixels%20(1).jpg" alt="Before — High-End Beauty Retouching">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-face-smile-beam"></i></span>
                        <h3>High-End Beauty &amp; Portrait Retouching</h3>
                        <p>Skin tone correction, texture refinement, blemish and acne removal, under-eye reduction, stray hair cleanup, and facial contouring — all done with a light hand to preserve natural skin character. No AI smoothing. Each image worked individually in Photoshop to a consistent, credible result.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Skin texture preserved — no plastic finish</li>
                            <li><i class="fas fa-check"></i> Blemish, acne &amp; under-eye correction</li>
                            <li><i class="fas fa-check"></i> Stray hair cleanup &amp; facial contouring</li>
                            <li><i class="fas fa-check"></i> Used by portrait, beauty &amp; editorial clients</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. E-commerce & Product Retouching -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/2.%20E-commerce%20%26%20Product%20Retouching/graphics%20pixels%20(2).jpg" alt="After — E-commerce Product Retouching">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/2.%20E-commerce%20%26%20Product%20Retouching/graphics%20pixels%20(1).jpg" alt="Before — E-commerce Product Retouching">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-box-open"></i></span>
                        <h3>E-commerce &amp; Product Retouching</h3>
                        <p>Background removal, surface blemish cleanup, colour accuracy, reflection and shadow correction, dust and scratch removal, and packaging label straightening — for Amazon, Shopify, eBay, Etsy, and Walmart listings. Jewellery polishing, garment retouching, and ghost mannequin work included as standard.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Platform-ready output for all major marketplaces</li>
                            <li><i class="fas fa-check"></i> Jewellery polish, metal reflections &amp; gemstone colour</li>
                            <li><i class="fas fa-check"></i> Ghost mannequin &amp; garment retouching</li>
                            <li><i class="fas fa-check"></i> Bulk orders from $1.50/image</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Model Portrait Retouching -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/3.%20Model%20Portrait%20Retouching/graphics%20pixels%20(2).jpg" alt="After — Model Portrait Retouching">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/3.%20Model%20Portrait%20Retouching/graphics%20pixels%20(1).jpg" alt="Before — Model Portrait Retouching">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-person"></i></span>
                        <h3>Model Portrait Retouching</h3>
                        <p>Retouching for fashion campaigns, product advertising, and catalog imagery. Skin correction, blemish removal, teeth whitening, eye enhancement, and facial symmetry adjustment — done to match the visual standard of the campaign brief. Output looks like the model on a good day, not digitally altered.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Brief-matched across full campaign batches</li>
                            <li><i class="fas fa-check"></i> Teeth whitening &amp; eye enhancement</li>
                            <li><i class="fas fa-check"></i> Symmetry correction &amp; expression refinement</li>
                            <li><i class="fas fa-check"></i> Used by fashion brands &amp; advertising agencies</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Commercial & Editorial Retouching -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/4.%20Commercial%20%26%20Editorial%20Retouching/graphics%20pixels%20(2).jpg" alt="After — Commercial & Editorial Retouching">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/4.%20Commercial%20%26%20Editorial%20Retouching/graphics%20pixels%20(1).jpg" alt="Before — Commercial & Editorial Retouching">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-newspaper"></i></span>
                        <h3>Commercial &amp; Editorial Retouching</h3>
                        <p>Retouching for advertising campaigns, magazine spreads, billboards, and brand visual libraries. Tone balancing, advanced colour grading, skin retouching to publishing standard, composite cleanup, and print-ready output at any resolution. Turnaround agreed per project scope.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Meets print &amp; large-format requirements</li>
                            <li><i class="fas fa-check"></i> Advanced colour grading &amp; tone balancing</li>
                            <li><i class="fas fa-check"></i> Composite cleanup &amp; layer organisation</li>
                            <li><i class="fas fa-check"></i> Used by ad agencies &amp; editorial photographers</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Fashion & Beauty Photo Retouching -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/5.%20Fashion%20%26%20Beauty%20Photo%20Retouching/graphics%20pixels%20(1).jpg" alt="Fashion & Beauty Photo Retouching" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shirt"></i></span>
                        <h3>Fashion &amp; Beauty Photo Retouching</h3>
                        <p>Retouching for clothing brands, beauty labels, lingerie, swimwear, and editorial fashion photography. Colour correction matched to garment swatches, crease and wrinkle removal from fabric, skin tone standardisation across campaign batches, and contrast grading for a clean, campaign-ready finish.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Fabric colour corrected to swatch reference</li>
                            <li><i class="fas fa-check"></i> Crease &amp; wrinkle removal from garments</li>
                            <li><i class="fas fa-check"></i> Consistent skin tone across batch shoots</li>
                            <li><i class="fas fa-check"></i> Used by fashion brands &amp; beauty campaigns</li>
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
                <p class="section-desc">From upload to delivery — we've streamlined the process to make it effortless for you.</p>
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
                        <p>Describe your edits and style preferences. Attach reference images if you have them.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-3"><i class="fas fa-magic"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>We Deliver Results</h3>
                        <p>Your edited images are ready within 24 hours. Full quality, platform-ready.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-4"><i class="fas fa-check-double"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Revisions Until Perfect</h3>
                        <p>Request changes anytime. Unlimited revisions until your vision is exactly matched.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VIDEO TESTIMONIALS SECTION ============ -->
    <section class="vt-section">
        <div class="vt-wrap">

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

            <div class="vt-right reveal" data-reveal="right">
                <div class="vt-stars-top">
                    <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                </div>
                <h2 class="vt-heading">
                    What Photographers, Business Owners, and Ecommerce Brands Say About Our Photo Retouching &amp; Post-Production Services
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
                    <input type="url" placeholder="Website">
                </div>
                <select required>
                    <option value="" disabled selected>Select The Service</option>
                    <option>Photo Retouching</option>
                    <option>Clipping Path</option>
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
                    <button class="faq-q">Do you use AI to retouch images? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>No. Every image is retouched manually in Photoshop by a trained editor. We do not use AI smoothing tools, batch presets, or automated skin filters. This is the standard clients come to us for — the natural result that automated tools cannot produce reliably.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How do I communicate what I want? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Include a brief with your images describing the result you need. A reference image is the most useful — send one example of the look you're going for and we'll match that standard across your full batch. Written instructions alone work fine too.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What is the turnaround time? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Standard orders are delivered within 24 hours. For larger batches, turnaround is agreed per project. Rush delivery is available for time-critical work — contact us to confirm availability.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I send raw files from my camera? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We accept RAW, TIFF, PSD, PNG, and JPEG. RAW files give our editors the most flexibility for tone and colour corrections. Specify your preferred output format in your brief.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How many revisions are included? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Unlimited revisions on paid orders. We revise until the result matches your brief exactly, at no additional charge. This applies to adjustments within the original scope — tone, skin, colour, cropping.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Are my files kept confidential? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. All staff sign NDA agreements before handling client work. Your files are stored on secure, firewalled servers and are never shared, repurposed, or used in any portfolio without explicit permission.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you handle bulk orders from photographers and studios? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — bulk is our primary workflow. With 120+ in-house editors we handle batches of any size at a consistent output standard. Bulk pricing starts from 100 images. Contact us for a dedicated account manager if you have regular volume.</p></div>
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
            after.style.clipPath   = 'inset(0 ' + (100 - pct) + '% 0 0)';
            divider.style.left     = pct + '%';
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

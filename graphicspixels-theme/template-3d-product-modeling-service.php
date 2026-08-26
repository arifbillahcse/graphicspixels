<?php /* Template Name: 3D Product Modeling Service */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/4__3D-Service.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/4__3D-Service.png');
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
        /* ---- 3D Model Viewer (interactive GLB) ---- */
        .svc-3d-wrap {
            position: relative;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            background: #f4f2ec;
        }
        .svc-3d-viewer {
            width: 100%;
            height: 420px;
            display: block;
            --poster-color: transparent;
        }
        .svc-3d-expand {
            position: absolute;
            bottom: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: none;
            background: rgba(255,255,255,0.9);
            color: #01015E;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            transition: background 0.2s;
        }
        .svc-3d-expand:hover { background: #fff; }
        .svc-3d-caption {
            text-align: center;
            font-size: 13px;
            color: #000;
            margin-top: 12px;
        }
        .svc-related {
            font-size: 14px;
            color: #000;
            margin-top: -8px;
            margin-bottom: 24px;
        }
        .svc-features-label {
            margin-bottom: 8px;
        }
        @media (max-width: 768px) {
            .svc-3d-viewer { height: 300px; }
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">3D Product Modeling Service</span>
                <h2>3D Product Modeling &amp; Rendering Service — Photorealistic CGI for E-commerce and Marketing</h2>
                <p class="ds-lead">Graphics Pixels builds photorealistic 3D product models for e-commerce, fashion, furniture, and jewelry brands — from reference images, design files, or physical samples.</p>
                <p>Render in any colour, background, or environment without reshooting. Print-ready, web-ready, and AR-ready assets. Custom quote, 3–7 day turnaround, free trial available.</p>

                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS 3D PRODUCT MODELING ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">Photorealistic CGI for E-commerce and Marketing</h2>
                    <p>Graphics Pixels produces photorealistic 3D product models and renderings for e-commerce brands, fashion companies, furniture manufacturers, jewelry designers, and marketing agencies — modeled from reference images, design files, or physical samples.</p>
                    <p>3D modeling removes the need for expensive product photography at every stage of a product cycle. A 3D model can be rendered in any colour, on any background, in any environment — without reshooting. Used for Amazon listings, Shopify product pages, marketing campaigns, trade catalogs, and virtual staging.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80" alt="3D Office Chair - 3D Product Modeling Example" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ HOW IT WORKS - VIDEO ============ -->
    <section class="pe-video-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">See It In Action</span>
                <h2 class="section-title">From Reference to Render</h2>
                <p class="section-desc">Watch our 3D modeling and rendering process — from product references and design files to finished photorealistic assets ready for e-commerce, marketing, and AR.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/Vv--U5DYXxo"
                        title="3D Product Modeling Process"
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
                <h2 class="section-title">Our Offered 3D Modeling & Rendering Services</h2>
                <p class="section-desc">From furniture and footwear to handbags and fashion apparel — we model and render any product category at the quality your brand demands, ready for e-commerce, AR, and marketing campaigns.</p>
            </div>

            <div class="svc-list">

                <!-- 1. 3D Furniture Modeling & Rendering (Jewelry GLB) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-3d-wrap">
                            <model-viewer class="svc-3d-viewer" src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/graphics-pixels-3.glb" alt="3D Furniture Model" camera-controls auto-rotate shadow-intensity="1" exposure="1"></model-viewer>
                            <button class="svc-3d-expand" aria-label="View fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                        <p class="svc-3d-caption">Drag to rotate and explore the 3D model</p>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-couch"></i></span>
                        <h3>3D Furniture Modeling & Rendering</h3>
                        <p>Photorealistic 3D models of furniture — sofas, chairs, tables, shelving, and bedroom furniture — rendered with accurate material textures, lighting, and shadow. Output used for e-commerce product pages, interior design presentations, trade catalogs, and virtual staging.</p>
                        <p>Delivered in any environment: white studio background, lifestyle room setting, or outdoor architectural context. Colour and material variants produced from a single model without reshooting. AR-ready formats available.</p>
                        <p class="svc-related"><em>→ Related: 3D Rendering | Virtual Staging | Product Marketing</em></p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Premium Luxury Furniture (Bag GLB) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-3d-wrap">
                            <model-viewer class="svc-3d-viewer" src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/graphics-pixels-1.glb" alt="Premium Luxury Furniture 3D Model" camera-controls auto-rotate shadow-intensity="1" exposure="1"></model-viewer>
                            <button class="svc-3d-expand" aria-label="View fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                        <p class="svc-3d-caption">Drag to rotate and explore the 3D model</p>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-gem"></i></span>
                        <h3>Premium Luxury Furniture 3D Modeling and Rendering Services</h3>
                        <p>Bring your luxury furniture designs to life with the best quality 3D Product Modeling Service and rendering services from Graphics Pixels. Our expert team creates stunning, realistic visuals that highlight the elegance, craftsmanship, and intricate details of your luxury furniture collection, ensuring the highest standard in every render. Perfect for interior designers, manufacturers, and online marketing, our services offer unmatched precision and quality that make your products stand out.</p>
                        <p class="svc-features-label"><strong>Key Features:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Luxury Furniture 3D Modeling Service</li>
                            <li><i class="fas fa-check"></i> Realistic 3D Rendering for Luxury Furniture</li>
                            <li><i class="fas fa-check"></i> Custom Furniture Design Visualization</li>
                            <li><i class="fas fa-check"></i> 3D Furniture Animation for Marketing</li>
                            <li><i class="fas fa-check"></i> Virtual Staging for Luxury Furniture</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Premium Luxury Furniture (Headphone GLB) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-3d-wrap">
                            <model-viewer class="svc-3d-viewer" src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/graphics-pixels-2-1.glb" alt="Premium Luxury Furniture 3D Model" camera-controls auto-rotate shadow-intensity="1" exposure="1"></model-viewer>
                            <button class="svc-3d-expand" aria-label="View fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                        <p class="svc-3d-caption">Drag to rotate and explore the 3D model</p>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-gem"></i></span>
                        <h3>Premium Luxury Furniture 3D Modeling and Rendering Services</h3>
                        <p>Bring your luxury furniture designs to life with the best quality 3D Product Modeling Service and rendering services from Graphics Pixels. Our expert team creates stunning, realistic visuals that highlight the elegance, craftsmanship, and intricate details of your luxury furniture collection, ensuring the highest standard in every render. Perfect for interior designers, manufacturers, and online marketing, our services offer unmatched precision and quality that make your products stand out.</p>
                        <p class="svc-features-label"><strong>Key Features:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Luxury Furniture 3D Modeling Service</li>
                            <li><i class="fas fa-check"></i> Realistic 3D Rendering for Luxury Furniture</li>
                            <li><i class="fas fa-check"></i> Custom Furniture Design Visualization</li>
                            <li><i class="fas fa-check"></i> 3D Furniture Animation for Marketing</li>
                            <li><i class="fas fa-check"></i> Virtual Staging for Luxury Furniture</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Premium Luxury Furniture (Sofa image) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/4_sofa.jpg" alt="Premium Luxury Furniture 3D Modeling" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-gem"></i></span>
                        <h3>Premium Luxury Furniture 3D Modeling and Rendering Services</h3>
                        <p>Bring your luxury furniture designs to life with the best quality 3D Product Modeling Service and rendering services from Graphics Pixels. Our expert team creates stunning, realistic visuals that highlight the elegance, craftsmanship, and intricate details of your luxury furniture collection, ensuring the highest standard in every render. Perfect for interior designers, manufacturers, and online marketing, our services offer unmatched precision and quality that make your products stand out.</p>
                        <p class="svc-features-label"><strong>Key Features:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Luxury Furniture 3D Modeling Service</li>
                            <li><i class="fas fa-check"></i> Realistic 3D Rendering for Luxury Furniture</li>
                            <li><i class="fas fa-check"></i> Custom Furniture Design Visualization</li>
                            <li><i class="fas fa-check"></i> 3D Furniture Animation for Marketing</li>
                            <li><i class="fas fa-check"></i> Virtual Staging for Luxury Furniture</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Footwear -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/5_footwear.jpg" alt="Footwear 3D Modeling and Rendering" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shoe-prints"></i></span>
                        <h3>Footwear 3D Modeling & Rendering</h3>
                        <p>Photorealistic 3D models of footwear — heels, sneakers, boots, loafers, and sandals — with accurate mesh texture, sole structure, lace detail, and material finish. Output used for e-commerce listings, footwear brand marketing, 3D ads, and AR try-on applications.</p>
                        <p>Colour and material variants produced from one base model. Studio-lit hero renders and lifestyle environment placements are both available. AR-ready formats for virtual try-on and product configurators.</p>
                        <p class="svc-related"><em>→ Related: 3D Product Rendering | 3D Animation | E-commerce Image Editing</em></p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 6. Handbag & Accessories -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/6_accessories.jpeg" alt="Handbag and Accessories 3D Modeling" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-bag-shopping"></i></span>
                        <h3>Handbag & Accessories 3D Modeling</h3>
                        <p>Photorealistic 3D models of handbags, clutches, wallets, and leather accessories — with accurate stitching detail, hardware finish, leather grain texture, and zip and clasp elements. Output used for fashion e-commerce product pages, lookbook photography replacement, wholesale catalog production, and brand campaign visuals.</p>
                        <p>Material and colour variants from a single model. Multiple camera angles and environment renders from one production run. Used by fashion brands, independent designers, and luxury accessory retailers.</p>
                        <p class="svc-related"><em>→ Related: 3D Rendering | Fashion Photo Retouching | E-commerce Image Editing</em></p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 7. Fashion & Apparel -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/3D/3D%20Modelling/7_fashion.jpeg" alt="Fashion and Apparel 3D Modeling" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shirt"></i></span>
                        <h3>Fashion & Apparel 3D Modeling</h3>
                        <p>Photorealistic 3D models of garments — evening dresses, formal wear, outerwear, and ready-to-wear — with accurate fabric simulation, drape and flow, texture, and garment construction detail. Used as an alternative to physical samples for pre-launch marketing, wholesale catalog production, and e-commerce listings before stock arrives.</p>
                        <p>Particularly useful for fashion brands producing collections in advance of physical production — 3D models can be used for buyer presentations, press imagery, and online listings from design files alone.</p>
                        <p class="svc-related"><em>→ Related: Ghost Mannequin Service | Fashion Photo Retouching | 3D Animation</em></p>
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
                        <p>Upload 1-5 images or share a cloud link. We accept JPG, PNG, PSD, and RAW formats.</p>
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

            <div class="vt-right reveal" data-reveal="right">
                <div class="vt-stars-top">
                    <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                </div>
                <h2 class="vt-heading">
                    What Photographers, Business Owners, and Ecommerce Brands Say About Our 3D Modeling &amp; Visualization Services
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
                <p>Complete the form, share your product references, and get your free trial model delivered fast.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-globe"></i> Global service</li>
                    <li><i class="fas fa-bolt"></i> Fast turnaround</li>
                    <li><i class="fas fa-rotate"></i> Unlimited revisions</li>
                    <li><i class="fas fa-face-smile"></i> 100% client satisfaction</li>
                    <li><i class="fas fa-cart-shopping"></i> Smooth ordering process</li>
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
                    <option value="" disabled selected>Select The Service</option>
                    <option>3D Product Modeling</option>
                    <option>3D Rendering</option>
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Background Removal</option>
                    <option>Color Correction</option>
                    <option>E-commerce Image Editing</option>
                </select>
                <textarea placeholder="Your message" rows="3"></textarea>
                <div class="file-upload">
                    <label for="file-input"><i class="fas fa-cloud-arrow-up"></i> Choose a file</label>
                    <input type="file" id="file-input">
                    <span class="file-name">No file chosen</span>
                </div>
                <p class="upload-note">If the size is more than 25 MB, share your files via cloud (Google Drive, Dropbox or WeTransfer).</p>
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
                    <button class="faq-q">Can you model furniture from just photos or a catalogue? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We work from product photos, technical drawings, CAD files, or physical samples. For furniture, multiple angles and dimension references give the best accuracy. The more detail you provide, the more precise the model.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I get colour and material variants from one model? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — and this is one of the key advantages of 3D over photography. We apply different materials, finishes, and colour ways to a single model and render them all without reshooting. Common for furniture, footwear, and handbags.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you deliver AR-ready formats for footwear and accessories? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We deliver GLTF and USDZ formats for AR try-on and product configurator applications. These are optimised for web-based AR (WebXR) and native mobile AR (Apple AR Quick Look, Google Scene Viewer).</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can fashion 3D models replace physical sample photography? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. For pre-launch collections or designs still in production, 3D garment models with accurate fabric simulation can be used for buyer presentations, press imagery, and e-commerce listings — from design files alone, before a single sample is made.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What file formats do you deliver? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We deliver OBJ, FBX, STL, GLTF, USDZ, and native formats for Blender, Cinema 4D, or 3ds Max. Rendered images are delivered as PNG, TIFF, or JPEG at your required resolution. Let us know your workflow and we'll match it.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is the free trial really free? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Share your product references — photos, sketches, or design files — and we'll deliver a sample model or render with no charge and no obligation, so you can assess quality before committing to a full project.</p></div>
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
        document.querySelectorAll('.svc-3d-expand').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var viewer = btn.previousElementSibling;
                if (viewer && viewer.requestFullscreen) {
                    viewer.requestFullscreen();
                }
            });
        });
    </script>

<?php get_footer(); ?>

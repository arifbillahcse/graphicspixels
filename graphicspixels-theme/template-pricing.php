<?php /* Template Name: Pricing */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/7__PLAN-PRICING.png');
            background-size: auto calc(100% - 100px);
            background-position: right bottom;
            background-repeat: no-repeat;
            overflow: hidden;
            display: flex;
            align-items: center;
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/7__PLAN-PRICING.png');
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

        /* ---- Pricing Calculator ---- */
        .pc-section { padding: 70px 0 40px; background: linear-gradient(135deg, #f9f8fd 0%, #fef5ff 100%); }
        .pc-wrap {
            display: grid; grid-template-columns: 1.3fr 1fr; gap: 28px;
            background: #fff; border-radius: 20px; overflow: hidden;
            box-shadow: 0 18px 50px rgba(1,1,94,0.10); border: 1px solid #efeaf5;
        }
        .pc-form { padding: 38px 40px; }
        .pc-field { margin-bottom: 22px; }
        .pc-field label {
            display: block; font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 600;
            color: #01015E; margin-bottom: 8px; letter-spacing: 0.3px;
        }
        .pc-field select, .pc-field input {
            width: 100%; padding: 13px 16px; font-size: 15px; font-family: 'Inter', sans-serif;
            border: 2px solid #e7e2f0; border-radius: 10px; background: #fff; color: #111;
            transition: border-color 0.2s, box-shadow 0.2s; -webkit-appearance: none; appearance: none;
        }
        .pc-field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%2301015E' d='M6 8L0 0h12z'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 16px center; padding-right: 40px; cursor: pointer;
        }
        .pc-field select:focus, .pc-field input:focus {
            outline: none; border-color: var(--magenta, #C3009D); box-shadow: 0 0 0 3px rgba(195,0,157,0.10);
        }
        .pc-qty-row { display: flex; align-items: stretch; gap: 10px; }
        .pc-qty-btn {
            width: 48px; flex: 0 0 48px; border: 2px solid #e7e2f0; border-radius: 10px; background: #faf7fd;
            font-size: 20px; font-weight: 700; color: var(--magenta, #C3009D); cursor: pointer; transition: all 0.15s;
        }
        .pc-qty-btn:hover { background: var(--magenta, #C3009D); color: #fff; border-color: var(--magenta, #C3009D); }
        .pc-qty-row input { text-align: center; font-weight: 600; }
        .pc-note { font-size: 12.5px; color: #888; margin-top: 6px; }

        .pc-result {
            background: var(--navy, #01015E); color: #fff; padding: 38px 36px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .pc-result-tag {
            font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 600; letter-spacing: 1.5px;
            text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 18px;
        }
        .pc-result-line { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; font-size: 14px; color: rgba(255,255,255,0.85); border-bottom: 1px solid rgba(255,255,255,0.12); }
        .pc-result-line span:last-child { font-weight: 600; color: #fff; text-align: right; }
        .pc-total {
            margin-top: 22px; padding-top: 20px; border-top: 2px solid rgba(255,255,255,0.2);
            display: flex; justify-content: space-between; align-items: baseline;
        }
        .pc-total-label { font-family: 'Poppins', sans-serif; font-size: 16px; font-weight: 600; }
        .pc-total-value { font-family: 'Poppins', sans-serif; font-size: 40px; font-weight: 800; color: #fff; line-height: 1; }
        .pc-total-value sup { font-size: 22px; top: -0.6em; margin-right: 2px; }
        .pc-result-btn {
            margin-top: 26px; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            background: var(--magenta, #C3009D); color: #fff; text-decoration: none;
            font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 15px;
            padding: 14px 20px; border-radius: 10px; transition: transform 0.15s, box-shadow 0.15s;
        }
        .pc-result-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 26px rgba(195,0,157,0.4); }
        .pc-disclaimer { font-size: 12px; color: rgba(255,255,255,0.55); margin-top: 16px; line-height: 1.5; }

        @media (max-width: 820px) {
            .pc-wrap { grid-template-columns: 1fr; }
            .pc-form { padding: 32px 24px; }
            .pc-result { padding: 32px 26px; }
        }
        @media (max-width: 600px) {
            .pc-section { padding: 50px 0 30px; }
            .pc-total-value { font-size: 34px; }
        }
    </style>

<!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Plans &amp; Pricing</span>
                <h2>Simple, Transparent Pricing</h2>
                <p class="ds-lead">Professional photo editing starting at just $0.19 per image.</p>
                <p>No hidden fees, no surprises — just pixel-perfect results delivered on time, every time.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ INTRO BANNER ============ -->
    <div class="pr-banner">
        <div class="container pr-banner-inner">
            <div class="pr-banner-text">
                <h2>Professional Photo Editing &amp; Retouching Services</h2>
                <p>Starting at just <strong>$0.19 per image</strong> — Standard delivery 24–48 hours. Need it faster? We offer express packages to meet your tightest deadlines.</p>
            </div>
            <a href="#free-trial" class="btn btn-primary pr-banner-btn">Get Free Trial</a>
        </div>
    </div>

    <!-- ============ PRICING CALCULATOR ============ -->
    <section class="pc-section" id="pricing-calculator">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Instant Estimate</span>
                <h2 class="section-title">Quick Pricing Calculator</h2>
                <p class="section-desc">Pick a service, choose the type, and enter how many images — get an instant estimate based on our live pricing.</p>
            </div>

            <div class="pc-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pc-form">
                    <div class="pc-field">
                        <label for="pc-category">Service</label>
                        <select id="pc-category"></select>
                    </div>
                    <div class="pc-field">
                        <label for="pc-type">Service Type</label>
                        <select id="pc-type"></select>
                    </div>
                    <div class="pc-field">
                        <label for="pc-qty">Number of Images</label>
                        <div class="pc-qty-row">
                            <button type="button" class="pc-qty-btn" id="pc-minus" aria-label="Decrease quantity">&minus;</button>
                            <input type="number" id="pc-qty" min="1" value="10" inputmode="numeric">
                            <button type="button" class="pc-qty-btn" id="pc-plus" aria-label="Increase quantity">&plus;</button>
                        </div>
                        <p class="pc-note">Minimum order applies. Bulk discounts available on request for large volumes.</p>
                    </div>
                </div>
                <div class="pc-result">
                    <div class="pc-result-tag">Your Estimate</div>
                    <div class="pc-result-line">
                        <span id="pc-sum-type">Service</span>
                        <span id="pc-sum-price">$0.00 / image</span>
                    </div>
                    <div class="pc-result-line">
                        <span>Quantity</span>
                        <span id="pc-sum-qty">0 images</span>
                    </div>
                    <div class="pc-total">
                        <span class="pc-total-label">Estimated Total</span>
                        <span class="pc-total-value" id="pc-total"><sup>$</sup>0.00</span>
                    </div>
                    <a href="#free-trial" class="pc-result-btn">Get This Done <i class="fas fa-arrow-right"></i></a>
                    <p class="pc-disclaimer">This is an estimate based on standard 24–48 hour delivery. Final pricing may vary with image complexity. Contact us for an exact quote.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PRICING CARDS ============ -->
    <section class="pr-section" id="pricing-cards">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Our Plans</span>
                <h2 class="section-title">Details Pricing Plan</h2>
                <p class="section-desc">Every plan includes unlimited revisions, dedicated support, and on-time delivery — guaranteed.</p>
            </div>

            <div class="pr-grid">

                <!-- Clipping Path -->
                <div class="pr-card reveal" data-reveal="up" data-delay="0">
                    <div class="pr-card-header pr-accent-magenta">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-cut"></i></div>
                            <h3>Clipping Path</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.25</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Basic Clipping Path</span><span class="pr-item-price">$0.39</span></li>
                        <li><span class="pr-item-name">Simple Clipping Path</span><span class="pr-item-price">$0.80</span></li>
                        <li><span class="pr-item-name">Medium Clipping Path</span><span class="pr-item-price">$1.50</span></li>
                        <li><span class="pr-item-name">Complex Clipping Path</span><span class="pr-item-price">$3.99</span></li>
                        <li><span class="pr-item-name">Super Complex Clipping Path</span><span class="pr-item-price">$7.99</span></li>
                        <li><span class="pr-item-name">Remove Unwanted Objects</span><span class="pr-item-price">$1.25</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Shadow Creation -->
                <div class="pr-card reveal" data-reveal="up" data-delay="100">
                    <div class="pr-card-header pr-accent-cyan">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-circle-half-stroke"></i></div>
                            <h3>Shadow Creation</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.49</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Drop Shadow Creation</span><span class="pr-item-price">$0.49</span></li>
                        <li><span class="pr-item-name">Reflection Shadow Creation</span><span class="pr-item-price">$0.99</span></li>
                        <li><span class="pr-item-name">Realistic Shadow Creation</span><span class="pr-item-price">$1.49</span></li>
                        <li><span class="pr-item-name">Retain Original Shadow</span><span class="pr-item-price">$0.49</span></li>
                        <li><span class="pr-item-name">Shadow Removal Service</span><span class="pr-item-price">$0.99</span></li>
                        <li><span class="pr-item-name">Shadow on Portrait</span><span class="pr-item-price">$1.99</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn pr-card-btn-cyan">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Ghost Mannequin -->
                <div class="pr-card reveal" data-reveal="up" data-delay="0">
                    <div class="pr-card-header pr-accent-cyan">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-tshirt"></i></div>
                            <h3>Ghost Mannequin Effects</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.75</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Basic Neck Joint on Ghost Mannequin</span><span class="pr-item-price">$0.75</span></li>
                        <li><span class="pr-item-name">Medium Neck Joint on Ghost Mannequin</span><span class="pr-item-price">$1.00</span></li>
                        <li><span class="pr-item-name">Complex Neck Joint on Ghost Mannequin</span><span class="pr-item-price">$1.20</span></li>
                        <li><span class="pr-item-name">Complex Packshot Ghost Mannequin Effect</span><span class="pr-item-price">$1.50</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn pr-card-btn-cyan">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Image Masking -->
                <div class="pr-card reveal" data-reveal="up" data-delay="100">
                    <div class="pr-card-header pr-accent-magenta">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-magic"></i></div>
                            <h3>Image Masking</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.75</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Layer Masking</span><span class="pr-item-price">$0.75</span></li>
                        <li><span class="pr-item-name">Alpha Channel Masking</span><span class="pr-item-price">$0.99</span></li>
                        <li><span class="pr-item-name">Fur &amp; Hair Masking</span><span class="pr-item-price">$1.20</span></li>
                        <li><span class="pr-item-name">Refine Edge Masking</span><span class="pr-item-price">$1.49</span></li>
                        <li><span class="pr-item-name">Transparent Image Masking</span><span class="pr-item-price">$2.49</span></li>
                        <li><span class="pr-item-name">Color Masking</span><span class="pr-item-price">$3.49</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- E-commerce Photo Editing -->
                <div class="pr-card reveal" data-reveal="up" data-delay="0">
                    <div class="pr-card-header pr-accent-magenta">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-shopping-bag"></i></div>
                            <h3>E-commerce Photo Editing</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.50</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Product Background Remove</span><span class="pr-item-price">$0.50</span></li>
                        <li><span class="pr-item-name">Bulk Photo Editing</span><span class="pr-item-price">$0.25</span></li>
                        <li><span class="pr-item-name">Color Correction</span><span class="pr-item-price">$0.99</span></li>
                        <li><span class="pr-item-name">Photoshop Shadow Effect</span><span class="pr-item-price">$0.49</span></li>
                        <li><span class="pr-item-name">Ghost Mannequin Effect</span><span class="pr-item-price">$1.20</span></li>
                        <li><span class="pr-item-name">Product Photo Cleaning</span><span class="pr-item-price">$1.00</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Photography Retouching -->
                <div class="pr-card reveal" data-reveal="up" data-delay="100">
                    <div class="pr-card-header pr-accent-cyan">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-camera"></i></div>
                            <h3>Photography Retouching</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>1.50</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Headshots &amp; Face Retouching</span><span class="pr-item-price">$1.50</span></li>
                        <li><span class="pr-item-name">Beauty &amp; Glamor Retouching</span><span class="pr-item-price">$2.00</span></li>
                        <li><span class="pr-item-name">Body Retouching &amp; Reshaping</span><span class="pr-item-price">$3.00</span></li>
                        <li><span class="pr-item-name">Digital Airbrushing</span><span class="pr-item-price">$4.00</span></li>
                        <li><span class="pr-item-name">Portrait Cleaning &amp; Enhancement</span><span class="pr-item-price">$4.00</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn pr-card-btn-cyan">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Color Correction -->
                <div class="pr-card reveal" data-reveal="up" data-delay="0">
                    <div class="pr-card-header pr-accent-cyan">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-palette"></i></div>
                            <h3>Color Correction Service</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>0.50</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Basic Color Correction</span><span class="pr-item-price">$0.50</span></li>
                        <li><span class="pr-item-name">Medium Color Correction</span><span class="pr-item-price">$0.80</span></li>
                        <li><span class="pr-item-name">Complex Color Correction</span><span class="pr-item-price">$1.20</span></li>
                        <li><span class="pr-item-name">Complex Packshot Color Correction</span><span class="pr-item-price">$1.50</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn pr-card-btn-cyan">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

                <!-- Vector Conversion -->
                <div class="pr-card reveal" data-reveal="up" data-delay="100">
                    <div class="pr-card-header pr-accent-magenta">
                        <div class="pr-card-title-wrap">
                            <div class="pr-card-icon"><i class="fas fa-bezier-curve"></i></div>
                            <h3>Vector Conversion</h3>
                        </div>
                        <div class="pr-price-badge">
                            <span class="pr-from">Starting at</span>
                            <div class="pr-price"><sup>$</sup>4.49</div>
                            <span class="pr-per">per image</span>
                        </div>
                    </div>
                    <ul class="pr-list">
                        <li><span class="pr-item-name">Raster to Vector Conversion</span><span class="pr-item-price">$4.49</span></li>
                        <li><span class="pr-item-name">Vector Line Drawing</span><span class="pr-item-price">$4.49</span></li>
                        <li><span class="pr-item-name">Vector Logo Design</span><span class="pr-item-price">$50.00</span></li>
                        <li><span class="pr-item-name">2D CAD Design</span><span class="pr-item-price">$9.99</span></li>
                        <li><span class="pr-item-name">3D Vector Conversion</span><span class="pr-item-price">$19.99</span></li>
                        <li><span class="pr-item-name">Product to Vector</span><span class="pr-item-price">$14.99</span></li>
                    </ul>
                    <a href="#free-trial" class="pr-card-btn">Get Free Trial <i class="fas fa-arrow-right"></i></a>
                </div>

            </div>
        </div>
    </section>

    <!-- ============ TRUST STRIP ============ -->
    <section class="pr-trust">
        <div class="container">
            <div class="pr-trust-grid">
                <div class="pr-trust-item reveal" data-reveal="up" data-delay="0">
                    <i class="fas fa-rotate-left"></i>
                    <span>Unlimited Free Revisions</span>
                </div>
                <div class="pr-trust-item reveal" data-reveal="up" data-delay="100">
                    <i class="fas fa-bolt"></i>
                    <span>24–48 Hour Delivery</span>
                </div>
                <div class="pr-trust-item reveal" data-reveal="up" data-delay="200">
                    <i class="fas fa-shield-halved"></i>
                    <span>100% Data Security</span>
                </div>
                <div class="pr-trust-item reveal" data-reveal="up" data-delay="300">
                    <i class="fas fa-headset"></i>
                    <span>24/7 Dedicated Support</span>
                </div>
                <div class="pr-trust-item reveal" data-reveal="up" data-delay="400">
                    <i class="fas fa-users"></i>
                    <span>120+ Expert Editors</span>
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

    <!-- ============ CUSTOM PRICING CTA ============ -->
    <section class="pr-cta">
        <div class="container">
            <div class="pr-cta-inner reveal" data-reveal="up">
                <span class="section-tag">Custom Solutions</span>
                <h2>Let's Talk About Your<br>Custom Pricing</h2>
                <p>Check out what satisfied customers have to say about our products &amp; services. We're ready to discuss your specific needs and create a tailored solution that fits your budget and requirements.</p>
                <div class="pr-cta-actions">
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-primary">Let's Talk</a>
                    <a href="<?php echo esc_url( home_url('/portfolio/') ); ?>" class="btn pr-btn-outline">View Our Work</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PRICING CALCULATOR SCRIPT ============ -->
    <script>
    (function () {
        // Prices mirror the pricing cards below — keep in sync if cards change.
        var PRICING = [
            { name: "Clipping Path", items: [
                ["Basic Clipping Path", 0.39], ["Simple Clipping Path", 0.80],
                ["Medium Clipping Path", 1.50], ["Complex Clipping Path", 3.99],
                ["Super Complex Clipping Path", 7.99], ["Remove Unwanted Objects", 1.25]
            ]},
            { name: "Shadow Creation", items: [
                ["Drop Shadow Creation", 0.49], ["Reflection Shadow Creation", 0.99],
                ["Realistic Shadow Creation", 1.49], ["Retain Original Shadow", 0.49],
                ["Shadow Removal Service", 0.99], ["Shadow on Portrait", 1.99]
            ]},
            { name: "Ghost Mannequin Effects", items: [
                ["Basic Neck Joint on Ghost Mannequin", 0.75], ["Medium Neck Joint on Ghost Mannequin", 1.00],
                ["Complex Neck Joint on Ghost Mannequin", 1.20], ["Complex Packshot Ghost Mannequin Effect", 1.50]
            ]},
            { name: "Image Masking", items: [
                ["Layer Masking", 0.75], ["Alpha Channel Masking", 0.99],
                ["Fur & Hair Masking", 1.20], ["Refine Edge Masking", 1.49],
                ["Transparent Image Masking", 2.49], ["Color Masking", 3.49]
            ]},
            { name: "E-commerce Photo Editing", items: [
                ["Product Background Remove", 0.50], ["Bulk Photo Editing", 0.25],
                ["Color Correction", 0.99], ["Photoshop Shadow Effect", 0.49],
                ["Ghost Mannequin Effect", 1.20], ["Product Photo Cleaning", 1.00]
            ]},
            { name: "Photography Retouching", items: [
                ["Headshots & Face Retouching", 1.50], ["Beauty & Glamor Retouching", 2.00],
                ["Body Retouching & Reshaping", 3.00], ["Digital Airbrushing", 4.00],
                ["Portrait Cleaning & Enhancement", 4.00]
            ]},
            { name: "Color Correction Service", items: [
                ["Basic Color Correction", 0.50], ["Medium Color Correction", 0.80],
                ["Complex Color Correction", 1.20], ["Complex Packshot Color Correction", 1.50]
            ]},
            { name: "Vector Conversion", items: [
                ["Raster to Vector Conversion", 4.49], ["Vector Line Drawing", 4.49],
                ["Vector Logo Design", 50.00], ["2D CAD Design", 9.99],
                ["3D Vector Conversion", 19.99], ["Product to Vector", 14.99]
            ]}
        ];

        var catSel = document.getElementById('pc-category');
        var typeSel = document.getElementById('pc-type');
        var qtyInput = document.getElementById('pc-qty');
        var minusBtn = document.getElementById('pc-minus');
        var plusBtn = document.getElementById('pc-plus');
        var sumType = document.getElementById('pc-sum-type');
        var sumPrice = document.getElementById('pc-sum-price');
        var sumQty = document.getElementById('pc-sum-qty');
        var totalEl = document.getElementById('pc-total');
        if (!catSel) return;

        // Populate categories
        PRICING.forEach(function (cat, i) {
            var o = document.createElement('option');
            o.value = i; o.textContent = cat.name;
            catSel.appendChild(o);
        });

        function populateTypes() {
            typeSel.innerHTML = '';
            var cat = PRICING[catSel.value];
            cat.items.forEach(function (item, j) {
                var o = document.createElement('option');
                o.value = j;
                o.textContent = item[0] + ' — $' + item[1].toFixed(2);
                typeSel.appendChild(o);
            });
        }

        function money(n) {
            return n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        function recalc() {
            var cat = PRICING[catSel.value];
            var item = cat.items[typeSel.value] || cat.items[0];
            var qty = parseInt(qtyInput.value, 10);
            if (isNaN(qty) || qty < 1) qty = 1;
            var total = item[1] * qty;
            sumType.textContent = item[0];
            sumPrice.textContent = '$' + item[1].toFixed(2) + ' / image';
            sumQty.textContent = qty.toLocaleString('en-US') + (qty === 1 ? ' image' : ' images');
            totalEl.innerHTML = '<sup>$</sup>' + money(total);
        }

        catSel.addEventListener('change', function () { populateTypes(); recalc(); });
        typeSel.addEventListener('change', recalc);
        qtyInput.addEventListener('input', recalc);
        qtyInput.addEventListener('blur', function () {
            if (parseInt(qtyInput.value, 10) < 1 || isNaN(parseInt(qtyInput.value, 10))) qtyInput.value = 1;
            recalc();
        });
        minusBtn.addEventListener('click', function () {
            var q = parseInt(qtyInput.value, 10) || 1;
            qtyInput.value = Math.max(1, q - 1); recalc();
        });
        plusBtn.addEventListener('click', function () {
            var q = parseInt(qtyInput.value, 10) || 0;
            qtyInput.value = q + 1; recalc();
        });

        populateTypes();
        recalc();
    })();
    </script>

<?php get_footer(); ?>

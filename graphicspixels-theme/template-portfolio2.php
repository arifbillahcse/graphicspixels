<?php /* Template Name: Portfolio2 */ ?>
<?php get_header(); ?>

<style>
        /* ============ PORTFOLIO PAGE (scoped pf-) ============ */
        .svc-hero {
            position: relative; overflow: hidden;
            background: var(--navy, #01015E); padding: 100px 0;
        }
        .svc-hero-pattern {
            position: absolute; inset: 0; z-index: 0; pointer-events: none;
        }
        .svc-hero-pattern i {
            position: absolute; color: rgba(195,0,157,0.2); opacity: 0.6;
            animation: iconDrift var(--dur, 9s) ease-in-out infinite;
            animation-delay: var(--dl, 0s);
        }
        .svc-hero-inner {
            position: relative; z-index: 2;
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        .svc-hero-content { padding-right: 40px; }
        .svc-hero-visual { display: flex; align-items: center; justify-content: center; }
        .svc-hero .hero-eyebrow {
            display: inline-block; color: #fff; background: rgba(255,255,255,0.14);
            padding: 7px 18px; border-radius: 100px; font-size: 13px; font-weight: 600;
            letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px;
        }
        .svc-hero h1 {
            font-family: 'Poppins', sans-serif; color: #fff;
            font-size: 48px; font-weight: 800; line-height: 1.2; margin-bottom: 22px;
        }
        .svc-hero p {
            color: rgba(255,255,255,0.75); font-size: 16px; line-height: 1.7;
            margin-bottom: 28px;
        }
        .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; }
        @keyframes iconDrift {
            0%, 100% { transform: rotate(var(--rot, 0deg)) translateY(0); }
            50% { transform: rotate(var(--rot, 0deg)) translateY(-12px); }
        }

        /* ---- Filter bar ---- */
        .pf-gallery { padding: 70px 0 90px; }
        .pf-filters {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;
            margin-bottom: 46px;
        }
        .pf-filter-btn {
            border: 1.5px solid #e4e4ef; background: #fff; color: var(--text, #1a1a2e);
            padding: 9px 18px; border-radius: 100px; font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all .25s ease; display: inline-flex; align-items: center; gap: 7px;
            font-family: 'Inter', sans-serif;
        }
        .pf-filter-btn i { font-size: 12px; opacity: .85; }
        .pf-filter-btn:hover { border-color: var(--magenta, #C3009D); color: var(--magenta, #C3009D); transform: translateY(-2px); }
        .pf-filter-btn.active {
            background: var(--gradient, linear-gradient(135deg,#01015E,#C3009D));
            border-color: transparent; color: #fff; box-shadow: 0 8px 20px rgba(195,0,157,0.28);
        }

        /* ---- Grid ---- */
        .pf-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 26px;
        }
        .pf-item {
            margin: 0; position: relative; border-radius: 16px; overflow: hidden;
            background: #f4f4f8; box-shadow: 0 10px 30px rgba(1,1,94,0.08);
            opacity: 0; transform: translateY(24px); animation: pfIn .5s ease forwards;
            transition: transform .4s ease, box-shadow .4s ease;
        }
        @keyframes pfIn { to { opacity: 1; transform: translateY(0); } }
        .pf-item:hover { transform: translateY(-6px); box-shadow: 0 20px 44px rgba(195,0,157,0.18); }
        .pf-item.pf-hide { display: none; }
        .pf-img {
            aspect-ratio: 4 / 3; overflow: hidden; cursor: zoom-in;
            display: flex; align-items: center; justify-content: center; background: #fff;
        }
        .pf-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform .6s ease;
        }
        .pf-item:hover .pf-img img { transform: scale(1.07); }
        .pf-tag {
            position: absolute; left: 12px; bottom: 12px; z-index: 3;
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(1,1,30,0.72); backdrop-filter: blur(6px);
            color: #fff; font-size: 12px; font-weight: 600; letter-spacing: .3px;
            padding: 6px 13px; border-radius: 100px;
            opacity: 1; transform: translateY(0); transition: all .3s ease;
        }
        .pf-tag i { color: #00e0ff; font-size: 11px; }
        .pf-zoom {
            position: absolute; top: 12px; right: 12px; z-index: 3;
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,0.92); color: var(--magenta, #C3009D);
            display: flex; align-items: center; justify-content: center; font-size: 14px;
            opacity: 0; transform: scale(.7); transition: all .3s ease; pointer-events: none;
        }
        .pf-item:hover .pf-zoom { opacity: 1; transform: scale(1); }
        .pf-empty { text-align: center; color: var(--text-light, #6a6a85); padding: 50px 0; font-size: 16px; display: none; }

        /* ---- CTA strip ---- */
        .pf-cta {
            background: var(--gradient, linear-gradient(135deg,#01015E,#C3009D));
            padding: 70px 0; text-align: center; position: relative; overflow: hidden;
        }
        .pf-cta::before {
            content: ""; position: absolute; inset: 0;
            background: radial-gradient(circle at 70% 30%, rgba(0,255,255,0.16), transparent 50%);
        }
        .pf-cta-inner { position: relative; z-index: 2; }
        .pf-cta h2 { font-family: 'Poppins', sans-serif; color: #fff; font-size: 34px; font-weight: 800; margin-bottom: 14px; }
        .pf-cta p { color: rgba(255,255,255,0.85); font-size: 16px; max-width: 600px; margin: 0 auto 28px; }
        .pf-cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        /* ---- Portfolio lightbox ---- */
        .pf-lb { display: none; position: fixed; inset: 0; z-index: 9999; }
        .pf-lb.open { display: flex; align-items: center; justify-content: center; animation: lightboxFadeIn .3s ease forwards; }
        .pf-lb-back { position: absolute; inset: 0; background: rgba(1,1,30,0.92); backdrop-filter: blur(6px); cursor: pointer; }
        .pf-lb-box { position: relative; z-index: 2; max-width: 90vw; max-height: 86vh; }
        .pf-lb-box img { max-width: 90vw; max-height: 78vh; border-radius: 12px; display: block; box-shadow: 0 30px 80px rgba(0,0,0,0.5); }
        .pf-lb-cap { color: #fff; text-align: center; margin-top: 14px; font-size: 14px; letter-spacing: .3px; }
        .pf-lb-btn {
            position: absolute; z-index: 3; width: 52px; height: 52px; border-radius: 50%;
            border: none; background: rgba(255,255,255,0.14); color: #fff; font-size: 18px;
            cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .2s ease;
        }
        .pf-lb-btn:hover { background: var(--magenta, #C3009D); transform: scale(1.1); }
        .pf-lb-close { top: 24px; right: 24px; }
        .pf-lb-prev { left: 24px; top: 50%; transform: translateY(-50%); }
        .pf-lb-next { right: 24px; top: 50%; transform: translateY(-50%); }
        .pf-lb-prev:hover { transform: translateY(-50%) scale(1.1); }
        .pf-lb-next:hover { transform: translateY(-50%) scale(1.1); }

        @media (max-width: 1024px) {
            .svc-hero-inner { grid-template-columns: 1fr; gap: 40px; }
            .svc-hero-content { padding-right: 0; }
        }
        @media (max-width: 768px) {
            .svc-hero h1 { font-size: 36px; }
            .svc-hero p { font-size: 15px; }
            .hero-actions { flex-direction: column; }
            .hero-actions .btn { width: 100%; }
            .pf-grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 14px; }
            .pf-cta h2 { font-size: 26px; }
            .pf-lb-prev { left: 10px; } .pf-lb-next { right: 10px; }
        }
    </style>

<!-- ============ HEADER / NAVIGATION (auto-loaded) ============ -->

    <!-- ============ PORTFOLIO HERO ============ -->
    <section class="svc-hero">
        <div class="svc-hero-pattern" aria-hidden="true">
            <i class="fas fa-image" style="top:12%;left:8%;font-size:56px;--rot:-18deg;--dl:0s;--dur:11s"></i>
            <i class="fas fa-star" style="top:75%;left:12%;font-size:44px;--rot:25deg;--dl:1.4s;--dur:9.5s"></i>
            <i class="fas fa-sparkles" style="top:20%;left:75%;font-size:52px;--rot:-12deg;--dl:0.8s;--dur:10s"></i>
            <i class="fas fa-palette" style="top:70%;left:82%;font-size:48px;--rot:32deg;--dl:1.6s;--dur:12s"></i>
            <i class="fas fa-circle-check" style="top:35%;left:88%;font-size:40px;--rot:-8deg;--dl:0.4s;--dur:8.5s"></i>
        </div>

        <div class="container svc-hero-inner">
            <div class="svc-hero-content reveal" data-reveal="up">
                <span class="hero-eyebrow">Our Work</span>
                <h1>A Portfolio Built Across Every Service</h1>
                <p>
                    Real before-and-after results from 13+ years of hand-crafted photo editing. Browse work from every service we offer — clipping path, retouching, ghost mannequin, background removal, color correction, drop shadow, masking, restoration, and full e-commerce production.
                </p>
                <div class="hero-actions">
                    <a href="#portfolio" class="btn btn-primary">View Gallery</a>
                    <a href="#free-trial" class="btn btn-outline-white">Start Free Trial</a>
                </div>
            </div>

            <div class="svc-hero-visual reveal" data-reveal="right">
                <div style="width:100%;max-width:420px;text-align:center;">
                    <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:auto;filter:drop-shadow(0 0 30px rgba(195,0,157,0.25))">
                        <defs><filter id="pfGlow"><feGaussianBlur stdDeviation="2" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter></defs>
                        <rect x="80" y="80" width="240" height="240" rx="12" fill="none" stroke="#00d4ff" stroke-width="2" opacity="0.8"/>
                        <circle cx="200" cy="200" r="60" fill="none" stroke="#C3009D" stroke-width="2" opacity="0.7"/>
                        <circle cx="200" cy="200" r="40" fill="none" stroke="#C3009D" stroke-width="1.5" opacity="0.5"/>
                        <circle cx="200" cy="200" r="25" fill="none" stroke="#00d4ff" stroke-width="1" opacity="0.6"/>
                        <circle cx="200" cy="200" r="20" fill="#0d0d60" stroke="#C3009D" stroke-width="1.5" opacity="0.9"/>
                        <image href="<?php echo esc_url( gp_media_base() ); ?>/images/gp-logo.png" x="186" y="186" width="28" height="28" opacity="0.9"/>
                        <circle cx="200" cy="80" r="8" fill="#00d4ff" opacity="0.8"/>
                        <circle cx="320" cy="200" r="6" fill="#C3009D" opacity="0.7"/>
                        <circle cx="200" cy="320" r="8" fill="#00ff88" opacity="0.8"/>
                        <circle cx="80" cy="200" r="6" fill="#ffff00" opacity="0.7"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FILTERABLE GALLERY ============ -->
    <section class="pf-gallery">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Portfolio</span>
                <h2 class="section-title">Explore Our Work by Service</h2>
                <p class="section-desc">Click any image to view it full size. Use the filters to focus on a single service.</p>
            </div>

            <!-- Filter bar -->
            <div class="pf-filters reveal" data-reveal="up" data-delay="80">
                <button class="pf-filter-btn active" data-filter="all"><i class="fas fa-border-all"></i> All Work</button>
                <button class="pf-filter-btn" data-filter="clipping"><i class="fas fa-scissors"></i> Clipping Path</button>
                <button class="pf-filter-btn" data-filter="retouching"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</button>
                <button class="pf-filter-btn" data-filter="ghost"><i class="fas fa-shirt"></i> Ghost Mannequin</button>
                <button class="pf-filter-btn" data-filter="headshot"><i class="fas fa-user"></i> Headshot Editing</button>
                <button class="pf-filter-btn" data-filter="background"><i class="fas fa-eraser"></i> Background Removal</button>
                <button class="pf-filter-btn" data-filter="color"><i class="fas fa-sliders"></i> Color Correction</button>
                <button class="pf-filter-btn" data-filter="shadow"><i class="fas fa-clone"></i> Drop Shadow</button>
                <button class="pf-filter-btn" data-filter="masking"><i class="fas fa-mask"></i> Image Masking</button>
                <button class="pf-filter-btn" data-filter="ecommerce"><i class="fas fa-cart-shopping"></i> E-commerce Editing</button>
                <button class="pf-filter-btn" data-filter="restoration"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</button>
            </div>

            <!-- Grid -->
            <div class="pf-grid" id="pfGrid">

                <!-- ===== CLIPPING PATH ===== -->
                <figure class="pf-item" data-cat="clipping">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/1.%20White%20and%20Colored%20Backgrounds/1%20graphics%20pixels.jpg" alt="Clipping Path — White & Coloured Background" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-scissors"></i> Clipping Path</figcaption>
                </figure>
                <figure class="pf-item" data-cat="clipping">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/2.%20Product%20Placement%20Into%20Scenes/graphics%20pixels%20%281%29.jpg" alt="Clipping Path — Product Placement Into Scenes" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-scissors"></i> Clipping Path</figcaption>
                </figure>
                <figure class="pf-item" data-cat="clipping">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/3.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%281%29.jpg" alt="Clipping Path — Visual Appeal Cutout" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-scissors"></i> Clipping Path</figcaption>
                </figure>
                <figure class="pf-item" data-cat="clipping">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/3.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%282%29.jpg" alt="Clipping Path — Complex Path Cutout" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-scissors"></i> Clipping Path</figcaption>
                </figure>
                <figure class="pf-item" data-cat="clipping">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/1.%20clipping-path-service/4.%20Image%20Get%20More%20Visually%20Appeal%20to%20Customers/graphics%20pixels%20%281%29.jpg" alt="Clipping Path — Super-Complex Subject" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-scissors"></i> Clipping Path</figcaption>
                </figure>

                <!-- ===== PHOTO RETOUCHING ===== -->
                <figure class="pf-item" data-cat="retouching">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/1.%20High-End%20Beauty%20%26%20Portrait%20Retouching/graphics%20pixels%20%281%29.jpg" alt="High-End Beauty & Portrait Retouching" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</figcaption>
                </figure>
                <figure class="pf-item" data-cat="retouching">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/2.%20E-commerce%20%26%20Product%20Retouching/graphics%20pixels%20%281%29.jpg" alt="E-commerce & Product Retouching" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</figcaption>
                </figure>
                <figure class="pf-item" data-cat="retouching">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/3.%20Model%20Portrait%20Retouching/graphics%20pixels%20%281%29.jpg" alt="Model Portrait Retouching" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</figcaption>
                </figure>
                <figure class="pf-item" data-cat="retouching">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/4.%20Commercial%20%26%20Editorial%20Retouching/graphics%20pixels%20%281%29.jpg" alt="Commercial & Editorial Retouching" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</figcaption>
                </figure>
                <figure class="pf-item" data-cat="retouching">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/5.%20Fashion%20%26%20Beauty%20Photo%20Retouching/graphics%20pixels%20%281%29.jpg" alt="Fashion & Beauty Photo Retouching" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-wand-magic-sparkles"></i> Photo Retouching</figcaption>
                </figure>

                <!-- ===== GHOST MANNEQUIN ===== -->
                <figure class="pf-item" data-cat="ghost">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/2.%20Neck%20Joint%20Services/graphics%20pixels%20%281%29.jpg" alt="Ghost Mannequin — Neck Joint Service" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-shirt"></i> Ghost Mannequin</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ghost">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/3.%20Exhibit%20a%20True-to-Life%20Look/graphics%20pixels%20%281%29.jpg" alt="Ghost Mannequin — True-to-Life Look" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-shirt"></i> Ghost Mannequin</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ghost">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/4.%20Engage%20the%20Largest%20Number%20of%20Viewers/graphics%20pixels%20%281%29.jpg" alt="Ghost Mannequin — Apparel Display" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-shirt"></i> Ghost Mannequin</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ghost">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/5.%20Get%20top-notch%20editing%20Retouched%20Photos/graphics%20pixels%20%281%29.jpg" alt="Ghost Mannequin — Retouched Garment" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-shirt"></i> Ghost Mannequin</figcaption>
                </figure>

                <!-- ===== HEADSHOT EDITING ===== -->
                <figure class="pf-item" data-cat="headshot">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/1.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results/graphics%20pixels%20%281%29.jpg" alt="Headshot Editing — Before & After" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-user"></i> Headshot Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="headshot">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/2.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy/graphics%20pixels%20%281%29.jpg" alt="Headshot Editing — Natural Retouch" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-user"></i> Headshot Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="headshot">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/3.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20%284%29/graphics%20pixels%20%281%29.jpg" alt="Headshot Editing — Corporate Profile" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-user"></i> Headshot Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="headshot">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/4.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20%283%29/graphics%20pixels%20%281%29.jpg" alt="Headshot Editing — Professional Portrait" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-user"></i> Headshot Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="headshot">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/5.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20%282%29/graphics%20pixels%20%281%29.jpg" alt="Headshot Editing — Portfolio Headshot" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-user"></i> Headshot Editing</figcaption>
                </figure>

                <!-- ===== BACKGROUND REMOVAL ===== -->
                <figure class="pf-item" data-cat="background">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/1.%20Our%20services%20for%20removing%20backgrounds/graphics%20pixels%20%281%29.jpg" alt="Background Removal — Clean Cutout" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-eraser"></i> Background Removal</figcaption>
                </figure>
                <figure class="pf-item" data-cat="background">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/2.%20Our%20retouching%20features/graphics%20pixels%20%281%29.jpg" alt="Background Removal — Retouching Feature" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-eraser"></i> Background Removal</figcaption>
                </figure>
                <figure class="pf-item" data-cat="background">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/3.%20Exact%20Clipping%20Path%20Services%20for%20Clean%20Cutouts/graphics%20pixels%20%281%29.png" alt="Background Removal — Transparent PNG" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-eraser"></i> Background Removal</figcaption>
                </figure>
                <figure class="pf-item" data-cat="background">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/4.%20Background%20Merging%20Services/graphics%20pixels%20%281%29.jpg" alt="Background Removal — Background Merge" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-eraser"></i> Background Removal</figcaption>
                </figure>
                <figure class="pf-item" data-cat="background">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/5.%20Get%20A%20Standard%20Image%20Look/graphics%20pixels%20%281%29.png" alt="Background Removal — Standard White" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-eraser"></i> Background Removal</figcaption>
                </figure>

                <!-- ===== COLOR CORRECTION ===== -->
                <figure class="pf-item" data-cat="color">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/1.%20Color%20correction%20what%20is%20it/graphics%20pixels%20%281%29.jpg" alt="Color Correction — White Balance" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-sliders"></i> Color Correction</figcaption>
                </figure>
                <figure class="pf-item" data-cat="color">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/2.%20Why%20Does%20Your%20Company%20Need%20Color%20Correction/graphics%20pixels%20%281%29.jpg" alt="Color Correction — Catalog Consistency" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-sliders"></i> Color Correction</figcaption>
                </figure>
                <figure class="pf-item" data-cat="color">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/3.%20How%20Does%20the%20Process%20of%20Color%20Correction%20Operate/graphics%20pixels%20%281%29.jpg" alt="Color Correction — Process" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-sliders"></i> Color Correction</figcaption>
                </figure>
                <figure class="pf-item" data-cat="color">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/4.%20Typical%20Applications%20for%20Color%20Correction%20Services/graphics%20pixels%20%281%29.jpg" alt="Color Correction — Application" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-sliders"></i> Color Correction</figcaption>
                </figure>
                <figure class="pf-item" data-cat="color">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/5.%20Professional%20Color%20Correction_s%20Advantages/graphics%20pixels%20%281%29.jpg" alt="Color Correction — Brand Accuracy" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-sliders"></i> Color Correction</figcaption>
                </figure>

                <!-- ===== DROP SHADOW ===== -->
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/1.%20Types%20of%20Shadow%20Effects%20We%20Provide/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Shadow Types" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/2.%20Drop%20Shadow%20Services%20for%20Realistic%20Product%20Photos/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Realistic Product" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/3.%20Reflection%20Shadow%20Editing%20for%20Clean%2C%20Polished%20Images/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Reflection Shadow" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/4.%20Photoshop%20Natural%20Shadow%20Creation/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Natural Shadow" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/5.%20Options%20for%20Shadow%20Customization/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Customisation" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>
                <figure class="pf-item" data-cat="shadow">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/6.%20Our%20Workflow%20for%20Drop%20Shadow/graphics%20pixels%20%281%29.jpg" alt="Drop Shadow — Workflow" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clone"></i> Drop Shadow</figcaption>
                </figure>

                <!-- ===== IMAGE MASKING ===== -->
                <figure class="pf-item" data-cat="masking">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/1.%20Layer%20Masking/graphics%20pixels%20%281%29.jpg" alt="Image Masking — Layer Masking" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-mask"></i> Image Masking</figcaption>
                </figure>
                <figure class="pf-item" data-cat="masking">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/5.%20Hair%20%26%20Fur%20Masking/graphics%20pixels%20%281%29.jpg" alt="Image Masking — Hair & Fur Masking" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-mask"></i> Image Masking</figcaption>
                </figure>

                <!-- ===== E-COMMERCE IMAGE EDITING ===== -->
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/1.%20Clipping%20Path%20with%20Ecommerce%20Image%20Editing%20Services/1%20graphics%20pixels%20%281%29.jpg" alt="E-commerce Editing — Clipping Path Workflow" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/1.%20Clipping%20Path%20with%20Ecommerce%20Image%20Editing%20Services/graphics%20p.jpg" alt="E-commerce Editing — Product Prep" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/2.%20Product%20Image%20Background%20Removal/graphics%20pixels%20%281%29.jpg" alt="E-commerce Editing — Background Removal" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/3.%20Product%20Image%20Background%20Removal%20-%20Copy/graphics%20pixels%20%281%29.jpg" alt="E-commerce Editing — Marketplace Ready" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/4.%20Product%20Image%20Background%20Removal%20-%20Copy%20%283%29/graphics%20pixels%20%281%29.jpg" alt="E-commerce Editing — Catalog Image" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>
                <figure class="pf-item" data-cat="ecommerce">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/5.%20Product%20Image%20Background%20Removal%20-%20Copy%20%282%29/graphics%20pixels%20%281%29.jpg" alt="E-commerce Editing — Bundled Output" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-cart-shopping"></i> E-commerce Editing</figcaption>
                </figure>

                <!-- ===== PHOTO RESTORATION ===== -->
                <figure class="pf-item" data-cat="restoration">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/1%20photo-restoration-service/graphics%20pixels%20%281%29.jpg" alt="Photo Restoration — Scratch & Tear Repair" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</figcaption>
                </figure>
                <figure class="pf-item" data-cat="restoration">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/2%20photo-restoration-service/graphics%20pixels%20%281%29.jpg" alt="Photo Restoration — Water Damage Repair" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</figcaption>
                </figure>
                <figure class="pf-item" data-cat="restoration">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/3.%20photo-restoration-service/graphics%20pixels%20%281%29.jpg" alt="Photo Restoration — Fading Restoration" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</figcaption>
                </figure>
                <figure class="pf-item" data-cat="restoration">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/4.%20photo-restoration-service/graphics%20pixels%20%281%29.jpg" alt="Photo Restoration — Missing Section Rebuild" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</figcaption>
                </figure>
                <figure class="pf-item" data-cat="restoration">
                    <div class="pf-img"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/5.%20photo-restoration-service/graphics%20pixels%20%281%29.jpg" alt="Photo Restoration — B&W Colorization" loading="lazy"></div>
                    <span class="pf-zoom"><i class="fas fa-expand"></i></span>
                    <figcaption class="pf-tag"><i class="fas fa-clock-rotate-left"></i> Photo Restoration</figcaption>
                </figure>

            </div><!-- /.pf-grid -->

            <p class="pf-empty" id="pfEmpty">No items in this category yet.</p>
        </div>
    </section>

    <!-- ============ VIDEO TESTIMONIALS SECTION ============ -->
    <section class="vt-section" id="portfolio">
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
                    What Photographers, Business Owners, and Ecommerce Brands Say About Our Photo Retouching &amp; Post-Production Services
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

                <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="vt-cta">
                    START A FREE TRIAL
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

    <!-- ============ PORTFOLIO LIGHTBOX ============ -->
    <div class="pf-lb" id="pfLb" role="dialog" aria-modal="true" aria-label="Portfolio image preview">
        <div class="pf-lb-back" id="pfLbBack"></div>
        <button class="pf-lb-btn pf-lb-close" id="pfLbClose" aria-label="Close"><i class="fas fa-times"></i></button>
        <button class="pf-lb-btn pf-lb-prev" id="pfLbPrev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
        <button class="pf-lb-btn pf-lb-next" id="pfLbNext" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
        <div class="pf-lb-box">
            <img id="pfLbImg" src="" alt="">
            <p class="pf-lb-cap" id="pfLbCap"></p>
        </div>
    </div>


    <!-- ============ PORTFOLIO FILTER + LIGHTBOX ============ -->
    <script>
    (function () {
        var grid    = document.getElementById('pfGrid');
        if (!grid) return;
        var items   = Array.prototype.slice.call(grid.querySelectorAll('.pf-item'));
        var btns    = Array.prototype.slice.call(document.querySelectorAll('.pf-filter-btn'));
        var empty   = document.getElementById('pfEmpty');

        /* ---- Filtering ---- */
        function applyFilter(cat) {
            var shown = 0;
            items.forEach(function (item) {
                var match = (cat === 'all' || item.getAttribute('data-cat') === cat);
                item.classList.toggle('pf-hide', !match);
                if (match) {
                    shown++;
                    // restart entrance animation
                    item.style.animation = 'none';
                    /* eslint-disable no-unused-expressions */
                    item.offsetHeight;
                    item.style.animation = '';
                }
            });
            if (empty) empty.style.display = shown ? 'none' : 'block';
        }

        btns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                btns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                applyFilter(btn.getAttribute('data-filter'));
            });
        });

        /* ---- Lightbox (respects current filter) ---- */
        var lb      = document.getElementById('pfLb');
        var lbImg   = document.getElementById('pfLbImg');
        var lbCap   = document.getElementById('pfLbCap');
        var lbClose = document.getElementById('pfLbClose');
        var lbBack  = document.getElementById('pfLbBack');
        var lbPrev  = document.getElementById('pfLbPrev');
        var lbNext  = document.getElementById('pfLbNext');
        var current = 0;
        var visible = [];

        function buildVisible() {
            visible = items
                .filter(function (it) { return !it.classList.contains('pf-hide'); })
                .map(function (it) { return it.querySelector('img'); });
        }

        function show(idx) {
            if (!visible.length) return;
            if (idx < 0) idx = visible.length - 1;
            if (idx >= visible.length) idx = 0;
            current = idx;
            lbImg.src = visible[current].src;
            lbImg.alt = visible[current].alt;
            lbCap.textContent = visible[current].alt;
        }

        function open(img) {
            buildVisible();
            var idx = visible.indexOf(img);
            if (idx < 0) idx = 0;
            show(idx);
            lb.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function close() {
            lb.classList.remove('open');
            lbImg.src = '';
            document.body.style.overflow = '';
        }

        items.forEach(function (item) {
            var img = item.querySelector('img');
            var trigger = item.querySelector('.pf-img');
            if (trigger && img) {
                trigger.addEventListener('click', function () { open(img); });
            }
        });

        if (lbPrev)  lbPrev.addEventListener('click', function () { show(current - 1); });
        if (lbNext)  lbNext.addEventListener('click', function () { show(current + 1); });
        if (lbClose) lbClose.addEventListener('click', close);
        if (lbBack)  lbBack.addEventListener('click', close);

        document.addEventListener('keydown', function (e) {
            if (!lb.classList.contains('open')) return;
            if (e.key === 'Escape')     close();
            if (e.key === 'ArrowLeft')  show(current - 1);
            if (e.key === 'ArrowRight') show(current + 1);
        });

        var touchX = 0;
        lb.addEventListener('touchstart', function (e) { touchX = e.changedTouches[0].screenX; }, { passive: true });
        lb.addEventListener('touchend', function (e) {
            var diff = touchX - e.changedTouches[0].screenX;
            if (Math.abs(diff) >= 50) show(diff > 0 ? current + 1 : current - 1);
        }, { passive: true });
    })();
    </script>

<?php get_footer(); ?>

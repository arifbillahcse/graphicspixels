<?php /* Template Name: Portfolio */ ?>
<?php get_header(); ?>

<style>
        /* ── Before / After slider ── */
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
            position: absolute; top: 16px; font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
            color: var(--white); padding: 5px 14px; border-radius: 50px; letter-spacing: 0.5px;
            text-transform: uppercase; pointer-events: none; backdrop-filter: blur(4px);
        }
        .ba-label-before { left: 16px; background: rgba(1,1,94,0.7); }
        .ba-label-after  { right: 16px; background: rgba(195,0,157,0.8); }
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

        /* ── Portfolio service sections ── */
        .pf-service {
            padding: 20px 0;
        }
        .pf-service:nth-child(even) {
            background: var(--bg-light, #f8f8fc);
        }
        .pf-service-head {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 40px; flex-wrap: wrap; gap: 16px;
        }
        .pf-service-head-text { flex: 1; min-width: 220px; }
        .pf-service-head-text .section-tag { margin-bottom: 8px; }
        .pf-service-title {
            font-family: 'Poppins', sans-serif;
            font-size: 30px; font-weight: 700; color: var(--navy, #01015E);
            margin: 0;
        }
        .pf-service-link {
            display: inline-flex; align-items: center; gap: 8px;
            font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600;
            color: var(--magenta, #C3009D); text-decoration: none;
            border: 2px solid var(--magenta, #C3009D);
            padding: 10px 22px; border-radius: 8px;
            transition: all 0.25s ease; white-space: nowrap;
        }
        .pf-service-link:hover {
            background: var(--magenta, #C3009D); color: #fff;
        }
        .pf-grid {
            display: grid; gap: 24px;
        }
        .pf-grid-3 { grid-template-columns: repeat(3, 1fr); }
        .pf-grid-2 { grid-template-columns: repeat(2, 1fr); max-width: 800px; margin: 0 auto; }
        .pf-grid-1 { grid-template-columns: 1fr; max-width: 520px; margin: 0 auto; }

        /* ── Portfolio CTA strip ── */
        .pf-cta-strip {
            background: var(--navy, #01015E);
            padding: 70px 0;
            text-align: center;
        }
        .pf-cta-strip h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 36px; font-weight: 800; color: #fff;
            margin-bottom: 14px;
        }
        .pf-cta-strip p {
            color: rgba(255,255,255,0.75); font-size: 16px;
            max-width: 540px; margin: 0 auto 32px;
        }
        .pf-cta-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .pf-grid-3 { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .pf-grid-3, .pf-grid-2 { grid-template-columns: 1fr; max-width: 100%; }
            .pf-service { padding: 52px 0; }
            .pf-service-head { flex-direction: column; align-items: flex-start; }
            .pf-service-title { font-size: 24px; }
            .pf-cta-strip h2 { font-size: 26px; }
        }
    </style>
<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/8__Portfolio.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/8__Portfolio.png');
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
                <span class="ds-showcase-eyebrow">Our Work</span>
                <h2>Before &amp; After Portfolio</h2>
                <p class="ds-lead">Real results from 13+ years of professional photo editing.</p>
                <p>Drag any slider to compare the before and after — every image worked by hand in Photoshop by our specialists.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ PORTFOLIO SECTIONS ============ -->
    <div id="portfolio">

        <!-- ── CLIPPING PATH SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Clipping Path Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/clipping-path-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-1-14.jpg" alt="Before — Clipping Path Service">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-1-4.png" alt="After — Clipping Path Service">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-Before-1-6.jpg" alt="Before — Clipping Path Service">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-After-1-5.jpg" alt="After — Clipping Path Service">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-2-1-1.jpg" alt="Before — Clipping Path Service">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-3.jpg" alt="After — Clipping Path Service">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PHOTO RETOUCHING SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Photo Retouching Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/photo-retouching-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/1.%20High-End%20Beauty%20%26%20Portrait%20Retouching/graphics%20pixels%20(2).jpg" alt="Before — Beauty Retouching">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/1.%20High-End%20Beauty%20%26%20Portrait%20Retouching/graphics%20pixels%20(1).jpg" alt="After — Beauty Retouching">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/2.%20E-commerce%20%26%20Product%20Retouching/graphics%20pixels%20(2).jpg" alt="Before — Product Retouching">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/2.%20E-commerce%20%26%20Product%20Retouching/graphics%20pixels%20(1).jpg" alt="After — Product Retouching">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/3.%20Model%20Portrait%20Retouching/graphics%20pixels%20(2).jpg" alt="Before — Portrait Retouching">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/2.%20photo-retouching-service/3.%20Model%20Portrait%20Retouching/graphics%20pixels%20(1).jpg" alt="After — Portrait Retouching">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── GHOST MANNEQUIN SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Ghost Mannequin Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/ghost-mannequin-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/1-%203D%20or%20Pack-shot%20Ghost%20Mannequin%20Effect/graphics-pixels-after-12.jpg" alt="Before — 3D Pack-shot">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/1-%203D%20or%20Pack-shot%20Ghost%20Mannequin%20Effect/graphics-pixels-Before-16.jpg" alt="After — 3D Pack-shot">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/2.%20Neck%20Joint%20Services/graphics%20pixels%20(1).jpg" alt="Before — Neck Joint">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/2.%20Neck%20Joint%20Services/graphics%20pixels%20(2).jpg" alt="After — Neck Joint">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/4.%20Engage%20the%20Largest%20Number%20of%20Viewers/graphics%20pixels%20(2).jpg" alt="Before — Ghost Mannequin">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/3.%20ghost-mannequin-service/4.%20Engage%20the%20Largest%20Number%20of%20Viewers/graphics%20pixels%20(1).jpg" alt="After — Ghost Mannequin">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── HEADSHOT PHOTO EDITING ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Headshot Photo Editing</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/headshot-photo-editing/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/1.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results/graphics%20pixels%20(1).jpg" alt="Headshot Editing — Before & After" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/2.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy/graphics%20pixels%20(1).jpg" alt="Headshot Editing — Before & After" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/3.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20(4)/graphics%20pixels%20(1).jpg" alt="Headshot Editing — Before & After" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- ── BACKGROUND REMOVAL SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Background Removal Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/background-removal-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/1.%20Our%20services%20for%20removing%20backgrounds/graphics%20pixels%20(2).jpg" alt="Before — Background Removal">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/1.%20Our%20services%20for%20removing%20backgrounds/graphics%20pixels%20(1).jpg" alt="After — Background Removal">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/4.%20Background%20Merging%20Services/graphics%20pixels%20(2).jpg" alt="Before — Background Merging">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/4.%20Background%20Merging%20Services/graphics%20pixels%20(1).jpg" alt="After — Background Merging">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/5.%20background-removal-service/2.%20Our%20retouching%20features/graphics%20pixels%20(1).jpg" alt="Pure White Background for E-commerce" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- ── COLOR CORRECTION SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Color Correction Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/color-correction-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/1.%20Color%20correction%20what%20is%20it/graphics%20pixels%20(2).jpg" alt="Before — Color Correction">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/1.%20Color%20correction%20what%20is%20it/graphics%20pixels%20(1).jpg" alt="After — Color Correction">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/3.%20How%20Does%20the%20Process%20of%20Color%20Correction%20Operate/graphics%20pixels%20(2).jpg" alt="Before — Color Grading">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/3.%20How%20Does%20the%20Process%20of%20Color%20Correction%20Operate/graphics%20pixels%20(1).jpg" alt="After — Color Grading">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/4.%20Typical%20Applications%20for%20Color%20Correction%20Services/graphics%20pixels%20(2).jpg" alt="Before — Skin Tone Correction">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/6.%20color-correction-service/4.%20Typical%20Applications%20for%20Color%20Correction%20Services/graphics%20pixels%20(1).jpg" alt="After — Skin Tone Correction">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── DROP SHADOW SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Drop Shadow Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/drop-shadow-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/1.%20Types%20of%20Shadow%20Effects%20We%20Provide/graphics%20pixels%20(2).jpg" alt="Before — Drop Shadow">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/1.%20Types%20of%20Shadow%20Effects%20We%20Provide/graphics%20pixels%20(1).jpg" alt="After — Drop Shadow">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/4.%20Photoshop%20Natural%20Shadow%20Creation/graphics%20pixels%20(2).jpg" alt="Before — Natural Shadow">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/4.%20Photoshop%20Natural%20Shadow%20Creation/graphics%20pixels%20(1).jpg" alt="After — Natural Shadow">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/5.%20Options%20for%20Shadow%20Customization/graphics%20pixels%20(2).jpg" alt="Before — Shadow Customization">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/5.%20Options%20for%20Shadow%20Customization/graphics%20pixels%20(1).jpg" alt="After — Shadow Customization">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── IMAGE MASKING SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Image Masking Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/image-masking-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/2.%20ALPHA%20CHANNEL%20MASKING/graphics-pixels-After-1-4.jpg" alt="Before — Alpha Channel Masking">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/2.%20ALPHA%20CHANNEL%20MASKING/graphics-pixels-Before-1-5.jpg" alt="After — Alpha Channel Masking">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/3.%20TRANSPARENT%20OBJECT%20MASKING/graphics-pixels-After-2-5.jpg" alt="Before — Transparent Object Masking">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/3.%20TRANSPARENT%20OBJECT%20MASKING/graphics-pixels-Before-2-5.jpg" alt="After — Transparent Object Masking">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/4.%20REFINE%20EDGE%20MASKING/graphics-pixels-After-3-6.jpg" alt="Before — Refine Edge Masking">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/4.%20REFINE%20EDGE%20MASKING/graphics-pixels-Before-3-5.jpg" alt="After — Refine Edge Masking">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── E-COMMERCE IMAGE EDITING ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">E-commerce Image Editing</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/ecommerce-image-editing-services/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/1.%20Clipping%20Path%20with%20Ecommerce%20Image%20Editing%20Services/graphics%20p.jpg" alt="Before — E-commerce Clipping Path">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/1.%20Clipping%20Path%20with%20Ecommerce%20Image%20Editing%20Services/1%20graphics%20pixels%20(1).jpg" alt="After — E-commerce Clipping Path">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/2.%20Product%20Image%20Background%20Removal/graphics%20pixels%20(1).jpg" alt="E-commerce — Background Removal" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/9.%20ecommerce-image-editing-services/3.%20Product%20Image%20Background%20Removal%20-%20Copy/graphics%20pixels%20(1).jpg" alt="E-commerce — Ghost Mannequin Effect" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                </div>
            </div>
        </section>

        <!-- ── PHOTO RESTORATION SERVICE ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">Photo Restoration Service</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/photo-restoration-service/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/3.%20photo-restoration-service/graphics%20pixels%20(2).jpg" alt="Before — Photo Restoration">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/10.%20photo-restoration-service/3.%20photo-restoration-service/graphics%20pixels%20(1).jpg" alt="After — Photo Restoration">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-5-5.jpg" alt="Before — Photo Restoration">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-6-3.jpg" alt="After — Photo Restoration">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                    <div class="ba-slider" aria-label="Before and after comparison">
                        <div class="ba-before">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-1-21.jpg" alt="Before — Photo Restoration">
                            <span class="ba-label ba-label-before">Before</span>
                        </div>
                        <div class="ba-after">
                            <img src="https://graphicspixels.com/wp-content/uploads/2026/07/graphics-pixels-1-5.png" alt="After — Photo Restoration">
                            <span class="ba-label ba-label-after">After</span>
                        </div>
                        <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── AI-GENERATED IMAGE FIXES ── -->
        <section class="pf-service">
            <div class="container">
                <div class="pf-service-head">
                    <div class="pf-service-head-text">
                        <span class="section-tag">Portfolio</span>
                        <h2 class="pf-service-title">AI-generated Image Fixes</h2>
                    </div>
                    <a href="<?php echo esc_url( home_url('/ai-generated-image-fixes/') ); ?>" class="pf-service-link">View Service <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="pf-grid pf-grid-3 reveal" data-reveal="up">
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/11-ai-generated-image-services/1.-Graphics-Pixels-1024x559.jpg" alt="AI-generated Image Fix — Example 1" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/11-ai-generated-image-services/2.-Graphics-Pixels-1024x559.jpg" alt="AI-generated Image Fix — Example 2" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                    <div class="svc-img" style="border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;background:#f4f4f8;">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/11-ai-generated-image-services/3.-Graphics-Pixels-1024x559.jpg" alt="AI-generated Image Fix — Example 3" style="width:100%;height:100%;object-fit:contain;padding:8px;">
                    </div>
                </div>
            </div>
        </section>

    </div><!-- /#portfolio -->

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

    <!-- ============ FOOTER ============ -->

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

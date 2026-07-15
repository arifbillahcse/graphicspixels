<?php /* Template Name: Image Masking Service */ ?>
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
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Image Masking service/graphics-pixels-10.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Image Masking service/graphics-pixels-10.png');
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
                <span class="ds-showcase-eyebrow">Photo Editing</span>
                <h2>Professional Image Masking Service — Hair, Fur, Transparent Objects &amp; Complex Edges</h2>
                <p class="ds-lead">Clipping path draws a hard vector outline around a subject. It works on products with clean, defined edges. It does not work on hair, fur, sheer fabric, fine mesh, glass, water, or any subject where the edge blends softly into the background. Image masking is the correct technique for those cases.</p>
                <p>Graphics Pixels provides layer masking, alpha channel masking, hair and fur masking, transparent object masking, and refine edge masking — all done by hand in Photoshop. The result is a clean, natural-edged cutout that holds up on any background, in any format, at any size.</p>
                <p>Pricing from $0.75/image. 24-hour turnaround. Free trial on every new order.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS IMAGE MASKING ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">When Clipping Path Is Not Enough</h2>
                    <p>Clipping path draws a precise vector outline around a subject. It is the correct technique for hard-edged products with clean, defined boundaries. But it does not work on hair, fur, sheer fabric, fine mesh, smoke, glass, or any subject where the edge blends gradually into the background — because a hard path cuts away the soft detail that makes those subjects look natural.</p>
                    <p>Image masking is the correct technique for those cases. At Graphics Pixels, we provide layer masking, alpha channel masking, hair and fur masking, transparent object masking, and refine edge masking — all executed by hand in Photoshop. The result is a clean, natural-edged cutout that holds up on any background, at any size, in any format.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/1.%20Layer%20Masking/graphics%20pixels%20(1).jpg" alt="Image Masking Service — Hair and Soft Edge" loading="lazy">
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
                <h2 class="section-title">Before &amp; After Image Masking Results</h2>
                <p class="section-desc">Watch how fine hair strands, soft edges, and transparent surfaces are isolated without losing detail — and how the result sits naturally on any new background.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/-VUy_vWbYJs"
                        title="Professional Image Masking Process"
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
                <h2 class="section-title">Our Image Masking Services</h2>
                <p class="section-desc">Five masking techniques, each matched to a specific subject type and edge challenge. We assess your images and use the correct method — you don't need to specify which technique is needed.</p>
            </div>

            <div class="svc-list">

                <!-- 1. Layer Masking -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/1.%20Layer%20Masking/graphics%20pixels%20(1).jpg" alt="Layer Masking Service" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-layer-group"></i></span>
                        <h3>Layer Masking</h3>
                        <p>Layer masking conceals or reveals parts of a layer using a greyscale mask rather than permanently deleting pixels. The original image data stays intact. The mask can be refined, adjusted, or removed at any stage without re-editing from scratch — critical for images that need rework or multiple output variants. Most commonly used for portrait and beauty work where soft, natural edges around hair are required. Pricing from $0.75/image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Non-destructive — original pixels preserved</li>
                            <li><i class="fas fa-check"></i> Mask adjustable at any stage</li>
                            <li><i class="fas fa-check"></i> Natural soft edges around hair &amp; skin</li>
                            <li><i class="fas fa-check"></i> Used by portrait &amp; beauty photographers</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Alpha Channel Masking -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/2.%20ALPHA%20CHANNEL%20MASKING/graphics-pixels-After-1-4.jpg" alt="Before — Alpha Channel Masking">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/2.%20ALPHA%20CHANNEL%20MASKING/graphics-pixels-Before-1-5.jpg" alt="After — Alpha Channel Masking">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-circle-half-stroke"></i></span>
                        <h3>Alpha Channel Masking</h3>
                        <p>Alpha channel masking stores a precise selection of the subject including its transparency values. Unlike a clipping path, the alpha channel records semi-transparent edges — making it the correct method for glass, water, smoke, sheer or translucent fabric, and any subject with partial transparency. Delivered as PNG or layered PSD with the alpha channel preserved, allowing further post-processing without affecting the background. Pricing from $0.99/image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Preserves partial transparency &amp; semi-transparent edges</li>
                            <li><i class="fas fa-check"></i> Ideal for glass, water, smoke &amp; sheer fabric</li>
                            <li><i class="fas fa-check"></i> PNG or layered PSD with alpha preserved</li>
                            <li><i class="fas fa-check"></i> Further post-processing without affecting bg</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Transparent Object Masking -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/3.%20TRANSPARENT%20OBJECT%20MASKING/graphics-pixels-After-2-5.jpg" alt="Before — Transparent Object Masking">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/3.%20TRANSPARENT%20OBJECT%20MASKING/graphics-pixels-Before-2-5.jpg" alt="After — Transparent Object Masking">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-droplet"></i></span>
                        <h3>Transparent Object Masking</h3>
                        <p>Transparent object masking isolates glass bottles, glassware, ceramics, ice, clear plastic, and any product with partial transparency. A pen tool path cuts away the background but also destroys the refractive qualities and light refraction that are part of the product's appearance. Our masking technique preserves the transparency, internal reflections, and depth so a glass bottle still looks like glass — not a flat cutout. Used by cosmetics, fragrance, beverage, and interior product brands. Pricing from $2.49/image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Preserves internal reflections &amp; light refraction</li>
                            <li><i class="fas fa-check"></i> Glass, glassware, ice &amp; clear plastic</li>
                            <li><i class="fas fa-check"></i> Used by fragrance, cosmetics &amp; beverage brands</li>
                            <li><i class="fas fa-check"></i> Product still looks like glass, not a flat shape</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Refine Edge Masking -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/4.%20REFINE%20EDGE%20MASKING/graphics-pixels-After-3-6.jpg" alt="Before — Refine Edge Masking">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/4.%20REFINE%20EDGE%20MASKING/graphics-pixels-Before-3-5.jpg" alt="After — Refine Edge Masking">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-wand-magic-sparkles"></i></span>
                        <h3>Refine Edge Masking</h3>
                        <p>Refine Edge masking — also called Refine Mask in newer Photoshop versions — analyses the boundary between subject and background at the pixel level and rebuilds the selection with the fine detail that manual selection misses. Used for flyaway hair against complex or busy backgrounds, animal fur with individual strands, fine lace and knitwear edges, feathers and plant foliage, and any subject where standard selection tools produce rough, jagged edges. Pricing from $1.49/image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Pixel-level edge reconstruction</li>
                            <li><i class="fas fa-check"></i> Flyaway hair, fine lace &amp; feather edges</li>
                            <li><i class="fas fa-check"></i> Works against complex or patterned backgrounds</li>
                            <li><i class="fas fa-check"></i> No jagged or rough edge artefacts</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Hair & Fur Masking -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" aria-label="Before and after comparison">
                            <div class="ba-before">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/5.%20Hair%20%26%20Fur%20Masking/graphics%20pixels%20(2).jpg" alt="Before — Hair and Fur Masking">
                            </div>
                            <div class="ba-after">
                                <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/8.%20image-masking-service/5.%20Hair%20%26%20Fur%20Masking/graphics%20pixels%20(1).jpg" alt="After — Hair and Fur Masking">
                            </div>
                            <div class="ba-divider"><button class="ba-handle" aria-hidden="true"><i class="fas fa-arrows-left-right"></i></button></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-eye"></i></span>
                        <h3>Hair &amp; Fur Masking</h3>
                        <p>The most detailed masking work we do. Used for portrait and fashion photography with complex or flyaway hair, beauty campaigns, animal photography, and product photography with fur or textile textures. Every strand that matters is retained. The transition between hair and background is rebuilt at the pixel level so the result looks natural on any new background — no halo, no hard edge, no missing strands. Brightness, colour, and texture adjustments applied to the isolated subject where needed. Pricing from $1.20/image.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Every individual strand retained</li>
                            <li><i class="fas fa-check"></i> No halo, no hard edge cut</li>
                            <li><i class="fas fa-check"></i> Natural on any replacement background</li>
                            <li><i class="fas fa-check"></i> Portrait, fashion, beauty &amp; animal photography</li>
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
                        <p>Describe the subject and output you need — background colour, format, intended platform. We'll select the correct masking technique automatically.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-3"><i class="fas fa-magic"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>We Deliver Results</h3>
                        <p>Your masked images are returned within 24 hours — clean edges, natural transitions, ready for any background.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-4"><i class="fas fa-check-double"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Revisions Until Perfect</h3>
                        <p>Request refinements anytime. Unlimited revisions until every edge and transition matches your exact requirement.</p>
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

                </div>

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
            </div>

            <div class="vt-right reveal" data-reveal="right">
                <div class="vt-stars-top">
                    <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                </div>
                <h2 class="vt-heading">
                    What Portrait Photographers, Fashion Studios, and Product Brands Say About Our Image Masking Service
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
            </div>

        </div>

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
                <p><strong>Try Our Service Free — Results Back in 24 Hours</strong><br>Send 1 to 5 images and we return them masked to your brief within 24 hours at no charge. No payment required. No commitment to continue.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-credit-card"></i> No upfront payment — review the work before paying</li>
                    <li><i class="fas fa-images"></i> 1 to 5 images masked to your exact specification</li>
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
                    <option value="" disabled>Select The Service</option>
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option>Background Removal</option>
                    <option>Color Correction</option>
                    <option>Drop Shadow</option>
                    <option selected>Image Masking</option>
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
                    <div class="faq-a"><p>Clipping path uses the pen tool to draw a hard vector outline — correct for products with clean, defined edges like shoes and electronics. Image masking is for subjects with soft, complex, or transparent edges — hair, fur, glass, sheer fabric — where a hard path would cut away detail that needs to be preserved.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How do I know which masking technique I need? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>You don't need to specify. Send your images and a description of the output you need — we assess each image and apply the correct technique automatically. Layer masking for portraits, alpha channel for glass and transparency, refine edge for complex hair, and so on.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can you mask hair against a busy or patterned background? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Refine Edge masking analyses the boundary at pixel level and works effectively even against complex or patterned backgrounds. Busy backgrounds are more time-intensive and reflected in the turnaround time, but the technique handles them.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can you preserve glass transparency when removing the background? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — using transparent object masking and alpha channel masking. The technique preserves the transparency, internal reflections, and refractive qualities so a glass bottle still looks like glass on the new background, not a flat shape.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What formats do you deliver masked images in? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>PNG with transparent background, layered PSD with alpha channel preserved, or flattened JPEG on a colour background. Specify your format and platform requirements in the brief and we'll prepare accordingly.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is the free trial really free? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Send 1–5 images with a brief and we'll return them masked within 24 hours — no charge, no obligation. Use the trial to verify the edge quality and natural finish before committing to a paid batch.</p></div>
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

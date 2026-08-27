<?php /* Template Name: Headshot Photo Editing */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Headshot photo editing/graphics-pixels-4.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/Headshot photo editing/graphics-pixels-4.png');
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
        .hs-intro {
            padding-top: 40px !important;
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Headshot Photo Editing</span>
                <h2>Professional Headshot Photo Editing Service — Natural Retouching for Portraits &amp; Profiles</h2>
                <p class="ds-lead">Professional headshot retouching for photographers, studios, and individuals — skin tone correction, blemish removal, flyaway hair cleanup, teeth whitening, eye enhancement, and background replacement.</p>
                <p>All done by hand in Photoshop, never AI filters, so results look polished rather than over-processed. From $5, 24–48 hour turnaround, free trial.</p>

                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS HEADSHOT EDITING ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">What Is Professional Headshot Editing?</h2>
                    <p>A professional headshot is often your first impression — on LinkedIn, a company website, a casting portfolio, or a professional profile. The editing should be invisible: the subject looks like themselves on a good day, not over-processed or artificially smoothed.</p>
                    <p>We edit headshots by hand in Photoshop. Skin is corrected for tone and texture, blemishes and shine are reduced, eyes are enhanced and brightened, teeth are whitened, flyaway hair is cleaned up, lighting is balanced, and backgrounds are cleaned or replaced. The result looks polished and credible. 24–48 hour turnaround. From $5 per image. Bulk rates for photographers and studios.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="https://graphicspixels.com/wp-content/uploads/2026/07/headshot.jpg" alt="Professional Headshot Photo Editing" loading="lazy">
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
                <h2 class="section-title">Watch Professional Headshot Retouching</h2>
                <p class="section-desc">See how we correct skin tone, remove blemishes, enhance eyes, balance lighting, and polish headshots without making them look over-processed or unnatural.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="pe-video-container">
                    <iframe
                        width="100%"
                        height="600"
                        src="https://www.youtube.com/embed/zfa4qMLbmzY"
                        title="Professional Headshot Editing Process"
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
                <h2 class="section-title">Our Headshot Editing Services</h2>
                <p class="section-desc">From light retouching of naturally good headshots to full editing of heavily shadowed or poorly lit portraits — we deliver polished, professional results across all headshot types and lighting conditions.</p>
            </div>

            <div class="svc-list">

                <!-- 1. Skin Tone & Texture -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/1.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results/graphics%20pixels%20(1).jpg" alt="Skin Tone and Texture Correction" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-wand-magic-sparkles"></i></span>
                        <h3>Skin Tone &amp; Texture Correction</h3>
                        <p>Uneven skin tone, colour casts from studio lighting, and texture problems are corrected using curves, selective colour, and the healing brush. Skin is smoothed without removing texture or detail — the result looks natural, not plastic. Redness and discolouration are neutralised, creating an even, professional canvas.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Colour casts and redness neutralised</li>
                            <li><i class="fas fa-check"></i> Skin tone evened across face</li>
                            <li><i class="fas fa-check"></i> Texture smoothed without loss of detail</li>
                            <li><i class="fas fa-check"></i> Natural, credible finish</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Blemish & Shine Removal -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/2.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy/graphics%20pixels%20(1).jpg" alt="Blemish and Shine Removal" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-circle-check"></i></span>
                        <h3>Blemish, Acne &amp; Shine Removal</h3>
                        <p>Blemishes, breakouts, acne scars, and oily shine are removed using the healing brush and clone stamp. The removal is invisible — surrounding skin texture is matched so the correction doesn't stand out. Shine from forehead, nose, and cheeks is reduced while maintaining natural skin light and luminosity.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Blemishes and breakouts removed</li>
                            <li><i class="fas fa-check"></i> Acne scars softened and blended</li>
                            <li><i class="fas fa-check"></i> Oily shine reduced naturally</li>
                            <li><i class="fas fa-check"></i> Invisible corrections with matched texture</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Eye & Teeth Enhancement -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/3.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20(4)/graphics%20pixels%20(1).jpg" alt="Eye and Teeth Enhancement" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-star"></i></span>
                        <h3>Eye &amp; Tooth Enhancement</h3>
                        <p>Eyes are brightened and whites are clarified using selective sharpening and curve adjustments. Shadows under eyes are reduced. Teeth are whitened subtly without looking artificially bright — the goal is natural-looking brightness, not dental veneers. Pupil detail and catchlights are enhanced to make the subject look more engaged and alive.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Eyes brightened and sharpened</li>
                            <li><i class="fas fa-check"></i> Under-eye shadows softened</li>
                            <li><i class="fas fa-check"></i> Teeth whitened naturally</li>
                            <li><i class="fas fa-check"></i> Catchlights and pupil detail enhanced</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Hair & Background Cleanup -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/4.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20(3)/graphics%20pixels%20(1).jpg" alt="Hair and Background Cleanup" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-image"></i></span>
                        <h3>Hair &amp; Background Cleanup</h3>
                        <p>Flyaway hairs and stray strands are cleaned up using the clone stamp and healing brush. Hair edges are refined against the background. Backgrounds are cleaned of distracting elements, or completely removed and replaced with a solid colour or professional backdrop. Lighting and shadows are balanced to create depth and separation.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Flyaway and stray hair removed</li>
                            <li><i class="fas fa-check"></i> Hair edges refined and sharpened</li>
                            <li><i class="fas fa-check"></i> Background cleaned or replaced</li>
                            <li><i class="fas fa-check"></i> Subject separated from background</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Lighting & Color Balance -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/4.%20headshot-photo-editing/5.%20Headshot%20Editing%20Prior%20to%20and%20Following%20Results%20-%20Copy%20(2)/graphics%20pixels%20(1).jpg" alt="Lighting and Color Balance" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-sun"></i></span>
                        <h3>Lighting &amp; Color Balance</h3>
                        <p>Harsh shadows are softened, dark areas under the eyes and jaw are lifted, and overall lighting is balanced for a flattering, even look. Colour casts from studio lights are neutralised. The result reads as well-lit and professional, whether shot in natural light, studio conditions, or mixed lighting. Exposure is adjusted globally and selectively as needed.</p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Harsh shadows softened</li>
                            <li><i class="fas fa-check"></i> Dark areas lifted and brightened</li>
                            <li><i class="fas fa-check"></i> Colour cast eliminated</li>
                            <li><i class="fas fa-check"></i> Even, professional lighting</li>
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
                <p class="section-desc">Send your headshots, choose a package, and we'll return them polished within 24–48 hours.</p>
            </div>

            <div class="how-timeline reveal" data-reveal="up" data-delay="100">
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-1"><i class="fas fa-folder-open"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Upload Your Headshots</h3>
                        <p>Send 1 or more headshot images via the form or cloud link. JPG, PNG, PSD, and TIFF formats accepted.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-2"><i class="fas fa-pen-to-square"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Choose Package or Send Reference</h3>
                        <p>Select Basic, Standard, or Pro editing package. Or send a reference headshot showing the standard you want us to match.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-3"><i class="fas fa-magic"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Professional Retouching</h3>
                        <p>Your headshots are edited by hand in Photoshop. Typically completed within 24–48 hours depending on image volume.</p>
                    </div>
                </div>
                <div class="how-arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></div>
                <div class="how-item">
                    <div class="how-circle">
                        <div class="how-icon-bg how-step-4"><i class="fas fa-check-double"></i></div>
                    </div>
                    <div class="how-content">
                        <h3>Review &amp; Download</h3>
                        <p>Receive your edited headshots ready to use on LinkedIn, your website, or print. Revisions included if any adjustments are needed.</p>
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
                    What Photographers, Job Seekers, and Corporate Professionals Say About Our Headshot Editing Service
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
                <p><strong>Send a Headshot — We'll Edit It Free</strong><br>Send 1 to 5 headshot images and we'll return them edited within 24 hours at no charge. No payment required. Review the quality before committing to a larger order.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-credit-card"></i> No upfront payment — review the work before paying</li>
                    <li><i class="fas fa-images"></i> 1 to 5 headshots edited at full quality</li>
                    <li><i class="fas fa-clock"></i> Results returned within 24 hours</li>
                    <li><i class="fas fa-rotate"></i> Unlimited revisions until you are satisfied</li>
                    <li><i class="fas fa-lock"></i> Your files are confidential and secure</li>
                    <li><i class="fas fa-tag"></i> Bulk rates for photographers and studios</li>
                    <li><i class="fas fa-handshake"></i> Dedicated account manager for regular orders</li>
                </ul>
            </div>
            <form class="free-trial-form reveal" data-reveal="right" id="trial-form">
                <div class="form-row">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Add Email*" required>
                </div>
                <div class="form-row">
                    <?php gp_render_phone_field(); ?>
                    <input type="url" placeholder="Website*" required>
                </div>
                <select required>
                    <option value="" disabled>Select The Service</option>
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option>Background Removal</option>
                    <option>Color Correction</option>
                    <option>Drop Shadow</option>
                    <option>Image Masking</option>
                    <option>E-commerce Image Editing</option>
                    <option>Photo Restoration</option>
                    <option selected>Headshot Photo Editing</option>
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
                    <button class="faq-q">Will I still look like myself after editing? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We correct and enhance — we do not alter. Skin is smoothed, blemishes are removed, and lighting is balanced. The result looks like you on a professional photo shoot, not a different person.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I use the edited headshot on LinkedIn and my website? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Edited headshots are yours to use anywhere — LinkedIn, company websites, casting portfolios, print materials, social media, and professional profiles without restriction.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How many revisions do I get? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Unlimited revisions on all paid orders. If the editing doesn't match your brief, we adjust until you are satisfied — at no extra charge.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How fast is the turnaround? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Standard turnaround is 24–48 hours. Single headshots are typically completed within 24 hours. Larger batches may take up to 48 hours depending on volume and complexity.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you handle bulk headshot batches for photographers? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Photographers with regular headshot session volume get bulk pricing and a dedicated workflow. Contact us with your typical batch size and turnaround needs for a custom quote.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What file formats do you deliver? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Edited headshots are delivered in the format you need — JPG for web and social media, PNG for transparency, or TIFF for printing. Specify your preference when ordering.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is there a free trial? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Send 1–5 headshots and we'll return them edited within 24 hours at no charge. It's a risk-free way to verify quality and see our standard before ordering a larger batch.</p></div>
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

<?php get_footer(); ?>

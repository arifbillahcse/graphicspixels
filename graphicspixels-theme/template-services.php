<?php /* Template Name: Services */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/graphics-pixels (1).png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/graphics-pixels (1).png');
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

<!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">SERVICES</span>
                <h2>Professional Photo Editing &amp; Retouching Services</h2>
                <p class="ds-lead">A dedicated photo editing and post-production studio handling clipping path, background removal, ghost mannequin, retouching, colour correction, masking, shadows, restoration, 3D modeling, and video editing — all under one roof.</p>
                <p>From 10 images to 10,000, every file goes through the same workflow and triple-layer quality check. 14+ years. Free 24-hour trial.</p>

                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TO WHOM BAND ============ -->
    <section class="svc-whom">
        <div class="container reveal" data-reveal="up">
            <h2 class="section-title" style="font-size: 28px;">To Whom We Provide Our Photo Editing Services</h2>
            <p>
                Graphics Pixels has worked with photographers, studios, retailers, and agencies across the USA,
                Europe, and the rest of the world for over 14 years. The clients who find us tend to stay — that
                track record tells you more about our work than we could. If you want to judge it yourself first,
                <a href="<?php echo esc_url( home_url('/contact/') ); ?>">request a free trial</a> and we'll send the edited files back within 24
                hours at no charge.
            </p>
        </div>
    </section>

    <!-- ============ SERVICES LIST ============ -->
    <section class="svc-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">What We Do</span>
                <h2 class="section-title">Photo Editing Services We Provide</h2>
            </div>

            <div class="svc-list">

                <!-- 1. Clipping Path (static image) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/Pricing/1.%20Clipping%20Path/graphics%20pixels%20(1).png" alt="Clipping Path Service" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-bezier-curve"></i></span>
                        <h3>Clipping Path Service</h3>
                        <p>Every path we draw is done by hand, with the pen tool, by an actual editor — no automation, no batch AI processing. We handle simple shapes, multi-part products, complex outlines, and super-complex subjects like jewelry or lacework. The subject gets cut precisely, placed on a white or transparent background, and sent back ready to use.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/clipping-path-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Photo Retouching (before/after) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" data-pos="50">
                            <img class="ba-img ba-after" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/1.%20Photo%20Retouching%20Services/graphics%20pixels%20(2).jpg" alt="After photo retouching" loading="lazy">
                            <div class="ba-before-wrap">
                                <img class="ba-img" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/1.%20Photo%20Retouching%20Services/graphics%20pixels%20(1).jpg" alt="Before photo retouching" loading="lazy">
                            </div>
                            <span class="ba-label ba-label-before">Before</span>
                            <span class="ba-label ba-label-after">After</span>
                            <div class="ba-handle"><i class="fas fa-left-right"></i></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-wand-magic-sparkles"></i></span>
                        <h3>Photo Retouching Services</h3>
                        <p>Premium-quality retouching isn't about making images look perfect — it's about making them look right. Our editors work on skin, product surfaces, lighting, and color with a light hand, fixing the problems without making the subject look unreal. Send a reference image and we'll match it. Quality checks run on every batch before anything goes out.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/photo-retouching-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Ghost Mannequin (before/after) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" data-pos="50">
                            <img class="ba-img ba-after" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/2.%20Ghost%20Mannequin%20Services/graphics%20pixels%20(2).jpg" alt="After ghost mannequin" loading="lazy">
                            <div class="ba-before-wrap">
                                <img class="ba-img" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/2.%20Ghost%20Mannequin%20Services/graphics%20pixels%20(1).jpg" alt="Before ghost mannequin" loading="lazy">
                            </div>
                            <span class="ba-label ba-label-before">Before</span>
                            <span class="ba-label ba-label-after">After</span>
                            <div class="ba-handle"><i class="fas fa-left-right"></i></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shirt"></i></span>
                        <h3>Ghost Mannequin Services</h3>
                        <p>The ghost mannequin service — also called invisible mannequin or neck joint — takes the mannequin out of the garment photo and joins the front and interior shots into one clean image. The clothing ends up with a natural three-dimensional shape, as if it's being worn, without needing a model. We handle both single pieces and large seasonal batches.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/ghost-mannequin-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Headshot (static image) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/3.%20Headshot%20Photo%20Editing%20%26%20Retouching/graphics%20pixels%20(1).jpg" alt="Headshot Photo Editing" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-user"></i></span>
                        <h3>Headshot Photo Editing &amp; Retouching</h3>
                        <p>A headshot needs to look professional without looking touched — a balance harder to get right than it sounds. Our headshot retouching hits the middle: skin correction, color grading, background cleanup, sharpness, and exposure adjusted until the image looks clean and credible. We work with photographers delivering in bulk, and individuals needing a single polished shot.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/headshot-photo-editing/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Background Removal (before/after) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" data-pos="50">
                            <img class="ba-img ba-after" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/4.%20Background%20Removal%20Services/graphics%20pixels%20(2).jpg" alt="After background removal" loading="lazy">
                            <div class="ba-before-wrap">
                                <img class="ba-img" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/4.%20Background%20Removal%20Services/graphics%20pixels%20(1).jpg" alt="Before background removal" loading="lazy">
                            </div>
                            <span class="ba-label ba-label-before">Before</span>
                            <span class="ba-label ba-label-after">After</span>
                            <div class="ba-handle"><i class="fas fa-left-right"></i></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-eraser"></i></span>
                        <h3>Background Removal Services</h3>
                        <p>Background removal at volume is where corners get cut if the team isn't set up for it. Ours is. We process large batches with hand-edited paths and masking, not automated tools, so edges stay clean on products with fine detail, transparent materials, or complex outlines — matched to platform specs for Amazon, Shopify, eBay, and others. Bulk orders get discounted rates.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/background-removal-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 6. Color Correction (before/after) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" data-pos="50">
                            <img class="ba-img ba-after" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/5.%20Color%20Correction%20Services/graphics%20pixels%20(2).jpg" alt="After color correction" loading="lazy">
                            <div class="ba-before-wrap">
                                <img class="ba-img" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/5.%20Color%20Correction%20Services/graphics%20pixels%20(1).jpg" alt="Before color correction" loading="lazy">
                            </div>
                            <span class="ba-label ba-label-before">Before</span>
                            <span class="ba-label ba-label-after">After</span>
                            <div class="ba-handle"><i class="fas fa-left-right"></i></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-palette"></i></span>
                        <h3>Color Correction Services</h3>
                        <p>Color problems in product photography are common and costly to ignore. A garment that photographs with a blue cast looks different from the actual product, and returns follow. We cover white balance, exposure, contrast, hue, and saturation — adjusted image by image. We also handle full color changes: showing a product in multiple colorways from a single shoot.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/color-correction-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 7. Drop Shadow (static image) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/individualservicepage/7.%20drop-shadow-service/2.%20Drop%20Shadow%20Services%20for%20Realistic%20Product%20Photos/graphics%20pixels%20(1).jpg" alt="Drop Shadow Services" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-clone"></i></span>
                        <h3>Drop Shadow Services</h3>
                        <p>A product sitting on a plain background with no shadow looks unconvincing — there's no weight to it. Adding the right drop shadow, whether natural, cast, or reflection, grounds the product and makes the image feel real. We build each shadow in Photoshop to match the actual lighting and style of the image, not a generic preset dropped on top.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/drop-shadow-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 8. Image Masking (static image) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/6.%20Image%20Masking%20Services/graphics%20pixels%20(1).jpg" alt="Image Masking Services" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-layer-group"></i></span>
                        <h3>Image Masking Services</h3>
                        <p>Clipping path works on products with hard, clean edges. Hair, fur, soft fabric, sheer materials, and fine strands need a different technique. Our image masking uses layer masking, channel masking, and refine edge in Photoshop to separate those subjects cleanly — keeping the soft detail a hard path would cut away. The result is a cutout that looks natural rather than carved.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/image-masking-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 9. Ecommerce Image Editing (static image) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/7.%20Ecommerce%20Image%20Editing%20Services/graphics%20pixels%20(1).jpg" alt="Ecommerce Image Editing" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-cart-shopping"></i></span>
                        <h3>Ecommerce Image Editing Services</h3>
                        <p>Product images for e-commerce need to meet platform requirements, match brand standards, and turn around fast enough to keep up with stock updates. We handle the full post-production run — clipping path, background removal, color correction, shadow work, and retouching — prepared to spec for Amazon, Shopify, eBay, Etsy, and others. Pricing scales down as batch size goes up.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/ecommerce-image-editing-services/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 10. Photo Restoration (before/after) -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="ba-slider" data-pos="50">
                            <img class="ba-img ba-after" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/8.%20Photo%20Restoration%20Service/graphics%20pixels%20(2).png" alt="After photo restoration" loading="lazy">
                            <div class="ba-before-wrap">
                                <img class="ba-img" src="<?php echo esc_url( gp_media_base() ); ?>/images/servicespage/8.%20Photo%20Restoration%20Service/graphics%20pixels%20(1).png" alt="Before photo restoration" loading="lazy">
                            </div>
                            <span class="ba-label ba-label-before">Before</span>
                            <span class="ba-label ba-label-after">After</span>
                            <div class="ba-handle"><i class="fas fa-left-right"></i></div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-clock-rotate-left"></i></span>
                        <h3>Photo Restoration Service</h3>
                        <p>Old photographs don't age well — colors shift, surfaces crack, stains spread, and detail disappears. Our restoration goes through each image systematically: scratches, creases, tears, mold, dust, fading, and color drift addressed individually. Where sections are missing, we reconstruct them. The goal is an image that looks like it was always in good condition, not one that looks restored.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/photo-restoration-service/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 11. AI-generated Image Fixes (static image) -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="svc-img">
                            <img src="<?php echo esc_url( gp_media_base() ); ?>/images/Pricing/6.%20Photo%20Retouching/graphics%20pixels%20(1).jpg" alt="AI-generated Image Fixes" loading="lazy">
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-robot"></i></span>
                        <h3>AI-generated Image Fixes</h3>
                        <p>AI-generated images save time on ideation but often fall short on execution — extra fingers, broken anatomy, warped text, inconsistent lighting, and unnatural skin texture appear even in well-prompted outputs. Our editors go into the specific problem areas in Photoshop and fix them directly, leaving the rest intact, so you get a usable, polished visual without restarting the generation.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/ai-generated-image-fixes/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ============ FREE TRIAL ============ -->
    <section class="free-trial" id="free-trial">
        <div class="container free-trial-container">
            <div class="free-trial-info reveal" data-reveal="left">
                <span class="section-tag light">Get Started</span>
                <h2 class="section-title light">With the FREE TRIAL</h2>
                <p>Complete the form, upload your images, and get your free trial project done in 1 hour.</p>
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
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option>Headshot Editing</option>
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
                    <button class="faq-q">Which file kinds do you take? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We accept all common formats — JPEG, PNG, TIFF, PSD, RAW, and more. If you have a specific format requirement, just let us know in your brief.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How long does it take you to turn around? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Depending on order size, 6 to 24 hours. For urgent work, we offer a fastest-delivery package.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">May I ask for changes? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Absolutely. We offer unlimited revisions until the result matches your brief exactly.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Will large orders receive discounts? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — our pricing scales down as batch size goes up, and recurring clients get the best rates.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is there a trial free of charge? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Send 1–5 images with a brief and we'll return the finished files within 24 hours — no charge, no obligation.</p></div>
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

    <!-- ============ SERVICES IMAGE LIGHTBOX ============ -->
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

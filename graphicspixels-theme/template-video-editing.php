<?php /* Template Name: Video Editing */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/5__Video-Editing-service.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/5__Video-Editing-service.png');
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
                <span class="ds-showcase-eyebrow">Post-Production</span>
                <h2>Professional Video Editing Service — Product, Fashion, Real Estate &amp; Beauty</h2>
                <p class="ds-lead">Post-Production for E-commerce Brands, Videographers, Agencies &amp; Content Creators</p>
                <p>Graphics Pixels provides professional video editing for product demos, e-commerce ads, fashion reels, real estate walkthroughs, beauty and skin retouching, cinematic color grading, motion graphics, and audio post-production. All editing is done by hand by our in-house team — no automated AI filters applied to your footage.</p>
                <p>Send us your raw footage and a brief. We return the edited video within 24–48 hours. Bulk projects handled at scalable capacity. Free trial on every new order.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS VIDEO EDITING ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">Professional Video Editing</h2>
                    <p>Raw footage doesn't sell — finished video does. Our editors transform your raw clips into polished, on-brand content that drives engagement and sales. Every frame is edited by hand: color grading, transitions, motion graphics, and audio sync all in-house.</p>
                    <p>We serve e-commerce brands, fashion labels, real estate developers, agencies, and content creators. 30-second product demos, cinematic walkthroughs, full beauty campaigns — we match your brief exactly and deliver within 24–48 hours.</p>
                    <p>No AI batch processing. No automated filters. Every edit is crafted by a specialist. Send us footage and a brief, and we handle the rest.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="svc-img">
                        <img src="https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?auto=format&fit=crop&w=800&q=80" alt="Professional Video Editing" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ VIDEO SHOWCASE ============ -->
    <section class="svc-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Our Services</span>
                <h2 class="section-title">Video Editing Services</h2>
                <p class="section-desc">From product demos to cinematic real estate, from beauty retouching to social content — we edit across all formats and industries. Every project goes through multi-layer QC for broadcast quality.</p>
            </div>

            <div class="svc-list">

                <!-- 1. E-commerce Product Videos -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://youtu.be/_355dopcByM?si=7ryZfuwPlD3jUWpD')">
                            <img src="https://img.youtube.com/vi/_355dopcByM/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-cart-shopping"></i></span>
                        <h3>Fashion and Accessory Highlights</h3>
                        <p>You should pay attention to your clothes and accessories. I employ new methods like the ghost mannequin effect to make clothes look expensive and professional. I also show off stylish items like handbags in a clear and focused way.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Beauty & Portrait Video Retouching -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/shorts/XWU11Nj9W8E')">
                            <img src="https://img.youtube.com/vi/XWU11Nj9W8E/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-face-smile"></i></span>
                        <h3>3D Product Motion Graphics</h3>
                        <p>I use 3D motion graphics that give your products depth, width, and height to make them stand out. This method provides a realistic, moving effect that works great for electronics, cosmetics, or any other product that looks better when you show it off in detail.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Real Estate Walkthroughs -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/shorts/Gqxbk4H2ErM')">
                            <img src="https://img.youtube.com/vi/Gqxbk4H2ErM/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-home"></i></span>
                        <h3>Show Off Your Shoes</h3>
                        <p>Shoes are more than just objects you wear; they tell people something about you. I make videos of shoes that show off their style, texture, and comfort as they're moving. This makes them more appealing to customers.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Cinematic Color Grading -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=fcMT6-glbjk')">
                            <img src="https://img.youtube.com/vi/fcMT6-glbjk/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-palette"></i></span>
                        <h3>High-End Real Estate Video Editing for Marketing | Cinematic Property Showcase</h3>
                        <p>In this video, we show professional Real Estate Video Editing technique to make your property visuals more cinematic, clean, and premium.</p>
                        <p>Learn how to enhance real estate footage, improve color grading, add smooth transitions, and create engaging property showcase videos that boost marketing results.</p>
                        <p>Perfect for real estate agents, property marketers, and video editors.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Motion Graphics & Titles -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=87YBqSdqLEU')">
                            <img src="https://img.youtube.com/vi/87YBqSdqLEU/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-wand-magic-sparkles"></i></span>
                        <h3>Interior Video Editing Service | Cinematic Home &amp; Office Showcase Editing</h3>
                        <p>Looking for premium interior video editing that makes spaces look elegant and luxurious?</p>
                        <p>We provide professional Interior Video Editing Service for homes, offices, and commercial spaces. Our editing style focuses on cinematic visuals, smooth transitions, perfect color grading, and premium presentation that enhances the beauty of every space.</p>
                        <p>This service is perfect for interior designers, real estate agents, architects, and property marketing agencies who want to attract more clients with high-quality visuals. We turn simple interior footage into visually stunning and engaging showcase videos.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 6. Fashion & Accessory Edits -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=FMLa79NEBOU')">
                            <img src="https://img.youtube.com/vi/FMLa79NEBOU/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shirt"></i></span>
                        <h3>High-End Skin Color Video Editing Services | Professional Beauty Retouch &amp; Smooth Skin Editing</h3>
                        <p>Looking for flawless and natural-looking skin in your videos?</p>
                        <p>We provide professional Skin Video Editing Services that enhance beauty while keeping a natural and realistic look. Our editing focuses on smooth retouching, blemish removal, color correction, and cinematic beauty enhancement for high-end results.</p>
                        <p>This service is perfect for beauty brands, makeup artists, influencers, fashion shoots, and skincare advertisements who want premium-quality visuals that attract attention and build trust. We make your visuals clean, elegant, and production-ready for social media and marketing campaigns.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 7. Audio Post-Production -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=SbVWFLV-KY4')">
                            <img src="https://img.youtube.com/vi/SbVWFLV-KY4/hqdefault.jpg" alt="Video Editing" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-headphones"></i></span>
                        <h3>Product Video Editing | Professional Product Showcase Video Tutorial</h3>
                        <p>Want to make your products look premium and increase sales with powerful visuals?</p>
                        <p>In this video, we show professional Product Video Editing techniques to create high-quality, cinematic product showcase videos for brands and e-commerce businesses.</p>
                        <p>You will learn how to enhance product footage, improve lighting, color grading, smooth transitions, and create engaging ads that grab customer attention instantly.</p>
                        <p>Perfect for e-commerce brands, drop shipping stores, and product marketers.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
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
                <p>Upload your raw footage and editing brief. Get your first cut back within 24 hours.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-globe"></i> Global service</li>
                    <li><i class="fas fa-bolt"></i> 24–48 hr turnaround</li>
                    <li><i class="fas fa-rotate"></i> Unlimited revisions</li>
                    <li><i class="fas fa-face-smile"></i> 100% client satisfaction</li>
                    <li><i class="fas fa-microchip"></i> No AI filters</li>
                    <li><i class="fas fa-cart-shopping"></i> Scalable capacity</li>
                    <li><i class="fas fa-gem"></i> Broadcast quality</li>
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
                    <option>E-commerce Product Videos</option>
                    <option>Beauty &amp; Skin Retouching</option>
                    <option>Real Estate Walkthroughs</option>
                    <option>Cinematic Color Grading</option>
                    <option>Motion Graphics &amp; Titles</option>
                    <option>Fashion &amp; Accessory Reels</option>
                    <option>Audio Post-Production</option>
                </select>
                <textarea placeholder="Your message" rows="3"></textarea>
                <div class="file-upload">
                    <label for="file-input"><i class="fas fa-cloud-arrow-up"></i> Choose a file</label>
                    <input type="file" id="file-input">
                    <span class="file-name">No file chosen</span>
                </div>
                <p class="upload-note">If the size is more than 100 MB, share via cloud (Google Drive, Dropbox, or WeTransfer).</p>
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
                    <button class="faq-q">What video formats do you accept? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We work with all major formats: MOV, MP4, AVI, MXF, and RAW camera footage (RED, ARRI, Blackmagic, etc.). Upload or send via cloud if file is large.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What is your typical turnaround time? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Standard turnaround is 24–48 hours depending on complexity and scope. Faster delivery available for urgent orders.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you handle bulk video editing? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We scale to handle 10 clips or 1,000+. Dedicated teams available for agencies with ongoing volume. Quality stays consistent across all projects.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I request revisions? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — unlimited revisions within project scope until the final deliverable matches your brief exactly.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What delivery formats do you provide? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We deliver in your required format (MP4, MOV, WebM, etc.) optimized for your platform (YouTube, TikTok, Instagram, Shopify, Amazon, etc.). Multiple codec and resolution options available.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is my raw footage secure? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. All footage and unreleased content are handled under NDA on secure, encrypted servers. We never share or repurpose your raw files.</p></div>
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

    <!-- ============ VIDEO MODAL ============ -->
    <div class="video-modal" id="videoModal" role="dialog" aria-modal="true" aria-label="Video player">
        <div class="video-modal-backdrop" id="videoBackdrop"></div>
        <div class="video-modal-container">
            <button class="video-modal-close" id="videoModalClose" aria-label="Close video">
                <i class="fas fa-times"></i>
            </button>
            <div class="video-modal-content">
                <iframe id="videoIframe"
                        width="100%"
                        height="100%"
                        src=""
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <script>
        function openVideoModal(videoUrl) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            const videoId = videoUrl.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]+)/)[1];
            iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0';
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');
            modal.classList.remove('open');
            iframe.src = '';
            document.body.style.overflow = '';
        }

        document.getElementById('videoBackdrop').addEventListener('click', closeVideoModal);
        document.getElementById('videoModalClose').addEventListener('click', closeVideoModal);
        document.addEventListener('keydown', function (e) {
            const modal = document.getElementById('videoModal');
            if (e.key === 'Escape' && modal.classList.contains('open')) closeVideoModal();
        });
    </script>

<?php get_footer(); ?>

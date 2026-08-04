<?php /* Template Name: 3D Rendering Service */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/1__main-page-Copy.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/1__main-page-Copy.png');
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
        .svc-features-label {
            margin-bottom: 8px;
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">3D Rendering Service</span>
                <h2>Investigate Our Photorealistic 3D Modeling and Rendering Services</h2>
                <p class="ds-lead">In today's digital world, visuals are everything.</p>
                <p>Photorealistic 3D models and renderings boost brand presence and customer engagement across fashion, furniture, e-commerce, and architecture.</p>
                <p>At Graphics Pixels, we turn your ideas into stunning 3D depictions that captivate, entice, and sell.</p>

                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ WHAT IS 3D RENDERING ============ -->
    <section class="cp-intro">
        <div class="container">
            <div class="cp-intro-inner">
                <div class="cp-intro-text reveal" data-reveal="left">
                    <span class="section-tag">About the Service</span>
                    <h2 class="section-title">Photorealistic CGI for E-commerce and Marketing</h2>
                    <p>In today's digital world, visuals are everything. High-quality 3D rendering services and lifelike CGI will dramatically boost your brand presence and customer engagement — whether you're in fashion, furniture, e-commerce, or architecture.</p>
                    <p>At Graphics Pixels, we turn your ideas into stunning, photorealistic 3D visuals that captivate, engage, and sell. A single model renders in any colour, background, or environment — no reshooting required. Used for Amazon listings, brand campaigns, trade catalogs, and AR experiences.</p>
                    <div class="cp-intro-actions">
                        <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                        <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline">Learn More</a>
                    </div>
                </div>
                <div class="cp-intro-image reveal" data-reveal="right" data-delay="150">
                    <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=NIYPhP0y4MQ')">
                        <img src="https://img.youtube.com/vi/NIYPhP0y4MQ/hqdefault.jpg" alt="3D Rendering Example" loading="lazy" class="yt-thumb-img">
                        <div class="yt-thumb-overlay">
                            <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                        </div>
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
                <h2 class="section-title">Realistic Industrial Machine 3D CGI Rendering</h2>
                <p class="section-desc">Precision-engineered CGI renders of industrial machinery, with every bolt, gauge, and mechanical component modeled to scale. Ideal for technical catalogs, equipment marketing, and manufacturer websites.</p>
            </div>
            <div class="pe-video-wrap reveal" data-reveal="up" data-delay="100">
                <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=xp7B6b-HFnI')">
                    <img src="https://img.youtube.com/vi/xp7B6b-HFnI/hqdefault.jpg" alt="Realistic Industrial Machine 3D CGI Rendering" loading="lazy" class="yt-thumb-img">
                    <div class="yt-thumb-overlay">
                        <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ SERVICES LIST ============ -->
    <section class="svc-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Highlighted services include</span>
                <h2 class="section-title">3D Modeling Product Rendering.</h2>
            </div>

            <div class="svc-list">

                <!-- 1. Red Heels -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=NIYPhP0y4MQ')">
                            <img src="https://img.youtube.com/vi/NIYPhP0y4MQ/hqdefault.jpg" alt="Stylish Red Heels 3D Modeling and Rendering" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-shoe-prints"></i></span>
                        <h3>Stunning Stylish Red Heels 3D Modeling and Rendering Services</h3>
                        <p>Revive your stylish red heels with exceptional quality 3D modeling and providing services from graphics pixels. Our premium service offers photorealistic 3D visual elements that emphasize every complex detail of your design, from texture and color to shape and material. The use of the highest technology our qualified team ensures that each rendering meets the highest quality standards and creates not only accurate visual elements that are not only accurate but also stunning. Our 3D models and rendering are ideal for electronic business, marketing campaigns and fashion visualizations that are created to impress, increase your brand and attract their audience with a flawless representation of your stylish red heels.</p>
                        <p class="svc-features-label"><strong>Key Features:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> 3D Modeling for Stylish Red Heels</li>
                            <li><i class="fas fa-check"></i> Realistic 3D Rendering for Red Heels</li>
                            <li><i class="fas fa-check"></i> High-Quality Fashion Footwear Visualization</li>
                            <li><i class="fas fa-check"></i> E-commerce Ready 3D Shoe Renderings</li>
                            <li><i class="fas fa-check"></i> 3D Animation of Stylish Red Heels</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 2. Luggage -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=Ro786ePh6CQ')">
                            <img src="https://img.youtube.com/vi/Ro786ePh6CQ/hqdefault.jpg" alt="Realistic Luggage 3D Modeling and CGI Rendering" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-suitcase"></i></span>
                        <h3>Realistic Luggage 3D Modeling & CGI Rendering | Suitcase Product Animation & Visualization</h3>
                        <p>Key points of interest: opulent leather trim and metal accents. Applications cover fashion ads, AR experiences, and product vision.</p>
                        <p><em>Elegant bags 3D model</em></p>
                        <p>Key aspects include elegant design, quality frame elements, and reflective materials. Use cases: Ideal for augmented reality/virtual reality internet shop presentations and digital marketing initiatives.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 3. Perfume -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=050I3ilDgn8')">
                            <img src="https://img.youtube.com/vi/050I3ilDgn8/hqdefault.jpg" alt="Luxury Perfume 3D Animation and CGI Rendering" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-spray-can-sparkles"></i></span>
                        <h3>Luxury Perfume 3D Animation & CGI Rendering | High-End Product Visualization</h3>
                        <p>Our top 3D modeling and rendering tools at Graphics Pixels will help you highlight your stylish evening dresses. Our specialty is producing high-quality, photorealistic 3D images that highlight the elegance, flow, and complexity of evening wear. Our knowledgeable staff guarantees exact fabric simulation, realistic textures, and ideal lighting to bring your creations to life. From design visualization to e-commerce to fashion marketing, our top-quality 3D renderings help you stand out in the cutthroat fashion sector.</p>
                        <p class="svc-features-label"><strong>Main Characteristics:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> Evening dress: High-Quality 3D Modeling</li>
                            <li><i class="fas fa-check"></i> Photorealistic 3D Rendering for Fashion Wear Luxury Evening Gown Visualization</li>
                            <li><i class="fas fa-check"></i> Animation &amp; Virtual Fashion Show</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 4. Furniture / Handbag -->
                <article class="svc-row reverse reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=OZhPeKuWakc')">
                            <img src="https://img.youtube.com/vi/OZhPeKuWakc/hqdefault.jpg" alt="Modern Furniture 3D Modeling and Realistic CGI Rendering" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-couch"></i></span>
                        <h3>Modern Furniture 3D Modeling & Realistic CGI Rendering | Interior Product Visualization</h3>
                        <p>Outstanding 3D Rendering and Modeling Services for Chic Purses. Transform your complex purse designs into real reality using Graphics Pixels' outstanding 3D modeling and rendering services. Our staff excels in creating beautiful, photorealistic pictures highlighting the fine details, textures, and workmanship of your handbag line. Using the most sophisticated technologies and techniques, we make sure every rendering correctly reflects the beauty and appeal of your items. Designed to raise the standard of your handbags in the cutthroat fashion sector, our 3D models are perfect for e-commerce platforms, fashion companies, and designers.</p>
                        <p class="svc-features-label"><strong>Main Features:</strong></p>
                        <ul class="svc-features">
                            <li><i class="fas fa-check"></i> 3D Design of Fashionable Handbags</li>
                            <li><i class="fas fa-check"></i> Realistic Handbag Renderings</li>
                            <li><i class="fas fa-check"></i> 3D models of luxury handbags ready for e-commerce for fashion promotion</li>
                        </ul>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

                <!-- 5. Sofa -->
                <article class="svc-row reveal" data-reveal="up">
                    <div class="svc-media">
                        <div class="video-hero-thumb video-row-thumb" onclick="openVideoModal('https://www.youtube.com/watch?v=Oeq-EA3aXxY')">
                            <img src="https://img.youtube.com/vi/Oeq-EA3aXxY/hqdefault.jpg" alt="Sofa 3D Modeling Rendering Services" loading="lazy" class="yt-thumb-img">
                            <div class="yt-thumb-overlay">
                                <button class="yt-play-btn" aria-label="Play video"><i class="fas fa-play"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="svc-body">
                        <span class="svc-badge"><i class="fas fa-couch"></i></span>
                        <h3>Sofa 3D modeling rendering services</h3>
                        <p>Main points: realistic glass reflections, metal straps, and accurate dials. Great for interactive ads, high-quality brand displays, and product catalogues.</p>
                        <div class="svc-actions">
                            <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                            <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ============ WHAT MAKES US DIFFERENT ============ -->
    <section class="td-different reveal" data-reveal="up">
        <div class="container">
            <div class="section-head">
                <span class="section-tag">Why Choose Us</span>
                <h2 class="section-title">What Makes Us Different</h2>
            </div>
            <div class="td-diff-grid">
                <div class="td-diff-card reveal" data-reveal="up" data-delay="0">
                    <span class="td-diff-icon"><i class="fas fa-star"></i></span>
                    <h3>Photorealistic Quality</h3>
                    <p>Accurate lighting, realistic reflections, and natural textures — every render delivers top-tier 3D models indistinguishable from real photography.</p>
                </div>
                <div class="td-diff-card reveal" data-reveal="up" data-delay="100">
                    <span class="td-diff-icon"><i class="fas fa-sliders"></i></span>
                    <h3>Full Customisation</h3>
                    <p>Every model is custom-built for your specific project — whether for digital presentations, e-commerce platforms, or marketing campaigns.</p>
                </div>
                <div class="td-diff-card reveal" data-reveal="up" data-delay="200">
                    <span class="td-diff-icon"><i class="fas fa-briefcase"></i></span>
                    <h3>Industry Expertise</h3>
                    <p>Our team works across fashion, furniture, jewelry, electronics, real estate, and more — with deep knowledge of each sector's visual standards.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ OUR PROCESS ============ -->
    <section class="td-process">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">How It Works</span>
                <h2 class="section-title">Our 3D Rendering Process</h2>
                <p class="section-desc">A clear, four-step workflow from your brief to finished, platform-ready assets.</p>
            </div>
            <div class="td-process-grid">
                <div class="td-process-step reveal" data-reveal="up" data-delay="0">
                    <span class="td-step-num">01</span>
                    <i class="fas fa-comments td-step-icon"></i>
                    <h3>Concept Development</h3>
                    <p>We start with a thorough briefing to understand your project specifications, vision, and end-use requirements.</p>
                </div>
                <div class="td-process-step reveal" data-reveal="up" data-delay="100">
                    <span class="td-step-num">02</span>
                    <i class="fas fa-cube td-step-icon"></i>
                    <h3>3D Modeling</h3>
                    <p>Our experienced artists capture every small detail with precision, building accurate 3D geometry from your references.</p>
                </div>
                <div class="td-process-step reveal" data-reveal="up" data-delay="200">
                    <span class="td-step-num">03</span>
                    <i class="fas fa-sun td-step-icon"></i>
                    <h3>Rendering & Visualisation</h3>
                    <p>We enhance the model with naturalistic lighting, materials, and textures to create a true-to-life photorealistic result.</p>
                </div>
                <div class="td-process-step reveal" data-reveal="up" data-delay="300">
                    <span class="td-step-num">04</span>
                    <i class="fas fa-box-archive td-step-icon"></i>
                    <h3>Final Delivery</h3>
                    <p>We deliver your final assets in all common formats (OBJ, FBX, PNG, and more), ready for use across every platform.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ INDUSTRIES ============ -->
    <section class="td-industries">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Who We Serve</span>
                <h2 class="section-title">Industries We Work With</h2>
                <p class="section-desc">Our clients come from diverse sectors that rely on high-quality visual assets to sell, present, and engage.</p>
            </div>
            <div class="td-industries-grid">
                <div class="td-industry-card reveal" data-reveal="up" data-delay="0">
                    <i class="fas fa-shirt"></i>
                    <span>Fashion &amp; Apparel</span>
                </div>
                <div class="td-industry-card reveal" data-reveal="up" data-delay="60">
                    <i class="fas fa-couch"></i>
                    <span>Furniture &amp; Interiors</span>
                </div>
                <div class="td-industry-card reveal" data-reveal="up" data-delay="120">
                    <i class="fas fa-gem"></i>
                    <span>Jewelry &amp; Watches</span>
                </div>
                <div class="td-industry-card reveal" data-reveal="up" data-delay="180">
                    <i class="fas fa-microchip"></i>
                    <span>Consumer Electronics</span>
                </div>
                <div class="td-industry-card reveal" data-reveal="up" data-delay="240">
                    <i class="fas fa-building"></i>
                    <span>Real Estate &amp; Architecture</span>
                </div>
                <div class="td-industry-card reveal" data-reveal="up" data-delay="300">
                    <i class="fas fa-cart-shopping"></i>
                    <span>E-commerce Brands</span>
                </div>
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
                    What Photographers, Business Owners, and Ecommerce Brands Say About Our 3D Rendering &amp; Visualization Services
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
                <p>Complete the form, share your 3D model or product references, and get a sample render delivered fast.</p>
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
                    <input type="url" placeholder="Website">
                </div>
                <select required>
                    <option value="" disabled selected>Select The Service</option>
                    <option>3D Rendering</option>
                    <option>3D Product Modeling</option>
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
                    <button class="faq-q">What do I need to provide for a render? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Ideally a 3D model file (OBJ, FBX, GLTF) along with material and lighting references. If you don't have a model yet, we can build one — see our 3D Product Modeling service.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What resolution are the renders delivered in? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We deliver at the resolution you need — from web-optimised 2K up to print-ready 8K. Multi-resolution packages are available for projects needing output for different platforms.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How long does a render take? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Simple product renders: 1–2 days. Complex scenes with multiple products or animation frames: 3–7 days. Rush delivery is available for time-sensitive projects.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I request revisions? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes — unlimited revisions on lighting, materials, angles, and composition until the render matches your brief exactly.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is the free trial really free? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Share your model and brief and we'll deliver a sample render — no charge, no obligation — so you can assess quality before committing to a full project.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can you produce 360° turntable animations? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. We produce turntable animations, exploded-view sequences, and custom camera fly-throughs. Output formats include MP4, GIF, and image sequences for use in video or interactive viewers.</p></div>
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

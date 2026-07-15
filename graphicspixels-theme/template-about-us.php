<?php /* Template Name: About Us */ ?>
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
    </style>

<!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Who We Are</span>
                <h2>The Team Behind Every Pixel</h2>
                <p class="ds-lead">120+ creative specialists. 13+ years of excellence. Over 1 million images transformed for global brands.</p>
                <p>We don't just edit images — we craft visual stories that sell.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>


    <!-- ============ WHO WE ARE ============ -->
    <section class="au-intro">
        <div class="container">
            <div class="au-intro-grid">
                <div class="au-intro-img reveal" data-reveal="left">
                    <img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/graphics-pixels.jpg" alt="Graphics Pixels Production Team">
                    <div class="au-intro-badge">120+ Specialists<br>Dhaka Studio</div>
                </div>
                <div class="au-intro-text reveal" data-reveal="right">
                    <span class="section-tag">Who We Are</span>
                    <h2 class="section-title">Graphicspixels: Where Every Pixel Has a Purpose</h2>
                    <p>At Graphicspixels, we believe that every image tells a story. Founded in 2010, we have grown from a two-person bedroom studio into a globally recognised visual production powerhouse with over 120 dedicated specialists.</p>
                    <p>Our primary expertise lies in Professional Photo Editing and Advanced Retouching — ensuring that every pixel is meticulously aligned with your brand's vision. From e-commerce product shots to high-end beauty retouching, we deliver results that convert.</p>
                    <p>With over <strong>1 million images</strong> processed for clients across the USA, UK, Canada, and Europe, we combine creative excellence with industrial-scale delivery.</p>
                    <ul class="au-checklist">
                        <li><i class="fas fa-check"></i> ISO-standard quality control on every image</li>
                        <li><i class="fas fa-check"></i> 24-hour turnaround for standard orders</li>
                        <li><i class="fas fa-check"></i> Trusted by 1,500+ clients globally</li>
                        <li><i class="fas fa-check"></i> Unlimited free revisions on all projects</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<!-- ============ STATS ============ -->
    <section class="au-stats">
        <div class="container">
            <div class="au-stats-grid">
                <div class="au-stat reveal" data-reveal="up" data-delay="0">
                    <div class="au-stat-num">120<span>+</span></div>
                    <div class="au-stat-lbl">Team Members</div>
                </div>
                <div class="au-stat reveal" data-reveal="up" data-delay="100">
                    <div class="au-stat-num">13<span>+</span></div>
                    <div class="au-stat-lbl">Years of Experience</div>
                </div>
                <div class="au-stat reveal" data-reveal="up" data-delay="200">
                    <div class="au-stat-num">5k<span>+</span></div>
                    <div class="au-stat-lbl">3D Projects Completed</div>
                </div>
                <div class="au-stat reveal" data-reveal="up" data-delay="300">
                    <div class="au-stat-num">1M<span>+</span></div>
                    <div class="au-stat-lbl">Images Edited</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CORE EXPERTISE ============ -->
    <section class="au-expertise">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">What We Do Best</span>
                <h2 class="section-title">Our Core Expertise</h2>
                <p class="section-desc">From precision clipping paths to complex 3D renders — our specialists master every discipline of visual production.</p>
            </div>
            <div class="au-expertise-grid">
                <div class="au-exp-card reveal" data-reveal="up" data-delay="0">
                    <div class="au-exp-icon"><i class="fas fa-cut"></i></div>
                    <h3>Clipping Path &amp; Background Removal</h3>
                    <p>Precision-driven product isolation for e-commerce, advertising, and print. Every edge clean, every shadow preserved.</p>
                </div>
                <div class="au-exp-card reveal" data-reveal="up" data-delay="100">
                    <div class="au-exp-icon"><i class="fas fa-magic"></i></div>
                    <h3>Image Masking &amp; Complex Edges</h3>
                    <p>Hair, fur, transparent glass, motion blur — our masking specialists extract subjects that other services leave behind.</p>
                </div>
                <div class="au-exp-card reveal" data-reveal="up" data-delay="200">
                    <div class="au-exp-icon"><i class="fas fa-shopping-cart"></i></div>
                    <h3>E-commerce Image Optimisation</h3>
                    <p>Amazon, eBay, and Shopify-ready product images that comply with marketplace guidelines and drive higher conversions.</p>
                </div>
                <div class="au-exp-card reveal" data-reveal="up" data-delay="300">
                    <div class="au-exp-icon"><i class="fas fa-tshirt"></i></div>
                    <h3>Ghost Mannequin &amp; Neck Joint</h3>
                    <p>Creating immersive 3D apparel visuals without physical models — depth, shape, and professional finish every time.</p>
                </div>
            </div>
            <div class="au-expertise-cta reveal" data-reveal="up" style="text-align: center; margin-top: 50px;">
                <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-primary">More Services</a>
            </div>
        </div>
    </section>

    <!-- ============ WHY US ============ -->
    <section class="au-why">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Why Us</span>
                <h2 class="section-title au-light">Why Graphicspixels is the Right Choice</h2>
                <p class="section-desc au-light">We combine creative talent with production discipline to deliver at any scale, on any deadline.</p>
            </div>
            <div class="au-why-grid">
                <div class="au-why-card reveal" data-reveal="up" data-delay="0">
                    <div class="au-why-icon"><i class="fas fa-layer-group"></i></div>
                    <h3>Massive Capacity</h3>
                    <p>Having edited 1,000,000+ images, we scale from 10 to 10,000 images per day without compromising quality.</p>
                </div>
                <div class="au-why-card reveal" data-reveal="up" data-delay="100">
                    <div class="au-why-icon"><i class="fas fa-users"></i></div>
                    <h3>Expert Team</h3>
                    <p>120+ creative minds in our dedicated Dhaka production studio, each specialising in specific editing disciplines.</p>
                </div>
                <div class="au-why-card reveal" data-reveal="up" data-delay="200">
                    <div class="au-why-icon"><i class="fas fa-bolt"></i></div>
                    <h3>Fast Turnaround</h3>
                    <p>Standard delivery within 24 hours. Rush delivery available for urgent campaigns and last-minute deadlines.</p>
                </div>
                <div class="au-why-card reveal" data-reveal="up" data-delay="300">
                    <div class="au-why-icon"><i class="fas fa-globe"></i></div>
                    <h3>Global Trust</h3>
                    <p>1,500+ clients across the USA, UK, Canada, and Europe rely on us for consistent, professional output.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TIMELINE ============ -->
    <section class="au-timeline">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Our Story</span>
                <h2 class="section-title">The Evolution of Graphics Pixels</h2>
                <p class="section-desc">From a bold two-person vision to a globally recognised studio.</p>
            </div>
            <div class="au-tl-wrap">
                <div class="au-tl-line"></div>

                <div class="au-tl-item au-tl-left reveal" data-reveal="left">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2010</span>
                        <h3>The Foundation</h3>
                        <p>Started as a bold two-person vision in a bedroom studio, serving our first international client via referral.</p>
                    </div>
                </div>

                <div class="au-tl-item au-tl-right reveal" data-reveal="right">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2012</span>
                        <h3>The First Milestone</h3>
                        <p>Reached 100+ active clients and expanded to 8 team members through word-of-mouth growth.</p>
                    </div>
                </div>

                <div class="au-tl-item au-tl-left reveal" data-reveal="left">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2016</span>
                        <h3>Professional Expansion</h3>
                        <p>Moved into our permanent Dhaka studio, establishing formal production workflows and quality control systems.</p>
                    </div>
                </div>

                <div class="au-tl-item au-tl-right reveal" data-reveal="right">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2017</span>
                        <h3>Video Production Launch</h3>
                        <p>Launched video editing services to provide complete visual content pipelines for brands.</p>
                    </div>
                </div>

                <div class="au-tl-item au-tl-left reveal" data-reveal="left">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2018</span>
                        <h3>3D Innovation</h3>
                        <p>Officially started our 3D modelling division, investing in high-end workstations and industry-leading software.</p>
                    </div>
                </div>

                <div class="au-tl-item au-tl-right reveal" data-reveal="right">
                    <div class="au-tl-dot"></div>
                    <div class="au-tl-card">
                        <span class="au-tl-year">2023 – Present</span>
                        <h3>Global Powerhouse</h3>
                        <p>A globally recognised studio with 120+ specialists serving the US, UK, Canada, and EU. Over 1 million images edited.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ TEAM ============ -->
    <section class="au-team" id="au-team">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Our People</span>
                <h2 class="section-title">Meet the Minds Behind the Vision</h2>
                <p class="section-desc">Creative minds, skilled retouchers, and technical artists united by a passion for perfection.</p>
            </div>

            <div class="au-team-group">
                <h3 class="au-group-title">Administration</h3>
                <div class="au-team-grid">
                    <div class="au-team-card reveal" data-reveal="up" data-delay="0">
                        <div class="au-avatar"><i class="fas fa-user"></i></div>
                        <div class="au-team-info">
                            <p class="au-name">Ajijul Haque</p>
                            <p class="au-role">Managing Director</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="100">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Muhammad-Abdullah.png" alt="Muhammad Abdullah"></div>
                        <div class="au-team-info">
                            <p class="au-name">Muhammad Abdullah</p>
                            <p class="au-role">Chief Executive Officer</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="200">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Muntasir-Mahmud-Chowdhury.png" alt="Muntasir Mahmud Chowdhury"></div>
                        <div class="au-team-info">
                            <p class="au-name">Muntasir Mahmud Chowdhury</p>
                            <p class="au-role">General Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="au-team-group">
                <h3 class="au-group-title">Marketing Leadership</h3>
                <div class="au-team-grid">
                    <div class="au-team-card reveal" data-reveal="up" data-delay="0">
                        <div class="au-avatar"><i class="fas fa-user"></i></div>
                        <div class="au-team-info">
                            <p class="au-name">David Joy</p>
                            <p class="au-role">Head of Marketing</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="100">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/MD.-SAHAB-UDDIN.png" alt="MD. Sahab Uddin"></div>
                        <div class="au-team-info">
                            <p class="au-name">MD. Sahab Uddin</p>
                            <p class="au-role">Marketing Manager</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="200">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Md-Munna-Abir-Hossan.png" alt="MD. Munna Abir Hossan"></div>
                        <div class="au-team-info">
                            <p class="au-name">MD. Munna Abir Hossan</p>
                            <p class="au-role">Digital Marketing Manager</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="300">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Mehraj-Ome.png" alt="Mehraj Ome"></div>
                        <div class="au-team-info">
                            <p class="au-name">Mehraj Ome</p>
                            <p class="au-role">Marketing Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="au-team-group">
                <h3 class="au-group-title">Production Excellence</h3>
                <div class="au-team-grid">
                    <div class="au-team-card reveal" data-reveal="up" data-delay="0">
                        <div class="au-avatar"><i class="fas fa-user"></i></div>
                        <div class="au-team-info">
                            <p class="au-name">Omar Faruk</p>
                            <p class="au-role">Production Manager</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="100">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Al-Amin.png" alt="Al-Amin"></div>
                        <div class="au-team-info">
                            <p class="au-name">Al-Amin</p>
                            <p class="au-role">Team Leader</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="200">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Md-Sojib-Alam.png" alt="Md Sojib Alam"></div>
                        <div class="au-team-info">
                            <p class="au-name">Md Sojib Alam</p>
                            <p class="au-role">Team Leader</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="300">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Tariqul.png" alt="Tariqul"></div>
                        <div class="au-team-info">
                            <p class="au-name">Tariqul</p>
                            <p class="au-role">Team Leader</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="0">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Mushlay-Uddin-Himel.png" alt="Mushlay Uddin Himel"></div>
                        <div class="au-team-info">
                            <p class="au-name">Mushlay Uddin Himel</p>
                            <p class="au-role">Quality Control QC</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="100">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Forhad-Hossain-Fahim.png" alt="Forhad Hossain Fahim"></div>
                        <div class="au-team-info">
                            <p class="au-name">Forhad Hossain Fahim</p>
                            <p class="au-role">Quality Control QC</p>
                        </div>
                    </div>
                    <div class="au-team-card reveal" data-reveal="up" data-delay="200">
                        <div class="au-avatar"><img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/team/Md.-Reyaj-Hassan.png" alt="Md. Reyaj Hassan"></div>
                        <div class="au-team-info">
                            <p class="au-name">Md. Reyaj Hassan</p>
                            <p class="au-role">Quality Control QC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CULTURE ============ -->
    <section class="au-culture">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Our Culture</span>
                <h2 class="section-title">Our Work Environment</h2>
            </div>
            <div class="au-culture-grid">
                <div class="au-culture-photos reveal" data-reveal="left">
                    <div class="au-culture-photo au-photo-tall">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/1-graphics-pixels.png" alt="Graphics Pixels Team">
                    </div>
                    <div class="au-culture-photo">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/2-graphics-pixels.jpg" alt="Studio Workspace">
                    </div>
                    <div class="au-culture-photo">
                        <img src="<?php echo esc_url( gp_media_base() ); ?>/images/about/3-graphics-pixels.jpg" alt="Production Floor">
                    </div>
                </div>
                <div class="au-culture-text reveal" data-reveal="right">
                    <span class="section-tag">Life at Graphicspixels</span>
                    <h3 class="au-culture-heading">Where Creativity Meets Discipline</h3>
                    <p>We foster a culture of teamwork, innovation, and mutual respect. Our Dhaka studio is more than a workplace — it's a creative hub where 120+ specialists push the boundaries of visual excellence every day.</p>
                    <p>Every voice matters here. We invest in our people through continuous training, career development, and the tools they need to produce their best work.</p>
                    <div class="au-pillars">
                        <div class="au-pillar"><i class="fas fa-users"></i> Collaborative Culture</div>
                        <div class="au-pillar"><i class="fas fa-lightbulb"></i> Innovation First</div>
                        <div class="au-pillar"><i class="fas fa-heart"></i> People-Centred</div>
                        <div class="au-pillar"><i class="fas fa-graduation-cap"></i> Continuous Growth</div>
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

    <!-- ============ CTA ============ -->
    <section class="au-cta">
        <div class="container">
            <div class="reveal" data-reveal="up">
                <h2>Ready to Transform Your Images?</h2>
                <p>Join 1,500+ global brands who trust Graphicspixels for professional photo editing, retouching, and 3D visualisation.</p>
                <div class="au-cta-actions">
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-primary">Get a Free Quote</a>
                    <a href="<?php echo esc_url( home_url('/services/') ); ?>" class="btn btn-outline-white">View All Services</a>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>

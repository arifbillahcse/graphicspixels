<?php /* Template Name: Contact */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section ---- */
        .ds-showcase {
            position: relative;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/9_CONTACT-US.png');
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
                background-image: url('<?php echo esc_url( gp_media_base() ); ?>/images/hero-banner-images/9_CONTACT-US.png');
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
                <span class="ds-showcase-eyebrow">Get In Touch</span>
                <h2>Contact Us</h2>
                <p class="ds-lead">Have questions about our services? Need a custom quote? We're here to help!</p>
                <p>Reach out to our team and we'll get back to you as soon as possible.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Get A Free Quote</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT SECTION ============ -->
    <section class="contact-section" style="padding: 80px 0;">
        <div class="container">
            <div class="contact-wrapper">
                <!-- Left: Contact Information -->
                <div class="contact-info reveal" data-reveal="left">
                    <h2 class="contact-info-title" style="font-size: 32px; margin-bottom: 15px; color: var(--navy);">Get In Touch</h2>
                    <p class="contact-info-desc" style="color: var(--text-light); margin-bottom: 30px;">Have a question or ready to start your project? <strong style="color: var(--navy);">Our team</strong> is available and eager to assist you.</p>

                    <!-- UK Office -->
                    <div style="margin-bottom: 30px; padding: 20px; border: 2px solid var(--border); border-radius: 12px;">
                        <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--navy); font-weight: 700;">UK OFFICE ADDRESS - CORPORATE OFFICE</h3>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0; line-height: 1.6; color: var(--text);">Unit 4, Storm 12 Plaza Shopping<br>Centre, 56 St Marys Road,<br>Southampton, United Kingdom</p>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-phone" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0;"><a href="tel:+447462284915" style="color: var(--magenta); text-decoration: none; font-weight: 600;">+44 7462 284915</a></p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <i class="fas fa-envelope" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0;"><a href="mailto:info@graphicspixels.com" style="color: var(--magenta); text-decoration: none; font-weight: 600;">info@graphicspixels.com</a></p>
                        </div>
                    </div>

                    <!-- Bangladesh Office -->
                    <div style="margin-bottom: 30px; padding: 20px; border: 2px solid var(--border); border-radius: 12px;">
                        <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--navy); font-weight: 700;">BANGLADESH OFFICE - POST-PRODUCTION HOUSE</h3>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0; line-height: 1.6; color: var(--text);">House # 31, Road # 3 (New),<br>Dhanmondi, Dhaka-1209<br>Bangladesh</p>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-phone" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0;"><a href="tel:+8801890373731" style="color: var(--magenta); text-decoration: none; font-weight: 600;">Phone number: +880 1890-373731</a></p>
                        </div>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <i class="fas fa-envelope" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0;"><a href="mailto:info@graphicspixels.com" style="color: var(--magenta); text-decoration: none; font-weight: 600;">info@graphicspixels.com</a></p>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <i class="fab fa-skype" style="color: var(--magenta); margin-top: 2px;"></i>
                            <p style="margin: 0;"><a href="skype:live:csd.rafy23?chat" style="color: var(--magenta); text-decoration: none; font-weight: 600;">Skype: live:csd.rafy23</a></p>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div style="padding: 20px; border: 2px solid var(--border); border-radius: 12px; background: var(--bg-light);">
                        <h3 style="font-size: 18px; margin-bottom: 10px; color: var(--navy); font-weight: 700;">Business Hours</h3>
                        <p style="margin: 0 0 8px 0; color: var(--text);"><strong>Monday to Saturday</strong> 9 AM - 7 PM (GMT+6)</p>
                        <p style="margin: 0; color: var(--text);">Available 24/7 via email and Skype</p>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="contact-form-wrapper reveal" data-reveal="right">
                    <h2 style="font-size: 32px; margin-bottom: 30px; color: var(--navy);">Send Us a Message</h2>
                    <form class="contact-form" id="contactForm" method="POST" action="#">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Full Name *</label>
                            <input type="text" id="name" name="name" required placeholder="Your full name" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.com" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+1 (234) 567-8900" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="company" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Company Name</label>
                            <input type="text" id="company" name="company" placeholder="Your company" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="service" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Service Interested In *</label>
                            <select id="service" name="service" required style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; transition: border-color 0.3s ease;">
                                <option value="">-- Select a service --</option>
                                <option value="clipping-path">Clipping Path</option>
                                <option value="photo-retouching">Photo Retouching</option>
                                <option value="ghost-mannequin">Ghost Mannequin</option>
                                <option value="background-removal">Background Removal</option>
                                <option value="color-correction">Color Correction</option>
                                <option value="video-editing">Video Editing</option>
                                <option value="3d-services">3D Services</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="message" style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--navy);">Message *</label>
                            <textarea id="message" name="message" required placeholder="Tell us about your project..." rows="5" style="width: 100%; padding: 12px 15px; border: 2px solid var(--border); border-radius: 8px; font-size: 16px; font-family: inherit; transition: border-color 0.3s ease; resize: vertical;"></textarea>
                        </div>

                        <div class="form-group checkbox" style="margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="privacy" name="privacy" required style="width: 18px; height: 18px; cursor: pointer;">
                            <label for="privacy" style="margin: 0; font-size: 14px; color: var(--text); cursor: pointer;">I agree to the privacy policy and terms of service</label>
                        </div>

                        <div class="gp-honeypot" aria-hidden="true">
                            <label for="contact-hp">Leave this field blank</label>
                            <input type="text" name="gp_hp_optin" id="contact-hp" tabindex="-1" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px 30px; font-size: 16px; font-weight: 600;">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ GOOGLE MAP SECTION ============ -->
    <section class="map-section" style="padding: 80px 0; background: var(--bg-light);">
        <div class="container">
            <div class="section-head reveal" data-reveal="up" style="margin-bottom: 50px;">
                <span class="section-tag">Visit Us</span>
                <h2 class="section-title">Our Offices Around the World</h2>
                <p class="section-desc">Find us at our offices in the UK and Bangladesh. We're ready to collaborate and bring your vision to life.</p>
            </div>
            <div class="reveal" data-reveal="up" style="border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-lg); height: 480px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d116850.77801715067!2d90.21783189726561!3d23.762109400000007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bfac271dbbf9%3A0xec701a660bd02cd6!2sGraphics%20Pixels!5e0!3m2!1sen!2sbd!4v1781007802888!5m2!1sen!2sbd" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

<?php get_footer(); ?>

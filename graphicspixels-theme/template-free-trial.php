<?php /* Template Name: Free Trial */ ?>
<?php get_header(); ?>

<style>
        /* ---- Showcase Banner Section (matches home page hero) ---- */
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

        /* ---- Free Trial Form Section — page-specific background ---- */
        .free-trial {
            background: var(--gradient);
            position: relative;
            overflow: hidden;
        }
        .free-trial::before {
            content: ''; position: absolute; top: -30%; left: -10%; width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%); border-radius: 50%;
        }
        .free-trial::after {
            content: ''; position: absolute; bottom: -25%; right: -8%; width: 460px; height: 460px;
            background: radial-gradient(circle, rgba(255,255,255,0.10) 0%, transparent 70%); border-radius: 50%;
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HERO / SHOWCASE ============ -->
    <section class="ds-showcase">
        <div class="ds-showcase-image" aria-hidden="true"></div>
        <div class="container">
            <div class="ds-showcase-content reveal" data-reveal="left">
                <span class="ds-showcase-eyebrow">Get Started Risk-Free</span>
                <h2>Try Our Services Completely Free</h2>
                <p class="ds-lead">No credit card required. No hidden fees.</p>
                <p>Send 1 to 5 images and receive professional, human-edited results within 24 hours. Unlimited revisions, NDA-compliant, zero obligation — try before you commit.</p>
                <div class="ds-showcase-actions">
                    <a href="#free-trial" class="btn btn-primary">Start Your Free Trial</a>
                    <a href="<?php echo esc_url( home_url('/pricing/') ); ?>" class="btn btn-outline-white">View Pricing</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FREE TRIAL FORM ============ -->
    <section class="free-trial" id="free-trial">
        <div class="container free-trial-container">
            <div class="free-trial-info reveal" data-reveal="left">
                <span class="section-tag light">Start Your Free Trial</span>
                <h2 class="section-title light">How to Get Started in 3 Steps</h2>
                <p><strong>It's simple:</strong> Upload your images, select your service, and we'll get to work immediately.</p>
                <ul class="trial-perks">
                    <li><i class="fas fa-file-upload"></i> <strong>Step 1:</strong> Upload 1-5 images (JPG, PNG, PSD, TIFF, RAW)</li>
                    <li><i class="fas fa-check"></i> <strong>Step 2:</strong> Select your service and tell us what you need</li>
                    <li><i class="fas fa-clock"></i> <strong>Step 3:</strong> Receive edited images within 24 hours</li>
                    <li><i class="fas fa-star"></i> Review quality and decide to order more</li>
                </ul>
                <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.2);">
                    <p style="font-size: 14px; opacity: 0.9;"><i class="fas fa-lock"></i> No payment details required. No auto-billing. 100% risk-free.</p>
                </div>
            </div>
            <form class="free-trial-form reveal" data-reveal="right" id="trial-form">
                <h3 style="margin-bottom: 20px; font-size: 18px; font-weight: 600;">Free Trial Request</h3>
                <div class="form-row">
                    <input type="text" placeholder="Your Name*" required>
                    <input type="email" placeholder="Email Address*" required>
                </div>
                <div class="form-row">
                    <input type="tel" placeholder="Phone*" required>
                    <input type="text" placeholder="Website*" required>
                </div>
                <select required>
                    <option value="" disabled selected>Select Service*</option>
                    <option>Clipping Path</option>
                    <option>Photo Retouching</option>
                    <option>Ghost Mannequin</option>
                    <option>Headshot Photo Editing</option>
                    <option>Background Removal</option>
                    <option>Color Correction</option>
                    <option>Drop Shadow</option>
                    <option>Image Masking</option>
                    <option>E-commerce Image Editing</option>
                    <option>Photo Restoration</option>
                    <option>AI-generated Image Fixes</option>
                    <option>3D Product Modeling</option>
                    <option>3D Rendering</option>
                    <option>Video Editing</option>
                    <option>Other</option>
                </select>
                <textarea placeholder="Tell us about your project or any specific requirements" rows="3"></textarea>
                <div class="file-upload">
                    <label for="file-input"><i class="fas fa-cloud-arrow-up"></i> Choose files (1-5 images)</label>
                    <input type="file" id="file-input" multiple accept="image/*">
                    <span class="file-name">No files chosen</span>
                </div>
                <p class="upload-note">Supported: JPG, PNG, PSD, TIFF, RAW. Max 25 MB per file. For larger files, use a cloud link below.</p>
                <input type="text" placeholder="Or paste a Google Drive / Dropbox link here">
                <div class="gp-honeypot" aria-hidden="true">
                    <label for="ft-hp">Leave this field blank</label>
                    <input type="text" name="gp_hp_optin" id="ft-hp" tabindex="-1" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Start Your Free Trial</button>
                <p style="font-size: 12px; text-align: center; margin-top: 12px; opacity: 0.8;">We'll review your request and send results within 24 hours.</p>
            </form>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->

<?php get_footer(); ?>

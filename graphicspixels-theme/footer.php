<?php $gp_uri = gp_media_base(); ?>

<!-- ============ GLOBAL CTA BANNER ============ -->
<style>
    .gp-cta-banner { padding: 80px 0; }
    .gp-cta-banner-inner {
        display: grid; grid-template-columns: 1fr 1fr; align-items: stretch;
        border-radius: 24px; overflow: hidden; box-shadow: var(--shadow-lg);
    }
    .gp-cta-banner-img { background-size: cover; background-position: center; min-height: 320px; }
    .gp-cta-banner-body {
        background: linear-gradient(155deg, #01015E 0%, #16006e 55%, #0a0050 100%);
        padding: 56px 48px; color: #fff;
    }
    .gp-cta-banner-body h2 { font-family: 'Poppins', sans-serif; font-size: 28px; font-weight: 800; color: #fff; line-height: 1.25; margin-bottom: 16px; }
    .gp-cta-banner-body p { color: rgba(255,255,255,0.8); font-size: 15px; line-height: 1.8; margin-bottom: 24px; }
    .gp-cta-banner-tools { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; }
    .gp-cta-banner-tools span { font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 100px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.18); color: #fff; }
    @media (max-width: 992px) {
        .gp-cta-banner-inner { grid-template-columns: 1fr; }
        .gp-cta-banner-img { min-height: 240px; }
    }
    @media (max-width: 768px) {
        .gp-cta-banner-body { padding: 40px 28px; }
    }
</style>
<section class="gp-cta-banner">
    <div class="container">
        <div class="gp-cta-banner-inner">
            <div class="gp-cta-banner-img" style="background-image:url('<?php echo esc_url( $gp_uri ); ?>/images/services_hero.png');"></div>
            <div class="gp-cta-banner-body">
                <h2>Ready to See the Graphics Pixels Difference for Yourself?</h2>
                <p>Join 1,700+ photographers and e-commerce brands who outsource their image editing to us — and get time back in their day without sacrificing a single pixel of quality. Background removal, retouching, clipping paths, color grading — we do it all, fast and flawlessly.</p>
                <div class="gp-cta-banner-tools">
                    <span>Adobe Photoshop</span>
                    <span>Adobe Lightroom</span>
                    <span>Capture One</span>
                    <span>Affinity Photo</span>
                    <span>CorelDRAW</span>
                </div>
                <a href="#free-trial" class="btn btn-primary">Start a Free Trial</a>
            </div>
        </div>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="container footer-grid">
        <div class="footer-col footer-about">
            <img src="<?php echo esc_url( $gp_uri ); ?>/images/graphics-pixels-logo-2-HR.png" alt="Graphics Pixels" class="footer-logo">
            <p class="footer-address">
                <i class="fas fa-location-dot"></i>
                <?php echo esc_html( gp_site_info( 'address' ) ); ?>
            </p>
            <p class="footer-contact"><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr( gp_site_info( 'phone_link' ) ); ?>"><?php echo esc_html( gp_site_info( 'phone' ) ); ?></a></p>
            <p class="footer-contact"><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr( gp_site_info( 'email' ) ); ?>"><?php echo esc_html( gp_site_info( 'email' ) ); ?></a></p>
        </div>
        <div class="footer-col">
            <h4>Useful Links</h4>
            <ul>
                <li><a href="#free-trial">Free Trial</a></li>
                <li><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a></li>
                <li><a href="<?php echo esc_url( home_url( '/reviews/' ) ); ?>">Reviews</a></li>
                <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a></li>
                <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">Blog</a></li>
                <li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Services</h4>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/clipping-path-service/' ) ); ?>">Clipping Path Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/photo-retouching-service/' ) ); ?>">Photo Retouching Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/ghost-mannequin-service/' ) ); ?>">Ghost Mannequin Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/headshot-photo-editing/' ) ); ?>">Headshot Photo Editing</a></li>
                <li><a href="<?php echo esc_url( home_url( '/background-removal-service/' ) ); ?>">Background Removal Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/color-correction-service/' ) ); ?>">Color Correction Service</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Services</h4>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/drop-shadow-service/' ) ); ?>">Drop Shadow Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/image-masking-service/' ) ); ?>">Image Masking Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/ecommerce-image-editing-services/' ) ); ?>">E-commerce Image Editing</a></li>
                <li><a href="<?php echo esc_url( home_url( '/photo-restoration-service/' ) ); ?>">Photo Restoration Service</a></li>
                <li><a href="<?php echo esc_url( home_url( '/ai-generated-image-fixes/' ) ); ?>">AI-generated Image Fixes</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>Copyright &copy; 2013 GRAPHICSPIXELS. Developed by <a href="https://softorio.com" target="_blank" rel="noopener">Softorio</a></p>
            <div class="social-links">
                <a href="https://www.pinterest.com/graphicspixels/" target="_blank" rel="noopener" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                <a href="https://www.youtube.com/@graphicspixels" target="_blank" rel="noopener" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <a href="https://twitter.com/graphicspixelss" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.instagram.com/grap.hicspixels/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company/graphicspixels/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://www.facebook.com/profile.php?id=61573139442036" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>
</footer>

<button class="back-to-top" id="back-to-top" aria-label="Back to top"><i class="fas fa-arrow-up"></i></button>

<!-- WhatsApp Chat Button -->
<a href="<?php echo esc_url( gp_site_info( 'whatsapp_link' ) ); ?>" target="_blank" class="whatsapp-button" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- ============ FREE TRIAL MODAL (loaded on all pages) ============ -->
<div class="trial-modal-overlay" id="trialModalOverlay" role="dialog" aria-modal="true" aria-label="Free Trial Form">
    <div class="trial-modal" id="trialModal">
        <button class="trial-modal-close" id="trialModalClose" aria-label="Close modal">
            <i class="fas fa-times"></i>
        </button>
        <div class="trial-modal-head">
            <span class="trial-modal-tag">Get Started</span>
            <h2 class="trial-modal-title">Get Your Free Trial</h2>
        </div>
        <form class="free-trial-form" id="modal-trial-form">
            <div class="form-row">
                <input type="text" name="name" placeholder="Your Name*" required>
                <input type="email" name="email" placeholder="Add Email*" required>
            </div>
            <div class="form-row">
                <input type="tel" name="phone" placeholder="Phone*" required>
                <input type="text" name="website" placeholder="Website">
            </div>
            <select name="service" required>
                <option value="" disabled selected>Select The Service</option>
                <option>Clipping Path</option>
                <option>Ghost Mannequin &amp; Neck Joint</option>
                <option>Photo Retouching</option>
                <option>Background Removal</option>
                <option>Color Correction</option>
                <option>Image Masking</option>
                <option>3D Service</option>
                <option>Video Editing</option>
            </select>
            <textarea name="message" placeholder="Your message" rows="3"></textarea>
            <div class="file-upload">
                <label for="modal-file-input"><i class="fas fa-cloud-arrow-up"></i> Choose a file</label>
                <input type="file" name="attachment" id="modal-file-input">
                <span class="file-name">No file chosen</span>
            </div>
            <p class="upload-note">If the size is more than 25 MB, share your images via cloud (Google Drive, Dropbox or WeTransfer).</p>
            <input type="text" name="file_link" placeholder="Paste the link here (URL)">
            <div class="gp-honeypot" aria-hidden="true">
                <label for="modal-hp">Leave this field blank</label>
                <input type="text" name="gp_hp_optin" id="modal-hp" tabindex="-1" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Send Message</button>
        </form>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>

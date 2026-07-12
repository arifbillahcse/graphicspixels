<?php $gp_uri = gp_media_base(); ?>
<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="container footer-grid">
        <div class="footer-col footer-about">
            <img src="<?php echo esc_url( $gp_uri ); ?>/images/graphics-pixels-logo-2-HR.png" alt="Graphics Pixels" class="footer-logo">
            <p class="footer-address">
                <i class="fas fa-location-dot"></i>
                Unit 4, Storm 12 Plaza Shopping Centre, 54 St Marys Road, Southampton, United Kingdom, SO14 0BH
            </p>
            <p class="footer-contact"><i class="fas fa-phone"></i> <a href="tel:+447462284915">+44 7462 284915</a></p>
            <p class="footer-contact"><i class="fas fa-envelope"></i> <a href="mailto:info@graphicspixels.com">info@graphicspixels.com</a></p>
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
<a href="https://wa.me/8801890373731" target="_blank" class="whatsapp-button" aria-label="Chat on WhatsApp">
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

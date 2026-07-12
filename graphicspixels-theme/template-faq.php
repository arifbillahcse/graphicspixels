<?php /* Template Name: Faq */ ?>
<?php get_header(); ?>

<style>
        /* ===== Page-scoped styles — FAQ ===== */
        .faq-page-header { padding: 150px 0 50px; background: var(--gradient-soft); }
        .faq-page-header .faq-eyebrow {
            font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px;
            letter-spacing: 2px; text-transform: uppercase; color: var(--magenta);
        }
        .faq-page-header h1 {
            font-family: 'Poppins', sans-serif; font-size: 44px; font-weight: 800;
            color: var(--navy); text-transform: uppercase; line-height: 1.1; margin-top: 10px;
        }
        .faq-page-header .faq-sub { margin-top: 14px; color: var(--text-light); font-size: 16px; max-width: 620px; }

        .faq-section:nth-of-type(even) { background: var(--white); }

        .faq-cta { padding: 70px 0; background: var(--navy); text-align: center; }
        .faq-cta h2 { font-family: 'Poppins', sans-serif; color: var(--white); font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .faq-cta p { color: rgba(255,255,255,0.75); font-size: 15px; margin-bottom: 28px; }
        .faq-cta-actions { display: flex; justify-content: center; gap: 16px; flex-wrap: wrap; }

        @media (max-width: 768px) {
            .faq-page-header { padding: 120px 0 40px; }
            .faq-page-header h1 { font-size: 30px; }
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HEADER ============ -->
    <section class="faq-page-header">
        <div class="container">
            <p class="faq-eyebrow">Got Questions?</p>
            <h1>Frequently Asked Questions</h1>
            <p class="faq-sub">Answers about our services, pricing, turnaround times, free trials, payment and file security.</p>
        </div>
    </section>

    <!-- ============ FAQ: GENERAL ============ -->
    <section class="faq-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">General</span>
                <h2 class="section-title">About Graphics Pixels</h2>
            </div>
            <div class="faq-list reveal" data-reveal="up" data-delay="100">
                <div class="faq-item">
                    <button class="faq-q">What is Graphics Pixels? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Graphics Pixels is a trusted photo editing and 3D rendering service provider that helps online businesses stand out with high-quality visual solutions.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What services do you offer? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p><strong>Photo Editing:</strong> Clipping Path, Background Removal, Ghost Mannequin, Photo Retouching, Color Correction, Image Masking, Drop Shadow, and more. <strong>3D &amp; Video Services:</strong> product video editing, motion graphics, and 3D product modeling/rendering.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Is a free trial available? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes! Submit your image through our free trial request form and you'll typically receive a sample back within 1 hour.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What are your pricing and turnaround times? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p><strong>Basic</strong> — $0.29/image, 24–48 hours. <strong>Standard</strong> — $0.69/image, turnaround based on complexity. <strong>Premium</strong> — $1.50+/image, turnaround as per requirements. Bulk orders and urgent deliveries may receive custom rates or discounts.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you offer discounts for bulk orders? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. Large orders (100–600+ images) receive progressive discounts based on volume — ask us for a custom quote.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What types of photo retouching do you provide? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>High-end retouching, e-commerce product retouching, jewelry retouching, fashion &amp; beauty editing, and skin/portrait retouching.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Do you work with international clients? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes! Graphics Pixels serves clients worldwide, including the US, UK, Canada, Australia, and EU countries. All communication is handled in English.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FAQ: PRICING & PAYMENT ============ -->
    <section class="faq-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Pricing</span>
                <h2 class="section-title">Pricing &amp; Payment</h2>
            </div>
            <div class="faq-list reveal" data-reveal="up" data-delay="100">
                <div class="faq-item">
                    <button class="faq-q">When do I have to pay? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>You don't have to pay upfront. You can review the completed work first, and only proceed with payment once you're satisfied.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I use FTP to upload/download files? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. After project confirmation, you'll receive FTP login credentials so you can easily upload or download bulk files.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">What file formats do you accept and deliver? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>We accept JPEG, PNG, PSD, TIFF, and RAW formats (including CR2, NEF). Delivery formats can be customized — usually JPEG, PNG, PSD, or transparent PNGs.</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FAQ: SECURITY & SUPPORT ============ -->
    <section class="faq-section">
        <div class="container">
            <div class="section-head reveal" data-reveal="up">
                <span class="section-tag">Security</span>
                <h2 class="section-title">Security &amp; Support</h2>
            </div>
            <div class="faq-list reveal" data-reveal="up" data-delay="100">
                <div class="faq-item">
                    <button class="faq-q">Are my images secure with you? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Absolutely. All staff sign NDAs, and files are handled on secure servers protected by firewalls and up-to-date antivirus software.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">Can I request revisions if I'm not satisfied? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p>Yes. You're entitled to unlimited revisions until you're fully satisfied with the output, at no extra charge, unless the original requirements change.</p></div>
                </div>
                <div class="faq-item">
                    <button class="faq-q">How can I contact you? <i class="fas fa-plus"></i></button>
                    <div class="faq-a"><p><strong>UK Office:</strong> Unit 4, Storm 12 Plaza Shopping Centre, 56 St Marys Road, Southampton, United Kingdom &middot; <a href="tel:+447576228915">+44 7576-228-915</a><br><strong>Bangladesh Office:</strong> House # 31, Road # 3 (New), Dhanmondi, Dhaka-1209 &middot; <a href="tel:+8801980326731">+880 1980-326-731</a><br><strong>Email:</strong> <a href="mailto:info@graphicspixels.com">info@graphicspixels.com</a></p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA ============ -->
    <section class="faq-cta">
        <div class="container">
            <h2>Still have questions?</h2>
            <p>Our team is happy to help — reach out or start with a free trial.</p>
            <div class="faq-cta-actions">
                <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline-white">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->

<?php get_footer(); ?>

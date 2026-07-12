<?php /* Template Name: Blog */ ?>
<?php get_header(); ?>

<style>
        /* ===== Page-scoped styles — Blog ===== */
        .bl-header { padding: 150px 0 50px; background: var(--gradient-soft); }
        .bl-header .bl-eyebrow {
            font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 14px;
            letter-spacing: 2px; text-transform: uppercase; color: var(--magenta);
        }
        .bl-header h1 {
            font-family: 'Poppins', sans-serif; font-size: 44px; font-weight: 800;
            color: var(--navy); text-transform: uppercase; line-height: 1.1; margin-top: 10px;
        }
        .bl-header .bl-sub { margin-top: 14px; color: var(--text-light); font-size: 16px; max-width: 620px; }

        .bl-empty { padding: 100px 0 120px; text-align: center; }
        .bl-empty i { font-size: 48px; color: var(--magenta); margin-bottom: 22px; }
        .bl-empty h2 { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; color: var(--navy); margin-bottom: 12px; }
        .bl-empty p { color: var(--text-light); font-size: 15px; max-width: 480px; margin: 0 auto 30px; }

        @media (max-width: 768px) {
            .bl-header { padding: 120px 0 40px; }
            .bl-header h1 { font-size: 30px; }
        }
    </style>

<!-- ============ HEADER / NAVIGATION ============ -->

    <!-- ============ PAGE HEADER ============ -->
    <section class="bl-header">
        <div class="container">
            <p class="bl-eyebrow">Graphics Pixels</p>
            <h1>Blog</h1>
            <p class="bl-sub">Photo editing tips, e-commerce imaging guides and news from our team.</p>
        </div>
    </section>

    <!-- ============ EMPTY STATE ============ -->
    <section class="bl-empty">
        <div class="container">
            <i class="fas fa-pen-nib"></i>
            <h2>New posts are coming soon</h2>
            <p>We're working on our first articles. In the meantime, get in touch or grab a free trial of our editing services.</p>
            <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
                <a href="#free-trial" class="btn btn-primary">Get Free Trial</a>
                <a href="<?php echo esc_url( home_url('/contact/') ); ?>" class="btn btn-outline">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->

<?php get_footer(); ?>

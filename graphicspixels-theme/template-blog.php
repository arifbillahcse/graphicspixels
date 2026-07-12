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

        /* ── Posts grid ── */
        .bl-posts { padding: 60px 0 90px; }
        .bl-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .bl-card {
            background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 14px;
            overflow: hidden; display: flex; flex-direction: column;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .bl-card:hover { transform: translateY(-4px); box-shadow: 0 14px 34px rgba(0,0,0,.08); }
        .bl-card-link { display: flex; flex-direction: column; height: 100%; color: inherit; text-decoration: none; }
        .bl-card-thumb { aspect-ratio: 16/10; overflow: hidden; background: var(--gradient-soft); }
        .bl-card-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .bl-card-body { padding: 22px; display: flex; flex-direction: column; flex: 1; }
        .bl-card-meta { font-size: 13px; color: var(--text-light, #667); margin-bottom: 8px; }
        .bl-card-cat { color: var(--magenta); font-weight: 600; }
        .bl-card-title {
            font-family: 'Poppins', sans-serif; font-size: 20px; font-weight: 700;
            color: var(--navy); line-height: 1.35; margin-bottom: 10px;
        }
        .bl-card-excerpt { font-size: 15px; color: var(--text-light, #667); line-height: 1.6; margin-bottom: 16px; }
        .bl-card-more { margin-top: auto; font-weight: 600; color: var(--magenta); font-size: 14px; }

        /* ── Pagination ── */
        .bl-pagination { margin-top: 50px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .bl-pagination a, .bl-pagination span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 42px; height: 42px; padding: 0 12px; border-radius: 8px;
            border: 1px solid var(--border, #e5e7eb); color: var(--navy);
            text-decoration: none; font-weight: 600; font-size: 14px;
        }
        .bl-pagination .current { background: var(--magenta); border-color: var(--magenta); color: #fff; }
        .bl-pagination a:hover { border-color: var(--magenta); color: var(--magenta); }

        .bl-empty { padding: 90px 0 110px; text-align: center; }
        .bl-empty i { font-size: 48px; color: var(--magenta); margin-bottom: 22px; }
        .bl-empty h2 { font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 700; color: var(--navy); margin-bottom: 12px; }
        .bl-empty p { color: var(--text-light); font-size: 15px; max-width: 480px; margin: 0 auto 30px; }

        @media (max-width: 900px) { .bl-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .bl-header { padding: 120px 0 40px; }
            .bl-header h1 { font-size: 30px; }
        }
        @media (max-width: 600px) { .bl-grid { grid-template-columns: 1fr; } }
    </style>

    <!-- ============ PAGE HEADER ============ -->
    <section class="bl-header">
        <div class="container">
            <p class="bl-eyebrow">Graphics Pixels</p>
            <h1>Blog</h1>
            <p class="bl-sub">Photo editing tips, e-commerce imaging guides and news from our team.</p>
        </div>
    </section>

    <?php
    // Resolve the current page number whether it comes via /page/N/, ?paged=N or ?page=N.
    $bl_paged = 1;
    if ( get_query_var( 'paged' ) ) {
        $bl_paged = (int) get_query_var( 'paged' );
    } elseif ( get_query_var( 'page' ) ) {
        $bl_paged = (int) get_query_var( 'page' );
    } elseif ( isset( $_GET['paged'] ) ) {
        $bl_paged = max( 1, absint( $_GET['paged'] ) );
    }

    $bl_query = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => $bl_paged,
        'ignore_sticky_posts' => false,
    ) );
    ?>

    <?php if ( $bl_query->have_posts() ) : ?>

        <!-- ============ POSTS GRID ============ -->
        <section class="bl-posts">
            <div class="container">
                <div class="bl-grid">
                    <?php while ( $bl_query->have_posts() ) : $bl_query->the_post(); ?>
                        <article <?php post_class( 'bl-card' ); ?>>
                            <a class="bl-card-link" href="<?php the_permalink(); ?>">
                                <div class="bl-card-thumb">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium_large' ); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="bl-card-body">
                                    <p class="bl-card-meta">
                                        <?php if ( has_category() ) : ?>
                                            <span class="bl-card-cat"><?php echo esc_html( get_the_category()[0]->name ); ?></span> ·
                                        <?php endif; ?>
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </p>
                                    <h2 class="bl-card-title"><?php the_title(); ?></h2>
                                    <p class="bl-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                                    <span class="bl-card-more">Read more <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php
                $bl_links = paginate_links( array(
                    'base'      => add_query_arg( 'paged', '%#%' ),
                    'format'    => '',
                    'current'   => $bl_paged,
                    'total'     => $bl_query->max_num_pages,
                    'type'      => 'array',
                    'prev_text' => '<i class="fas fa-arrow-left"></i>',
                    'next_text' => '<i class="fas fa-arrow-right"></i>',
                ) );
                if ( $bl_links ) : ?>
                    <nav class="bl-pagination">
                        <?php echo implode( '', $bl_links ); // phpcs:ignore ?>
                    </nav>
                <?php endif; ?>
            </div>
        </section>

        <?php wp_reset_postdata(); ?>

    <?php else : ?>

        <!-- ============ EMPTY STATE (no posts yet) ============ -->
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

    <?php endif; ?>

<?php get_footer(); ?>

<?php
/**
 * Single blog post.
 */
get_header();
?>

<section class="section gp-single">
    <div class="container gp-single-inner">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'gp-post' ); ?>>
                <header class="gp-post-head">
                    <h1 class="gp-post-title"><?php the_title(); ?></h1>
                    <p class="gp-post-meta">
                        <i class="fas fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?>
                        &nbsp;·&nbsp;
                        <i class="fas fa-user"></i> <?php the_author(); ?>
                        <?php if ( has_category() ) : ?>
                            &nbsp;·&nbsp;<i class="fas fa-folder"></i> <?php the_category( ', ' ); ?>
                        <?php endif; ?>
                    </p>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="gp-post-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
                <?php endif; ?>

                <div class="gp-post-content">
                    <?php the_content(); ?>
                    <?php
                    wp_link_pages( array(
                        'before' => '<div class="gp-page-links">' . esc_html__( 'Pages:', 'graphicspixels' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

                <?php if ( has_tag() ) : ?>
                    <footer class="gp-post-tags"><i class="fas fa-tags"></i> <?php the_tags( '', ', ' ); ?></footer>
                <?php endif; ?>
            </article>

            <div class="gp-post-nav">
                <div class="gp-post-nav-prev"><?php previous_post_link( '%link', '<i class="fas fa-arrow-left"></i> %title' ); ?></div>
                <div class="gp-post-nav-next"><?php next_post_link( '%link', '%title <i class="fas fa-arrow-right"></i>' ); ?></div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<style>
    .gp-single { padding: 150px 0 60px; }
    @media (max-width: 768px) { .gp-single { padding-top: 120px; } }
    .gp-single-inner { max-width: 820px; }
    .gp-post-title { font-size: 34px; line-height: 1.25; margin-bottom: 14px; }
    .gp-post-meta { color: var(--text-light, #667); font-size: 14px; margin-bottom: 28px; }
    .gp-post-meta a { color: inherit; }
    .gp-post-thumb { margin: 0 0 32px; border-radius: 12px; overflow: hidden; }
    .gp-post-thumb img { width: 100%; height: auto; display: block; }
    .gp-post-content { font-size: 17px; line-height: 1.75; }
    .gp-post-content p { margin-bottom: 20px; }
    .gp-post-content img { max-width: 100%; height: auto; border-radius: 10px; margin: 18px 0; }
    .gp-post-content h2 { font-size: 26px; margin: 34px 0 14px; }
    .gp-post-content h3 { font-size: 21px; margin: 28px 0 12px; }
    .gp-post-content ul, .gp-post-content ol { margin: 0 0 20px 22px; }
    .gp-post-content blockquote { border-left: 4px solid var(--primary, #4f46e5); padding-left: 18px; margin: 22px 0; color: var(--text-light, #667); font-style: italic; }
    .gp-post-tags { margin-top: 34px; font-size: 14px; color: var(--text-light, #667); }
    .gp-post-tags a { color: inherit; }
    .gp-post-nav { display: flex; justify-content: space-between; gap: 20px; margin: 44px 0; padding-top: 24px; border-top: 1px solid var(--border, #e5e7eb); font-weight: 600; }
    .gp-post-nav a { color: var(--primary, #4f46e5); text-decoration: none; }
    .gp-post-nav-next { text-align: right; margin-left: auto; }
    @media (max-width: 600px) {
        .gp-post-title { font-size: 26px; }
        .gp-post-nav { flex-direction: column; }
        .gp-post-nav-next { text-align: left; }
    }
</style>

<?php get_footer(); ?>

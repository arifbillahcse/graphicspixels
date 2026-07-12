<?php
/**
 * Archive (category, tag, date, author) — reuses the blog grid layout.
 */
get_header();
?>

<section class="section gp-blog">
    <div class="container">
        <header class="gp-blog-head">
            <h1 class="gp-blog-title"><?php the_archive_title(); ?></h1>
            <?php the_archive_description( '<div class="gp-blog-desc">', '</div>' ); ?>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="gp-post-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class( 'gp-card' ); ?>>
                        <a class="gp-card-link" href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="gp-card-thumb"><?php the_post_thumbnail( 'medium_large' ); ?></div>
                            <?php endif; ?>
                            <div class="gp-card-body">
                                <p class="gp-card-meta"><?php echo esc_html( get_the_date() ); ?></p>
                                <h2 class="gp-card-title"><?php the_title(); ?></h2>
                                <p class="gp-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
                                <span class="gp-card-more">Read more <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
        <?php else : ?>
            <p>Nothing found in this archive.</p>
        <?php endif; ?>
    </div>
</section>

<style>
    .gp-blog { padding: 60px 0; }
    .gp-blog-head { text-align: center; margin-bottom: 44px; }
    .gp-blog-title { font-size: 36px; }
    .gp-blog-desc { color: var(--text-light, #667); margin-top: 10px; }
    .gp-post-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
    .gp-card { background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 14px; overflow: hidden; transition: transform .25s ease, box-shadow .25s ease; }
    .gp-card:hover { transform: translateY(-4px); box-shadow: 0 14px 34px rgba(0,0,0,.08); }
    .gp-card-link { display: block; color: inherit; text-decoration: none; }
    .gp-card-thumb { aspect-ratio: 16/10; overflow: hidden; }
    .gp-card-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .gp-card-body { padding: 22px; }
    .gp-card-meta { font-size: 13px; color: var(--text-light, #667); margin-bottom: 8px; }
    .gp-card-title { font-size: 20px; line-height: 1.35; margin-bottom: 10px; }
    .gp-card-excerpt { font-size: 15px; color: var(--text-light, #667); line-height: 1.6; margin-bottom: 14px; }
    .gp-card-more { font-weight: 600; color: var(--primary, #4f46e5); font-size: 14px; }
    @media (max-width: 900px) { .gp-post-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .gp-post-grid { grid-template-columns: 1fr; } }
</style>

<?php get_footer(); ?>

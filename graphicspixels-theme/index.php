<?php
/**
 * Fallback template (also serves the blog posts index once
 * native posts are used).
 */
get_header();
?>

<section class="section">
    <div class="container">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>Nothing found.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

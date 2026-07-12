<?php
/**
 * Default page template — used for any page without one of the
 * converted "Template Name" templates assigned.
 */
get_header();
?>

<section class="section">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>

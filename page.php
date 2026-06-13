<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="nd-page">
    <h1 class="nd-page__title"><?php the_title(); ?></h1>
    <div class="nd-page__content">
        <?php the_content(); ?>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

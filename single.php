<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php
$cats   = get_the_category();
$cat    = $cats ? $cats[0] : null;
?>

<article class="nd-article" id="post-<?php the_ID(); ?>">

    <!-- Breadcrumb -->
    <nav class="nd-article__breadcrumb" aria-label="Fil d'Ariane">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Accueil</a>
        <span>›</span>
        <?php if ( $cat ) : ?>
            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                <?php echo esc_html( $cat->name ); ?>
            </a>
            <span>›</span>
        <?php endif; ?>
        <span><?php the_title(); ?></span>
    </nav>

    <!-- Titre -->
    <h1 class="nd-article__title"><?php the_title(); ?></h1>

    <!-- Image à la une -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="nd-article__thumbnail">
            <?php the_post_thumbnail( 'nd-article' ); ?>
        </div>
    <?php endif; ?>

    <!-- Contenu de l'article -->
    <div class="nd-article__content">
        <?php the_content(); ?>
    </div>

</article>

<!-- Articles similaires -->
<?php
$same_cat_query = new WP_Query( array(
    'category__in'   => $cat ? array( $cat->term_id ) : array(),
    'posts_per_page' => 3,
    'post__not_in'   => array( get_the_ID() ),
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( $same_cat_query->have_posts() ) : ?>
<section class="nd-section nd-section--alt nd-related">
    <div class="nd-container">
        <div class="nd-section__head">
            <div>
                <span class="nd-label">À lire aussi</span>
                <h2 class="nd-section__title">Articles similaires</h2>
            </div>
        </div>
        <div class="nd-posts-grid">
            <?php while ( $same_cat_query->have_posts() ) : $same_cat_query->the_post();
                $rcats    = get_the_category();
                $rcat     = $rcats ? $rcats[0] : null;
            ?>
            <article class="nd-card">
                <div class="nd-card__img<?php echo ! has_post_thumbnail() ? ' nd-card__img--placeholder' : ''; ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'nd-card' ); ?>
                    <?php else : ?>
                        <span class="nd-placeholder-label">[ photo : <?php echo strtolower( esc_html( get_the_title() ) ); ?> ]</span>
                    <?php endif; ?>
                </div>
                <div class="nd-card__body">
                    <?php if ( $rcat ) : ?>
                        <span class="nd-card__cat"><?php echo esc_html( $rcat->name ); ?></span>
                    <?php endif; ?>
                    <h3 class="nd-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="nd-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 18, '…' ); ?></p>
                    <a href="<?php the_permalink(); ?>" class="nd-card__link">Lire l'article →</a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

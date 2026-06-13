<?php get_header(); ?>

<div class="nd-blog__hero">
    <div class="nd-container">
        <h1 class="nd-blog__title">Tous nos articles</h1>
        <p class="nd-blog__desc">Guides d'achat, comparatifs et conseils pour mieux dormir.</p>
    </div>
</div>

<section class="nd-section">
    <div class="nd-container">
        <?php if ( have_posts() ) : ?>
            <div class="nd-posts-grid">
                <?php while ( have_posts() ) : the_post();
                    $cats     = get_the_category();
                    $cat_name = $cats ? esc_html( $cats[0]->name ) : '';
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
                        <?php if ( $cat_name ) : ?>
                            <span class="nd-card__cat"><?php echo $cat_name; ?></span>
                        <?php endif; ?>
                        <h2 class="nd-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="nd-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '…' ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="nd-card__link">Lire l'article →</a>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>

            <div class="nd-pagination">
                <?php
                echo paginate_links( array(
                    'prev_text' => '← Précédent',
                    'next_text' => 'Suivant →',
                ) );
                ?>
            </div>

        <?php else : ?>
            <p>Aucun article pour le moment. Revenez bientôt !</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>

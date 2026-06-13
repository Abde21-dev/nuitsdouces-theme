<?php get_header(); ?>

<!-- ================================================================
     HERO — fond bleu nuit, slogan, CTA
================================================================ -->
<section class="nd-hero">
    <div class="nd-hero__inner">
        <span class="nd-hero__label">Bien dormir, simplement</span>
        <h1 class="nd-hero__title">Des nuits plus douces,<br>des choix plus sûrs.</h1>
        <p class="nd-hero__desc">
            Tests honnêtes, guides d'achat clairs et comparatifs sans jargon.
            On vous aide à trouver la literie qui vous ressemble&nbsp;—
            et à mieux dormir, dès ce soir.
        </p>
        <div class="nd-hero__actions">
            <a href="<?php echo esc_url( home_url( '/category/matelas/' ) ); ?>" class="nd-btn-cta">
                Voir le comparatif matelas →
            </a>
            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="nd-hero__ghost">
                Tous nos guides
            </a>
        </div>
    </div>
</section>

<!-- ================================================================
     ARTICLES RÉCENTS — 3 dernières publications
================================================================ -->
<section class="nd-section">
    <div class="nd-container">
        <div class="nd-section__head">
            <div>
                <span class="nd-label">Le carnet</span>
                <h2 class="nd-section__title">Articles récents</h2>
            </div>
            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="nd-section__more">Tout voir →</a>
        </div>

        <div class="nd-posts-grid">
            <?php
            $loop = new WP_Query( array(
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ) );
            if ( $loop->have_posts() ) :
                while ( $loop->have_posts() ) : $loop->the_post();
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
                        <h3 class="nd-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <p class="nd-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20, '…' ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="nd-card__link">Lire l'article →</a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     GUIDES PHARES — 3 piliers
================================================================ -->
<section class="nd-section nd-section--alt">
    <div class="nd-container">
        <div class="nd-section__head">
            <div>
                <span class="nd-label">Nos sélections</span>
                <h2 class="nd-section__title">Nos guides phares</h2>
            </div>
        </div>

        <div class="nd-guides-grid">
            <?php
            $guides = array(
                array(
                    'tag'    => 'Matelas',
                    'titre'  => 'Meilleur matelas 2025',
                    'desc'   => 'Notre sélection des matelas les mieux notés selon votre morphologie et votre budget.',
                    'img'    => '[ photo : matelas ]',
                    'lien'   => home_url( '/category/matelas/' ),
                ),
                array(
                    'tag'    => 'Oreillers',
                    'titre'  => 'Meilleur oreiller 2025',
                    'desc'   => 'Côté, dos, ventre : trouvez l\'oreiller adapté à votre position de sommeil.',
                    'img'    => '[ photo : oreiller ]',
                    'lien'   => home_url( '/category/oreillers/' ),
                ),
                array(
                    'tag'    => 'Accessoires',
                    'titre'  => 'Couverture lestée 2025',
                    'desc'   => 'Poids, matière, entretien : tout ce qu\'il faut savoir avant d\'acheter.',
                    'img'    => '[ photo : couverture lestée ]',
                    'lien'   => home_url( '/category/accessoires/' ),
                ),
            );
            foreach ( $guides as $guide ) :
            ?>
            <a href="<?php echo esc_url( $guide['lien'] ); ?>" class="nd-guide-card">
                <div class="nd-guide-card__img">
                    <span><?php echo esc_html( $guide['img'] ); ?></span>
                </div>
                <div class="nd-guide-card__body">
                    <span class="nd-guide-card__tag"><?php echo esc_html( $guide['tag'] ); ?></span>
                    <h3><?php echo esc_html( $guide['titre'] ); ?></h3>
                    <p><?php echo esc_html( $guide['desc'] ); ?></p>
                    <span class="nd-guide-card__cta">Voir le guide →</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     SECTION CONFIANCE
================================================================ -->
<section class="nd-section nd-section--dark">
    <div class="nd-container">
        <div class="nd-trust__grid">
            <div class="nd-trust__item">
                <span class="nd-trust__icon">✓</span>
                <h4>Tests honnêtes</h4>
                <p>Chaque produit évalué selon des critères objectifs, sans sponsoring caché.</p>
            </div>
            <div class="nd-trust__item">
                <span class="nd-trust__icon">📚</span>
                <h4>Sources vérifiées</h4>
                <p>Recommandations basées sur des études scientifiques et avis d'experts.</p>
            </div>
            <div class="nd-trust__item">
                <span class="nd-trust__icon">🔄</span>
                <h4>Mise à jour régulière</h4>
                <p>Prix et disponibilités vérifiés régulièrement pour rester exacts.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

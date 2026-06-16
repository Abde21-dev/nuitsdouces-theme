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
            <a href="<?php echo esc_url(home_url('/category/matelas/')); ?>" class="nd-btn-cta">
                Voir le comparatif matelas →
            </a>
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="nd-hero__ghost">
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
            <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="nd-section__more">Tout voir →</a>
        </div>

        <div class="nd-posts-grid">
            <?php
            $loop = new WP_Query(array(
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            if ($loop->have_posts()) :
                while ($loop->have_posts()) : $loop->the_post();
                    $cats     = get_the_category();
                    $cat_name = $cats ? esc_html($cats[0]->name) : '';
            ?>
                    <article class="nd-card">
                        <div class="nd-card__img<?php echo ! has_post_thumbnail() ? ' nd-card__img--placeholder' : ''; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('nd-card'); ?>
                            <?php else : ?>
                                <span class="nd-placeholder-label">[ photo : <?php echo strtolower(esc_html(get_the_title())); ?> ]</span>
                            <?php endif; ?>
                        </div>
                        <div class="nd-card__body">
                            <?php if ($cat_name) : ?>
                                <span class="nd-card__cat"><?php echo $cat_name; ?></span>
                            <?php endif; ?>
                            <h3 class="nd-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="nd-card__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '…'); ?></p>
                            <a href="<?php the_permalink(); ?>" class="nd-card__link">Lire l'article →</a>
                        </div>
                    </article>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
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
                    'img'    => 113,
                    'lien'   => home_url('/category/matelas/'),
                ),
                array(
                    'tag'    => 'Oreillers',
                    'titre'  => 'Meilleur oreiller 2025',
                    'desc'   => 'Côté, dos, ventre : trouvez l\'oreiller adapté à votre position de sommeil.',
                    'img'    => 114,
                    'lien'   => home_url('/category/oreillers/'),
                ),
                array(
                    'tag'    => 'Accessoires',
                    'titre'  => 'Couverture lestée 2025',
                    'desc'   => 'Poids, matière, entretien : tout ce qu\'il faut savoir avant d\'acheter.',
                    'img'    => 115,
                    'lien'   => home_url('/category/accessoires/'),
                ),
            );
            foreach ($guides as $guide) :
            ?>
                <a href="<?php echo esc_url($guide['lien']); ?>" class="nd-guide-card">
                    <div class="nd-guide-card__img">
                        <?php echo wp_get_attachment_image($guide['img'], 'nd-card'); ?>
                    </div>


                    <div class="nd-guide-card__body">
                        <span class="nd-guide-card__tag"><?php echo esc_html($guide['tag']); ?></span>
                        <h3><?php echo esc_html($guide['titre']); ?></h3>
                        <p><?php echo esc_html($guide['desc']); ?></p>
                        <span class="nd-guide-card__cta">Voir le guide →</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================================================================
     POURQUOI NOUS FAIRE CONFIANCE
================================================================ -->
<section class="nd-section nd-section--alt nd-trust-section">
    <div class="nd-container">
        <div class="nd-trust-section__header">
            <span class="nd-label">Notre méthode</span>
            <h2 class="nd-trust-section__title">Pourquoi nous faire confiance</h2>
        </div>
        <div class="nd-trust-section__grid">

            <div class="nd-trust-card">
                <div class="nd-trust-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <h4>Tests honnêtes</h4>
                <p>On dort réellement sur les produits avant d'écrire. Pas de fiche recopiée, pas de complaisance.</p>
            </div>

            <div class="nd-trust-card">
                <div class="nd-trust-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                </div>
                <h4>Sources vérifiées</h4>
                <p>Nos conseils s'appuient sur des études du sommeil et l'avis de spécialistes, cités en clair.</p>
            </div>

            <div class="nd-trust-card">
                <div class="nd-trust-card__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <h4>Mise à jour régulière</h4>
                <p>Prix, disponibilités et sélections sont revus chaque mois. Une date de mise à jour sur chaque article.</p>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
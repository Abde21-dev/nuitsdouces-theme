<?php
/**
 * Template : Page d'accueil Nuits Douces
 * Remplace l'affichage par défaut des articles par une homepage éditoriale complète.
 */
get_header(); ?>

<div class="nd-homepage">

  <!-- ================================================================
       HERO — fond bleu nuit + motif, slogan, CTA
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
        <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="nd-hero__link">
          Tous nos guides
        </a>
      </div>
    </div>
  </section>

  <!-- ================================================================
       ARTICLES RÉCENTS — 3 dernières publications
  ================================================================ -->
  <section class="nd-section" id="nd-recent">
    <div class="nd-section__container">
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
                <?php the_post_thumbnail( 'medium_large' ); ?>
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
       GUIDES PHARES — 3 pilier pages
  ================================================================ -->
  <section class="nd-section nd-section--alt" id="nd-guides">
    <div class="nd-section__container">
      <div class="nd-section__head">
        <div>
          <span class="nd-label">Nos sélections</span>
          <h2 class="nd-section__title">Nos guides phares</h2>
        </div>
      </div>

      <div class="nd-guides-grid">
        <a href="<?php echo esc_url( home_url( '/category/matelas/' ) ); ?>" class="nd-guide-card">
          <div class="nd-guide-card__img nd-guide-card__img--placeholder">
            <span>[ photo : matelas ]</span>
          </div>
          <div class="nd-guide-card__body">
            <span class="nd-guide-card__tag">Matelas</span>
            <h3>Meilleur matelas 2025</h3>
            <p>Notre sélection selon votre morphologie et votre budget.</p>
            <span class="nd-guide-card__cta">Voir le guide →</span>
          </div>
        </a>

        <a href="<?php echo esc_url( home_url( '/category/oreillers/' ) ); ?>" class="nd-guide-card">
          <div class="nd-guide-card__img nd-guide-card__img--placeholder">
            <span>[ photo : oreiller ]</span>
          </div>
          <div class="nd-guide-card__body">
            <span class="nd-guide-card__tag">Oreillers</span>
            <h3>Meilleur oreiller 2025</h3>
            <p>Côté, dos, ventre : l'oreiller adapté à votre position.</p>
            <span class="nd-guide-card__cta">Voir le guide →</span>
          </div>
        </a>

        <a href="<?php echo esc_url( home_url( '/category/accessoires/' ) ); ?>" class="nd-guide-card">
          <div class="nd-guide-card__img nd-guide-card__img--placeholder">
            <span>[ photo : couverture lestée ]</span>
          </div>
          <div class="nd-guide-card__body">
            <span class="nd-guide-card__tag">Accessoires</span>
            <h3>Couverture lestée 2025</h3>
            <p>Poids, matière, entretien : tout avant d'acheter.</p>
            <span class="nd-guide-card__cta">Voir le guide →</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- ================================================================
       SECTION CONFIANCE — 3 arguments éditoriaux
  ================================================================ -->
  <section class="nd-section nd-trust">
    <div class="nd-section__container">
      <div class="nd-trust__grid">
        <div class="nd-trust__item">
          <div class="nd-trust__icon">✓</div>
          <h4>Tests honnêtes</h4>
          <p>Chaque produit évalué selon des critères objectifs, sans sponsoring caché.</p>
        </div>
        <div class="nd-trust__item">
          <div class="nd-trust__icon">📚</div>
          <h4>Sources vérifiées</h4>
          <p>Recommandations basées sur des études scientifiques et avis d'experts.</p>
        </div>
        <div class="nd-trust__item">
          <div class="nd-trust__icon">🔄</div>
          <h4>Mise à jour régulière</h4>
          <p>Prix et disponibilités vérifiés régulièrement pour rester exacts.</p>
        </div>
      </div>
    </div>
  </section>

</div><!-- .nd-homepage -->

<?php get_footer(); ?>

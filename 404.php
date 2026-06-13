<?php get_header(); ?>

<div class="nd-404">
    <div class="nd-404__code">404</div>
    <h1 class="nd-404__title">Page introuvable</h1>
    <p class="nd-404__desc">
        Cette page n'existe pas ou a été déplacée.<br>
        Retournez à l'accueil ou explorez nos guides.
    </p>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nd-btn-cta">
        ← Retour à l'accueil
    </a>
</div>

<?php get_footer(); ?>

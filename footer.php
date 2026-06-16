</div><!-- /.nd-main -->

<footer class="nd-footer" role="contentinfo">
    <div class="nd-footer__inner">

        <!-- Colonne marque -->
        <div class="nd-footer__brand">
            <a class="nd-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <svg width="22" height="22" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="14" cy="14" r="12" fill="#C8A45A"/>
                    <circle cx="18.5" cy="11.5" r="9.5" fill="#FFFFFF"/>
                    <circle cx="9"    cy="8"    r="1.3" fill="#C8A45A"/>
                </svg>
                <?php bloginfo( 'name' ); ?>
            </a>
            <p class="nd-footer__amazon">Notre site participe au programme Partenaire Amazon.</p>
            <p class="nd-footer__tagline">Tests honnêtes. Nuits réparées.</p>
        </div>

        <!-- Navigation légale -->
        <nav class="nd-footer__nav" aria-label="Liens légaux">
            <a href="<?php echo esc_url( home_url( '/mentions-legales/' ) ); ?>">Mentions légales</a>
            <a href="<?php echo esc_url( home_url( '/politique-de-confidentialite/' ) ); ?>">Confidentialité</a>
            <a href="<?php echo esc_url( home_url( '/page-affilie-amazon/' ) ); ?>">Affiliation Amazon</a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact</a>
        </nav>

        <!-- Copyright -->
        <p class="nd-footer__copy">
            © <?php echo date( 'Y' ); ?> nuitsdouces.fr — Tous droits réservés
        </p>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

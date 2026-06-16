<?php
/**
 * Nuits Douces — functions.php
 * Thème standalone pour nuitsdouces.fr
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// ===========================================================================
// 1. SUPPORT THÈME
// ===========================================================================
function nuitsdouces_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'navigation-widgets',
    ) );
    add_image_size( 'nd-card',    600, 380, true );
    add_image_size( 'nd-article', 1200, 500, true );

    register_nav_menus( array(
        'primary' => 'Menu principal',
        'footer'  => 'Menu footer',
    ) );

    load_theme_textdomain( 'nuitsdouces', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'nuitsdouces_theme_setup' );

// ===========================================================================
// 2. ENQUEUE STYLES & SCRIPTS
// ===========================================================================
function nuitsdouces_enqueue_assets() {
    // Google Fonts : Playfair Display + DM Sans + DM Mono
    wp_enqueue_style(
        'nuitsdouces-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,700&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap',
        array(), null
    );

    $uri = get_stylesheet_directory_uri();

    // CSS principal
    wp_enqueue_style(
        'nuitsdouces-style',
        $uri . '/assets/css/custom.css',
        array(), '3.0.2'
    );

    // JS navigation mobile
    wp_enqueue_script(
        'nuitsdouces-nav',
        $uri . '/assets/js/nav.js',
        array(), '1.0.0', true
    );

    // JS table des matières (articles uniquement)
    if ( is_single() ) {
        wp_enqueue_script(
            'nuitsdouces-toc',
            $uri . '/assets/js/toc.js',
            array(), '1.0.0', true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'nuitsdouces_enqueue_assets' );

// ===========================================================================
// 3. SHORTCODE [toc] — Table des matières automatique
// ===========================================================================
function nuitsdouces_toc_shortcode( $atts ) {
    $atts = shortcode_atts( array( 'title' => 'Dans cet article' ), $atts, 'toc' );
    ob_start(); ?>
    <div class="nd-toc" role="navigation" aria-label="Table des matières">
        <div class="nd-toc__header">
            <span class="nd-toc__icon" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                </svg>
            </span>
            <span class="nd-toc__title"><?php echo esc_html( $atts['title'] ); ?></span>
            <button class="nd-toc__toggle" aria-expanded="true" aria-label="Afficher/masquer le sommaire">
                <svg class="nd-toc__toggle-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="18 15 12 9 6 15"/>
                </svg>
            </button>
        </div>
        <nav class="nd-toc__nav">
            <p class="nd-toc__loading">Génération du sommaire…</p>
        </nav>
    </div>
    <?php return ob_get_clean();
}
add_shortcode( 'toc', 'nuitsdouces_toc_shortcode' );

// ===========================================================================
// 4. SHORTCODE [tableau_comparatif] — Tableau de comparaison produits
// ===========================================================================
// Usage :
//   [tableau_comparatif
//     produits="Emma Original, Tediber, Nectar"
//     criteres="Prix, Fermeté, Garantie"
//     valeurs="499€, 469€, 599€ | Moyen, Ferme, Doux | 10 ans, 10 ans, Forever"
//     meilleur="0"
//     liens="https://amzn.to/xxx, https://amzn.to/yyy, https://amzn.to/zzz"
//   ]

function nuitsdouces_tableau_comparatif_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'produits' => '', 'criteres' => '', 'valeurs' => '',
        'meilleur' => '0', 'liens' => '',
    ), $atts, 'tableau_comparatif' );

    $produits       = array_map( 'trim', explode( ',', $atts['produits'] ) );
    $criteres       = array_map( 'trim', explode( ',', $atts['criteres'] ) );
    $valeurs_lignes = array_map( 'trim', explode( '|', $atts['valeurs'] ) );
    $liens          = array_map( 'trim', explode( ',', $atts['liens'] ) );
    $meilleur_idx   = intval( $atts['meilleur'] );

    if ( empty( $produits[0] ) || empty( $criteres[0] ) ) {
        return '<p class="nd-error">Paramètres du tableau manquants. Vérifie les attributs <code>produits</code> et <code>criteres</code>.</p>';
    }

    ob_start(); ?>
    <div class="nd-comparison">
        <div class="nd-comparison__scroll">
            <table class="nd-comparison__table">
                <thead>
                    <tr>
                        <th class="nd-comparison__th nd-comparison__th--critere" scope="col">Critère</th>
                        <?php foreach ( $produits as $i => $produit ) : ?>
                            <th class="nd-comparison__th <?php echo ( $i === $meilleur_idx ) ? 'nd-comparison__th--winner' : ''; ?>" scope="col">
                                <?php if ( $i === $meilleur_idx ) : ?>
                                    <span class="nd-badge-winner">⭐ Meilleur choix</span>
                                <?php endif; ?>
                                <?php echo esc_html( $produit ); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $criteres as $ri => $critere ) : ?>
                        <tr>
                            <td class="nd-comparison__td nd-comparison__td--critere"><?php echo esc_html( $critere ); ?></td>
                            <?php
                            $valeurs_row = isset( $valeurs_lignes[ $ri ] )
                                ? array_map( 'trim', explode( ',', $valeurs_lignes[ $ri ] ) )
                                : array();
                            foreach ( $produits as $i => $produit ) :
                                $val = isset( $valeurs_row[ $i ] ) ? $valeurs_row[ $i ] : '—';
                            ?>
                                <td class="nd-comparison__td <?php echo ( $i === $meilleur_idx ) ? 'nd-comparison__td--winner' : ''; ?>">
                                    <?php echo esc_html( $val ); ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="nd-comparison__cta-row">
                        <td class="nd-comparison__td"></td>
                        <?php foreach ( $produits as $i => $produit ) :
                            $lien = ( isset( $liens[ $i ] ) && ! empty( $liens[ $i ] ) ) ? $liens[ $i ] : '#';
                        ?>
                            <td class="nd-comparison__td <?php echo ( $i === $meilleur_idx ) ? 'nd-comparison__td--winner' : ''; ?>">
                                <a href="<?php echo esc_url( $lien ); ?>"
                                   class="nd-btn-amazon <?php echo ( $i === $meilleur_idx ) ? 'nd-btn-amazon--primary' : 'nd-btn-amazon--secondary'; ?>"
                                   target="_blank" rel="nofollow noopener noreferrer">
                                    Voir sur Amazon
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="nd-comparison__disclaimer">
            * Notre site participe au programme Partenaire Amazon.
        </p>
    </div>
    <?php return ob_get_clean();
}
add_shortcode( 'tableau_comparatif', 'nuitsdouces_tableau_comparatif_shortcode' );

// ===========================================================================
// 5. NETTOYAGE
// ===========================================================================
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );

// Ajouter la classe "current" sur les éléments de menu actifs
add_filter( 'nav_menu_css_class', function( $classes, $item ) {
    if ( in_array( 'current-menu-item', $classes ) ) {
        $classes[] = 'nd-nav__item--active';
    }
    return $classes;
}, 10, 2 );

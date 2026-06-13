<?php
/**
 * Nuits Douces — functions.php
 * Thème enfant GeneratePress pour nuitsdouces.fr
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ---------------------------------------------------------------------------
// 1. ENQUEUE STYLES ET SCRIPTS
// ---------------------------------------------------------------------------

function nuitsdouces_enqueue_assets() {

    // Google Fonts : Playfair Display (titres serif) + DM Sans (corps) + DM Mono (labels)
    wp_enqueue_style(
        'nuitsdouces-fonts',
        'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,700&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Mono:wght@400;500&display=swap',
        array(),
        null
    );

    // CSS personnalisé — chargé après GeneratePress (generate-style est le handle réel de GP)
    wp_enqueue_style(
        'nuitsdouces-custom',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        array( 'generate-style' ),
        '2.0.2'
    );

    // JS : table des matières (chargé uniquement sur les articles)
    if ( is_single() ) {
        wp_enqueue_script(
            'nuitsdouces-toc',
            get_stylesheet_directory_uri() . '/assets/js/toc.js',
            array(),
            '1.0.0',
            true // chargé en pied de page
        );
    }
}
add_action( 'wp_enqueue_scripts', 'nuitsdouces_enqueue_assets' );


// ---------------------------------------------------------------------------
// 2. SHORTCODE [toc] — TABLE DES MATIÈRES AUTOMATIQUE
// ---------------------------------------------------------------------------
// Usage dans un article : [toc] ou [toc title="Dans cet article"]
//
// Le JavaScript (toc.js) lit les H2/H3 de l'article et remplit la nav.

function nuitsdouces_toc_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'title' => 'Dans cet article',
        ),
        $atts,
        'toc'
    );

    ob_start();
    ?>
    <div class="nd-toc" role="navigation" aria-label="Table des matières">
        <div class="nd-toc__header">
            <span class="nd-toc__icon" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="8" y1="6" x2="21" y2="6"/>
                    <line x1="8" y1="12" x2="21" y2="12"/>
                    <line x1="8" y1="18" x2="21" y2="18"/>
                    <line x1="3" y1="6" x2="3.01" y2="6"/>
                    <line x1="3" y1="12" x2="3.01" y2="12"/>
                    <line x1="3" y1="18" x2="3.01" y2="18"/>
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
    <?php
    return ob_get_clean();
}
add_shortcode( 'toc', 'nuitsdouces_toc_shortcode' );


// ---------------------------------------------------------------------------
// 3. SHORTCODE [tableau_comparatif] — TABLEAU DE COMPARAISON PRODUITS
// ---------------------------------------------------------------------------
// Usage :
//   [tableau_comparatif
//     produits="Emma Original, Tediber Hybrid, Nectar Premier"
//     criteres="Prix, Fermeté, Garantie, Livraison"
//     valeurs="499€, 469€, 599€ | Moyen, Ferme, Doux | 10 ans, 10 ans, Forever | Gratuite, Gratuite, Gratuite"
//     meilleur="0"
//     liens="https://amzn.to/xxx, https://amzn.to/yyy, https://amzn.to/zzz"
//   ]
//
// - "valeurs" : chaque ligne de critère séparée par |, chaque produit par ,
// - "meilleur" : index (0 = premier produit) mis en valeur avec badge

function nuitsdouces_tableau_comparatif_shortcode( $atts ) {
    $atts = shortcode_atts(
        array(
            'produits' => '',
            'criteres' => '',
            'valeurs'  => '',
            'meilleur' => '0',
            'liens'    => '',
        ),
        $atts,
        'tableau_comparatif'
    );

    $produits       = array_map( 'trim', explode( ',', $atts['produits'] ) );
    $criteres       = array_map( 'trim', explode( ',', $atts['criteres'] ) );
    $valeurs_lignes = array_map( 'trim', explode( '|', $atts['valeurs'] ) );
    $liens          = array_map( 'trim', explode( ',', $atts['liens'] ) );
    $meilleur_idx   = intval( $atts['meilleur'] );

    if ( empty( $produits[0] ) || empty( $criteres[0] ) ) {
        return '<p class="nd-error">Paramètres du tableau manquants. Vérifie les attributs <code>produits</code> et <code>criteres</code>.</p>';
    }

    ob_start();
    ?>
    <div class="nd-comparison">
        <div class="nd-comparison__scroll">
            <table class="nd-comparison__table">

                <!-- En-tête : noms des produits -->
                <thead>
                    <tr>
                        <th class="nd-comparison__th nd-comparison__th--critere" scope="col">Critère</th>
                        <?php foreach ( $produits as $i => $produit ) : ?>
                            <th class="nd-comparison__th <?php echo ( $i === $meilleur_idx ) ? 'nd-comparison__th--winner' : ''; ?>" scope="col">
                                <?php if ( $i === $meilleur_idx ) : ?>
                                    <span class="nd-badge-winner">Meilleur choix</span>
                                <?php endif; ?>
                                <?php echo esc_html( $produit ); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <!-- Corps : valeurs par critère -->
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

                    <!-- Ligne CTA -->
                    <tr class="nd-comparison__cta-row">
                        <td class="nd-comparison__td"></td>
                        <?php foreach ( $produits as $i => $produit ) :
                            $lien = ( isset( $liens[ $i ] ) && ! empty( $liens[ $i ] ) ) ? $liens[ $i ] : '#';
                        ?>
                            <td class="nd-comparison__td <?php echo ( $i === $meilleur_idx ) ? 'nd-comparison__td--winner' : ''; ?>">
                                <a
                                    href="<?php echo esc_url( $lien ); ?>"
                                    class="nd-btn-amazon <?php echo ( $i === $meilleur_idx ) ? 'nd-btn-amazon--primary' : 'nd-btn-amazon--secondary'; ?>"
                                    target="_blank"
                                    rel="nofollow noopener noreferrer"
                                >
                                    Voir sur Amazon
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>

            </table>
        </div>
        <p class="nd-comparison__disclaimer">
            * En tant que Partenaire Amazon, nous percevons une commission sur les achats éligibles, sans surcoût pour vous.
        </p>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'tableau_comparatif', 'nuitsdouces_tableau_comparatif_shortcode' );


// ---------------------------------------------------------------------------
// 4. NETTOYAGE DIVERS
// ---------------------------------------------------------------------------

// Supprimer l'emoji script WordPress (inutile pour un blog affiliation)
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Supprimer le lien vers le fichier XML-RPC (sécurité)
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );

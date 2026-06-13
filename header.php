<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="nd-header" role="banner">
    <div class="nd-header__inner">

        <!-- Logo -->
        <a class="nd-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?> — accueil">
            <svg class="nd-header__logo-icon" width="28" height="28" viewBox="0 0 28 28" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="14" cy="14" r="12" fill="#C8A45A"/>
                <circle cx="18.5" cy="11.5" r="9.5" fill="#FFFFFF"/>
                <circle cx="9"    cy="8"    r="1.3" fill="#C8A45A"/>
            </svg>
            <span class="nd-header__logo-text"><?php bloginfo( 'name' ); ?></span>
        </a>

        <!-- Navigation principale -->
        <nav class="nd-header__nav" id="nd-main-nav" role="navigation" aria-label="Menu principal">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nd-nav__list',
                'menu_id'        => 'nd-nav-list',
                'fallback_cb'    => 'nuitsdouces_fallback_menu',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'link_before'    => '',
                'link_after'     => '',
            ) );
            ?>
        </nav>

        <!-- Bouton burger mobile -->
        <button class="nd-header__burger" id="nd-burger" aria-controls="nd-main-nav" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="nd-burger__line"></span>
            <span class="nd-burger__line"></span>
            <span class="nd-burger__line"></span>
        </button>

    </div>
</header>

<div class="nd-main" id="nd-content">
<?php

/**
 * Menu de secours si aucun menu n'est configuré dans WordPress admin.
 * Affiche les catégories principales.
 */
function nuitsdouces_fallback_menu() {
    $cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 5 ) );
    if ( ! $cats ) {
        echo '<ul class="nd-nav__list"><li class="nd-nav__item"><a class="nd-nav__link" href="' . esc_url( home_url( '/' ) ) . '">Accueil</a></li></ul>';
        return;
    }
    echo '<ul class="nd-nav__list">';
    foreach ( $cats as $cat ) {
        echo '<li class="nd-nav__item"><a class="nd-nav__link" href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></li>';
    }
    echo '</ul>';
}

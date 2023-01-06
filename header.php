<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header>
        <div class="container-narrow">
            <div id="shop-link__container">
                <?php $shop_link = get_field('le_shop', 'option');
                $shop_link_target = $shop_link['target'] ? $shop_link['target'] : '_self';
                ?>
                <a href="<?= esc_url($shop_link['url']); ?>" target="<?= esc_attr($shop_link_target); ?>" class="shop-link">
                    <span>Aller vers</span>
                    <span class="le-shop">Le <span class="shop">shop</span></span>
                </a>
            </div>
            <?php if (have_rows('menu_gauche', 'option')) : ?>
                <nav id="left-nav">
                    <ul class="nav-container">
                        <?php while (have_rows('menu_gauche', 'option')) : the_row(); ?>
                            <li>
                                <?php $lien_gauche = get_sub_field('lien');
                                $target = $lien_gauche['target'] ? $lien_gauche['target'] : '_self';
                                ?>
                                <a href="<?= esc_url($lien_gauche['url']); ?>" target="<?= esc_attr($target) ?>"><?= esc_html($lien_gauche['title']); ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            <div id="logo">
                <div class="background"></div>
                <a href="<?= esc_url(home_url('/')); ?>">
                    <?php $logo = get_field('logo', 'option') ?>
                    <img src="<?= esc_url($logo['url']) ?>" alt="<?= esc_attr($logo['alt']); ?>">
                </a>
            </div>
            <?php if (have_rows('menu_droite', 'option')) : ?>
                <nav id="right-nav">
                    <ul class="nav-container">
                        <?php while (have_rows('menu_droite', 'option')) : the_row(); ?>
                            <li>
                                <?php $lien_droite = get_sub_field('lien');
                                $target = $lien_droite['target'] ? $lien_droite['target'] : '_self';
                                ?>
                                <a href="<?= esc_url($lien_droite['url']); ?>" target="<?= esc_attr($target) ?>"><?= esc_html($lien_droite['title']); ?></a>
                            </li>
                        <?php endwhile; ?>
                        <li class="search-container">
                            <form role="search" method="get" id="search-header" class="search-form" action="<?php echo home_url('/'); ?>">
                                <label id="search-label">
                                    <span class="screen-reader-text">Rechercher</span>
                                    <input type="search" class="search-field" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
                                </label>
                                <div class="submit-container">
                                    <button type="submit" id="search-submit">
                                        <img src="<?= get_template_directory_uri(); ?>/img/search-icons.svg" alt="Rechercher sur la site">
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            <div class="mobile-menu-nav">
                <div class="menu-nav-container" id="click-menu">
                    <div class="menu-nav-bar"></div>
                    <div class="menu-nav-bar"></div>
                    <div class="menu-nav-bar"></div>
                </div>
                <nav id="nav-mobile">
                    <ul>
                        <?php if (have_rows('menu_gauche', 'option')) :
                            while (have_rows('menu_gauche', 'option')) : the_row(); ?>
                                <li>
                                    <?php $lien_gauche = get_sub_field('lien');
                                    $target = $lien_gauche['target'] ? $lien_gauche['target'] : '_self';
                                    ?>
                                    <a href="<?= esc_url($lien_gauche['url']); ?>" target="<?= esc_attr($target) ?>"><?= esc_html($lien_gauche['title']); ?></a>
                                </li>
                        <?php endwhile;
                        endif; ?>
                        <?php if (have_rows('menu_droite', 'option')) :
                            while (have_rows('menu_droite', 'option')) : the_row(); ?>
                                <li>
                                    <?php $lien_gauche = get_sub_field('lien');
                                    $target = $lien_gauche['target'] ? $lien_gauche['target'] : '_self';
                                    ?>
                                    <a href="<?= esc_url($lien_gauche['url']); ?>" target="<?= esc_attr($target) ?>"><?= esc_html($lien_gauche['title']); ?></a>
                                </li>
                        <?php endwhile;
                        endif; ?>
                        <li class="search-container">
                            <form role="search" method="get" id="search-header" class="search-form" action="<?php echo home_url('/'); ?>">
                                <label id="search-label">
                                    <span class="screen-reader-text">Rechercher</span>
                                    <input type="search" class="search-field" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label') ?>" />
                                </label>
                                <div class="submit-container">
                                    <button type="submit" id="search-submit">
                                        <img src="<?= get_template_directory_uri(); ?>/img/search-icons.svg" alt="Rechercher sur la site">
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
    </header>
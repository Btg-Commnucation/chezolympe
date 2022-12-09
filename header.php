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
                    </ul>
                </nav>
            <?php endif; ?>
    </header>
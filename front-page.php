<?php get_header(); ?>

<main id="front-page">
    <section class="hero-banner">
        <div class="leaf-hero"></div>
        <div class="left-side">
            <div class="container-left">
                <h1><?php the_title(); ?></h1>
                <div class="slogan__container-left">
                    <div class="content"><?php the_content(); ?></div>
                    <img src="<?= get_template_directory_uri(); ?>/img/logo-blanc-simple.svg" alt="Logo Chez Olympe">
                </div>
            </div>
        </div>
        <div class="separator">
            <div class="line"></div>
            <div class="dot"></div>
        </div>
        <div class="right-side">
            <?php $image_haut_page = get_field('image_haut_de_page'); ?>
            <img src="<?= $image_haut_page ? esc_url($image_haut_page['url']) : get_template_directory_uri() . '/img/Photo-top.jpg' ?>" alt="<?= $image_haut_page ? esc_attr($image_haut_page['alt']) : 'Photo d\'une femme se cachant la poitrine' ?>">
        </div>
    </section>
</main>

<?php get_footer(); ?>
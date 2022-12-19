<?php
get_header();
?>

<main id="page-olympe">
    <section class="hero-banner">
        <div class="leaf">
            <img src="<?= get_template_directory_uri(); ?>/img/top-leaf.svg" alt="Feuille de vigne">
        </div>
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php $logo_small = get_field('logo_petit'); ?>
            <img src="<?= $logo_small ? esc_url($logo_small['url']) : get_template_directory_uri() . '/img/logo-blanc-simple.svg'; ?>" alt="" <?= $logo_small ? esc_attr($logo_small['alt']) : 'Logo Olympe en blanc'; ?>>
            <p><?php the_field('slogan_page') && the_field('slogan_page'); ?></p>
        </div>
    </section>
    <article>
        <div class="container-large">
            <?php the_content(); ?>
            <div class="leaf-article">
                <img src="<?= get_template_directory_uri(); ?>/img/leaf-article.svg" alt="Feuille de vigne">
            </div>
        </div>
    </article>
    <section class="bottom-page">
        <div class="container">
            <h3><?php the_field('titre_bas_de_page'); ?></h3>
            <p><?php the_field('texte_bas_de_page'); ?></p>
            <?php if (have_rows('lien_bas_de_page')) : ?>
                <div class="liens">
                    <?php while (have_rows('lien_bas_de_page')) : the_row();
                        $lien = get_sub_field('lien');
                        $lien_target = $lien['target'] ? $lien['target'] : '_self';
                    ?>
                        <a href="<?= esc_url($lien['url']); ?>" target="<?= esc_attr($lien_target) ?>"><?= esc_html($lien['title']); ?></a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_template_part('parts/bottom');
get_footer();
?>
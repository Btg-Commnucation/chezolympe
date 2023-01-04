<?php
/*
* Template Name: Guide Conseils
*/
get_header();
?>

<main id="guides-conseils">
    <section class="hero-banner">
        <div class="leaf">
            <img src="<?= get_template_directory_uri(); ?>/img/top-leaf.svg" alt="Feuille de vigne">
        </div>
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </section>
    <section class="specifiques">
        <div class="container-large">
            <h2><?php get_field('titre_fond_peau') ? the_field('titre_fond_peau') : 'Conseils Spécifiques'; ?></h2>
            <p><?php get_field('texte_fond_peau') ? the_field('texte_fond_peau') : 'Vous recherchez des conseils et vous appartenez a une des catégories ci-dessous, pas de panique ! Nous sommes là pour vous accompagner dans la recherche de votre plaisir quelques soient vos spécificités, parce que nous sommes toutes uniques.' ?></p>
            <?php if (have_rows('lien_fond_peau')) : ?>
                <div class="lien-specifiques">
                    <?php while (have_rows('lien_fond_peau')) : the_row();
                        $lien = get_sub_field('lien');
                        $lien_target = $lien['target'] ? $lien['target'] : '_self';
                    ?>
                        <a href="<?= esc_url($lien['url']); ?>" target="<?= esc_attr($lien_target) ?>"><?= esc_html($lien['title']); ?></a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('parts/slider'); ?>
</main>

<?php
get_template_part('parts/bottom');
get_footer();
?>
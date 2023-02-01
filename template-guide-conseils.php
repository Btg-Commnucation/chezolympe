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
                    <?php while (have_rows('lien_fond_peau')) : the_row(); ?>
                        <a class="popup-link" href="#"><?php the_sub_field('titre'); ?></a>
                        <?php if (get_sub_field('contenu_popup')) : ?>
                            <div class="popup-background">
                                <div class="popup">
                                    <div class="close-popup">
                                        <img src="<?= get_template_directory_uri(); ?>/img/close-popup.svg" alt="Fermer le popup">
                                    </div>
                                    <?php the_sub_field('contenu_popup'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('parts/slider'); ?>
    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    data: null,
                }
            }
        })
    </script>
</main>

<?php
get_template_part('parts/bottom');
get_footer();
?>
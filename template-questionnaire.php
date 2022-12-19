<?php
/*
* Template Name: Questionnaire
*/

get_header();
?>

<main id="questionnaire">
    <section class="hero-banner">
        <div class="leaf">
            <img src="<?= get_template_directory_uri(); ?>/img/top-leaf.svg" alt="Feuille de vigne">
        </div>
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </section>
    <article>
        <div class="container">
            <h2><?php the_field('titre_grandes_familles'); ?></h2>
            <?php if (have_rows('les_familles')) :
                $i = 0;
            ?>
                <div class="familles-btn">
                    <?php while (have_rows('les_familles')) : the_row(); ?>
                        <button class="btn btn-primary" id="<?= $i; ?>"><?= get_sub_field('texte_bouton'); ?></button>
                        <?php $i++; ?>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <?php if (have_rows('les_familles')) :
                $j = 0;
            ?>
                <div class="familles">
                    <?php while (have_rows('les_familles')) : the_row(); ?>
                        <div class="famille" id="<?= $j ?>">
                            <?php $image_famille = get_sub_field('image'); ?>
                            <img src="<?= esc_url($image_famille['url']); ?>" alt="<?= esc_attr($image_famille['alt']); ?>">
                            <p><?php the_sub_field('texte'); ?></p>
                        </div>
                    <?php $j++;
                    endwhile; ?>
                </div>
            <?php endif; ?>
            <div class="questionnaire-content">
                <?php the_field('contenu'); ?>
            </div>
        </div>
    </article>
</main>

<?php
get_template_part('parts/bottom');
get_footer();
?>
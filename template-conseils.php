<?php
/*
* Template Name: Conseils
*/
get_header();
?>

<main id="conseils">
    <section class="hero-banner">
        <div class="container">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
        </div>
    </section>
    <?php if (have_rows('conseils')) : ?>
        <article class="conseils-article">
            <img src="<?= get_template_directory_uri() ?>/img/leaf-black.svg" alt="Feuille noir" class="feuille-noire">
            <?php while (have_rows('conseils')) : the_row(); ?>
                <div class="conseil">
                    <div class="container">
                        <h2>
                            <span><?php the_sub_field('numero'); ?></span>
                            <span><?php the_sub_field('titre'); ?></span>
                        </h2>
                        <div class="content">
                            <div class="text-container">
                                <?php the_sub_field('texte'); ?>
                            </div>
                            <?php $image = get_sub_field('image'); ?>
                            <img class="illustration" src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>">
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </article>
    <?php endif; ?>
    <section class="bottom__leshop">
        <div class="container">
            <p><?php the_field('phrase_daccroche'); ?></p>
            <?php $lien = get_field('le_shop', 'option');
            if ($lien) :
                $lien_target = $lien['target'] ? $lien['target'] : '_self';
            ?>
                <a href="<?= esc_url($lien['url']); ?>" target="<?= esc_attr($lien_target); ?>"><?= esc_html($lien['title']); ?></a>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_template_part('parts/bottom');
get_footer(); ?>
<article class="slider-splide">
    <div class="container-slider">
        <img src="<?= get_template_directory_uri(); ?>/img/leaf-rotate.svg" alt="Feuille retournée" class="feuille-top">
        <img src="<?= get_template_directory_uri(); ?>/img/leaf-bottom-slider.svg" alt="Feuille retournée" class="feuille-bottom">
        <h3><?php the_field('titre_slider'); ?></h3>
        <p><?php the_field('texte_slider'); ?></p>
        <?php if (have_rows('slider')) : ?>
            <div class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while (have_rows('slider')) : the_row();
                            $image = get_sub_field('image');
                            $lien_quest = get_sub_field('lien');
                            $lien_quest_target = $lien_quest['target'] ? $lien_quest['target'] : '_self';
                        ?>
                            <li class="splide__slide">
                                <a href="<?= esc_url($lien_quest['url']) ?>" target="<?= esc_attr($lien_quest_target); ?>">
                                    <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>">
                                    <span><?= esc_html($lien_quest['title']); ?></span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <ul class="splide__pagination"></ul>
            </div>
        <?php endif; ?>
    </div>
</article>
<section id="shop-categories">
    <div class="container-narrow">
        <h2><?php the_field('titre_categories'); ?></h2>
        <p><?php the_field('texte_categories') ?></p>
        <?php if (have_rows('categories')) : ?>
            <ul class="categories-container">
                <?php while (have_rows('categories')) : the_row();
                    $image = get_sub_field('image');
                    $lien = get_sub_field('categorie');
                    $lien_target = $lien['target'] ? $lien['target'] : "_self";
                ?>
                    <li class="category">
                        <a href="<?= esc_url($lien['url']); ?>" target="<?= esc_attr($lien_target) ?>">
                            <?php if ($image) : ?>
                                <div class="circle-img">
                                    <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>">
                                    <div class="category__background"></div>
                                </div>
                            <?php endif; ?>
                            <span><?= esc_html($lien['title']); ?></span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
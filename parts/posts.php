<?php $args = array(
    'post_type' => 'post',
    'posts_per_page' => 2,
    'orderby' => 'date',
    'order' => 'ASC'
);


$query = new WP_Query($args);

if ($query->have_posts()) :
?>
    <section class="posts">
        <div class="container">
            <h2><?php the_field('titre_news'); ?></h2>
            <div><?php the_field('texte_news'); ?></div>
            <?php $lien_blog = get_field('le_blog', 'option');
            $lien_blog_target = $lien_blog['target'] ? $lien_blog['target'] : '_self';
            ?>
            <div class="posts__container">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <div class="post">
                        <div class="post__image">
                            <img src="<?= get_the_post_thumbnail_url(); ?>" alt="<?= get_the_title(); ?>">
                        </div>
                        <div class="post__content">
                            <h3><?php the_title(); ?></h3>
                            <p><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="post__link">Lire la suite</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <a href="<?= esc_url($lien_blog['url']); ?>" target="<?= esc_attr($lien_blog_target) ?>" class="blog-link">
                <?= esc_html($lien_blog['title']); ?>
            </a>
        </div>
    </section>
<?php endif; ?>
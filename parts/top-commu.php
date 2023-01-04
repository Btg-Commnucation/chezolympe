<section id="top-commu" v-if="!isLoading">
    <div class="container">
        <h2><?php the_field('titre_top_communaute'); ?></h2>
        <p><?php the_field('texte_top_communaute'); ?></p>
        <ul class="product-list">
            <li v-for="product in filteredPorduct" :index="product.id">
                <div class="product-container" v-if="product.name.length > 0">
                    <a :href="setProductLink(product)" target="_blank" title="Se rendre sur la page du produit" class="product-image">
                        <img :src="setImageUrl(product)" :alt="product.name">
                    </a>
                    <div class="product-content">
                        <h4><a :href="setProductLink(product)" target="_blank">{{ product.name }}</a></h4>
                    </div>
                </div>
                <strong class="product-price" v-if="product.name.length > 0">{{product.price.slice(0, 5)}} €</strong>
            </li>
        </ul>
        <?php $lien_shop = get_field('le_shop', 'option');
        $lien_shop_target = $lien_shop['target'] ? $lien_shop['target'] : '_self';
        ?>
        <a href="<?= esc_url($lien_shop['url']); ?>" target="<?= esc_attr($lien_shop_target) ?>" class="shop-link">
            <?= esc_html($lien_shop['title']); ?>
        </a>
    </div>
</section>
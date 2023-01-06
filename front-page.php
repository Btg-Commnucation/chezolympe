<?php
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3@leshop-chezolympe.btg-dev.com/api/products?display=full&output_format=JSON",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);


get_header(); ?>

<main id="front-page">
    <div id="white-opener"></div>
    <section class="hero-banner">
        <div class="leaf-hero"></div>
        <div class="leaf-bottom-image"></div>
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
    <?php get_template_part('parts/shop-categories');
    get_template_part('parts/top-commu');
    get_template_part('parts/slider');
    get_template_part('parts/posts'); ?>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    data: null,
                    frontPageProducts: [],
                    key: 'WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3',
                    isLoading: true
                }
            },
            computed: {
                filteredPorduct() {
                    return this.frontPageProducts.filter(product => {
                        if (product.name.length > 0) {
                            return product
                        }
                    })
                }
            },
            async mounted() {
                await this.getData();
                this.isLoading = false;
            },
            methods: {
                getData() {
                    this.data = <?php echo json_encode($response); ?>;
                    this.data = JSON.parse(this.data)
                    this.data.products.map(product => {
                        if (product.id_category_default == "2") {
                            this.frontPageProducts.push(product);
                        }
                    })
                },
                setProductLink(product) {
                    if (product.product_type === "combinations") {
                        return `https://leshop-chezolympe.btg-dev.com/accueil/${product.id}-${Number(product.associations.combinations[0].id)}-${product.link_rewrite}.html`
                    } else {
                        return `https://leshop-chezolympe.btg-dev.com/accueil/${product.id}-${product.link_rewrite}.html`
                    }
                },
                setImageUrl(product) {
                    return `https://leshop-chezolympe.btg-dev.com/api/images/products/${Number(product.id)}/${Number(product.id_default_image)}/?ws_key=${this.key}`;
                }
            }
        }).mount('#front-page')
    </script>
</main>

<?php
get_template_part('parts/bottom');
get_footer(); ?>
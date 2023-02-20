<?php
$token_prestashop = get_field('token_prestashop', 'option');
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://leshop.chezolympe.com/api/products?ws_key=' . $token_prestashop  . '&display=full&output_format=JSON',
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
                    key: null,
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
                    this.key = <?php echo json_encode($token_prestashop); ?>;
                    this.data = JSON.parse(this.data);
                    this.data.products.map(product => {
                        if (product.active === "1") {
                            for (const category of product.associations.categories) {
                                if (category.id === "2") {
                                    this.frontPageProducts.push(product);
                                }
                            }
                        }
                    })
                },
                setProductLink(product) {
                    if (typeof product.link_rewrite === 'object') {
                        return `https://leshop.chezolympe.com/accueil/${product.id}-${product.link_rewrite[0].value}.html`
                    } else {
                        return `https://leshop.chezolympe.com/accueil/${product.id}-${product.link_rewrite}.html`
                    }
                },
                setImageUrl(product) {
                    return `https://leshop.chezolympe.com/api/images/products/${Number(product.id)}/${Number(product.id_default_image)}/?ws_key=${this.key}`;
                },
                showPrice({
                    price,
                    id_tax_rules_group
                }) {
                    if (id_tax_rules_group === "1") {
                        let priceTt = String(Number(price) * 1.2)
                        // Si priceTt à plus de 2 chiffres après la virgule, fait un +1 sur deuxième chiffre après la virgule et n'affiche que 2 chiffre après la virgule
                        if (priceTt.split('.')[1].length > 2) {
                            const price = Number(priceTt) + 0.01;
                            const priceString = price.toFixed(2); // convertit le nombre en chaîne avec deux chiffres après la virgule
                            const priceArray = priceString.split('.'); // sépare la chaîne en un tableau de deux éléments
                            const firstPart = priceArray[0];
                            const secondPart = priceArray[1] || '0';
                            return `${firstPart}.${secondPart.slice(0, 2)}`;
                        } else {
                            const result = priceTt.slice(0, 5);
                            if (result.length < 5) {
                                return result + '0'
                            }
                            return result
                        }
                    } else {
                        let priceTt = String(Number(price) * 1.055)
                        if (priceTt.split('.')[1].length > 2) {
                            const price = Number(priceTt) + 0.01;
                            const priceString = price.toFixed(2); // convertit le nombre en chaîne avec deux chiffres après la virgule
                            const priceArray = priceString.split('.'); // sépare la chaîne en un tableau de deux éléments
                            const firstPart = priceArray[0];
                            const secondPart = priceArray[1] || '0';
                            return `${firstPart}.${secondPart.slice(0, 2)}`;
                        } else {
                            const result = priceTt.slice(0, 5);
                            if (result.length < 5) {
                                return result + '0'
                            }
                            return result
                        }
                    }
                }
            }
        }).mount('#front-page')
    </script>
</main>

<?php
get_template_part('parts/bottom');
get_footer(); ?>
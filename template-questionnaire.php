<?php
/*
* Template Name: Questionnaire
*/

get_header();

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3@leshop-chezolympe.btg-dev.com/api/products?display=full&output_format=JSON",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
$products_images = [];
$products = is_array(json_decode($response)->products) ? json_decode($response)->products : array(json_decode($reponse)->products);
if ($products) :
    foreach ($products as $product) {
        $image_request = curl_init();
        curl_setopt_array($image_request, [
            CURLOPT_URL => "https://WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3@leshop-chezolympe.btg-dev.com/api/images/products/" . $product->id . "?display=full",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ]);
        $image_response = curl_exec($image_request);
        $image_err = curl_error($image_request);

        if ($image_response) {
            $products_images[] = simplexml_load_string($image_response);
        } else {
            var_dump($image_err);
        }
    }


endif;

$request = curl_init();

curl_setopt_array($request, [
    CURLOPT_URL => "https://WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3@leshop-chezolympe.btg-dev.com/api/product_feature_values?display=full&output_format=JSON",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$newResult = curl_exec($request);
$newErr = curl_error($request);

curl_close($request);


class Question
{
    public $question;
    public $answers;
    public $value;
}

$question_list = [];
$answers_list = [];

if (have_rows('questions')) :
    while (have_rows('questions')) : the_row();
        $question_object = new Question();
        $question_object->question = get_sub_field('question');
        if (have_rows('reponses')) :
            while (have_rows('reponses')) : the_row();
                $question_object->answers[] = get_sub_field('reponse');
                $question_object->value[] = get_sub_field('valeur');
            endwhile;
        endif;
        $question_list[] = $question_object;
    endwhile;

endif;

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
    <template v-if="!isLoading">
        <section class="question-part">
            <div class="container">
                <h2>{{ allAnswers ? 'Voici des produits qui te correspondent' : 'Questionnaire'}}</h2>
                <div class="questions-container" v-if="!allAnswers">
                    <div class="question" v-for="question in data.slice(sliceA, sliceB)">
                        <h3>{{ question.question  }}</h3>
                        <form action="" class="choices">
                            <div class="choice" v-for="(answer, index) in question.answers">
                                <input type="radio" :id="question.value[index]" :name="question.question" :value="question.value[index]" v-model="result">
                                <label :for="question.value[index]">{{ answer }}</label>
                            </div>
                        </form>
                    </div>
                    <button class="validate" @click="handleClick()">Valider</button>
                </div>
                <div class="result" v-if="allAnswers">
                    <div class="loading" v-if="!responseIsReady">
                        <strong>Nous recherchons les meilleurs produit pour vous</strong>
                        <p>Merci de patienter quelques secondes !</p>
                        <div class="lds-ripple">
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="product-list" v-if="responseIsReady">
                        <p class="texte-return-product">Cela semble répondre à ton profil. Nous t'encourageons cependant à bien regarder les fiches-produits pour t'assurer que cela répond à tes attentes.</p>
                        <ul class="product" v-if="products.length > 0">
                            <li v-for="(product, index) in products">
                                <div class="product-container">
                                    <a :href="setProductLink(index)" target="_blank" title="Se rendre sur la page du produit" class="product-image">
                                        <img :src="setUrl(imageIds[index].id, imageIds[index].imageId)" :alt="product.name">
                                    </a>
                                    <div class="product-content">
                                        <h4><a :href="setProductLink(index)" target="_blank">{{ product.name }}</a></h4>
                                    </div>
                                </div>
                                <strong class="product-price">{{product.price.slice(0, 5)}} €</strong>
                            </li>
                        </ul>
                        <div class="no-result" v-else>
                            <h5>Oups... Désolé</h5>
                            <p>Il semblerait qu'aucun produit ne correspond à votre recherche, vous pouvez toujours venir visiter notre boutique ou repassez plus tard</p>
                            <div class="button">
                                <a class="btn-accueil" href="<?= home_url('/') ?>">Accueil</a>
                                <?php $le_shop = get_field('le_shop', 'option');
                                $le_shop_target = $le_shop['target'] ? $le_shop['target'] : '_self';
                                if ($le_shop) : ?>
                                    <a class="btn-shop" href="<?= esc_url($le_shop['url']); ?>" target="<?= esc_attr($le_shop_target) ?>">
                                        <?= esc_html($le_shop['title']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    data: null,
                    sliceA: 0,
                    sliceB: 1,
                    step: 1,
                    isLoading: true,
                    result: null,
                    results: [],
                    apiResponse: null,
                    featureValues: [],
                    allAnswers: false,
                    responseIsReady: false,
                    products: null,
                    image: null,
                    imageIds: [],
                    key: 'WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3@',
                    productsLink: [],
                    productMatchingValues: [],
                }
            },
            async mounted() {
                await this.getData();
                this.isLoading = false;
            },
            methods: {
                getData() {
                    this.data = <?= json_encode($question_list); ?>;
                    this.image = <?= json_encode($products_images); ?>;
                    this.apiResponse = <?= $response ? json_encode($response) : json_encode($err); ?>;
                    this.apiResponse = JSON.parse(this.apiResponse);
                    this.featureValues = <?= $newResult ? json_encode($newResult) : json_encode($newErr); ?>;
                    this.featureValues = JSON.parse(this.featureValues);
                },
                async handleClick() {
                    this.results.push(this.result);
                    this.result = null;
                    if (this.sliceB < this.data.length) {
                        this.sliceA = this.sliceA + this.step;
                        this.sliceB = this.sliceB + this.step;
                    } else if (this.sliceB === this.data.length) {
                        this.allAnswers = true;
                        await this.setListFeature();
                        this.setProducts();
                        setTimeout(() => {
                            this.responseIsReady = true;
                        }, 1500)
                    }
                },
                setListFeature() {
                    let tempArray = [];
                    for (const element of this.results) {
                        tempArray.push(element.replaceAll('-', ' '));
                    }
                    this.results = tempArray;
                    let arrayIdValues = [];
                    for (const element of this.featureValues.product_feature_values) {
                        for (const value of this.results) {
                            if (value === element.value.toLowerCase()) {
                                arrayIdValues.push({
                                    id: String(element.id),
                                    name: element.value
                                });
                            }
                        }
                    }
                    this.productMatchingValues = [...new Set(arrayIdValues)]
                },
                setProducts() {
                    let tempArray = [];
                    for (const element of this.apiResponse.products) {
                        if (element.associations.product_features) {
                            if (this.productMatchingValues.every(value => element.associations.product_features.some(element => element.id_feature_value === value.id))) {
                                tempArray.push(element);
                            }

                        }
                    }
                    this.products = tempArray;
                    this.setImageIds();
                },
                setImageIds() {
                    let tempArray = [];
                    let tempLink = [];
                    for (const product of this.products) {
                        if (product.product_type === "combinations") {
                            tempLink.push({
                                id: product.id,
                                link: product.link_rewrite,
                                combination: product.associations.combinations[0]
                            })
                        } else {
                            tempLink.push({
                                id: product.id,
                                link: product.link_rewrite
                            })
                        }
                        this.productsLink = [...new Set(tempLink)]
                        for (const image of this.image) {
                            if (product.id === Number(image.image['@attributes'].id)) {
                                tempArray.push({
                                    id: image.image['@attributes'].id,
                                    imageId: image.image.declination[0]['@attributes'].id
                                })
                            }
                        }
                    }
                    this.imageIds = [...new Set(tempArray)];
                },
                setUrl(id, imageId) {
                    return `https://${this.key}leshop-chezolympe.btg-dev.com/api/images/products/${Number(id)}/${Number(imageId)}`;
                },
                setProductLink(index) {
                    if (this.productsLink[index].combination) {
                        return `https://leshop-chezolympe.btg-dev.com/${this.productsLink[index].id}-${this.productsLink[index].combination.id}-${this.productsLink[index].link}.html`;
                    } else {
                        return `https://leshop-chezolympe.btg-dev.com/${this.productsLink[index].id}-${this.productsLink[index].link}.html`;
                    }
                }
            }
        }).mount('#questionnaire');
    </script>
</main>


<?php
get_template_part('parts/bottom');
get_footer();
?>
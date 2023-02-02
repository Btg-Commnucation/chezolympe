<?php
/*
* Template Name: Questionnaire
*/

get_header();
$token_prestashop = get_field('token_prestashop', 'option');

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://leshop.chezolympe.com/api/products?ws_key=' . $token_prestashop . '&display=full&output_format=JSON',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "GET",
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$request = curl_init();

curl_setopt_array($request, [
    CURLOPT_URL => 'https://leshop.chezolympe.com/api/product_feature_values?ws_key=' . $token_prestashop . '&display=full&output_format=JSON',
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
        <?php $image_questionnaire = get_field('image_questionnaire'); ?>
        <?php if ($image_questionnaire) : ?>
            <img src="<?= esc_url($image_questionnaire['url']); ?>" alt="<?= esc_attr($image_questionnaire['alt']); ?>" class="hero-banner-img" />
        <?php endif; ?>
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
                <h2 v-if="!allAnswers">Questionnaire</h2>
                <h2 v-else="allAsnwsers && products.length > 0">{{ products.length > 0 ? 'Voici les produits qui semblent te correspondre' : noResponseTitle }}</h2>
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
                        <p class="texte-return-product" v-if="products.length > 0">Cela semble répondre à ton profil. Nous t'encourageons cependant à bien regarder les fiches-produits pour t'assurer que cela répond à tes attentes.</p>
                        <p v-else><?php the_field('texte_aucun_article'); ?></p>
                        <ul class="product" v-if="products.length > 0">
                            <li v-for="(product, index) in products">
                                <div class="product-container">
                                    <a :href="setProductLink(product)" target="_blank" title="Se rendre sur la page du produit" class="product-image">
                                        <img :src="setUrl(product)" :alt="product.name">
                                    </a>
                                    <div class="product-content">
                                        <h4 v-if="typeof product.name === 'object'"><a :href="setProductLink(product)" target="_blank">{{ product.name[0].value }}</a></h4>
                                        <h4 v-else><a :href="setProductLink(product)" target="_blank">{{ product.name }}</a></h4>
                                    </div>
                                </div>
                                <strong class="product-price">{{product.price.slice(0, 5)}} €</strong>
                            </li>
                        </ul>
                        <div class="no-result" v-else>
                            <div class="button">
                                <a class="btn-accueil" href="#" @click="handleReload()">Recommencer</a>
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
                    key: null,
                    productsLink: [],
                    productMatchingValues: [],
                    noResponseTitle: null,
                    associationsProducts: [],
                }
            },
            async mounted() {
                await this.getData();
                this.isLoading = false;
            },
            methods: {
                handleReload() {
                    window.location.reload();
                },
                async getData() {
                    this.data = <?= json_encode($question_list); ?>;
                    this.key = <?= json_encode($token_prestashop); ?>;
                    this.apiResponse = <?= $response ? json_encode($response) : json_encode($err); ?>;
                    this.apiResponse = JSON.parse(this.apiResponse);
                    this.featureValues = <?= $newResult ? json_encode($newResult) : json_encode($newErr); ?>;
                    this.featureValues = JSON.parse(this.featureValues);
                    this.noResponseTitle = <?= json_encode(get_field('titre_aucun_article')); ?>;
                    await this.setAssociationsProducts();
                },
                setAssociationsProducts() {
                    this.apiResponse.products.map(element => {
                        if (element.associations.product_features) {
                            this.associationsProducts.push(element);
                        }
                    })
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
                    this.results.map((item, index) => {
                        this.featureValues.product_feature_values.map((element, index) => {
                            if (item.toLowerCase() === element.value[0].value.toLowerCase()) {
                                this.productMatchingValues.push(element)
                            }
                        })
                    })
                    this.productMatchingValues = [...new Set(this.productMatchingValues)];
                },
                setProducts() {
                    this.products = this.associationsProducts.filter(product =>
                        product.associations.product_features.every(feature =>
                            this.productMatchingValues.some(value =>
                                Number(feature.id_feature_value) === Number(value.id) && Number(feature.id) === Number(value.id_feature)
                            )
                        )
                    );
                },
                setUrl(product) {
                    return `https://leshop.chezolympe.com/api/images/products/${Number(product.id)}/${Number(product.id_default_image)}/?ws_key=${this.key}`;
                },
                setProductLink(product) {
                    return `https://leshop.chezolympe.com/${product.id}-${typeof product.link_rewrite === 'object' ? product.link_rewrite[0].value : product.link_rewrite}.html`
                }
            }
        }).mount('#questionnaire');
    </script>
</main>


<?php
get_template_part('parts/bottom');
get_footer();
?>
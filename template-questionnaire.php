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
        <?php $image_questionnaire = get_field('questionnaire_image'); ?>
        <img src="<?= esc_url($image_questionnaire['url']); ?>" alt="<?= esc_attr($image_questionnaire['alt']); ?>" class="hero-banner-img" />
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
                <!-- <h2 v-if="!allAnswers">Questionnaire</h2>
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
                                        <h4><a :href="setProductLink(product)" target="_blank">{{ product.name }}</a></h4>
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
                </div> -->
                <div class="temporary-result">
                    <h2><?php the_field('prochainement_titre'); ?></h2>
                    <p><?php the_field('prochainement_texte'); ?></p>
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
                    key: 'WR19W8DUK6YKMJGYZU9UGHI8TDYWBJM3',
                    productsLink: [],
                    productMatchingValues: [],
                    noResponseTitle: null,
                    newFeaturedValues: [],
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
                    this.apiResponse = <?= $response ? json_encode($response) : json_encode($err); ?>;
                    this.apiResponse = JSON.parse(this.apiResponse);
                    this.featureValues = <?= $newResult ? json_encode($newResult) : json_encode($newErr); ?>;
                    this.featureValues = JSON.parse(this.featureValues);
                    await this.setFeaturedValues();
                    this.noResponseTitle = <?= json_encode(get_field('titre_aucun_article')); ?>;
                },
                setFeaturedValues() {
                    this.featureValues.product_feature_values.map((item, index) => {
                        if (item.value !== "Les points forts") {
                            this.newFeaturedValues.push(item)
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
                    let arrayIdValues = [];
                    let arraySecond = [];
                    for (const value of this.results) {
                        for (const element of this.newFeaturedValues) {
                            if (value.toLowerCase() === element.value.toLowerCase()) {
                                arrayIdValues.push({
                                    id: String(element.id),
                                    name: element.value
                                });
                            }
                        }
                    }


                    arraySecond = arrayIdValues.filter(element => {
                        return arrayIdValues.some(value => {
                            return value.name.toLowerCase() !== element.name.toLowerCase()
                        })
                    })


                    arraySecond = arraySecond.map(element => {
                        return {
                            id: String(null),
                            name: element.name
                        }
                    })

                    // arrayIdValues.filter(element => {
                    //     console.log(element.name)
                    //     for (const emptyValue of this.results) {
                    //         if (element.name !== emptyValue) {
                    //             return arraySecond.push({
                    //                 id: String(null),
                    //                 name: emptyValue
                    //             })
                    //         }
                    //     }
                    // })
                    // for (const emptyValue of this.results) {
                    //     // for (const idValues of arrayIdValues) {
                    //     if (arrayIdValues.find(element => element.name.toLowerCase() !== emptyValue.toLowerCase())) {
                    //         console.log(emptyValue)
                    //         arraySecond.push({
                    //             id: String(null),
                    //             name: emptyValue
                    //         })
                    //     }
                    //     // }
                    // }
                    this.productMatchingValues = arrayIdValues.concat(arraySecond);
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
                },
                setUrl(product) {
                    return `https://leshop-chezolympe.btg-dev.com/api/images/products/${Number(product.id)}/${Number(product.id_default_image)}/?ws_key=${this.key}`;
                },
                setProductLink(product) {
                    return `https://leshop-chezolympe.btg-dev.com/${product.id}-${product.link_rewrite}.html`
                }
            }
        }).mount('#questionnaire');
    </script>
</main>


<?php
get_template_part('parts/bottom');
get_footer();
?>
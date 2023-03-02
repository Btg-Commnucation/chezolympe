<?php
/*
* Template Name: Home
*/

get_header();

class Post_single
{
    public $title;
    public $excerpt;
    public $content;
    public $categories;
    public $thumbnails;
    public $permalink;
    public $isQuizz;
}

$post_list = [];

$args = array(
    'post_type' => 'post',
    'post_per_page' => -1,
    'orderby' => 'title',
    'order' => 'DESC'
);

$query = new WP_Query($args);

if ($query->have_posts()) :

    while ($query->have_posts()) : $query->the_post();

        $post_object = new Post_single();
        $post_object->title = get_the_title();
        $post_object->content = do_shortcode(get_the_content());
        $post_object->excerpt = get_the_excerpt();
        $post_object->categories = get_the_category();
        $post_object->thumbnails = get_the_post_thumbnail();
        $post_object->permalink = get_the_permalink();
        $post_object->isQuizz = get_field('questionnaire');

        $post_list[] = $post_object;
    endwhile;
    wp_reset_postdata();

endif;
json_encode($post_list);

?>

<main id="home">
    <section class="hero-banner">
        <div class="leaf-top"></div>
        <h1>Le blog d'Olympe</h1>
    </section>
    <article v-if="loading">
        <div class="container">
            <section class="sort-by">
                <button v-if="mobile" class="show-sort" @click="showSort = !showSort">{{showSort ? 'Cacher les filtres' : 'Filtrer les articles'}}</button>
                <ul :class="showSort ? '' : 'hide'">
                    <li>
                        <button @click="filterCategory('')">Tout</button>
                    </li>
                    <li v-for="(category, index) in categories" :index="index">
                        <button @click="filterCategory(category)">{{category}}</button>
                    </li>
                </ul>
            </section>
            <section class="post__article">
                <div class="post-home" v-for="(post, index) in filteredCategory.slice(a, b)" :index="index">
                    <div class="post-home__image" v-if="post.isQuizz === 'non'">
                        <a :href="post.permalink" v-html="post.thumbnails"></a>
                    </div>
                    <div class="post-home__content" v-if="post.isQuizz === 'non'">
                        <h2><a :href="post.permalink" v-html="post.title"></a></h2>
                        <ul class="post-home__categories">
                            <li v-for="(category, index) in post.categories" :index="index">
                                {{category.name}}
                            </li>
                        </ul>
                        <p v-if="post.isQuizz === 'non'">{{post.excerpt}}</p>
                    </div>
                    <div id="quizz" class="quizz-container" v-if="post.isQuizz === 'oui'" v-html="post.content"></div>
                </div>
            </section>
            <section class="pagination">
                <ul>
                    <li class="prev">
                        <button @click="handlePageSwitch('prev')">
                            <span class="screen-reader-text">Page précédente</span>
                            <img src="<?= get_template_directory_uri() ?>/img/arrow-blog.svg" alt="Flèche pour la page précédente">
                        </button>
                    </li>
                    <li v-for="(page, index) in pagination" :index="index" :class="currentPage === page ? 'page__pagination active' : 'page__pagination'">
                        <button @click="handlePagination(page)">{{page}}</button>
                    </li>
                    <li class="next">
                        <button @click="handlePageSwitch('next')">
                            <span class="screen-reader-text">Page suivante</span>
                            <img src="<?= get_template_directory_uri(); ?>/img/arrow-blog.svg" alt="Flèche pour la page suivante">
                        </button>
                    </li>
                </ul>
            </section>
        </div>
    </article>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    data: null,
                    categories: [],
                    showSort: false,
                    mobile: false,
                    windowWidth: null,
                    selectedCategory: '',
                    loading: false,
                    pagination: [],
                    perPage: 6,
                    currentPage: 1,
                    a: 0,
                    b: 6,
                    filterPost: []
                }
            },
            computed: {
                filteredCategory() {
                    this.filterPost = [];
                    return this.data.filter(post => {
                        return post.categories.some(category => {
                            if (this.selectedCategory === '') {
                                this.filterPost.push(post)
                                this.handlePaginationCalculator;
                                return category
                            } else if (category.name === this.selectedCategory) {
                                this.filterPost.push(post)
                                this.handlePaginationCalculator;
                                return category
                            }
                        })
                    })
                },
                handlePaginationCalculator() {
                    this.pagination = [];
                    for (let i = 1; i <= this.filterPost.length; i++) {
                        console.log(Math.ceil(i / this.perPage))
                        this.pagination.push(Math.ceil(i / this.perPage));
                    }
                    this.pagination = [...new Set(this.pagination)]
                }
            },
            async mounted() {
                await this.getData();
                if (this.windowWidth <= 600) {
                    this.mobile = true;
                }
                this.loading = true;
            },
            methods: {
                getData() {
                    this.windowWidth = window.innerWidth;
                    this.data = <?php echo json_encode($post_list); ?>;
                    this.filterPost = this.data;
                    this.data.forEach(post => {
                        post.categories.forEach(category => {
                            if (!this.categories.includes(category.name)) {
                                this.categories.push(category.name);
                            }
                        })
                        this.categories = [...new Set(this.categories)]
                    })
                    this.handlePaginationCalculator;
                },
                filterCategory(category) {
                    this.selectedCategory = category;
                },
                handlePagination(pageNumber) {
                    if (this.currentPage > pageNumber) {
                        this.a = this.a - this.perPage * (this.currentPage - pageNumber);
                        this.b = this.b - this.perPage * (this.currentPage - pageNumber);
                    } else if (this.currentPage < pageNumber) {
                        this.a = this.a + this.perPage * (pageNumber - this.currentPage);
                        this.b = this.b + this.perPage * (pageNumber - this.currentPage);
                    }
                    this.currentPage = pageNumber;
                },
                handlePageSwitch(direction) {
                    if (direction === 'next') {
                        if (this.currentPage < this.pagination.length) {
                            this.a = this.a + this.perPage;
                            this.b = this.b + this.perPage;
                            this.currentPage++;
                        }
                    } else if (direction === 'prev') {
                        if (this.currentPage > 1) {
                            this.a = this.a - this.perPage;
                            this.b = this.b - this.perPage;
                            this.currentPage--;
                        }
                    }
                }
            }
        }).mount('#home')
    </script>
</main>

<?php
get_template_part('/parts/bottom');
get_footer(); ?>
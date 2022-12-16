<?php
/*
* Template Name: Home
*/

get_header();

class Post_single
{
    public $title;
    public $excerpt;
    public $categories;
    public $thumbnails;
    public $permalink;
}

$post_list = [];

$args = array(
    'post_type' => 'post',
    'post_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
);

$query = new WP_Query($args);

if ($query->have_posts()) :

    while ($query->have_posts()) : $query->the_post();

        $post_object = new Post_single();
        $post_object->title = get_the_title();
        $post_object->excerpt = get_the_excerpt();
        $post_object->categories = get_the_category();
        $post_object->thumbnails = get_the_post_thumbnail();
        $post_object->permalink = get_the_permalink();

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
    <article>
        <div class="container">
            <section class="sort-by">
                <ul>
                    <li>
                        <button>Tout</button>
                    </li>
                    <li v-for="(category, index) in categories" :index="index">
                        <button>{{category}}</button>
                    </li>
                </ul>
            </section>
            <section class="post__article">
                <div class="post-home" v-for="(post, index) in data" :index="index">
                    <div class="post-home__image">
                        <a :href="post.permalink" v-html="post.thumbnails"></a>
                    </div>
                    <div class="post-home__content">
                        <h2><a :href="post.permalink">{{post.title}}</a></h2>
                        <ul class="post-home__categories">
                            <li v-for="(category, index) in post.categories" :index="index">
                                {{category.name}}
                            </li>
                        </ul>
                        <p>{{post.excerpt}}</p>
                    </div>
                </div>
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
                    categories: []
                }
            },
            async mounted() {
                await this.getData();
            },
            methods: {
                getData() {
                    this.data = <?php echo json_encode($post_list); ?>;
                    this.data.forEach(post => {
                        post.categories.forEach(category => {
                            if (!this.categories.includes(category.name)) {
                                this.categories.push(category.name);
                            }
                        })
                        this.categories = [...new Set(this.categories)]
                    })
                }
            }
        }).mount('#home')
    </script>
</main>

<?php
get_template_part('/parts/bottom');
get_footer(); ?>
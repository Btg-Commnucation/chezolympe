<?php get_header();

class Post_single
{
    public $title;
    public $excerpt;
    public $categories;
    public $thumbnails;
    public $mostreaded;
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
        $post_object->mostreaded = get_field('le_plus_lu');
        $post_object->permalink = get_the_permalink();

        $post_list[] = $post_object;
    endwhile;
    wp_reset_postdata();

endif;
json_encode($post_list);

?>

<main id="single">
    <section class="hero-banner">
        <div class="leaf-top"></div>
        <h1>Le blog d'Olympe</h1>
    </section>
    <section class="content">
        <div class="container">
            <article>
                <h2><?php the_title(); ?></h2>
                <div class="content-wrapper">
                    <?php the_content(); ?>
                </div>
            </article>
            <aside>
                <h4>Les articles les plus lus</h4>
                <div class="post-container">
                    <div class="post" v-for="data in mostReaded">
                        <div class="thumbnails">
                            <a :href="data.permalink" v-html='data.thumbnails' :title="data.title"></a>
                        </div>
                        <div class="post__content">
                            <h5><a :href="data.permalink">{{data.title}}</a></h5>
                            <ul class="categories">
                                <li v-for="category in data.categories">
                                    {{category.cat_name}}
                                </li>
                            </ul>
                            <p>{{data.excerpt}}</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>


    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    data: null,
                    mostReaded: null,
                }
            },
            async mounted() {
                await this.getData();
                this.mostReadArticle();
            },
            methods: {
                getData() {
                    this.data = <?= json_encode($post_list); ?>;
                },
                mostReadArticle() {
                    this.mostReaded = this.data.filter((item) => {
                        return item.mostreaded === "Oui";
                    });
                }
            }
        }).mount('#single')
    </script>
</main>

<?php get_footer(); ?>
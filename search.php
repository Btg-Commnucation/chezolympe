<?php get_header(); ?>
<main id="search">
    <div class="container">
        <?php
        $s = get_search_query();
        $args = array(
            's' => $s
        );
        // The Query
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            _e("<h1 class='search-found__titel'>Résultat de la recherche pour : " . get_query_var('s') . "</h1>"); ?>
            <ul>
                <?php while ($the_query->have_posts()) {
                    $the_query->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php
                } ?>
            </ul>

        <?php } else {
        ?>
            <h1 class="not__found-title">Oupsi ... </h1>
            <div class="alert">
                <p>Désolé, nous n'avons rien trouver pour votre recherche. Réessayez avec des mots différents ou revenez à l'accueil</p>
                <a href="<?= home_url('/') ?>">Accueil</a>
            </div>
        <?php } ?>
    </div>
</main>

<?php get_template_part('parts/bottom');
get_footer(); ?>
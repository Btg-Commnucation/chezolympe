<?php
/*
* Template Name: Legals
*/
get_header(); ?>

<main id="legals">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <article class="content">
            <?php the_content(); ?>
        </article>
    </div>
</main>

<?php
get_template_part('./parts/bottom');
get_footer(); ?>
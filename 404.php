<?php get_header(); ?>

<main id="not-found">
    <div class="container">
        <div class="title">
            <h1 class="screen-reader-text">
                404 - Page non trouvée
            </h1>
            <img id="space-ship" src="<?= get_template_directory_uri() ?>/img/error-not-found.jpg" alt="Photo d'une 404 se faisant aspirer par un vaisseau extraterrestre">
            <img id="mulder-scully" src="<?= get_template_directory_uri() ?>/img/x-file-page-not-found.jpg" alt="La vérité est ailleurs">
            <img id="mib-ending" src="<?= get_template_directory_uri(); ?>/img/lost-page.gif" alt="La planète est sauve... Encore">
        </div>
        <div class="content">
            <strong>
                La page que vous cherchez n'est pas ici, elle a dû être kidnappée par des extraterrestres.
            </strong>
            <strong>
                Si vous avez des informations sur sa disparition, veuillez contacter le <span id="mib">MIB</span> ou <span id="mulder">Mulder</span> et <span id="scully">Scully</span>.
            </strong>
            <strong>
                Vous pouvez aussi retourner à la <a href="<?= home_url('/'); ?>">page d'accueil</a>.
            </strong>
        </div>
    </div>
</main>

<?php get_template_part('parts/bottom');
get_footer(); ?>
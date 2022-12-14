<?php wp_footer(); ?>

<footer>
    <div class="container">
        <img src="<?= get_template_directory_uri() ?>/img/logo-blanc.svg" alt="Logo Chez olympe">
        <div class="footer__menu-container">
            <section class="informations">
                <?php $univers = wp_get_nav_menu_name("univers"); ?>
                <?= $univers ? '<h3>' . $univers . '</h3>' : '' ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'univers',
                    'container'      => 'nav',
                    'menu_id'        => 'univers',
                    'fallback_cb'    => false,
                )); ?>
            </section>
            <section class="shop">
                <?php $shop = wp_get_nav_menu_name("shop"); ?>
                <?= $shop ? '<h3>' . $shop . '</h3>' : '' ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'shop',
                    'container'      => 'nav',
                    'menu_id'        => 'shop',
                    'fallback_cb'    => false,
                )) ?>
            </section>
            <section class="propos">
                <?php $propos = wp_get_nav_menu_name("propos"); ?>
                <?= $propos ? '<h3>' . $propos . '</h3>' : '' ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'propos',
                    'container'      => 'nav',
                    'menu_id'        => 'propos',
                    'fallback_cb'    => false,
                )) ?>
            </section>
            <section class="instagram">
                <?php $rs = wp_get_nav_menu_name("propos"); ?>
                <?= $rs ? '<h3>' . $rs . '</h3>' : '' ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'instagram',
                    'container'      => 'nav',
                    'menu_id'        => 'instagram',
                    'fallback_cb'    => false,
                )) ?>
            </section>
        </div>
        <div class="footer__bottom">
            <p>Réalisation : <a href="https://www.btg-communication.fr" target="_blank">btg communication</a></p>
        </div>
    </div>
</footer>

</body>

</html>
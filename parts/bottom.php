<?php
if (get_field('token_instagram', 'option')) {
    $instagram_token = get_field('token_instagram', 'option');
}
?>
<script>
    const instagramToken = "<?= $instagram_token; ?>";
</script>
<section class="instagram" id="instagram-container">
    <div class="title-container">
        <h2>Nous suivre sur instagram</h2>
        <p>Suis-nous sur Instagram et retrouve tous nos conseils</p>
    </div>
    <ul class="insta-image">

    </ul>
</section>

<section class="benefits product-benefits">
    <div class="large-container">
        <ul class="benefits-list">
            <li>
                <img src="<?= get_template_directory_uri(); ?>/img/camion.svg" alt="Illustration d'un camion">
                <p>Livraison rapide et gratuite dès 86€</p>
            </li>
            <li>
                <img src="<?= get_template_directory_uri(); ?>/img/cb.svg" alt="Illustration d'une carte bleue">
                <p>Paiement sécurisé</p>
            </li>
            <li>
                <img src="<?= get_template_directory_uri(); ?>/img/cils.svg" alt="Illustration de cils">
                <p>Livraison discrète</p>
            </li>
            <li>
                <img src="<?= get_template_directory_uri(); ?>/img/check.svg" alt="Illustration d'une main check">
                <p>Marque engagée</p>
            </li>
        </ul>
    </div>
</section>
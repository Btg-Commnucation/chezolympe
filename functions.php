<?php
add_theme_support('post-thumbnails');
add_theme_support('title-tag');

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
        'position' => '2'
    ));
}

add_filter('script_loader_tag', 'load_as_ES6', 10, 3);

function load_as_ES6($tag, $handle, $source)
{
    if ('btg-script' === $handle) {
        $tag = '<script src="' . $source . '" type="module" ></script>';
    }
    return $tag;
};


function btg_register_assets()
{
    wp_enqueue_style('btg-splide', get_template_directory_uri() . '/css/splide.min.css', 1.0);
    wp_enqueue_style('btg-style', get_template_directory_uri() . '/css/style.css', 1.0);
    // wp_enqueue_script('axios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js', array(), 1.0);
    wp_enqueue_script('vue', get_template_directory_uri() . '/vue.dev.js', array(), 1.0);
    wp_enqueue_script('btg-splide', get_template_directory_uri() . '/js/splide.min.js', array(), 1.0);
    wp_enqueue_script('btg-script', get_template_directory_uri() . '/js/script.js', array(), 1.0, true);
}

/* Disable WordPress Admin Bar for all users */
add_filter('show_admin_bar', '__return_false');

add_action('wp_enqueue_scripts', 'btg_register_assets');



register_nav_menus(array(
    'univers' => 'Menu Univers',
    'shop' => 'Menu Le shop',
    'propos' => 'Menu À propos',
    'instagram' => 'Menu Instagram'
));

add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);

function my_wp_nav_menu_objects($items, $args)
{

    // loop
    foreach ($items as &$item) {

        // vars
        $icon = get_field('rs', $item);


        // append icon
        if ($icon) {
            $item->title = '<span class="screen-reader-text">' . $item->title . '</span><img src="' . $icon . '" alt="' . $item->title . '" />';
        }
    }


    // return
    return $items;
}

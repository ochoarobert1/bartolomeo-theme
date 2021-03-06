<?php

if (!defined('ABSPATH')) {
    die('Invalid request.');
}

/* --------------------------------------------------------------
    ENQUEUE AND REGISTER CSS
-------------------------------------------------------------- */

require_once('includes/wp_enqueue_styles.php');

/* --------------------------------------------------------------
    ENQUEUE AND REGISTER JS
-------------------------------------------------------------- */

if (!is_admin()) add_action('wp_enqueue_scripts', 'bartolomeo_enqueue_jquery');
function bartolomeo_enqueue_jquery()
{
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
    if ($_SERVER['REMOTE_ADDR'] == '::1') {
        wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js', false, '3.6.0', false);
        wp_register_script('jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate.min.js',  array('jquery'), '3.3.2', false);
    } else {
        wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', false, '3.6.0', false);
        wp_register_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.3.2.min.js', array('jquery'), '3.3.2', true);
    }
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-migrate');
}

/* NOW ALL THE JS FILES */

require_once('includes/wp_enqueue_scripts.php');

/* --------------------------------------------------------------
    ADD CUSTOM WALKER BOOTSTRAP
-------------------------------------------------------------- */

add_action('after_setup_theme', 'bartolomeo_register_navwalker');
function bartolomeo_register_navwalker()
{
    require_once('includes/class-wp-bootstrap-navwalker.php');
}

/* --------------------------------------------------------------
    ADD CUSTOM WORDPRESS FUNCTIONS
-------------------------------------------------------------- */

require_once('includes/wp_custom_functions.php');

/* --------------------------------------------------------------
    ADD REQUIRED WORDPRESS PLUGINS
-------------------------------------------------------------- */

require_once('includes/class-tgm-plugin-activation.php');
require_once('includes/class-required-plugins.php');

/* --------------------------------------------------------------
    ADD CUSTOM WOOCOMMERCE OVERRIDES
-------------------------------------------------------------- */

if (class_exists('WooCommerce')) {
    require_once('includes/wp_woocommerce_functions.php');
}

/* --------------------------------------------------------------
    ADD NAV MENUS LOCATIONS
-------------------------------------------------------------- */

register_nav_menus(array(
    'header_menu' => __('Menu Header', 'bartolomeo'),
    'footer_menu' => __('Menu Footer', 'bartolomeo'),
));

/* --------------------------------------------------------------
    ADD DYNAMIC SIDEBAR SUPPORT
-------------------------------------------------------------- */

add_action('widgets_init', 'bartolomeo_widgets_init');

function bartolomeo_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar Principal', 'bartolomeo'),
        'id' => 'main_sidebar',
        'description' => __('Estos widgets seran vistos en las entradas y p??ginas del sitio', 'bartolomeo'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ));

    register_sidebars(4, array(
        'name'          => __('Pie de P??gina %d', 'bartolomeo'),
        'id'            => 'sidebar_footer',
        'description'   => __('Estos widgets seran vistos en el pie de p??gina del sitio', 'bartolomeo'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>'
    ));

    if (class_exists('WooCommerce')) {
        register_sidebar(array(
            'name' => __('Sidebar de la Tienda', 'bartolomeo'),
            'id' => 'shop_sidebar',
            'description' => __('Estos widgets seran vistos en Tienda y Categorias de Producto', 'bartolomeo'),
            'before_widget' => '<li id="%1$s" class="widget %2$s">',
            'after_widget'  => '</li>',
            'before_title'  => '<h2 class="widgettitle">',
            'after_title'   => '</h2>',
        ));
    }
}

/* --------------------------------------------------------------
    ADD CUSTOM METABOX
-------------------------------------------------------------- */

require_once('includes/wp_custom_metabox.php');

/* --------------------------------------------------------------
    ADD CUSTOM POST TYPE
-------------------------------------------------------------- */

require_once('includes/wp_custom_post_type.php');

/* --------------------------------------------------------------
    ADD CUSTOM THEME CONTROLS
-------------------------------------------------------------- */

require_once('includes/wp_custom_theme_control.php');

/* --------------------------------------------------------------
    ADD CUSTOM IMAGE SIZE
-------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(9999, 400, true);
}
if (function_exists('add_image_size')) {
    add_image_size('avatar', 100, 100, true);
    add_image_size('logo', 270, 180, false);
    add_image_size('blog_img', 276, 217, true);
    add_image_size('single_img', 636, 297, true);
}

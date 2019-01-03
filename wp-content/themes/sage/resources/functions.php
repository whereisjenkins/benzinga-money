<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__).'/config/assets.php',
            'theme' => require dirname(__DIR__).'/config/theme.php',
            'view' => require dirname(__DIR__).'/config/view.php',
        ]);
    }, true);

// Create the affiliates custom post type
function custom_post_type(){
    // Set UI labels for CPT
    $labels = array(
        'name'              => _x('Affiliates', 'Post Type General Name', 'sage'),
        'singular_name'     => _x('Affiliate', 'Post Type Singular Name', 'sage'),
        'menu_name'         => _x('Affiliates', 'sage'),
        'parent_item_colon' => _x('Parent Affiliate', 'sage'),
        'all_items'         => _x('All Affiliates', 'sage'),
        'view_item'         => _x('View Affiliate', 'sage'),
        'add_new_item'      => _x('Add New Affiliate', 'sage'),
        'add_new'           => _x('Add New', 'sage'),
        'edit_item'         => _x('Edit Affiliate', 'sage'),
        'update_item'       => _x('Update Affiliate', 'sage'),
        'search_items'      => _x('Search Affiliates', 'sage'),
        'not_found'         => _x('Not Found', 'sage'),
        'not_found_in_trash'=> _x('Not Found in Trash', 'sage'),
    );
    
    // Set other options for CPT
    $args = array(
        'label'             => _('affiliates'),
        'description'       => _('Links to affiliate programs and partners'),
        'labels'            => $labels,
        'supports'          => array('title', 'editor', 'excerpt', 'thumbnail', 'custom-fields',),
        'taxonomies'        => array('partners'),
        'hierarchical'      => false,
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menu'  => true,
        'show_in_admin_bar' => true,
        'menu_position'     => 5,
        'can_export'        => true,
        'has_archive'       => true,
        'exclude_from_search'=> false,
        'publicly_queryable'=> true,
        'capability_type'   => 'page',
    );
    
    // Register CPT
    register_post_type('affiliates', $args);
}

// Hook into init
add_action('init', 'custom_post_type', 0);
// Rename the Excerpt meta box, using it for the affiliate URL
function wpartisan_excerpt_label($translation, $original){
    if('Excerpt' == $original){
        return __('Affiliate Program URL');
    } elseif(false !== strpos($original, 'Excerpts are optional hand-crafted summaries of your')){
        return __('Use this field to enter the direct link that will navigate the consumer to the affiliate landing page');
    }
    return $translation;
}
add_filter('gettext', 'wpartisan_excerpt_label', 10, 2);

// Display the custom post type
function display_custom_post_type(){
    $args = array(
        'post_type'     => 'affiliates',
        'post_status'   => 'publish'
    );
    
    $string = '';
    $query = new WP_Query($args);
    if($query->have_posts()){
        $string .= '<ul>';
        while($query->have_posts()){
            $query->the_post();
            $string .= '<li>' . get_the_title() . '</li>';
        }
        $string .= '</ul>';
    }
    wp_reset_postdata();
    return $string;
}
add_shortcode('affiliate', 'display_custom_post_type');

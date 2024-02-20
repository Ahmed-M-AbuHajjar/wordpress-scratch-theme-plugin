<?php

// Enqueue css & javascript with versioning
function enqueue_custom_assets() {
    // Get file modification time for versioning
    $bootstrap_version = filemtime(get_template_directory() . '/assets/css/bootstrap.min.css');
    $main_css_version = filemtime(get_template_directory() . '/assets/css/main.css');
    $bootstrap_js_version = filemtime(get_template_directory() . '/assets/js/bootstrap.bundle.min.js');

    // Stylesheets
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), $bootstrap_version, 'all');
    wp_enqueue_style('main', get_template_directory_uri() . '/assets/css/main.css', array(), $main_css_version, 'all');

    // Scripts
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), $bootstrap_js_version, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_assets');

// Header Nav Menu
function theme_setup() {
    add_theme_support('menus');
    register_nav_menus(
        array(
            'top-menu' => 'Top Menu Location',
            'mobile-menu' => 'Mobile Menu Location'
        )
    );
}
add_action('after_setup_theme', 'theme_setup');

// Create Team Member Post Type
function create_team_member_post_type() {
    register_post_type('team_member',
        array(
            'labels'      => array(
                'name'          => __('Team Members', 'textdomain'),
                'singular_name' => __('Team Member', 'textdomain'),
                'add_new'       => __('Add New Member', 'textdomain'),  
                'add_new_item'  => __('Add New Team Member', 'textdomain'), 
                'edit_item'     => __('Edit Team Member', 'textdomain'),
            ),
            'public'      => true,
            'has_archive' => true,
            'supports'    => array('title', 'thumbnail', 'custom-fields'),
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-groups',
        )
    );
}
add_action('init', 'create_team_member_post_type');

// Disable Gutenberg editor
function disable_gutenberg_editor() {
    return false;
}
add_filter('use_block_editor_for_post', 'disable_gutenberg_editor', 10);


?>
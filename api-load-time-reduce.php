<?php
/**
 * Plugin Name: Api Load Time Reduce
 */

// Register Custom Admin Page
function custom_admin_page_setup() {
    add_menu_page(
        'Custom Admin Page',
        'Custom Page',
        'manage_options',
        'custom_admin_page_slug',
        'custom_admin_page_render',
        'dashicons-admin-generic',
        6
    );
}
add_action('admin_menu', 'custom_admin_page_setup');

// Render Custom Admin Page
function custom_admin_page_render() {
    echo "<h1>".esc_html(get_admin_page_title())."</h1>";

    $post_data = get_transient('demo-data');

    if (! $post_data){
        $post_data = wp_remote_get('https://jsonplaceholder.typicode.com/posts');
        $post_data = wp_remote_retrieve_body($post_data);
        $post_data = json_decode($post_data);

        set_transient('demo-data', $post_data,24 * HOUR_IN_SECONDS);
        $post_data = get_transient('demo-data');
    }


    echo "<ol>";
    foreach ($post_data as $key => $value){
        echo "<li>{$value->title}</li>";
    }
    echo "</ol>";
}
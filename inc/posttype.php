<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_action('init', function () {
    register_post_type('dw_picha_changelog', array(
        'labels' => array(
            'name' => __('Picha (Changelog)', 'dw-picha-changelog'),
            'singular_name' => __('Changelog', 'dw-picha-changelog'),
            'name_admin_bar' => __('Changelog', 'dw-picha-changelog'),
            'add_new' => __('Add New Project', 'dw-picha-changelog'),
            'add_new_item' => __('Add New Project', 'dw-picha-changelog'),
            'edit_item' => __('Edit Log', 'dw-picha-changelog'),
            'search_items' => __('Search Changelog', 'dw-picha-changelog'),
        ),
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => false,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => 'notifications',
        'menu_icon' => 'dashicons-clipboard',
        'show_in_rest' => false,
        'supports' => array('title'),
        'menu_position' => 5
    ));
});
add_filter('manage_dw_picha_changelog_posts_columns', function ($column) {
    $column['dwpicha313_shortcode'] = __('ShortCode', 'dw-picha-changelog');
    return $column;
});
add_filter('manage_dw_picha_changelog_posts_custom_column', function ($column) {
    if ('dwpicha313_shortcode' === $column) {
        global $post;;
        echo '<input type="text" value="[dwpicha313_shortcode id=' . esc_html($post->ID) . ']" class="dwp_shortcode" readonly>';
    }
    return $column;
}, 10, 3);
<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('dw_picha_changelog', [
        'labels' => [
            'name'               => __('Picha', 'dw-picha-changelog'),
            'singular_name'      => __('Changelog', 'dw-picha-changelog'),
            'name_admin_bar'     => __('Changelog', 'dw-picha-changelog'),
            'add_new'            => __('Add New Project', 'dw-picha-changelog'),
            'add_new_item'       => __('Add New Project', 'dw-picha-changelog'),
            'edit_item'          => __('Edit Log', 'dw-picha-changelog'),
            'search_items'       => __('Search Changelog', 'dw-picha-changelog'),
        ],
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'menu_icon'          => 'dashicons-clipboard',
        'show_in_rest'       => false,
        'supports'           => ['title'],
        'menu_position'      => 5,
    ]);
});

add_filter('manage_dw_picha_changelog_posts_columns', function ($columns) {
    $columns['dwpicha313_shortcode'] = __('ShortCode', 'dw-picha-changelog');
    return $columns;
});

add_action('manage_dw_picha_changelog_posts_custom_column', function ($column, $post_id) {
    if ($column === 'dwpicha313_shortcode') {
        printf(
            '<input type="text" value="%s" class="dwp_shortcode" readonly onclick="this.select();">',
            esc_attr('[dwpicha313_shortcode id=' . $post_id . ']')
        );
    }
}, 10, 2);
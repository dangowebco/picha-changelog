<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', function () {
    register_rest_route('picha/v1', '/changelog/(?P<id>\d+)', [
        'methods'             => 'GET',
        'callback'            => 'dwpicha313_rest_get_changelog',
        'permission_callback' => '__return_true',
        'args'                => [
            'id' => [
                'validate_callback' => function ($param) {
                    return is_numeric($param) && (int) $param > 0;
                },
                'sanitize_callback' => 'absint',
            ],
        ],
    ]);
});

/**
 * Return the changelog data as JSON.
 *
 * @param WP_REST_Request $request
 * @return WP_REST_Response|WP_Error
 */
function dwpicha313_rest_get_changelog(WP_REST_Request $request)
{
    $id = (int) $request['id'];

    if (get_post_type($id) !== 'dw_picha_changelog') {
        return new WP_Error('not_found', __('Changelog not found.', 'dw-picha-changelog'), ['status' => 404]);
    }

    $logs = maybe_unserialize(get_post_meta($id, '_dwp_changelog', true));
    if (empty($logs) || !is_array($logs)) {
        return new WP_Error('empty', __('No changelog data available.', 'dw-picha-changelog'), ['status' => 404]);
    }

    $options = maybe_unserialize(get_post_meta($id, '_dwp_changelog_options', true));
    if (!is_array($options)) {
        $options = [];
    }

    $normalized = [];
    foreach ($logs as $entry) {
        $items = [];
        if (!empty($entry['item']) && is_array($entry['item'])) {
            foreach ($entry['item'] as $item) {
                $items[] = [
                    'status'  => sanitize_key($item['status'] ?? ''),
                    'label'   => dwpicha313_log_status($item['status'] ?? ''),
                    'content' => wp_strip_all_tags($item['content'] ?? ''),
                ];
            }
        }
        $normalized[] = [
            'version'        => wp_strip_all_tags($entry['version'] ?? ''),
            'jalali_date'    => wp_strip_all_tags($entry['jalali_date'] ?? ''),
            'gregorian_date' => wp_strip_all_tags($entry['gregorian_date'] ?? ''),
            'description'    => wp_strip_all_tags($entry['description'] ?? ''),
            'items'          => $items,
        ];
    }

    return new WP_REST_Response([
        'id'       => $id,
        'title'    => get_the_title($id),
        'options'  => array_map('sanitize_text_field', $options),
        'versions' => $normalized,
    ], 200);
}
<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the AJAX handler for live preview.
 */
add_action('wp_ajax_dwpicha313_preview', 'dwpicha313_ajax_preview');

/**
 * Handle AJAX preview request.
 * Sanitizes incoming data, renders the selected template, returns HTML.
 */
function dwpicha313_ajax_preview()
{
    // Verify nonce (reuse the same nonce as the metabox save).
    if (!isset($_POST['nonce']) || !wp_verify_nonce(
        sanitize_text_field(wp_unslash($_POST['nonce'])),
        'dwp_save_meta_box'
    )) {
        wp_send_json_error(['message' => __('Security check failed.', 'dw-picha-changelog')], 403);
    }

    if (!current_user_can('edit_posts')) {
        wp_send_json_error(['message' => __('Permission denied.', 'dw-picha-changelog')], 403);
    }

    // Decode the JSON payload.
    $raw_logs = isset($_POST['logs']) ? wp_unslash($_POST['logs']) : '';
    $raw_opts = isset($_POST['options']) ? wp_unslash($_POST['options']) : '';

    $logs = json_decode($raw_logs, true);
    $opts = json_decode($raw_opts, true);

    if (!is_array($logs)) {
        $logs = [];
    }
    if (!is_array($opts)) {
        $opts = [];
    }

    // Sanitize using the same recursive function used on save.
    $change_logs    = dwpicha313_sanitize_recursive($logs);
    $change_options = array_map('sanitize_text_field', $opts);

    // Default template.
    $template_slug = $change_options['template'] ?? '1';
    $template_file = dwpicha313_locate_template($template_slug);

    if (!$template_file) {
        wp_send_json_error([
            'message' => __('Template file not found.', 'dw-picha-changelog'),
        ], 404);
    }

    // Render.
    ob_start();
    include $template_file;
    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}
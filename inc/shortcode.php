<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    add_shortcode('dwpicha313_shortcode', 'dwpicha313_shortcode_results');
});

/**
 * Render the changelog shortcode output.
 *
 * @param array $atts
 * @return string
 */
function dwpicha313_shortcode_results($atts)
{
    $atts = shortcode_atts(['id' => 0], $atts, 'dwpicha313_shortcode');

    $post_id = absint($atts['id']);
    if (!$post_id) {
        return '';
    }

    if (get_post_type($post_id) !== 'dw_picha_changelog') {
        return '';
    }

    $change_logs = maybe_unserialize(get_post_meta($post_id, '_dwp_changelog', true));
    if (empty($change_logs) || !is_array($change_logs)) {
        return '';
    }

    $change_options = maybe_unserialize(get_post_meta($post_id, '_dwp_changelog_options', true));
    if (!is_array($change_options)) {
        $change_options = [];
    }

    // Migration — removed
    $template_slug = $change_options['template'] ?? '1';

    $template_file = dwpicha313_locate_template($template_slug);
    if (!$template_file) {
        return __('Template file not found.', 'dw-picha-changelog');
    }

    // Enqueue frontend JS if needed (only timeline + accordion)
    if (in_array($template_slug, ['3', '5'], true)) {
        wp_enqueue_script(
            'dwpichaFrontend',
            DWPICHA_LITE_ASSETS . 'frontend.js',
            [],
            DWPICHA_LITE_VERSION,
            true
        );
    }

    // Build appearance CSS
    $appearance  = $change_options['appearance'] ?? [];
    $appearance_css = dwpicha313_build_appearance_css($post_id, $appearance);

    // Color mode class
    $color_mode_class = '';
    $color_mode = $appearance['color_mode'] ?? 'auto';
    $has_custom = !empty($appearance['enabled']);

    if ($has_custom) {
        $color_mode_class .= ' dwpHasCustomColors';
    }
    if ($color_mode === 'dark') {
        $color_mode_class .= ' dwpDark';
    } elseif ($color_mode === 'light') {
        $color_mode_class .= ' dwpForceLight';
    } else {
        $color_mode_class .= ' dwpAuto';
    }

    // Register appearance CSS for wp_head
    $appearance = $change_options['appearance'] ?? [];
    dwpicha313_register_appearance_css($post_id, $appearance);

    // Color mode class
    $color_mode_class = '';
    $color_mode = $appearance['color_mode'] ?? 'auto';

    if ($color_mode === 'dark') {
        $color_mode_class = ' dwpDark';
    } elseif ($color_mode === 'light') {
        $color_mode_class = ' dwpForceLight';
    } else {
        $color_mode_class = ' dwpAuto';
    }

    ob_start();
?>
    <div id="dwpicha-<?php echo esc_attr($post_id); ?>"
        class="dwpichaWrapper<?php echo esc_attr($color_mode_class); ?>">
        <?php include $template_file; ?>
    </div>
<?php
    return ob_get_clean();
}

// Backward-compatible alias.
if (!function_exists('dwpicha313ShortcodeResultsLite')) {
    function dwpicha313ShortcodeResultsLite($atts)
    {
        return dwpicha313_shortcode_results($atts);
    }
}

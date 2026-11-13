<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('init', function () {
    add_shortcode('dwpicha313_shortcode', 'dwpicha313ShortcodeResultsLite');
});

function dwpicha313ShortcodeResultsLite($atts)
{
    // Set default attributes and extract them
    $atts = shortcode_atts(['id' => null], $atts);

    // Check if 'id' is provided
    if (!$atts['id']) {
        return ''; // Return empty string if no ID is provided
    }

    // Get post meta data
    $postMeta = maybe_unserialize(get_post_meta($atts['id'], '_dwp_changelog_options', true));
    $change_logs = maybe_unserialize(get_post_meta($atts['id'], '_dwp_changelog', true));

    // Check if change logs exist
    if (!$change_logs) {
        return ''; // Return empty string if no change logs are found
    }

    // Start output buffering
    ob_start();

    // Prepare variables to pass to the template
    $template_data = [
        'change_logs' => $change_logs,
        'change_options' => $postMeta, // Assuming this contains the options
    ];

    // Include the appropriate template file
    if (isset($postMeta['template'])) {
        $template_file = DWPICHA313_ROOT_LITE . 'templates/template-' . $postMeta['template'] . '.php';
    } else {
        $template_file = DWPICHA313_ROOT_LITE . 'templates/template-1.php';
    }

    // Check if the template file exists before including it
    if (file_exists($template_file)) {
        extract($template_data); // Extract variables for use in the template
        include $template_file;
    } else {
        return __('Template file not found.', 'dw-picha-changelog');
    }

    // Get the buffered content and clean the buffer
    $output = ob_get_clean();

    // Return the output
    return $output;
}
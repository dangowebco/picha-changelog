<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Return localized label for a changelog item status.
 *
 * @param string $status
 * @return string
 */
function dwpicha313_log_status($status)
{
    $map = [
        'added'         => __('New', 'dw-picha-changelog'),
        'updated'       => __('Update', 'dw-picha-changelog'),
        'improved'      => __('Improvement', 'dw-picha-changelog'),
        'removed'       => __('Remove', 'dw-picha-changelog'),
        'deprecated'    => __('Obsolete', 'dw-picha-changelog'),
        'compatibility' => __('Compatibility', 'dw-picha-changelog'),
        'special'       => __('Special', 'dw-picha-changelog'),
        'fixed'         => __('Fixed', 'dw-picha-changelog'),
    ];

    return $map[$status] ?? '';
}

/**
 * Return the list of available statuses as value => label.
 *
 * @return array
 */
function dwpicha313_get_statuses()
{
    return [
        'added'         => __('New', 'dw-picha-changelog'),
        'fixed'         => __('Fixed', 'dw-picha-changelog'),
        'updated'       => __('Update', 'dw-picha-changelog'),
        'improved'      => __('Improvement', 'dw-picha-changelog'),
        'removed'       => __('Remove', 'dw-picha-changelog'),
        'deprecated'    => __('Obsolete', 'dw-picha-changelog'),
        'compatibility' => __('Compatibility', 'dw-picha-changelog'),
        'special'       => __('Special', 'dw-picha-changelog'),
    ];
}

/**
 * Backward-compatible alias.
 */
if (!function_exists('dwpicha313LogStatus')) {
    function dwpicha313LogStatus($status)
    {
        return dwpicha313_log_status($status);
    }
}

/**
 * Locate a template file, allowing theme override.
 *
 * Priority: theme/picha/template-{n}.php > plugin/templates/template-{n}.php
 *
 * @param string $template Template slug (e.g. "1", "2", "custom")
 * @return string|false Absolute path or false if not found.
 */
function dwpicha313_locate_template($template)
{
    $template = preg_replace('/[^a-zA-Z0-9\-_]/', '', (string) $template);
    if ($template === '') {
        $template = '1';
    }

    $theme_file = locate_template([
        'picha/template-' . $template . '.php',
        'picha-changelog/template-' . $template . '.php',
    ]);

    if ($theme_file) {
        return $theme_file;
    }

    $plugin_file = DWPICHA_LITE_PATH . 'templates/template-' . $template . '.php';
    return file_exists($plugin_file) ? $plugin_file : false;
}

/**
 * Get the list of available templates (slug => label).
 *
 * @return array
 */
function dwpicha313_get_templates()
{
    return [
        '1' => __('Classic', 'dw-picha-changelog'),
        '2' => __('Modern Card', 'dw-picha-changelog'),
        '3' => __('Timeline', 'dw-picha-changelog'),
        '4' => __('Minimal', 'dw-picha-changelog'),
        '5' => __('Accordion', 'dw-picha-changelog'),
    ];
}
add_action('wp_footer', function () {
    if (!is_singular()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var wrapper = document.querySelector('.dwpichaWrapper');
        if (!wrapper) return;
        var template = wrapper.querySelector('.dwpTemplate');
        if (!template) return;
        var styles = getComputedStyle(template);
    });
    </script>
    <?php
});
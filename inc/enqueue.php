<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'dwpichaTheme',
        DWPICHA_LITE_ASSETS . 'theme.css',
        [],
        DWPICHA_LITE_VERSION
    );
});

add_action('admin_enqueue_scripts', function ($hook) {
    $screen = get_current_screen();
    $is_picha = $screen && $screen->post_type === 'dw_picha_changelog';

    // WordPress color picker (always in admin, for potential use)
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    // Admin styles
    wp_enqueue_style('dwpicha', DWPICHA_LITE_ASSETS . 'admin.css', [], DWPICHA_LITE_VERSION);

    if (!$is_picha) {
        return;
    }

    // Preview needs frontend theme CSS
    wp_enqueue_style('dwpichaTheme', DWPICHA_LITE_ASSETS . 'theme.css', [], DWPICHA_LITE_VERSION);

    // Jalali datepicker
    wp_enqueue_style('dwpichaJalali', DWPICHA_LITE_ASSETS . 'jalalidatepicker.min.css', [], DWPICHA_LITE_VERSION);
    wp_enqueue_script('dwpichaJalali', DWPICHA_LITE_ASSETS . 'jalalidatepicker.min.js', ['jquery'], DWPICHA_LITE_VERSION, true);

    // Sortable
    wp_enqueue_script('jquery-ui-sortable');

    // Main admin JS
    wp_enqueue_script(
        'dwpicha',
        DWPICHA_LITE_ASSETS . 'admin.js',
        ['jquery', 'dwpichaJalali', 'jquery-ui-sortable', 'wp-color-picker'],
        DWPICHA_LITE_VERSION,
        true
    );

    wp_localize_script('dwpicha', 'dwp', [
        'add'           => __('Add Log', 'dw-picha-changelog'),
        'addBulk'       => __('Add Bulk Log', 'dw-picha-changelog'),
        'bulkDesc'      => __('Put each item on a line.', 'dw-picha-changelog'),
        'version'       => __('Version', 'dw-picha-changelog'),
        'description'   => __('Description', 'dw-picha-changelog'),
        'gregorianDate' => __('Gregorian Date', 'dw-picha-changelog'),
        'jalaliDate'    => __('Jalali Date', 'dw-picha-changelog'),
        'delete'        => __('Delete', 'dw-picha-changelog'),
        'duplicate'     => __('Duplicate', 'dw-picha-changelog'),
        'added'         => __('New', 'dw-picha-changelog'),
        'fixed'         => __('Fixed', 'dw-picha-changelog'),
        'updated'       => __('Update', 'dw-picha-changelog'),
        'improved'      => __('Improvement', 'dw-picha-changelog'),
        'removed'       => __('Remove', 'dw-picha-changelog'),
        'deprecated'    => __('Obsolete', 'dw-picha-changelog'),
        'compatibility' => __('Compatibility', 'dw-picha-changelog'),
        'special'       => __('Special', 'dw-picha-changelog'),
        'confirmDelete' => __('Are you sure you want to delete this section?', 'dw-picha-changelog'),
        'preview'       => __('Preview', 'dw-picha-changelog'),
        'previewTitle'  => __('Changelog Preview', 'dw-picha-changelog'),
        'previewError'  => __('Could not generate preview. Please try again.', 'dw-picha-changelog'),
        'previewEmpty'  => __('Add at least one version with content to preview.', 'dw-picha-changelog'),
        'close'         => __('Close', 'dw-picha-changelog'),
        'ajaxUrl'       => admin_url('admin-ajax.php'),
        'nonce'         => wp_create_nonce('dwp_save_meta_box'),
        'dragToReorder'         => __('Drag to reorder', 'dw-picha-changelog'),
        'versionPlaceholder'    => __('e.g. 2.1.0', 'dw-picha-changelog'),
        'jalaliPlaceholder'     => __('1403/09/06', 'dw-picha-changelog'),
        'descriptionHint'       => __('Optional summary of this release', 'dw-picha-changelog'),
        'descriptionPlaceholder' => __('Describe what changed in this version...', 'dw-picha-changelog'),
        'logEntries'            => __('Log Entries', 'dw-picha-changelog'),
        'bulkPlaceholder'       => __("Added feature A\nFixed bug B\nImproved performance", 'dw-picha-changelog'),
        'cancel'                => __('Cancel', 'dw-picha-changelog'),
        'addAll'                => __('Add All', 'dw-picha-changelog'),
        'noEntries'             => __('No entries yet. Click "Add Entry" to start.', 'dw-picha-changelog'),
        'emptyTitle'            => __('No versions yet', 'dw-picha-changelog'),
        'emptyDesc'             => __('Click "New Version" to add your first changelog entry.', 'dw-picha-changelog'),
        'createFirst'           => __('Create First Version', 'dw-picha-changelog'),
        'describeChange'        => __('Describe the change...', 'dw-picha-changelog'),
        'itemCountTitle'        => __('Number of log entries', 'dw-picha-changelog'),
        // Appearance
        'useCustomColors'   => __('Use custom colors', 'dw-picha-changelog'),
        'primaryColor'      => __('Primary color', 'dw-picha-changelog'),
        'textColor'         => __('Text color', 'dw-picha-changelog'),
        'surfaceColor'      => __('Surface color', 'dw-picha-changelog'),
        'resetToDefaults'   => __('Reset to defaults', 'dw-picha-changelog'),
        'colorMode'         => __('Color mode', 'dw-picha-changelog'),
        'colorModeAuto'     => __('Auto (follow system)', 'dw-picha-changelog'),
        'colorModeLight'    => __('Always light', 'dw-picha-changelog'),
        'colorModeDark'     => __('Always dark', 'dw-picha-changelog'),
        'confirmResetColors' => __('Reset all colors to their default values?', 'dw-picha-changelog'),
    ]);
});

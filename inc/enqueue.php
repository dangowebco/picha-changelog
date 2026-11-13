<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('dwpichaTheme', DWPICHA313_ASSETS_LITE . 'theme.css', '', '2.0.0');
});
add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('dwpicha', DWPICHA313_ASSETS_LITE . 'admin.css', '', '2.0.0');
    wp_enqueue_script('dwpicha', DWPICHA313_ASSETS_LITE . 'admin.js', '', '2.0.0', ['in_footer' => true]);
    wp_enqueue_style('dwpichaJalali', DWPICHA313_ASSETS_LITE . 'jalalidatepicker.min.css', '', '2.0.0');
    wp_enqueue_script('dwpichaJalali', DWPICHA313_ASSETS_LITE . 'jalalidatepicker.min.js', '', '2.0.0');
    wp_localize_script('dwpicha', 'dwp', array(
        'add' => __('Add Log', 'dw-picha-changelog'),
        'addBulk' => __('Add Bulk Log', 'dw-picha-changelog'),
        'bulkDesc' => __('Put each item on a line.', 'dw-picha-changelog'),
        'version' => __('Version', 'dw-picha-changelog'),
        'description' => __('Description', 'dw-picha-changelog'),
        'gregorianDate' => __('Gregorian Date', 'dw-picha-changelog'),
        'jalaliDate' => __('Jalali Date', 'dw-picha-changelog'),
        'added' => __('New', 'dw-picha-changelog'),
        'fixed' => __('Fixed', 'dw-picha-changelog'),
        'updated' => __('Update', 'dw-picha-changelog'),
        'improved' => __('Improvement', 'dw-picha-changelog'),
        'removed' => __('Remove', 'dw-picha-changelog'),
        'deprecated' => __('Obsolete', 'dw-picha-changelog'),
        'compatibility' => __('Compatibility', 'dw-picha-changelog'),
        'special' => __('Special', 'dw-picha-changelog'),
    ));
});

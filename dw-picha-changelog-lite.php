<?php
/*
 * Plugin Name: Picha – Changelog & Release Notes
 * Plugin URI: https://dangoweb.ir/product/picha-wordpress-changelog-plugin/
 * Description: Create and display attractive changelogs for physical and digital products, software, and product updates. All features are free.
 * Version: 2.3
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: Dango Web
 * Author URI: https://dangoweb.ir/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: dw-picha-changelog
 * Domain Path: /languages
 */

defined('ABSPATH') || exit();

define('DWPICHA_LITE_VERSION', '2.3');
define('DWPICHA_LITE_PATH', plugin_dir_path(__FILE__));
define('DWPICHA_LITE_URL', plugins_url('/', __FILE__));
define('DWPICHA_LITE_ASSETS', DWPICHA_LITE_URL . 'assets/');
define('DWPICHA_LITE_INC', DWPICHA_LITE_PATH . 'inc/');

// Backward-compatible constants (v2.0)
define('DWPICHA313_ROOT_LITE', DWPICHA_LITE_PATH);
define('DWPICHA313_ASSETS_LITE', DWPICHA_LITE_ASSETS);
define('DWPICHA313_INC_LITE', DWPICHA_LITE_INC);

/**
 * Load plugin textdomain the WordPress standard way.
 */
add_action('init', function () {
    load_plugin_textdomain(
        'dw-picha-changelog',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});

require_once DWPICHA_LITE_INC . 'posttype.php';
require_once DWPICHA_LITE_INC . 'enqueue.php';
require_once DWPICHA_LITE_INC . 'shortcode.php';
require_once DWPICHA_LITE_INC . 'metaboxes.php';
require_once DWPICHA_LITE_INC . 'functions.php';
require_once DWPICHA_LITE_INC . 'preview.php';
require_once DWPICHA_LITE_INC . 'color-helpers.php';
require_once DWPICHA_LITE_INC . 'rest-api.php';
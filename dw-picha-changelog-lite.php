<?php
/*
 * Plugin Name: DW Picha Changelog
 * Plugin URI: https://dangoweb.ir/product/picha-wordpress-changelog-plugin/
 * Description: Picha is a WordPress plugin designed to showcase the changes in physical or digital products in the most engaging way possible for users.
 * Version: 2.0
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Author: Dango Web
 * Author URI: https://dangoweb.ir/
 * License: GPL v2 or later
 * Text Domain: dw-picha-changelog
 * Domain Path: /languages
 */
defined('ABSPATH') || exit();
add_action('plugins_loaded', function () {
    load_textdomain('dw-picha-changelog', wp_normalize_path(plugin_dir_path(__FILE__)) . '/languages/dw-picha-changelog-' . determine_locale() . '.mo');
});
define('DWPICHA313_ROOT_LITE', plugin_dir_path(__FILE__));
define('DWPICHA313_ASSETS_LITE', plugins_url('assets/', __FILE__));
define('DWPICHA313_INC_LITE', plugin_dir_path(__FILE__) . 'inc/');
require_once DWPICHA313_INC_LITE . 'posttype.php';
require_once DWPICHA313_INC_LITE . 'enqueue.php';
require_once DWPICHA313_INC_LITE . 'shortcode.php';
require_once DWPICHA313_INC_LITE . 'metaboxes.php';
require_once DWPICHA313_INC_LITE . 'functions.php';


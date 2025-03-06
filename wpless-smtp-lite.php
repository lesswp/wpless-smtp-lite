<?php
/**
 * Plugin Name: WPLess SMTP Lite
 * Plugin URI:  https://yourwebsite.com/
 * Description: A lightweight SMTP plugin for WordPress.
 * Version:     1.0.0
 * Author:      Anuj Pandey
 * Author URI:  https://www.wpless.com/
 * License:     GPL-2.0+
 * Text Domain: wpless-smtp-lite
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path
define('WPLESS_SMTP_PATH', plugin_dir_path(__FILE__));
define('WPLESS_SMTP_URL', plugin_dir_url(__FILE__));
define('WPLESS_SMTP_VERSION', '1.0.0');

// Include necessary files
require_once WPLESS_SMTP_PATH . 'includes/admin-settings.php';
require_once WPLESS_SMTP_PATH . 'includes/email.php';
require_once WPLESS_SMTP_PATH . 'includes/helpers.php';

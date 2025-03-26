<?php

/**
 * Plugin Name: CF7 MCP Event Manager Integration
 * Plugin URI: https://davekim.io
 * Description: Adds custom Contact Form 7 tags for workshops and webinars, pulling data from the workshops and webinars created from the MCP Event Manager plugin.
 * Version: 1.0
 * Author: Dave Kim
 * Author URI: https://davekim.io
 * License: MIT
 */

if (! defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

// 1. Define constants for plugin paths.
define('CF7_MCP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CF7_MCP_PLUGIN_URL', plugin_dir_url(__FILE__));

// 2. Include the necessary files.
require_once CF7_MCP_PLUGIN_DIR . 'includes/helper-functions.php';
require_once CF7_MCP_PLUGIN_DIR . 'includes/class-cf7-mcp-tags.php';
require_once CF7_MCP_PLUGIN_DIR . 'includes/class-cf7-mcp-tag-generator.php';

/**
 * Initialize the plugin.
 */
function cf7_mcp_init_plugin() {
  error_log('CF7 MCP Event Manager Integration plugin initialized.');
}

add_action('plugins_loaded', 'cf7_mcp_init_plugin');

<?php

/**
 * Helper Functions for CF7 MCP
 * Contains the database option keys, and the function to build <select> elements.
 */

if (! defined('ABSPATH')) {
  exit;
}

/* Option keys for events data */
define('CF7_MCP_DB_KEY_WORKSHOPS', 'cf7_mcp_workshops');
define('CF7_MCP_DB_KEY_WEBINARS',  'cf7_mcp_webinars');

/**
 * Build a basic <select> element from an array of events.
 */
function cf7_mcp_create_select_field($options, $option_key, $id_key, $default_option_class) {
  $className     = "mcp-field";
  $defaultSelect = "<select class=\"$className $default_option_class\"><option>-- No events at this time --</option></select>";
  $output        = "<select class=\"$className $option_key\">";

  if (empty($options) || ! is_array($options)) {
    return $defaultSelect;
  }

  foreach ($options as $option) {
    if (! isset($option[$id_key], $option['location'], $option['date'], $option['time'])) {
      continue;
    }
    $id       = sanitize_text_field($option[$id_key]);
    $location = sanitize_text_field($option['location']);
    $date     = date("m/d/Y", strtotime($option['date']));
    $time     = date("g:iA", strtotime(sanitize_text_field($option['time'])));
    $label    = "$location - $date at $time";

    // Value attribute: "ID | Label"
    $output  .= "<option value=\"" . esc_attr($id . " | " . $label) . "\">" . esc_html($label) . "</option>";
  }

  $output .= "</select>";
  return $output;
}

/**
 * Generate the workshops <select> field using event data from the DB.
 */
function cf7_mcp_generate_workshop_select_field() {
  $option_key = 'mcp_workshops_field';
  $options    = get_option(CF7_MCP_DB_KEY_WORKSHOPS);
  return cf7_mcp_create_select_field($options, $option_key, 'eventId', $option_key . ' mcp-empty');
}

/**
 * Generate the webinars <select> field using event data from the DB.
 */
function cf7_mcp_generate_webinar_select_field() {
  $option_key = 'mcp_webinars_field';
  $options    = get_option(CF7_MCP_DB_KEY_WEBINARS);
  return cf7_mcp_create_select_field($options, $option_key, 'eventId', $option_key . ' mcp-empty');
}

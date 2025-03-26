<?php

/**
 * Handles registering the CF7 tags (normal + required) and their callbacks.
 * Also includes custom validation for the required fields.
 */

if (! defined('ABSPATH')) {
  exit;
}

class CF7_MCP_Tags {

  public function __construct() {
    // Register both normal + required versions
    add_action('wpcf7_init', array($this, 'register_form_tags'));

    // Validation for required fields
    add_filter('wpcf7_validate_mcp_workshops*', array($this, 'validate_required_workshops'), 10, 2);
    add_filter('wpcf7_validate_mcp_webinars*', array($this, 'validate_required_webinars'), 10, 2);
  }

  /**
   * Register custom form tags: mcp_workshops, mcp_workshops*, mcp_webinars, mcp_webinars*.
   */
  public function register_form_tags() {
    wpcf7_add_form_tag(
      array('mcp_workshops', 'mcp_workshops*'),
      array($this, 'workshops_callback'),
      array('name-attr' => true)
    );

    wpcf7_add_form_tag(
      array('mcp_webinars', 'mcp_webinars*'),
      array($this, 'webinars_callback'),
      array('name-attr' => true)
    );
  }

  /**
   * The callback that outputs the <select> for workshops.
   */
  public function workshops_callback($tag) {
    if (empty($tag->name)) {
      return '';
    }
    $field_name       = $tag->name;
    $additional_class = $tag->get_class_option();
    $include_blank    = $tag->has_option('include_blank');
    $required         = $tag->is_required();

    // Build the base <select> from helper function
    $select_html = cf7_mcp_generate_workshop_select_field();

    return $this->wrap_select($select_html, $field_name, $additional_class, $include_blank, $required);
  }

  /**
   * The callback that outputs the <select> for webinars.
   */
  public function webinars_callback($tag) {
    if (empty($tag->name)) {
      return '';
    }
    $field_name       = $tag->name;
    $additional_class = $tag->get_class_option();
    $include_blank    = $tag->has_option('include_blank');
    $required         = $tag->is_required();

    $select_html = cf7_mcp_generate_webinar_select_field();

    return $this->wrap_select($select_html, $field_name, $additional_class, $include_blank, $required);
  }

  /**
   * Validate required [mcp_workshops*] fields.
   */
  public function validate_required_workshops($result, $tag) {
    $name  = $tag->name;
    $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
    if ('' === $value) {
      $result->invalidate($tag, wpcf7_get_message('invalid_required'));
    }
    return $result;
  }

  /**
   * Validate required [mcp_webinars*] fields.
   */
  public function validate_required_webinars($result, $tag) {
    $name  = $tag->name;
    $value = isset($_POST[$name]) ? trim($_POST[$name]) : '';
    if ('' === $value) {
      $result->invalidate($tag, wpcf7_get_message('invalid_required'));
    }
    return $result;
  }

  /**
   * Wrap the <select> in CF7’s typical markup, adding classes and attributes.
   */
  private function wrap_select($select_html, $field_name, $additional_class, $include_blank, $required) {
    $classes = 'wpcf7-form-control wpcf7-select mcp-field';
    if ($required) {
      $classes .= ' wpcf7-validates-as-required';
    }
    if ($additional_class) {
      $classes .= ' ' . $additional_class;
    }

    // Build the <select> tag
    $atts = array(
      'name' => $field_name,
      'class' => $classes,
      'aria-invalid' => 'false',
    );
    if ($required) {
      $atts['aria-required'] = 'true';
    }

    $select_output = '<select ' . wpcf7_format_atts($atts) . '>';

    if ($include_blank) {
      $blank_label = __('&#8212;Please choose an option&#8212;', 'contact-form-7');
      $select_output .= '<option value="">' . esc_html($blank_label) . '</option>';
    }

    // Extract the <option> tags from the base select
    if (preg_match('/<select[^>]*>(.*)<\/select>/s', $select_html, $matches)) {
      $inner = $matches[1];
    } else {
      $inner = $select_html;
    }

    $select_output .= $inner . '</select>';

    return sprintf(
      '<span class="wpcf7-form-control-wrap" data-name="%s">%s</span>',
      esc_attr($field_name),
      $select_output
    );
  }
}

// Instantiate our class to run the logic
new CF7_MCP_Tags();

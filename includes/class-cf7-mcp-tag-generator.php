<?php

/**
 * Handles the CF7 admin tag generator panels for workshops and webinars.
 */

if (! defined('ABSPATH')) {
  exit;
}

class CF7_MCP_Tag_Generator {

  public function __construct() {
    add_action('wpcf7_admin_init', array($this, 'register_tag_generators'));
  }

  public function register_tag_generators() {
    if (! class_exists('WPCF7_TagGenerator')) {
      return;
    }
    $tg = WPCF7_TagGenerator::get_instance();

    // Workshops
    $tg->add(
      'mcp_workshops',
      __('MCP Workshops Select', 'cf7-mcp-event-manager'),
      array($this, 'workshops_tag_panel'),
      array('version' => '2')
    );

    // Webinars
    $tg->add(
      'mcp_webinars',
      __('MCP Webinars Select', 'cf7-mcp-event-manager'),
      array($this, 'webinars_tag_panel'),
      array('version' => '2')
    );
  }

  /**
   * Tag generator panel for workshops.
   */
  public function workshops_tag_panel($contact_form, $args = '') {
?>
    <div id="cf7_mcp_workshops_panel">
      <div class="control-box">
        <fieldset>
          <legend><?php echo esc_html(__('Generate MCP Workshops Select field', 'cf7-mcp-event-manager')); ?></legend>
          <table class="form-table">
            <tbody>
              <tr>
                <th scope="row"><?php echo esc_html(__('Field type', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="field_type" class="tg-name oneline" value="mcp_workshops" readonly="readonly" />
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Field name', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="field_name" class="tg-name oneline" value="workshops" />
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Required field', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <label>
                    <input type="checkbox" name="required" />
                    <?php echo esc_html(__('Required', 'cf7-mcp-event-manager')); ?>
                  </label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Options', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <label>
                    <input type="checkbox" name="include_blank" />
                    <?php echo esc_html(__('Include blank option', 'cf7-mcp-event-manager')); ?>
                  </label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('CSS Class', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="class" class="tg-name oneline" placeholder="<?php esc_attr_e('Optional extra class', 'cf7-mcp-event-manager'); ?>" />
                </td>
              </tr>
            </tbody>
          </table>
        </fieldset>
      </div>
      <div class="insert-box">
        <input type="text" name="mcp_workshops" class="tag code" readonly="readonly" onfocus="this.select()" value="[mcp_workshops workshops]" />
        <div class="submitbox">
          <input type="button" class="button insert-tag" value="<?php echo esc_attr(__('Insert Tag', 'cf7-mcp-event-manager')); ?>" />
        </div>
        <br class="clear" />
      </div>
    </div>
    <script>
      (function($) {
        $(document).ready(function() {
          function buildWorkshopsTag() {
            var panel = $('#cf7_mcp_workshops_panel');
            var fieldName = panel.find('input[name="field_name"]').val().trim();
            if (!fieldName) {
              fieldName = 'workshops';
            }
            var required = panel.find('input[name="required"]').is(':checked') ? '*' : '';
            var includeBlank = panel.find('input[name="include_blank"]').is(':checked') ? ' include_blank' : '';
            var extraClass = panel.find('input[name="class"]').val().trim();
            var classPart = extraClass ? ' class:' + extraClass : '';

            var tagType = required ? 'mcp_workshops*' : 'mcp_workshops';
            var finalTag = '[' + tagType + ' ' + fieldName + includeBlank + classPart + ']';
            panel.find('input.tag.code').val(finalTag);
          }
          $('#cf7_mcp_workshops_panel input[name="field_name"], #cf7_mcp_workshops_panel input[name="required"], #cf7_mcp_workshops_panel input[name="include_blank"], #cf7_mcp_workshops_panel input[name="class"]').on('change keyup', buildWorkshopsTag);
          buildWorkshopsTag();
        });
      })(jQuery);
    </script>
  <?php
  }

  /**
   * Tag generator panel for webinars.
   */
  public function webinars_tag_panel($contact_form, $args = '') {
  ?>
    <div id="cf7_mcp_webinars_panel">
      <div class="control-box">
        <fieldset>
          <legend><?php echo esc_html(__('Generate MCP Webinars Select field', 'cf7-mcp-event-manager')); ?></legend>
          <table class="form-table">
            <tbody>
              <tr>
                <th scope="row"><?php echo esc_html(__('Field type', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="field_type" class="tg-name oneline" value="mcp_webinars" readonly="readonly" />
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Field name', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="webinars_field_name" class="tg-name oneline" value="webinars" />
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Required field', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <label>
                    <input type="checkbox" name="required" />
                    <?php echo esc_html(__('Required', 'cf7-mcp-event-manager')); ?>
                  </label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('Options', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <label>
                    <input type="checkbox" name="webinars_include_blank" />
                    <?php echo esc_html(__('Include blank option', 'cf7-mcp-event-manager')); ?>
                  </label>
                </td>
              </tr>
              <tr>
                <th scope="row"><?php echo esc_html(__('CSS Class', 'cf7-mcp-event-manager')); ?></th>
                <td>
                  <input type="text" name="webinars_class" class="tg-name oneline" placeholder="<?php esc_attr_e('Optional extra class', 'cf7-mcp-event-manager'); ?>" />
                </td>
              </tr>
            </tbody>
          </table>
        </fieldset>
      </div>
      <div class="insert-box">
        <input type="text" name="mcp_webinars" class="tag code" readonly="readonly" onfocus="this.select()" value="[mcp_webinars webinars]" />
        <div class="submitbox">
          <input type="button" class="button insert-tag" value="<?php echo esc_attr(__('Insert Tag', 'cf7-mcp-event-manager')); ?>" />
        </div>
        <br class="clear" />
      </div>
    </div>
    <script>
      (function($) {
        $(document).ready(function() {
          function buildWebinarsTag() {
            var panel = $('#cf7_mcp_webinars_panel');
            var fieldName = panel.find('input[name="webinars_field_name"]').val().trim();
            if (!fieldName) {
              fieldName = 'webinars';
            }
            var required = panel.find('input[name="required"]').is(':checked') ? '*' : '';
            var includeBlank = panel.find('input[name="webinars_include_blank"]').is(':checked') ? ' include_blank' : '';
            var extraClass = panel.find('input[name="webinars_class"]').val().trim();
            var classPart = extraClass ? ' class:' + extraClass : '';

            var tagType = required ? 'mcp_webinars*' : 'mcp_webinars';
            var finalTag = '[' + tagType + ' ' + fieldName + includeBlank + classPart + ']';
            panel.find('input.tag.code').val(finalTag);
          }
          $('#cf7_mcp_webinars_panel input[name="webinars_field_name"], #cf7_mcp_webinars_panel input[name="required"], #cf7_mcp_webinars_panel input[name="webinars_include_blank"], #cf7_mcp_webinars_panel input[name="webinars_class"]').on('change keyup', buildWebinarsTag);
          buildWebinarsTag();
        });
      })(jQuery);
    </script>
<?php
  }
}

// Instantiate
new CF7_MCP_Tag_Generator();

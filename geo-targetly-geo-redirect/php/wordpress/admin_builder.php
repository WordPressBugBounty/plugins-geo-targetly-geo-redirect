<?php
namespace GeoTargetly\GeoRedirect;

/**
 * @param string $title
 * @param callable $renderDescriptionSection
 * @return void
 */
function register_wp_menu($title, $renderDescriptionSection, $id = null)
{
  add_action('admin_menu', function () use (
    $title,
    $renderDescriptionSection,
    $id
  ) {
    add_menu_page(
      "$title - Geo Targetly",
      $title,
      'manage_options',
      !empty($id) ? $id : get_unique_id(),
      function () use ($title, $renderDescriptionSection) {
        return require __DIR__ . '/html/settings_page.php';
      },
      'dashicons-location'
    );
  });
}

function register_wp_settings($legacyOptionName = null, $legacyFieldName = null)
{
  add_action('admin_init', function () use (
    $legacyOptionName,
    $legacyFieldName
  ) {
    register_setting(get_unique_id('pluginPage'), get_settings_field_name(), [
      'sanitize_callback' => function ($input) {
        $ids = array_map(
          'sanitize_text_field',
          explode(',', $input[get_unique_id('ids')])
        );
        return [get_unique_id('ids') => implode(',', $ids)];
      },
    ]);
    add_settings_section(
      get_unique_id('pluginPage_section'),
      __('Settings', 'geo-targetly-geo-redirect'),
      function () {
        echo '';
      },
      get_unique_id('pluginPage')
    );
    add_settings_field(
      get_unique_id('ids'),
      __('IDs (comma separated)', 'geo-targetly-geo-redirect'),
      function () use ($legacyOptionName, $legacyFieldName) {
        $optionFieldName = get_settings_field_name();
        $options = get_option($optionFieldName);
        $arrayKey = get_unique_id('ids');
        $fieldName = $arrayKey;
        if (empty($options) && $legacyOptionName && $legacyFieldName) {
          $options = get_option($legacyOptionName);
          $fieldName = $legacyFieldName;
        }
        $name = "{$optionFieldName}[$arrayKey]";
        $value = is_array($options) ? $options[$fieldName] : '';
        return require __DIR__ . '/html/ids_input.php';
      },
      get_unique_id('pluginPage'),
      get_unique_id('pluginPage_section')
    );
  });
}

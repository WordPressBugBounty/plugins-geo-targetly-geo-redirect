<?php
namespace GeoTargetly\GeoRedirect;

function inject_script($legacyOptionName = null, $legacyFieldName = null)
{
  add_action('init', function () use ($legacyOptionName, $legacyFieldName) {
    $optionFieldName = get_settings_field_name();
    $options = get_option($optionFieldName);
    $fieldName = get_unique_id('ids');
    if (empty($options) && $legacyOptionName && $legacyFieldName) {
      $options = get_option($legacyOptionName);
      $fieldName = $legacyFieldName;
    }
    $value = is_array($options) ? $options[$fieldName] : '';
    $ids = array_filter(
      array_map(function ($value) {
        return trim($value);
      }, explode(',', $value)),
      function ($value) {
        return !empty($value);
      }
    );
    foreach ($ids as $i => $resourceId) {
      add_action('wp_enqueue_scripts', function () use ($resourceId, $i) {
        $scriptId = get_unique_id("script_$i");
        wp_register_script($scriptId, false, null, '1.0', [
          'in_footer' => false,
        ]);
        wp_enqueue_script($scriptId);
        ob_start();
        include __DIR__ . '/../../shared/templates/script.js.php';
        $script = ob_get_clean();
        wp_add_inline_script($scriptId, $script);
      });
    }
  });
}

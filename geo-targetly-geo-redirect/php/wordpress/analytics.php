<?php
namespace GeoTargetly\GeoRedirect;
function register_wp_installation($file)
{
  register_activation_hook($file, function () {
    $opt = get_option(get_instance_field_name());
    if (!empty($opt)) {
      return;
    }
    $id = get_wp_instance_id();
    $payload = [
      'instanceId' => $id,
      'siteUrl' => get_site_url(),
      'plugin' => 'geo_redirect',
      'cms' => [
        'version' => get_bloginfo('version'),
        'name' => 'wordpress',
      ],
      'runtime' => [
        'name' => 'php',
        'version' => PHP_VERSION,
      ],
    ];

    $response = wp_remote_post(GT_PLUGINS_API_URL . 'wordpress/install', [
      'timeout' => 5,
      'headers' => [
        'Content-Type' => 'application/json',
      ],
      'body' => wp_json_encode($payload),
    ]);

    if (is_wp_error($response)) {
      return;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 201) {
      return;
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    if (!is_array($data) || empty($data['id'])) {
      return;
    }

    update_option(get_instance_field_name(), $data['id'], false);
  });

  register_deactivation_hook($file, function () {
    $id = get_option(get_instance_field_name());
    if (empty($id)) {
      return;
    }
    wp_remote_post(GT_PLUGINS_API_URL . "wordpress/$id/uninstall", [
      'timeout' => 5,
      'headers' => [
        'Content-Type' => 'application/json',
      ],
    ]);
    delete_option(get_instance_field_name());
  });
}

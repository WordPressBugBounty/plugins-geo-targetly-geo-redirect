<?php
/*
 * Plugin Name: Geo Redirect
 * Description: Redirect your website by geo location
 * Version: 8.0.1
 * Author: Geo Targetly
 * Author URI: https://geotargetly.com
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Contributors: geotargetly
 */
namespace GeoTargetly\GeoRedirect;
if (!defined('ABSPATH')) {
  exit();
}

require_once __DIR__ . '/php/shared/autoload.php';
require_once __DIR__ . '/php/wordpress/autoload.php';

register_wp_menu(
  'Geo Redirect',
  function () {
    include __DIR__ . '/templates/settings_description.php';
  },
  'geotargetly_wp_georedirect'
);
register_wp_settings(
  'geotargetly_wp_georedirect_settings',
  'geotargetly_wp_georedirect_ids'
);

inject_script(
  'geotargetly_wp_georedirect_settings',
  'geotargetly_wp_georedirect_ids'
);

register_wp_installation(__FILE__);

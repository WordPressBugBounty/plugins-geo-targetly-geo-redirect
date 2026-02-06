<?php
namespace GeoTargetly\GeoRedirect;

function get_settings_field_name()
{
  return get_unique_id('settings');
}

function get_instance_field_name()
{
  return get_unique_id('instance');
}

function get_wp_instance_id()
{
  return get_instance_id(get_site_url());
}

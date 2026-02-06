<?php
namespace GeoTargetly\GeoRedirect;

function get_unique_id($resource = null)
{
  return 'geotargetly_geo_redirect' . ($resource ? "_$resource" : '');
}

function get_instance_id($siteId)
{
  $salt = get_unique_id('instance_id');
  return hash('sha512', $salt . '|' . $siteId);
}

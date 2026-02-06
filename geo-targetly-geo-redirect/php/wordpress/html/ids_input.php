<?php
namespace GeoTargetly\GeoRedirect;
if (!defined('ABSPATH')) {
  exit();
}
/**
 * @var string $name
 * @var string $value
 */
?>
<input type='text'
       name='<?php echo esc_attr($name); ?>'
       value='<?php echo esc_attr($value); ?>'>
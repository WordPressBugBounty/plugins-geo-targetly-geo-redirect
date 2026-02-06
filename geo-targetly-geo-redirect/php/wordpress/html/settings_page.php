<?php
namespace GeoTargetly\GeoRedirect;
if (!defined('ABSPATH')) {
  exit();
}
/**
 * @var string $pluginSlug
 * @var string $title
 * @var callable $renderDescriptionSection
 */
?>
<form action='options.php' method='post'>
  <div id="post-body" class="metabox-holder columns-2">
    <div id="post-body-content">

      <h2><?php echo esc_html($title); ?> - By Geo Targetly</h2>

      <div class="postbox" style="width:70%; padding:30px;">
        <h2>Getting Started</h2>
        <?php if (is_callable($renderDescriptionSection)) {
          $renderDescriptionSection();
        } ?>
      </div>

      <div class="postbox" style="width:70%; padding:30px;">
          <?php
          settings_fields(get_unique_id('pluginPage'));
          do_settings_sections(get_unique_id('pluginPage'));
          submit_button();
          ?>
      </div>
    </div>
  </div>
</form>

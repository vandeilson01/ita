<div id="fotos_slide">
<?php
/**
 * @file
 * Template file for field_slideshow
 *
 *
 */

// Should fix issue #1502772
// @todo: find a nicer way to fix this
if (!isset($controls_position)) {
  $controls_position = "after";
}
if (!isset($pager_position)) {
  $pager_position = "after";
}
?>

  <?php if ($controls_position == "before")  print(render($controls)); ?>
  <?php if ($pager_position == "before")  print(render($pager)); ?>

  <div class="slide <?php print $classes; ?>">
    <?php foreach ($items as $num => $item) : ?>
      <div <?php if ($num) : ?> style="display:none;"<?php endif; ?>>
        <?php print $item['image']; ?>
        <?php if (isset($item['caption']) && $item['caption'] != '') : ?>
            <span class="field-slideshow-caption-text"><?php print $item['caption']; ?></span>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <?php if ($controls_position != "before") print(render($controls)); ?>

  <?php if ($pager_position != "before") print(render($pager)); ?>
</div>

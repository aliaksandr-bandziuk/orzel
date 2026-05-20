<?php

/**
 * Block Name: Before After Block
 */

$block_id = 'before-after-block-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'before-after-block';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';
$before_image = get_field('before_image');
$after_image = get_field('after_image');
$before_label = get_field('before_label') ?: 'Before';
$after_label = get_field('after_label') ?: 'After';

if (!$before_image || !$after_image) {
  return;
}
?>

<section <?php echo get_block_wrapper_attributes([
            'id' => $block_id,
            'class' => $classes,
          ]); ?>>

  <div class="before-after-block__container">

    <?php if ($pretitle || $title) : ?>
      <div class="block-precontent mb50">

        <?php if ($pretitle) : ?>
          <p class="block-precontent__descr mb10">
            <?php echo esc_html($pretitle); ?>
          </p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="h2">
            <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>

      </div>
    <?php endif; ?>

    <div data-fls-beforeafter class="before-after">

      <!-- BEFORE -->
      <div data-fls-beforeafter-before class="before-after__item before-after__item--before">
        <?php echo wp_get_attachment_image(
          $before_image['ID'],
          'before-after-main',
          false,
          [
            'alt'      => esc_attr($before_label),
            'loading'  => 'lazy',
            'decoding' => 'async',
            'sizes'    => '100vw',
          ]
        ); ?>
      </div>

      <!-- AFTER -->
      <div data-fls-beforeafter-after class="before-after__item before-after__item--after">
        <?php echo wp_get_attachment_image(
          $after_image['ID'],
          'before-after-main',
          false,
          [
            'alt'      => esc_attr($after_label),
            'loading'  => 'lazy',
            'decoding' => 'async',
            'sizes'    => '100vw',
          ]
        ); ?>
      </div>

      <!-- HANDLE -->
      <div data-fls-beforeafter-arrow class="before-after__arrow" aria-hidden="true">
        <span class="before-after__handle"></span>
      </div>

    </div>

  </div>
</section>
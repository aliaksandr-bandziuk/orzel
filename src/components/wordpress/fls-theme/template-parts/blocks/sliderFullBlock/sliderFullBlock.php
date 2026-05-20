<?php

/**
 * Block: Slider Full Block
 */

$images = get_field('gallery_images');
$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';

if (empty($images)) {
  return;
}

$block_id = 'slider-full-block-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'slider-full-block';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

// Для ACF block supports
$wrapper_attributes = '';

if (function_exists('get_block_wrapper_attributes')) {
  $wrapper_attributes = get_block_wrapper_attributes([
    'id'    => $block_id,
    'class' => $classes,
  ]);
} else {
  $wrapper_attributes = sprintf(
    'id="%s" class="%s"',
    esc_attr($block_id),
    esc_attr($classes)
  );
}
?>

<section <?php echo $wrapper_attributes; ?> data-slider-full-block>
  <div class="slider-full-block__container">

    <?php if ($pretitle || $title) : ?>
      <div class="block-precontent mb50">

        <?php if ($pretitle) : ?>
          <p class="block-precontent__descr mb10">
            <?php echo esc_html($pretitle); ?>
          </p>
        <?php endif; ?>

        <?php if ($title) : ?>
          <h2 class="h2 block-precontent__title mb30">
            <?php echo esc_html($title); ?>
          </h2>
        <?php endif; ?>

      </div>
    <?php endif; ?>

    <div class="slider-full-block__wrap">

      <div class="slider-full-block__col">
        <div class="slider-full-block__thumbs-wrap">
          <div class="swiper slider-full-block__thumbs">
            <div class="swiper-wrapper">
              <?php foreach ($images as $image) : ?>
                <div class="swiper-slide">
                  <div class="slider-full-block__thumb">
                    <img
                      src="<?php echo esc_url($image['sizes']['thumbnail'] ?? $image['url']); ?>"
                      alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>" />
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="slider-full-block__images">
        <div class="swiper slider-full-block__main">
          <div class="swiper-wrapper">
            <?php foreach ($images as $image) : ?>
              <div class="swiper-slide">
                <div class="slider-full-block__image">
                  <img
                    src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                    alt="<?php echo esc_attr($image['alt'] ?: $image['title']); ?>" />
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>



    </div>
  </div>
</section>
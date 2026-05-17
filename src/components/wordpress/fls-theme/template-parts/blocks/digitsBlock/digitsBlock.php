<?php

/**
 * Digits Block
 */

$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';
$digit_items = get_field('digit_items');

$classes = 'digits';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}

$wrapper_attributes = get_block_wrapper_attributes([
  'class' => $classes,
]);
?>

<?php if (!empty($digit_items)) : ?>
  <section <?php echo $wrapper_attributes; ?>>
    <div class="digits__container">

      <?php if ($pretitle || $title) : ?>
        <div class="block-precontent mb50">

          <?php if ($pretitle) : ?>
            <div class="section-pretitle mb20">
              <span></span>
              <?php echo esc_html($pretitle); ?>
            </div>
          <?php endif; ?>

          <?php if ($title) : ?>
            <h2 class="h2 block-precontent__title mb50">
              <?php echo esc_html($title); ?>
            </h2>
          <?php endif; ?>

        </div>
      <?php endif; ?>

      <div class="digits__items">
        <div class="digits__wrapper">

          <?php foreach ($digit_items as $item) :
            $digit_icon     = $item['digit_icon'] ?? '';
            $counter_value  = $item['counter_value'] ?? '';
            $counter_symbol = $item['counter_symbol'] ?? '';
            $digit_title    = $item['digit_title'] ?? '';
            $digit_text     = $item['digit_text'] ?? '';

            $icon_url = '';

            if (is_array($digit_icon) && !empty($digit_icon['url'])) {
              $icon_url = $digit_icon['url'];
            } elseif (is_numeric($digit_icon)) {
              $icon_url = wp_get_attachment_image_url($digit_icon, 'full');
            } elseif (is_string($digit_icon)) {
              $icon_url = $digit_icon;
            }
          ?>
            <div class="digit-item">
              <div class="digit-item__wrapper">

                <?php if ($icon_url) : ?>
                  <div class="digit-item__icon">
                    <img src="<?php echo esc_url($icon_url); ?>" alt="" loading="lazy">
                  </div>
                <?php endif; ?>

                <div class="digit-item__counter--inner">
                  <div class="digit-item__counter">
                    <p class="counter">
                      <span class="counter__value"><?php echo esc_html($counter_value); ?></span>
                      <?php if (!empty($counter_symbol)) : ?>
                        <?php echo esc_html($counter_symbol); ?>
                      <?php endif; ?>
                    </p>
                  </div>

                  <?php if ($digit_title || $digit_text) : ?>
                    <div class="digit-item__content">
                      <?php if ($digit_title) : ?>
                        <p class="digit-item__title">
                          <?php echo esc_html($digit_title); ?>
                        </p>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

    </div>
  </section>
<?php endif; ?>
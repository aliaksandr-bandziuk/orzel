<?php

/**
 * Block Name: Reviews Block
 */

$block_id = 'reviews-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'reviews';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'prev' => [
    'pl' => 'Poprzedni slajd',
    'en' => 'Previous slide',
    'ru' => 'Предыдущий слайд',
    'uk' => 'Попередній слайд',
  ],
  'next' => [
    'pl' => 'Następny slajd',
    'en' => 'Next slide',
    'ru' => 'Следующий слайд',
    'uk' => 'Наступний слайд',
  ],
  'default_position' => [
    'pl' => 'Opinia klienta',
    'en' => 'Client review',
    'ru' => 'Отзыв клиента',
    'uk' => 'Відгук клієнта',
  ],
];

$shape_image = get_field('shape_image');
$reviews = get_field('reviews_list');

if (empty($reviews) || !is_array($reviews)) {
  return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <?php if (!empty($shape_image['ID'])) : ?>
    <?php
    echo wp_get_attachment_image(
      $shape_image['ID'],
      'full',
      false,
      [
        'class'    => 'reviews__shape',
        'alt'      => '',
        'loading'  => 'lazy',
        'decoding' => 'async',
      ]
    );
    ?>
  <?php else : ?>
    <img src="/wp-content/uploads/2026/05/shape-166.png" alt="" class="reviews__shape" loading="lazy" decoding="async">
  <?php endif; ?>

  <div class="reviews__layout">
    <div class="reviews__container">
      <div class="reviews__body">
        <div class="reviews__main">
          <div class="reviews__slider slider-block" data-fls-slider data-slider-type="reviews">
            <div class="reviews__slider-wrap swiper">
              <div class="reviews__wrapper swiper-wrapper">

                <?php foreach ($reviews as $index => $review) :
                  $text = $review['text'] ?? '';
                  $name = $review['name'] ?? '';
                  $position = $review['position'] ?? $i18n['default_position'][$lang];
                ?>
                  <div
                    class="reviews__slide swiper-slide"
                    data-review-gallery-id="<?php echo esc_attr($index); ?>">
                    <div class="reviews__content">
                      <div class="reviews__bg" aria-hidden="true">
                        <img
                          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/reviews/car-outline.svg'); ?>"
                          alt=""
                          loading="lazy"
                          decoding="async">
                      </div>

                      <div class="reviews__quote" aria-hidden="true">
                        <img
                          src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icons/quote.svg'); ?>"
                          alt=""
                          loading="lazy"
                          decoding="async">
                      </div>

                      <?php if (!empty($text)) : ?>
                        <div class="reviews__text">
                          <div><?php echo wp_kses_post($text); ?></div>
                        </div>
                      <?php endif; ?>

                      <div class="reviews__author">
                        <div class="reviews__info">
                          <?php if (!empty($name)) : ?>
                            <div class="reviews__name"><?php echo esc_html($name); ?></div>
                          <?php endif; ?>

                          <?php if (!empty($position)) : ?>
                            <div class="reviews__position"><?php echo esc_html($position); ?></div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

              </div>
            </div>

            <div class="reviews__controls">
              <button class="reviews__button reviews__button--prev" type="button" aria-label="<?php echo esc_attr($i18n['prev'][$lang]); ?>">
                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M11.5 5L6.5 10L11.5 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>

              <button class="reviews__button reviews__button--next" type="button" aria-label="<?php echo esc_attr($i18n['next'][$lang]); ?>">
                <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M8.5 5L13.5 10L8.5 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="reviews__media">
      <?php foreach ($reviews as $index => $review) :
        $gallery = $review['gallery'] ?? [];
        $has_gallery =
          !empty($gallery) &&
          is_array($gallery);
      ?>
        <div
          class="reviews__media-gallery <?php echo $index === 0 ? 'is-active' : ''; ?>"
          data-review-gallery-id="<?php echo esc_attr($index); ?>">

          <?php if ($has_gallery): ?>

            <div class="reviews__media-slider swiper">
              <div class="swiper-wrapper">

                <?php foreach ($gallery as $image):

                  if (empty($image['ID'])) {
                    continue;
                  }

                  $image_alt =
                    !empty($image['alt'])
                    ? $image['alt']
                    : 'Review image';
                ?>

                  <div class="swiper-slide">
                    <?php
                    echo wp_get_attachment_image(
                      $image['ID'],
                      'review-gallery',
                      false,
                      [
                        'alt'      => esc_attr($image_alt),
                        'loading'  => 'lazy',
                        'decoding' => 'async',
                        'sizes' =>
                        '(max-width:767px)100vw,
                                    (max-width:1200px)50vw,
                                    720px',
                      ]
                    );
                    ?>
                  </div>

                <?php endforeach; ?>

              </div>

              <div class="reviews__media-pagination"></div>
            </div>

          <?php else: ?>

            <div class="reviews__placeholder">
              <img
                src="/wp-content/uploads/2026/05/handiman.jpg"
                alt="Remonty mieszkań"
                loading="lazy"
                decoding="async">
            </div>

          <?php endif; ?>

        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
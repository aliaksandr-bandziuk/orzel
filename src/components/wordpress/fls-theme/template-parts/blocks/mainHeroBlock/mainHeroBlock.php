<?php
$background_image = get_field('background_image');
$overline         = get_field('pretitle');        // reused ACF field; class renamed to main-hero__pretitle (overline style)
$title            = get_field('title');
$description      = get_field('description');     // new ACF field — add it in block registration
$show_decor       = get_field('show_decor');

$services_text    = get_field('services_text');
$services_url     = get_field('services_url');

$popup_text       = get_field('popup_text');
$popup_link       = get_field('popup_link');

$image_id = !empty($background_image['ID']) ? (int) $background_image['ID'] : 0;

$image_alt = !empty($background_image['alt'])
  ? $background_image['alt']
  : (!empty($title) ? wp_strip_all_tags($title) : 'Hero image');

$section_classes = 'main-hero';
?>

<section class="<?php echo esc_attr($section_classes); ?>">
  <div class="main-hero__media">
    <?php if ($image_id) : ?>
      <div class="main-hero__image">
        <?php
        echo wp_get_attachment_image(
          $image_id,
          'hero-main',
          false,
          [
            'class'         => 'main-hero__img',
            'alt'           => esc_attr($image_alt),
            'loading'       => 'eager',
            'fetchpriority' => 'high',
            'decoding'      => 'async',
            'sizes'         => '100vw',
          ]
        );
        ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="main-hero__body">
    <div class="main-hero__container">
      <div class="main-hero__content">

        <?php if (!empty($overline)) : ?>
          <p class="main-hero__pretitle">
            <?php echo esc_html($overline); ?>
          </p>
        <?php endif; ?>

        <?php if (!empty($title)) : ?>
          <h1 class="main-hero__title">
            <?php echo nl2br(esc_html($title)); ?>
          </h1>
        <?php endif; ?>

        <?php if (!empty($description)) : ?>
          <p class="main-hero__description">
            <?php echo esc_html($description); ?>
          </p>
        <?php endif; ?>

        <?php if ($show_decor) : ?>
          <span class="--icon-decor-double-line-white main-hero__decor" aria-hidden="true"></span>
        <?php endif; ?>

        <div class="main-hero__buttons">

          <?php if (!empty($services_url) && !empty($services_text)) : ?>
            <a href="<?php echo esc_url($services_url); ?>" class="services-main main-btn">
              <div class="services-main__wrapper">
                <span class="services-main__icon --icon-ico-triangle" aria-hidden="true"></span>
                <span class="services-main__text">
                  <?php echo esc_html($services_text); ?>
                </span>
              </div>
            </a>
          <?php endif; ?>

          <?php if (!empty($popup_text) && !empty($popup_link)) : ?>
            <button
              data-fls-popup-link="<?php echo esc_attr($popup_link); ?>"
              class="button-main main-btn"
              type="button">
              <div class="button-main__wrapper">
                <span class="button-main__icon --icon-ico-triangle" aria-hidden="true"></span>
                <span class="button-main__text">
                  <?php echo esc_html($popup_text); ?>
                </span>
              </div>
            </button>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>

<?php
$pretitle = get_field('pretitle') ?: 'ABOUT US';
$title = get_field('title') ?: 'Devoted to Delivering Top Notch Roofing Solutions';
$text = get_field('text') ?: 'It is a long established fact that a reader will be distracted the readable content of a page when looking at layout the point of using lorem the is Ipsum less normal distribution of letters.';

$main_image = get_field('main_image');
$secondary_image = get_field('secondary_image');

$experience_number = get_field('experience_number') ?: '10+';
$experience_text = get_field('experience_text') ?: 'World Best Roofing Award Got';

$features = get_field('features');

$button_text = get_field('button_text') ?: 'ABOUT US';
$button_link = get_field('button_link') ?: '#';

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

$phone_label = $current_lang == 'pl'
  ? 'Zadzwoń teraz'
  : ($current_lang == 'ru'
    ? 'Позвоните нам'
    : ($current_lang == 'uk'
      ? 'Зателефонуйте нам'
      : 'Call us'));

$phone_number = get_field('phone_number') ?: '517 351 391';
$phone_href = preg_replace('/\D+/', '', $phone_number);
?>

<section class="about-remont-block">
  <img src="http://localhost:8080/wp-content/uploads/2026/05/shape-31.png" alt="O firme Orzeł Realty" class="about-remont-block__shape">
  <div class="about-remont-block__container">

    <div class="about-remont-block__media">
      <?php if ($main_image): ?>
        <img
          class="about-remont-block__main-img"
          src="<?php echo esc_url($main_image['url']); ?>"
          alt="<?php echo esc_attr($main_image['alt'] ?: $title); ?>">
      <?php endif; ?>

      <div class="about-remont-block__badge">
        <div class="about-remont-block__badge-top">
          <span><?php echo esc_html($experience_number); ?></span>
          <p><?php echo esc_html($experience_text); ?></p>
        </div>

        <div class="about-remont-block__badge-icon">
          <img src="/wp-content/uploads/2026/05/about-cup.png" alt="O firme Orzeł Realty">
        </div>
      </div>

      <?php if ($secondary_image): ?>
        <div class="about-remont-block__secondary">
          <img
            src="<?php echo esc_url($secondary_image['url']); ?>"
            alt="<?php echo esc_attr($secondary_image['alt'] ?: $title); ?>">
        </div>
      <?php endif; ?>
    </div>

    <div class="about-remont-block__content">
      <div class="section-pretitle">
        <span></span>
        <?php echo esc_html($pretitle); ?>
      </div>

      <h2 class="h2 mt20 mb30">
        <?php echo esc_html($title); ?>
      </h2>

      <div class="about-remont-block__text">
        <?php echo wp_kses_post($text); ?>
      </div>

      <?php if ($features): ?>
        <ul class="about-remont-block__features">
          <?php foreach ($features as $item): ?>
            <li>
              <span></span>
              <?php echo esc_html($item['text']); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <div class="about-remont-block__bottom">
        <a href="<?php echo esc_url($button_link); ?>" class="button-primary">
          <?php echo esc_html($button_text); ?>
        </a>

        <a href="tel:+48<?php echo esc_attr($phone_href); ?>" class="header-phone-button">
          <span class="header-phone-button__icon">
            <img src="/wp-content/uploads/2026/05/phone-call.png" alt="Phone">
          </span>

          <div class="header-phone-button__text">
            <p><?php echo esc_html($phone_label); ?></p>
            <p><?php echo esc_html($phone_number); ?></p>
          </div>
        </a>
      </div>
    </div>

  </div>
</section>
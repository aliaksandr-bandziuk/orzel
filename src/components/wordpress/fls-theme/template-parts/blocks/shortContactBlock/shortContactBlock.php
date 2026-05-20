<?php

/**
 * Block Name: Short Contact Block
 */

$block_id = 'short-contact-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'short-form';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$title       = get_field('title') ?: 'Chcesz taki efekt? Skontaktuj się z nami';
$description = get_field('description') ?: 'Skontaktujemy się z Tobą od razu po otrzymaniu wiadomości.';
$button_text = get_field('button_text') ?: 'Oddzwonić';

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

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'phone' => [
    'pl' => 'Telefon',
    'en' => 'Phone',
    'ru' => 'Телефон',
    'uk' => 'Телефон',
  ],
];

$phone_label = $i18n['phone'][$lang];
?>

<section <?php echo $wrapper_attributes; ?> aria-label="<?php echo esc_attr($title); ?>">
  <div class="short-form__container">
    <div class="short-form__wrapper">
      <p class="title-lite text-center mb20">
        <?php echo esc_html($title); ?>
      </p>

      <p class="text-center mb30 short-form__description">
        <?php echo esc_html($description); ?>
      </p>

      <form
        action="<?php echo esc_url(get_template_directory_uri() . '/sendmail/index.php'); ?>"
        method="post"
        autocomplete="off"
        aria-label="<?php echo esc_attr($title); ?>"
        class="small-form form-sending"
        data-fls-form="ajax"
        data-fls-form-popup="popup-thanks">

        <input type="hidden" name="page_url" value="">
        <input type="hidden" name="form_name" value="Краткая форма">

        <div style="position:absolute; left:-9999px; opacity:0; pointer-events:none;" aria-hidden="true">
          <label for="website_<?php echo esc_attr($block['id']); ?>">Website</label>
          <input
            type="text"
            name="website"
            id="website_<?php echo esc_attr($block['id']); ?>"
            tabindex="-1"
            autocomplete="off">
        </div>

        <div class="input-container">
          <input
            type="tel"
            name="phone"
            id="short_phone_<?php echo esc_attr($block['id']); ?>"
            class="input-contact"
            inputmode="tel"
            autocomplete="tel"
            placeholder="+48 123 456 789"
            required
            data-phone-input
            data-fls-form-errtext="<?php echo esc_attr(
                                      $lang === 'pl' ? 'Wpisz numer telefonu' : ($lang === 'ru' ? 'Введите номер телефона' : ($lang === 'uk' ? 'Введіть номер телефону' : 'Enter your phone number'))
                                    ); ?>"
            data-phone-error="<?php echo esc_attr(
                                $lang === 'pl' ? 'Wpisz poprawny numer telefonu w formacie międzynarodowym, np. +48 123 456 789.' : ($lang === 'ru' ? 'Введите корректный номер телефона в международном формате, например: +48 123 456 789.' : ($lang === 'uk' ? 'Введіть коректний номер телефону в міжнародному форматі, наприклад: +48 123 456 789.' :
                                  'Enter a valid phone number in international format, e.g. +48 123 456 789.'))
                              ); ?>" />
          <label for="short_phone_<?php echo esc_attr($block['id']); ?>"><?php echo esc_html($phone_label); ?></label>
          <span><?php echo esc_html($phone_label); ?></span>
        </div>

        <div class="form-message" aria-live="polite"></div>

        <button type="submit" class="button-primary btn w_btn2" aria-label="<?php echo esc_attr($button_text); ?>">
          <?php echo esc_html($button_text); ?>
        </button>
      </form>
    </div>
  </div>
</section>
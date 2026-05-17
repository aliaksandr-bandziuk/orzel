<?php

/**
 * Block Name: Final Contact Block
 */

$block_id = 'final-contact-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'final-contact';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$title       = get_field('title') ?: 'Skontaktuj się z nami';
$description = get_field('description') ?: 'Masz pytanie lub chcesz otrzymać wycenę? Wypełnij formularz, a odpowiemy tak szybko, jak to możliwe.';
$button_text = get_field('button_text') ?: 'Wyślij formularz';

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

$i18n = [
  'name' => [
    'pl' => 'Imię',
    'en' => 'Name',
    'ru' => 'Имя',
    'uk' => 'Ім’я',
  ],
  'phone' => [
    'pl' => 'Telefon',
    'en' => 'Phone',
    'ru' => 'Телефон',
    'uk' => 'Телефон',
  ],
  'message' => [
    'pl' => 'Opisz zakres remontu (nieobowiązkowo)',
    'en' => 'Describe your renovation project (optional)',
    'ru' => 'Опишите ремонт (необязательно)',
    'uk' => 'Опишіть ремонт (необов’язково)',
  ],
  'message_placeholder' => [
    'pl' => 'np. remont łazienki, wykończenie mieszkania',
    'en' => 'e.g. bathroom renovation, apartment finishing',
    'ru' => 'например: ремонт ванной, отделка квартиры',
    'uk' => 'наприклад: ремонт ванної, оздоблення квартири',
  ],
  'upload' => [
    'pl' => 'Dodaj zdjęcia pomieszczenia',
    'en' => 'Add photos of the property',
    'ru' => 'Добавьте фото помещения',
    'uk' => 'Додайте фото приміщення',
  ],
  'upload_note' => [
    'pl' => 'Maksymalnie 10 zdjęć, do 5 MB każde.',
    'en' => 'Maximum 10 photos, 5 MB each.',
    'ru' => 'До 10 фото, максимум 5 МБ каждое.',
    'uk' => 'До 10 фото, максимум 5 МБ кожне.',
  ],
];

?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <div class="final-contact__container">

    <div class="final-contact__inner">

      <h2 class="h2-white mb20">
        <?php echo esc_html($title); ?>
      </h2>

      <p class="final-contact__description mb20">
        <?php echo esc_html($description); ?>
      </p>

      <form
        action="<?php echo esc_url(get_template_directory_uri() . '/sendmail/index.php'); ?>"
        method="post"
        autocomplete="off"
        class="small-form form-sending"
        enctype="multipart/form-data"
        data-fls-form="ajax"
        data-fls-form-popup="popup-thanks">

        <input type="hidden" name="page_url" value="">
        <input type="hidden" name="form_name" value="Контактная форма">

        <div class="input-container">
          <input
            type="text"
            name="name"
            id="name_<?php echo esc_attr($block['id']); ?>"
            class="input-contact"
            required>

          <label for="name_<?php echo esc_attr($block['id']); ?>">
            <?php echo esc_html($i18n['name'][$lang]); ?>
          </label>

          <span><?php echo esc_html($i18n['name'][$lang]); ?></span>
        </div>

        <div class="input-container">
          <input
            type="tel"
            name="phone"
            id="phone_<?php echo esc_attr($block['id']); ?>"
            class="input-contact"
            required
            placeholder="+48 123 456 789">

          <label for="phone_<?php echo esc_attr($block['id']); ?>">
            <?php echo esc_html($i18n['phone'][$lang]); ?>
          </label>

          <span><?php echo esc_html($i18n['phone'][$lang]); ?></span>
        </div>

        <div class="input-container textarea">
          <textarea
            name="message"
            id="message_<?php echo esc_attr($block['id']); ?>"
            class="input-contact"
            placeholder="<?php echo esc_attr($i18n['message_placeholder'][$lang]); ?>">
          </textarea>

          <label for="message_<?php echo esc_attr($block['id']); ?>">
            <?php echo esc_html($i18n['message'][$lang]); ?>
          </label>

          <span>
            <?php echo esc_html($i18n['message'][$lang]); ?>
          </span>
        </div>

        <div class="file-upload">

          <input
            type="file"
            name="photos[]"
            id="photos_<?php echo esc_attr($block['id']); ?>"
            class="input-file"
            multiple
            accept=".jpg,.jpeg,.png,.webp">

          <label
            for="photos_<?php echo esc_attr($block['id']); ?>"
            class="file-label">

            <?php echo esc_html($i18n['upload'][$lang]); ?>

          </label>

          <div class="file-note">
            <?php echo esc_html($i18n['upload_note'][$lang]); ?>
          </div>

          <div class="file-list"></div>

        </div>

        <button
          type="submit"
          class="button-primary btn">

          <?php echo esc_html($button_text); ?>

        </button>

      </form>

    </div>

  </div>
</section>
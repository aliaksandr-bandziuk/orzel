<?php

/**
 * Block Name: FAQ Block
 */

$block_id = 'faq-block-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'faq';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle') ?: '';
$title = get_field('title') ?: '';
$items = get_field('faq_items');

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

<section <?php echo $wrapper_attributes; ?>>
  <div class="faq__container">

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

        <div class="about-company__divider mb30" aria-hidden="true">
          <svg xmlns="http://www.w3.org/2000/svg" width="64" height="8">
            <path fill="#fd6b1c" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
          </svg>
        </div>

      </div>
    <?php endif; ?>

    <?php if ($items) : ?>
      <div class="faq__wrapper">
        <div data-fls-spollers data-fls-spollers-one class="spollers faq-spollers">

          <?php foreach ($items as $item) :

            $question = trim($item['question'] ?? '');
            $answer   = trim($item['answer'] ?? '');

            if ($question === '' || $answer === '') {
              continue;
            }

            if (function_exists('felgilab_add_faq_schema_item')) {
              felgilab_add_faq_schema_item($question, $answer);
            }

          ?>

            <details class="faq-spollers__item">
              <summary class="faq-spollers__title">
                <?php echo esc_html($question); ?>
              </summary>

              <div class="faq-spollers__body">
                <?php echo wp_kses_post($answer); ?>
              </div>
            </details>

          <?php endforeach; ?>

        </div>
      </div>
    <?php endif; ?>

  </div>
</section>
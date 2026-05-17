<?php

/**
 * @var array $block
 */

$block = $block ?? [];

$block_id = !empty($block['anchor'])
  ? $block['anchor']
  : 'main-bullets-' . ($block['id'] ?? uniqid());

$section_pretitle = get_field('section_pretitle');
$section_title    = get_field('section_title');
$section_text     = get_field('section_text');
$bullets          = get_field('bullets');

$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
?>

<section id="<?php echo esc_attr($block_id); ?>" class="main-bullets-block">
  <img src="/wp-content/uploads/2026/05/shape-27.png" alt="Decorative shape" class="main-hero__decor-shape--1" aria-hidden="true">
  <img src="/wp-content/uploads/2026/05/shape-28.png" alt="Decorative shape" class="main-hero__decor-shape--2" aria-hidden="true">
  <div class="main-bullets-block__container">

    <?php if ($section_pretitle || $section_title || $section_text) : ?>
      <div class="main-bullets-block__head">
        <?php if ($section_pretitle) : ?>
          <div class="main-bullets-block__pretitle">
            <?php echo esc_html($section_pretitle); ?>
          </div>
        <?php endif; ?>

        <?php if ($section_title) : ?>
          <h2 class="main-bullets-block__title">
            <?php echo esc_html($section_title); ?>
          </h2>
        <?php endif; ?>

        <?php if ($section_text) : ?>
          <div class="main-bullets-block__text">
            <?php echo wp_kses_post($section_text); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($bullets) : ?>
      <div class="main-bullets-block__grid">
        <?php foreach ($bullets as $item) :
          $icon  = $item['icon'] ?? null;
          $title = $item['title'] ?? '';
          $text  = $item['text'] ?? '';
        ?>
          <div class="main-bullets-block__item">
            <?php if ($icon) : ?>
              <div class="main-bullets-block__icon">
                <img
                  src="<?php echo esc_url($icon['url']); ?>"
                  alt="<?php echo esc_attr($icon['alt'] ?: $title); ?>"
                  loading="lazy">
              </div>
            <?php endif; ?>

            <?php if ($title) : ?>
              <h3 class="main-bullets-block__item-title">
                <?php echo esc_html($title); ?>
              </h3>
            <?php endif; ?>

            <?php if ($text) : ?>
              <div class="main-bullets-block__item-text">
                <?php echo wp_kses_post($text); ?>
              </div>
            <?php endif; ?>

            <span class="main-bullets-block__corner"></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>
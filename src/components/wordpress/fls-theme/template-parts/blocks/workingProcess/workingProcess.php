<?php

/**
 * Block Name: Working Process
 */

$block_id = 'working-process-' . $block['id'];

if (!empty($block['anchor'])) {
  $block_id = $block['anchor'];
}

$classes = 'working-process';
if (!empty($block['className'])) {
  $classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $classes .= ' align' . $block['align'];
}

$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$steps    = get_field('steps');

if (empty($steps) || !is_array($steps)) {
  $steps = [
    [
      'item_title' => 'Identify Problems',
      'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    ],
    [
      'item_title' => 'Start Servicing',
      'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    ],
    [
      'item_title' => 'Trial For Make Sure',
      'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    ],
    [
      'item_title' => 'Deliver Service',
      'item_text'  => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
    ],
  ];
}

// гарантируем 4 шага
for ($i = 0; $i < 4; $i++) {
  if (!isset($steps[$i])) {
    $steps[$i] = [
      'item_title' => '',
      'item_text'  => '',
    ];
  }
}

$shadow_img = '/wp-content/uploads/2026/05/process-bg.png';
$center_img = '/wp-content/uploads/2026/05/work-animate.png';
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
  <img
    src="<?php echo esc_url($shadow_img); ?>"
    alt=""
    class="working-process__shadow" />

  <div class="working-process__container">
    <div class="block-precontent mb50">
      <?php if ($pretitle): ?>
        <div class="section-pretitle mb20">
          <span></span>
          <?php echo esc_html($pretitle); ?>
        </div>
      <?php endif; ?>

      <?php if ($title): ?>
        <h2 class=" h2 block-precontent__title">
          <?php echo esc_html($title); ?>
        </h2>
      <?php endif; ?>
    </div>

    <div class="working-process__body">
      <!-- <div class="working-process__bg">
        <img src="/wp-content/uploads/2026/03/car-outline.png" alt="" />
      </div> -->
      <div class="working-process__grid">
        <div class="working-process__item working-process__item--1">
          <div class="working-process__item-content">
            <?php if (!empty($steps[0]['item_title'])): ?>
              <h3 class="working-process__item-title">
                <?php echo esc_html($steps[0]['item_title']); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($steps[0]['item_text'])): ?>
              <p class="working-process__item-text">
                <?php echo esc_html($steps[0]['item_text']); ?>
              </p>
            <?php endif; ?>
          </div>
          <div class="working-process__item-number">1</div>
        </div>

        <div class="working-process__item working-process__item--2">
          <div class="working-process__item-content">
            <?php if (!empty($steps[1]['item_title'])): ?>
              <h3 class="working-process__item-title">
                <?php echo esc_html($steps[1]['item_title']); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($steps[1]['item_text'])): ?>
              <p class="working-process__item-text">
                <?php echo esc_html($steps[1]['item_text']); ?>
              </p>
            <?php endif; ?>
          </div>
          <div class="working-process__item-number">2</div>
        </div>

        <div class="working-process__center">
          <img
            src="<?php echo esc_url($center_img); ?>"
            width="300"
            height="300"
            alt="Wheel service process" />
        </div>

        <div class="working-process__item working-process__item--3">
          <div class="working-process__item-number">3</div>
          <div class="working-process__item-content">
            <?php if (!empty($steps[2]['item_title'])): ?>
              <h3 class="working-process__item-title">
                <?php echo esc_html($steps[2]['item_title']); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($steps[2]['item_text'])): ?>
              <p class="working-process__item-text">
                <?php echo esc_html($steps[2]['item_text']); ?>
              </p>
            <?php endif; ?>
          </div>
        </div>

        <div class="working-process__item working-process__item--4">
          <div class="working-process__item-number">4</div>
          <div class="working-process__item-content">
            <?php if (!empty($steps[3]['item_title'])): ?>
              <h3 class="working-process__item-title">
                <?php echo esc_html($steps[3]['item_title']); ?>
              </h3>
            <?php endif; ?>

            <?php if (!empty($steps[3]['item_text'])): ?>
              <p class="working-process__item-text">
                <?php echo esc_html($steps[3]['item_text']); ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
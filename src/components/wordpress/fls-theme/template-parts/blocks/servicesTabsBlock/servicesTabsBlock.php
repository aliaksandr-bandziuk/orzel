<?php
$pretitle = get_field('pretitle') ?: 'WHAT WE DO';
$title    = get_field('title') ?: 'Delivering High Quality Roof Services';
$link     = get_field('all_services_link');

$tabs = get_field('tabs');

if (empty($tabs)) {
  return;
}
?>

<section class="services-tabs-section">
  <img src="/wp-content/uploads/2026/05/shape-33.png" alt="Usługi" class="services-tabs-section__shape--1">
  <img src="/wp-content/uploads/2026/05/shape-34.png" alt="Usługi" class="services-tabs-section__shape--2">
  <div class="services-tabs-section__bg"></div>

  <div class="services-tabs-section__container">
    <div class="services-tabs-section__top">
      <div class="services-tabs-section__heading">
        <div class="section-pretitle">
          <span></span>
          <?php echo esc_html($pretitle); ?>
        </div>

        <h2 class="h2-white"><?php echo esc_html($title); ?></h2>
      </div>

      <?php if (!empty($link['url'])) : ?>
        <a
          href="<?php echo esc_url($link['url']); ?>"
          class="services-tabs-section__link"
          <?php echo !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
          <span><?php echo esc_html($link['title'] ?: 'All services'); ?></span>
          <i></i>
          <svg width="18" height="12" viewBox="0 0 18 12" fill="none">
            <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
          </svg>
        </a>
      <?php endif; ?>
    </div>

    <div data-fls-tabs class="tabs services-tabs">
      <nav data-fls-tabs-titles class="tabs__navigation services-tabs__navigation">
        <?php foreach ($tabs as $index => $tab) : ?>
          <button
            type="button"
            class="tabs__title services-tabs__title <?php echo $index === 0 ? '--tab-active' : ''; ?>">
            <?php if (!empty($tab['icon'])) : ?>
              <span class="services-tabs__title-icon">
                <?php echo wp_get_attachment_image($tab['icon'], 'thumbnail'); ?>
              </span>
            <?php endif; ?>

            <span class="services-tabs__title-text">
              <?php echo esc_html($tab['tab_title']); ?>
            </span>
          </button>
        <?php endforeach; ?>
      </nav>

      <div data-fls-tabs-body class="tabs__content services-tabs__content">
        <?php foreach ($tabs as $tab) : ?>
          <div class="tabs__body services-tabs__body">
            <div class="services-tabs__card">
              <?php if (!empty($tab['image'])) : ?>
                <div class="services-tabs__image">
                  <?php echo wp_get_attachment_image($tab['image'], 'large'); ?>
                </div>
              <?php endif; ?>

              <div class="services-tabs__info">
                <?php if (!empty($tab['content_title'])) : ?>
                  <h3><?php echo esc_html($tab['content_title']); ?></h3>
                <?php endif; ?>

                <?php if (!empty($tab['description'])) : ?>
                  <div class="services-tabs__text">
                    <?php echo wp_kses_post($tab['description']); ?>
                  </div>
                <?php endif; ?>

                <?php if (!empty($tab['bullets'])) : ?>
                  <ul class="services-tabs__list">
                    <?php foreach ($tab['bullets'] as $bullet) : ?>
                      <li>
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                          <circle cx="9" cy="9" r="7.5" stroke="currentColor" />
                          <path d="M5.5 9.2L7.8 11.5L12.8 6.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span><?php echo esc_html($bullet['text']); ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>

                <?php if (!empty($tab['button']['url'])) : ?>
                  <a
                    href="<?php echo esc_url($tab['button']['url']); ?>"
                    class="services-tabs__button"
                    <?php echo !empty($tab['button']['target']) ? 'target="' . esc_attr($tab['button']['target']) . '"' : ''; ?>>
                    <span><?php echo esc_html($tab['button']['title'] ?: 'Read more'); ?></span>
                    <i></i>
                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none">
                      <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                      <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
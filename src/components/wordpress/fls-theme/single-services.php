<?php

get_header();

// Получаем текущий язык через Polylang
$current_lang = pll_current_language();
?>


<main class="page services-page">
  <section
    class="main-hero">
    <div class="main-hero__media">
      <div class="main-hero__image">
        <!-- featured image -->
        <?php
        if (has_post_thumbnail()) {
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
          $image_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
        } else {
          $image_url = '';
          $image_alt = '';
        }
        ?>
        <?php if ($image_url) : ?>
          <img
            src="<?php echo esc_url($image_url); ?>"
            alt="<?php echo esc_attr($image_alt); ?>"
            class="main-hero__img">
        <?php endif; ?>
      </div>
    </div>

    <div class="main-hero__body">
      <div class="main-hero__container">
        <div class="main-hero__content">

          <div class="breadcrumbs" aria-label="Breadcrumb">
            <?php custom_breadcrumbs(); ?>
          </div>

          <h1 class="main-hero__title">
            <?php the_title(); ?>
          </h1>
          <span class="--icon-decor-double-line-white main-hero__decor" aria-hidden="true"></span>
          <div class="main-hero__buttons">

            <button data-fls-popup-link="popup-order" class="button-main main-btn" type="button">
              <div class="button-main__wrapper">
                <span class="button-main__text">
                  <?php
                  switch ($current_lang) {
                    case 'ru':
                      echo 'Получить предложение';
                      break;
                    case 'en':
                      echo 'Get a quote';
                      break;
                    case 'uk':
                      echo 'Отримати пропозицію';
                      break;
                    default:
                      echo 'Uzyskaj wycenę';
                      break;
                  }
                  ?>
                </span>
                <span class="button-main__icon --icon-ico-triangle" aria-hidden="true"></span>
              </div>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php while (have_posts()) : the_post(); ?>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>

  <!-- Похожие работы -->
  <section class="blog-section mb50 mt50">
    <div class="blog-section__container">
      <div class="block-intro">
        <div class="block-intro__wrapper">
          <div class="block-intro__title">
            <h2 class="h2 mb50">
              <?php
              switch ($current_lang) {
                case 'ru':
                  echo 'Другие услуги';
                  break;
                case 'en':
                  echo 'Other services';
                  break;
                case 'uk':
                  echo 'Інші послуги';
                  break;
                default:
                  echo 'Inne usługi';
                  break;
              }
              ?>
            </h2>
          </div>
        </div>
      </div>

      <div class="services-grid">
        <?php
        $current_post_id = get_the_ID();
        $current_date    = get_the_date('Y-m-d H:i:s');

        // 1. Сначала берём 3 предыдущих проекта
        $args = array(
          'post_type'      => 'services',
          'posts_per_page' => 3,
          'orderby'        => 'date',
          'order'          => 'DESC',
          'post__not_in'   => array($current_post_id),
          'lang'           => $current_lang,
          'date_query'     => array(
            array(
              'before'    => $current_date,
              'inclusive' => false,
            ),
          ),
        );

        $similar_posts = new WP_Query($args);

        // 2. Если нашли меньше 3 — добираем недостающие
        $similar_ids = array();

        if ($similar_posts->have_posts()) {
          foreach ($similar_posts->posts as $post_item) {
            $similar_ids[] = $post_item->ID;
          }
        }

        $found_posts = count($similar_ids);
        $needed_posts = 3 - $found_posts;

        if ($needed_posts > 0) {
          $fallback_args = array(
            'post_type'      => 'services',
            'posts_per_page' => $needed_posts,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'post__not_in'   => array_merge(array($current_post_id), $similar_ids),
            'lang'           => $current_lang,
          );

          $fallback_posts = new WP_Query($fallback_args);

          if ($fallback_posts->have_posts()) {
            $similar_posts->posts = array_merge($similar_posts->posts, $fallback_posts->posts);
            $similar_posts->post_count = count($similar_posts->posts);
          }

          wp_reset_postdata();
        }

        // 3. Выводим итоговые 3 карточки
        if (!empty($similar_posts->posts)) :
          foreach ($similar_posts->posts as $post) :
            setup_postdata($post);

            $service_id    = $post->ID;
            $service_title = get_the_title($service_id);
            $service_url   = get_permalink($service_id);
            $icon          = get_field('icon', $service_id);
        ?>

            <a href="<?php echo esc_url($service_url); ?>" class="services-main__card">

              <div class="services-main__card-image">
                <?php if (has_post_thumbnail($service_id)) : ?>
                  <?php echo get_the_post_thumbnail($service_id, 'large', [
                    'class'   => 'services-main__card-img',
                    'alt'     => esc_attr($service_title),
                    'loading' => 'lazy',
                  ]); ?>
                <?php else : ?>
                  <div class="services-main__card-img services-main__card-img--placeholder"></div>
                <?php endif; ?>
              </div>

              <div class="services-main__card-shelf">

                <div class="services-main__card-badge">
                  <?php if (!empty($icon)) : ?>
                    <?php echo wp_get_attachment_image($icon['ID'], [48, 48], false, [
                      'class'       => 'services-main__card-icon',
                      'alt'         => '',
                      'aria-hidden' => 'true',
                    ]); ?>
                  <?php endif; ?>
                </div>

                <p class="services-main__card-title"><?php echo esc_html($service_title); ?></p>

                <span class="services-main__card-arrow" aria-hidden="true">
                  <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                  </svg>
                </span>

              </div>

            </a>

        <?php
          endforeach;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

</main>

<?php get_footer(); ?>
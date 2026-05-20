<?php

get_header();

// Получаем текущий язык через Polylang
$current_lang = pll_current_language();
?>


<main class="page">
  <section
    class="standard-hero">
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
        <img
          src="<?php echo esc_url($image_url); ?>"
          alt="<?php echo esc_attr($image_alt); ?>"
          class="main-hero__img">
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
        </div>
      </div>
    </div>
  </section>

  <section class="portfolio-data">
    <div class="portfolio-data__container">
      <?php
      $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';

      // Переводы меток
      switch ($current_lang) {
        case 'en':
          $car_label          = 'Car';
          $diameter_label     = 'Wheel diameter';
          $color_label        = 'Color';
          $service_label      = 'Service';
          $similar_title      = 'Similar topics';
          $read_more_text     = 'Read more';
          $no_image_alt       = 'Preview image';
          $effekt_label       = 'Effect';
          break;

        case 'ru':
          $car_label          = 'Автомобиль';
          $diameter_label     = 'Диаметр диска';
          $color_label        = 'Цвет';
          $service_label      = 'Услуга';
          $similar_title      = 'Похожие материалы';
          $read_more_text     = 'Читать далее';
          $no_image_alt       = 'Изображение превью';
          $effekt_label       = 'Эффект';
          break;

        case 'uk':
          $car_label          = 'Автомобіль';
          $diameter_label     = 'Діаметр диска';
          $color_label        = 'Колір';
          $service_label      = 'Послуга';
          $similar_title      = 'Схожі матеріали';
          $read_more_text     = 'Читати далі';
          $no_image_alt       = 'Зображення прев’ю';
          $effekt_label       = 'Ефект';
          break;

        case 'pl':
        default:
          $car_label          = 'Samochód';
          $diameter_label     = 'Średnica felgi';
          $color_label        = 'Kolor';
          $service_label      = 'Usługa';
          $similar_title      = 'Podobne tematy';
          $read_more_text     = 'Czytaj więcej';
          $no_image_alt       = 'Miniatura';
          $effekt_label       = 'Efekt';
          break;
      }

      // Получаем новые метаполя
      $car_name     = trim(get_post_meta(get_the_ID(), '_portfolio_car_name', true));
      $rim_diameter = trim(get_post_meta(get_the_ID(), '_portfolio_rim_diameter', true));
      $rim_color    = trim(get_post_meta(get_the_ID(), '_portfolio_rim_color', true));
      $service_name = trim(get_post_meta(get_the_ID(), '_portfolio_service_name', true));

      if ($car_name || $rim_diameter || $rim_color || $service_name) :
      ?>


        <div class="portfolio-data__wrapper mb60">
          <?php if ($car_name) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($car_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($car_name); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($rim_diameter) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($diameter_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($rim_diameter); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($rim_color) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($color_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($rim_color); ?></p>
              </div>
            </div>
          <?php endif; ?>

          <?php if ($service_name) : ?>
            <div class="portfolio-bullet">
              <div class="portfolio-bullet__top">
                <p><?php echo esc_html($service_label); ?></p>
              </div>
              <div class="portfolio-bullet__bottom">
                <p><?php echo esc_html($service_name); ?></p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (has_excerpt()) : ?>
        <div class="wide-excerpt mb60">
          <p><b><?php echo esc_html($effekt_label); ?>:</b> <?php echo get_the_excerpt(); ?></p>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <?php while (have_posts()) : the_post(); ?>
    <div class="entry-content">
      <?php the_content(); ?>
    </div>
  <?php endwhile; ?>

  <!-- Похожие работы -->
  <section class="blog-section mb50">
    <div class="blog-section__container">
      <div class="block-intro">
        <div class="block-intro__wrapper">
          <div class="block-intro__title">
            <h2 class="h2 mb50">
              <?php
              switch ($current_lang) {
                case 'ru':
                  echo 'Похожие работы';
                  break;
                case 'en':
                  echo 'Similar works';
                  break;
                case 'uk':
                  echo 'Схожі роботи';
                  break;
                default:
                  echo 'Podobne realizacje';
                  break;
              }
              ?>
            </h2>
          </div>
        </div>
      </div>

      <div class="grid-1-2">
        <?php
        $current_post_id = get_the_ID();
        $current_date    = get_the_date('Y-m-d H:i:s');

        // 1. Сначала берём 2 предыдущих проекта
        $args = array(
          'post_type'      => 'portfolio',
          'posts_per_page' => 2,
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

        // 2. Если нашли меньше 2 — добираем недостающие
        $similar_ids = array();

        if ($similar_posts->have_posts()) {
          foreach ($similar_posts->posts as $post_item) {
            $similar_ids[] = $post_item->ID;
          }
        }

        $found_posts = count($similar_ids);
        $needed_posts = 2 - $found_posts;

        if ($needed_posts > 0) {
          $fallback_args = array(
            'post_type'      => 'portfolio',
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

        // 3. Выводим итоговые 2 карточки
        if (!empty($similar_posts->posts)) :
          foreach ($similar_posts->posts as $post) :
            setup_postdata($post);
        ?>

            <a href="<?php the_permalink(); ?>" class="portfolio-card">
              <div class="portfolio-card__wrapper">
                <div class="portfolio-inner">
                  <div class="portfolio-inner__item">
                    <p class="portfolio-card__title"><?php the_title(); ?></p>

                    <?php
                    $car_name     = get_post_meta(get_the_ID(), '_portfolio_car_name', true);
                    $rim_diameter = get_post_meta(get_the_ID(), '_portfolio_rim_diameter', true);
                    $rim_color    = get_post_meta(get_the_ID(), '_portfolio_rim_color', true);
                    $service_name = get_post_meta(get_the_ID(), '_portfolio_service_name', true);
                    ?>
                  </div>

                  <div class="portfolio-inner__item">
                    <p class="portfolio-card__excerpt">
                      <?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                    </p>
                  </div>
                </div>

                <div class="portfolio-card__image">
                  <?php
                  if (has_post_thumbnail()) {
                    the_post_thumbnail('full');
                  } else {
                    echo '<img src="' . esc_url(get_template_directory_uri() . '/img/no-image.webp') . '" alt="No image">';
                  }
                  ?>
                </div>
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
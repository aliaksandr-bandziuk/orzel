<?php
/*
Template Name: Page Portfolio
Template Post Type: page
*/
get_header();

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$portfolio_ids = get_posts([
  'post_type'        => 'portfolio',
  'post_status'      => 'publish',
  'numberposts'      => -1,
  'fields'           => 'ids',
  'suppress_filters' => false,
  'lang'             => $current_lang,
]);

$portfolio_brands = [];

if (!empty($portfolio_ids)) {
  $portfolio_brands_raw = wp_get_object_terms($portfolio_ids, 'car_brand', [
    'orderby' => 'name',
    'order'   => 'ASC',
  ]);

  if (!is_wp_error($portfolio_brands_raw) && !empty($portfolio_brands_raw)) {
    $unique_brands = [];

    foreach ($portfolio_brands_raw as $brand) {
      $unique_brands[$brand->term_id] = $brand;
    }

    $portfolio_brands = array_values($unique_brands);
  }
}

$selected_brand = isset($_GET['portfolio_brand']) ? sanitize_text_field($_GET['portfolio_brand']) : 'all';
$posts_per_page = 8;

// Тексты интерфейса
switch ($current_lang) {
  case 'pl':
    $all_label        = 'Wszystkie';
    $load_more_label  = 'Załaduj więcej';
    $read_more_label  = 'Czytaj więcej';
    $empty_label      = 'Nie znaleziono realizacji.';
    $error_label      = 'Wystąpił błąd podczas ładowania realizacji.';
    break;

  case 'ru':
    $all_label        = 'Все';
    $load_more_label  = 'Загрузить ещё';
    $read_more_label  = 'Читать далее';
    $empty_label      = 'Реализации не найдены.';
    $error_label      = 'Произошла ошибка при загрузке работ.';
    break;

  case 'uk':
    $all_label        = 'Всі';
    $load_more_label  = 'Завантажити ще';
    $read_more_label  = 'Читати далі';
    $empty_label      = 'Реалізації не знайдено.';
    $error_label      = 'Сталася помилка при завантаженні робіт.';
    break;

  case 'en':
  default:
    $all_label        = 'All';
    $load_more_label  = 'Load more';
    $read_more_label  = 'Read more';
    $empty_label      = 'No portfolio items found.';
    $error_label      = 'Error loading portfolio items.';
    break;
}
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
        </div>
      </div>
    </div>
  </section>

  <section class="portfolio-all">
    <div class="portfolio-all__container">
      <div class="portfolio-tabs">

        <nav class="portfolio-tabs__navigation">
          <button
            type="button"
            class="portfolio-tab tab-custom <?php echo ($selected_brand === 'all') ? '_tab-active' : ''; ?>"
            data-brand="all">
            <?php echo esc_html($all_label); ?>
          </button>

          <?php if (!empty($portfolio_brands)) : ?>
            <?php foreach ($portfolio_brands as $brand) : ?>
              <button
                type="button"
                class="portfolio-tab tab-custom <?php echo ($selected_brand === $brand->slug) ? '_tab-active' : ''; ?>"
                data-brand="<?php echo esc_attr($brand->slug); ?>">
                <?php echo esc_html($brand->name); ?>
              </button>
            <?php endforeach; ?>
          <?php endif; ?>
        </nav>

        <div class="portfolio-tabs__content">
          <div id="portfolio-content" class="portfolio-tabs__body">
            <?php
            $paged = 1;

            $args = [
              'post_type'        => 'portfolio',
              'posts_per_page'   => $posts_per_page,
              'paged'            => $paged,
              'post_status'      => 'publish',
              'suppress_filters' => false,
            ];

            if (!empty($current_lang)) {
              $args['lang'] = $current_lang;
            }

            if ('all' !== $selected_brand) {
              $args['tax_query'] = [
                [
                  'taxonomy' => 'car_brand',
                  'field'    => 'slug',
                  'terms'    => $selected_brand,
                ],
              ];
            }

            $query = new WP_Query($args);

            if ($query->have_posts()) :
              while ($query->have_posts()) :
                $query->the_post();
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

                        <div class="portfolio-card__metas">
                          <?php if ($car_name) : ?>
                            <div class="portfolio-card__meta"><?php echo esc_html($car_name); ?></div>
                          <?php endif; ?>

                          <?php if ($service_name) : ?>
                            <div class="portfolio-card__meta"><?php echo esc_html($service_name); ?></div>
                          <?php endif; ?>

                          <?php if ($rim_diameter || $rim_color) : ?>
                            <div class="portfolio-card__meta">
                              <?php echo esc_html(trim($rim_diameter . '", ' . $rim_color)); ?>
                            </div>
                          <?php endif; ?>
                        </div>


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
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/wp-content/uploads/2026/03/no-image.webp') . '" alt="No image">';
                      }
                      ?>
                    </div>
                  </div>
                </a>
            <?php
              endwhile;
            else :
              echo '<p>' . esc_html($empty_label) . '</p>';
            endif;

            wp_reset_postdata();
            ?>
          </div>
        </div>
      </div>

      <?php if (!empty($query) && $query->max_num_pages > 1) : ?>
        <div class="load-more-container mt50">
          <button id="load-more" class="button-primary">
            <?php echo esc_html($load_more_label); ?>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php if (get_the_content()) : ?>
    <section class="portfolio-page-content mb60">
      <div class="portfolio-page-content__container">
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php get_footer(); ?>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const tabs = document.querySelectorAll('.portfolio-tab');
    const portfolioContent = document.getElementById('portfolio-content');
    const loadMoreBtn = document.getElementById('load-more');
    const ajaxUrl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
    const currentLang = "<?php echo esc_js($current_lang); ?>";
    let currentBrand = "<?php echo esc_js($selected_brand); ?>";
    let paged = 1;

    tabs.forEach(function(tab) {
      tab.addEventListener('click', function(e) {
        e.preventDefault();

        tabs.forEach(t => t.classList.remove('_tab-active'));
        tab.classList.add('_tab-active');

        currentBrand = tab.getAttribute('data-brand');
        paged = 1;

        const data = new URLSearchParams();
        data.append('action', 'filter_portfolio');
        data.append('portfolio_brand', currentBrand);
        data.append('paged', paged);
        data.append('lang', currentLang);

        fetch(ajaxUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: data.toString()
          })
          .then(response => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.text();
          })
          .then(html => {
            portfolioContent.innerHTML = html;

            if (loadMoreBtn) {
              loadMoreBtn.style.display = html.trim() === '' ? 'none' : 'block';
            }

            // window.scrollTo({
            //   top: 0,
            //   behavior: 'smooth'
            // });
          })
          .catch(error => {
            portfolioContent.innerHTML = '<p><?php echo esc_js($error_label); ?></p>';
            console.error(error);
          });
      });
    });

    if (loadMoreBtn) {
      loadMoreBtn.addEventListener('click', function(e) {
        e.preventDefault();
        paged++;

        const data = new URLSearchParams();
        data.append('action', 'filter_portfolio');
        data.append('portfolio_brand', currentBrand);
        data.append('paged', paged);
        data.append('lang', currentLang);

        fetch(ajaxUrl, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            body: data.toString()
          })
          .then(response => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.text();
          })
          .then(html => {
            if (html.trim() !== '') {
              portfolioContent.insertAdjacentHTML('beforeend', html);
            } else {
              loadMoreBtn.style.display = 'none';
            }
          })
          .catch(error => {
            console.error(error);
          });
      });
    }
  });
</script>
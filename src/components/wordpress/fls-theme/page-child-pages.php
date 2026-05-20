<?php
/*
Template Name: Page Child Pages
Template Post Type: page
*/
get_header();

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

switch ($current_lang) {
  case 'pl':
    $empty_label = 'Nie znaleziono stron.';
    break;
  case 'ru':
    $empty_label = 'Страницы не найдены.';
    break;
  case 'uk':
    $empty_label = 'Сторінки не знайдено.';
    break;
  case 'en':
  default:
    $empty_label = 'No pages found.';
    break;
}

$current_page_id = get_the_ID();

function fls_get_child_pages($parent_id, $current_lang = '')
{
  $args = [
    'post_type'        => 'page',
    'posts_per_page'   => -1,
    'post_status'      => 'publish',
    'post_parent'      => $parent_id,
    'orderby'          => [
      'menu_order' => 'ASC',
      'date'       => 'DESC',
    ],
    'suppress_filters' => false,
  ];

  if (!empty($current_lang)) {
    $args['lang'] = $current_lang;
  }

  return new WP_Query($args);
}

function fls_render_page_card($page_id)
{
  $title = get_the_title($page_id);
  $url   = get_permalink($page_id);

  $image_html = get_the_post_thumbnail(
    $page_id,
    'large',
    [
      'class'   => 'service-item__img',
      'alt'     => esc_attr($title),
      'loading' => 'lazy',
    ]
  );

  $excerpt = get_the_excerpt($page_id);

  if (empty($excerpt)) {
    $content = get_post_field('post_content', $page_id);
    $excerpt = wp_strip_all_tags(strip_shortcodes($content));
  }

  $excerpt = mb_strimwidth(trim($excerpt), 0, 120, '...');

?>
  <a href="<?php echo esc_url($url); ?>" class="service-item services-grid__item">

    <div class="service-item__content">
      <?php if ($title) : ?>
        <p class="service-item__title">
          <?php echo esc_html($title); ?>
        </p>
      <?php endif; ?>

      <?php if ($excerpt) : ?>
        <p class="service-item__descr">
          <?php echo esc_html($excerpt); ?>
        </p>
      <?php endif; ?>
    </div>
  </a>
<?php
}
?>

<main class="page">
  <section class="standard-hero">
    <div class="main-hero__media">
      <div class="main-hero__image">
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
        </div>
      </div>
    </div>
  </section>

  <section class="services services-archive">
    <div class="services__container">
      <?php
      $children_query = fls_get_child_pages($current_page_id, $current_lang);

      if ($children_query->have_posts()) :

        $children = $children_query->posts;
        $has_grouped_pages = false;

        foreach ($children as $child_page) {
          $grandchildren_query = fls_get_child_pages($child_page->ID, $current_lang);

          if ($grandchildren_query->have_posts()) {
            $has_grouped_pages = true;
          }

          wp_reset_postdata();
        }

        if ($has_grouped_pages) :

          foreach ($children as $child_page) :
            $grandchildren_query = fls_get_child_pages($child_page->ID, $current_lang);

            if ($grandchildren_query->have_posts()) :
      ?>
              <div class="services-category">
                <h2 class="h2 mb70">
                  <?php echo esc_html(get_the_title($child_page->ID)); ?>
                </h2>

                <div class="services-grid">
                  <?php
                  while ($grandchildren_query->have_posts()) :
                    $grandchildren_query->the_post();
                    fls_render_page_card(get_the_ID());
                  endwhile;
                  ?>
                </div>
              </div>
          <?php
            endif;

            wp_reset_postdata();
          endforeach;

        else :
          ?>
          <div class="services-grid">
            <?php
            while ($children_query->have_posts()) :
              $children_query->the_post();
              fls_render_page_card(get_the_ID());
            endwhile;
            ?>
          </div>
      <?php
          wp_reset_postdata();

        endif;

      else :
        echo '<p>' . esc_html($empty_label) . '</p>';
      endif;

      wp_reset_postdata();
      ?>
    </div>
  </section>

  <?php if (get_the_content()) : ?>
    <section class="services-page-content mb60">
      <div class="services-page-content__container">
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
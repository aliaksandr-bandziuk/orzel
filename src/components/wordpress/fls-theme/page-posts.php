<?php
/*
Template Name: Page Blog
Template Post Type: page
*/
get_header();
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

  <section class="blog-posts">
    <div class="blog-posts__container">

      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>

      <div class="divider"></div>
      <div class="grid-1-2">

        <?php
        $current_language = function_exists('pll_current_language') ? pll_current_language() : '';

        $paged = get_query_var('paged') ? (int) get_query_var('paged') : 1;

        $args = array(
          'post_type'           => 'post',
          'posts_per_page'      => 8,
          'paged'               => $paged,
          'post_status'         => 'publish',
          'suppress_filters'    => false,
        );

        if (!empty($current_language)) {
          $args['lang'] = $current_language;
        }

        $query = new WP_Query($args);

        if (!function_exists('custom_excerpt')) {
          function custom_excerpt($text, $limit)
          {
            if (str_word_count($text, 0) > $limit) {
              $words = str_word_count($text, 2);
              $pos = array_keys($words);
              $text = substr($text, 0, $pos[$limit]) . '...';
            }
            return $text;
          }
        }
        ?>

        <?php if ($query->have_posts()) : ?>
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="grid-1-2__child--lite">
              <a href="<?php the_permalink(); ?>" class="blog-card">
                <div class="blog-card__wrapper">
                  <div class="blog-card__image">
                    <div class="image-overlay"></div>
                    <img
                      class="preview"
                      src="<?php echo has_post_thumbnail() ? esc_url(get_the_post_thumbnail_url()) : esc_url(get_template_directory_uri() . '/assets/img/no-image.webp'); ?>"
                      alt="preview image">
                    <div class="post-data">
                      <div class="post-data__item"><?php the_time('d.m.Y'); ?></div>
                      <!-- <div class="post-data__item">5 min read</div> -->
                    </div>
                  </div>
                  <div class="blog-card__content">
                    <h3 class="blog-card__title"><?php the_title(); ?></h3>
                    <p class="blog-card__excerpt"><?php echo esc_html(custom_excerpt(get_the_excerpt(), 200)); ?></p>
                  </div>
                </div>
              </a>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>

      </div>

      <div class="pagination-block mb60">
        <div class="pagination-buttons">
          <?php
          echo paginate_links(array(
            'base'      => trailingslashit(get_pagenum_link(1)) . 'page/%#%/',
            'format'    => '',
            'total'     => $query->max_num_pages,
            'current'   => max(1, get_query_var('paged')),
            'show_all'  => false,
            'type'      => 'plain',
            'end_size'  => 2,
            'mid_size'  => 1,
            'prev_next' => false,
          ));
          ?>
        </div>
      </div>

      <?php wp_reset_postdata(); ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
<?php
$block_id = 'portfolio-block-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
$classes = 'portfolio-block';
if (!empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

$section_title = get_field('title')      ?: 'Nasze realizacje';
$link_label    = get_field('link_label') ?: 'Zobacz wszystkie realizacje';
$link_url      = get_field('link_url')   ?: get_post_type_archive_link('portfolio');

$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';

$query_args = [
    'post_type'        => 'portfolio',
    'posts_per_page'   => 6,
    'post_status'      => 'publish',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'suppress_filters' => false,
];

if (!empty($current_lang)) {
    $query_args['lang'] = $current_lang;
}

$portfolio_query = new WP_Query($query_args);

if (!$portfolio_query->have_posts()) {
    return;
}
?>

<section id="<?php echo esc_attr($block_id); ?>"
    class="<?php echo esc_attr($classes); ?>"
    data-fls-slider
    data-slider-type="portfolio">

    <div class="portfolio-block__container">

        <div class="portfolio-block__head">
            <h2 class="portfolio-block__title"><?php echo esc_html($section_title); ?></h2>
            <?php if ($link_url) : ?>
                <a href="<?php echo esc_url($link_url); ?>" class="portfolio-block__view-all">
                    <span><?php echo esc_html($link_label); ?></span>
                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <div class="portfolio-block__slider-wrap">

            <button type="button"
                class="portfolio-block__nav portfolio-block__nav--prev slider-block__button--prev"
                aria-label="Previous">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            <div class="swiper portfolio-block__swiper">
                <div class="swiper-wrapper">

                    <?php while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                        $post_id  = get_the_ID();
                        $location = get_post_meta($post_id, '_portfolio_location', true);
                    ?>

                        <div class="swiper-slide">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="portfolio-block__card">

                                <div class="portfolio-block__card-image">
                                    <?php if (has_post_thumbnail($post_id)) : ?>
                                        <?php echo get_the_post_thumbnail($post_id, 'portfolio-card', [
                                            'class'   => 'portfolio-block__card-img',
                                            'alt'     => esc_attr(get_the_title()),
                                            'loading' => 'lazy',
                                        ]); ?>
                                    <?php else : ?>
                                        <div class="portfolio-block__card-img portfolio-block__card-img--placeholder"></div>
                                    <?php endif; ?>
                                </div>

                                <div class="portfolio-block__card-shelf">
                                    <div class="portfolio-block__card-info">
                                        <p class="portfolio-block__card-title"><?php echo esc_html(get_the_title()); ?></p>
                                        <?php if ($location) : ?>
                                            <p class="portfolio-block__card-location"><?php echo esc_html($location); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <span class="portfolio-block__card-arrow" aria-hidden="true">
                                        <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" />
                                        </svg>
                                    </span>
                                </div>

                            </a>
                        </div>

                    <?php endwhile;
                    wp_reset_postdata(); ?>

                </div>
            </div>

            <button type="button"
                class="portfolio-block__nav portfolio-block__nav--next slider-block__button--next"
                aria-label="Next">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

        </div>

        <div class="slider-block__pagination portfolio-block__pagination"></div>

    </div>

</section>
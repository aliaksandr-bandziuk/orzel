<?php
$section_title = get_field('title') ?: 'Nasze usługi';
$current_lang  = function_exists('pll_current_language') ? pll_current_language() : '';

$query_args = [
    'post_type'        => 'services',
    'posts_per_page'   => 6,
    'post_status'      => 'publish',
    'post_parent'      => 0,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'suppress_filters' => false,
];

if (!empty($current_lang)) {
    $query_args['lang'] = $current_lang;
}

$services_query = new WP_Query($query_args);

if (!$services_query->have_posts()) {
    return;
}
?>

<section class="services-main">
    <div class="services-main__container container__wrapper">

        <div class="services-main__head">
            <h2 class="services-main__title"><?php echo esc_html($section_title); ?></h2>
            <span class="services-main__accent" aria-hidden="true"></span>
        </div>

        <div class="services-main__grid">
            <?php while ($services_query->have_posts()) : $services_query->the_post(); ?>

                <?php
                $service_id    = get_the_ID();
                $service_title = get_the_title();
                $service_url   = get_permalink();
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
                                    'class'        => 'services-main__card-icon',
                                    'alt'          => '',
                                    'aria-hidden'  => 'true',
                                ]); ?>
                            <?php endif; ?>
                        </div>

                        <p class="services-main__card-title"><?php echo esc_html($service_title); ?></p>

                        <span class="services-main__card-arrow" aria-hidden="true">
                            <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                        </span>

                    </div>

                </a>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>

<?php
$block_id = 'about-remont-block-' . $block['id'];
if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}
$classes = 'about-remont-block';
if (!empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

$pretitle    = get_field('pretitle')    ?: 'O NAS';
$title       = get_field('title')       ?: '';
$text        = get_field('text')        ?: '';
$button_text = get_field('button_text') ?: 'Poznaj nas bliżej';
$button_link = get_field('button_link') ?: '#';
$main_image  = get_field('main_image');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">

    <?php if ($main_image) : ?>
        <div class="about-remont-block__image-wrap">
            <img
                class="about-remont-block__img"
                src="<?php echo esc_url($main_image['url']); ?>"
                alt="<?php echo esc_attr($main_image['alt'] ?: $title); ?>"
                loading="lazy">
        </div>
    <?php endif; ?>

    <div class="about-remont-block__container">
        <div class="about-remont-block__content">

            <?php if ($pretitle) : ?>
                <p class="about-remont-block__overline"><?php echo esc_html($pretitle); ?></p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="about-remont-block__heading"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <span class="about-remont-block__accent" aria-hidden="true"></span>

            <?php if ($text) : ?>
                <div class="about-remont-block__text">
                    <?php echo wp_kses_post($text); ?>
                </div>
            <?php endif; ?>

            <?php if ($button_link && $button_text) : ?>
                <a href="<?php echo esc_url($button_link); ?>" class="about-remont-block__btn">
                    <span><?php echo esc_html($button_text); ?></span>
                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 1L17 6L12 11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1 6H17" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </a>
            <?php endif; ?>

        </div>
    </div>

</section>

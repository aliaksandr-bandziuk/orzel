<?php

$block_id = 'working-process-' . $block['id'];

if (!empty($block['anchor'])) {
    $block_id = $block['anchor'];
}

$classes = 'working-process';
if (!empty($block['className'])) {
    $classes .= ' ' . $block['className'];
}

$pretitle = get_field('pretitle') ?: '';
$title    = get_field('title') ?: '';
$steps    = get_field('steps');

if (empty($steps) || !is_array($steps)) {
    $steps = [
        [
            'item_title' => 'Analiza i koncepcja',
            'item_text'  => 'Poznajemy potrzeby, analizujemy możliwości i tworzymy plan działania.',
            'icon'       => null,
        ],
        [
            'item_title' => 'Wycena',
            'item_text'  => 'Działamy kompleksowo – od wyceny i projektu po realizację.',
            'icon'       => null,
        ],
        [
            'item_title' => 'Realizacja',
            'item_text'  => 'Czuwamy nad każdym etapem, zapewniając jakość i terminowość.',
            'icon'       => null,
        ],
        [
            'item_title' => 'Odbiór',
            'item_text'  => 'Przekazujemy gotowe wnętrze i dbamy o każdy detal.',
            'icon'       => null,
        ],
    ];
}
?>

<section id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($classes); ?>">
    <div class="working-process__container">

        <div class="working-process__head">
            <?php if ($pretitle) : ?>
                <p class="working-process__pretitle"><?php echo esc_html($pretitle); ?></p>
            <?php endif; ?>
            <h2 class="working-process__title"><?php echo esc_html($title ?: 'Jak pracujemy?'); ?></h2>
            <span class="working-process__accent" aria-hidden="true"></span>
        </div>

        <div class="working-process__steps">
            <?php foreach ($steps as $i => $step) :
                $icon     = !empty($step['icon']) ? $step['icon'] : null;
                $icon_alt = ($icon && !empty($icon['alt'])) ? $icon['alt'] : '';
            ?>
                <div class="working-process__step">
                    <!-- wrapper for step content -->
                    <div class="working-process__step-wrapper">
                        <?php if ($icon) : ?>
                            <div class="working-process__step-icon">
                                <?php echo wp_get_attachment_image($icon['ID'], [80, 80], false, [
                                    'class'   => 'working-process__step-img',
                                    'alt'     => esc_attr($icon_alt),
                                    'loading' => 'lazy',
                                ]); ?>
                            </div>
                        <?php endif; ?>

                        <!-- content for step -->
                        <div class="working-process__step-content">
                            <p class="working-process__step-number"><?php echo sprintf('%02d', $i + 1); ?></p>

                            <?php if (!empty($step['item_title'])) : ?>
                                <h3 class="working-process__step-title"><?php echo esc_html($step['item_title']); ?></h3>
                            <?php endif; ?>

                            <?php if (!empty($step['item_text'])) : ?>
                                <p class="working-process__step-text"><?php echo esc_html($step['item_text']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
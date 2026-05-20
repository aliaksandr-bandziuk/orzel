<?php

get_header();

// Получаем текущий язык через Polylang
$current_lang = pll_current_language();
?>


<main class="page">
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
	<section class="blog-section mt50 mb50">
		<div class="blog-section__container">
			<div class="block-intro">
				<div class="block-intro__wrapper">
					<div class="block-intro__title">
						<h2 class="h2 mb50">
							<?php
							switch ($current_lang) {
								case 'ru':
									echo 'Другие статьи';
									break;
								case 'en':
									echo 'Other articles';
									break;
								case 'uk':
									echo 'Інші статті';
									break;
								default:
									echo 'Inne artykuły';
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

				// 1. Сначала берём 2 предыдущих статьи
				$args = array(
					'post_type'      => 'post',
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
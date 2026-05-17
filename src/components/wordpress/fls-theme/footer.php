	<?php
	// Определяем текущий язык через Polylang
	$current_language = function_exists('pll_current_language') ? pll_current_language() : 'pl';

	// Формируем идентификатор опций футера для текущего языка
	$footer_option_id = 'footer_' . $current_language;

	// Основные поля
	$footer_logo = get_field('footer_logo', $footer_option_id);
	$footer_description = get_field('footer_description', $footer_option_id);

	// Working hours
	$footer_working_hours = get_field('footer_working_hours', $footer_option_id);

	$footer_working_hours_title = $footer_working_hours['title'] ?? '';
	$footer_working_hours_text  = $footer_working_hours['text'] ?? '';

	// Quick Links
	$footer_quick_links = get_field('footer_quick_links', $footer_option_id);

	$footer_quick_links_title = $footer_quick_links['title'] ?? '';
	$footer_quick_links_items = $footer_quick_links['items'] ?? [];

	// Services
	$footer_services = get_field('footer_services', $footer_option_id);

	$footer_services_title = $footer_services['title'] ?? '';
	$footer_services_items = $footer_services['items'] ?? [];

	// Нижняя часть оставляем как была
	$footer_bottom = get_field('footer_bottom', $footer_option_id);

	$footer_privacy_label = $footer_bottom['privacy_label'] ?? '';
	$footer_privacy_url   = $footer_bottom['privacy_url'] ?? '';
	?>

	<?php
	if (!function_exists('orzel_footer_get_link_data')) {
		function orzel_footer_get_link_data($item)
		{
			$link = $item['url'] ?? '';

			$url = '';
			$target = '_self';
			$label = $item['label'] ?? '';

			if (is_array($link)) {
				$url = $link['url'] ?? '';
				$target = $link['target'] ?? '_self';

				if (empty($label)) {
					$label = $link['title'] ?? '';
				}
			} else {
				$url = $link;
			}

			return [
				'url' => $url,
				'target' => $target,
				'label' => $label,
			];
		}
	}
	?>

	<footer class="footer">
		<img class="footer__shape-1" src="/wp-content/uploads/2026/05/shape-f-1.png" alt="footer shape 1">
		<img class="footer__shape-2" src="/wp-content/uploads/2026/05/shape-f-2.png" alt="footer shape 2">
		<div class="footer__container">

			<div class="footer-data">
				<div class="footer-data__wrapper">

					<!-- COLUMN 1 -->
					<div class="footer-block">
						<div class="footer-block__wrapper">

							<?php if (!empty($footer_logo['url'])) : ?>
								<div class="footer-block__logo">
									<a href="<?php echo esc_url(get_home_url()); ?>" class="header-logo__link">
										<img
											src="<?php echo esc_url($footer_logo['url']); ?>"
											alt="<?php echo esc_attr($footer_logo['alt'] ?: 'Logo'); ?>"
											class="logo-image"
											width="<?php echo esc_attr($footer_logo['width'] ?? ''); ?>"
											height="<?php echo esc_attr($footer_logo['height'] ?? ''); ?>">
									</a>
								</div>
							<?php endif; ?>

							<?php if ($footer_description) : ?>
								<div class="footer-block__descr">
									<?php echo wp_kses_post(nl2br($footer_description)); ?>
								</div>
							<?php endif; ?>

							<?php if ($footer_working_hours_title || $footer_working_hours_text) : ?>
								<div class="footer-working-hours">

									<?php if ($footer_working_hours_title) : ?>
										<div class="footer-block__title">
											<?php echo esc_html($footer_working_hours_title); ?>
										</div>
									<?php endif; ?>

									<?php if ($footer_working_hours_text) : ?>
										<div class="footer-working-hours__text">
											<?php echo wp_kses_post(nl2br($footer_working_hours_text)); ?>
										</div>
									<?php endif; ?>

								</div>
							<?php endif; ?>

						</div>
					</div>

					<!-- COLUMN 2 -->
					<div class="footer-block">
						<div class="footer-block__wrapper">

							<?php if ($footer_quick_links_title) : ?>
								<div class="footer-block__title">
									<?php echo esc_html($footer_quick_links_title); ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($footer_quick_links_items)) : ?>
								<ul class="footer-block__list">

									<?php foreach ($footer_quick_links_items as $item) : ?>

										<?php
										$link_data = orzel_footer_get_link_data($item);

										$item_url = $link_data['url'];
										$item_target = $link_data['target'];
										$item_label = $link_data['label'];
										?>

										<?php if ($item_url && $item_label) : ?>
											<li class="footer-block__item">
												<a
													href="<?php echo esc_url($item_url); ?>"
													target="<?php echo esc_attr($item_target); ?>"
													class="footer-block__link">

													<?php echo esc_html($item_label); ?>

												</a>
											</li>
										<?php endif; ?>

									<?php endforeach; ?>

								</ul>
							<?php endif; ?>

						</div>
					</div>

					<!-- COLUMN 3 -->
					<div class="footer-block">
						<div class="footer-block__wrapper">

							<?php if ($footer_services_title) : ?>
								<div class="footer-block__title">
									<?php echo esc_html($footer_services_title); ?>
								</div>
							<?php endif; ?>

							<?php if (!empty($footer_services_items)) : ?>
								<ul class="footer-block__list">

									<?php foreach ($footer_services_items as $item) : ?>

										<?php
										$link_data = orzel_footer_get_link_data($item);

										$item_url = $link_data['url'];
										$item_target = $link_data['target'];
										$item_label = $link_data['label'];
										?>

										<?php if ($item_url && $item_label) : ?>
											<li class="footer-block__item">
												<a
													href="<?php echo esc_url($item_url); ?>"
													target="<?php echo esc_attr($item_target); ?>"
													class="footer-block__link">

													<?php echo esc_html($item_label); ?>

												</a>
											</li>
										<?php endif; ?>

									<?php endforeach; ?>

								</ul>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>

			<!-- НИЖНЯЯ ЧАСТЬ НЕ ТРОГАЕМ -->
			<div class="footer-company">
				<div class="footer-company__wrapper">

					<div class="footer-text">
						<?php
						$current_year = date('Y');

						switch ($current_language) {
							case 'pl':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Orzeł Realty. Wszelkie prawa zastrzeżone.</p>';
								break;
							case 'ru':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Orzeł Realty. Все права защищены.</p>';
								break;
							case 'uk':
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Orzeł Realty. Всі права захищені.</p>';
								break;
							default:
								echo '<p class="footer-text__item">© ' . esc_html($current_year) . ' Orzeł Realty. All rights reserved.</p>';
								break;
						}
						?>
					</div>

					<?php if ($footer_privacy_label && $footer_privacy_url) : ?>
						<a href="<?php echo esc_url($footer_privacy_url); ?>" class="footer-text__item">
							<?php echo esc_html($footer_privacy_label); ?>
						</a>
					<?php endif; ?>

					<div class="developer-data">
						<p class="developer-data__text">
							<?php
							switch ($current_language) {
								case 'pl':
									echo 'Strona stworzona przez';
									break;
								case 'ru':
									echo 'Сайт разработан';
									break;
								case 'uk':
									echo 'Сайт розроблено';
									break;
								default:
									echo 'Developed by';
									break;
							}
							?>
						</p>

						<a href="https://www.bandziuk.com" target="_blank" class="developer-data__link" rel="noopener noreferrer">
							Bandziuk
						</a>
					</div>

				</div>
			</div>

		</div>
	</footer>
	</div>
	<script>
		var currentLang = '<?php echo pll_current_language(); ?>';
	</script>
	<div id="messagePopup" class="message-popup-form" style="display: none;">
		<div class="message-popup-form-content">
			<span class="close-popup-form-button" onclick="document.getElementById('messagePopup').style.display='none'">&times;</span>
			<div class="order-content">
				<p id="popupTitle" class="order-content__title">Ваше сообщение здесь</p>
				<p id="popupMessage" class="order-content__subtitle">Ваше сообщение здесь</p>
			</div>
		</div>
	</div>

	<?php
	$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
	$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

	$cookie_i18n = [
		'text' => [
			'pl' => 'Używamy plików cookies, aby zapewnić prawidłowe działanie strony oraz analizować ruch. Możesz zaakceptować lub odrzucić dodatkowe cookies.',
			'en' => 'We use cookies to ensure proper website operation and to analyze traffic. You can accept or reject additional cookies.',
			'ru' => 'Мы используем cookies, чтобы сайт работал корректно и для анализа трафика. Вы можете принять или отклонить дополнительные cookies.',
			'uk' => 'Ми використовуємо cookies, щоб сайт працював коректно та для аналізу трафіку. Ви можете прийняти або відхилити додаткові cookies.',
		],
		'accept' => [
			'pl' => 'Akceptuję',
			'en' => 'Accept',
			'ru' => 'Принять',
			'uk' => 'Прийняти',
		],
		'decline' => [
			'pl' => 'Odrzucam',
			'en' => 'Decline',
			'ru' => 'Отклонить',
			'uk' => 'Відхилити',
		],
		'policy' => [
			'pl' => 'Polityka prywatności',
			'en' => 'Privacy Policy',
			'ru' => 'Политика конфиденциальности',
			'uk' => 'Політика конфіденційності',
		],
	];

	$privacy_page_url = 'https://felgilab.pl/polityka-prywatnosci/';
	?>

	<div class="cookie-banner" id="cookie-banner" hidden>
		<div class="cookie-banner__inner">
			<p class="cookie-banner__text">
				<?php echo esc_html($cookie_i18n['text'][$lang]); ?>
				<a href="<?php echo esc_url($privacy_page_url); ?>">
					<?php echo esc_html($cookie_i18n['policy'][$lang]); ?>
				</a>
			</p>

			<div class="cookie-banner__actions">
				<button type="button" class="cookie-banner__button cookie-banner__button--accept" id="cookie-accept">
					<?php echo esc_html($cookie_i18n['accept'][$lang]); ?>
				</button>

				<button type="button" class="cookie-banner__button cookie-banner__button--decline" id="cookie-decline">
					<?php echo esc_html($cookie_i18n['decline'][$lang]); ?>
				</button>
			</div>
		</div>
	</div>

	<?php wp_footer(); ?>
	</body>

	</html>
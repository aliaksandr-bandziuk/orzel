<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FLS
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="wrapper">


		<header class="header" id="siteHeader">
			<div class="header__placeholder" id="headerPlaceholder"></div>
			<div class="header__wrapper" id="headerWrapper">
				<div class="header__container relative">
					<div class="header__menu menu">
						<div class="burger-bg" data-fls-menu>
							<button type="button" class="menu__icon icon-menu" aria-label="Toggle Burger Menu"><span></span></button>
						</div>
						<div class="menu__wrapper">
							<div class="header-logo">
								<a href="<?php echo get_home_url(); ?>" class="header-logo__link">
									<img src="<?php
														$custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
														echo $custom_logo__url[0];
														?>" alt="Orzeł Realty" class="logo-image" width="150" height="150">
								</a>
							</div>
							<nav class="menu__body">
								<div class="nav__wrapper">
									<?php
									if (function_exists('pll_current_language')) {
										$current_language = pll_current_language();
										$menu_slug = '';

										switch ($current_language) {
											case 'en':
												$menu_slug = 'english-menu';
												break;
											case 'pl':
												$menu_slug = 'polish-menu';
												break;
											case 'ru':
												$menu_slug = 'russian-menu';
												break;
										}

										$menu = wp_get_nav_menu_object($menu_slug);

										if ($menu) {
											$menu_items = wp_get_nav_menu_items($menu->term_id);
											$menu_items_by_parent = array();

											foreach ($menu_items as $menu_item) {
												$menu_items_by_parent[$menu_item->menu_item_parent][] = $menu_item;
											}

											function display_menu_items($parent_id, $menu_items_by_parent)
											{
												if (!isset($menu_items_by_parent[$parent_id])) {
													return;
												}

												$is_submenu = $parent_id !== 0;
												$ul_class   = $is_submenu ? 'menu__sub-list' : 'menu__list';
												$link_class = $is_submenu ? 'menu__sub-link' : 'menu__link';

												echo '<ul class="' . esc_attr($ul_class) . '">';

												foreach ($menu_items_by_parent[$parent_id] as $menu_item) {
													$is_anchor         = strpos($menu_item->url, '#') !== false;
													$has_submenu       = isset($menu_items_by_parent[$menu_item->ID]);
													$is_active         = orzel_is_menu_item_active($menu_item->url);
													$has_active_child  = $has_submenu ? orzel_menu_item_has_active_child($menu_item->ID, $menu_items_by_parent) : false;

													$link_class_final = $link_class . ($is_anchor ? ' anchor-link' : '');
													if ($is_active) {
														$link_class_final .= ' is-active';
													}

													$item_class = $is_submenu ? 'menu__sub-item' : 'menu__item';

													if ($has_submenu && !$is_submenu) {
														$item_class .= ' menu__has-submenu';
													}

													if ($is_active) {
														$item_class .= ' is-active';
													}

													if ($has_active_child) {
														$item_class .= ' is-active-parent';
													}

													echo '<li class="' . esc_attr($item_class) . '">';

													echo '<a href="' . esc_url($menu_item->url) . '" class="' . esc_attr($link_class_final) . '"' . ($is_anchor ? ' data-scroll' : '') . ($is_active ? ' aria-current="page"' : '') . '>';
													echo esc_html($menu_item->title);

													if ($has_submenu) {
														echo '<svg class="menu__arrow" width="10" height="5" viewBox="7 10 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">';
														echo '<path d="M17 10.5L12 14.5" stroke="#F7F4EE" stroke-width="1.25" stroke-linecap="round" />';
														echo '<path d="M12 14.5L7 10.5" stroke="#F7F4EE" stroke-width="1.25" stroke-linecap="round" />';
														echo '</svg>';
													}

													echo '</a>';

													if ($has_submenu) {
														display_menu_items($menu_item->ID, $menu_items_by_parent);
													}

													echo '</li>';
												}

												echo '</ul>';
											}

											display_menu_items(0, $menu_items_by_parent);
										}
									}
									?>
									<div class="menu__mob-btn">
										<a href="tel:+48739103744" class="mob-menu-button">
											<span class="--icon-ico-callback ico-callback-header"></span>
											<div class="mob-menu-content">
												<span class="mob-menu-content__text">
													<?php echo pll_current_language() == 'pl' ? 'Uzyskać wycenę' : (pll_current_language() == 'ru' ? 'Получить предложение' : (pll_current_language() == 'uk' ? 'Отримати пропозицію' : 'Get quote')); ?>
												</span>
												<span class="mob-menu-content__phone">739 103 744</span>
											</div>
										</a>
									</div>
								</div>
							</nav>
							<div class="mobile-phone-link">
								<a href="tel:+48739103744">739 103 744</a>
							</div>
							<div class="header-elements">
								<div id="languageDropdown" class="language-dropdown">
									<div class="language-dropdown__wrapper">
										<button id="languageBtn" class="language-btn">
											<?php echo strtoupper(pll_current_language('slug')); ?>
										</button>
										<span id="arrowIcon" class="arrow-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="10" height="20" viewBox="0 0 10 20" fill="none">
												<path d="M1 9L4.64645 12.6464C4.84171 12.8417 5.15829 12.8417 5.35355 12.6464L9 9" stroke-linecap="round" />
											</svg>
										</span>
									</div>
									<ul class="language-list" id="languageList">
										<?php if (function_exists('pll_the_languages')) : ?>
											<?php
											$languages = pll_the_languages(['raw' => 1]);
											$current_language = pll_current_language('slug');

											foreach ($languages as $language) :
												if ($language['slug'] === $current_language) {
													continue;
												}
											?>
												<li>
													<a href="<?php echo esc_url($language['url']); ?>">
														<?php echo esc_html(strtoupper($language['slug'])); ?>
													</a>
												</li>
											<?php endforeach; ?>
										<?php endif; ?>
									</ul>
								</div>
								<div class="header-buttons">
									<a href="tel:+48517351391" class="header-phone-button">
										<span class="header-phone-button__icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
												<path d="M6.6 10.8C7.8 13.2 9.8 15.2 12.2 16.4L14 14.6C14.2 14.4 14.6 14.4 14.8 14.6C15.6 14.9 16.5 15.1 17.4 15.1C17.8 15.1 18.1 15.4 18.1 15.8V17.9C18.1 18.3 17.8 18.6 17.4 18.6C9.7 18.6 3.5 12.4 3.5 4.7C3.5 4.3 3.8 4 4.2 4H6.3C6.7 4 7 4.3 7 4.7C7 5.6 7.2 6.5 7.5 7.3C7.6 7.6 7.5 7.9 7.3 8.1L6.6 10.8Z" fill="#ffffff"/>
											</svg>
										</span>
										<div class="header-phone-button__text">
											<p>+48 517 351 391</p>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<?php
		$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
		$lang = in_array($current_lang, ['pl', 'en', 'ru', 'uk'], true) ? $current_lang : 'pl';

		$popup_title = [
			'pl' => 'Skontaktuj się z nami',
			'en' => 'Contact us',
			'ru' => 'Свяжитесь с нами',
			'uk' => 'Зв’яжіться з нами',
		];

		$popup_description = [
			'pl' => 'Masz pytanie dotyczące remontu lub chcesz otrzymać wycenę? Wypełnij formularz, a skontaktujemy się z Tobą tak szybko, jak to możliwe.',
			'en' => 'Do you have a renovation question or want to get a quote? Fill out the form and we will contact you as soon as possible.',
			'ru' => 'Есть вопрос по ремонту или хотите получить оценку? Заполните форму, и мы свяжемся с вами как можно скорее.',
			'uk' => 'Маєте питання щодо ремонту або хочете отримати оцінку? Заповніть форму, і ми зв’яжемося з вами якомога швидше.',
		];

		$popup_button_text = [
			'pl' => 'Wyślij formularz',
			'en' => 'Send form',
			'ru' => 'Отправить форму',
			'uk' => 'Надіслати форму',
		];

		$popup_i18n = [
			'name' => [
				'pl' => 'Imię',
				'en' => 'Name',
				'ru' => 'Имя',
				'uk' => 'Ім’я',
			],
			'phone' => [
				'pl' => 'Telefon',
				'en' => 'Phone',
				'ru' => 'Телефон',
				'uk' => 'Телефон',
			],
			'message' => [
				'pl' => 'Opisz zakres remontu (nieobowiązkowo)',
				'en' => 'Describe the renovation work (optional)',
				'ru' => 'Опишите объём ремонта (необязательно)',
				'uk' => 'Опишіть обсяг ремонту (необов’язково)',
			],
			'message_placeholder' => [
				'pl' => 'np. remont łazienki, odświeżenie mieszkania, malowanie ścian, wymiana podłogi',
				'en' => 'e.g. bathroom renovation, apartment refresh, wall painting, floor replacement',
				'ru' => 'например: ремонт ванной, обновление квартиры, покраска стен, замена пола',
				'uk' => 'наприклад: ремонт ванної, оновлення квартири, фарбування стін, заміна підлоги',
			],
			'upload' => [
				'pl' => 'Dodaj zdjęcia pomieszczenia lub miejsca do remontu',
				'en' => 'Add photos of the area that needs renovation',
				'ru' => 'Добавьте фото помещения или места, которое нужно отремонтировать',
				'uk' => 'Додайте фото приміщення або місця, яке потрібно відремонтувати',
			],

			'upload_note' => [
				'pl' => 'Możesz dodać maksymalnie 10 zdjęć (JPG, PNG, WebP), do 5 MB każde.',
				'en' => 'You can add up to 10 photos (JPG, PNG, WebP), 5 MB each maximum.',
				'ru' => 'Можно добавить до 10 фото (JPG, PNG, WebP), максимум 5 МБ каждое.',
				'uk' => 'Можна додати до 10 фото (JPG, PNG, WebP), максимум 5 МБ кожне.',
			],
		];
		?>

		<div id="popup-order" data-fls-popup="popup-order" aria-hidden="true" class="popup popup-order">
			<div data-fls-popup-wrapper class="popup__wrapper">
				<div data-fls-popup-body class="popup__body popup-order__content">
					<button data-fls-popup-close type="button" class="popup-order__close">
						<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.2218 13.6066L20 21.3848L21.4142 19.9706L13.636 12.1924L21.3848 4.44366L19.9706 3.02945L12.2218 10.7782L4.44365 3L3.02944 4.41421L10.8076 12.1924L3 20L4.41421 21.4142L12.2218 13.6066Z" fill="#fff"></path>
						</svg>
					</button>

					<div data-fls-popup-content class="popup__text">
						<div class="final-contact__inner popup-order__inner">
							<h2 class="h2-white mb20">
								<?php echo esc_html($popup_title[$lang]); ?>
							</h2>

							<form
								action="<?php echo esc_url(get_template_directory_uri() . '/sendmail/index.php'); ?>"
								method="post"
								autocomplete="off"
								class="small-form form-sending"
								enctype="multipart/form-data"
								data-fls-form="ajax"
								data-fls-form-popup="popup-thanks">

								<input type="hidden" name="page_url" value="">
								<input type="hidden" name="form_name" value="Форма в попапе">

								<div style="position:absolute; left:-9999px; opacity:0; pointer-events:none;" aria-hidden="true">
									<label for="website">Website</label>
									<input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
								</div>

								<div class="input-container">
									<input
										id="popup-name"
										type="text"
										name="name"
										class="input-contact"
										required
										data-fls-form-errtext="<?php echo esc_attr($lang === 'pl' ? 'Wpisz imię' : ($lang === 'ru' ? 'Введите имя' : ($lang === 'uk' ? 'Введіть ім’я' : 'Enter your name'))); ?>" />
									<label for="popup-name"><?php echo esc_html($popup_i18n['name'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['name'][$lang]); ?></span>
								</div>

								<div class="input-container">
									<input
										id="popup-phone"
										type="tel"
										name="phone"
										class="input-contact"
										required
										inputmode="tel"
										autocomplete="tel"
										placeholder="+48 123 456 789"
										data-phone-input
										data-fls-form-errtext="<?php echo esc_attr($lang === 'pl' ? 'Wpisz numer telefonu' : ($lang === 'ru' ? 'Введите номер телефона' : ($lang === 'uk' ? 'Введіть номер телефону' : 'Enter your phone number'))); ?>"
										data-phone-error="<?php echo esc_attr($lang === 'pl' ? 'Wpisz poprawny numer telefonu w formacie międzynarodowym, np. +48 123 456 789.' : ($lang === 'ru' ? 'Введите корректный номер телефона в международном формате, например: +48 123 456 789.' : ($lang === 'uk' ? 'Введіть коректний номер телефону в міжнародному форматі, наприклад: +48 123 456 789.' : 'Enter a valid phone number in international format, e.g. +48 123 456 789.'))); ?>" />
									<label for="popup-phone"><?php echo esc_html($popup_i18n['phone'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['phone'][$lang]); ?></span>
								</div>

								<div class="input-container textarea">
									<textarea
										id="popup-message"
										name="message"
										class="input-contact"
										placeholder="<?php echo esc_attr($popup_i18n['message_placeholder'][$lang]); ?>"></textarea>
									<label for="popup-message"><?php echo esc_html($popup_i18n['message'][$lang]); ?></label>
									<span><?php echo esc_html($popup_i18n['message'][$lang]); ?></span>
								</div>

								<div class="file-upload">
									<input
										type="file"
										name="wheel_photos[]"
										id="wheel_photos_popup"
										class="input-file"
										accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
										multiple
										data-max-files="10"
										data-max-file-size="<?php echo esc_attr(5 * 1024 * 1024); ?>"
										data-error-too-many="<?php echo esc_attr($lang === 'pl' ? 'Możesz dodać maksymalnie 10 zdjęć.' : ($lang === 'ru' ? 'Можно добавить максимум 10 фото.' : ($lang === 'uk' ? 'Можна додати максимум 10 фото.' : 'You can upload up to 10 photos.'))); ?>"
										data-error-too-large="<?php echo esc_attr($lang === 'pl' ? 'Plik jest za duży. Maksymalny rozmiar jednego zdjęcia to 5 MB.' : ($lang === 'ru' ? 'Файл слишком большой. Максимальный размер одного фото — 5 МБ.' : ($lang === 'uk' ? 'Файл занадто великий. Максимальний розмір одного фото — 5 МБ.' : 'File is too large. Maximum size per photo is 5 MB.'))); ?>"
										data-error-invalid-type="<?php echo esc_attr($lang === 'pl' ? 'Nieprawidłowy format pliku. Dozwolone: JPG, PNG, WebP.' : ($lang === 'ru' ? 'Недопустимый формат файла. Разрешены: JPG, PNG, WebP.' : ($lang === 'uk' ? 'Неприпустимий формат файлу. Дозволені: JPG, PNG, WebP.' : 'Invalid file type. Allowed: JPG, PNG, WebP.'))); ?>"
										data-remove-label="<?php echo esc_attr($lang === 'pl' ? 'Usuń' : ($lang === 'ru' ? 'Удалить' : ($lang === 'uk' ? 'Видалити' : 'Remove'))); ?>" />

									<label for="wheel_photos_popup" class="file-label">
										<?php echo esc_html($popup_i18n['upload'][$lang]); ?>
									</label>

									<div class="file-note">
										<?php echo esc_html($popup_i18n['upload_note'][$lang]); ?>
									</div>

									<div class="file-list" id="fileList_popup"></div>
								</div>

								<div class="form-message" aria-live="polite"></div>

								<button type="submit" class="button-primary btn" aria-label="<?php echo esc_attr($popup_button_text[$lang]); ?>">
									<?php echo esc_html($popup_button_text[$lang]); ?>
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="popup-thanks" data-fls-popup="popup-thanks" aria-hidden="true" class="popup popup-order popup-thanks">
			<div data-fls-popup-wrapper class="popup__wrapper">
				<div data-fls-popup-body class="popup__body popup-order__content">
					<button data-fls-popup-close type="button" class="popup-order__close">
						<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
							<path d="M12.2218 13.6066L20 21.3848L21.4142 19.9706L13.636 12.1924L21.3848 4.44366L19.9706 3.02945L12.2218 10.7782L4.44365 3L3.02944 4.41421L10.8076 12.1924L3 20L4.41421 21.4142L12.2218 13.6066Z" fill="#fff"></path>
						</svg>
					</button>

					<div data-fls-popup-content class="popup__text">
						<div class="final-contact__inner popup-order__inner popup-thanks__inner">
							<h2 class="h2-white mb20">
								<?php echo esc_html(
									$lang === 'pl' ? 'Dziękujemy!' : ($lang === 'ru' ? 'Спасибо!' : ($lang === 'uk' ? 'Дякуємо!' : 'Thank you!'))
								); ?>
							</h2>

							<div class="about-company__divider mb30">
								<svg xmlns="http://www.w3.org/2000/svg" width="64" height="8" aria-hidden="true">
									<path fill="#B89A68" d="M34 0h30v2H34zm0 6h15v2H34zM0 0h30v2H0zm15 6h15v2H15z" />
								</svg>
							</div>

							<p class="popup-thanks__text">
								<?php echo esc_html(
									$lang === 'pl' ? 'Formularz został wysłany. Skontaktujemy się z Tobą tak szybko, jak to możliwe.' : ($lang === 'ru' ? 'Форма успешно отправлена. Мы свяжемся с вами как можно скорее.' : ($lang === 'uk' ? 'Форму успішно надіслано. Ми зв’яжемося з вами якомога швидше.' : 'Your form has been sent. We will contact you as soon as possible.'))
								); ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
// Language detection — preserved exactly as before
$current_language = function_exists('pll_current_language') ? pll_current_language() : 'pl';
$footer_option_id = 'footer_' . $current_language;

// New contact & design fields
$footer_heading     = get_field('footer_heading',     $footer_option_id);
$footer_subheading  = get_field('footer_subheading',  $footer_option_id);
$footer_phone       = get_field('footer_phone',       $footer_option_id);
$footer_email       = get_field('footer_email',       $footer_option_id);
$footer_address     = get_field('footer_address',     $footer_option_id);
$footer_telegram    = get_field('footer_telegram',    $footer_option_id);
$footer_bg_image    = get_field('footer_bg_image',    $footer_option_id);
$footer_copyright   = get_field('footer_copyright',   $footer_option_id);
$footer_terms_label = get_field('footer_terms_label', $footer_option_id);
$footer_terms_url   = get_field('footer_terms_url',   $footer_option_id);

// Nav columns — existing DB group fields
$footer_quick_links = get_field('footer_quick_links', $footer_option_id);
$footer_services    = get_field('footer_services',    $footer_option_id);

// Privacy link — standalone fields (migrated from old footer_bottom group)
$footer_privacy_label = get_field('footer_privacy_label', $footer_option_id) ?: '';
$footer_privacy_url   = get_field('footer_privacy_url',   $footer_option_id) ?: '';

// Copyright: replace {year} placeholder, or fall back to generated string
if (!empty($footer_copyright)) {
	$footer_copyright = str_replace('{year}', date('Y'), $footer_copyright);
} else {
	$year = date('Y');
	switch ($current_language) {
		case 'ru': $footer_copyright = '© ' . $year . ' Orzeł Realty. Все права защищены.'; break;
		case 'uk': $footer_copyright = '© ' . $year . ' Orzeł Realty. Всі права захищені.'; break;
		case 'en': $footer_copyright = '© ' . $year . ' Orzeł Realty. All rights reserved.'; break;
		default:   $footer_copyright = '© ' . $year . ' Orzeł Realty. Wszelkie prawa zastrzeżone.'; break;
	}
}
?>

<footer class="footer"<?php if (!empty($footer_bg_image['url'])) : ?> style="background-image: url('<?php echo esc_url($footer_bg_image['url']); ?>')"<?php endif; ?>>
	<div class="footer__inner">

		<div class="footer__main">
			<div class="footer__content">

				<?php if ($footer_heading) : ?>
					<h2 class="footer__heading"><?php echo esc_html($footer_heading); ?></h2>
				<?php endif; ?>

				<?php if ($footer_subheading) : ?>
					<p class="footer__subheading"><?php echo esc_html($footer_subheading); ?></p>
				<?php endif; ?>

				<div class="footer__contacts">

					<?php if (!empty($footer_phone['label'])) :
							$phone_digits = preg_replace('/[^\d+]/', '', $footer_phone['label']);
							$phone_digits = preg_replace('/(?<!^)\+/', '', $phone_digits);
						?>
						<a href="tel:<?php echo esc_attr($phone_digits); ?>" class="footer__contact-row">
							<?php if (!empty($footer_phone['icon']['ID'])) : ?>
								<?php echo wp_get_attachment_image($footer_phone['icon']['ID'], [20, 20], false, [
									'class'       => 'footer__contact-icon',
									'alt'         => '',
									'aria-hidden' => 'true',
								]); ?>
							<?php endif; ?>
							<span class="footer__contact-text"><?php echo esc_html($footer_phone['label']); ?></span>
						</a>
					<?php endif; ?>

					<?php if (!empty($footer_email['label'])) : ?>
						<a href="mailto:<?php echo esc_attr($footer_email['label']); ?>" class="footer__contact-row">
							<?php if (!empty($footer_email['icon']['ID'])) : ?>
								<?php echo wp_get_attachment_image($footer_email['icon']['ID'], [20, 20], false, [
									'class'       => 'footer__contact-icon',
									'alt'         => '',
									'aria-hidden' => 'true',
								]); ?>
							<?php endif; ?>
							<span class="footer__contact-text"><?php echo esc_html($footer_email['label']); ?></span>
						</a>
					<?php endif; ?>

					<?php if (!empty($footer_address['label'])) : ?>
						<a href="<?php echo esc_url('https://www.google.com/maps/search/?api=1&query=' . urlencode($footer_address['label'])); ?>"
						   class="footer__contact-row"
						   target="_blank"
						   rel="noopener noreferrer">
							<?php if (!empty($footer_address['icon']['ID'])) : ?>
								<?php echo wp_get_attachment_image($footer_address['icon']['ID'], [20, 20], false, [
									'class'       => 'footer__contact-icon',
									'alt'         => '',
									'aria-hidden' => 'true',
								]); ?>
							<?php endif; ?>
							<span class="footer__contact-text"><?php echo esc_html($footer_address['label']); ?></span>
						</a>
					<?php endif; ?>

					<?php if (!empty($footer_telegram['label'])) : ?>
						<a href="<?php echo esc_url($footer_telegram['url'] ?? ''); ?>" class="footer__contact-row" target="_blank" rel="noopener noreferrer">
							<?php if (!empty($footer_telegram['icon']['ID'])) : ?>
								<?php echo wp_get_attachment_image($footer_telegram['icon']['ID'], [20, 20], false, [
									'class'       => 'footer__contact-icon',
									'alt'         => '',
									'aria-hidden' => 'true',
								]); ?>
							<?php endif; ?>
							<span class="footer__contact-text"><?php echo esc_html($footer_telegram['label']); ?></span>
						</a>
					<?php endif; ?>

				</div>
			</div>
		</div>

		<?php
		$ql_title  = !empty($footer_quick_links['title']) ? $footer_quick_links['title'] : '';
		$ql_items  = !empty($footer_quick_links['items']) ? $footer_quick_links['items'] : [];
		$svc_title = !empty($footer_services['title'])    ? $footer_services['title']    : '';
		$svc_items = !empty($footer_services['items'])    ? $footer_services['items']    : [];
		?>

		<?php if (!empty($ql_items) || !empty($svc_items)) : ?>
		<div class="footer__nav">

			<?php if (!empty($ql_items)) : ?>
			<div class="footer__nav-col">
				<?php if ($ql_title) : ?>
					<p class="footer__nav-title"><?php echo esc_html($ql_title); ?></p>
				<?php endif; ?>
				<ul class="footer__nav-list">
					<?php foreach ($ql_items as $item) :
						$raw         = $item['url'] ?? '';
						if (is_array($raw)) {
							$item_url    = $raw['url']    ?? '';
							$item_target = $raw['target'] ?? '_self';
							$item_label  = !empty($item['label']) ? $item['label'] : ($raw['title'] ?? '');
						} else {
							$item_url    = $raw;
							$item_target = '_self';
							$item_label  = $item['label'] ?? '';
						}
						if (empty($item_url) || empty($item_label)) continue;
					?>
						<li class="footer__nav-item">
							<a href="<?php echo esc_url($item_url); ?>"
							   target="<?php echo esc_attr($item_target); ?>"
							   class="footer__nav-link">
								<?php echo esc_html($item_label); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

			<?php if (!empty($svc_items)) : ?>
			<div class="footer__nav-col">
				<?php if ($svc_title) : ?>
					<p class="footer__nav-title"><?php echo esc_html($svc_title); ?></p>
				<?php endif; ?>
				<ul class="footer__nav-list">
					<?php foreach ($svc_items as $item) :
						$raw         = $item['url'] ?? '';
						if (is_array($raw)) {
							$item_url    = $raw['url']    ?? '';
							$item_target = $raw['target'] ?? '_self';
							$item_label  = !empty($item['label']) ? $item['label'] : ($raw['title'] ?? '');
						} else {
							$item_url    = $raw;
							$item_target = '_self';
							$item_label  = $item['label'] ?? '';
						}
						if (empty($item_url) || empty($item_label)) continue;
					?>
						<li class="footer__nav-item">
							<a href="<?php echo esc_url($item_url); ?>"
							   target="<?php echo esc_attr($item_target); ?>"
							   class="footer__nav-link">
								<?php echo esc_html($item_label); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>

		<div class="footer__bottom">

			<p class="footer__copyright"><?php echo esc_html($footer_copyright); ?></p>

			<?php if (($footer_privacy_label && $footer_privacy_url) || ($footer_terms_label && $footer_terms_url)) : ?>
				<div class="footer__links">
					<?php if ($footer_privacy_label && $footer_privacy_url) : ?>
						<a href="<?php echo esc_url($footer_privacy_url); ?>" class="footer__link">
							<?php echo esc_html($footer_privacy_label); ?>
						</a>
					<?php endif; ?>
					<?php if ($footer_terms_label && $footer_terms_url) : ?>
						<a href="<?php echo esc_url($footer_terms_url); ?>" class="footer__link">
							<?php echo esc_html($footer_terms_label); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="footer__developer">
				<span class="footer__developer-text"><?php
					switch ($current_language) {
						case 'ru': echo 'Сайт разработан'; break;
						case 'uk': echo 'Сайт розроблено'; break;
						case 'pl': echo 'Strona stworzona przez'; break;
						default:   echo 'Developed by'; break;
					}
				?></span>
				<a href="https://www.bandziuk.com" target="_blank" class="footer__developer-link" rel="noopener noreferrer">Bandziuk</a>
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

$privacy_page_url = 'https://orzel-realty.pl/polityka-prywatnosci/';
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

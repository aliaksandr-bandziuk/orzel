<?php

/**
 * FLS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package FLS
 */

//------------------------------------
// Підключення матеріалів
// не видаляти
//------------------------------------
require_once 'inc/assets-include.php';
//------------------------------------

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function fls_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on FLS, use a find and replace
		* to change 'fls' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('fls', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'fls'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'fls_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support('wp-block-styles'); // Поддержка стилей блоков
	add_theme_support('align-wide'); // Поддержка широкого выравнивания блоков
	add_theme_support('editor-styles'); // Подключение стилей редактора блоков
	add_editor_style(); // Подключение стилей для редактора
	add_image_size('hero-main', 1600, 0, false); // Размер для главного изображения в блоке Hero
	add_image_size('hero-mobile', 768, 0, false); // Размер для главного изображения в блоке Hero на мобильных устройствах
	add_image_size('portfolio-card', 600, 400, true); // Размер для изображений в карточках портфолио
	add_image_size('gallery-grid', 800, 600, true); // Размер для изображений в галерее
	add_image_size('gallery-grid-home', 520, 390, true); // Размер для изображений в галерее на главной странице
	add_image_size('before-after-main', 1400, 0, false); // Размер для изображений в блоке "До и После"
	add_image_size('service-card', 700, 460, true); // Размер для изображений в карточках услуг
	add_image_size('service-card-small', 420, 276, true); // Размер для изображений в карточках услуг на мобильных устройствах
	add_image_size('review-gallery', 720, 540, true); // Размер для изображений в галерее отзывов
	add_image_size('main-logo', 300, 0, false); // Размер для главного логотипа в шапке
}
add_action('after_setup_theme', 'fls_setup');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function fls_content_width()
{
	$GLOBALS['content_width'] = apply_filters('fls_content_width', 640);
}
add_action('after_setup_theme', 'fls_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function fls_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'fls'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'fls'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'fls_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

// Можливість завантажувати SVG
function my_own_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'my_own_mime_types');

// Перевірка на наявність плагіну
if (!function_exists('get_fls_field')) {
	function get_fls_field($field_name, $post_id = false, $default = null)
	{
		if (!function_exists('get_field')) {
			return $default;
		}
		$value = get_field($field_name, $post_id);
		return $value !== null ? $value : $default;
	}
}
if (!function_exists('get_fls_fields')) {
	function get_fls_fields($post_id = false, $default = null)
	{
		if (!function_exists('get_fields')) {
			return $default;
		}
		$value = get_fields($post_id);
		return $value !== null ? $value : $default;
	}
}

/**
 * Enqueue scripts and styles for admin.
 */
function fls_admin_scripts()
{
	wp_enqueue_style('fls-admin-styles', get_template_directory_uri() . '/style-admin.css', array(), _S_VERSION);
}
add_action('admin_enqueue_scripts', 'fls_admin_scripts');

// Advanced Custom Fields Start
// Advanced Custom Fields: multilingual footer options
add_action('acf/init', 'orzel_register_footer_options');

function orzel_register_footer_options()
{
	if (!function_exists('acf_add_options_page') || !function_exists('pll_languages_list')) {
		return;
	}

	$parent = acf_add_options_page([
		'page_title' => 'Footer',
		'menu_title' => 'Footer',
		'menu_slug'  => 'footer-settings',
		'capability' => 'manage_options',
		'redirect'   => true,
		'position'   => 30,
		'icon_url'   => 'dashicons-editor-kitchensink',
	]);

	$languages = pll_languages_list();

	foreach ($languages as $lang) {
		acf_add_options_sub_page([
			'page_title'  => sprintf('Footer (%s)', strtoupper($lang)),
			'menu_title'  => strtoupper($lang),
			'menu_slug'   => 'footer-' . $lang,
			'parent_slug' => 'footer-settings',
			'capability'  => 'manage_options',
			'post_id'     => 'footer_' . $lang,
		]);
	}
}

add_action('acf/init', 'orzel_register_acf_field_groups');
function orzel_register_acf_field_groups()
{
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	$template_dir = get_template_directory() . '/template-parts';

	$patterns = [
		$template_dir . '/blocks/*/group_*.json',
		$template_dir . '/fields/group_*.json',
	];

	$groups = [];
	foreach ($patterns as $pattern) {
		$found = glob($pattern);
		if ($found) {
			$groups = array_merge($groups, $found);
		}
	}

	foreach ($groups as $file) {
		$data = json_decode(file_get_contents($file), true);
		if ($data) {
			acf_add_local_field_group($data);
		}
	}
}

add_action('acf/init', 'orzel_register_acf_blocks');
function orzel_register_acf_blocks()
{
	if (function_exists('register_block_type')) {
		register_block_type(get_template_directory() . "/template-parts/blocks/mainHeroBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/mainBulletsBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/aboutRemontBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/servicesTabsBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/workingProcess/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/reviewsBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/finalContactBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/digitsBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/sliderFullBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/shortContactBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/faqBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/beforeAfterBlock/block.json");
		register_block_type(get_template_directory() . "/template-parts/blocks/servicesMainBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/sliderStandardBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/galleryCustomBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/ctaLiteBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/priceListBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/aboutCompanyBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/reviewsBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/brandsMarqueeBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/comparisonBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/teamBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/priceCalculatorBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/contentTabsBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/allContactsBlock/block.json");
		// register_block_type(get_template_directory() . "/template-parts/blocks/galleryManualBlock/block.json");
	}
}
// Advanced Custom Fields End

// cpt portfolio
add_action('init', 'orzel_register_portfolio_cpt', 0);

function orzel_register_portfolio_cpt()
{
	$labels = array(
		'name'                  => __('Portfolio', 'fls'),
		'singular_name'         => __('Portfolio Item', 'fls'),
		'menu_name'             => __('Portfolio', 'fls'),
		'name_admin_bar'        => __('Portfolio Item', 'fls'),
		'archives'              => __('Portfolio Archives', 'fls'),
		'attributes'            => __('Portfolio Attributes', 'fls'),
		'all_items'             => __('All Portfolio Items', 'fls'),
		'add_new_item'          => __('Add New Portfolio Item', 'fls'),
		'add_new'               => __('Add New', 'fls'),
		'new_item'              => __('New Portfolio Item', 'fls'),
		'edit_item'             => __('Edit Portfolio Item', 'fls'),
		'update_item'           => __('Update Portfolio Item', 'fls'),
		'view_item'             => __('View Portfolio Item', 'fls'),
		'view_items'            => __('View Portfolio Items', 'fls'),
		'search_items'          => __('Search Portfolio Items', 'fls'),
		'not_found'             => __('Not found', 'fls'),
		'not_found_in_trash'    => __('Not found in Trash', 'fls'),
		'featured_image'        => __('Featured Image', 'fls'),
		'set_featured_image'    => __('Set featured image', 'fls'),
		'remove_featured_image' => __('Remove featured image', 'fls'),
		'use_featured_image'    => __('Use as featured image', 'fls'),
		'items_list'            => __('Portfolio list', 'fls'),
		'items_list_navigation' => __('Portfolio list navigation', 'fls'),
		'filter_items_list'     => __('Filter portfolio list', 'fls'),
	);

	$args = array(
		'label'               => __('Portfolio', 'fls'),
		'description'         => __('Custom post type for portfolio items', 'fls'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
		'hierarchical'        => false,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'capability_type'     => 'post',
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-portfolio',
		'menu_position'       => 22,
		'rewrite'             => array(
			'slug'       => 'portfolio',
			'with_front' => false,
		),
	);

	register_post_type('portfolio', $args);
}
// cpt portfolio end

// portfolio property type taxonomy
add_action('init', 'orzel_register_property_type_taxonomy', 0);

function orzel_register_property_type_taxonomy()
{
	$labels = array(
		'name'          => __('Property Types', 'fls'),
		'singular_name' => __('Property Type', 'fls'),
		'menu_name'     => __('Property Types', 'fls'),
		'all_items'     => __('All Property Types', 'fls'),
		'edit_item'     => __('Edit Property Type', 'fls'),
		'update_item'   => __('Update Property Type', 'fls'),
		'add_new_item'  => __('Add New Property Type', 'fls'),
		'new_item_name' => __('New Property Type Name', 'fls'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'property-type',
			'with_front' => false,
		),
		'show_in_rest'      => true,
	);

	register_taxonomy('property_type', array('portfolio'), $args);
}
// portfolio property type taxonomy end

function orzel_add_property_type_taxonomy_to_polylang($taxonomies)
{
	$taxonomies[] = 'property_type';
	return $taxonomies;
}
add_filter('pll_get_taxonomies', 'orzel_add_property_type_taxonomy_to_polylang');

// add portfolio to polylang
function orzel_add_portfolio_to_polylang($types)
{
	$types[] = 'portfolio';
	return $types;
}
add_filter('pll_get_post_types', 'orzel_add_portfolio_to_polylang');
// add portfolio to polylang end

// portfolio metabox
add_action('add_meta_boxes', 'orzel_add_portfolio_metabox');

function orzel_add_portfolio_metabox()
{
	add_meta_box(
		'orzel_portfolio_data_metabox',
		'Portfolio Data',
		'orzel_render_portfolio_data_metabox',
		'portfolio',
		'side',
		'default'
	);
}

function orzel_render_portfolio_data_metabox($post)
{
	wp_nonce_field('orzel_save_portfolio_data', 'orzel_portfolio_nonce');

	$building_type = get_post_meta($post->ID, '_portfolio_building_type', true);
	$duration      = get_post_meta($post->ID, '_portfolio_duration', true);
	$service_name  = get_post_meta($post->ID, '_portfolio_service_name', true);
?>
	<p>
		<label for="portfolio_building_type"><strong>Rodzaj budynku:</strong></label><br>
		<input type="text" name="portfolio_building_type" id="portfolio_building_type" value="<?php echo esc_attr($building_type); ?>" style="width:100%;" placeholder="np. Mieszkalny">
	</p>

	<p>
		<label for="portfolio_duration"><strong>Czas:</strong></label><br>
		<input type="text" name="portfolio_duration" id="portfolio_duration" value="<?php echo esc_attr($duration); ?>" style="width:100%;" placeholder="np. 3 tygodnie">
	</p>

	<p>
		<label for="portfolio_service_name"><strong>Kwadrat:</strong></label><br>
		<input type="text" name="portfolio_service_name" id="portfolio_service_name" value="<?php echo esc_attr($service_name); ?>" style="width:100%;" placeholder="np. 120m²">
	</p>
	<?php
}

add_action('save_post_portfolio', 'orzel_save_portfolio_metabox');

function orzel_save_portfolio_metabox($post_id)
{
	if (!isset($_POST['orzel_portfolio_nonce'])) {
		return;
	}

	if (!wp_verify_nonce($_POST['orzel_portfolio_nonce'], 'orzel_save_portfolio_data')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['portfolio_building_type'])) {
		update_post_meta($post_id, '_portfolio_building_type', sanitize_text_field($_POST['portfolio_building_type']));
	}

	if (isset($_POST['portfolio_duration'])) {
		update_post_meta($post_id, '_portfolio_duration', sanitize_text_field($_POST['portfolio_duration']));
	}

	if (isset($_POST['portfolio_service_name'])) {
		update_post_meta($post_id, '_portfolio_service_name', sanitize_text_field($_POST['portfolio_service_name']));
	}
}
// portfolio metabox end

if (!function_exists('orzel_get_single_term_name')) {
	function orzel_get_single_term_name($post_id, $taxonomy)
	{
		$terms = get_the_terms($post_id, $taxonomy);

		if (empty($terms) || is_wp_error($terms)) {
			return '';
		}

		$first_term = reset($terms);

		return $first_term ? $first_term->name : '';
	}
}

// ajax portfolio filter/load more
function orzel_filter_portfolio_callback()
{
	$paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
	$lang  = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : '';
	$property_type = isset($_POST['property_type']) ? sanitize_text_field($_POST['property_type']) : 'all';

	$args = array(
		'post_type'        => 'portfolio',
		'posts_per_page'   => 8,
		'paged'            => $paged,
		'post_status'      => 'publish',
		'suppress_filters' => false,
	);

	if (!empty($lang)) {
		$args['lang'] = $lang;
	}

	if ($property_type !== 'all') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'property_type',
				'field'    => 'slug',
				'terms'    => $property_type,
			),
		);
	}

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();

		while ($query->have_posts()) {
			$query->the_post();

			$building_type = get_post_meta(get_the_ID(), '_portfolio_building_type', true);
			$duration      = get_post_meta(get_the_ID(), '_portfolio_duration', true);
			$service_name  = get_post_meta(get_the_ID(), '_portfolio_service_name', true);
	?>
			<a href="<?php the_permalink(); ?>" class="portfolio-card">
				<div class="portfolio-card__wrapper">
					<div class="portfolio-inner">
						<div class="portfolio-inner__item">
							<p class="portfolio-card__title"><?php the_title(); ?></p>

							<div class="portfolio-card__metas">
								<?php if ($building_type) : ?>
									<div class="portfolio-card__meta"><?php echo esc_html($building_type); ?></div>
								<?php endif; ?>

								<?php if ($duration) : ?>
									<div class="portfolio-card__meta"><?php echo esc_html($duration); ?></div>
								<?php endif; ?>

								<?php if ($service_name) : ?>
									<div class="portfolio-card__meta"><?php echo esc_html($service_name); ?></div>
								<?php endif; ?>
							</div>
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
							the_post_thumbnail('portfolio-card', [
								'loading' => 'lazy',
								'decoding' => 'async',
							]);
						} else {
							echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/no-image.webp') . '" alt="No image" loading="lazy" decoding="async">';
						}
						?>
					</div>
				</div>
			</a>
<?php
		}

		wp_reset_postdata();
		echo ob_get_clean();
	} else {
		echo '';
	}

	wp_die();
}
add_action('wp_ajax_filter_portfolio', 'orzel_filter_portfolio_callback');
add_action('wp_ajax_nopriv_filter_portfolio', 'orzel_filter_portfolio_callback');
// ajax portfolio filter/load more end

// meta box for gallery_item cpt
add_action('add_meta_boxes', function () {

	global $post;

	if (!$post) return;

	$template = get_page_template_slug($post->ID);

	if ($template !== 'page-gallery.php') {
		return;
	}

	add_meta_box(
		'orzel_pretitle',
		'Pretitle',
		'orzel_pretitle_metabox_callback',
		'page',
		'normal',
		'high'
	);
});
// meta box for gallery_item cpt end

// field inside meta box for gallery_item cpt
function orzel_pretitle_metabox_callback($post)
{

	$value = get_post_meta($post->ID, '_orzel_pretitle', true);

	wp_nonce_field('orzel_pretitle_nonce', 'orzel_pretitle_nonce');

	echo '<input type="text" style="width:100%;" name="orzel_pretitle" value="' . esc_attr($value) . '" placeholder="Galeria realizacji">';
}
// field inside meta box for gallery_item cpt end

// save meta box field for gallery_item cpt
add_action('save_post', function ($post_id) {

	if (!isset($_POST['orzel_pretitle_nonce'])) {
		return;
	}

	if (!wp_verify_nonce($_POST['orzel_pretitle_nonce'], 'orzel_pretitle_nonce')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (isset($_POST['orzel_pretitle'])) {

		update_post_meta(
			$post_id,
			'_orzel_pretitle',
			sanitize_text_field($_POST['orzel_pretitle'])
		);
	}
});
// save meta box field for gallery_item cpt end

// cpt gallery_item
add_action('init', function () {
	register_post_type('gallery_item', [
		'labels' => [
			'name'          => 'Gallery Items',
			'singular_name' => 'Gallery Item',
		],
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => ['title', 'thumbnail', 'excerpt'],
		'has_archive'        => false,
		'rewrite'            => false,
	]);
});
// cpt gallery_item end

// services helpers
if (!function_exists('orzel_get_services_base_slug')) {
	function orzel_get_services_base_slug($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$slugs = array(
			'en' => 'services',
			'pl' => 'uslugi',
			'ru' => 'uslugi',
		);

		return isset($slugs[$lang]) ? $slugs[$lang] : 'services';
	}
}

if (!function_exists('orzel_get_services_archive_url')) {
	function orzel_get_services_archive_url($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
		$base_slug    = orzel_get_services_base_slug($lang);

		if (!empty($lang) && $lang !== $default_lang) {
			return home_url('/' . $lang . '/' . $base_slug . '/');
		}

		return home_url('/' . $base_slug . '/');
	}
}

if (!function_exists('orzel_get_services_breadcrumb_title')) {
	function orzel_get_services_breadcrumb_title($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$titles = array(
			'en' => 'Services',
			'pl' => 'Usługi',
			'ru' => 'Услуги',
		);

		return isset($titles[$lang]) ? $titles[$lang] : 'Services';
	}
}
// services helpers end

// cpt services
add_action('init', 'orzel_register_services_cpt', 0);

function orzel_register_services_cpt()
{
	$labels = array(
		'name'                  => __('Services', 'fls'),
		'singular_name'         => __('Service', 'fls'),
		'menu_name'             => __('Services', 'fls'),
		'name_admin_bar'        => __('Service', 'fls'),
		'archives'              => __('Service Archives', 'fls'),
		'attributes'            => __('Service Attributes', 'fls'),
		'parent_item_colon'     => __('Parent Service:', 'fls'),
		'all_items'             => __('All Services', 'fls'),
		'add_new_item'          => __('Add New Service', 'fls'),
		'add_new'               => __('Add New', 'fls'),
		'new_item'              => __('New Service', 'fls'),
		'edit_item'             => __('Edit Service', 'fls'),
		'update_item'           => __('Update Service', 'fls'),
		'view_item'             => __('View Service', 'fls'),
		'view_items'            => __('View Services', 'fls'),
		'search_items'          => __('Search Service', 'fls'),
		'not_found'             => __('Not found', 'fls'),
		'not_found_in_trash'    => __('Not found in Trash', 'fls'),
		'featured_image'        => __('Featured Image', 'fls'),
		'set_featured_image'    => __('Set featured image', 'fls'),
		'remove_featured_image' => __('Remove featured image', 'fls'),
		'use_featured_image'    => __('Use as featured image', 'fls'),
		'insert_into_item'      => __('Insert into service', 'fls'),
		'uploaded_to_this_item' => __('Uploaded to this service', 'fls'),
		'items_list'            => __('Services list', 'fls'),
		'items_list_navigation' => __('Services list navigation', 'fls'),
		'filter_items_list'     => __('Filter services list', 'fls'),
	);

	$args = array(
		'label'               => __('Services', 'fls'),
		'description'         => __('Custom post type for services', 'fls'),
		'labels'              => $labels,
		'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
		'taxonomies'          => array('services_category'),
		'hierarchical'        => true,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => false,
		'capability_type'     => 'page',
		'map_meta_cap'        => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-admin-tools',
		'menu_position'       => 23,
		'rewrite' 						=> array(
			'slug'       => 'uslugi',
			'with_front' => false,
		),
	);

	register_post_type('services', $args);
}
// cpt services end

// services taxonomy
add_action('init', 'orzel_register_services_taxonomy', 0);

function orzel_register_services_taxonomy()
{
	$labels = array(
		'name'              => __('Service Categories', 'fls'),
		'singular_name'     => __('Service Category', 'fls'),
		'search_items'      => __('Search Service Categories', 'fls'),
		'all_items'         => __('All Service Categories', 'fls'),
		'parent_item'       => __('Parent Service Category', 'fls'),
		'parent_item_colon' => __('Parent Service Category:', 'fls'),
		'edit_item'         => __('Edit Service Category', 'fls'),
		'update_item'       => __('Update Service Category', 'fls'),
		'add_new_item'      => __('Add New Service Category', 'fls'),
		'new_item_name'     => __('New Service Category Name', 'fls'),
		'menu_name'         => __('Service Categories', 'fls'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array(
			'slug'       => 'services-category',
			'with_front' => false,
		),
		'show_in_rest'      => true,
	);

	register_taxonomy('services_category', array('services'), $args);
}
// services taxonomy end

// add services to polylang
function orzel_add_services_to_polylang($types)
{
	$types[] = 'services';
	return $types;
}
add_filter('pll_get_post_types', 'orzel_add_services_to_polylang');

function orzel_add_services_taxonomy_to_polylang($taxonomies)
{
	$taxonomies[] = 'services_category';
	return $taxonomies;
}
add_filter('pll_get_taxonomies', 'orzel_add_services_taxonomy_to_polylang');
// add services to polylang end

// services permalink with parents + language
function orzel_services_post_type_link($post_link, $post, $leavename, $sample)
{
	if ($post->post_type !== 'services') {
		return $post_link;
	}

	$lang         = function_exists('pll_get_post_language') ? pll_get_post_language($post->ID) : '';
	$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
	$base_slug    = orzel_get_services_base_slug($lang);

	$ancestors = get_post_ancestors($post->ID);
	$slug_path = '';

	if (!empty($ancestors)) {
		$ancestors = array_reverse($ancestors);

		foreach ($ancestors as $ancestor_id) {
			$ancestor = get_post($ancestor_id);

			if ($ancestor && $ancestor->post_type === 'services') {
				$slug_path .= $ancestor->post_name . '/';
			}
		}
	}

	if (!empty($lang) && $lang !== $default_lang) {
		return home_url('/' . $lang . '/' . $base_slug . '/' . $slug_path . $post->post_name . '/');
	}

	return home_url('/' . $base_slug . '/' . $slug_path . $post->post_name . '/');
}
add_filter('post_type_link', 'orzel_services_post_type_link', 10, 4);
// services permalink with parents + language end

// services rewrite rules
function orzel_services_rewrite_rules()
{
	if (function_exists('pll_languages_list') && function_exists('pll_default_language')) {
		$langs        = pll_languages_list();
		$default_lang = pll_default_language();

		foreach ($langs as $lang) {
			$base_slug = orzel_get_services_base_slug($lang);

			if ($lang === $default_lang) {
				add_rewrite_rule(
					'^' . $base_slug . '/(.+?)/?$',
					'index.php?services=$matches[1]',
					'top'
				);
			} else {
				add_rewrite_rule(
					'^' . $lang . '/' . $base_slug . '/(.+?)/?$',
					'index.php?lang=' . $lang . '&services=$matches[1]',
					'top'
				);
			}
		}
	} else {
		add_rewrite_rule(
			'^services/(.+?)/?$',
			'index.php?services=$matches[1]',
			'top'
		);
	}
}
add_action('init', 'orzel_services_rewrite_rules', 20);
// services rewrite rules end

// services canonical redirect
function orzel_services_template_redirect_canonical()
{
	if (!is_singular('services')) {
		return;
	}

	global $post, $wp;

	$canonical   = get_permalink($post);
	$current_url = home_url(add_query_arg(array(), $wp->request)) . '/';

	if (trailingslashit($current_url) !== trailingslashit($canonical)) {
		wp_redirect($canonical, 301);
		exit;
	}
}
add_action('template_redirect', 'orzel_services_template_redirect_canonical');
// services canonical redirect end

// output FAQ schema in JSON-LD format in the footer
add_action('wp_footer', 'orzel_output_faq_schema', 100);

function orzel_add_faq_schema_item($question, $answer)
{
	global $orzel_faq_schema_items;

	if (!is_array($orzel_faq_schema_items)) {
		$orzel_faq_schema_items = [];
	}

	$question = trim((string) $question);
	$answer   = trim((string) $answer);

	if ($question === '' || $answer === '') {
		return;
	}

	$answer_text = wp_strip_all_tags($answer, true);
	$answer_text = preg_replace('/\s+/', ' ', $answer_text);
	$answer_text = trim($answer_text);

	if ($answer_text === '') {
		return;
	}

	$orzel_faq_schema_items[] = [
		'@type' => 'Question',
		'name'  => $question,
		'acceptedAnswer' => [
			'@type' => 'Answer',
			'text'  => $answer_text,
		],
	];
}

function orzel_output_faq_schema()
{
	if (is_admin()) {
		return;
	}

	global $orzel_faq_schema_items;

	if (empty($orzel_faq_schema_items) || !is_array($orzel_faq_schema_items)) {
		return;
	}

	$unique_items = [];
	$seen_items = [];

	foreach ($orzel_faq_schema_items as $item) {
		$question = $item['name'] ?? '';
		$answer   = $item['acceptedAnswer']['text'] ?? '';

		if ($question === '' || $answer === '') {
			continue;
		}

		$hash = md5($question . '|' . $answer);

		if (isset($seen_items[$hash])) {
			continue;
		}

		$seen_items[$hash] = true;
		$unique_items[] = $item;
	}

	if (empty($unique_items)) {
		return;
	}

	$schema = [
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => array_values($unique_items),
	];

	echo '<script type="application/ld+json">' .
		wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) .
		'</script>';
}

if (!function_exists('orzel_get_blog_page_slug')) {
	function orzel_get_blog_page_slug($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$slugs = array(
			'pl' => 'blog',
			'en' => 'blog-en',
			'ru' => 'blog-ru',
		);

		return isset($slugs[$lang]) ? $slugs[$lang] : 'blog';
	}
}

if (!function_exists('orzel_get_blog_virtual_slug')) {
	function orzel_get_blog_virtual_slug()
	{
		return 'blog';
	}
}

if (!function_exists('orzel_get_blog_page_id_by_lang')) {
	function orzel_get_blog_page_id_by_lang($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$page_slug = orzel_get_blog_page_slug($lang);

		$pages = get_posts([
			'post_type'        => 'page',
			'name'             => $page_slug,
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'suppress_filters' => false,
			'lang'             => $lang,
			'fields'           => 'ids',
		]);

		if (!empty($pages)) {
			return (int) $pages[0];
		}

		return 0;
	}
}

if (!function_exists('orzel_get_blog_archive_url')) {
	function orzel_get_blog_archive_url($lang = '')
	{
		if (empty($lang) && function_exists('pll_current_language')) {
			$lang = pll_current_language();
		}

		$default_lang = function_exists('pll_default_language') ? pll_default_language() : '';
		$virtual_slug = orzel_get_blog_virtual_slug();

		if (!empty($lang) && $lang !== $default_lang) {
			return home_url('/' . $lang . '/' . $virtual_slug . '/');
		}

		return home_url('/' . $virtual_slug . '/');
	}
}

function orzel_blog_rewrite_rules()
{
	$virtual_slug = orzel_get_blog_virtual_slug();

	if (function_exists('pll_languages_list') && function_exists('pll_default_language')) {
		$langs        = pll_languages_list();
		$default_lang = pll_default_language();

		foreach ($langs as $lang) {
			if ($lang === $default_lang) {
				add_rewrite_rule(
					'^' . $virtual_slug . '/?$',
					'index.php?orzel_blog_lang=' . $lang,
					'top'
				);

				add_rewrite_rule(
					'^' . $virtual_slug . '/page/([0-9]{1,})/?$',
					'index.php?orzel_blog_lang=' . $lang . '&paged=$matches[1]',
					'top'
				);
			} else {
				add_rewrite_rule(
					'^' . $lang . '/' . $virtual_slug . '/?$',
					'index.php?orzel_blog_lang=' . $lang,
					'top'
				);

				add_rewrite_rule(
					'^' . $lang . '/' . $virtual_slug . '/page/([0-9]{1,})/?$',
					'index.php?orzel_blog_lang=' . $lang . '&paged=$matches[1]',
					'top'
				);
			}
		}
	}
}
add_action('init', 'orzel_blog_rewrite_rules', 20);

function orzel_blog_query_vars($vars)
{
	$vars[] = 'orzel_blog_lang';
	return $vars;
}
add_filter('query_vars', 'orzel_blog_query_vars');

function orzel_blog_request_to_page($query)
{
	if (is_admin() || !$query->is_main_query()) {
		return;
	}

	$blog_lang = $query->get('orzel_blog_lang');

	if (empty($blog_lang)) {
		return;
	}

	$page_id = orzel_get_blog_page_id_by_lang($blog_lang);

	if (!$page_id) {
		return;
	}

	$query->set('page_id', $page_id);
	$query->set('post_type', 'page');
	$query->set('pagename', '');
	$query->set('name', '');
	$query->set('lang', $blog_lang);

	$query->is_page = true;
	$query->is_singular = true;
	$query->is_single = false;
	$query->is_home = false;
	$query->is_archive = false;
	$query->is_post_type_archive = false;
	$query->is_posts_page = false;
	$query->is_404 = false;
}
add_action('pre_get_posts', 'orzel_blog_request_to_page');

function orzel_blog_template_redirect_canonical()
{
	if (!is_page()) {
		return;
	}

	$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
	$page_id      = get_queried_object_id();
	$blog_page_id = orzel_get_blog_page_id_by_lang($current_lang);

	if (!$page_id || !$blog_page_id || (int) $page_id !== (int) $blog_page_id) {
		return;
	}

	global $wp;

	$current_url = home_url(add_query_arg([], $wp->request));
	$canonical   = orzel_get_blog_archive_url($current_lang);

	$current_paged = max(1, get_query_var('paged'));

	if ($current_paged > 1) {
		$canonical = trailingslashit($canonical) . 'page/' . $current_paged . '/';
	}

	if (trailingslashit($current_url) !== trailingslashit($canonical)) {
		wp_redirect($canonical, 301);
		exit;
	}
}
add_action('template_redirect', 'orzel_blog_template_redirect_canonical', 1);

add_filter('wpseo_canonical', function ($canonical) {
	if (!is_page()) {
		return $canonical;
	}

	$current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
	$page_id      = get_queried_object_id();
	$blog_page_id = orzel_get_blog_page_id_by_lang($current_lang);

	if (!$page_id || !$blog_page_id || (int) $page_id !== (int) $blog_page_id) {
		return $canonical;
	}

	$url = orzel_get_blog_archive_url($current_lang);
	$current_paged = max(1, get_query_var('paged'));

	if ($current_paged > 1) {
		$url = trailingslashit($url) . 'page/' . $current_paged . '/';
	}

	return $url;
});


// custom breadcrumbs
function custom_breadcrumbs()
{
	$separator = ' / '; // не используется, если разделители не нужны
	$list_class = 'breadcrumbs__list';
	$current_lang = function_exists('pll_current_language') ? pll_current_language() : 'pl';
	$default_lang = function_exists('pll_default_language') ? pll_default_language() : 'pl';

	$home_titles = array(
		'en' => 'Homepage',
		'pl' => 'Strona główna',
		'ru' => 'Главная',
	);
	$home_title = isset($home_titles[$current_lang]) ? $home_titles[$current_lang] : $home_titles['en'];

	$posts_titles = array(
		'en' => 'Blog',
		'pl' => 'Blog',
		'ru' => 'Блог',
	);

	$portfolio_slugs = array(
		'en' => 'portfolio',
		'pl' => 'portfolio',
		'ru' => 'portfolio',
	);
	$landings_slugs = array(
		'en' => 'landings',
		'pl' => 'landings',
		'ru' => 'landings',
	);
	$portfolio_title = 'Portfolio';
	$landings_title = 'Landings';

	global $post;
	$home_url = get_home_url();

	// Начало JSON‑LD разметки
	$breadcrumbs_data = array(
		"@context" => "https://schema.org",
		"@type"    => "BreadcrumbList",
		"itemListElement" => array()
	);

	if (!is_front_page()) {
		echo '<ul class="' . $list_class . '" itemscope itemtype="https://schema.org/BreadcrumbList">';
		$position = 1;

		// Главная страница
		echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<a href="' . $home_url . '" class="breadcrumbs__link" itemprop="item">';
		echo '<span itemprop="name">' . $home_title . '</span>';
		echo '</a>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</li>';
		$breadcrumbs_data["itemListElement"][] = array(
			"@type"    => "ListItem",
			"position" => $position,
			"name"     => $home_title,
			"item"     => $home_url
		);
		$position++;

		// Для записей типа "services"
		if (is_singular('services')) {
			$services_title    = orzel_get_services_breadcrumb_title($current_lang);
			$services_page_url = orzel_get_services_archive_url($current_lang);

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . esc_url($services_page_url) . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . esc_html($services_title) . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';

			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $services_title,
				"item"     => $services_page_url
			);

			$position++;

			$ancestors = get_post_ancestors(get_the_ID());

			if (!empty($ancestors)) {
				$ancestors = array_reverse($ancestors);

				foreach ($ancestors as $ancestor_id) {
					$ancestor = get_post($ancestor_id);

					if (!$ancestor || $ancestor->post_type !== 'services') {
						continue;
					}

					echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
					echo '<a href="' . esc_url(get_permalink($ancestor_id)) . '" class="breadcrumbs__link" itemprop="item">';
					echo '<span itemprop="name">' . esc_html(get_the_title($ancestor_id)) . '</span>';
					echo '</a>';
					echo '<meta itemprop="position" content="' . $position . '" />';
					echo '</li>';

					$breadcrumbs_data["itemListElement"][] = array(
						"@type"    => "ListItem",
						"position" => $position,
						"name"     => get_the_title($ancestor_id),
						"item"     => get_permalink($ancestor_id)
					);

					$position++;
				}
			}

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';

			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "post"
		} elseif (is_singular('post')) {
			$posts_title    = isset($posts_titles[$current_lang]) ? $posts_titles[$current_lang] : 'Blog';
			$posts_page_url = orzel_get_blog_archive_url($current_lang);

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $posts_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . ucfirst($posts_title) . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => ucfirst($posts_title),
				"item"     => $posts_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "portfolio"
		} elseif (is_singular('portfolio')) {
			$portfolio_slug = 'portfolio';
			$portfolio_page_url = ($current_lang == $default_lang) ? home_url('/' . $portfolio_slug . '/') : home_url('/' . $current_lang . '/' . $portfolio_slug . '/');

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $portfolio_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . $portfolio_title . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $portfolio_title,
				"item"     => $portfolio_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Для записей типа "landings"
		} elseif (is_singular('landings')) {
			$landings_slug = isset($landings_slugs[$current_lang]) ? $landings_slugs[$current_lang] : 'landings';
			$landings_page_url = ($current_lang == $default_lang) ? home_url('/' . $landings_slug . '/') : home_url('/' . $current_lang . '/' . $landings_slug . '/');

			echo '<li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<a href="' . $landings_page_url . '" class="breadcrumbs__link" itemprop="item">';
			echo '<span itemprop="name">' . $landings_title . '</span>';
			echo '</a>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => $landings_title,
				"item"     => $landings_page_url
			);
			$position++;

			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);

			// Если это обычная страница
		} elseif (is_page()) {
			echo '<li class="breadcrumbs__item breadcrumbs__item--active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
			echo '<span itemprop="name">' . get_the_title() . '</span>';
			echo '<meta itemprop="position" content="' . $position . '" />';
			echo '</li>';
			$breadcrumbs_data["itemListElement"][] = array(
				"@type"    => "ListItem",
				"position" => $position,
				"name"     => get_the_title(),
				"item"     => get_permalink()
			);
		}

		echo '</ul>';
		echo '<script type="application/ld+json">' . json_encode($breadcrumbs_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
	}
}
// custom breadcrumbs

// functions for menu item active state
if (!function_exists('orzel_normalize_url_path')) {
	function orzel_normalize_url_path($url)
	{
		if (empty($url)) {
			return '/';
		}

		$path = wp_parse_url($url, PHP_URL_PATH);

		if (!$path) {
			$path = '/';
		}

		$path = trailingslashit($path);

		return $path;
	}
}

if (!function_exists('orzel_is_menu_item_active')) {
	function orzel_is_menu_item_active($menu_item_url)
	{
		if (empty($menu_item_url)) {
			return false;
		}

		// Якоря не активируем
		if (strpos($menu_item_url, '#') !== false) {
			return false;
		}

		// На главной вообще ничего не подсвечиваем
		if (is_front_page()) {
			return false;
		}

		$current_id = get_queried_object_id();
		$item_id    = url_to_postid($menu_item_url);

		if ($current_id && $item_id) {
			return (int) $current_id === (int) $item_id;
		}

		$current_url = trailingslashit(home_url(add_query_arg([], $GLOBALS['wp']->request)));
		$item_url    = trailingslashit($menu_item_url);

		return untrailingslashit($current_url) === untrailingslashit($item_url);
	}
}

if (!function_exists('orzel_menu_item_has_active_child')) {
	function orzel_menu_item_has_active_child($item_id, $menu_items_by_parent)
	{
		if (is_front_page()) {
			return false;
		}

		if (empty($menu_items_by_parent[$item_id])) {
			return false;
		}

		foreach ($menu_items_by_parent[$item_id] as $child_item) {
			if (orzel_is_menu_item_active($child_item->url)) {
				return true;
			}

			if (orzel_menu_item_has_active_child($child_item->ID, $menu_items_by_parent)) {
				return true;
			}
		}

		return false;
	}
}
// functions for menu item active state end

// add async loading for specific styles
add_filter('style_loader_tag', function ($html, $handle, $href, $media) {

	$async_styles = [];

	if (in_array($handle, $async_styles, true)) {
		return "<link rel='preload' href='{$href}' as='style' onload=\"this.onload=null;this.rel='stylesheet'\">\n<noscript><link rel='stylesheet' href='{$href}' media='{$media}'></noscript>";
	}

	return $html;
}, 10, 4);
// add async loading for specific styles end

// add defer loading for scripts except some specific ones
add_filter('script_loader_tag', function ($tag, $handle, $src) {

	if (is_admin()) return $tag;

	// исключения
	$exclude = [
		'gtm',
		'google-tag-manager',
		'jquery', // важно!
	];

	foreach ($exclude as $ex) {
		if (strpos($handle, $ex) !== false) {
			return $tag;
		}
	}

	// если уже есть defer или async — не трогаем
	if (strpos($tag, 'defer') !== false || strpos($tag, 'async') !== false) {
		return $tag;
	}

	// добавляем defer внутрь тега
	return str_replace('<script ', '<script defer ', $tag);
}, 10, 3);
// add defer loading for scripts except some specific ones end
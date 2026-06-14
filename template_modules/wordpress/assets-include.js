// Налаштування шаблону
import templateConfig from '../../template.config.js'
import logger from '../logger.js'
import fs from 'node:fs'

const isProduction = process.env.NODE_ENV === 'production'

export default function wpAssetsInclude() {
	const file = 'src/components/wordpress/fls-theme/inc/assets-include.php'
	const moduleType = []
	let data = '<?php\n'

	data += `const VITE_HOST = 'http://${templateConfig.server.hostname}:${templateConfig.server.port}';\n`
	data += `function add_vite() {\n`

	if (isProduction) {
		data += `$theme_dir = get_template_directory();\n`
		data += `$theme_uri = get_template_directory_uri();\n`

		data += `$app_css_path = $theme_dir . '/build/assets/css/app.min.css';\n`
		data += `$app_js_path = $theme_dir . '/build/assets/js/app.min.js';\n`
		data += `$custom_css_path = $theme_dir . '/build/assets/css/custom.css';\n`
		data += `$custom_js_path = $theme_dir . '/build/assets/js/custom.js';\n`

		data += `$app_css_ver = file_exists($app_css_path) ? filemtime($app_css_path) : null;\n`
		data += `$app_js_ver = file_exists($app_js_path) ? filemtime($app_js_path) : null;\n`
		data += `$custom_css_ver = file_exists($custom_css_path) ? filemtime($custom_css_path) : null;\n`
		data += `$custom_js_ver = file_exists($custom_js_path) ? filemtime($custom_js_path) : null;\n`

		data += `wp_enqueue_style('app.min.css', $theme_uri . '/build/assets/css/app.min.css', array(), $app_css_ver, 'all');\n`
		data += `wp_enqueue_script('app.min.js', $theme_uri . '/build/assets/js/app.min.js', array(), $app_js_ver, true);\n`

		moduleType.push('app.min.js')

		fs.writeFileSync('src/components/wordpress/fls-theme/build/assets/js/custom.js', '')
		fs.writeFileSync('src/components/wordpress/fls-theme/build/assets/css/custom.css', '')

		data += `wp_enqueue_style('vite-custom-css', $theme_uri . '/build/assets/css/custom.css', array(), $custom_css_ver, 'all');\n`
		data += `wp_enqueue_script('vite-custom-js', $theme_uri . '/build/assets/js/custom.js', array(), $custom_js_ver, true);\n`
	} else {
		data += `wp_enqueue_script('vite-client', VITE_HOST . '/@vite/client', array(), null, true);\n`
		data += `wp_enqueue_script('vite-app', VITE_HOST . '/components/wordpress/fls-theme/assets/app.js', array(), null, true);\n`

		moduleType.push('vite-client')
		moduleType.push('vite-app')

		if (templateConfig.images.svgsprite) {
			data += `wp_enqueue_script('vite-sprite', VITE_HOST . '/@vite-plugin-svg-spritemap/client__spritemap', array(), null, true);\n`
			moduleType.push('vite-sprite')
		}
	}

	data += `}\n`
	data += `add_action('wp_enqueue_scripts', 'add_vite');\n`

	data += `function add_type_module_attribute($tag, $handle) {\n`

	if (moduleType.length > 0) {
		data += `if (`
		moduleType.forEach((element, i) => {
			data += `${i ? ' || ' : ''}'${element}' === $handle`
		})
		data += `) {\n`
		data += `return str_replace('<script', '<script type="module"', $tag);\n`
		data += `}\n`
	}

	data += `return $tag;\n`
	data += `}\n`
	data += `add_filter('script_loader_tag', 'add_type_module_attribute', 10, 2);\n`
	data += `?>`

	fs.writeFileSync(file, data)
	logger('WordPress запущений')
}
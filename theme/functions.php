<?php
/**
 * Wades Plumbing & Septic functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wades_Plumbing_&_Septic
 */

if ( ! defined( 'WADES_PLUMBING_SEPTIC_VERSION' ) ) {
	/*
	 * Set the theme's version number.
	 *
	 * This is used primarily for cache busting.
	 */
	define( 'WADES_PLUMBING_SEPTIC_VERSION', '1.1.0' );
}

if ( ! defined( 'WADES_PLUMBING_SEPTIC_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `wades_plumbing_septic_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they're removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE's body class when it
	 * initializes.
	 */
	define(
		'WADES_PLUMBING_SEPTIC_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'wades_plumbing_septic_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wades_plumbing_septic_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Wades Plumbing & Septic, use a find and replace
		 * to change 'wades-plumbing-septic' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wades-plumbing-septic', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		// Add support for custom logo with specific dimensions
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary', 'wades-plumbing-septic' ),
				'menu-2' => __( 'Footer Menu', 'wades-plumbing-septic' ),
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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );
		add_editor_style( 'style-editor-extra.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'wades_plumbing_septic_setup' );

/**
 * Disable core emoji assets to avoid extra render-blocking scripts.
 *
 * @return void
 */
function wades_plumbing_septic_disable_wp_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'wades_plumbing_septic_disable_wp_emojis' );

/**
 * Normalize final front-end HTML shell.
 *
 * - Strip UTF-8 BOM bytes before HTML.
 * - Ensure `<!doctype html>` appears before `<html>`.
 * - Remove legacy/broken Matomo script tags (any host/path) that 404 in production.
 *   Note: tags injected dynamically by GTM must be removed in the GTM workspace.
 *
 * @param string $buffer Full response output buffer.
 * @return string
 */
function wades_plumbing_septic_normalize_frontend_html_shell( $buffer ) {
	if ( ! is_string( $buffer ) || '' === $buffer ) {
		return $buffer;
	}

	// Strip UTF-8 BOM from anywhere in the document.
	// A BOM inside <head> HTML causes the parser to prematurely close the head,
	// pushing all remaining wp_head() output into <body>.
	$buffer = str_replace( "\xEF\xBB\xBF", '', $buffer );

	$doctype_pattern = '#^\s*<!doctype\s+html>#i';
	if ( ! preg_match( $doctype_pattern, $buffer ) ) {
		$html_pos = stripos( $buffer, '<html' );
		if ( false !== $html_pos ) {
			$buffer = substr( $buffer, 0, $html_pos ) . "<!doctype html>\n" . substr( $buffer, $html_pos );
		}
	}

	$buffer = preg_replace(
		array(
			'#<script[^>]+src=["\'][^"\']*matomo\.js[^"\']*["\'][^>]*>\s*</script>#i',
			'#<script\b[^>]*>[\s\S]*?(?:cdn\.matomo\.cloud|matomo\.cloud)[\s\S]*?</script>#i',
		),
		'',
		$buffer
	);

	return is_string( $buffer ) ? $buffer : '';
}

/**
 * Start output buffering on front-end requests to strip leading BOM bytes.
 *
 * @return void
 */
function wades_plumbing_septic_start_frontend_buffer() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return;
	}

	ob_start( 'wades_plumbing_septic_normalize_frontend_html_shell' );
}
add_action( 'template_redirect', 'wades_plumbing_septic_start_frontend_buffer', 0 );

/**
 * Override Wade Forms script source to use theme-hosted fallback copy.
 *
 * Some environments can return 403 for plugin asset URLs. This preserves
 * the existing `wade-forms` handle and localization while forcing a stable URL.
 *
 * @param string $src    Script source URL.
 * @param string $handle Script handle.
 * @return string
 */
function wades_plumbing_septic_override_wade_forms_script_src( $src, $handle ) {
	if ( 'wade-forms' !== $handle ) {
		return $src;
	}

	$fallback_rel  = '/js/wade-forms.js';
	$fallback_path = get_template_directory() . $fallback_rel;
	if ( ! file_exists( $fallback_path ) ) {
		return $src;
	}

	$fallback_url = get_template_directory_uri() . $fallback_rel;
	$version      = (string) filemtime( $fallback_path );

	return add_query_arg( 'ver', $version, $fallback_url );
}
add_filter( 'script_loader_src', 'wades_plumbing_septic_override_wade_forms_script_src', 20, 2 );

/**
 * Setup Jetpack integration and add support for custom content types.
 */
function wades_plumbing_septic_jetpack_setup() {
	// Add theme support for Jetpack Custom Content Types
	add_theme_support( 'jetpack-content-options', array(
		'post-details' => array(
			'stylesheet' => 'wades-plumbing-septic-style',
			'date'       => '.posted-on',
			'categories' => '.cat-links',
			'tags'       => '.tags-links',
			'author'     => '.byline',
			'comment'    => '.comments-link',
		),
	) );
	
	// Add support for Jetpack portfolio and testimonial content types
	add_theme_support( 'jetpack-portfolio' );
	add_theme_support( 'jetpack-testimonial' );
	
	// Register custom service post type with Jetpack (enable if using Jetpack to manage the services)
	if ( function_exists( 'jetpack_register_custom_post_type' ) ) {
		// This requires Jetpack 3.1+ - it helps Jetpack recognize our custom post type
		add_filter( 'jetpack_custom_post_types', function( $post_types ) {
			$post_types[] = 'service';
			return $post_types;
		} );
	}
	
	// Force service custom content types to always be visible
	add_filter( 'classic_theme_helper_should_display_services', function( $should_display ) {
		return true;
	} );
}
add_action( 'after_setup_theme', 'wades_plumbing_septic_jetpack_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wades_plumbing_septic_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'wades-plumbing-septic' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'wades-plumbing-septic' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wades_plumbing_septic_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wades_plumbing_septic_scripts() {
	$asset_version = static function( $relative_path ) {
		$relative_path = '/' . ltrim( (string) $relative_path, '/' );
		$full_path     = get_template_directory() . $relative_path;
		if ( file_exists( $full_path ) ) {
			return (string) filemtime( $full_path );
		}
		return WADES_PLUMBING_SEPTIC_VERSION;
	};

	$style_registry = array(
		'wades-plumbing-septic-style' => array(
			'src'   => get_stylesheet_uri(),
			'deps'  => array(),
			'ver'   => $asset_version( 'style.css' ),
			'when'  => static function() {
				return true;
			},
		),
		'wades-plumbing-septic-custom-style' => array(
			'src'   => get_template_directory_uri() . '/assets/css/custom.css',
			'deps'  => array( 'wades-plumbing-septic-style' ),
			'ver'   => $asset_version( 'assets/css/custom.css' ),
			'when'  => static function() {
				return true;
			},
		),
		'wades-plumbing-septic-pagination' => array(
			'src'   => get_template_directory_uri() . '/assets/css/pagination.css',
			'deps'  => array(),
			'ver'   => $asset_version( 'assets/css/pagination.css' ),
			'when'  => static function() {
				return is_archive()
					|| is_home()
					|| is_search()
					|| is_singular( 'post' )
					|| is_singular( 'service' );
			},
		),
	);

	foreach ( $style_registry as $handle => $style ) {
		if ( ! $style['when']() ) {
			continue;
		}
		wp_enqueue_style( $handle, $style['src'], $style['deps'], $style['ver'] );
	}

	$script_registry = array(
		'wades-plumbing-septic-script' => array(
			'src'       => get_template_directory_uri() . '/js/script.min.js',
			'deps'      => array(),
			'ver'       => $asset_version( 'js/script.min.js' ),
			'in_footer' => true,
			'when'      => static function() {
				return true;
			},
		),
		'wades-plumbing-septic-conversion-tracking' => array(
			'src'       => get_template_directory_uri() . '/js/conversion-tracking.js',
			'deps'      => array(),
			'ver'       => $asset_version( 'js/conversion-tracking.js' ),
			'in_footer' => true,
			'when'      => static function() {
				return ! is_admin();
			},
		),
		'wades-plumbing-septic-fixed-header' => array(
			'src'       => get_template_directory_uri() . '/js/fixed-header.js',
			'deps'      => array(),
			'ver'       => $asset_version( 'js/fixed-header.js' ),
			'in_footer' => true,
			'when'      => static function() {
				return ! is_admin();
			},
		),
		'wades-plumbing-septic-shorts-feed' => array(
			'src'       => get_template_directory_uri() . '/assets/js/shorts-feed.js',
			'deps'      => array(),
			'ver'       => $asset_version( 'assets/js/shorts-feed.js' ),
			'in_footer' => true,
			'when'      => static function() {
				return is_page_template( 'template-shorts.php' );
			},
		),
	);

	foreach ( $script_registry as $handle => $script ) {
		if ( ! $script['when']() ) {
			continue;
		}
		wp_enqueue_script( $handle, $script['src'], $script['deps'], $script['ver'], $script['in_footer'] );
	}

	if ( wp_script_is( 'wades-plumbing-septic-conversion-tracking', 'enqueued' ) ) {
		wp_localize_script(
			'wades-plumbing-septic-conversion-tracking',
			'wadesTrackingConfig',
			wades_plumbing_septic_tracking_context()
		);
	}

	// Comment reply script - only on singular posts with comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wades_plumbing_septic_scripts' );

/**
 * Avoid loading Wade Forms assets on pages without the shortcode.
 *
 * @return void
 */
function wades_plumbing_septic_conditionally_dequeue_wade_forms() {
	if ( is_admin() ) {
		return;
	}

	$current_post = get_post();
	$has_wade_form = false;
	if ( $current_post instanceof WP_Post ) {
		$content = (string) $current_post->post_content;
		$has_wade_form = has_shortcode( $content, 'wade_contact_form' ) || has_shortcode( $content, 'formspree_form' );
	}

	if ( $has_wade_form ) {
		return;
	}

	if ( wp_script_is( 'wade-forms', 'enqueued' ) ) {
		wp_dequeue_script( 'wade-forms' );
		wp_deregister_script( 'wade-forms' );
	}
}
add_action( 'wp_enqueue_scripts', 'wades_plumbing_septic_conditionally_dequeue_wade_forms', 999 );

/**
 * Build conversion tracking metadata for page context.
 *
 * @return array<string,string>
 */
function wades_plumbing_septic_tracking_context() {
	$template = '';
	if ( is_singular() ) {
		$template = (string) get_page_template_slug( get_queried_object_id() );
	}

	$service_type = 'general';
	$urgency_type = 'standard';
	if ( false !== strpos( $template, 'emergency' ) ) {
		$service_type = 'emergency-plumbing';
		$urgency_type = 'emergency';
	} elseif ( false !== strpos( $template, 'water-main-sewer' ) ) {
		$service_type = 'water-main-sewer';
		$urgency_type = 'high-value';
	} elseif ( false !== strpos( $template, 'failed-septic' ) ) {
		$service_type = 'failed-septic';
		$urgency_type = 'high-value';
	} elseif ( false !== strpos( $template, 'engineered-septic' ) ) {
		$service_type = 'engineered-septic';
		$urgency_type = 'high-value';
	} elseif ( false !== strpos( $template, 'core-plumbing' ) ) {
		$service_type = 'core-plumbing';
	}

	return array(
		'landing_template' => $template,
		'service_type'     => $service_type,
		'urgency_type'     => $urgency_type,
		'cta_variant'      => 'phone_primary',
	);
}

/**
 * Mapbox + Service Area map (single template only).
 */
function wades_plumbing_septic_service_area_map_assets() {
	if ( ! is_page_template( 'template-service-areas.php' ) ) {
		return;
	}
	wp_enqueue_style(
		'mapbox-gl',
		'https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.css',
		array(),
		'3.1.2'
	);
	wp_enqueue_script(
		'mapbox-gl',
		'https://api.mapbox.com/mapbox-gl-js/v3.1.2/mapbox-gl.js',
		array(),
		'3.1.2',
		true
	);
	wp_enqueue_script(
		'service-area-map',
		get_template_directory_uri() . '/assets/js/dist/ServiceAreaMap.js',
		array( 'mapbox-gl' ),
		WADES_PLUMBING_SEPTIC_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'wades_plumbing_septic_service_area_map_assets', 20 );

/**
 * Enqueue the block editor script.
 */
function wades_plumbing_septic_enqueue_block_editor_script() {
	wp_enqueue_script(
		'wades-plumbing-septic-editor',
		get_template_directory_uri() . '/js/block-editor.min.js',
		array(
			'wp-blocks',
			'wp-edit-post',
		),
		WADES_PLUMBING_SEPTIC_VERSION,
		true
	);
	wp_add_inline_script( 'wades-plumbing-septic-editor', "tailwindTypographyClasses = '" . esc_attr( WADES_PLUMBING_SEPTIC_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
}
add_action( 'enqueue_block_editor_assets', 'wades_plumbing_septic_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function wades_plumbing_septic_tinymce_add_class( $settings ) {
	$settings['body_class'] = WADES_PLUMBING_SEPTIC_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'wades_plumbing_septic_tinymce_add_class' );

/**
 * Load all includes through a single bootstrap.
 */
require get_template_directory() . '/inc/bootstrap.php';

/**
 * Implement the Custom Header feature.
 */

/**
 * Add defer or async attributes to script tags
 * 
 * @param string $tag The script tag.
 * @param string $handle The script handle.
 * @return string Modified script tag.
 */
function wades_plumbing_septic_script_loader_tag($tag, $handle) {
	// List of scripts to defer (load in order but execute after parsing)
	// Defer is better than async for scripts that depend on each other
	$defer_scripts = array(
		'wades-plumbing-septic-script',
		'wades-plumbing-septic-conversion-tracking',
		'wades-plumbing-septic-parallax',
		'wades-plumbing-septic-fixed-header',
		'wade-forms',
		'mapbox-gl',
		'service-area-map',
		'comment-reply',
	);
	
	// List of scripts to load asynchronously (load in parallel, execute when ready)
	// Use async for independent scripts that don't depend on DOM or other scripts
	$async_scripts = array();
	
	// Add defer attribute (prevents render-blocking)
	if (in_array($handle, $defer_scripts)) {
		// Check if defer already exists to avoid duplicates
		if (strpos($tag, ' defer') === false) {
			return str_replace(' src', ' defer src', $tag);
		}
	}
	
	// Add async attribute
	if (in_array($handle, $async_scripts)) {
		if (strpos($tag, ' async') === false) {
			return str_replace(' src', ' async src', $tag);
		}
	}
	
	return $tag;
}
add_filter('script_loader_tag', 'wades_plumbing_septic_script_loader_tag', 10, 2);

/**
 * Add DNS prefetch and preconnect for external domains
 * Optimized for performance - preconnect for critical resources
 */
function wades_plumbing_septic_dns_prefetch() {
	// Only add hints for origins that are actually needed on the current template.
	if (!is_admin()) {
		// Service Areas map (Mapbox) — connect early on that template only
		if (is_page_template('template-service-areas.php')) {
			echo '<link rel="preconnect" href="https://api.mapbox.com" crossorigin>' . PHP_EOL;
			echo '<link rel="dns-prefetch" href="https://api.mapbox.com">' . PHP_EOL;
		}
		
		// Preload logo only on homepage where it contributes to above-the-fold paint.
		$custom_logo_id = get_theme_mod('custom_logo');
		if ($custom_logo_id && is_front_page()) {
			echo '<link rel="preconnect" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com" crossorigin>' . PHP_EOL;
			echo '<link rel="dns-prefetch" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com">' . PHP_EOL;
			$logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
			if ($logo_url) {
				echo '<link rel="preload" href="' . esc_url($logo_url) . '" as="image" fetchpriority="high">' . PHP_EOL;
			}
		}
	}
}
add_action('wp_head', 'wades_plumbing_septic_dns_prefetch', 0);

/**
 * Deprecated legacy meta output.
 * Kept for backward compatibility with existing hooks.
 */
function wades_plumbing_septic_add_meta_tags() {
	return;
}

/**
 * Implement page caching and performance optimizations
 */
function wades_plumbing_septic_setup_caching() {
	// Set appropriate caching headers for static resources
	if (!is_admin() && !is_user_logged_in()) {
		// Only apply caching for non-admin and non-logged-in users
		
		// Get the file extension to determine the content type
		$url = isset($_SERVER['REQUEST_URI']) ? esc_url_raw(wp_unslash($_SERVER['REQUEST_URI'])) : '';
		$ext = pathinfo($url, PATHINFO_EXTENSION);
		
		// Set cache control headers based on file type
		$cache_time = 0; // Default: no caching
		
		if (in_array($ext, ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'])) {
			// Static assets: cache for 1 week (604800 seconds)
			$cache_time = 604800;
		} elseif (is_front_page() || is_page() || is_single()) {
			// Pages and posts: cache for 1 day (86400 seconds)
			$cache_time = 86400;
		} elseif (is_archive() || is_category() || is_tag()) {
			// Archive pages: cache for 3 hours (10800 seconds)
			$cache_time = 10800;
		}
		
		if ($cache_time > 0) {
			header('Cache-Control: public, max-age=' . $cache_time);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_time) . ' GMT');
		}
	}
}
add_action('send_headers', 'wades_plumbing_septic_setup_caching');

/**
 * Add script attributes to optimize loading
 */
function wades_plumbing_septic_add_resource_hints($urls, $relation_type) {
	// Preload self-hosted fonts only (main CSS is loaded once via wp_enqueue_style).
	if ('preload' === $relation_type && file_exists(get_template_directory() . '/fonts/open-sans-v34-latin-regular.woff2')) {
		$urls[] = array(
			'href' => get_template_directory_uri() . '/fonts/open-sans-v34-latin-regular.woff2',
			'as' => 'font',
			'type' => 'font/woff2',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter('wp_resource_hints', 'wades_plumbing_septic_add_resource_hints', 10, 2);

/**
 * Implement browser caching
 */
function wades_plumbing_septic_htaccess_contents($rules) {
	$theme_path = get_template_directory();
	$htaccess_path = $theme_path . '/.htaccess';
	
	// Only update if we can actually write the file
	if (is_writable($htaccess_path) || (!file_exists($htaccess_path) && is_writable($theme_path))) {
		$custom_rules = "
# Caching rules for Wade's Plumbing & Septic Theme
<IfModule mod_expires.c>
    ExpiresActive On
    
    # Images
    ExpiresByType image/jpeg \"access plus 1 year\"
    ExpiresByType image/gif \"access plus 1 year\"
    ExpiresByType image/png \"access plus 1 year\"
    ExpiresByType image/webp \"access plus 1 year\"
    ExpiresByType image/svg+xml \"access plus 1 year\"
    ExpiresByType image/x-icon \"access plus 1 year\"
    
    # CSS, JavaScript
    ExpiresByType text/css \"access plus 1 month\"
    ExpiresByType text/javascript \"access plus 1 month\"
    ExpiresByType application/javascript \"access plus 1 month\"
    
    # Fonts
    ExpiresByType font/ttf \"access plus 1 year\"
    ExpiresByType font/otf \"access plus 1 year\"
    ExpiresByType font/woff \"access plus 1 year\"
    ExpiresByType font/woff2 \"access plus 1 year\"
    ExpiresByType application/font-woff \"access plus 1 year\"
    
    # Others
    ExpiresByType application/pdf \"access plus 1 month\"
    ExpiresByType application/x-shockwave-flash \"access plus 1 month\"
</IfModule>

# GZIP compression
<IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML and fonts
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
    AddOutputFilterByType DEFLATE application/x-font
    AddOutputFilterByType DEFLATE application/x-font-opentype
    AddOutputFilterByType DEFLATE application/x-font-otf
    AddOutputFilterByType DEFLATE application/x-font-truetype
    AddOutputFilterByType DEFLATE application/x-font-ttf
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE font/opentype
    AddOutputFilterByType DEFLATE font/otf
    AddOutputFilterByType DEFLATE font/ttf
    AddOutputFilterByType DEFLATE image/svg+xml
    AddOutputFilterByType DEFLATE image/x-icon
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml
    
    # Remove browser bugs
    BrowserMatch ^Mozilla/4 gzip-only-text/html
    BrowserMatch ^Mozilla/4\\.0[678] no-gzip
    BrowserMatch \\bMSIE !no-gzip !gzip-only-text/html
    Header append Vary User-Agent
</IfModule>
";
		
		// Only write theme .htaccess when explicitly enabled (avoids unexpected disk writes).
		if ( defined( 'WADES_ALLOW_THEME_HTACCESS_WRITE' ) && WADES_ALLOW_THEME_HTACCESS_WRITE ) {
			file_put_contents( $htaccess_path, $custom_rules );
		}
	}

	return $rules;
}
add_filter('mod_rewrite_rules', 'wades_plumbing_septic_htaccess_contents');

/**
 * Register a function to implement unstable-cache for server-side caching
 * (works with modern WordPress installations)
 */
function wades_plumbing_septic_setup_unstable_cache() {
	// Check if the wp_cache_add_unstable_cache_cb function exists (WordPress 6.2+)
	if (function_exists('wp_cache_add_non_persistent_groups')) {
		// Create a cache group for our theme
		wp_cache_add_non_persistent_groups('wades_plumbing_septic_cache');
		
		// We'll implement our own server-side caching for compatibility
		global $wp_version;
		$unstable_cache_available = version_compare($wp_version, '6.3', '>=');
		
		if ($unstable_cache_available && function_exists('wp_cache_add_unstable_cache_cb')) {
			// Register a callback for each major data type we want to cache
			wp_cache_add_unstable_cache_cb('wades_plumbing_septic_get_page_data', 'wades_plumbing_septic_cache_page_data_cb');
			wp_cache_add_unstable_cache_cb('wades_plumbing_septic_get_nav_data', 'wades_plumbing_septic_cache_nav_data_cb');
			wp_cache_add_unstable_cache_cb('wades_plumbing_septic_get_services', 'wades_plumbing_septic_cache_services_cb');
		}
	}
}
add_action('init', 'wades_plumbing_septic_setup_unstable_cache');

/**
 * Cache callback for page data
 */
function wades_plumbing_septic_cache_page_data_cb($page_id) {
	// This function will be called when the cache needs to be refreshed
	$page_data = array(
		'title' => get_the_title($page_id),
		'content' => apply_filters('the_content', get_post_field('post_content', $page_id)),
		'featured_image' => get_the_post_thumbnail_url($page_id, 'full'),
		'permalink' => get_permalink($page_id),
		'last_modified' => get_the_modified_time('U', $page_id),
	);
	
	return $page_data;
}

/**
 * Cache callback for navigation data
 */
function wades_plumbing_septic_cache_nav_data_cb($menu_location) {
	// This function will be called when the cache needs to be refreshed
	$locations = get_nav_menu_locations();
	if (isset($locations[$menu_location])) {
		$menu = wp_get_nav_menu_object($locations[$menu_location]);
		if ($menu) {
			return wp_get_nav_menu_items($menu->term_id);
		}
	}
	return array();
}

/**
 * Cache callback for services
 */
function wades_plumbing_septic_cache_services_cb() {
	// This function will be called when the cache needs to be refreshed
	$services = array();
	
	// Get services from custom post type or categories as appropriate
	$args = array(
		'post_type' => 'page', // Change to your custom post type if you have one
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => '_wp_page_template',
				'value' => 'page-service.php', // Change to your service template
			),
		),
	);
	
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$services[] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'excerpt' => get_the_excerpt(),
				'permalink' => get_permalink(),
				'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
			);
		}
		wp_reset_postdata();
	}
	
	return $services;
}

/**
 * Get page data with caching
 */
function wades_plumbing_septic_get_page_data($page_id) {
	$cache_key = 'page_data_' . $page_id;
	
	// Try to get from cache first
	$cached_data = wp_cache_get($cache_key, 'wades_plumbing_septic_cache');
	if (false !== $cached_data) {
		return $cached_data;
	}
	
	// If we're on WordPress 6.3+ and have unstable cache available
	global $wp_version;
	if (version_compare($wp_version, '6.3', '>=') && function_exists('wp_cache_unstable_get')) {
		return wp_cache_unstable_get($cache_key, 'wades_plumbing_septic_cache_page_data', array($page_id), DAY_IN_SECONDS);
	}
	
	// Fallback: generate the data and cache it ourselves
	$page_data = wades_plumbing_septic_cache_page_data_cb($page_id);
	wp_cache_set($cache_key, $page_data, 'wades_plumbing_septic_cache', DAY_IN_SECONDS);
	
	return $page_data;
}

/**
 * Get navigation data with caching
 */
function wades_plumbing_septic_get_nav_data($menu_location) {
	$cache_key = 'nav_data_' . $menu_location;
	
	// Try to get from cache first
	$cached_data = wp_cache_get($cache_key, 'wades_plumbing_septic_cache');
	if (false !== $cached_data) {
		return $cached_data;
	}
	
	// If we're on WordPress 6.3+ and have unstable cache available
	global $wp_version;
	if (version_compare($wp_version, '6.3', '>=') && function_exists('wp_cache_unstable_get')) {
		return wp_cache_unstable_get($cache_key, 'wades_plumbing_septic_cache_nav_data', array($menu_location), HOUR_IN_SECONDS);
	}
	
	// Fallback: generate the data and cache it ourselves
	$nav_data = wades_plumbing_septic_cache_nav_data_cb($menu_location);
	wp_cache_set($cache_key, $nav_data, 'wades_plumbing_septic_cache', HOUR_IN_SECONDS);
	
	return $nav_data;
}

/**
 * Get services with caching
 */
function wades_plumbing_septic_get_services() {
	$cache_key = 'services_data';
	
	// Try to get from cache first
	$cached_data = wp_cache_get($cache_key, 'wades_plumbing_septic_cache');
	if (false !== $cached_data) {
		return $cached_data;
	}
	
	// If we're on WordPress 6.3+ and have unstable cache available
	global $wp_version;
	if (version_compare($wp_version, '6.3', '>=') && function_exists('wp_cache_unstable_get')) {
		return wp_cache_unstable_get($cache_key, 'wades_plumbing_septic_cache_services', array(), DAY_IN_SECONDS);
	}
	
	// Fallback: generate the data and cache it ourselves
	$services = wades_plumbing_septic_cache_services_cb();
	wp_cache_set($cache_key, $services, 'wades_plumbing_septic_cache', DAY_IN_SECONDS);
	
	return $services;
}

/**
 * Deprecated legacy meta output.
 * Kept for backward compatibility with existing hooks.
 */
function wades_add_social_meta_tags() {
	return;
}

/**
 * Determine whether a dedicated SEO plugin controls head markup.
 *
 * @return bool
 */
function wades_plumbing_septic_has_external_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

/**
 * Canonical navigation path candidates.
 *
 * First path in each list is preferred when no page exists.
 *
 * @return array<string, array<int, string>>
 */
function wades_plumbing_septic_get_canonical_path_map() {
	return array(
		'home'                  => array( '' ),
		'services'              => array( 'services' ),
		'expert_tips'           => array( 'expert-tips', 'blog' ),
		'about'                 => array( 'about-us', 'about' ),
		'contact'               => array( 'contact' ),
		'service_areas'         => array( 'service-areas', 'service-area' ),
		'faq'                   => array( 'faq' ),
		'testimonials'          => array( 'testimonials' ),
		'financing'             => array( 'financing' ),
		'insurance_claims'      => array( 'insurance-claims' ),
		'careers'               => array( 'careers' ),
		'privacy_policy'        => array( 'privacy-policy' ),
		'terms_of_service'      => array( 'terms-of-service', 'terms' ),
		'septic_solutions'      => array( 'septic-solutions' ),
		'homeowners_septic_guide' => array( 'a-homeowners-guide-to-new-septic-systems-in-santa-cruz-county' ),
		'maintenance_guide'     => array( 'maintenance-guide' ),
		'glossary'              => array( 'glossary' ),
		'videos'                => array( 'videos', 'video-tutorials' ),
		'downloads'             => array( 'downloads' ),
		'shorts'                => array( 'shorts', 'field-shorts' ),
	);
}

/**
 * Resolve canonical URL for a nav key.
 *
 * @param string $key Nav key.
 * @return string
 */
function wades_plumbing_septic_get_canonical_page_url( $key ) {
	$map = wades_plumbing_septic_get_canonical_path_map();
	if ( ! isset( $map[ $key ] ) ) {
		return home_url( '/' );
	}

	foreach ( $map[ $key ] as $path ) {
		if ( '' === $path ) {
			return home_url( '/' );
		}
		$page = get_page_by_path( $path, OBJECT, 'page' );
		if ( $page instanceof WP_Post ) {
			return get_permalink( $page );
		}
		$post_ids = get_posts(
			array(
				'name'             => $path,
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'posts_per_page'   => 1,
				'fields'           => 'ids',
				'suppress_filters' => true,
				'no_found_rows'    => true,
			)
		);
		if ( ! empty( $post_ids ) ) {
			return get_permalink( (int) $post_ids[0] );
		}
	}

	return home_url( '/' . trailingslashit( $map[ $key ][0] ) );
}

/**
 * Privacy policy URL from Settings → Privacy, else canonical page slug fallback.
 *
 * @return string
 */
function wades_plumbing_septic_get_privacy_policy_url() {
	if ( function_exists( 'get_privacy_policy_url' ) ) {
		$url = get_privacy_policy_url();
		if ( $url ) {
			return $url;
		}
	}
	return wades_plumbing_septic_get_canonical_page_url( 'privacy_policy' );
}

/**
 * URL for the service post type archive (CPT rewrite slug: service-offerings).
 *
 * @return string
 */
function wades_plumbing_septic_get_service_post_type_archive_url() {
	$url = get_post_type_archive_link( 'service' );
	if ( $url ) {
		return $url;
	}
	return wades_plumbing_septic_get_canonical_page_url( 'services' );
}

/**
 * Permalink for a published service post by post_name, or service archive fallback.
 *
 * @param string $slug Post slug.
 * @return string
 */
function wades_plumbing_septic_get_service_permalink_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return wades_plumbing_septic_get_service_post_type_archive_url();
	}
	$ids = get_posts(
		array(
			'name'             => $slug,
			'post_type'        => 'service',
			'post_status'      => 'publish',
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'suppress_filters' => true,
			'no_found_rows'    => true,
		)
	);
	if ( ! empty( $ids ) ) {
		return get_permalink( (int) $ids[0] );
	}
	return wades_plumbing_septic_get_service_post_type_archive_url();
}

/**
 * URL for a service_category term by slug, or service archive fallback.
 *
 * @param string $slug Term slug.
 * @return string
 */
function wades_plumbing_septic_get_service_category_url_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return wades_plumbing_septic_get_service_post_type_archive_url();
	}
	$term = get_term_by( 'slug', $slug, 'service_category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return wades_plumbing_septic_get_service_post_type_archive_url();
	}
	$link = get_term_link( $term );
	if ( is_wp_error( $link ) || ! $link ) {
		return wades_plumbing_septic_get_service_post_type_archive_url();
	}
	return $link;
}

/**
 * URL for a blog category by slug, or canonical Expert Tips fallback.
 *
 * @param string $slug Category slug.
 * @return string
 */
function wades_plumbing_septic_get_blog_category_url_by_slug( $slug ) {
	$slug = sanitize_title( $slug );
	if ( '' === $slug ) {
		return wades_plumbing_septic_get_canonical_page_url( 'expert_tips' );
	}
	$term = get_term_by( 'slug', $slug, 'category' );
	if ( ! $term || is_wp_error( $term ) ) {
		return wades_plumbing_septic_get_canonical_page_url( 'expert_tips' );
	}
	$link = get_term_link( $term );
	if ( is_wp_error( $link ) || ! $link ) {
		return wades_plumbing_septic_get_canonical_page_url( 'expert_tips' );
	}
	return $link;
}

/**
 * Turn legacy theme paths into real URLs (service CPT archive base: service-offerings).
 *
 * Handles e.g. services/categories/{term}, services/{service-slug}, service-offerings/{slug}.
 *
 * @param string $path Path beginning with / or bare (e.g. /services/drain-cleaning).
 * @return string
 */
function wades_plumbing_septic_resolve_legacy_service_path( $path ) {
	$path = trim( (string) $path, '/' );
	if ( '' === $path ) {
		return wades_plumbing_septic_get_service_post_type_archive_url();
	}
	if ( preg_match( '#^services/categories/([^/]+)/?$#', $path, $m ) ) {
		return wades_plumbing_septic_get_service_category_url_by_slug( $m[1] );
	}
	if ( preg_match( '#^services/#', $path ) ) {
		$rest = substr( $path, strlen( 'services/' ) );
		$slug = ( strpos( $rest, '/' ) !== false ) ? basename( $rest ) : $rest;
		return wades_plumbing_septic_get_service_permalink_by_slug( $slug );
	}
	if ( preg_match( '#^service-offerings/#', $path ) ) {
		return wades_plumbing_septic_get_service_permalink_by_slug( basename( $path ) );
	}
	return wades_plumbing_septic_get_service_permalink_by_slug( basename( $path ) );
}

/**
 * Redirect known alias paths to canonical nav URLs.
 *
 * @return void
 */
function wades_plumbing_septic_redirect_nav_aliases() {
	if ( is_admin() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( '' === $request_uri ) {
		return;
	}

	$path         = (string) parse_url( $request_uri, PHP_URL_PATH );
	$site_path    = trim( (string) parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	$request_path = trim( $path, '/' );

	if ( '' !== $site_path && strpos( $request_path, $site_path . '/' ) === 0 ) {
		$request_path = substr( $request_path, strlen( $site_path ) + 1 );
	}

	if ( '' === $request_path ) {
		return;
	}

	$aliases = array(
		'about'         => array( 'about', 'about-us' ),
		'expert_tips'   => array( 'blog', 'expert-tips' ),
		'services'      => array( 'service-offerings' ),
		'service_areas' => array( 'service-area', 'service-areas' ),
	);

	foreach ( $aliases as $key => $possible_paths ) {
		if ( ! in_array( $request_path, $possible_paths, true ) ) {
			continue;
		}

		$canonical_url  = wades_plumbing_septic_get_canonical_page_url( $key );
		$canonical_path = trim( (string) parse_url( $canonical_url, PHP_URL_PATH ), '/' );

		if ( $request_path !== $canonical_path ) {
			wp_safe_redirect( $canonical_url, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'wades_plumbing_septic_redirect_nav_aliases', 1 );

/**
 * Remove accidental head markup injected inside <body> before #page.
 *
 * Some production stacks/plugins can inject duplicate header/head fragments
 * after <body>, which breaks layout and can cause front-page scaling issues.
 *
 * @param string $html Full HTML response buffer.
 * @return string
 */
function wades_plumbing_septic_strip_body_injected_head_markup( $html ) {
	if ( ! is_string( $html ) || '' === $html ) {
		return $html;
	}

	$body_start = stripos( $html, '<body' );
	if ( false === $body_start ) {
		return $html;
	}

	$body_open_end = strpos( $html, '>', $body_start );
	if ( false === $body_open_end ) {
		return $html;
	}

	$page_marker_double = '<div id="page">';
	$page_marker_single = "<div id='page'>";
	$page_pos           = stripos( $html, $page_marker_double, $body_open_end );
	$page_marker        = $page_marker_double;

	if ( false === $page_pos ) {
		$page_pos    = stripos( $html, $page_marker_single, $body_open_end );
		$page_marker = $page_marker_single;
	}

	if ( false === $page_pos ) {
		return $html;
	}

	$between = substr( $html, $body_open_end + 1, $page_pos - ( $body_open_end + 1 ) );
	if ( false === $between || '' === $between ) {
		return $html;
	}

	$looks_like_head_fragment =
		false !== stripos( $between, '<meta charset' )
		|| false !== stripos( $between, '<meta name="viewport"' )
		|| false !== stripos( $between, '<link rel="profile"' )
		|| false !== stripos( $between, '<title' )
		|| false !== stripos( $between, 'id="wades-critical-css"' )
		|| false !== stripos( $between, '<style id="wades-plumbing-septic-style-inline-css"' );

	if ( ! $looks_like_head_fragment ) {
		return $html;
	}

	$preserved = '';

	// Keep valid noscript content that belongs in wp_body_open.
	if ( preg_match_all( '#<noscript>.*?</noscript>#is', $between, $noscripts ) && ! empty( $noscripts[0] ) ) {
		$preserved = implode( "\n", $noscripts[0] );
	}

	// Preserve any stylesheet payload injected after <body> to avoid unstyled pages.
	$preserved_styles = array();
	if ( preg_match_all( '#<link\b[^>]*rel=(["\'])stylesheet\1[^>]*>#is', $between, $style_links ) && ! empty( $style_links[0] ) ) {
		$preserved_styles = array_merge( $preserved_styles, $style_links[0] );
	}
	if ( preg_match_all( '#<style\b[^>]*>.*?</style>#is', $between, $style_blocks ) && ! empty( $style_blocks[0] ) ) {
		$preserved_styles = array_merge( $preserved_styles, $style_blocks[0] );
	}
	if ( ! empty( $preserved_styles ) ) {
		$preserved_styles = array_values( array_unique( array_map( 'trim', $preserved_styles ) ) );
		$preserved       .= ( '' !== $preserved ? "\n" : '' ) . implode( "\n", $preserved_styles );
	}

	$before = substr( $html, 0, $body_open_end + 1 );
	$after  = substr( $html, $page_pos );

	if ( false === $before || false === $after ) {
		return $html;
	}

	$debug_marker = "\n<!-- wades-body-sanitizer: stripped-duplicate-head -->\n";

	return $before . $debug_marker . $preserved . "\n" . $page_marker . substr( $after, strlen( $page_marker ) );
}

/**
 * Start output buffering to sanitize malformed body preamble.
 *
 * @return void
 */
function wades_plumbing_septic_start_body_markup_sanitizer() {
	if ( is_admin() || wp_doing_ajax() || is_feed() || is_robots() || is_trackback() ) {
		return;
	}

	ob_start( 'wades_plumbing_septic_strip_body_injected_head_markup' );
}
add_action( 'template_redirect', 'wades_plumbing_septic_start_body_markup_sanitizer', 0 );

/**
 * Emergency guard: disable front-page cache layers while malformed body preamble is investigated.
 *
 * @return void
 */
function wades_plumbing_septic_disable_front_page_cache_temporarily() {
	if ( is_admin() || is_user_logged_in() || ! is_front_page() ) {
		return;
	}

	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}

	if ( function_exists( 'nocache_headers' ) ) {
		nocache_headers();
	}

	// LiteSpeed-specific no-cache control if plugin is active.
	do_action( 'litespeed_control_set_nocache', 'wades_frontpage_debug' );
}
add_action( 'template_redirect', 'wades_plumbing_septic_disable_front_page_cache_temporarily', -100 );

/**
 * Cached latest posts for repeated navigation render paths.
 *
 * @param int $count Number of posts.
 * @return array<int, array<string, mixed>>
 */
function wades_plumbing_septic_get_cached_recent_posts( $count = 5 ) {
	$count = max( 1, (int) $count );
	$key   = 'wades_recent_posts_' . $count;
	$posts = get_transient( $key );
	if ( is_array( $posts ) ) {
		return $posts;
	}

	$posts = wp_get_recent_posts(
		array(
			'numberposts' => $count,
			'post_status' => 'publish',
		)
	);
	set_transient( $key, $posts, HOUR_IN_SECONDS );

	return is_array( $posts ) ? $posts : array();
}

/**
 * Cached service links for mega-menu sections.
 *
 * @param int $term_id Service category term ID.
 * @return array<int, array{title:string,url:string}>
 */
function wades_plumbing_septic_get_cached_service_menu_items( $term_id ) {
	$term_id = (int) $term_id;
	if ( $term_id <= 0 ) {
		return array();
	}

	$key   = 'wades_service_menu_' . $term_id;
	$items = get_transient( $key );
	if ( is_array( $items ) ) {
		return $items;
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'service',
			'posts_per_page' => 5,
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'tax_query'      => array(
				array(
					'taxonomy' => 'service_category',
					'field'    => 'term_id',
					'terms'    => $term_id,
				),
			),
		)
	);

	$items = array();
	if ( ! empty( $query->posts ) ) {
		foreach ( $query->posts as $post_id ) {
			$items[] = array(
				'title' => get_the_title( $post_id ),
				'url'   => get_permalink( $post_id ),
			);
		}
	}
	wp_reset_postdata();

	set_transient( $key, $items, HOUR_IN_SECONDS );
	return $items;
}

/**
 * Meta description for the current request (used by Lighthouse + search snippets).
 *
 * @return string
 */
function wades_plumbing_septic_get_document_meta_description() {
	if ( is_admin() ) {
		return '';
	}

	$description = get_theme_mod( 'meta_description', '' );
	if ( empty( $description ) ) {
		$description = get_bloginfo( 'description' );
	}

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			$meta_description = (string) get_post_meta( $post_id, '_wades_seo_description', true );
			if ( ! empty( $meta_description ) ) {
				$description = $meta_description;
			} elseif ( has_excerpt( $post_id ) ) {
				$description = wp_strip_all_tags( get_the_excerpt( $post_id ) );
			} else {
				$raw = wp_strip_all_tags( get_post_field( 'post_content', $post_id ) );
				$raw = preg_replace( '/\s+/', ' ', $raw );
				$sentences = preg_split( '/(?<=[.!?…])\s+/', $raw, -1, PREG_SPLIT_NO_EMPTY );
				$built       = '';
				foreach ( $sentences as $sentence ) {
					$cand = $built ? $built . ' ' . $sentence : $sentence;
					if ( strlen( $cand ) > 155 ) {
						break;
					}
					$built = $cand;
				}
				$description = $built ?: wp_trim_words( $raw, 28 );
			}
		}
	} elseif ( is_archive() ) {
		$description = wp_strip_all_tags( get_the_archive_description() );
	} elseif ( is_search() ) {
		$description = sprintf( 'Search results for "%s" on %s.', get_search_query(), get_bloginfo( 'name' ) );
	}

	$description = wp_strip_all_tags( (string) $description );
	if ( empty( $description ) ) {
		$description = 'Professional plumbing and septic services.';
	}

	return $description;
}

/**
 * Print meta description as early as possible in wp_head (Lighthouse reads head order reliably).
 *
 * @return void
 */
function wades_plumbing_septic_print_meta_description_early() {
	if ( is_admin() ) {
		return;
	}
	echo '<meta name="description" content="' . esc_attr( wades_plumbing_septic_get_document_meta_description() ) . '" />' . PHP_EOL;
}
add_action( 'wp_head', 'wades_plumbing_septic_print_meta_description_early', 0 );

/**
 * Build and output canonical SEO tags and JSON-LD.
 *
 * @return void
 */
function wades_plumbing_septic_output_seo_head() {
	if ( is_admin() ) {
		return;
	}

	$seo_location = get_option( 'wades_seo_location_settings', array() );
	$seo_social   = get_option( 'wades_seo_social_settings', array() );
	$primary_location = isset( $seo_location['primary_location'] ) ? (string) $seo_location['primary_location'] : 'ca';
	$location_map = array(
		'ca' => array(
			'area_name' => 'Santa Cruz County, California',
			'region'    => 'CA',
		),
		'ga' => array(
			'area_name' => 'Pickens County, Georgia',
			'region'    => 'GA',
		),
	);
	$primary_area_name = isset( $location_map[ $primary_location ] ) ? $location_map[ $primary_location ]['area_name'] : 'Santa Cruz County, California';
	$service_area_summary = function_exists( 'wades_plumbing_septic_get_service_area_summary' )
		? wades_plumbing_septic_get_service_area_summary()
		: 'Santa Cruz County, CA and Pickens County, GA';
	$business_hours = function_exists( 'wades_plumbing_septic_get_business_hours' )
		? wades_plumbing_septic_get_business_hours()
		: '';
	$business_start_year = function_exists( 'wades_plumbing_septic_get_business_start_year' )
		? wades_plumbing_septic_get_business_start_year()
		: '';

	$wades_site_home = wades_plumbing_septic_get_canonical_page_url( 'home' );
	$wades_site_root = untrailingslashit( $wades_site_home );

	$title = wp_get_document_title();
	if ( empty( $title ) ) {
		$title = get_bloginfo( 'name' );
	}

	$description = wades_plumbing_septic_get_document_meta_description();
	$image       = '';
	$url         = is_front_page() ? $wades_site_home : '';

	if ( is_singular() ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			$url   = get_permalink( $post_id );
			$image = get_the_post_thumbnail_url( $post_id, 'full' );

			// Priority 1: human-saved SEO meta fields (meta box or automation).
			$meta_title       = (string) get_post_meta( $post_id, '_wades_seo_title', true );
			$meta_og_image_id = (int) get_post_meta( $post_id, '_wades_seo_og_image_id', true );

			if ( ! empty( $meta_title ) ) {
				$title = $meta_title;
			}

			if ( $meta_og_image_id > 0 ) {
				$og_override = wp_get_attachment_image_url( $meta_og_image_id, 'full' );
				if ( $og_override ) {
					$image = $og_override;
				}
			}
		}
	} elseif ( is_archive() ) {
		$obj = get_queried_object();
		if ( isset( $obj->term_id, $obj->taxonomy ) ) {
			$term_link = get_term_link( (int) $obj->term_id, $obj->taxonomy );
			if ( ! is_wp_error( $term_link ) ) {
				$url = $term_link;
			}
		} elseif ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );
			$post_type = is_array( $post_type ) ? reset( $post_type ) : $post_type;
			if ( is_string( $post_type ) ) {
				$archive_link = get_post_type_archive_link( $post_type );
				if ( ! empty( $archive_link ) ) {
					$url = $archive_link;
				}
			}
		}
	} elseif ( is_search() ) {
		$url = home_url( '/?s=' . rawurlencode( get_search_query() ) );
	} elseif ( is_home() && ! is_front_page() ) {
		$page_for_posts = (int) get_option( 'page_for_posts' );
		if ( $page_for_posts > 0 ) {
			$url = get_permalink( $page_for_posts );
		}
	}

	if ( empty( $url ) ) {
		$url = $wades_site_home;
	}

	if ( empty( $image ) ) {
		$custom_logo_id = (int) get_theme_mod( 'custom_logo' );
		$image = $custom_logo_id ? wp_get_attachment_image_url( $custom_logo_id, 'full' ) : '';
		if ( empty( $image ) && function_exists( 'wades_get_image_with_fallback' ) ) {
			$image = wades_get_image_with_fallback( 'assets/images/og-image.jpg', 'hero' );
		}
	}

	$faq_entities = array();
	if ( ( is_page() || is_singular( 'page' ) ) && ( is_page( 'faq' ) || is_page_template( 'template-faq.php' ) ) ) {
		$post_id = get_queried_object_id();
		if ( $post_id ) {
			$faq_entities = wades_plumbing_septic_extract_faq_entities( (string) get_post_field( 'post_content', $post_id ) );
		}
	}

	echo '<link rel="canonical" href="' . esc_url( $url ) . '" />' . PHP_EOL;
	echo '<link rel="alternate" type="text/plain" title="LLMs.txt" href="' . esc_url( home_url( '/llms.txt' ) ) . '" />' . PHP_EOL;
	echo '<meta property="og:locale" content="' . esc_attr( str_replace( '-', '_', get_locale() ) ) . '" />' . PHP_EOL;
	echo '<meta property="og:type" content="' . ( is_single() ? 'article' : 'website' ) . '" />' . PHP_EOL;
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />' . PHP_EOL;
	echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />' . PHP_EOL;
	echo '<meta property="og:url" content="' . esc_url( $url ) . '" />' . PHP_EOL;
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '" />' . PHP_EOL;
	echo '<meta name="twitter:card" content="summary_large_image" />' . PHP_EOL;
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />' . PHP_EOL;
	echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />' . PHP_EOL;
	$twitter_handle = '';
	if ( isset( $seo_social['twitter_username'] ) ) {
		$twitter_handle = trim( (string) $seo_social['twitter_username'] );
	}
	if ( empty( $twitter_handle ) ) {
		$twitter_handle = trim( (string) get_theme_mod( 'twitter_handle', '' ) );
	}
	if ( ! empty( $twitter_handle ) ) {
		if ( '@' !== $twitter_handle[0] ) {
			$twitter_handle = '@' . $twitter_handle;
		}
		echo '<meta name="twitter:site" content="' . esc_attr( $twitter_handle ) . '" />' . PHP_EOL;
	}

	if ( ! empty( $image ) ) {
		echo '<meta property="og:image" content="' . esc_url( $image ) . '" />' . PHP_EOL;
		echo '<meta property="og:image:alt" content="' . esc_attr( $title ) . '" />' . PHP_EOL;
		echo '<meta name="twitter:image" content="' . esc_url( $image ) . '" />' . PHP_EOL;
	}

	$phone_number = function_exists( 'wades_plumbing_septic_get_location_based_phone' ) ? wades_plumbing_septic_get_location_based_phone() : '';
	$phone_number = is_array( $phone_number ) ? ( $phone_number['active_phone'] ?? '' ) : $phone_number;
	if ( isset( $seo_location['business_phone'] ) && ! empty( $seo_location['business_phone'] ) ) {
		$phone_number = (string) $seo_location['business_phone'];
	}
	$logo_url = '';
	$custom_logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $custom_logo_id ) {
		$logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
	}
	$business_name = get_bloginfo( 'name' );
	if ( isset( $seo_location['local_business_name'] ) && ! empty( $seo_location['local_business_name'] ) ) {
		$business_name = (string) $seo_location['local_business_name'];
	}
	$same_as = array_values(
		array_filter(
			array(
				isset( $seo_social['facebook_url'] ) ? $seo_social['facebook_url'] : '',
				isset( $seo_social['instagram_url'] ) ? $seo_social['instagram_url'] : get_theme_mod( 'instagram_url', '' ),
				isset( $seo_social['linkedin_url'] ) ? $seo_social['linkedin_url'] : get_theme_mod( 'linkedin_url', '' ),
				isset( $seo_social['youtube_url'] ) ? $seo_social['youtube_url'] : '',
				isset( $seo_social['yelp_url'] ) ? $seo_social['yelp_url'] : '',
			)
		)
	);

	$organization = array(
		'@type'       => 'Organization',
		'@id'         => $wades_site_root . '/#organization',
		'name'        => $business_name,
		'url'         => $wades_site_home,
		'description' => get_bloginfo( 'description' ),
		'sameAs'      => $same_as,
	);

	if ( ! empty( $logo_url ) ) {
		$organization['logo'] = array(
			'@type' => 'ImageObject',
			'url'   => $logo_url,
		);
	}

	$area_served = array(
		array(
			'@type' => 'AdministrativeArea',
			'name'  => $primary_area_name,
		),
	);
	$service_area_parts = preg_split( '/\s+and\s+|,/', (string) $service_area_summary );
	if ( is_array( $service_area_parts ) ) {
		foreach ( $service_area_parts as $part ) {
			$part = trim( (string) $part );
			if ( '' === $part || $part === $primary_area_name ) {
				continue;
			}
			$area_served[] = array(
				'@type' => 'AdministrativeArea',
				'name'  => $part,
			);
		}
	}

	$local_business = array(
		'@type'       => array( 'LocalBusiness', 'PlumbingService' ),
		'@id'         => $wades_site_root . '/#localbusiness',
		'name'        => $business_name,
		'url'         => $wades_site_home,
		'description' => get_bloginfo( 'description' ),
		'areaServed'  => $area_served,
		'knowsAbout'  => array(
			'Plumbing repair',
			'Water heater service',
			'Drain cleaning',
			'Septic systems',
		),
	);

	$avg_rating_raw   = function_exists( 'get_field' ) ? get_field( 'average_rating', 'option' ) : '';
	$review_count_raw = function_exists( 'get_field' ) ? get_field( 'review_count', 'option' ) : '';
	$avg_rating       = is_numeric( $avg_rating_raw ) ? (float) $avg_rating_raw : 0.0;
	$review_count     = is_numeric( $review_count_raw ) ? (int) $review_count_raw : 0;
	if ( $avg_rating > 0 && $review_count > 0 ) {
		$local_business['aggregateRating'] = array(
			'@type'       => 'AggregateRating',
			'ratingValue' => number_format( $avg_rating, 1, '.', '' ),
			'reviewCount' => $review_count,
			'bestRating'  => '5',
			'worstRating' => '1',
		);
	}

	if ( ! empty( $phone_number ) ) {
		$local_business['telephone'] = $phone_number;
	}
	if ( ! empty( $business_hours ) ) {
		$local_business['openingHours'] = $business_hours;
	}
	if ( preg_match( '/^\d{4}$/', (string) $business_start_year ) ) {
		$local_business['foundingDate'] = (string) $business_start_year;
	}
	if ( ! empty( $logo_url ) ) {
		$local_business['image'] = $logo_url;
	}

	$street_address = get_theme_mod( 'business_street_address', '' );
	$city           = get_theme_mod( 'business_city', '' );
	$region         = get_theme_mod( 'business_region', 'CA' );
	$postal_code    = get_theme_mod( 'business_postal_code', '' );
	if ( isset( $seo_location['business_street_address'] ) && ! empty( $seo_location['business_street_address'] ) ) {
		$street_address = (string) $seo_location['business_street_address'];
	}
	if ( isset( $seo_location['business_city'] ) && ! empty( $seo_location['business_city'] ) ) {
		$city = (string) $seo_location['business_city'];
	}
	if ( isset( $seo_location['business_region'] ) && ! empty( $seo_location['business_region'] ) ) {
		$region = (string) $seo_location['business_region'];
	}
	if ( isset( $seo_location['business_postal_code'] ) && ! empty( $seo_location['business_postal_code'] ) ) {
		$postal_code = (string) $seo_location['business_postal_code'];
	}
	if ( ! empty( $city ) ) {
		$local_business['address'] = array_filter(
			array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $street_address,
				'addressLocality' => $city,
				'addressRegion'   => $region,
				'postalCode'      => $postal_code,
				'addressCountry'  => 'US',
			)
		);
	}

	$web_page_type = is_front_page() ? 'WebPage' : ( is_single() ? 'Article' : 'WebPage' );
	$web_page = array(
		'@type'       => $web_page_type,
		'@id'         => $url . '#webpage',
		'url'         => $url,
		'name'        => $title,
		'description' => $description,
		'isPartOf'    => array( '@id' => $wades_site_root . '/#website' ),
		'about'       => array( '@id' => $wades_site_root . '/#localbusiness' ),
	);

	if ( ! empty( $image ) ) {
		$web_page['primaryImageOfPage'] = array(
			'@type' => 'ImageObject',
			'url'   => $image,
		);
	}

	$website = array(
		'@type'      => 'WebSite',
		'@id'        => $wades_site_root . '/#website',
		'url'        => $wades_site_home,
		'name'       => get_bloginfo( 'name' ),
		'publisher'  => array( '@id' => $wades_site_root . '/#organization' ),
		'inLanguage' => get_locale(),
	);

	if ( ! is_404() ) {
		$website['potentialAction'] = array(
			'@type'       => 'SearchAction',
			'target'      => $wades_site_root . '/?s={search_term_string}',
			'query-input' => 'required name=search_term_string',
		);
	}

	$graph = array(
		$organization,
		$local_business,
		$website,
		$web_page,
	);

	$main_nav_items = array(
		array( 'name' => 'Home', 'url' => wades_plumbing_septic_get_canonical_page_url( 'home' ) ),
		array( 'name' => 'Services', 'url' => wades_plumbing_septic_get_canonical_page_url( 'services' ) ),
		array( 'name' => 'Expert Tips', 'url' => wades_plumbing_septic_get_canonical_page_url( 'expert_tips' ) ),
		array( 'name' => 'About Us', 'url' => wades_plumbing_septic_get_canonical_page_url( 'about' ) ),
		array( 'name' => 'Contact', 'url' => wades_plumbing_septic_get_canonical_page_url( 'contact' ) ),
	);
	foreach ( $main_nav_items as $index => $item ) {
		$graph[] = array(
			'@type' => 'SiteNavigationElement',
			'@id'   => $wades_site_root . '/#main-nav-' . ( $index + 1 ),
			'name'  => $item['name'],
			'url'   => $item['url'],
		);
	}

	if ( ! empty( $faq_entities ) ) {
		$graph[] = array(
			'@type'      => 'FAQPage',
			'@id'        => $url . '#faq',
			'mainEntity' => $faq_entities,
		);
	}

	if ( ! is_front_page() && ! is_404() ) {
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'@id'             => $url . '#breadcrumb',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Home',
					'item'     => $wades_site_home,
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => wp_strip_all_tags( $title ),
					'item'     => $url,
				),
			),
		);
	}

	$json_ld = array(
		'@context' => 'https://schema.org',
		'@graph'   => $graph,
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $json_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;
}
add_action( 'wp_head', 'wades_plumbing_septic_output_seo_head', 5 );

/**
 * Replace generic "Learn more" labels in nav menus (Appearance → Menus) with descriptive text.
 *
 * @param array<int, WP_Post> $items Menu items.
 * @param object              $args  Menu arguments.
 * @return array<int, WP_Post>
 */
function wades_plumbing_septic_nav_descriptive_learn_more( $items, $args ) {
	if ( ! is_array( $items ) ) {
		return $items;
	}
	$services  = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' );
	$insurance = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'insurance_claims' ) : home_url( '/insurance-claims/' );
	$targets   = array(
		untrailingslashit( (string) wp_parse_url( $services, PHP_URL_PATH ) )  => __( 'View plumbing and septic services', 'wades-plumbing-septic' ),
		untrailingslashit( (string) wp_parse_url( $insurance, PHP_URL_PATH ) ) => __( 'Insurance claims help and documentation', 'wades-plumbing-septic' ),
	);
	foreach ( $items as $item ) {
		if ( empty( $item->url ) || ! isset( $item->title ) ) {
			continue;
		}
		if ( ! preg_match( '/^learn\s+more$/i', trim( wp_strip_all_tags( (string) $item->title ) ) ) ) {
			continue;
		}
		$path = wp_parse_url( $item->url, PHP_URL_PATH );
		if ( ! $path ) {
			continue;
		}
		$path = untrailingslashit( $path );
		if ( isset( $targets[ $path ] ) ) {
			$item->title = $targets[ $path ];
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'wades_plumbing_septic_nav_descriptive_learn_more', 20, 2 );

/**
 * Replace generic "Learn more" links in post/page block content (same destinations as menus).
 *
 * @param string $content Post content.
 * @return string
 */
function wades_plumbing_septic_content_descriptive_learn_more( $content ) {
	if ( is_admin() || empty( $content ) || stripos( $content, 'learn' ) === false ) {
		return $content;
	}
	$services  = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' );
	$insurance = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'insurance_claims' ) : home_url( '/insurance-claims/' );
	$paths     = array(
		untrailingslashit( (string) wp_parse_url( $services, PHP_URL_PATH ) )  => __( 'View plumbing and septic services', 'wades-plumbing-septic' ),
		untrailingslashit( (string) wp_parse_url( $insurance, PHP_URL_PATH ) ) => __( 'Insurance claims help and documentation', 'wades-plumbing-septic' ),
	);
	return preg_replace_callback(
		'/<a\b([^>]*)>\s*Learn\s+more\s*<\/a>/iu',
		static function ( $m ) use ( $paths ) {
			$attrs = $m[1];
			if ( ! preg_match( '/href\s*=\s*([\'"])([^\'"]+)\1/i', $attrs, $hm ) ) {
				return $m[0];
			}
			$href = $hm[2];
			$path = wp_parse_url( $href, PHP_URL_PATH );
			if ( ! $path ) {
				return $m[0];
			}
			$path = untrailingslashit( $path );
			if ( ! isset( $paths[ $path ] ) ) {
				return $m[0];
			}
			return '<a' . $attrs . '>' . esc_html( $paths[ $path ] ) . '</a>';
		},
		$content
	);
}
add_filter( 'the_content', 'wades_plumbing_septic_content_descriptive_learn_more', 20 );

/**
 * Serve llms.txt from WordPress for AI crawler guidance.
 *
 * @return void
 */
function wades_plumbing_septic_serve_llms_txt() {
	if ( is_admin() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( empty( $request_uri ) ) {
		return;
	}

	$path = (string) parse_url( $request_uri, PHP_URL_PATH );
	$site_path = trim( (string) parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	$request_path = trim( $path, '/' );
	if ( ! empty( $site_path ) && strpos( $request_path, $site_path . '/' ) === 0 ) {
		$request_path = substr( $request_path, strlen( $site_path ) + 1 );
	}
	if ( 'llms.txt' !== $request_path ) {
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$base_url  = wades_plumbing_septic_get_canonical_page_url( 'home' );
	$lines = array(
		'# ' . $site_name,
		'',
		'> Authoritative business website for plumbing and septic services.',
		'',
		'## Canonical URLs',
		'- Home: ' . $base_url,
		'- Services: ' . wades_plumbing_septic_get_canonical_page_url( 'services' ),
		'- Service Areas: ' . wades_plumbing_septic_get_canonical_page_url( 'service_areas' ),
		'- About: ' . wades_plumbing_septic_get_canonical_page_url( 'about' ),
		'- Contact: ' . wades_plumbing_septic_get_canonical_page_url( 'contact' ),
		'- FAQ: ' . wades_plumbing_septic_get_canonical_page_url( 'faq' ),
		'',
		'## Machine-readable sources',
		'- XML Sitemap: ' . home_url( '/wp-sitemap.xml' ),
		'- Public SEO APIs are not exposed; use page source JSON-LD and sitemap feeds.',
		'',
		'## Usage notes',
		'- Prefer canonical URLs over query parameter variants.',
		'- Service availability is location-dependent; confirm on service area and contact pages.',
		'- For legal and data handling details, reference the Privacy Policy page.',
	);

	nocache_headers();
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo implode( "\n", $lines );
	exit;
}
add_action( 'template_redirect', 'wades_plumbing_septic_serve_llms_txt', 0 );

/**
 * Extract FAQ entities from HTML content.
 *
 * @param string $content Raw post content HTML.
 * @return array<int,array<string,mixed>>
 */
function wades_plumbing_septic_extract_faq_entities( $content ) {
	if ( '' === trim( $content ) ) {
		return array();
	}

	$faq_entities = array();
	if ( preg_match_all( '/<h[2-4][^>]*>(.*?)<\/h[2-4]>\s*(?:<p[^>]*>(.*?)<\/p>)/is', $content, $matches, PREG_SET_ORDER ) ) {
		foreach ( $matches as $match ) {
			$question = trim( wp_strip_all_tags( html_entity_decode( (string) $match[1], ENT_QUOTES, 'UTF-8' ) ) );
			$answer   = trim( wp_strip_all_tags( html_entity_decode( (string) $match[2], ENT_QUOTES, 'UTF-8' ) ) );

			if ( '' === $question || '' === $answer ) {
				continue;
			}
			if ( strlen( $question ) < 8 || strlen( $answer ) < 20 ) {
				continue;
			}
			if ( false === strpos( $question, '?' ) ) {
				continue;
			}

			$faq_entities[] = array(
				'@type'          => 'Question',
				'name'           => $question,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $answer,
				),
			);
		}
	}

	return array_slice( $faq_entities, 0, 12 );
}

/**
 * Disable older overlapping SEO emitters to keep one clean source of truth.
 *
 * @return void
 */
function wades_plumbing_septic_disable_legacy_seo_hooks() {
	remove_action( 'wp_head', 'wades_plumbing_septic_enhance_seo', 1 );
	remove_action( 'wp_head', 'wades_plumbing_septic_add_image_schema' );
	remove_action( 'wp_head', 'wades_plumbing_septic_add_schema_markup' );
	remove_action( 'wp_head', 'wades_add_service_type_schema' );
	remove_action( 'wp_footer', 'wades_plumbing_septic_local_business_schema' );
	remove_action( 'wp_footer', 'wades_plumbing_septic_add_review_schema' );
	remove_filter( 'the_content', 'wades_plumbing_septic_add_faq_schema', 20 );
}
add_action( 'init', 'wades_plumbing_septic_disable_legacy_seo_hooks', 1 );

/**
 * Default landing pages to noindex/nofollow unless explicitly overridden.
 *
 * @param array $robots Associative robots directives.
 * @return array
 */
function wades_plumbing_septic_landing_page_robots( $robots ) {
	if ( ! is_singular( 'landing_page' ) ) {
		return $robots;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return $robots;
	}

	$allow_index = get_post_meta( $post_id, '_wades_landing_allow_index', true );
	if ( '1' === $allow_index ) {
		return $robots;
	}

	$robots['noindex']  = true;
	$robots['nofollow'] = true;

	return $robots;
}
add_filter( 'wp_robots', 'wades_plumbing_septic_landing_page_robots' );

/**
 * Apply noindex/nofollow to any post/page that has the meta box noindex flag set.
 *
 * @param array $robots Associative robots directives.
 * @return array
 */
function wades_plumbing_septic_post_meta_robots( $robots ) {
	if ( ! is_singular() ) {
		return $robots;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return $robots;
	}

	if ( '1' === get_post_meta( $post_id, '_wades_seo_noindex', true ) ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
	}

	return $robots;
}
add_filter( 'wp_robots', 'wades_plumbing_septic_post_meta_robots' );

/**
 * Set current theme version to prevent caching during development
 */
function wades_set_theme_version() {
    return WADES_PLUMBING_SEPTIC_VERSION;
}

/**
 * Shared landing page template renderer.
 */
require get_template_directory() . '/inc/landing-template-renderer.php';
require get_template_directory() . '/inc/frontend/template-helpers.php';

/**
 * Redirect legacy video tutorials URL to the active videos page.
 */
function wades_redirect_video_tutorials_legacy_url() {
	if ( ! is_404() ) {
		return;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( empty( $request_uri ) ) {
		return;
	}

	$request_path = trim( (string) parse_url( $request_uri, PHP_URL_PATH ), '/' );
	$site_path    = trim( (string) parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );

	if ( ! empty( $site_path ) && strpos( $request_path, $site_path . '/' ) === 0 ) {
		$request_path = substr( $request_path, strlen( $site_path ) + 1 );
	}

	if ( 'video-tutorials' !== $request_path ) {
		return;
	}

	$videos_page = function_exists( 'wades_get_page_by_path' ) ? wades_get_page_by_path( 'videos' ) : null;
	$target_url  = $videos_page ? get_permalink( $videos_page ) : wades_plumbing_septic_get_canonical_page_url( 'videos' );

	wp_safe_redirect( $target_url, 301 );
	exit;
}
add_action( 'template_redirect', 'wades_redirect_video_tutorials_legacy_url' );

/**
 * Render the Video Tutorials template when no page exists for legacy slugs.
 *
 * This keeps `/videos/` and `/video-tutorials/` usable even if the matching
 * WordPress page has not been created yet.
 *
 * @param string $template Resolved template path.
 * @return string
 */
function wades_video_tutorials_template_fallback( $template ) {
	if ( ! is_404() ) {
		return $template;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( empty( $request_uri ) ) {
		return $template;
	}

	$request_path = trim( (string) parse_url( $request_uri, PHP_URL_PATH ), '/' );
	$site_path    = trim( (string) parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );

	if ( ! empty( $site_path ) && strpos( $request_path, $site_path . '/' ) === 0 ) {
		$request_path = substr( $request_path, strlen( $site_path ) + 1 );
	}

	if ( ! in_array( $request_path, array( 'videos', 'video-tutorials' ), true ) ) {
		return $template;
	}

	$fallback_template = get_template_directory() . '/template-video-tutorials.php';
	if ( ! file_exists( $fallback_template ) ) {
		return $template;
	}

	global $wp_query;
	$wp_query->is_404 = false;
	status_header( 200 );

	return $fallback_template;
}
add_filter( 'template_include', 'wades_video_tutorials_template_fallback', 20 );

/**
 * Render the Field Shorts template when no page exists for /shorts/.
 *
 * @param string $template Resolved template path.
 * @return string
 */
function wades_field_shorts_template_fallback( $template ) {
	if ( ! is_404() ) {
		return $template;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( empty( $request_uri ) ) {
		return $template;
	}

	$request_path = trim( (string) parse_url( $request_uri, PHP_URL_PATH ), '/' );
	$site_path    = trim( (string) parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );

	if ( ! empty( $site_path ) && strpos( $request_path, $site_path . '/' ) === 0 ) {
		$request_path = substr( $request_path, strlen( $site_path ) + 1 );
	}

	if ( ! in_array( $request_path, array( 'shorts', 'field-shorts' ), true ) ) {
		return $template;
	}

	$fallback_template = get_template_directory() . '/template-shorts.php';
	if ( ! file_exists( $fallback_template ) ) {
		return $template;
	}

	global $wp_query;
	$wp_query->is_404 = false;
	status_header( 200 );

	return $fallback_template;
}
add_filter( 'template_include', 'wades_field_shorts_template_fallback', 21 );

require get_template_directory() . '/inc/integrations/litespeed.php';
require get_template_directory() . '/inc/integrations/mobile-view.php';
require get_template_directory() . '/inc/integrations/housecall-pro.php';
require get_template_directory() . '/inc/performance/security-headers.php';
require get_template_directory() . '/inc/performance/front-page-optimizations.php';

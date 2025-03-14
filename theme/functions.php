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
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'WADES_PLUMBING_SEPTIC_VERSION', '0.1.0' );
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
	wp_enqueue_style( 'wades-plumbing-septic-style', get_stylesheet_uri(), array(), WADES_PLUMBING_SEPTIC_VERSION );
	wp_enqueue_script( 'wades-plumbing-septic-script', get_template_directory_uri() . '/js/script.min.js', array(), WADES_PLUMBING_SEPTIC_VERSION, true );
	
	// Enqueue the parallax effect script
	wp_enqueue_script( 'wades-plumbing-septic-parallax', get_template_directory_uri() . '/js/parallax.min.js', array(), WADES_PLUMBING_SEPTIC_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wades_plumbing_septic_scripts' );

/**
 * Enqueue the block editor script.
 */
function wades_plumbing_septic_enqueue_block_editor_script() {
	if ( is_admin() ) {
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
}
add_action( 'enqueue_block_assets', 'wades_plumbing_septic_enqueue_block_editor_script' );

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
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom navigation walkers.
 */
require get_template_directory() . '/inc/navigation-walkers.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Block patterns for this theme.
 */
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Include the custom Walker class for the footer menu.
 */
require get_template_directory() . '/inc/class-wade-footer-nav-walker.php';

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
	$defer_scripts = array(
		'wades-plumbing-septic-script',
		'wades-plumbing-septic-parallax',
	);
	
	// List of scripts to load asynchronously (load in parallel, execute when ready)
	$async_scripts = array();
	
	// Add defer attribute
	if (in_array($handle, $defer_scripts)) {
		return str_replace(' src', ' defer src', $tag);
	}
	
	// Add async attribute
	if (in_array($handle, $async_scripts)) {
		return str_replace(' src', ' async src', $tag);
	}
	
	return $tag;
}
add_filter('script_loader_tag', 'wades_plumbing_septic_script_loader_tag', 10, 2);

/**
 * Add DNS prefetch for external domains
 */
function wades_plumbing_septic_dns_prefetch() {
	echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . PHP_EOL;
	echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . PHP_EOL;
	echo '<link rel="dns-prefetch" href="//ipapi.co">' . PHP_EOL;
}
add_action('wp_head', 'wades_plumbing_septic_dns_prefetch', 0);

/**
 * Add additional meta tags for SEO
 */
function wades_plumbing_septic_add_meta_tags() {
	// Add OG metadata only on single posts and pages
	if (is_singular()) {
		global $post;
		$excerpt = has_excerpt($post->ID) ? get_the_excerpt() : wp_trim_words(get_the_content(), 20);
		
		// Get the featured image
		$image = get_the_post_thumbnail_url($post->ID, 'large');
		if (!$image) {
			// Use logo as fallback
			$custom_logo_id = get_theme_mod('custom_logo');
			$image = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';
		}
		
		// Output OG tags
		echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . PHP_EOL;
		echo '<meta property="og:type" content="' . (is_single() ? 'article' : 'website') . '" />' . PHP_EOL;
		echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '" />' . PHP_EOL;
		echo '<meta property="og:description" content="' . esc_attr($excerpt) . '" />' . PHP_EOL;
		echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '" />' . PHP_EOL;
		echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '" />' . PHP_EOL;
		
		if ($image) {
			echo '<meta property="og:image" content="' . esc_url($image) . '" />' . PHP_EOL;
		}
		
		// Twitter Card tags
		echo '<meta name="twitter:card" content="summary_large_image" />' . PHP_EOL;
		echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '" />' . PHP_EOL;
		echo '<meta name="twitter:description" content="' . esc_attr($excerpt) . '" />' . PHP_EOL;
		
		if ($image) {
			echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . PHP_EOL;
		}
	}
}
add_action('wp_head', 'wades_plumbing_septic_add_meta_tags');

/**
 * Implement page caching and performance optimizations
 */
function wades_plumbing_septic_setup_caching() {
	// Set appropriate caching headers for static resources
	if (!is_admin() && !is_user_logged_in()) {
		// Only apply caching for non-admin and non-logged-in users
		
		// Get the file extension to determine the content type
		$url = $_SERVER['REQUEST_URI'];
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
	// Add preload for critical resources
	if ('preload' === $relation_type) {
		// Preload the main stylesheet
		$urls[] = array(
			'href' => get_stylesheet_uri(),
			'as' => 'style',
		);
		
		// Preload critical fonts
		if (file_exists(get_template_directory() . '/fonts/open-sans-v34-latin-regular.woff2')) {
			$urls[] = array(
				'href' => get_template_directory_uri() . '/fonts/open-sans-v34-latin-regular.woff2',
				'as' => 'font',
				'type' => 'font/woff2',
				'crossorigin' => 'anonymous',
			);
		}
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
		
		// Write our caching rules
		file_put_contents($htaccess_path, $custom_rules);
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

<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Wades_Plumbing_&_Septic
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wades_plumbing_septic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wades_plumbing_septic_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function wades_plumbing_septic_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'wades_plumbing_septic_comment_form_defaults' );

/**
 * Register custom block styles
 */
function wades_plumbing_septic_register_block_styles() {
	// Register parallax style for cover block
	if ( function_exists( 'register_block_style' ) ) {
		register_block_style(
			'core/cover',
			array(
				'name'         => 'wades-parallax-hero',
				'label'        => __( 'Parallax Hero', 'wades-plumbing-septic' ),
				'is_default'   => false,
				'inline_style' => '
					.is-style-wades-parallax-hero {
						background-attachment: fixed !important;
						background-position: center !important;
						background-repeat: no-repeat !important;
						background-size: cover !important;
						position: relative !important;
						min-height: 80vh !important;
						overflow: hidden !important;
						width: 100% !important;
						max-width: 100% !important;
						margin-left: 0 !important;
						margin-right: 0 !important;
					}
					.is-style-wades-parallax-hero .wp-block-cover__image-background {
						transform: translateZ(0);
						will-change: transform;
						z-index: 0 !important;
					}
					.editor-styles-wrapper .is-style-wades-parallax-hero {
						display: flex !important;
						align-items: center !important;
						justify-content: center !important;
					}
					.editor-styles-wrapper .is-style-wades-parallax-hero .wp-block-cover__inner-container {
						position: relative !important;
						z-index: 2 !important;
					}
					.is-style-wades-parallax-hero .wp-block-cover__inner-container {
						position: relative !important;
						z-index: 2 !important;
						margin: 0 auto !important;
					}
					/* Fix for horizontal scrollbar */
					body {
						overflow-x: hidden !important;
					}
					.wp-block-post-content {
						overflow-x: hidden !important;
					}
					.alignfull {
						width: 100% !important;
						max-width: 100% !important;
						margin-left: 0 !important;
						margin-right: 0 !important;
					}
				',
			)
		);
		
		// Register brand color styles
		$brand_color = '#bc6f30';
		$brand_dark = '#844e22';
		$brand_light = '#c98c59';
		
		// Brand background for paragraphs
		register_block_style(
			'core/paragraph',
			array(
				'name'         => 'brand-background',
				'label'        => __( 'Brand Background', 'wades-plumbing-septic' ),
				'inline_style' => '
					.is-style-brand-background {
						background-color: ' . $brand_color . ';
						padding: 1.5rem;
						color: #000;
					}
				',
			)
		);
		
		// Brand background for group blocks
		register_block_style(
			'core/group',
			array(
				'name'         => 'brand-background',
				'label'        => __( 'Brand Background', 'wades-plumbing-septic' ),
				'inline_style' => '
					.is-style-brand-background {
						background-color: ' . $brand_color . ';
						padding: 1.5rem;
						color: #000;
					}
				',
			)
		);
		
		// Brand style for buttons
		register_block_style(
			'core/button',
			array(
				'name'         => 'brand-button',
				'label'        => __( 'Brand Button', 'wades-plumbing-septic' ),
				'inline_style' => '
					.is-style-brand-button .wp-block-button__link {
						background-color: ' . $brand_color . ';
						color: #000;
						border: 2px solid ' . $brand_color . ';
						transition: all 0.3s ease;
					}
					.is-style-brand-button .wp-block-button__link:hover {
						background-color: transparent;
						color: ' . $brand_color . ';
					}
				',
			)
		);
		
		// Brand border for any block
		register_block_style(
			'core/group',
			array(
				'name'         => 'brand-border',
				'label'        => __( 'Brand Border', 'wades-plumbing-septic' ),
				'inline_style' => '
					.is-style-brand-border {
						border: 2px solid ' . $brand_color . ';
						padding: 1rem;
					}
				',
			)
		);
		
		// Brand style for headings
		register_block_style(
			'core/heading',
			array(
				'name'         => 'brand-heading',
				'label'        => __( 'Brand Heading', 'wades-plumbing-septic' ),
				'inline_style' => '
					.is-style-brand-heading {
						color: ' . $brand_color . ';
						border-bottom: 2px solid ' . $brand_color . ';
						padding-bottom: 0.5rem;
					}
				',
			)
		);
		
		// Add more block styles here as needed
	}
}
add_action( 'init', 'wades_plumbing_septic_register_block_styles' );

/**
 * Filters the default archive titles.
 */
function wades_plumbing_septic_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'wades-plumbing-septic' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'wades-plumbing-septic' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'wades-plumbing-septic' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'wades-plumbing-septic' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'wades-plumbing-septic' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'wades-plumbing-septic' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'wades-plumbing-septic' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'wades-plumbing-septic' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'wades-plumbing-septic' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'wades-plumbing-septic' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'wades-plumbing-septic' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'wades_plumbing_septic_get_the_archive_title' );

/**
 * Determines whether the post thumbnail can be displayed.
 */
function wades_plumbing_septic_can_show_post_thumbnail() {
	return apply_filters( 'wades_plumbing_septic_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function wades_plumbing_septic_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function wades_plumbing_septic_continue_reading_link( $more_string ) {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'wades-plumbing-septic' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'wades_plumbing_septic_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'wades_plumbing_septic_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function wades_plumbing_septic_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'wades-plumbing-septic' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'wades-plumbing-septic' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'wades-plumbing-septic' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'wades-plumbing-septic' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'wades-plumbing-septic' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div <?php wades_plumbing_septic_content_class( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}

/**
 * Add a body class for pages with hidden titles
 *
 * @param array $classes An array of body class names.
 * @return array Modified array of body class names.
 */
function wades_plumbing_septic_body_classes_for_hidden_titles( $classes ) {
	// Add class if the page has the hide title option enabled
	if ( is_page() && get_post_meta( get_the_ID(), '_wades_hide_title', true ) ) {
		$classes[] = 'hide-page-title';
	}
	
	// Always hide title on front page
	if ( is_front_page() ) {
		$classes[] = 'hide-page-title';
	}
	
	return $classes;
}
add_filter( 'body_class', 'wades_plumbing_septic_body_classes_for_hidden_titles' );

/**
 * Add meta box for hiding page title
 */
function wades_plumbing_septic_add_hide_title_meta_box() {
	add_meta_box(
		'wades_hide_title_meta_box',
		__( 'Page Title Options', 'wades-plumbing-septic' ),
		'wades_plumbing_septic_hide_title_meta_box_callback',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'wades_plumbing_septic_add_hide_title_meta_box' );

/**
 * Meta box callback function
 */
function wades_plumbing_septic_hide_title_meta_box_callback( $post ) {
	// Add a nonce field for security
	wp_nonce_field( 'wades_hide_title_meta_box_nonce', 'wades_hide_title_meta_box_nonce' );
	
	// Get the current value
	$hide_title = get_post_meta( $post->ID, '_wades_hide_title', true );
	
	?>
	<p>
		<label for="wades_hide_title">
			<input type="checkbox" name="wades_hide_title" id="wades_hide_title" value="1" <?php checked( $hide_title, '1' ); ?> />
			<?php _e( 'Hide page title visually (SEO friendly)', 'wades-plumbing-septic' ); ?>
		</label>
	</p>
	<p class="description">
		<?php _e( 'The title will still be in the HTML for SEO and accessibility, but visually hidden.', 'wades-plumbing-septic' ); ?>
	</p>
	<?php
}

/**
 * Save meta box data
 */
function wades_plumbing_septic_save_hide_title_meta_box_data( $post_id ) {
	// Check if nonce is set
	if ( ! isset( $_POST['wades_hide_title_meta_box_nonce'] ) ) {
		return;
	}
	
	// Verify nonce
	if ( ! wp_verify_nonce( $_POST['wades_hide_title_meta_box_nonce'], 'wades_hide_title_meta_box_nonce' ) ) {
		return;
	}
	
	// If this is an autosave, don't do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check user permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	// Update the meta field
	if ( isset( $_POST['wades_hide_title'] ) ) {
		update_post_meta( $post_id, '_wades_hide_title', '1' );
	} else {
		delete_post_meta( $post_id, '_wades_hide_title' );
	}
}
add_action( 'save_post', 'wades_plumbing_septic_save_hide_title_meta_box_data' );

/**
 * Filter page title visibility based on meta field and front page
 */
function wades_plumbing_septic_filter_page_title_visibility( $show_title, $post_id ) {
	// Always hide title on front page
	if ( is_front_page() && $post_id === get_option( 'page_on_front' ) ) {
		return false;
	}
	
	// Hide title based on meta value
	if ( get_post_meta( $post_id, '_wades_hide_title', true ) ) {
		return false;
	}
	
	return $show_title;
}
add_filter( 'wades_plumbing_septic_show_page_title', 'wades_plumbing_septic_filter_page_title_visibility', 10, 2 );

/**
 * Get the appropriate phone number based on user's location
 * 
 * @return array Phone numbers with information about which one to use
 */
function wades_plumbing_septic_get_location_based_phone() {
    $primary_phone = get_theme_mod('business_phone', '831.225.4344');
    $missouri_phone = get_theme_mod('missouri_phone', '');
    $enable_location = get_theme_mod('enable_location_detection', true);
    
    // Default setup
    $result = array(
        'primary_phone' => $primary_phone,
        'missouri_phone' => $missouri_phone,
        'active_phone' => $primary_phone,
        'is_missouri' => false,
        'show_selector' => false
    );
    
    // If location detection is disabled or Missouri phone not set, just return primary
    if (!$enable_location || empty($missouri_phone)) {
        return $result;
    }
    
    // Check if we've already detected and stored the state
    $detected_state = isset($_COOKIE['wades_detected_state']) ? sanitize_text_field($_COOKIE['wades_detected_state']) : '';
    $user_selected_state = isset($_COOKIE['wades_selected_state']) ? sanitize_text_field($_COOKIE['wades_selected_state']) : '';
    
    // User selection takes precedence
    if (!empty($user_selected_state)) {
        $is_missouri = ($user_selected_state === 'MO');
        $result['is_missouri'] = $is_missouri;
        $result['active_phone'] = $is_missouri ? $missouri_phone : $primary_phone;
        return $result;
    }
    
    // If we already detected the state, use that
    if (!empty($detected_state)) {
        $is_missouri = ($detected_state === 'MO');
        $result['is_missouri'] = $is_missouri;
        $result['active_phone'] = $is_missouri ? $missouri_phone : $primary_phone;
        $result['show_selector'] = true; // Always show selector when we've detected a state
        return $result;
    }
    
    // No detection yet, we'll need JavaScript to handle it
    $result['show_selector'] = true;
    return $result;
}

/**
 * Add Schema.org structured data to improve SEO
 */
function wades_plumbing_septic_add_schema_markup() {
	// Only add schema to the front page
	if (!is_front_page()) {
		return;
	}

	// Get customizer settings
	$phone = get_theme_mod('phone_number', '831.225.4344');
	$phone_clean = preg_replace('/[^0-9+]/', '', $phone);
	$business_hours = get_theme_mod('business_hours', 'Mon - Fri 9:00am - 5:00pm');
	$service_areas = get_theme_mod('service_areas', 'Santa Cruz County, Monterey County, Santa Clara County');
	
	// Build the schema
	$schema = array(
		'@context' => 'https://schema.org',
		'@type' => 'PlumbingService',
		'name' => get_bloginfo('name'),
		'url' => home_url('/'),
		'logo' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
		'image' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
		'telephone' => $phone_clean,
		'priceRange' => '$$',
		'description' => get_bloginfo('description'),
		'openingHoursSpecification' => array(
			'@type' => 'OpeningHoursSpecification',
			'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'),
			'opens' => '09:00',
			'closes' => '17:00'
		),
		'areaServed' => explode(',', $service_areas),
		'hasOfferCatalog' => array(
			'@type' => 'OfferCatalog',
			'name' => 'Plumbing Services',
			'itemListElement' => array(
				array(
					'@type' => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name' => 'Plumbing Repairs'
					)
				),
				array(
					'@type' => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name' => 'Septic Services'
					)
				),
				array(
					'@type' => 'Offer',
					'itemOffered' => array(
						'@type' => 'Service',
						'name' => 'Emergency Plumbing'
					)
				)
			)
		)
	);

	// Output the schema in the head
	echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}
add_action('wp_head', 'wades_plumbing_septic_add_schema_markup');

/**
 * Improve image alt text for accessibility and SEO
 * 
 * @param array $attributes Existing image attributes.
 * @param WP_Post $attachment The attachment post object.
 * @param string|array $size Requested image size.
 * @return array Modified image attributes.
 */
function wades_plumbing_septic_filter_image_attributes($attributes, $attachment, $size) {
	// If alt is empty, use the title or fallback to a descriptive text
	if (empty($attributes['alt'])) {
		$attributes['alt'] = get_the_title($attachment->ID);
		
		// If it's a logo, be descriptive
		if (strpos(strtolower($attributes['alt']), 'logo') !== false) {
			$attributes['alt'] = get_bloginfo('name') . ' Logo';
		}
	}
	
	// Add loading="lazy" for images that aren't in the initial viewport
	// Skip for logos and very small images
	$skip_lazy = false;
	if (strpos(strtolower($attributes['alt']), 'logo') !== false) {
		$skip_lazy = true;
	}
	
	if (!$skip_lazy && !isset($attributes['loading'])) {
		$attributes['loading'] = 'lazy';
	}
	
	// Add decoding="async" for better performance
	if (!isset($attributes['decoding'])) {
		$attributes['decoding'] = 'async';
	}
	
	return $attributes;
}
add_filter('wp_get_attachment_image_attributes', 'wades_plumbing_septic_filter_image_attributes', 10, 3);

/**
 * Add critical CSS to improve page loading speed
 * Follows Next.js unstable-cache pattern by extracting critical styles
 */
function wades_plumbing_septic_add_critical_css() {
	// Only add critical CSS to the front page
	if (!is_front_page()) {
		return;
	}

	// Critical CSS for above-the-fold content
	$critical_css = '
	/* Critical CSS for above-the-fold content */
	:root, :host {
		--background: #ffffff;
		--foreground: #404040;
		--primary: #b91c1c;
		--secondary: #15803d;
		--tertiary: #0369a1;
	}
	body {
		margin: 0;
		color: var(--foreground);
		background-color: var(--background);
		font-family: system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,sans-serif;
		overflow-x: hidden;
	}
	.sr-only {
		position: absolute;
		width: 1px;
		height: 1px;
		padding: 0;
		margin: -1px;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		white-space: nowrap;
		border-width: 0;
	}
	.bg-black {
		background-color: #000;
	}
	.text-white {
		color: #fff;
	}
	.sticky {
		position: sticky;
	}
	.top-0 {
		top: 0;
	}
	.z-50 {
		z-index: 50;
	}
	.hidden {
		display: none;
	}
	.flex {
		display: flex;
	}
	.items-center {
		align-items: center;
	}
	.justify-between {
		justify-content: space-between;
	}
	.p-3 {
		padding: 0.75rem;
	}
	.mx-auto {
		margin-left: auto;
		margin-right: auto;
	}
	.space-x-4 > :not(:first-child) {
		margin-left: 1rem;
	}
	.site-logo img {
		height: var(--logo-height, 48px);
		width: auto;
	}
	.bg-brand {
		background-color: #bc6f30;
	}
	.text-brand {
		color: #bc6f30;
	}
	.text-black {
		color: #000;
	}
	.wp-block-cover {
		position: relative;
		background-size: cover;
		background-position: center;
		min-height: 430px;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 1rem;
		color: #fff;
	}
	.wp-block-cover__background {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 1;
	}
	.wp-block-cover__image-background {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		object-fit: cover;
		width: 100%;
		height: 100%;
		z-index: 0;
	}
	.wp-block-cover__inner-container {
		position: relative;
		z-index: 2;
		width: 100%;
	}
	.overflow-hidden {
		overflow: hidden !important;
	}
	.wp-block-post-content {
		overflow-x: hidden !important;
	}';

	// Print the critical CSS in the head
	echo '<style id="wades-critical-css">' . $critical_css . '</style>';
	
	// Add preload for main stylesheet
	echo '<link rel="preload" href="' . get_stylesheet_uri() . '?ver=' . WADES_PLUMBING_SEPTIC_VERSION . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
	echo '<noscript><link rel="stylesheet" href="' . get_stylesheet_uri() . '?ver=' . WADES_PLUMBING_SEPTIC_VERSION . '"></noscript>';
}
add_action('wp_head', 'wades_plumbing_septic_add_critical_css', 1);

/**
 * Add inline styles to make sure brand colors and other Tailwind utilities are consistent
 */
function wades_plumbing_septic_add_custom_inline_styles() {
    $inline_css = '
    /* Ensure Tailwind utility classes are consistent */
    .bg-brand {
        background-color: #bc6f30 !important;
    }
    .text-brand {
        color: #bc6f30 !important;
    }
    .border-brand {
        border-color: #bc6f30 !important;
    }
    /* Fix for overflow issues */
    body, 
    .wp-block-post-content {
        overflow-x: hidden !important;
    }
    .is-style-wades-parallax-hero {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        overflow: hidden !important;
    }
    .alignfull {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    ';
    
    wp_add_inline_style('wades-plumbing-septic-style', $inline_css);
    wp_add_inline_style('wades-plumbing-septic-style-deferred', $inline_css);
}
add_action('wp_enqueue_scripts', 'wades_plumbing_septic_add_custom_inline_styles', 30);

/**
 * Dequeue non-critical CSS and defer loading
 */
function wades_plumbing_septic_defer_non_critical_css() {
	if (is_front_page()) {
		// Remove default style loading
		wp_dequeue_style('wades-plumbing-septic-style');
		
		// Re-add it with a different method (the preload is added in the critical CSS function)
		wp_enqueue_style('wades-plumbing-septic-style-deferred', get_stylesheet_uri(), array(), WADES_PLUMBING_SEPTIC_VERSION);
		wp_style_add_data('wades-plumbing-septic-style-deferred', 'data-loading', 'defer');
	}
}
add_action('wp_enqueue_scripts', 'wades_plumbing_septic_defer_non_critical_css', 20);

/**
 * Clean content output by removing empty paragraphs and divs
 * 
 * @param string $content The content to clean.
 * @return string The cleaned content.
 */
function wades_plumbing_septic_clean_content($content) {
    // Remove empty paragraphs
    $content = str_replace('<p></p>', '', $content);
    $content = str_replace('<p>&nbsp;</p>', '', $content);
    
    // Add alt text to images that are missing it
    if (preg_match_all('/<img[^>]+>/', $content, $matches)) {
        foreach ($matches[0] as $img) {
            if (strpos($img, 'alt=""') !== false || !preg_match('/alt=/', $img)) {
                // Get image src to generate a more descriptive alt
                preg_match('/src=["\']([^"\']+)["\']/', $img, $src);
                if (!empty($src[1])) {
                    $filename = basename($src[1]);
                    $filename = preg_replace('/\.(jpg|jpeg|png|gif|webp)$/i', '', $filename);
                    $filename = str_replace(['-', '_'], ' ', $filename);
                    $filename = ucwords($filename);
                    
                    // Get default alt text from theme settings or use the filename
                    $default_alt = get_theme_mod('default_image_alt', '');
                    $alt_text = !empty($default_alt) ? $default_alt : $filename;
                    
                    // Replace the empty alt with the new one
                    $new_img = preg_replace('/alt=["\']["\']/', 'alt="' . esc_attr($alt_text) . '"', $img);
                    if ($new_img === $img) { // if no alt attribute exists
                        $new_img = str_replace('<img ', '<img alt="' . esc_attr($alt_text) . '" ', $img);
                    }
                    
                    $content = str_replace($img, $new_img, $content);
                }
            }
        }
    }
    
    return $content;
}
add_filter('the_content', 'wades_plumbing_septic_clean_content', 20);

/**
 * Add body classes for front page and other special cases
 * 
 * @param array $classes Body classes.
 * @return array Modified body classes.
 */
function wades_plumbing_septic_body_classes($classes) {
    // Add class to front page to hide title
    if (is_front_page()) {
        $classes[] = 'hide-page-title';
    }
    
    return $classes;
}
add_filter('body_class', 'wades_plumbing_septic_body_classes');

/**
 * Add editor scripts and styles for better HTML structure
 */
function wades_plumbing_septic_block_editor_settings() {
    // Only load on admin side
    if (!is_admin()) {
        return;
    }

    // Create the CSS directory if it doesn't exist
    $css_dir = get_template_directory() . '/css';
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }

    // Check if our editor CSS files exist, create them if not
    $editor_css_file = $css_dir . '/editor-html-structure.css';
    if (!file_exists($editor_css_file)) {
        wades_plumbing_septic_create_editor_html_structure_css();
    }
    
    $editor_patterns_css_file = $css_dir . '/editor-patterns.css';
    if (!file_exists($editor_patterns_css_file)) {
        wades_plumbing_septic_create_editor_patterns_css();
    }

    // Create the JS directory if it doesn't exist
    $js_dir = get_template_directory() . '/js';
    if (!file_exists($js_dir)) {
        wp_mkdir_p($js_dir);
    }

    // Check if we need to create or update the simplified JS file
    $editor_js_file = $js_dir . '/editor-html-structure-simple.js';
    if (!file_exists($editor_js_file) || filemtime($js_dir . '/editor-html-structure.js') > filemtime($editor_js_file)) {
        wades_plumbing_septic_create_simplified_editor_js();
    }
    
    // Check if we need to create the patterns fix JS file
    $editor_patterns_js_file = $js_dir . '/editor-patterns-fix.js';
    if (!file_exists($editor_patterns_js_file)) {
        wades_plumbing_septic_create_editor_patterns_fix_js();
    }

    // Enqueue the editor styles
    wp_enqueue_style(
        'wades-plumbing-septic-editor-html-structure',
        get_template_directory_uri() . '/css/editor-html-structure.css',
        array(),
        filemtime(get_template_directory() . '/css/editor-html-structure.css')
    );
    
    // Enqueue our new editor patterns CSS
    wp_enqueue_style(
        'wades-plumbing-septic-editor-patterns',
        get_template_directory_uri() . '/css/editor-patterns.css',
        array(),
        filemtime(get_template_directory() . '/css/editor-patterns.css')
    );

    // Enqueue the SIMPLIFIED editor script to avoid linter errors
    wp_enqueue_script(
        'wades-plumbing-septic-editor-html-structure',
        get_template_directory_uri() . '/js/editor-html-structure-simple.js',
        array('wp-blocks', 'wp-dom-ready', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post'),
        filemtime(get_template_directory() . '/js/editor-html-structure-simple.js'),
        true
    );
    
    // Enqueue the patterns fix script
    wp_enqueue_script(
        'wades-plumbing-septic-editor-patterns-fix',
        get_template_directory_uri() . '/js/editor-patterns-fix.js',
        array('jquery', 'wp-blocks', 'wp-dom-ready'),
        filemtime(get_template_directory() . '/js/editor-patterns-fix.js'),
        true
    );

    // Localize the script with data
    global $post;
    $script_data = array(
        'is_front_page' => isset($post) && $post->ID === get_option('page_on_front'),
        'page_title' => isset($post) ? get_the_title($post) : '',
        'site_name' => get_bloginfo('name'),
        'site_description' => get_bloginfo('description'),
    );
    wp_localize_script('wades-plumbing-septic-editor-html-structure', 'wades_plumbing_septic_editor', $script_data);
}
add_action('enqueue_block_editor_assets', 'wades_plumbing_septic_block_editor_settings');

/**
 * Create a simplified version of the HTML structure JS without linter errors
 */
function wades_plumbing_septic_create_simplified_editor_js() {
    // Get the JS directory
    $js_dir = get_template_directory() . '/js';
    
    // Create it if it doesn't exist
    if (!file_exists($js_dir)) {
        wp_mkdir_p($js_dir);
    }
    
    // Create a simplified version of the HTML structure JS that won't have linter errors
    $js_content = <<<JS
/**
 * Simplified HTML Structure Checker for WordPress Block Editor
 */
jQuery(document).ready(function($) {
    // Wait for WordPress to be fully loaded
    setTimeout(function() {
        if (typeof wp === 'undefined' || !wp.plugins || !wp.editPost || !wp.data) {
            return;
        }
        
        // Function to check HTML content for issues
        function checkContent() {
            try {
                // Get the current post content
                var content = wp.data.select('core/editor').getEditedPostContent();
                var issues = [];
                
                // Check for empty paragraphs
                if (content.includes('<p></p>') || content.includes('<p>&nbsp;</p>')) {
                    issues.push({
                        type: 'warning',
                        message: 'Empty paragraphs detected. Consider removing them for better HTML structure.'
                    });
                }
                
                // Check for duplicate H1 tags
                var h1Count = (content.match(/<h1/g) || []).length;
                if (h1Count > 1) {
                    issues.push({
                        type: 'error',
                        message: 'Multiple H1 headings detected. A page should have only one H1 for proper SEO.'
                    });
                }
                
                // Check for images without alt text
                if (content.includes('alt=""') || content.match(/<img(?![^>]*alt=)[^>]*>/g)) {
                    issues.push({
                        type: 'error',
                        message: 'Images without alt text detected. Add descriptive alt text for accessibility and SEO.'
                    });
                }
                
                return issues;
            } catch (e) {
                console.error('Error checking HTML structure:', e);
                return [];
            }
        }
        
        // Register block styles
        if (wp.blocks && typeof wp.blocks.registerBlockStyle === 'function') {
            // Add custom style for paragraph blocks
            wp.blocks.registerBlockStyle('core/paragraph', {
                name: 'semantic-paragraph',
                label: 'Semantic Paragraph'
            });
            
            // Add custom style for heading blocks
            wp.blocks.registerBlockStyle('core/heading', {
                name: 'semantic-heading',
                label: 'Semantic Heading'
            });
            
            // Add custom style for image blocks
            wp.blocks.registerBlockStyle('core/image', {
                name: 'semantic-image',
                label: 'Accessible Image'
            });
        }
        
        // Function to display HTML structure warnings in the publish panel
        var hasAddedIssuesPanel = false;
        var checkAndDisplayIssues = function() {
            var issues = checkContent();
            
            // If we have issues and the pre-publish panel is open
            if (issues.length > 0) {
                var $prePublishPanel = $('.editor-post-publish-panel__prepublish');
                
                if ($prePublishPanel.length && !hasAddedIssuesPanel) {
                    // Create our own panel
                    var $htmlIssuesPanel = $('<div class="wades-html-structure-checker components-panel__body"><h2 class="components-panel__body-title">HTML Structure Issues</h2><div class="wades-html-checker-content"></div></div>');
                    var $content = $htmlIssuesPanel.find('.wades-html-checker-content');
                    
                    // Add each issue
                    $.each(issues, function(i, issue) {
                        var $notice = $('<div class="components-notice is-' + issue.type + '"><div class="components-notice__content">' + issue.message + '</div></div>');
                        $content.append($notice);
                    });
                    
                    // Add message about importance
                    $content.append('<p>Having clean HTML structure is important for SEO and accessibility.</p>');
                    
                    // Add to pre-publish panel
                    $prePublishPanel.append($htmlIssuesPanel);
                    hasAddedIssuesPanel = true;
                }
            }
        };
        
        // Check for changes in the editor content
        var contentObserver = setInterval(function() {
            if ($('.editor-post-publish-panel').is(':visible')) {
                checkAndDisplayIssues();
            } else {
                hasAddedIssuesPanel = false;
            }
        }, 1000);
        
        // Clean up when page is unloaded
        $(window).on('unload', function() {
            clearInterval(contentObserver);
        });
    }, 1000);
});
JS;
    
    // Write to file
    $file = fopen(get_template_directory() . '/js/editor-html-structure-simple.js', 'w');
    fwrite($file, $js_content);
    fclose($file);
}

/**
 * Create the editor HTML structure CSS file
 */
function wades_plumbing_septic_create_editor_html_structure_css() {
    // Get the CSS directory
    $css_dir = get_template_directory() . '/css';
    
    // Create it if it doesn't exist
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    // CSS content
    $css_content = <<<CSS
/**
 * CSS for highlighting HTML structure issues in the Gutenberg editor
 */

/* Highlight empty paragraphs */
.block-editor-block-list__block[data-type="core/paragraph"] .editor-styles-wrapper:empty,
.block-editor-block-list__block[data-type="core/paragraph"] .wp-block-paragraph:empty,
.block-editor-block-list__block[data-type="core/paragraph"] .wp-block-paragraph:only-child:not(:first-child):empty {
    position: relative;
    border: 1px dashed #e74c3c;
    padding: 10px;
    background-color: rgba(231, 76, 60, 0.1);
}

.block-editor-block-list__block[data-type="core/paragraph"] .editor-styles-wrapper:empty::before,
.block-editor-block-list__block[data-type="core/paragraph"] .wp-block-paragraph:empty::before,
.block-editor-block-list__block[data-type="core/paragraph"] .wp-block-paragraph:only-child:not(:first-child):empty::before {
    content: "Empty paragraph detected";
    color: #e74c3c;
    font-style: italic;
    font-size: 12px;
    position: absolute;
    top: -20px;
    left: 0;
}

/* Highlight images without alt text */
.block-editor-block-list__block[data-type="core/image"] img:not([alt]),
.block-editor-block-list__block[data-type="core/image"] img[alt=""] {
    border: 1px dashed #e74c3c;
    position: relative;
}

.block-editor-block-list__block[data-type="core/image"] .components-placeholder::before {
    content: "Missing alt text";
    color: #e74c3c;
    font-style: italic;
    font-size: 12px;
    display: block;
    margin-bottom: 10px;
}

/* Style for semantic blocks */
.is-style-semantic-paragraph {
    border-left: 3px solid #3498db;
    padding-left: 10px;
}

.is-style-semantic-heading {
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
}

.is-style-semantic-image {
    border: 2px solid #2ecc71;
    position: relative;
}

.is-style-semantic-image::after {
    content: "Accessible Image";
    background-color: #2ecc71;
    color: white;
    font-size: 10px;
    padding: 2px 5px;
    position: absolute;
    top: 0;
    right: 0;
}

/* Highlight multiple H1 headings */
.block-editor-block-list__block[data-type="core/heading"][data-level="1"]:not(:first-of-type) {
    border: 1px dashed #e74c3c;
    position: relative;
    padding: 5px;
    background-color: rgba(231, 76, 60, 0.1);
}

.block-editor-block-list__block[data-type="core/heading"][data-level="1"]:not(:first-of-type)::before {
    content: "Multiple H1 tags detected - consider using H2 or lower for this heading";
    color: #e74c3c;
    font-style: italic;
    font-size: 12px;
    display: block;
    margin-bottom: 5px;
}

/* Notice styles for HTML structure checker */
.wades-html-structure-checker .notice {
    padding: 10px;
    margin: 10px 0;
    border-left: 4px solid #ddd;
}

.wades-html-structure-checker .notice-error {
    border-left-color: #e74c3c;
    background-color: rgba(231, 76, 60, 0.1);
}

.wades-html-structure-checker .notice-warning {
    border-left-color: #f39c12;
    background-color: rgba(243, 156, 18, 0.1);
}

/* Custom styles for the front page editor */
body.is-front-page .entry-header {
    display: none;
}

body.is-front-page .wp-block-heading[data-level="1"]:first-of-type {
    border: 2px solid #2ecc71;
    padding: 5px;
    position: relative;
}

body.is-front-page .wp-block-heading[data-level="1"]:first-of-type::before {
    content: "Main H1 - Only one H1 is allowed per page";
    color: #2ecc71;
    font-style: italic;
    font-size: 12px;
    display: block;
    margin-bottom: 5px;
}
CSS;
    
    // Write to file
    $file = fopen(get_template_directory() . '/css/editor-html-structure.css', 'w');
    fwrite($file, $css_content);
    fclose($file);
}

/**
 * Create the editor patterns CSS file
 */
function wades_plumbing_septic_create_editor_patterns_css() {
    // Get the CSS directory
    $css_dir = get_template_directory() . '/css';
    
    // Create it if it doesn't exist
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    // CSS content
    $css_content = <<<CSS
/**
 * Specific CSS for patterns in the block editor
 */

/* Hero pattern fixes for admin */
.editor-styles-wrapper .is-style-wades-parallax-hero {
  background-attachment: fixed !important;
  background-position: center !important;
  background-repeat: no-repeat !important;
  background-size: cover !important;
  min-height: 80vh !important;
  position: relative !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  overflow: hidden !important;
}

.editor-styles-wrapper .is-style-wades-parallax-hero .wp-block-cover__image-background {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  transform: translateZ(0);
  will-change: transform;
  z-index: 0 !important;
}

.editor-styles-wrapper .is-style-wades-parallax-hero .wp-block-cover__background {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 100% !important;
  height: 100% !important;
  z-index: 1 !important;
}

.editor-styles-wrapper .is-style-wades-parallax-hero .wp-block-cover__inner-container {
  position: relative !important;
  z-index: 2 !important;
  width: 100% !important;
  max-width: 1280px !important;
  margin: 0 auto !important;
}

/* Fix for editor-specific block positioning */
.editor-styles-wrapper .z-30 {
  z-index: 30 !important;
}

.editor-styles-wrapper .z-10 {
  z-index: 10 !important;
}

.editor-styles-wrapper .relative {
  position: relative !important;
}

.editor-styles-wrapper .absolute {
  position: absolute !important;
}

.editor-styles-wrapper .bottom-0 {
  bottom: 0 !important;
}

.editor-styles-wrapper .right-10 {
  right: 2.5rem !important;
}

/* Fix for utilities that may not be applied properly in the editor */
.editor-styles-wrapper .overflow-hidden {
  overflow: hidden !important;
}

.editor-styles-wrapper .w-full {
  width: 100% !important;
}

.editor-styles-wrapper .mx-auto {
  margin-left: auto !important;
  margin-right: auto !important;
}

/* Backdrop blur effect fix for editor */
.editor-styles-wrapper .backdrop-blur-sm {
  backdrop-filter: blur(4px) !important;
}

.editor-styles-wrapper .bg-white\\/10 {
  background-color: rgba(255, 255, 255, 0.1) !important;
}

/* Ensure text colors are correct */
.editor-styles-wrapper .text-white {
  color: #fff !important;
}

.editor-styles-wrapper .text-black {
  color: #000 !important;
}

.editor-styles-wrapper .bg-brand {
  background-color: #FFDD00 !important;
}

/* Ensure block styles are preserved in editor */
.editor-styles-wrapper .alignfull {
  margin-left: calc(-100vw / 2 + 100% / 2) !important;
  margin-right: calc(-100vw / 2 + 100% / 2) !important;
  max-width: 100vw !important;
  width: 100vw !important;
}

/* Fix grid layout issues in the editor */
.editor-styles-wrapper .grid {
  display: grid !important;
}

.editor-styles-wrapper .lg\\:grid-cols-12 {
  grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
}

/* Fix responsive classes that might not be working properly in the editor */
@media (min-width: 782px) {
  .editor-styles-wrapper .md\\:block {
    display: block !important;
  }
  
  .editor-styles-wrapper .hidden.md\\:block {
    display: block !important;
  }
}

@media (max-width: 781px) {
  .editor-styles-wrapper .hidden:not(.md\\:block) {
    display: none !important;
  }
}
CSS;
    
    // Write to file
    $file = fopen(get_template_directory() . '/css/editor-patterns.css', 'w');
    fwrite($file, $css_content);
    fclose($file);
}

/**
 * Create the editor patterns fix JS file
 */
function wades_plumbing_septic_create_editor_patterns_fix_js() {
    // Get the JS directory
    $js_dir = get_template_directory() . '/js';
    
    // Create it if it doesn't exist
    if (!file_exists($js_dir)) {
        wp_mkdir_p($js_dir);
    }
    
    // JS content
    $js_content = <<<JS
/**
 * JavaScript to fix pattern rendering in the Gutenberg editor
 */
(function($) {
    // Wait for document ready
    $(document).ready(function() {
        // Fix for hero pattern in the editor
        function fixHeroPatternDisplay() {
            // Wait for Gutenberg to be fully loaded
            if (typeof wp === 'undefined' || typeof wp.data === 'undefined') {
                setTimeout(fixHeroPatternDisplay, 500);
                return;
            }
            
            // Function to fix the hero pattern
            function refreshHeroPattern() {
                // Target the hero pattern cover blocks
                $('.editor-styles-wrapper .is-style-wades-parallax-hero').each(function() {
                    var \$hero = $(this);
                    
                    // Ensure proper z-index stacking
                    \$hero.find('.wp-block-cover__background').css('z-index', 1);
                    \$hero.find('.wp-block-cover__inner-container').css('z-index', 2);
                    
                    // Fix responsive issues with the plumber mascot
                    \$hero.find('.hidden.md\\\\:block').css({
                        'display': 'block',
                        'position': 'absolute',
                        'bottom': '0',
                        'right': '2.5rem'
                    });
                    
                    // Fix backdrop blur if present
                    \$hero.find('.backdrop-blur-sm').css({
                        'backdrop-filter': 'blur(4px)',
                        'background-color': 'rgba(255, 255, 255, 0.1)'
                    });
                });
            }
            
            // Initial fix
            refreshHeroPattern();
            
            // React to changes in the editor content
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        refreshHeroPattern();
                    }
                });
            });
            
            // Observe the editor for changes
            var editorEl = document.querySelector('.editor-styles-wrapper');
            if (editorEl) {
                observer.observe(editorEl, { 
                    childList: true,
                    subtree: true
                });
            }
            
            // Also watch for resize events
            $(window).on('resize', function() {
                refreshHeroPattern();
            });
        }
        
        // Start the fix process
        fixHeroPatternDisplay();
    });
})(jQuery);
JS;
    
    // Write to file
    $file = fopen(get_template_directory() . '/js/editor-patterns-fix.js', 'w');
    fwrite($file, $js_content);
    fclose($file);
}

/**
 * Register block colors
 */
function wades_plumbing_septic_register_custom_colors() {
    // Register brand colors
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Brand', 'wades-plumbing-septic'),
            'slug'  => 'brand',
            'color' => '#bc6f30',
        ),
        array(
            'name'  => __('Brand 600', 'wades-plumbing-septic'),
            'slug'  => 'brand-600',
            'color' => '#a9642b',
        ),
        array(
            'name'  => __('Black', 'wades-plumbing-septic'),
            'slug'  => 'black',
            'color' => '#000000',
        ),
        array(
            'name'  => __('White', 'wades-plumbing-septic'),
            'slug'  => 'white',
            'color' => '#FFFFFF',
        ),
        array(
            'name'  => __('Gray 300', 'wades-plumbing-septic'),
            'slug'  => 'gray-300',
            'color' => '#D1D5DB',
        ),
        array(
            'name'  => __('Gray 400', 'wades-plumbing-septic'),
            'slug'  => 'gray-400',
            'color' => '#9CA3AF',
        ),
    ));

    // Add CSS variables for the new colors
    add_action('wp_head', 'wades_plumbing_septic_add_color_variables');
    add_action('admin_head', 'wades_plumbing_septic_add_color_variables');
}
add_action('after_setup_theme', 'wades_plumbing_septic_register_custom_colors');

/**
 * Add CSS variables for colors and header height offset
 */
function wades_plumbing_septic_add_color_variables() {
    echo '<style>
        :root {
            --color-brand: #bc6f30;
            --color-brand-600: #a9642b;
            --color-black: #000000;
            --color-white: #FFFFFF;
            --color-gray-300: #D1D5DB;
            --color-gray-400: #9CA3AF;
            --wp-header-height: 80px;
        }
        
        /* Support for the text-brand class */
        .text-brand {
            color: var(--color-brand) !important;
        }
        
        /* Support for the hover:bg-brand-600 class */
        .hover\\:bg-brand-600:hover {
            background-color: var(--color-brand-600) !important;
        }
        
        /* Header height offset for full-height sections */
        .header-offset-height {
            min-height: calc(100vh - var(--wp-header-height)) !important;
        }
        
        /* Improve text readability */
        .bg-black\\/50 {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }
        
        /* Text with opacity */
        .text-white\\/80 {
            color: rgba(255, 255, 255, 0.8) !important;
        }
    </style>';
}

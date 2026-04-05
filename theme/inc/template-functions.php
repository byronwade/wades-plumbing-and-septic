<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Wades_Plumbing_&_Septic
 */

require_once get_template_directory() . '/inc/frontend/image-helpers.php';

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
	
	// Get comment date - for relative time display
	$comment_date = mysql2date( 'U', $comment->comment_date );
	$time_diff = current_time( 'timestamp' ) - $comment_date;
	
	// Show relative time for recent comments
	if ( $time_diff < 60*60*24*7 ) { // If less than a week
		if ( $time_diff < 60 ) {
			$time_string = __( 'Just now', 'wades-plumbing-septic' );
		} elseif ( $time_diff < 60*60 ) {
			$mins = round( $time_diff / 60 );
			$time_string = sprintf( _n( '%s minute ago', '%s minutes ago', $mins, 'wades-plumbing-septic' ), $mins );
		} elseif ( $time_diff < 60*60*24 ) {
			$hours = round( $time_diff / (60*60) );
			$time_string = sprintf( _n( '%s hour ago', '%s hours ago', $hours, 'wades-plumbing-septic' ), $hours );
		} else {
			$days = round( $time_diff / (60*60*24) );
			$time_string = sprintf( _n( '%s day ago', '%s days ago', $days, 'wades-plumbing-septic' ), $days );
		}
	} else {
		$time_string = sprintf(
			'%s',
			get_comment_date( 'F j, Y \a\t g:i a', $comment )
		);
	}
	
	// Determine if this is a reply comment
	$is_reply = $comment->comment_parent ? true : false;
	$author_badge = ( $comment->user_id && $comment->user_id == get_the_author_meta( 'ID' ) ) ? true : false;
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $is_reply ? 'child-comment' : '', $comment ); ?>>
		<div id="div-comment-<?php comment_ID(); ?>" class="comment-body flex items-start gap-4 <?php echo $is_reply ? 'ml-8 md:ml-12 mt-4' : 'mb-8'; ?>">
			<div class="flex-shrink-0 mt-1">
				<?php
				echo get_avatar(
					$comment,
					$args['avatar_size'],
					'',
					'',
					array(
						'class' => 'rounded-full ' . ($author_badge ? 'ring-2 ring-primary ring-offset-1' : ''),
					)
				);
				?>
			</div>
			
			<div class="flex-1 min-w-0">
				<div class="bg-gray-50 p-4 rounded-lg">
					<div class="flex flex-wrap items-center gap-2 mb-2">
						<h4 class="font-bold text-gray-900">
							<?php
							$comment_author = get_comment_author_link( $comment );

							if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
								$comment_author = get_comment_author( $comment );
							}

							printf( '%s', wp_kses_post( $comment_author ) );
							?>
						</h4>
						
						<?php if ( $author_badge ) : ?>
							<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary text-white">
								<?php echo __( 'Author', 'wades-plumbing-septic' ); ?>
							</span>
						<?php endif; ?>
						
						<span class="text-sm text-gray-500"><?php echo esc_html( $time_string ); ?></span>
						
						<?php edit_comment_link( __( 'Edit', 'wades-plumbing-septic' ), '<span class="text-xs text-gray-400 hover:text-primary">', '</span>' ); ?>
					</div>

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<div class="comment-awaiting-moderation bg-yellow-50 text-yellow-800 p-2 rounded-md mb-2 text-sm border border-yellow-100">
							<?php echo esc_html( $moderation_note ); ?>
						</div>
					<?php endif; ?>

					<div class="prose prose-sm max-w-none text-gray-700">
						<?php comment_text(); ?>
					</div>
				</div>
				
				<div class="mt-2 flex items-center gap-4">
					<?php
					comment_reply_link(
						array_merge(
							$args,
							array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
								'before'    => '',
								'after'     => '',
							)
						)
					);
					?>
				</div>
			</div>
		</div>
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
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wades_hide_title_meta_box_nonce'] ) ), 'wades_hide_title_meta_box_nonce' ) ) {
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
 * Add a consolidated meta box for landing page controls.
 */
function wades_plumbing_septic_add_landing_page_controls_meta_box() {
	add_meta_box(
		'wades_landing_page_controls_meta_box',
		__( 'Landing Page Controls', 'wades-plumbing-septic' ),
		'wades_plumbing_septic_landing_page_controls_meta_box_callback',
		'landing_page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'wades_plumbing_septic_add_landing_page_controls_meta_box' );

/**
 * Render landing page controls.
 *
 * @param WP_Post $post Current post object.
 */
function wades_plumbing_septic_landing_page_controls_meta_box_callback( $post ) {
	wp_nonce_field( 'wades_landing_page_controls_nonce_action', 'wades_landing_page_controls_nonce' );

	$start_at      = get_post_meta( $post->ID, '_wades_landing_start_at', true );
	$end_at        = get_post_meta( $post->ID, '_wades_landing_end_at', true );
	$expiry_action = get_post_meta( $post->ID, '_wades_landing_expiry_action', true );
	$redirect_url  = get_post_meta( $post->ID, '_wades_landing_redirect_url', true );
	$template      = get_post_meta( $post->ID, '_wades_landing_template_preset', true );
	$allow_index   = get_post_meta( $post->ID, '_wades_landing_allow_index', true );

	if ( empty( $expiry_action ) ) {
		$expiry_action = 'set_draft';
	}

	if ( empty( $template ) ) {
		$template = 'none';
	}

	$wades_landing_services_url = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' );
	?>
	<p>
		<label for="wades_landing_start_at"><strong><?php esc_html_e( 'Start Time', 'wades-plumbing-septic' ); ?></strong></label>
		<input type="datetime-local" id="wades_landing_start_at" name="wades_landing_start_at" value="<?php echo esc_attr( $start_at ); ?>" class="widefat" />
	</p>

	<p>
		<label for="wades_landing_end_at"><strong><?php esc_html_e( 'End Time', 'wades-plumbing-septic' ); ?></strong></label>
		<input type="datetime-local" id="wades_landing_end_at" name="wades_landing_end_at" value="<?php echo esc_attr( $end_at ); ?>" class="widefat" />
	</p>

	<p>
		<label for="wades_landing_expiry_action"><strong><?php esc_html_e( 'On Expiry', 'wades-plumbing-septic' ); ?></strong></label>
		<select id="wades_landing_expiry_action" name="wades_landing_expiry_action" class="widefat">
			<option value="set_draft" <?php selected( $expiry_action, 'set_draft' ); ?>><?php esc_html_e( 'Set to Draft', 'wades-plumbing-septic' ); ?></option>
			<option value="redirect" <?php selected( $expiry_action, 'redirect' ); ?>><?php esc_html_e( '301 Redirect', 'wades-plumbing-septic' ); ?></option>
		</select>
	</p>

	<p>
		<label for="wades_landing_redirect_url"><strong><?php esc_html_e( 'Redirect URL', 'wades-plumbing-septic' ); ?></strong></label>
		<input type="url" id="wades_landing_redirect_url" name="wades_landing_redirect_url" value="<?php echo esc_attr( $redirect_url ); ?>" class="widefat" placeholder="<?php echo esc_attr( $wades_landing_services_url ); ?>" />
		<span class="description"><?php esc_html_e( 'Used when "301 Redirect" is selected. Fallback is /services/.', 'wades-plumbing-septic' ); ?></span>
	</p>

	<p>
		<label for="wades_landing_template_preset"><strong><?php esc_html_e( 'Template Preset', 'wades-plumbing-septic' ); ?></strong></label>
		<select id="wades_landing_template_preset" name="wades_landing_template_preset" class="widefat">
			<option value="none" <?php selected( $template, 'none' ); ?>><?php esc_html_e( 'None', 'wades-plumbing-septic' ); ?></option>
			<option value="call_first" <?php selected( $template, 'call_first' ); ?>><?php esc_html_e( 'Call-First', 'wades-plumbing-septic' ); ?></option>
			<option value="proof_cta" <?php selected( $template, 'proof_cta' ); ?>><?php esc_html_e( 'Proof + CTA', 'wades-plumbing-septic' ); ?></option>
			<option value="emergency" <?php selected( $template, 'emergency' ); ?>><?php esc_html_e( 'Emergency', 'wades-plumbing-septic' ); ?></option>
		</select>
	</p>

	<p>
		<label for="wades_landing_allow_index">
			<input type="checkbox" id="wades_landing_allow_index" name="wades_landing_allow_index" value="1" <?php checked( $allow_index, '1' ); ?> />
			<?php esc_html_e( 'Allow indexing (override default noindex)', 'wades-plumbing-septic' ); ?>
		</label>
	</p>
	<?php
}

/**
 * Save landing page controls.
 *
 * @param int $post_id Post ID.
 */
function wades_plumbing_septic_save_landing_page_controls_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['wades_landing_page_controls_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['wades_landing_page_controls_nonce'], 'wades_landing_page_controls_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$start_at = isset( $_POST['wades_landing_start_at'] ) ? sanitize_text_field( wp_unslash( $_POST['wades_landing_start_at'] ) ) : '';
	$end_at   = isset( $_POST['wades_landing_end_at'] ) ? sanitize_text_field( wp_unslash( $_POST['wades_landing_end_at'] ) ) : '';

	$expiry_action = isset( $_POST['wades_landing_expiry_action'] ) ? sanitize_key( wp_unslash( $_POST['wades_landing_expiry_action'] ) ) : 'set_draft';
	if ( ! in_array( $expiry_action, array( 'set_draft', 'redirect' ), true ) ) {
		$expiry_action = 'set_draft';
	}

	$template = isset( $_POST['wades_landing_template_preset'] ) ? sanitize_key( wp_unslash( $_POST['wades_landing_template_preset'] ) ) : 'none';
	if ( ! in_array( $template, array( 'none', 'call_first', 'proof_cta', 'emergency' ), true ) ) {
		$template = 'none';
	}

	$redirect_url = isset( $_POST['wades_landing_redirect_url'] ) ? esc_url_raw( wp_unslash( $_POST['wades_landing_redirect_url'] ) ) : '';

	if ( '' !== $start_at ) {
		update_post_meta( $post_id, '_wades_landing_start_at', $start_at );
	} else {
		delete_post_meta( $post_id, '_wades_landing_start_at' );
	}

	if ( '' !== $end_at ) {
		update_post_meta( $post_id, '_wades_landing_end_at', $end_at );
	} else {
		delete_post_meta( $post_id, '_wades_landing_end_at' );
	}

	update_post_meta( $post_id, '_wades_landing_expiry_action', $expiry_action );
	update_post_meta( $post_id, '_wades_landing_template_preset', $template );

	if ( 'redirect' === $expiry_action && ! empty( $redirect_url ) ) {
		update_post_meta( $post_id, '_wades_landing_redirect_url', $redirect_url );
	} elseif ( 'redirect' === $expiry_action && empty( $redirect_url ) ) {
		update_post_meta( $post_id, '_wades_landing_redirect_url', function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' ) );
	} else {
		delete_post_meta( $post_id, '_wades_landing_redirect_url' );
	}

	if ( isset( $_POST['wades_landing_allow_index'] ) ) {
		update_post_meta( $post_id, '_wades_landing_allow_index', '1' );
	} else {
		delete_post_meta( $post_id, '_wades_landing_allow_index' );
	}
}
add_action( 'save_post_landing_page', 'wades_plumbing_septic_save_landing_page_controls_meta_box_data' );

/**
 * Convert landing control datetime-local value into a Unix timestamp.
 *
 * @param string $value Datetime-local value.
 * @return int|false
 */
function wades_plumbing_septic_landing_datetime_to_timestamp( $value ) {
	if ( empty( $value ) ) {
		return false;
	}

	$timezone = wp_timezone();
	$date     = date_create_immutable_from_format( 'Y-m-d\TH:i', $value, $timezone );

	if ( false === $date ) {
		return false;
	}

	return $date->getTimestamp();
}

/**
 * Enforce landing page schedules and expiry actions at runtime.
 */
function wades_plumbing_septic_enforce_landing_page_schedule() {
	if ( is_admin() || is_preview() || ! is_singular( 'landing_page' ) ) {
		return;
	}

	$post_id = get_queried_object_id();
	if ( empty( $post_id ) ) {
		return;
	}

	$start_at      = get_post_meta( $post_id, '_wades_landing_start_at', true );
	$end_at        = get_post_meta( $post_id, '_wades_landing_end_at', true );
	$expiry_action = get_post_meta( $post_id, '_wades_landing_expiry_action', true );
	$redirect_url  = get_post_meta( $post_id, '_wades_landing_redirect_url', true );

	if ( empty( $expiry_action ) ) {
		$expiry_action = 'set_draft';
	}

	$now_timestamp   = current_datetime()->getTimestamp();
	$start_timestamp = wades_plumbing_septic_landing_datetime_to_timestamp( $start_at );
	$end_timestamp   = wades_plumbing_septic_landing_datetime_to_timestamp( $end_at );

	// Before the start window, treat as not found.
	if ( false !== $start_timestamp && $now_timestamp < $start_timestamp ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
		return;
	}

	// Expiry handling.
	if ( false !== $end_timestamp && $now_timestamp >= $end_timestamp ) {
		if ( 'redirect' === $expiry_action ) {
			$wades_services_fallback = function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' );
			$target                  = ! empty( $redirect_url ) ? $redirect_url : $wades_services_fallback;

			// Prevent self-redirect loops.
			$request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$current_path = wp_parse_url( $request_uri, PHP_URL_PATH );
			$target_path  = wp_parse_url( $target, PHP_URL_PATH );
			if ( $target_path && $current_path && untrailingslashit( $target_path ) === untrailingslashit( $current_path ) ) {
				$target = $wades_services_fallback;
			}

			wp_safe_redirect( $target, 301 );
			exit;
		}

		if ( 'publish' === get_post_status( $post_id ) ) {
			remove_action( 'save_post_landing_page', 'wades_plumbing_septic_save_landing_page_controls_meta_box_data' );
			wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => 'draft',
				)
			);
			add_action( 'save_post_landing_page', 'wades_plumbing_septic_save_landing_page_controls_meta_box_data' );
		}

		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}
add_action( 'template_redirect', 'wades_plumbing_septic_enforce_landing_page_schedule', 1 );

/**
 * Map landing page template preset keys to registered block pattern slugs.
 *
 * @param string $preset Template preset key.
 * @return string
 */
function wades_plumbing_septic_get_landing_template_pattern_slug( $preset ) {
	$map = array(
		'call_first' => 'wades-plumbing-septic/landing-call-first',
		'proof_cta'  => 'wades-plumbing-septic/landing-proof-cta',
		'emergency'  => 'wades-plumbing-septic/landing-emergency',
	);

	return isset( $map[ $preset ] ) ? $map[ $preset ] : '';
}

/**
 * Insert preset content on first publish if landing page content is empty.
 *
 * @param string  $new_status New post status.
 * @param string  $old_status Old post status.
 * @param WP_Post $post       Post object.
 */
function wades_plumbing_septic_apply_landing_template_on_first_publish( $new_status, $old_status, $post ) {
	if ( ! ( $post instanceof WP_Post ) || 'landing_page' !== $post->post_type ) {
		return;
	}

	if ( 'publish' !== $new_status || 'publish' === $old_status ) {
		return;
	}

	$already_applied = get_post_meta( $post->ID, '_wades_landing_template_applied', true );
	if ( '1' === $already_applied ) {
		return;
	}

	$current_content = trim( (string) $post->post_content );
	if ( '' !== $current_content ) {
		return;
	}

	$preset       = get_post_meta( $post->ID, '_wades_landing_template_preset', true );
	$pattern_slug = wades_plumbing_septic_get_landing_template_pattern_slug( $preset );

	if ( empty( $pattern_slug ) || ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
		return;
	}

	$registry = WP_Block_Patterns_Registry::get_instance();
	$pattern  = $registry->get_registered( $pattern_slug );

	if ( empty( $pattern ) || empty( $pattern['content'] ) ) {
		return;
	}

	wp_update_post(
		array(
			'ID'           => $post->ID,
			'post_content' => $pattern['content'],
		)
	);

	update_post_meta( $post->ID, '_wades_landing_template_applied', '1' );
}
add_action( 'transition_post_status', 'wades_plumbing_septic_apply_landing_template_on_first_publish', 10, 3 );

/**
 * Customize landing page list table columns.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function wades_plumbing_septic_landing_page_columns( $columns ) {
	$updated_columns = array();

	foreach ( $columns as $key => $label ) {
		$updated_columns[ $key ] = $label;

		if ( 'title' === $key ) {
			$updated_columns['landing_status_window'] = __( 'Status Window', 'wades-plumbing-septic' );
			$updated_columns['landing_expires']       = __( 'Expires', 'wades-plumbing-septic' );
			$updated_columns['landing_expiry_action'] = __( 'Expiry Action', 'wades-plumbing-septic' );
			$updated_columns['landing_seo']           = __( 'SEO', 'wades-plumbing-septic' );
		}
	}

	return $updated_columns;
}
add_filter( 'manage_landing_page_posts_columns', 'wades_plumbing_septic_landing_page_columns' );

/**
 * Render custom landing page list table column values.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function wades_plumbing_septic_landing_page_custom_column( $column, $post_id ) {
	$start_at      = get_post_meta( $post_id, '_wades_landing_start_at', true );
	$end_at        = get_post_meta( $post_id, '_wades_landing_end_at', true );
	$expiry_action = get_post_meta( $post_id, '_wades_landing_expiry_action', true );
	$allow_index   = get_post_meta( $post_id, '_wades_landing_allow_index', true );

	switch ( $column ) {
		case 'landing_status_window':
			if ( empty( $start_at ) && empty( $end_at ) ) {
				echo esc_html__( 'Always Active', 'wades-plumbing-septic' );
				break;
			}

			$now_timestamp   = current_datetime()->getTimestamp();
			$start_timestamp = wades_plumbing_septic_landing_datetime_to_timestamp( $start_at );
			$end_timestamp   = wades_plumbing_septic_landing_datetime_to_timestamp( $end_at );

			if ( false !== $start_timestamp && $now_timestamp < $start_timestamp ) {
				echo esc_html__( 'Scheduled', 'wades-plumbing-septic' );
			} elseif ( false !== $end_timestamp && $now_timestamp >= $end_timestamp ) {
				echo esc_html__( 'Expired', 'wades-plumbing-septic' );
			} else {
				echo esc_html__( 'Active', 'wades-plumbing-septic' );
			}
			break;

		case 'landing_expires':
			if ( empty( $end_at ) ) {
				echo esc_html__( 'Never', 'wades-plumbing-septic' );
			} else {
				echo esc_html( $end_at );
			}
			break;

		case 'landing_expiry_action':
			if ( empty( $expiry_action ) ) {
				$expiry_action = 'set_draft';
			}

			echo esc_html( 'redirect' === $expiry_action ? __( '301 Redirect', 'wades-plumbing-septic' ) : __( 'Set to Draft', 'wades-plumbing-septic' ) );
			break;

		case 'landing_seo':
			echo esc_html( '1' === $allow_index ? __( 'Index', 'wades-plumbing-septic' ) : __( 'Noindex', 'wades-plumbing-septic' ) );
			break;
	}
}
add_action( 'manage_landing_page_posts_custom_column', 'wades_plumbing_septic_landing_page_custom_column', 10, 2 );

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
    $seo_location  = get_option('wades_seo_location_settings', array());
    $primary_phone = isset($seo_location['business_phone']) ? trim((string) $seo_location['business_phone']) : '';
    if ($primary_phone === '') {
        $primary_phone = get_theme_mod('business_phone', get_theme_mod('phone_number', '831.225.4344'));
    }
    
    // Return primary phone with simplified structure
    $result = array(
        'primary_phone' => $primary_phone,
        'active_phone' => $primary_phone,
        'show_selector' => false
    );
    
    return $result;
}

/**
 * Get the business hours from theme customizer
 * 
 * @return string Business hours string
 */
function wades_plumbing_septic_get_business_hours() {
    $seo_location   = get_option('wades_seo_location_settings', array());
    $business_hours = isset($seo_location['business_hours']) ? trim((string) $seo_location['business_hours']) : '';
    if ($business_hours === '') {
        $business_hours = get_theme_mod('business_hours', 'Mon - Fri 9:00am - 5:00pm');
    }
    
    // Return the formatted business hours
    return $business_hours;
}

/**
 * Get normalized service area copy for templates and snippets.
 *
 * @return string
 */
function wades_plumbing_septic_get_service_area_summary() {
    $seo_location = get_option('wades_seo_location_settings', array());
    $summary      = isset($seo_location['service_area_summary']) ? trim((string) $seo_location['service_area_summary']) : '';

    if ($summary === '') {
        $summary = 'Santa Cruz County, CA and Pickens County, GA';
    }

    return $summary;
}

/**
 * Get the business start year from SEO settings.
 *
 * @return string
 */
function wades_plumbing_septic_get_business_start_year() {
    $seo_location = get_option('wades_seo_location_settings', array());
    $start_year   = isset($seo_location['business_start_year']) ? preg_replace('/[^0-9]/', '', (string) $seo_location['business_start_year']) : '';

    if ($start_year === '' || strlen($start_year) !== 4) {
        $start_year = '2021';
    }

    return $start_year;
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
		'url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' ),
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
						'name' => 'Plumbing Maintenance'
					)
				)
			)
		)
	);

	// Output the schema in the head
	echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}
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
	// Disable by default to prevent front-page-only style drift across environments.
	$critical_css_enabled = (bool) apply_filters( 'wades_enable_front_page_critical_css', false );
	if ( ! $critical_css_enabled || ! is_front_page() ) {
		return;
	}

	// Critical CSS for above-the-fold content
	$critical_css = '
	/* Critical CSS for above-the-fold content */
	:root, :host {
		--background: #ffffff;
		--foreground: #404040;
		--primary: 29 59% 47%;
		--color-primary: #bc6f30;
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

	// Inline critical CSS only; full stylesheet loads once via wp_enqueue_style.
	echo '<style id="wades-critical-css">' . $critical_css . '</style>';
}
add_action('wp_head', 'wades_plumbing_septic_add_critical_css', 1);

/**
 * Add inline styles to make sure brand colors and other Tailwind utilities are consistent
 */
function wades_plumbing_septic_home_utility_fallback_css() {
	return '
	/* Front-page runtime fallback for missing utility classes in production CSS. */
	body.home .bg-\[\#111111\] { background-color: #111111; }
	body.home .bg-primary\/15 { background-color: rgba(188, 111, 48, 0.15); }
	body.home .bg-primary\/8 { background-color: rgba(188, 111, 48, 0.08); }
	body.home .bg-primary\/80 { background-color: rgba(188, 111, 48, 0.8); }
	body.home .blur-2xl { filter: blur(40px); }
	body.home .border-primary\/20 { border-color: rgba(188, 111, 48, 0.2); }
	body.home .border-primary\/40 { border-color: rgba(188, 111, 48, 0.4); }
	body.home .border-white\/40 { border-color: rgba(255, 255, 255, 0.4); }
	body.home .border-white\/8 { border-color: rgba(255, 255, 255, 0.08); }
	body.home .divide-gray-100 > :not([hidden]) ~ :not([hidden]) { border-top: 1px solid #f3f4f6; }
	body.home .font-black { font-weight: 900; }
	body.home .fp-section-title { font-size: clamp(2rem, 4.2vw, 3rem); line-height: 1.1; font-weight: 800; letter-spacing: -0.02em; }
	body.home .from-black\/75 { --tw-gradient-from: rgba(0, 0, 0, 0.75); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(0, 0, 0, 0)); }
	body.home .via-black\/10 { --tw-gradient-stops: var(--tw-gradient-from), rgba(0, 0, 0, 0.1), var(--tw-gradient-to, rgba(0, 0, 0, 0)); }
	body.home .gap-0\.5 { gap: 0.125rem; }
	body.home .gap-1\.5 { gap: 0.375rem; }
	body.home .gap-2\.5 { gap: 0.625rem; }
	body.home .gap-5 { gap: 1.25rem; }
	body.home .gap-x-8 { column-gap: 2rem; }
	body.home .h-1\.5 { height: 0.375rem; }
	body.home .h-80 { height: 20rem; }
	body.home .h-\[3px\] { height: 3px; }
	body.home .h-\[520px\] { height: 520px; }
	body.home .h-\[600px\] { height: 600px; }
	body.home .leading-none { line-height: 1; }
	body.home .leading-snug { line-height: 1.375; }
	body.home .mb-0\.5 { margin-bottom: 0.125rem; }
	body.home .mb-14 { margin-bottom: 3.5rem; }
	body.home .mt-5 { margin-top: 1.25rem; }
	body.home .opacity-0 { opacity: 0; }
	body.home .pb-0 { padding-bottom: 0; }
	body.home .pt-20 { padding-top: 5rem; }
	body.home .px-5 { padding-left: 1.25rem; padding-right: 1.25rem; }
	body.home .px-7 { padding-left: 1.75rem; padding-right: 1.75rem; }
	body.home .py-3\.5 { padding-top: 0.875rem; padding-bottom: 0.875rem; }
	body.home .py-5 { padding-top: 1.25rem; padding-bottom: 1.25rem; }
	body.home .right-2 { right: 0.5rem; }
	body.home .left-2 { left: 0.5rem; }
	body.home .top-6 { top: 1.5rem; }
	body.home .left-6 { left: 1.5rem; }
	body.home .shadow-black\/30 { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); }
	body.home .shadow-black\/40 { box-shadow: 0 12px 36px rgba(0, 0, 0, 0.4); }
	body.home .shadow-primary\/20 { box-shadow: 0 10px 30px rgba(188, 111, 48, 0.2); }
	body.home .shadow-primary\/30 { box-shadow: 0 10px 30px rgba(188, 111, 48, 0.3); }
	body.home .text-gray-100 { color: #f3f4f6; }
	body.home .text-gray-200 { color: #e5e7eb; }
	body.home .text-gray-800 { color: #1f2937; }
	body.home .text-white\/70 { color: rgba(255, 255, 255, 0.7); }
	body.home .text-yellow-500 { color: #eab308; }
	body.home .tracking-widest { letter-spacing: 0.1em; }
	body.home .transition-opacity { transition-property: opacity; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
	body.home .w-1\.5 { width: 0.375rem; }
	body.home .w-44 { width: 11rem; }
	body.home .w-\[600px\] { width: 600px; }
	body.home .hover\:bg-brand-700:hover { background-color: #965926; }
	body.home .hover\:bg-primary\/10:hover { background-color: rgba(188, 111, 48, 0.1); }
	body.home .hover\:bg-primary\/5:hover { background-color: rgba(188, 111, 48, 0.05); }
	body.home .hover\:bg-white\/8:hover { background-color: rgba(255, 255, 255, 0.08); }
	body.home .hover\:border-primary\/30:hover { border-color: rgba(188, 111, 48, 0.3); }
	body.home .hover\:text-brand-700:hover { color: #965926; }
	body.home .hover\:text-primary:hover { color: #bc6f30; }
	body.home .focus\:ring-primary:focus { box-shadow: 0 0 0 2px #bc6f30; }
	body.home .focus\:ring-white\/30:focus { box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3); }
	body.home .focus\:ring-offset-gray-950:focus { outline-offset: 2px; }
	body.home .group:hover .group-hover\:opacity-100 { opacity: 1; }
	body.home .group:hover .group-hover\:text-primary { color: #bc6f30; }
	body.home .group:hover .group-hover\:bg-primary\/20 { background-color: rgba(188, 111, 48, 0.2); }
	body.home .first\:pt-0:first-child { padding-top: 0; }
	body.home .last\:pb-0:last-child { padding-bottom: 0; }
	@media (min-width: 640px) {
		body.home .sm\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
		body.home .sm\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
		body.home .sm\:justify-between { justify-content: space-between; }
		body.home .sm\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
		body.home .sm\:text-6xl { font-size: 3.75rem; line-height: 1; }
		body.home .sm\:w-auto { width: auto; }
	}
	@media (min-width: 768px) {
		body.home .md\:h-96 { height: 24rem; }
		body.home .md\:justify-end { justify-content: flex-end; }
		body.home .md\:p-10 { padding: 2.5rem; }
	}
	@media (min-width: 1024px) {
		body.home .lg\:gap-16 { gap: 4rem; }
		body.home .lg\:py-24 { padding-top: 6rem; padding-bottom: 6rem; }
	}
	body.home .eyebrow-badge,
	body.home .eyebrow-badge-dark {
		display: inline-flex;
		align-items: center;
		border-radius: 9999px;
		padding: 0.35rem 0.75rem;
		font-size: 0.72rem;
		font-weight: 700;
		letter-spacing: 0.08em;
		text-transform: uppercase;
	}
	body.home .eyebrow-badge {
		background-color: rgba(188, 111, 48, 0.12);
		color: #a9642b;
	}
	body.home .eyebrow-badge-dark {
		background-color: rgba(255, 255, 255, 0.08);
		color: #f1f5f9;
	}';
}

/**
 * Ensure the custom runtime stylesheet is present on frontend requests.
 *
 * @return void
 */
function wades_plumbing_septic_ensure_custom_css_enqueued() {
	if ( is_admin() ) {
		return;
	}

	if ( wp_style_is( 'wades-plumbing-septic-custom-style', 'enqueued' ) ) {
		return;
	}

	$relative_path = '/assets/css/custom.css';
	$full_path     = get_template_directory() . $relative_path;
	$version       = file_exists( $full_path ) ? (string) filemtime( $full_path ) : wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'wades-plumbing-septic-custom-style',
		get_template_directory_uri() . $relative_path,
		array( 'wades-plumbing-septic-style' ),
		$version
	);
}
add_action( 'wp_enqueue_scripts', 'wades_plumbing_septic_ensure_custom_css_enqueued', 99 );

/**
 * Inject the Mapbox public access token as a JS global so the ServiceAreaMap
 * component can read it without the token being hardcoded in the JS bundle.
 */
function wades_plumbing_septic_inject_mapbox_token() {
	// Token priority: WADES_MAPBOX_TOKEN constant (wp-config.php) → Customizer mapbox_token option → empty.
	// Define WADES_MAPBOX_TOKEN in wp-config.php to keep the key out of the database.
	$token = defined( 'WADES_MAPBOX_TOKEN' )
		? WADES_MAPBOX_TOKEN
		: get_theme_mod( 'mapbox_token', '' );
	echo '<script>window.wadesMapboxToken=' . wp_json_encode( $token ) . ';</script>' . "\n";
}
add_action( 'wp_head', 'wades_plumbing_septic_inject_mapbox_token', 5 );

/**
 * Add inline styles to make sure brand colors and utility classes are consistent.
 *
 * @return void
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
    /* Remove text underlines from buttons - let button component handle all other styling */
    button,
    .button,
    .wp-block-button__link,
    .wp-block-button a,
    input[type="button"],
    input[type="submit"],
    input[type="reset"],
    a.button,
    button:hover,
    button:focus,
    button:active,
    .button:hover,
    .button:focus,
    .button:active,
    .wp-block-button__link:hover,
    .wp-block-button__link:focus,
    .wp-block-button__link:active,
    .wp-block-button a:hover,
    .wp-block-button a:focus,
    .wp-block-button a:active,
    input[type="button"]:hover,
    input[type="button"]:focus,
    input[type="button"]:active,
    input[type="submit"]:hover,
    input[type="submit"]:focus,
    input[type="submit"]:active,
    input[type="reset"]:hover,
    input[type="reset"]:focus,
    input[type="reset"]:active,
    a.button:hover,
    a.button:focus,
    a.button:active {
        text-decoration: none !important;
        text-decoration-line: none !important;
        -webkit-text-decoration-line: none !important;
        text-underline-offset: 0 !important;
        text-decoration-thickness: 0 !important;
    }
    /* Remove underlines from regular links (not buttons) */
    a:where(:not(.wp-element-button)) {
        text-decoration: none !important;
        text-decoration-line: none !important;
        -webkit-text-decoration-line: none !important;
        text-underline-offset: 0 !important;
        text-decoration-thickness: 0 !important;
    }
    ';

	if ( is_front_page() || is_home() ) {
		$inline_css .= wades_plumbing_septic_home_utility_fallback_css();
	}
    
	wp_add_inline_style('wades-plumbing-septic-style', $inline_css);
}
add_action('wp_enqueue_scripts', 'wades_plumbing_septic_add_custom_inline_styles', 30);

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

    $can_write_theme_editor_assets = current_user_can('edit_theme_options');

    // Auto-generate editor assets only for users allowed to modify theme files.
    if ($can_write_theme_editor_assets) {
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
        $source_js = $js_dir . '/editor-html-structure.js';
        if (!file_exists($editor_js_file) || (file_exists($source_js) && filemtime($source_js) > filemtime($editor_js_file))) {
            wades_plumbing_septic_create_simplified_editor_js();
        }

        // Check if we need to create the patterns fix JS file
        $editor_patterns_js_file = $js_dir . '/editor-patterns-fix.js';
        if (!file_exists($editor_patterns_js_file)) {
            wades_plumbing_septic_create_editor_patterns_fix_js();
        }
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
    if (!current_user_can('edit_theme_options')) {
        return;
    }
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
    if (!current_user_can('edit_theme_options')) {
        return;
    }
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
    if (!current_user_can('edit_theme_options')) {
        return;
    }
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
    if (!current_user_can('edit_theme_options')) {
        return;
    }
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

/**
 * Use custom templates for specific categories
 *
 * @param string $template The path of the template to include.
 * @return string The path of the template to include.
 */
function wades_category_template($template) {
    if (is_category()) {
        $category = get_queried_object();
        
        // Check for a template in the theme directory with the category's slug
        $template_file = locate_template(array(
            "category-{$category->slug}.php",
            "category-{$category->term_id}.php"
        ));
        
        // If a category-specific template exists, use it
        if ($template_file) {
            return $template_file;
        }
    }
    
    return $template;
}
add_filter('template_include', 'wades_category_template');

/**
 * Create default content for the theme on activation
 */
function wades_plumbing_septic_create_default_content() {
    // Only run this once by checking for an option
    if (get_option('wades_default_content_created')) {
        return;
    }
    
    // Create default menus
    wades_create_default_menus();
    
    // Create default services
    wades_create_default_services();
    
    // Create default careers
    wades_create_default_careers();
    
    // Create default blog categories
    wades_create_default_categories();
    
    // Create default pages
    wades_create_default_pages();
    
    // Set the option so this only runs once
    update_option('wades_default_content_created', true);
}
add_action('after_switch_theme', 'wades_plumbing_septic_create_default_content');

/**
 * Create default navigation menus
 */
function wades_create_default_menus() {
    // Create Primary Menu if it doesn't exist
    $primary_menu_exists = wp_get_nav_menu_object('Primary Menu');
    
    if (!$primary_menu_exists) {
        $primary_menu_id = wp_create_nav_menu('Primary Menu');
        
        // Add default menu items
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Home',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Services parent item
        $services_item_id = wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Plumbing & Septic Services',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Service sub-items (service_category taxonomy)
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Plumbing Services',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_service_category_url_by_slug' ) ? wades_plumbing_septic_get_service_category_url_by_slug( 'plumbing' ) : home_url( '/services/plumbing/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $services_item_id,
        ));
        
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Septic Services',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_service_category_url_by_slug' ) ? wades_plumbing_septic_get_service_category_url_by_slug( 'septic' ) : home_url( '/services/septic/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $services_item_id,
        ));
        
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Commercial Services',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_service_category_url_by_slug' ) ? wades_plumbing_septic_get_service_category_url_by_slug( 'commercial' ) : home_url( '/services/commercial/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $services_item_id,
        ));
        
        // About Us
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'About Us',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'about' ) : home_url( '/about-us/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Expert Tips (Blog)
        $tips_item_id = wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Expert Tips',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'expert_tips' ) : home_url( '/expert-tips/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Blog category sub-items
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Plumbing Tips',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_blog_category_url_by_slug' ) ? wades_plumbing_septic_get_blog_category_url_by_slug( 'plumbing-tips' ) : home_url( '/category/plumbing-tips/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $tips_item_id,
        ));
        
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Septic Maintenance',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_blog_category_url_by_slug' ) ? wades_plumbing_septic_get_blog_category_url_by_slug( 'septic-maintenance' ) : home_url( '/category/septic-maintenance/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $tips_item_id,
        ));
        
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'DIY Projects',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_blog_category_url_by_slug' ) ? wades_plumbing_septic_get_blog_category_url_by_slug( 'diy-projects' ) : home_url( '/category/diy-projects/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
            'menu-item-parent-id' => $tips_item_id,
        ));
        
        // Careers
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Careers',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'careers' ) : home_url( '/careers/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Contact Us
        wp_update_nav_menu_item($primary_menu_id, 0, array(
            'menu-item-title' => 'Contact Us',
            'menu-item-url' => function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('contact') : home_url('/contact/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Assign menu to primary location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $primary_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    // Create Footer Menu if it doesn't exist
    $footer_menu_exists = wp_get_nav_menu_object('Footer Menu');
    
    if (!$footer_menu_exists) {
        $footer_menu_id = wp_create_nav_menu('Footer Menu');
        
        // Add default menu items
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Home',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Services',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'services' ) : home_url( '/services/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'About Us',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'about' ) : home_url( '/about-us/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Expert Tips',
            'menu-item-url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'expert_tips' ) : home_url( '/expert-tips/' ),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Careers',
            'menu-item-url' => function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('careers') : home_url('/careers/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Contact Us',
            'menu-item-url' => function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('contact') : home_url('/contact/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Privacy Policy',
            'menu-item-url' => function_exists('wades_plumbing_septic_get_privacy_policy_url') ? wades_plumbing_septic_get_privacy_policy_url() : home_url('/privacy-policy/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        wp_update_nav_menu_item($footer_menu_id, 0, array(
            'menu-item-title' => 'Terms of Service',
            'menu-item-url' => function_exists('wades_plumbing_septic_get_canonical_page_url') ? wades_plumbing_septic_get_canonical_page_url('terms_of_service') : home_url('/terms-of-service/'),
            'menu-item-status' => 'publish',
            'menu-item-type' => 'custom',
        ));
        
        // Assign menu to footer location
        $locations = get_theme_mod('nav_menu_locations');
        $locations['menu-2'] = $footer_menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * Create default services
 */
function wades_create_default_services() {
    // Create Service Categories if they don't exist
    if (!term_exists('Plumbing', 'service_category')) {
        wp_insert_term('Plumbing', 'service_category', array(
            'description' => 'All plumbing services offered by Wade\'s Plumbing & Septic',
            'slug' => 'plumbing'
        ));
    }
    
    if (!term_exists('Septic', 'service_category')) {
        wp_insert_term('Septic', 'service_category', array(
            'description' => 'All septic system services offered by Wade\'s Plumbing & Septic',
            'slug' => 'septic'
        ));
    }
    
    if (!term_exists('Commercial', 'service_category')) {
        wp_insert_term('Commercial', 'service_category', array(
            'description' => 'Services for commercial clients and properties',
            'slug' => 'commercial'
        ));
    }
    
    // Add additional service categories used in templates
    if (!term_exists('Residential Plumbing', 'service_category')) {
        wp_insert_term('Residential Plumbing', 'service_category', array(
            'description' => 'Complete plumbing solutions for your home',
            'slug' => 'residential-plumbing'
        ));
    }
    
    if (!term_exists('Commercial Plumbing', 'service_category')) {
        wp_insert_term('Commercial Plumbing', 'service_category', array(
            'description' => 'Professional plumbing services for businesses of all sizes',
            'slug' => 'commercial-plumbing'
        ));
    }
    
    if (!term_exists('Septic Services', 'service_category')) {
        wp_insert_term('Septic Services', 'service_category', array(
            'description' => 'Complete septic system solutions for residential and commercial properties',
            'slug' => 'septic-services'
        ));
    }
    
    if (!term_exists('Emergency Services', 'service_category')) {
        wp_insert_term('Emergency Services', 'service_category', array(
            'description' => '24/7 emergency plumbing and septic services',
            'slug' => 'emergency-services'
        ));
    }
    
    if (!term_exists('Specialty Services', 'service_category')) {
        wp_insert_term('Specialty Services', 'service_category', array(
            'description' => 'Specialized plumbing and septic solutions for unique needs',
            'slug' => 'specialty-services'
        ));
    }
    
    // Get category term IDs
    $plumbing_cat = get_term_by('slug', 'plumbing', 'service_category');
    $septic_cat = get_term_by('slug', 'septic', 'service_category');
    $commercial_cat = get_term_by('slug', 'commercial', 'service_category');
    $residential_plumbing_cat = get_term_by('slug', 'residential-plumbing', 'service_category');
    $commercial_plumbing_cat = get_term_by('slug', 'commercial-plumbing', 'service_category');
    $septic_services_cat = get_term_by('slug', 'septic-services', 'service_category');
    $emergency_services_cat = get_term_by('slug', 'emergency-services', 'service_category');
    $specialty_services_cat = get_term_by('slug', 'specialty-services', 'service_category');
    
    // Define default services
    $default_services = array(
        // SEPTIC SERVICES
        array(
            'title' => 'Alternative Septic System Installation',
            'content' => 'Our alternative septic system installation services provide solutions for challenging soil conditions, high water tables, or environmentally sensitive areas. We install aerobic treatment units, mound systems, sand filters, and other alternative designs that meet regulatory requirements while providing effective waste treatment. Our expertise ensures proper system selection, design, and installation for your specific site conditions.',
            'category' => array($septic_cat->term_id, $septic_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Installation of specialized alternative septic systems for challenging sites including aerobic treatment units, mound systems, and sand filters.',
        ),
        array(
            'title' => 'Septic System Certification',
            'content' => 'Our septic system certification service provides thorough inspection and documentation of your system\'s condition for real estate transactions, refinancing, or regulatory compliance. Our certified inspectors evaluate all components, perform flow testing, and provide detailed reports accepted by lending institutions and local health departments. We identify any issues that need addressing before certification.',
            'category' => array($septic_cat->term_id, $septic_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional septic system certification services for real estate transactions, financing requirements, and regulatory compliance.',
        ),
        array(
            'title' => 'Septic Filter Cleaning and Replacement',
            'content' => 'Our septic filter services include cleaning and replacement of effluent filters that prevent solids from entering your drainfield. Regular maintenance of these filters extends system life and prevents costly repairs. We inspect, clean, and when necessary replace filters to ensure optimal system performance and protect your drainfield from premature failure.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional cleaning and replacement of septic effluent filters to protect your drainfield and extend system lifespan.',
        ),
        array(
            'title' => 'High-Pressure Jetting for Septic Lines',
            'content' => 'Our high-pressure jetting service for septic systems uses specialized equipment to clear build-up in distribution lines and restore proper flow to your drainfield. This preventative maintenance removes biomat, roots, and accumulated debris that can cause system backups and failures. Regular jetting can often restore performance to struggling systems without major repairs.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Specialized high-pressure jetting service to clean septic distribution lines and restore proper flow to struggling drainfields.',
        ),
        array(
            'title' => 'Septic System Abandonment',
            'content' => 'Our septic system abandonment service properly decommissions old or failing systems in accordance with local health department regulations. This process includes pumping the tank, removing or crushing it, filling it with appropriate materials, and documenting the abandonment. Proper abandonment prevents safety hazards and environmental contamination when connecting to municipal sewer or installing a new system.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional septic system abandonment services with complete decommissioning according to health department regulations.',
        ),
        // PLUMBING SERVICES
        array(
            'title' => 'Drain Cleaning',
            'content' => 'Our professional drain cleaning service uses the latest equipment to clear any clogged or slow drains. We can handle kitchen sinks, bathroom drains, floor drains, and main sewer lines. Our technicians identify the cause of the clog and provide a complete solution to prevent future issues.',
            'category' => array($plumbing_cat->term_id, $residential_plumbing_cat->term_id, $emergency_services_cat->term_id),
            'featured_image' => '', // Set default image path if available
            'excerpt' => 'Professional drain cleaning services for all household drains, using advanced equipment to clear clogs and prevent future issues.',
        ),
        array(
            'title' => 'Water Heater Installation',
            'content' => 'Our water heater installation service includes removal of your old unit, installation of your new water heater, and all necessary connections and testing. We install traditional tank water heaters as well as tankless models from all major brands. Our technicians will help you select the right size and type for your household needs.',
            'category' => array($plumbing_cat->term_id, $residential_plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Expert installation of traditional and tankless water heaters, including removal of old units and complete setup of new systems.',
        ),
        array(
            'title' => 'Toilet Repair',
            'content' => 'Our toilet repair service addresses all common toilet problems including leaks, running toilets, weak flushes, and clogged toilets. Our skilled technicians can repair or replace flappers, fill valves, wax rings, and other components to restore proper function. We work with all major toilet brands and models to ensure your bathroom fixtures work efficiently and reliably.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete toilet repair services addressing leaks, running toilets, weak flushes, and clogs with expertise in all major brands.',
        ),
        array(
            'title' => 'Garbage Disposal Installation',
            'content' => 'Our garbage disposal installation service includes removal of your old unit (if applicable), installation of your new disposal, and all necessary plumbing connections. We install all major brands and models, from economy to premium units. Our technicians will also provide guidance on proper use and maintenance to extend the life of your new disposal.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional installation of garbage disposals of all brands and models, including removal of old units and complete setup.',
        ),
        array(
            'title' => 'Shower head Replacement',
            'content' => 'Our shower head replacement service includes removal of your old fixture, installation of your new shower head, and testing for proper function and water pressure. We can install standard fixed shower heads, handheld models, rainfall systems, and combination units. Our technicians can also recommend water-saving models that maintain excellent pressure while reducing water usage.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Expert replacement of all types of shower heads including fixed, handheld, rainfall, and water-saving models.',
        ),
        array(
            'title' => 'Sump Pump Installation',
            'content' => 'Our sump pump installation service provides complete protection against basement flooding. We handle the entire process including basin installation, pump placement, discharge piping, check valve installation, and electrical connections. We install primary pumps, battery backup systems, and water-powered backup pumps to ensure your property remains protected even during power outages.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete sump pump installation services including primary pumps and backup systems to protect against basement flooding.',
        ),
        array(
            'title' => 'Water Softener Maintenance',
            'content' => 'Our water softener maintenance service helps extend the life of your water treatment system and maintain its efficiency. Our comprehensive service includes inspection of all components, cleaning of the brine tank, checking for salt bridges, cleaning the venturi valve, sanitizing the resin bed, and testing cycle times. We service all major brands and can recommend appropriate maintenance schedules based on your water hardness and usage.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional water softener maintenance to ensure optimal performance and extended lifespan of your water treatment system.',
        ),
        array(
            'title' => 'Sewer Camera Inspection',
            'content' => 'Our sewer camera inspection service uses high-definition waterproof cameras to visually inspect your sewer lines and drains. This non-invasive diagnostic technique allows us to identify blockages, tree root intrusions, pipe breaks, collapses, and other issues without excavation. You\'ll receive a detailed report of our findings and video documentation of any problems discovered during the inspection.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'High-definition camera inspection of sewer lines to identify blockages, breaks, and other issues without excavation.',
        ),
        array(
            'title' => 'Backflow Prevention Testing',
            'content' => 'Our backflow prevention testing service ensures your backflow prevention devices are functioning properly to protect your drinking water. Our certified technicians conduct thorough testing according to local regulations and can provide necessary documentation for compliance. We also offer repairs and replacements for failed devices to maintain your water system\'s safety and meet regulatory requirements.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Certified backflow prevention testing to ensure proper function and regulatory compliance of your water system safety devices.',
        ),
        array(
            'title' => 'Grease Trap Installation',
            'content' => 'Our grease trap installation service is designed for restaurants, commercial kitchens, and food processing facilities. We handle the entire process from sizing and selection to installation and initial maintenance training. Our installations comply with all local codes and regulations. We offer both under-sink units for smaller facilities and larger in-ground interceptors for high-volume operations.',
            'category' => array($plumbing_cat->term_id, $commercial_cat->term_id, $commercial_plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete grease trap installation services for commercial kitchens, restaurants, and food processing facilities, compliant with all local codes.',
        ),
        array(
            'title' => 'Backflow Prevention Installation',
            'content' => 'Our backflow prevention installation service protects your water supply from contamination. We install all types of backflow preventers including pressure vacuum breakers, double-check valves, and reduced pressure zone devices. Our certified technicians ensure proper installation according to local plumbing codes and manufacturer specifications, followed by testing and certification to verify proper function.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional installation of all types of backflow prevention devices to protect your water supply from contamination.',
        ),
        array(
            'title' => 'Sewer Line Inspection',
            'content' => 'Our comprehensive sewer line inspection combines advanced camera technology with professional expertise to assess the condition of your sewer pipes. We identify blockages, tree root intrusions, cracks, collapses, and offset joints. Each inspection includes a detailed report of findings with video evidence, allowing for informed decisions about necessary repairs or maintenance.',
            'category' => array($plumbing_cat->term_id, $emergency_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Thorough sewer line inspections using advanced camera technology to identify blockages, damage, and other issues throughout your sewer system.',
        ),
        array(
            'title' => 'Smoke Tests',
            'content' => 'Our smoke testing service locates leaks, breaks, and improper connections in sewer systems and drain lines. Non-toxic, odorless smoke is introduced into the system, which then escapes through defects, making them easy to identify. This is an effective method for finding sources of odors, locating cross-connections, and identifying infiltration points without excavation or extensive camera work.',
            'category' => array($plumbing_cat->term_id, $specialty_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Non-invasive smoke testing to locate leaks, breaks, and improper connections in sewer systems without excavation.',
        ),
        array(
            'title' => 'Hydro Jetting for Drain Clearing',
            'content' => 'Our hydro jetting service uses high-pressure water to thoroughly clean drains and sewer lines. Unlike traditional snaking, which only creates a hole through blockages, hydro jetting scours pipe walls to remove all debris, grease, scale, and tree roots. This comprehensive cleaning method restores pipes to near-original condition and prevents quick re-occurrence of clogs, making it ideal for both maintenance and severe blockages.',
            'category' => array($plumbing_cat->term_id, $specialty_services_cat->term_id, $emergency_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Powerful high-pressure water jetting to completely clear drains and sewer lines of blockages, grease, scale, and tree roots.',
        ),
        array(
            'title' => 'Drain Line Inspection',
            'content' => 'Our drain line inspection service uses specialized camera equipment to visually examine your home\'s drain pipes. We can locate blockages, identify pipe damage, and detect potential problem areas before they cause backups or leaks. This non-invasive diagnostic approach allows us to pinpoint issues precisely, saving time and minimizing disruption during subsequent repairs.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Video inspection of household drain lines to identify blockages, damage, and potential issues before they cause significant problems.',
        ),
        array(
            'title' => 'Grease Trap Cleaning',
            'content' => 'Our professional grease trap cleaning service helps maintain kitchen drainage systems and comply with local regulations. We provide complete cleaning including removal of fats, oils, and grease (FOG), scraping and washing of baffles and interceptor components, and proper disposal of waste. Regular service prevents backups, eliminates odors, and helps avoid costly emergency services or regulatory fines.',
            'category' => array($plumbing_cat->term_id, $commercial_cat->term_id, $commercial_plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Thorough cleaning of commercial grease traps to prevent drainage issues, eliminate odors, and ensure regulatory compliance.',
        ),
        array(
            'title' => 'Storm Drain Clearing',
            'content' => 'Our storm drain clearing service prevents flooding and water damage to your property. We use specialized equipment to remove leaves, sediment, debris, and other blockages from storm drains, catch basins, and drainage systems. Regular maintenance helps prevent costly water damage and extends the life of your drainage infrastructure. We also offer preventative maintenance programs for commercial properties.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete cleaning of storm drains and catch basins to prevent flooding and protect your property from water damage.',
        ),
        array(
            'title' => 'Main Line Cleanout Installation',
            'content' => 'Our main line cleanout installation service provides easy access for future maintenance and emergency clearing of your main sewer line. We handle the entire process including location planning, excavation, pipe cutting, cleanout installation, and surface restoration. A properly installed cleanout saves time and money during future sewer service by eliminating the need to remove toilets or access roof vents.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Installation of main line cleanouts to provide convenient access for maintenance and emergency service of your main sewer line.',
        ),
        array(
            'title' => 'Gas Line Repair',
            'content' => 'Our gas line repair service ensures the safety and functionality of your home\'s natural gas or propane system. Our licensed technicians can locate and repair leaks, replace corroded pipes, update outdated materials, and install new gas lines for appliances or additions. We follow all safety protocols and local building codes, conducting pressure testing after all repairs to verify system integrity.',
            'category' => array($plumbing_cat->term_id, $emergency_services_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional repair and replacement of gas lines with comprehensive safety testing and code compliance for residential and commercial properties.',
        ),
        
        // SEPTIC SERVICES
        array(
            'title' => 'Septic Tank Pumping',
            'content' => 'Regular septic tank pumping is essential for maintaining your septic system. Our comprehensive pumping service includes inspection of the tank, baffles, and filters. We recommend pumping every 3-5 years depending on household size and usage patterns. Our technicians will provide a detailed report of your system\'s condition.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete septic tank pumping services with thorough inspection of all components to ensure your system functions properly.',
        ),
        array(
            'title' => 'Septic System Installation',
            'content' => 'Our septic system installation service covers everything from permit acquisition to final inspection. We handle site evaluation, system design, excavation, tank placement, drainfield installation, and all connections. We install conventional systems, aerobic treatment units, mound systems, and more, customized to your property\'s needs.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Full-service septic system installation including permits, design, excavation, and complete system setup with final inspection.',
        ),
        array(
            'title' => 'Septic Tank System Compliance and Permitting',
            'content' => 'Our septic system compliance and permitting service helps navigate the complex regulatory requirements for septic systems. We handle all aspects of permitting including site evaluations, system designs, permit applications, regulatory meetings, variance requests when needed, and final inspection coordination. Our expertise ensures your system meets all local, state, and federal regulations while minimizing delays and complications.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete management of septic system permitting and regulatory compliance from initial application through final approval.',
        ),
        array(
            'title' => 'Septic Tank Design and Engineering',
            'content' => 'Our septic tank design and engineering service creates custom septic system solutions for challenging sites and special requirements. Our team of experienced engineers develops detailed specifications considering soil conditions, topography, groundwater, usage demands, and environmental constraints. We provide complete engineered drawings, specifications, and documentation required for permitting and construction of conventional, alternative, and advanced treatment systems.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Expert engineering and design of septic systems for challenging sites or special requirements with complete documentation for permitting.',
        ),
        array(
            'title' => 'Septic Tank Troubleshooting and Diagnostic Services',
            'content' => 'Our septic tank troubleshooting and diagnostic service identifies the root cause of septic system problems using advanced techniques including camera inspections, dye testing, hydraulic load testing, and electronic locating. Our systematic approach pinpoints issues such as clogs, leaks, drainage failures, or component malfunctions without unnecessary excavation. You\'ll receive a detailed explanation of findings and clear recommendations for the most cost-effective solutions.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Comprehensive diagnostic services to identify septic system issues using advanced techniques and technology with clear recommendations for repair.',
        ),
        array(
            'title' => 'Septic Tank System Upgrades',
            'content' => 'Our septic system upgrade service enhances existing systems to improve performance, increase capacity, or add advanced treatment capabilities. Upgrades may include adding effluent filters, installing risers for easier access, retrofitting with aerobic treatment units, adding pump chambers, or expanding drainfields. Our team evaluates your current system and recommends targeted improvements to extend system life and enhance performance without full replacement when possible.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Strategic upgrades to existing septic systems to improve performance, increase capacity, and extend system lifespan.',
        ),
        array(
            'title' => 'Septic Tank Maintenance and Care',
            'content' => 'Our septic system maintenance program helps prevent costly failures and extends the life of your system. Regular maintenance includes tank inspection, effluent filter cleaning, riser and lid checks, pump and alarm testing for advanced systems, and drainfield evaluation. We offer scheduled maintenance plans customized to your system type and usage patterns, including detailed documentation of services performed and system condition.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Preventative maintenance programs to extend septic system life and avoid costly failures through regular professional care.',
        ),
        array(
            'title' => 'Septic Tank Repair and Replacement',
            'content' => 'Our septic tank repair and replacement service addresses damaged, deteriorated, or failed septic tanks. Whether you need baffle repairs, lid replacement, leak sealing, or complete tank replacement, our experienced team handles the entire process. We manage everything from excavation and old tank removal to new tank installation and system reconnection, with minimal disruption to your property and daily activities.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Expert repair or replacement of damaged septic tanks with comprehensive service from excavation through system reconnection.',
        ),
        array(
            'title' => 'Septic Tank Inspection and Assessment',
            'content' => 'Our septic tank inspection and assessment service provides a comprehensive evaluation of your septic system\'s condition and performance. Inspections include tank condition assessment, baffle and outlet tee examination, sludge and scum level measurement, drainfield evaluation, and distribution box inspection where accessible. This service is ideal for property transfers, identifying maintenance needs, or diagnosing early signs of problems before they cause system failure.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Thorough inspection and assessment of septic systems for property transfers, maintenance planning, or early problem detection.',
        ),
        array(
            'title' => 'Septic Tank Cleaning and Pumping',
            'content' => 'Our septic tank cleaning and pumping service removes accumulated solids, scum, and sludge from your septic tank to prevent system failure and extend its life. Our comprehensive service includes locating the tank, excavating to access lids if necessary, complete pumping of all compartments, inspection of tank interior, baffles, and outlet tees, plus a detailed condition report with recommendations for future maintenance.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional septic tank cleaning and pumping with detailed inspection to maintain system function and prevent costly failures.',
        ),
        array(
            'title' => 'Video Inspections',
            'content' => 'Our video inspection service uses waterproof cameras to examine the interior of septic system components, drain lines, and sewer pipes. This non-invasive technique allows us to inspect baffles, identify blockages, locate breaks or cracks, detect root intrusions, and find misaligned pipes without excavation. You\'ll receive recorded video documentation of findings along with a professional assessment and recommendations.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Advanced camera technology to visually inspect septic components and drainage systems without excavation or disassembly.',
        ),
        array(
            'title' => 'Septic Tank Riser Installation',
            'content' => 'Our septic tank riser installation service brings buried tank access points to the surface for easier maintenance and inspections. We install durable, watertight risers with secure, childproof lids that can be disguised in your landscaping. This improvement eliminates the need for digging to access your tank for pumping or inspections, saving time and money on future maintenance while helping prevent service delays.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Installation of septic tank risers to bring access points to the surface for easier maintenance and reduced service costs.',
        ),
        array(
            'title' => 'Drainfield Repair and Replacement',
            'content' => 'Our drainfield repair and replacement service restores function to failing septic system drainfields. After thorough diagnosis, we offer solutions ranging from targeted repairs and drainfield rejuvenation treatments to complete replacement or installation of alternative dispersal systems. Our team handles all aspects including permitting, excavation, installation of new drainage components, final grading, and system reconnection.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete repair or replacement of failing septic drainfields with options from rejuvenation treatments to full system replacement.',
        ),
        array(
            'title' => 'Septic Tank Alarm Installation',
            'content' => 'Our septic tank alarm installation service adds crucial monitoring to advanced septic systems with pumps or aerobic treatment units. We install reliable alarm systems that alert you to abnormal conditions like high water levels or pump failures before they cause backups or system damage. Our installations include proper electrical connections, weather-resistant components, and instructions on alarm response procedures to help prevent costly emergency situations.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Installation of monitoring alarms for advanced septic systems to provide early warning of potential problems or failures.',
        ),
        array(
            'title' => 'Septic Tank Distribution Box Repair and Replacement',
            'content' => 'Our distribution box repair and replacement service addresses a critical component that ensures even distribution of wastewater to all drainfield lines. We locate and excavate the distribution box, assess its condition, and either repair issues like cracks and settled boxes or replace damaged units. Our technicians ensure proper leveling and sealing during installation to prevent uneven drainfield loading that can lead to system failure.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Expert repair or replacement of septic distribution boxes to ensure even wastewater flow throughout the drainfield system.',
        ),
        array(
            'title' => 'Septic Tank Leach Field Repair and Replacement',
            'content' => 'Our leach field repair and replacement service restores functionality to failing drainfields that show signs of saturation, surfacing effluent, or slow drains. We offer solutions ranging from hydrojetting and targeted repairs to complete replacement with conventional, chamber, or alternative drainfield systems. Our comprehensive service includes necessary permitting, material selection based on soil conditions, proper installation, and final testing to ensure optimal performance.',
            'category' => array($septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Comprehensive repair or replacement of failing septic leach fields with solutions tailored to your site conditions and needs.',
        ),
        array(
            'title' => 'Commercial Plumbing Maintenance',
            'content' => 'Our commercial plumbing maintenance programs help prevent costly emergency repairs and business interruptions. Regular maintenance includes inspection of all plumbing fixtures, water heaters, backflow preventers, and drainage systems. We create customized maintenance schedules based on your facility\'s specific needs and usage patterns.',
            'category' => array($commercial_cat->term_id, $plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Preventative maintenance programs for commercial plumbing systems designed to minimize downtime and extend equipment lifespan.',
        ),
        array(
            'title' => 'Commercial Septic Services',
            'content' => 'Our commercial septic services are designed for businesses, restaurants, retail establishments, and multi-unit properties. We provide system design, installation, pumping, repairs, and ongoing maintenance. Our technicians understand the unique demands placed on commercial septic systems and provide solutions that meet regulatory requirements while handling higher usage loads.',
            'category' => array($commercial_cat->term_id, $septic_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Comprehensive septic services for commercial properties including high-capacity system design, installation, and maintenance.',
        ),
        array(
            'title' => 'Fixture Installation',
            'content' => 'Our professional plumbers can install any type of plumbing fixture in your home, from sinks and toilets to showers and bathtubs. We ensure proper installation with careful attention to detail, preventing leaks and ensuring optimal performance. All installations are performed to code with proper sealing and connections.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional installation of all plumbing fixtures including sinks, toilets, showers, and bathtubs with guaranteed workmanship.',
        ),
        array(
            'title' => 'Pipe Repair and Replacement',
            'content' => 'Our pipe repair and replacement services address damaged, corroded, or leaking pipes throughout your home or business. We work with all pipe materials including copper, PEX, PVC, and galvanized steel. Our experts can spot signs of pipe deterioration before they cause major damage and provide solutions ranging from spot repairs to whole-house repiping.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete pipe repair and replacement services for all types of plumbing systems, fixing leaks, corrosion, and aging infrastructure.',
        ),
        array(
            'title' => 'Leak Detection',
            'content' => 'Our advanced leak detection services use non-invasive methods to locate hidden water leaks in your plumbing system. Using specialized acoustic equipment, thermal imaging, and pressure testing, we can find leaks behind walls, under floors, or in your yard without unnecessary demolition. Early detection prevents water damage and reduces utility bills.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Non-invasive leak detection services using advanced technology to find hidden water leaks without unnecessary demolition.',
        ),
        array(
            'title' => 'Water Line Repair and Installation',
            'content' => 'Our water line services cover everything from repairing leaking or damaged water supply lines to complete replacements and new installations. We handle main water lines connecting to municipal supplies, well systems, and all interior water distribution lines. Our services include trenchless solutions when appropriate to minimize disruption to your property.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Complete water line repair, replacement, and installation services for residential and commercial properties with minimal disruption.',
        ),
        array(
            'title' => 'Water Filtration System Installation',
            'content' => 'Improve your water quality with our professional water filtration system installation services. We offer whole-house systems, point-of-use filters, reverse osmosis systems, and specialized filtration for specific contaminants. Our experts can test your water, recommend the best solution for your needs, and provide professional installation with ongoing maintenance support.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Professional installation of water filtration systems including whole-house filters, reverse osmosis, and specialized contaminant removal systems.',
        ),
        array(
            'title' => 'Tankless Water Heater Installation',
            'content' => 'Our tankless water heater installation services provide an energy-efficient alternative to traditional tank-based systems. These on-demand heaters save space, reduce energy costs, and provide endless hot water. Our certified technicians handle all aspects of installation including gas line modifications, venting, and proper sizing to ensure optimal performance for your household needs.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Energy-efficient tankless water heater installation with professional sizing, gas line modifications, and complete setup for endless hot water.',
        ),
        array(
            'title' => 'Commercial Drain Cleaning',
            'content' => 'Our commercial drain cleaning services address the unique challenges of business plumbing systems. We use industrial-grade equipment for restaurants, hotels, office buildings, and retail establishments. Our preventative maintenance programs help avoid costly emergency situations and business interruptions by keeping your drainage systems flowing properly year-round.',
            'category' => array($plumbing_cat->term_id, $commercial_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Specialized drain cleaning services for commercial properties including restaurants, hotels, and office buildings with preventative maintenance options.',
        ),
        array(
            'title' => 'Trenchless Sewer Line Replacement',
            'content' => 'Our trenchless sewer line replacement service offers minimal disruption to your property while replacing damaged or deteriorated sewer pipes. Using pipe bursting or pipe lining technology, we can install new sewer lines without extensive excavation. This innovative approach saves your landscaping, hardscaping, and driveways while providing a long-lasting solution to sewer line problems.',
            'category' => array($plumbing_cat->term_id),
            'featured_image' => '',
            'excerpt' => 'Minimally invasive trenchless sewer line replacement that preserves your landscape while solving pipe problems permanently.',
        ),
    );
    
    // Create the services
    foreach ($default_services as $service) {
        // Check if the service already exists
        $existing = get_page_by_title($service['title'], OBJECT, 'service');
        
        if (!$existing) {
            // Create post object
            $service_data = array(
                'post_title'    => $service['title'],
                'post_content'  => $service['content'],
                'post_status'   => 'publish',
                'post_type'     => 'service',
                'post_excerpt'  => $service['excerpt'],
            );
            
            // Insert the post into the database
            $service_id = wp_insert_post($service_data);
            
            // Set service category
            if (!empty($service['category'])) {
                wp_set_object_terms($service_id, $service['category'], 'service_category');
            }
            
            // Set featured image if available
            if (!empty($service['featured_image']) && function_exists('media_sideload_image')) {
                $image_id = media_sideload_image($service['featured_image'], $service_id, '', 'id');
                if (!is_wp_error($image_id)) {
                    set_post_thumbnail($service_id, $image_id);
                }
            }
        }
    }
}

/**
 * Create default careers
 */
function wades_create_default_careers() {
    // Create Department Categories
    if (!term_exists('Field Operations', 'department')) {
        wp_insert_term('Field Operations', 'department', array(
            'description' => 'On-site service and installation teams',
            'slug' => 'field-operations'
        ));
    }
    
    if (!term_exists('Customer Service', 'department')) {
        wp_insert_term('Customer Service', 'department', array(
            'description' => 'Customer support and scheduling team',
            'slug' => 'customer-service'
        ));
    }
    
    if (!term_exists('Administration', 'department')) {
        wp_insert_term('Administration', 'department', array(
            'description' => 'Office and administrative support',
            'slug' => 'administration'
        ));
    }
    
    // Create Location Categories
    if (!term_exists('Washington', 'job_location')) {
        wp_insert_term('Washington', 'job_location', array(
            'description' => 'Jobs located in Washington state',
            'slug' => 'washington'
        ));
    }
    
    if (!term_exists('Oregon', 'job_location')) {
        wp_insert_term('Oregon', 'job_location', array(
            'description' => 'Jobs located in Oregon state',
            'slug' => 'oregon'
        ));
    }
    
    // Get term IDs
    $field_ops = get_term_by('slug', 'field-operations', 'department');
    $customer_service = get_term_by('slug', 'customer-service', 'department');
    $admin = get_term_by('slug', 'administration', 'department');
    
    $washington = get_term_by('slug', 'washington', 'job_location');
    $oregon = get_term_by('slug', 'oregon', 'job_location');
    
    // Define default careers
    $default_careers = array(
        array(
            'title' => 'Licensed Plumber',
            'content' => '
<h2>Job Description</h2>
<p>Wade\'s Plumbing & Septic is seeking licensed plumbers to join our growing team. This position involves residential and commercial service work, installations, and repairs.</p>

<h2>Responsibilities</h2>
<ul>
    <li>Diagnose and repair plumbing systems and fixtures</li>
    <li>Install new plumbing systems in residential and commercial settings</li>
    <li>Respond to service calls and emergency situations</li>
    <li>Maintain accurate records of work performed</li>
    <li>Provide estimates for repairs and installations</li>
    <li>Ensure all work meets applicable codes and standards</li>
</ul>

<h2>Requirements</h2>
<ul>
    <li>Valid plumbing license</li>
    <li>Minimum 2 years of experience in residential/commercial plumbing</li>
    <li>Clean driving record</li>
    <li>Strong customer service skills</li>
    <li>Problem-solving abilities and attention to detail</li>
    <li>Ability to work independently and as part of a team</li>
</ul>

<h2>Benefits</h2>
<ul>
    <li>Competitive hourly rate based on experience</li>
    <li>Health, dental, and vision insurance</li>
    <li>401(k) retirement plan with company match</li>
    <li>Paid vacation and holidays</li>
    <li>Company vehicle and fuel card</li>
    <li>Ongoing training and certification opportunities</li>
    <li>Career advancement possibilities</li>
</ul>

<p>Wade\'s Plumbing & Septic is an equal opportunity employer committed to creating an inclusive workplace.</p>

<h2>How to Apply</h2>
<p>Submit your resume and cover letter through our online application form or email support@wadesinc.io.</p>
            ',
            'department' => array($field_ops->term_id),
            'location' => array($washington->term_id),
            'excerpt' => 'Join our team as a licensed plumber performing residential and commercial service work. Minimum 2 years experience required with competitive pay and benefits.',
        ),
        array(
            'title' => 'Septic System Installer',
            'content' => '
<h2>Job Description</h2>
<p>We are looking for experienced septic system installers to help us meet growing demand. This role involves installing new septic systems and repairing existing ones.</p>

<h2>Responsibilities</h2>
<ul>
    <li>Install conventional and alternative septic systems</li>
    <li>Excavate and prepare installation sites</li>
    <li>Repair and replace failing septic system components</li>
    <li>Operate heavy equipment including excavators and backhoes</li>
    <li>Read and interpret septic design plans</li>
    <li>Ensure all installations meet county health department requirements</li>
</ul>

<h2>Requirements</h2>
<ul>
    <li>Minimum 1 year experience in septic installation (preferred)</li>
    <li>Experience operating heavy equipment</li>
    <li>Knowledge of septic system components and function</li>
    <li>Valid driver\'s license with clean driving record</li>
    <li>Ability to perform physical labor in various weather conditions</li>
    <li>Strong attention to detail and commitment to quality</li>
</ul>

<h2>Benefits</h2>
<ul>
    <li>Competitive hourly rate based on experience</li>
    <li>Health, dental, and vision insurance</li>
    <li>401(k) retirement plan with company match</li>
    <li>Paid vacation and holidays</li>
    <li>Ongoing training opportunities</li>
    <li>Career advancement possibilities</li>
</ul>

<p>Wade\'s Plumbing & Septic is an equal opportunity employer committed to creating an inclusive workplace.</p>

<h2>How to Apply</h2>
<p>Submit your resume and cover letter through our online application form or email support@wadesinc.io.</p>
            ',
            'department' => array($field_ops->term_id),
            'location' => array($washington->term_id, $oregon->term_id),
            'excerpt' => 'Experienced septic system installer needed to install and repair septic systems. Heavy equipment operation experience preferred with excellent benefits package.',
        ),
        array(
            'title' => 'Customer Service Representative',
            'content' => '
<h2>Job Description</h2>
<p>Our customer service team is the heart of our company. We\'re looking for friendly, organized individuals to handle customer calls, schedule service appointments, and provide outstanding support to our clients.</p>

<h2>Responsibilities</h2>
<ul>
    <li>Answer incoming calls and respond to customer inquiries</li>
    <li>Schedule service appointments and coordinate with field technicians</li>
    <li>Process service orders and maintain accurate customer records</li>
    <li>Provide information about services and pricing</li>
    <li>Follow up with customers after service completion</li>
    <li>Handle customer concerns and escalate issues when necessary</li>
</ul>

<h2>Requirements</h2>
<ul>
    <li>Previous customer service experience (1+ years preferred)</li>
    <li>Excellent communication and interpersonal skills</li>
    <li>Proficiency with computers and scheduling software</li>
    <li>Strong organizational abilities and attention to detail</li>
    <li>Problem-solving skills and positive attitude</li>
    <li>Ability to multitask in a fast-paced environment</li>
</ul>

<h2>Benefits</h2>
<ul>
    <li>Competitive hourly rate</li>
    <li>Health, dental, and vision insurance</li>
    <li>401(k) retirement plan with company match</li>
    <li>Paid vacation and holidays</li>
    <li>Career advancement opportunities</li>
</ul>

<p>Wade\'s Plumbing & Septic is an equal opportunity employer committed to creating an inclusive workplace. This is a full-time position at our main office location.</p>

<h2>How to Apply</h2>
<p>Submit your resume and cover letter through our online application form or email support@wadesinc.io.</p>
            ',
            'department' => array($customer_service->term_id),
            'location' => array($washington->term_id),
            'excerpt' => 'Join our customer service team handling calls, scheduling appointments, and providing exceptional customer support. Previous customer service experience preferred.',
        ),
    );
    
    // Create the careers
    foreach ($default_careers as $career) {
        // Check if the career already exists
        $existing = get_page_by_title($career['title'], OBJECT, 'career');
        
        if (!$existing) {
            // Create post object
            $career_data = array(
                'post_title'    => $career['title'],
                'post_content'  => $career['content'],
                'post_status'   => 'publish',
                'post_type'     => 'career',
                'post_excerpt'  => $career['excerpt'],
            );
            
            // Insert the post into the database
            $career_id = wp_insert_post($career_data);
            
            // Set career taxonomies
            if (!empty($career['department'])) {
                wp_set_object_terms($career_id, $career['department'], 'department');
            }
            
            if (!empty($career['location'])) {
                wp_set_object_terms($career_id, $career['location'], 'job_location');
            }
        }
    }
}

/**
 * Create default blog categories with descriptions
 */
function wades_create_default_categories() {
    // Create the Plumbing Tips category if it doesn't exist
    if (!term_exists('Plumbing Tips', 'category')) {
        wp_insert_term('Plumbing Tips', 'category', array(
            'description' => 'Professional advice and best practices for all your plumbing needs. Learn from our experts about maintenance, troubleshooting, and when to call for help.',
            'slug' => 'plumbing-tips'
        ));
    }
    
    // Create the Septic Maintenance category if it doesn't exist
    if (!term_exists('Septic Maintenance', 'category')) {
        wp_insert_term('Septic Maintenance', 'category', array(
            'description' => 'Essential information about septic system care, maintenance schedules, warning signs of problems, and how to maximize the lifespan of your system.',
            'slug' => 'septic-maintenance'
        ));
    }
    
    // Create the DIY Projects category if it doesn't exist
    if (!term_exists('DIY Projects', 'category')) {
        wp_insert_term('DIY Projects', 'category', array(
            'description' => 'Step-by-step tutorials for homeowners who want to tackle simple plumbing and septic projects themselves, with safety tips and professional insights.',
            'slug' => 'diy-projects'
        ));
    }
    
    // Create default example posts for each category
    $categories = array(
        'plumbing-tips' => 'Plumbing Tips',
        'septic-maintenance' => 'Septic Maintenance',
        'diy-projects' => 'DIY Projects'
    );
    
    foreach ($categories as $slug => $name) {
        $category = get_term_by('slug', $slug, 'category');
        
        if ($category && !get_posts(array('category' => $category->term_id, 'posts_per_page' => 1))) {
            // Create example posts based on category
            $example_posts = array();
            
            if ($slug === 'plumbing-tips') {
                $example_posts = array(
                    array(
                        'title' => '5 Signs You Need to Call a Professional Plumber',
                        'content' => '
<p>When it comes to plumbing issues, knowing when to call a professional can save you time, money, and prevent major damage to your home. While some minor problems can be handled with DIY solutions, others require expert attention. Here are five clear signs it\'s time to call Wade\'s Plumbing & Septic.</p>

<h2>1. Persistent Low Water Pressure</h2>
<p>If you\'ve noticed consistently low water pressure throughout your home that doesn\'t improve, this could indicate serious problems like hidden leaks, pipe corrosion, or main line issues. A professional plumber can diagnose the root cause and recommend the appropriate solution.</p>

<h2>2. Multiple Clogged Drains</h2>
<p>When several drains in your home are slow or clogged simultaneously, this suggests a problem in your main sewer line rather than individual fixtures. Professional plumbers have specialized equipment like video cameras and hydro-jetters that can locate and clear main line blockages effectively.</p>

<h2>3. Water Heater Issues</h2>
<p>If your water heater is making unusual noises, leaking, or not providing consistent hot water, it\'s time to call a professional. Water heater problems can range from simple thermostat issues to serious problems that could lead to flooding or even explosions if not addressed properly.</p>

<h2>4. Visible Water Damage or Mold</h2>
<p>Water stains on walls or ceilings, warped flooring, or visible mold growth are serious indicators of hidden plumbing leaks. These issues require immediate professional attention to identify the source of the leak and prevent structural damage and health hazards from mold exposure.</p>

<h2>5. Recurring Plumbing Issues</h2>
<p>If you find yourself repeatedly dealing with the same plumbing problem despite attempts to fix it, this indicates there\'s likely a larger underlying issue that DIY methods aren\'t addressing. A professional plumber can provide a comprehensive solution that addresses the root cause.</p>

<h2>When to Call Wade\'s Plumbing & Septic</h2>
<p>Our team of licensed professionals is available 24/7 for emergency services and can handle everything from routine maintenance to complex repairs. Don\'t wait until a minor issue becomes a major problem - contact us at the first sign of these warning indicators.</p>

<p>Remember, proper maintenance is the best way to avoid serious plumbing emergencies. Schedule regular inspections of your home\'s plumbing system to catch potential problems before they require expensive repairs.</p>
',
                        'excerpt' => 'Learn to recognize the warning signs that indicate it\'s time to call a professional plumber instead of attempting DIY repairs. From persistent low water pressure to multiple clogged drains, these symptoms require expert attention.',
                    ),
                    array(
                        'title' => 'How to Prevent Frozen Pipes This Winter',
                        'content' => '
<p>Winter brings the risk of frozen pipes, which can lead to bursts, flooding, and expensive repairs. Preventing frozen pipes is much easier and less costly than dealing with the aftermath of a pipe burst. Here\'s how to protect your home\'s plumbing during cold weather.</p>

<h2>Identify Vulnerable Pipes</h2>
<p>Start by identifying which pipes in your home are most at risk. These typically include:</p>
<ul>
    <li>Pipes in unheated areas like basements, attics, and garages</li>
    <li>Pipes running along exterior walls</li>
    <li>Outdoor spigots and irrigation systems</li>
    <li>Pipes in cabinets under sinks on exterior walls</li>
</ul>

<h2>Insulate Exposed Pipes</h2>
<p>One of the most effective preventative measures is insulating vulnerable pipes:</p>
<ul>
    <li>Use foam pipe insulation sleeves, which are inexpensive and easy to install</li>
    <li>Apply heat tape or thermostatically-controlled heat cables for pipes at high risk</li>
    <li>Seal leaks that allow cold air to enter where pipes are located</li>
    <li>Consider adding insulation to areas like basements and crawl spaces</li>
</ul>

<h2>Maintain Consistent Heat</h2>
<p>Keep your home heated to at least 55°F, even when you\'re away. This consistent temperature helps prevent interior pipes from freezing. If you\'ll be away for an extended period during winter, consider these additional steps:</p>
<ul>
    <li>Ask a friend or neighbor to check your house regularly</li>
    <li>Shut off and drain the water system</li>
    <li>Install a smart thermostat that alerts you to temperature drops</li>
</ul>

<h2>Allow Faucets to Drip</h2>
<p>During extremely cold weather, allow faucets connected to vulnerable pipes to drip slightly. Running water, even at a trickle, helps prevent freezing. Focus on faucets furthest from where water enters your home.</p>

<h2>Keep Cabinet Doors Open</h2>
<p>Open kitchen and bathroom cabinet doors to allow warmer air to circulate around plumbing, especially if sinks are on exterior walls.</p>

<h2>What to Do If Pipes Freeze</h2>
<p>If you turn on a faucet and only a trickle comes out, you likely have a frozen pipe. Some steps to take:</p>
<ul>
    <li>Keep the faucet open as you treat the frozen pipe</li>
    <li>Apply heat to the frozen section using an electric heating pad, hair dryer, or portable space heater (never use open flame devices)</li>
    <li>Continue applying heat until full water pressure is restored</li>
    <li>Check all other faucets for additional frozen pipes</li>
</ul>

<p>If you cannot locate the frozen area, if the frozen area is not accessible, or if you cannot thaw the pipe, call Wade\'s Plumbing & Septic immediately. We provide 24/7 emergency services to help protect your home from water damage.</p>

<p>Taking these preventative measures can save you from the inconvenience and expense of dealing with burst pipes during the coldest months of the year.</p>
',
                        'excerpt' => 'Protect your home from costly water damage with these essential tips for preventing frozen pipes during winter. Learn how to identify vulnerable pipes, properly insulate them, and maintain adequate heating to avoid expensive emergency repairs.',
                    ),
                );
            } elseif ($slug === 'septic-maintenance') {
                $example_posts = array(
                    array(
                        'title' => 'The Complete Guide to Septic System Maintenance',
                        'content' => '
<p>A properly maintained septic system can last 25-30 years or more, while a neglected one may fail in just a few years, leading to expensive repairs or replacement. This comprehensive guide covers everything homeowners need to know about maintaining their septic systems.</p>

<h2>Understanding Your Septic System</h2>
<p>Most residential septic systems consist of two main parts:</p>
<ul>
    <li><strong>Septic Tank:</strong> A buried, watertight container where solids settle and begin to break down</li>
    <li><strong>Drainfield:</strong> A shallow, covered area where pretreated wastewater filters into the soil</li>
</ul>

<p>Knowing the location, size, and type of your system is essential for proper maintenance. If you don\'t have this information, our team can help locate your system components and provide detailed documentation.</p>

<h2>Regular Pumping Schedule</h2>
<p>The most important maintenance task is regular pumping of your septic tank. The frequency depends on:</p>
<ul>
    <li>Household size</li>
    <li>Tank size</li>
    <li>Volume of wastewater generated</li>
    <li>Amount of solids in wastewater</li>
</ul>

<p>For most households, pumping every 3-5 years is recommended. However, homes with garbage disposals, water softeners, or many occupants may need more frequent pumping. During pumping, a professional should inspect the tank, baffles, and effluent filter.</p>

<h2>Water Conservation</h2>
<p>Reducing water use helps prevent system overload:</p>
<ul>
    <li>Fix leaky faucets and running toilets promptly</li>
    <li>Install high-efficiency toilets, faucets, and showerheads</li>
    <li>Spread laundry loads throughout the week</li>
    <li>Run dishwashers and washing machines only when full</li>
    <li>Consider installing a water softener that recharges based on water usage rather than a timer</li>
</ul>

<h2>Proper Waste Disposal</h2>
<p>What goes down your drains affects your septic system. Avoid flushing or draining:</p>
<ul>
    <li>Cooking grease or oil</li>
    <li>"Flushable" wipes (which don\'t break down properly)</li>
    <li>Paper towels, feminine hygiene products, or diapers</li>
    <li>Coffee grounds, eggshells, or other food waste</li>
    <li>Household chemicals, paints, or solvents</li>
    <li>Pharmaceuticals</li>
</ul>

<h2>Drainfield Protection</h2>
<p>To maintain a healthy drainfield:</p>
<ul>
    <li>Never park or drive over the drainfield</li>
    <li>Don\'t plant trees or shrubs with aggressive roots near the drainfield</li>
    <li>Direct roof drains, sump pumps, and other rainwater drainage away from the drainfield</li>
    <li>Maintain a grass cover over the drainfield to prevent erosion</li>
</ul>

<h2>Warning Signs of Problems</h2>
<p>Contact us immediately if you notice:</p>
<ul>
    <li>Slow drains or backups</li>
    <li>Gurgling sounds in the plumbing</li>
    <li>Sewage odors inside or outside</li>
    <li>Wet, spongy ground around the septic tank or drainfield</li>
    <li>Lush, green grass over the drainfield when the rest of the lawn is dry</li>
    <li>High levels of nitrates or bacteria in well water tests</li>
</ul>

<h2>Professional Inspections</h2>
<p>We recommend professional inspections:</p>
<ul>
    <li>Every 1-3 years for systems with mechanical components or pumps</li>
    <li>Every 3-5 years for conventional systems during pumping</li>
</ul>

<p>Our technicians use specialized equipment to thoroughly assess all components of your septic system and can identify potential issues before they become serious problems.</p>

<h2>Schedule Your Maintenance Today</h2>
<p>Regular maintenance is far less expensive than repairing or replacing a failed septic system. Contact Wade\'s Plumbing & Septic to schedule your professional septic system inspection and pumping. Our experienced technicians will ensure your system continues to function properly for years to come.</p>
',
                        'excerpt' => 'Learn how to properly maintain your septic system to maximize its lifespan and avoid costly repairs. This comprehensive guide covers pumping schedules, water conservation, proper waste disposal, and warning signs of potential problems.',
                    ),
                    array(
                        'title' => 'Why You Should Never Ignore Septic System Warning Signs',
                        'content' => '
<p>Your septic system works silently until something goes wrong. Unfortunately, many homeowners ignore the early warning signs of septic problems, leading to much more expensive repairs and potential environmental hazards. Understanding and responding to these warning signs promptly can save you thousands of dollars and protect your property value.</p>

<h2>Early Warning Signs You Shouldn\'t Ignore</h2>

<h3>1. Slow Drains Throughout Your Home</h3>
<p>When multiple drains in your home begin draining slowly, particularly if this affects toilets and floor drains, it\'s often a sign that your septic system is reaching capacity or experiencing blockages. This isn\'t something that will resolve itself - it typically worsens over time until a complete backup occurs.</p>

<h3>2. Gurgling Sounds in Plumbing</h3>
<p>Strange gurgling noises from drains, toilets, or pipes can indicate that air is trapped in your septic system due to blockages or that your tank is overfilled. These sounds occur when wastewater is struggling to flow properly through the system.</p>

<h3>3. Sewage Odors</h3>
<p>Foul odors around your drainfield, near your tank, or even inside your home are never normal. These smells indicate that waste isn\'t being properly treated or contained and may be escaping from your system. Beyond being unpleasant, these odors can signal serious health hazards.</p>

<h3>4. Unusually Lush or Green Grass</h3>
<p>While it might seem like a good thing, a patch of very green, lush grass over your drainfield when the rest of your lawn is less vibrant is a classic sign of a leaking septic system. The effluent acts as a fertilizer, creating this distinctive growth pattern.</p>

<h3>5. Standing Water or Soggy Areas</h3>
<p>Pools of water or consistently soggy ground around your septic tank or drainfield, especially during dry weather, typically indicate that your system is releasing effluent before it\'s been properly treated.</p>

<h2>The Consequences of Delaying Action</h2>

<h3>System Failure and Expensive Repairs</h3>
<p>Minor issues inevitably progress to complete system failure if left unaddressed. What might have been a simple repair can quickly escalate to needing a full system replacement - transforming a few hundred dollar repair into a $10,000+ project.</p>

<h3>Property Damage</h3>
<p>Sewage backups into your home can damage flooring, walls, furniture, and personal belongings. The costs of cleanup and restoration after sewage contamination can be substantial, and standard homeowner\'s insurance policies often don\'t cover damage from septic failures.</p>

<h3>Health Risks</h3>
<p>Failing septic systems release improperly treated wastewater containing harmful bacteria, viruses, and pathogens. This creates significant health risks for your family and neighbors, potentially contaminating groundwater and nearby wells.</p>

<h3>Environmental Impact</h3>
<p>Leaking septic systems contribute to the pollution of local waterways, harming wildlife and plant ecosystems. Many areas now impose substantial fines for environmental contamination from neglected septic systems.</p>

<h3>Property Value Reduction</h3>
<p>A failing septic system can dramatically reduce your property value and complicate selling your home. Many jurisdictions require septic inspections during property transfers, and problems discovered during this process can delay or derail sales.</p>

<h2>Take Action Now</h2>
<p>If you\'ve noticed any of these warning signs, don\'t wait for the problem to worsen. Contact Wade\'s Plumbing & Septic for a thorough inspection. Our certified technicians can:</p>
<ul>
    <li>Accurately diagnose the specific issue affecting your system</li>
    <li>Provide clear, upfront pricing for necessary repairs</li>
    <li>Recommend preventative maintenance to avoid future problems</li>
    <li>Complete repairs efficiently with minimal disruption to your property</li>
</ul>

<p>Remember, addressing septic issues early is always less expensive and less disruptive than waiting for complete system failure. Schedule your inspection today and protect your home, health, and property value.</p>
',
                        'excerpt' => 'Learn to recognize the critical warning signs of septic system problems and why addressing them promptly can save you thousands in repairs. From slow drains to unusual odors, these symptoms require immediate professional attention.',
                    ),
                );
            } elseif ($slug === 'diy-projects') {
                $example_posts = array(
                    array(
                        'title' => 'How to Properly Clear a Clogged Drain: A Step-by-Step Guide',
                        'content' => '
<p>Clogged drains are one of the most common household plumbing issues. While severe clogs may require professional help, many can be cleared with the right approach and tools. This guide will walk you through safe and effective methods to clear different types of clogged drains.</p>

<h2>Before You Start: Safety First</h2>
<p>Always prioritize safety when attempting any plumbing repair:</p>
<ul>
    <li>Wear rubber gloves to protect your hands from chemicals and bacteria</li>
    <li>Use eye protection when using plungers, augers, or chemical cleaners</li>
    <li>Never mix different drain cleaners - this can create dangerous chemical reactions</li>
    <li>Always read and follow manufacturer instructions for any products used</li>
</ul>

<h2>Method 1: The Plunger Technique</h2>
<p>A plunger is often the first and simplest solution for many clogs. For best results:</p>

<h3>What You\'ll Need:</h3>
<ul>
    <li>Cup plunger (for sinks, tubs, and showers)</li>
    <li>Flange plunger (for toilets)</li>
    <li>Towels</li>
    <li>Petroleum jelly (optional)</li>
</ul>

<h3>Steps:</h3>
<ol>
    <li>For sinks with overflow openings, cover the overflow with a damp cloth to create better suction</li>
    <li>For double sinks, seal the second drain with a stopper or wet cloth</li>
    <li>Ensure there\'s enough water in the fixture to cover the plunger cup (add water if needed)</li>
    <li>Apply a thin layer of petroleum jelly to the rim of the plunger for better seal (optional)</li>
    <li>Position the plunger completely over the drain</li>
    <li>Plunge vigorously with vertical strokes 5-6 times, maintaining the seal</li>
    <li>Pull up sharply to break the clog</li>
    <li>Repeat several times if necessary</li>
    <li>Run hot water down the drain to confirm it\'s clear</li>
</ol>

<h2>Method 2: Natural Drain Cleaners</h2>
<p>Before turning to harsh chemicals, try these natural alternatives that are safer for your pipes and the environment:</p>

<h3>Boiling Water Method:</h3>
<p>This works best for grease clogs in kitchen sinks:</p>
<ol>
    <li>Bring half a gallon of water to a rolling boil</li>
    <li>Carefully pour the boiling water directly down the drain in 2-3 stages</li>
    <li>Allow the hot water to work for a few minutes between each pour</li>
</ol>
<p><strong>Important:</strong> Do not use boiling water if you have PVC pipes, as it could damage them. Also avoid this method for toilets as it could crack the porcelain.</p>

<h3>Baking Soda and Vinegar Method:</h3>
<ol>
    <li>Pour 1/2 cup of baking soda down the drain</li>
    <li>Follow with 1/2 cup of white vinegar</li>
    <li>Immediately cover the drain with a plug or cloth for 5-10 minutes</li>
    <li>Pour a kettle of hot (not boiling) water down the drain</li>
</ol>

<h2>Method 3: Manual Removal</h2>
<p>For visible clogs near the drain opening:</p>

<h3>What You\'ll Need:</h3>
<ul>
    <li>Flashlight</li>
    <li>Screwdriver (to remove drain covers)</li>
    <li>Needle-nose pliers or tweezers</li>
    <li>Wire coat hanger</li>
    <li>Bucket (for under sink work)</li>
</ul>

<h3>Steps:</h3>
<ol>
    <li>Remove any visible drain covers or stoppers</li>
    <li>Use the flashlight to inspect for visible blockages</li>
    <li>Use pliers or tweezers to remove any visible debris</li>
    <li>For hair clogs just out of reach, straighten a wire coat hanger leaving a small hook at one end</li>
    <li>Insert the hook and carefully pull out hair and debris</li>
    <li>Run hot water to clear any remaining residue</li>
</ol>

<h2>Method 4: Drain Snake (Auger)</h2>
<p>For more stubborn clogs deeper in the pipes:</p>

<h3>What You\'ll Need:</h3>
<ul>
    <li>Hand-cranked drain snake (available at hardware stores)</li>
    <li>Bucket and towels</li>
    <li>Rubber gloves</li>
</ul>

<h3>Steps:</h3>
<ol>
    <li>Insert the end of the snake into the drain opening</li>
    <li>Turn the crank clockwise to extend the snake into the pipe</li>
    <li>When you feel resistance (the clog), continue cranking while pushing gently</li>
    <li>Rotate the snake to hook onto the obstruction</li>
    <li>Once engaged with the clog, crank counterclockwise while pulling out to retrieve the debris</li>
    <li>Repeat if necessary until the drain flows freely</li>
    <li>Run hot water for several minutes to clear any remaining debris</li>
</ol>

<h2>When to Call Wade\'s Plumbing & Septic</h2>
<p>While many clogs can be cleared with DIY methods, some situations require professional assistance:</p>
<ul>
    <li>Multiple fixtures are backing up simultaneously</li>
    <li>You\'ve tried multiple methods without success</li>
    <li>Clogs recur frequently in the same drain</li>
    <li>You hear gurgling in multiple drains</li>
    <li>There are foul odors coming from drains even after clearing</li>
    <li>Your home has older pipes that might be damaged</li>
</ul>

<p>Our professional plumbers have specialized equipment like video cameras and high-pressure water jetters that can resolve even the most stubborn clogs without damaging your plumbing system. For persistent or complex drain issues, contact Wade\'s Plumbing & Septic for prompt, professional service.</p>
',
                        'excerpt' => 'Learn how to effectively clear clogged drains using various DIY methods, from simple plunging techniques to natural cleaners. This comprehensive guide helps you tackle common household clogs safely and effectively before calling a professional.',
                    ),
                    array(
                        'title' => 'How to Install a New Bathroom Faucet: A Weekend DIY Project',
                        'content' => '
<p>Replacing an old or outdated bathroom faucet is a relatively simple DIY project that can dramatically improve the look and functionality of your bathroom. With basic tools and a few hours of time, you can install a new faucet and save on plumbing service costs. This guide walks you through the process step by step.</p>

<h2>Tools and Materials You\'ll Need</h2>
<ul>
    <li>New bathroom faucet kit</li>
    <li>Adjustable wrench</li>
    <li>Basin wrench or channel-lock pliers</li>
    <li>Bucket or small container</li>
    <li>Towels or rags</li>
    <li>Plumber\'s putty or silicone caulk</li>
    <li>Teflon tape</li>
    <li>Flashlight</li>
    <li>Safety glasses</li>
    <li>Penetrating oil (like WD-40) for stubborn nuts</li>
</ul>

<h2>Before You Begin</h2>
<ol>
    <li><strong>Purchase the right faucet:</strong> Ensure your new faucet matches your sink\'s hole configuration (single-hole, 4" centerset, or 8" widespread)</li>
    <li><strong>Turn off the water:</strong> Locate the water shut-off valves under the sink and turn them clockwise to shut off both hot and cold water</li>
    <li><strong>Open the faucet:</strong> Turn on the faucet to release pressure and drain remaining water</li>
    <li><strong>Clear space:</strong> Remove items from under the sink to give yourself room to work</li>
</ol>

<h2>Step 1: Remove the Old Faucet</h2>
<ol>
    <li>Place a bucket under the water lines to catch any remaining water</li>
    <li>Disconnect the water supply lines from the faucet by unscrewing the nuts connecting them (use the adjustable wrench)</li>
    <li>Locate the mounting nuts that secure the faucet to the sink - these are usually located underneath the sink and might require a basin wrench to reach</li>
    <li>Unscrew and remove these mounting nuts</li>
    <li>Lift the old faucet from above the sink - you may need to wiggle it a bit if caulk or mineral deposits are holding it in place</li>
    <li>Clean the sink surface thoroughly, removing any old putty, caulk, or debris</li>
</ol>

<h2>Step 2: Prepare the New Faucet</h2>
<ol>
    <li>Unpack your new faucet and review the manufacturer\'s instructions</li>
    <li>Assemble any parts that need to be attached to the faucet before installation (this varies by model)</li>
    <li>If your faucet uses a gasket, attach it to the bottom of the faucet base</li>
    <li>If your faucet requires plumber\'s putty instead of a gasket:
        <ul>
            <li>Roll a small amount of plumber\'s putty between your hands to form a thin "rope"</li>
            <li>Apply it in a circle around the base of the faucet where it will contact the sink</li>
        </ul>
    </li>
</ol>

<h2>Step 3: Install the New Faucet</h2>
<ol>
    <li>Feed the faucet\'s supply lines and mounting hardware through the holes in the sink</li>
    <li>Position the faucet so it\'s straight and centered</li>
    <li>From underneath, secure the faucet by screwing on the mounting nuts - tighten by hand first, then use a wrench for the final tightening, but be careful not to overtighten</li>
    <li>Wipe away any excess putty that squeezed out from under the faucet</li>
</ol>

<h2>Step 4: Connect the Water Supply Lines</h2>
<ol>
    <li>Wrap the threaded ends of the water supply lines with 2-3 turns of Teflon tape (wrap clockwise in the direction of the threading)</li>
    <li>Connect the supply lines to the shut-off valves (hot to hot, cold to cold)
        <ul>
            <li>Hand-tighten first</li>
            <li>Then give an additional quarter to half turn with a wrench</li>
            <li>Be careful not to overtighten, which can damage the fittings</li>
        </ul>
    </li>
</ol>

<h2>Step 5: Install the Drain Assembly (if included)</h2>
<p>Many new faucets come with a matching drain assembly. If yours does:</p>
<ol>
    <li>Remove the old drain by unscrewing the P-trap and the mounting nut connecting the drain to the sink</li>
    <li>Apply plumber\'s putty under the flange of the new drain</li>
    <li>Insert the new drain assembly from above the sink</li>
    <li>From below, attach and tighten the gasket, washer, and mounting nut</li>
    <li>Reconnect the P-trap to the new drain tail piece</li>
</ol>

<h2>Step 6: Test for Leaks</h2>
<ol>
    <li>Turn the water supply back on by turning the shut-off valves counterclockwise</li>
    <li>Turn on the faucet and check for leaks:
        <ul>
            <li>Check all connections - under the sink, around the base of the faucet, and at the drain</li>
            <li>Look for any dripping or moisture</li>
            <li>If you find leaks, turn off the water and tighten the connections slightly</li>
        </ul>
    </li>
    <li>Run both hot and cold water to ensure proper operation</li>
    <li>Test the drain by filling the sink and then draining it while checking for leaks</li>
</ol>

<h2>Troubleshooting Common Issues</h2>
<ul>
    <li><strong>Leaking from connection points:</strong> Usually requires tightening or reapplying Teflon tape</li>
    <li><strong>Leaking from faucet base:</strong> May need more plumber\'s putty or tightening of mounting nuts</li>
    <li><strong>Low water pressure:</strong> Check if aerator is clogged or supply valves aren\'t fully open</li>
    <li><strong>Handles not aligned:</strong> Most handles can be removed and repositioned without affecting function</li>
</ul>

<h2>When to Call a Professional</h2>
<p>While faucet installation is generally DIY-friendly, consider calling Wade\'s Plumbing & Septic if:</p>
<ul>
    <li>You discover corroded or damaged pipes that need replacement</li>
    <li>You need to modify your plumbing to accommodate the new faucet</li>
    <li>You encounter persistent leaks that you can\'t resolve</li>
    <li>Your home has complex plumbing or non-standard installations</li>
</ul>

<p>Installing a new bathroom faucet is a satisfying DIY project that most homeowners can complete in 2-3 hours. With proper installation, your new faucet should provide years of reliable service while enhancing your bathroom\'s appearance.</p>
',
                        'excerpt' => 'Transform your bathroom with this easy-to-follow guide for replacing an outdated faucet. Learn how to select the right replacement, remove your old fixture, and install a new one properly with basic tools in just a few hours.',
                    ),
                );
            }
            
            // Create the example posts
            foreach ($example_posts as $post) {
                wp_insert_post(array(
                    'post_title'    => $post['title'],
                    'post_content'  => $post['content'],
                    'post_status'   => 'publish',
                    'post_type'     => 'post',
                    'post_excerpt'  => $post['excerpt'],
                    'post_category' => array($category->term_id)
                ));
            }
        }
    }
}

/**
 * Create default pages based on header navigation
 */
function wades_create_default_pages() {
    // Service Pages
    create_page_if_not_exists('Services', 'services', '
        <h1>Plumbing & Septic Services</h1>
        <p>Wade\'s Plumbing & Septic offers comprehensive plumbing and septic solutions for residential and commercial properties. Our experienced team provides reliable service with a customer-first approach.</p>
        
        <h2>Plumbing Services</h2>
        <p>From emergency repairs to routine maintenance, our skilled plumbers handle all your plumbing needs with expertise and professionalism.</p>
        <ul>
            <li>Emergency Repairs</li>
            <li>Leak Detection & Repair</li>
            <li>Drain Cleaning</li>
            <li>Water Heater Services</li>
            <li>Fixture Installation</li>
            <li>Pipe Replacement</li>
        </ul>
        
        <h2>Septic Services</h2>
        <p>Keep your septic system functioning efficiently with our complete range of septic services, from installation to maintenance.</p>
        <ul>
            <li>Septic Tank Installation</li>
            <li>Septic Tank Pumping</li>
            <li>System Repairs</li>
            <li>Inspections</li>
            <li>Advanced Treatment Systems</li>
        </ul>
        
        <h2>Commercial Services</h2>
        <p>Our commercial plumbing and septic solutions help businesses maintain operations with minimal disruption.</p>
        <ul>
            <li>Commercial Plumbing</li>
            <li>Restaurant Services</li>
            <li>Office Building Systems</li>
            <li>Industrial Plumbing</li>
            <li>Commercial Septic</li>
            <li>Preventative Maintenance</li>
        </ul>
        
        <h2>Schedule Service Today</h2>
        <p>Contact our team for reliable plumbing and septic services. We offer upfront pricing, experienced technicians, and guaranteed workmanship.</p>
    ');
    
    // Plumbing Service Pages
    create_page_if_not_exists('Plumbing Services', 'services/plumbing', '
        <h1>Professional Plumbing Services</h1>
        <p>Wade\'s Plumbing & Septic delivers expert plumbing services for all your residential and commercial needs. Our licensed and experienced plumbers provide reliable solutions with quality workmanship.</p>
        
        <h2>Our Plumbing Services Include:</h2>
        <ul>
            <li>Emergency repairs</li>
            <li>Leak detection and repair</li>
            <li>Drain cleaning and unclogging</li>
            <li>Water heater services</li>
            <li>Fixture installation and repair</li>
            <li>Pipe replacement and repiping</li>
        </ul>
        
        <p>Whether you\'re facing a plumbing emergency or planning a renovation, our team has the skills and equipment to handle your project with professionalism and efficiency.</p>
    ');

    create_page_if_not_exists('Emergency Plumbing Repairs', 'services/plumbing/emergency-repairs', '
        <h1>24/7 Emergency Plumbing Repairs</h1>
        <p>Plumbing emergencies don\'t wait for convenient hours, and neither do we. Wade\'s Plumbing & Septic offers 24/7 emergency plumbing services to address unexpected issues promptly.</p>
        
        <h2>Our Emergency Services Include:</h2>
        <ul>
            <li>Burst pipe repairs</li>
            <li>Major leaks and flooding</li>
            <li>Sewer backups</li>
            <li>Water heater failures</li>
            <li>Toilet overflows</li>
            <li>Gas line emergencies</li>
        </ul>
        
        <p>When you call our emergency line, a qualified plumber will respond quickly to minimize damage to your property and restore your plumbing system.</p>
    ');

    create_page_if_not_exists('Leak Detection & Repair', 'services/plumbing/leak-detection', '
        <h1>Precise Leak Detection & Repair</h1>
        <p>Undetected leaks can cause significant damage to your property and lead to high water bills. Our advanced leak detection services locate hidden leaks quickly and accurately.</p>
        
        <h2>Our Leak Detection Process:</h2>
        <ul>
            <li>Non-invasive electronic leak detection</li>
            <li>Thermal imaging technology</li>
            <li>Video camera inspections</li>
            <li>Pressure testing</li>
            <li>Precise location identification</li>
            <li>Efficient repair solutions</li>
        </ul>
        
        <p>Our technicians can detect leaks in walls, floors, ceilings, and underground pipes with minimal disruption to your property.</p>
    ');

    // Septic Service Pages
    create_page_if_not_exists('Septic Services', 'services/septic', '
        <h1>Complete Septic System Services</h1>
        <p>Wade\'s Plumbing & Septic provides comprehensive septic system services to keep your system functioning efficiently. From installation to maintenance, our experienced team delivers reliable solutions.</p>
        
        <h2>Our Septic Services Include:</h2>
        <ul>
            <li>Septic tank installation</li>
            <li>Regular pumping and maintenance</li>
            <li>System repairs and troubleshooting</li>
            <li>Inspections and evaluations</li>
            <li>Advanced treatment systems</li>
            <li>Commercial septic services</li>
        </ul>
        
        <p>With our expertise in septic systems, we ensure your system operates efficiently, preventing costly failures and protecting the environment.</p>
    ');

    create_page_if_not_exists('Septic Tank Pumping', 'services/septic/pumping', '
        <h1>Professional Septic Tank Pumping</h1>
        <p>Regular septic tank pumping is essential for maintaining a healthy septic system. Wade\'s Plumbing & Septic provides thorough pumping services to prevent backups and system failures.</p>
        
        <h2>Our Pumping Service Includes:</h2>
        <ul>
            <li>Complete tank evacuation</li>
            <li>Inspection of tank components</li>
            <li>Baffle and filter cleaning</li>
            <li>System evaluation</li>
            <li>Documentation for records</li>
            <li>Maintenance recommendations</li>
        </ul>
        
        <p>We recommend pumping every 3-5 years, depending on household size and usage patterns. Our technicians will help you establish an appropriate maintenance schedule.</p>
    ');

    // Commercial Service Pages
    create_page_if_not_exists('Commercial Services', 'services/commercial', '
        <h1>Commercial Plumbing & Septic Solutions</h1>
        <p>Wade\'s Plumbing & Septic offers specialized services for businesses, understanding that plumbing issues can impact your operations and bottom line. Our commercial services minimize disruption while maintaining code compliance.</p>
        
        <h2>Commercial Solutions We Provide:</h2>
        <ul>
            <li>Commercial plumbing systems</li>
            <li>Restaurant plumbing</li>
            <li>Office building systems</li>
            <li>Industrial plumbing</li>
            <li>Commercial septic systems</li>
            <li>Preventative maintenance programs</li>
        </ul>
        
        <p>Our team works efficiently to address your commercial plumbing and septic needs with minimal impact on your daily operations.</p>
    ');

    // About Pages
    create_page_if_not_exists('About Us', 'about-us', '
        <h1>About Wade\'s Plumbing & Septic</h1>
        <p>Wade\'s Plumbing & Septic is a family-owned and operated business delivering reliable plumbing and septic solutions since 2005. We\'ve built our reputation on quality workmanship, honest recommendations, and exceptional customer service.</p>
        
        <h2>Our Mission</h2>
        <p>To provide dependable, high-quality plumbing and septic services that exceed customer expectations while maintaining the highest standards of integrity and professionalism.</p>
        
        <h2>Our Values</h2>
        <ul>
            <li><strong>Integrity:</strong> We always provide honest assessments and fair pricing.</li>
            <li><strong>Quality:</strong> We never compromise on the quality of our work.</li>
            <li><strong>Reliability:</strong> When we make a commitment, we honor it.</li>
            <li><strong>Expertise:</strong> Our team receives continuous training to stay current with industry advancements.</li>
            <li><strong>Community:</strong> We\'re proud to support the communities we serve.</li>
        </ul>
        
        <h2>The Wade\'s Difference</h2>
        <p>What sets us apart is our customer-first approach. We listen to your concerns, explain the issues clearly, and provide options that fit your needs and budget. We\'re not just fixing plumbing problems; we\'re building lasting relationships with our customers.</p>
    ');

    create_page_if_not_exists('Meet Our Team', 'team', '
        <h1>Meet Our Expert Team</h1>
        <p>The foundation of Wade\'s Plumbing & Septic is our dedicated team of professionals. Our licensed plumbers and septic specialists bring years of experience and a commitment to excellence to every job.</p>
        
        <h2>Our Leadership</h2>
        <p>Founded by Wade Johnson, our company is led by industry veterans with decades of combined experience. Our management team ensures every project meets our high standards for quality and customer satisfaction.</p>
        
        <h2>Our Technicians</h2>
        <p>All of our technicians are licensed, insured, and receive ongoing training to stay current with the latest techniques and technologies. When you welcome a Wade\'s technician into your home or business, you can expect:</p>
        <ul>
            <li>Professional appearance and conduct</li>
            <li>Clear communication</li>
            <li>Thorough knowledge of plumbing and septic systems</li>
            <li>Respect for your property</li>
            <li>Efficient problem resolution</li>
        </ul>
        
        <h2>Join Our Team</h2>
        <p>We\'re always looking for skilled professionals who share our values and commitment to excellence. Visit our Careers page to learn about current opportunities.</p>
    ');

    // Support Pages
    create_page_if_not_exists('Contact Us', 'contact', '
        <h1>Contact Wade\'s Plumbing & Septic</h1>
        <p>We\'re here to help with all your plumbing and septic needs. Reach out to our team for prompt, professional service.</p>
        
        <h2>Request Service</h2>
        <p>For service requests, questions, or to schedule an appointment, call us or fill out the form below. Our team will respond promptly to address your needs.</p>
        
        <!-- Contact form would be inserted here -->
        
        <h2>Emergency Service</h2>
        <p>For plumbing emergencies, please call our emergency line for immediate assistance. We provide 24/7 emergency service throughout our service areas.</p>
        
        <h2>Our Office</h2>
        <address>
            123 Main Street<br>
            Anytown, USA 12345<br>
            Phone: (555) 123-4567<br>
            Email: support@wadesinc.io
        </address>
        
        <h2>Hours of Operation</h2>
        <p>Monday - Friday: 7:00 AM - 6:00 PM<br>
        Saturday: 8:00 AM - 2:00 PM<br>
        Sunday: Closed (Emergency Services Available)</p>
    ');

    create_page_if_not_exists('FAQ', 'faq', '
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about plumbing, septic systems, and our services. If you don\'t see your question here, please contact us directly.</p>
        
        <h2>General Questions</h2>
        
        <h3>What areas do you service?</h3>
        <p>We proudly serve [list of counties/areas]. If you\'re unsure whether we service your area, please contact us.</p>
        
        <h3>Do you offer emergency services?</h3>
        <p>Yes, we provide 24/7 emergency plumbing and septic services. Call our emergency line for immediate assistance.</p>
        
        <h3>Are your technicians licensed and insured?</h3>
        <p>Yes. In California we hold an active CSLB license with C-36 (Plumbing Contractor) and C-42 (Sanitation System Contractor) classifications. In Georgia we hold a master plumber license. All technicians are insured and receive ongoing training to stay current with codes and industry standards.</p>
        
        <h2>Plumbing Questions</h2>
        
        <h3>How can I prevent frozen pipes?</h3>
        <p>To prevent frozen pipes, insulate exposed pipes, keep cabinet doors open during cold weather, let faucets drip, and maintain a consistent indoor temperature. For more detailed prevention tips, visit our blog.</p>
        
        <h3>What should I do if I have a pipe leak?</h3>
        <p>First, shut off the water supply to that area or at the main valve. Then, call us immediately for professional repair. If safe to do so, place a bucket under the leak to minimize water damage.</p>
        
        <h2>Septic Questions</h2>
        
        <h3>How often should I pump my septic tank?</h3>
        <p>Most residential septic tanks should be pumped every 3-5 years, depending on household size and water usage. We can help you determine the optimal schedule for your system.</p>
        
        <h3>What are signs of septic system problems?</h3>
        <p>Warning signs include slow drains, gurgling sounds in plumbing, sewage odors, wet spots in the yard, unusually lush grass over the drainfield, and backups. If you notice these signs, contact us for an inspection.</p>
    ');

    create_page_if_not_exists('Financing Options', 'financing', '
        <h1>Flexible Financing Options</h1>
        <p>At Wade\'s Plumbing & Septic, we understand that plumbing and septic emergencies can create unexpected financial strain. That\'s why we offer flexible financing options to help you address necessary repairs or replacements without delay.</p>
        
        <h2>Available Financing Plans</h2>
        <p>We partner with reputable financing providers to offer a range of payment plans that can accommodate various budgets and credit situations:</p>
        <ul>
            <li>0% interest plans (for qualified applicants)</li>
            <li>Low monthly payment options</li>
            <li>Extended payment terms</li>
            <li>Quick approval process</li>
        </ul>
        
        <h2>Financing Process</h2>
        <ol>
            <li>Discuss your project with our technician</li>
            <li>Review financing options available for your specific needs</li>
            <li>Complete a simple application</li>
            <li>Receive a quick decision</li>
            <li>Proceed with necessary work upon approval</li>
        </ol>
        
        <h2>Ready to Get Started?</h2>
        <p>Contact us to discuss your plumbing or septic needs and learn more about our current financing options. Our team will guide you through the process and help you find the payment solution that works best for your situation.</p>
    ');

    // Default Policy Pages
    create_page_if_not_exists('Privacy Policy', 'privacy-policy', '
        <h1>Privacy Policy</h1>
        <p>Last updated: [Current Date]</p>
        
        <p>Wade\'s Plumbing & Septic ("we," "us," or "our") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, and safeguard your information when you visit our website or use our services.</p>
        
        <h2>Information We Collect</h2>
        <p>We may collect the following types of information:</p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number, and address when you request services, contact us, or create an account.</li>
            <li><strong>Service Information:</strong> Details about your plumbing or septic system when you request service.</li>
            <li><strong>Payment Information:</strong> Credit card or other payment details when you pay for services (processed securely through our payment processors).</li>
            <li><strong>Usage Information:</strong> How you interact with our website, including pages visited and features used.</li>
            <li><strong>Device Information:</strong> IP address, browser type, and operating system.</li>
        </ul>
        
        <h2>How We Use Your Information</h2>
        <p>We use the information we collect to:</p>
        <ul>
            <li>Provide and improve our services</li>
            <li>Process transactions and send related information</li>
            <li>Respond to your inquiries and requests</li>
            <li>Send service updates and promotional materials</li>
            <li>Maintain and improve our website</li>
            <li>Comply with legal obligations</li>
        </ul>
        
        <h2>Information Sharing</h2>
        <p>We do not sell your personal information. We may share information with:</p>
        <ul>
            <li>Service providers who assist in our operations</li>
            <li>Professional advisors such as lawyers and accountants</li>
            <li>Legal authorities when required by law</li>
            <li>Business partners with your consent</li>
        </ul>
        
        <h2>Your Choices</h2>
        <p>You can:</p>
        <ul>
            <li>Opt-out of marketing communications</li>
            <li>Request access to your personal information</li>
            <li>Request correction or deletion of your information</li>
            <li>Set your browser to refuse cookies</li>
        </ul>
        
        <h2>Security</h2>
        <p>We implement appropriate security measures to protect your personal information. However, no method of transmission over the Internet or electronic storage is 100% secure.</p>
        
        <h2>Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page.</p>
        
        <h2>Contact Us</h2>
        <p>If you have questions about this Privacy Policy, please contact us.</p>
    ');

    create_page_if_not_exists('Terms of Service', 'terms-of-service', '
        <h1>Terms of Service</h1>
        <p>Last updated: [Current Date]</p>
        
        <p>These Terms of Service ("Terms") govern your use of the website and services offered by Wade\'s Plumbing & Septic ("we," "us," or "our"). By accessing our website or using our services, you agree to these Terms.</p>
        
        <h2>Services</h2>
        <p>We provide plumbing and septic services for residential and commercial properties. Our services include installation, repair, maintenance, and emergency response.</p>
        
        <h2>Service Appointments</h2>
        <p>When scheduling service, you agree to:</p>
        <ul>
            <li>Provide accurate information about your plumbing or septic needs</li>
            <li>Ensure an adult (18+) is present during service</li>
            <li>Provide reasonable access to areas requiring service</li>
            <li>Pay for services as agreed</li>
        </ul>
        
        <h2>Payment Terms</h2>
        <p>Payment is due upon completion of service unless other arrangements are made in advance. We accept various payment methods as specified at the time of service.</p>
        
        <h2>Warranties and Guarantees</h2>
        <p>We provide warranties on our workmanship and installed parts as specified at the time of service. Warranty details will be provided in writing for applicable services.</p>
        
        <h2>Limitation of Liability</h2>
        <p>To the maximum extent permitted by law, we shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use or inability to use our services.</p>
        
        <h2>Indemnification</h2>
        <p>You agree to indemnify and hold us harmless from any claims, damages, liabilities, and expenses arising from your use of our services or violation of these Terms.</p>
        
        <h2>Changes to Terms</h2>
        <p>We may modify these Terms at any time. Continued use of our services after changes indicates your acceptance of the revised Terms.</p>
        
        <h2>Governing Law</h2>
        <p>These Terms are governed by the laws of the state where our principal place of business is located, without regard to its conflict of law principles.</p>
        
        <h2>Contact Us</h2>
        <p>If you have questions about these Terms, please contact us.</p>
    ');
    
    // Create additional pages
    wades_create_additional_default_pages();
}

/**
 * Helper function to create a page if it doesn't exist
 */
function create_page_if_not_exists($title, $slug, $content) {
    $page_exists = function_exists('wades_get_page_by_path') ? wades_get_page_by_path($slug) : null;
    if (!$page_exists && function_exists('get_page_by_path')) {
        $page_exists = get_page_by_path($slug, OBJECT, 'page');
    }
    
    if (!$page_exists) {
        wp_insert_post(
            array(
                'post_title'    => $title,
                'post_name'     => $slug,
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_author'   => 1,
            )
        );
    }
}

/**
 * Creates additional default pages from the header navigation
 */
function wades_create_additional_default_pages() {
    // Additional service pages
    create_page_if_not_exists('Drain Cleaning & Unclogging', 'services/plumbing/drain-cleaning', '
        <h1>Professional Drain Cleaning Services</h1>
        <p>Wade\'s Plumbing & Septic provides thorough drain cleaning services to resolve clogs and keep your plumbing system flowing smoothly. Our technicians use professional-grade equipment to clear even the most stubborn blockages.</p>
        
        <h2>Our Drain Cleaning Services Include:</h2>
        <ul>
            <li>Kitchen sink drains</li>
            <li>Bathroom sink and shower drains</li>
            <li>Toilet clogs</li>
            <li>Floor drains</li>
            <li>Main sewer line cleaning</li>
            <li>Preventative maintenance</li>
        </ul>
        
        <p>We identify the root cause of clogs to provide lasting solutions, not temporary fixes. Our equipment can handle tree roots, grease buildup, mineral deposits, and foreign objects.</p>
    ');
    
    create_page_if_not_exists('Water Heater Services', 'services/plumbing/water-heaters', '
        <h1>Complete Water Heater Services</h1>
        <p>Wade\'s Plumbing & Septic provides expert installation, repair, and maintenance for all types of water heaters. Whether you need a new installation or your existing unit requires service, our team delivers reliable solutions.</p>
        
        <h2>Our Water Heater Services:</h2>
        <ul>
            <li>Traditional tank water heater installation</li>
            <li>Tankless water heater installation</li>
            <li>Hybrid and heat pump water heaters</li>
            <li>Repairs for all makes and models</li>
            <li>Maintenance and tune-ups</li>
            <li>Energy efficiency upgrades</li>
        </ul>
        
        <p>We help you select the right water heater for your home\'s needs, considering factors like household size, usage patterns, and energy efficiency goals.</p>
    ');
    
    create_page_if_not_exists('Fixture Installation & Repair', 'services/plumbing/fixture-installation', '
        <h1>Expert Fixture Installation & Repair</h1>
        <p>From faucets to toilets, Wade\'s Plumbing & Septic provides professional installation and repair services for all your plumbing fixtures. Our technicians ensure proper installation for optimal performance and longevity.</p>
        
        <h2>Fixtures We Install & Repair:</h2>
        <ul>
            <li>Kitchen and bathroom faucets</li>
            <li>Toilets and bidets</li>
            <li>Showers and tubs</li>
            <li>Sinks and vanities</li>
            <li>Garbage disposals</li>
            <li>Water filters and softeners</li>
        </ul>
        
        <p>We work with fixtures from all major manufacturers and can help you select quality products that match your style preferences and budget requirements.</p>
    ');
    
    create_page_if_not_exists('Pipe Replacement & Repiping', 'services/plumbing/pipe-replacement', '
        <h1>Comprehensive Pipe Replacement & Repiping</h1>
        <p>Wade\'s Plumbing & Septic provides expert pipe replacement and whole-house repiping services. When repairs aren\'t enough, our team can replace your outdated or damaged plumbing system with modern, reliable pipes.</p>
        
        <h2>Our Pipe Replacement Services:</h2>
        <ul>
            <li>Partial pipe replacement</li>
            <li>Whole-house repiping</li>
            <li>Water line replacement</li>
            <li>Sewer line replacement</li>
            <li>Upgrade to copper or PEX piping</li>
            <li>Code compliance updates</li>
        </ul>
        
        <p>We specialize in efficient repiping with minimal disruption to your home and daily life. Our technicians clean up thoroughly after each project, leaving your home in excellent condition.</p>
    ');
    
    create_page_if_not_exists('Septic System Installation', 'services/septic/installation', '
        <h1>Professional Septic System Installation</h1>
        <p>Wade\'s Plumbing & Septic provides complete septic system installation services, from initial site evaluation to final inspection. Our experienced team ensures your new system meets all local codes and functions optimally for years to come.</p>
        
        <h2>Our Installation Process:</h2>
        <ul>
            <li>Comprehensive site evaluation</li>
            <li>System design and permitting</li>
            <li>Excavation and tank placement</li>
            <li>Drain field installation</li>
            <li>Connection to home plumbing</li>
            <li>Final testing and inspection</li>
        </ul>
        
        <p>We install various types of septic systems, including conventional systems, advanced treatment units, and alternative systems for challenging sites.</p>
    ');
    
    create_page_if_not_exists('Septic System Repairs', 'services/septic/repairs', '
        <h1>Expert Septic System Repairs</h1>
        <p>When your septic system shows signs of problems, Wade\'s Plumbing & Septic provides prompt, effective repair services to prevent costly system failures and protect your property.</p>
        
        <h2>Septic Repair Services We Offer:</h2>
        <ul>
            <li>Tank repair and baffle replacement</li>
            <li>Drain field restoration</li>
            <li>Pump repair and replacement</li>
            <li>Broken pipe repair</li>
            <li>Riser and lid replacement</li>
            <li>Control panel troubleshooting</li>
        </ul>
        
        <p>Our technicians accurately diagnose septic issues using specialized equipment, including cameras and electronic monitors, to identify problems without unnecessary excavation.</p>
    ');
    
    create_page_if_not_exists('Septic Inspections', 'services/septic/inspections', '
        <h1>Thorough Septic System Inspections</h1>
        <p>Wade\'s Plumbing & Septic provides comprehensive septic system inspections for homeowners, home buyers, and property sellers. Our detailed evaluations assess all components of your septic system to identify existing or potential issues.</p>
        
        <h2>Our Inspection Services Include:</h2>
        <ul>
            <li>Tank condition assessment</li>
            <li>Baffle and outlet inspection</li>
            <li>Drain field evaluation</li>
            <li>Pump and control testing</li>
            <li>Sludge level measurement</li>
            <li>Real estate transaction inspections</li>
        </ul>
        
        <p>After completing the inspection, we provide a detailed report of findings and recommendations for maintenance or repairs if needed.</p>
    ');
    
    create_page_if_not_exists('Advanced Treatment Systems', 'services/septic/advanced-treatment', '
        <h1>Advanced Septic Treatment Systems</h1>
        <p>Wade\'s Plumbing & Septic specializes in advanced treatment systems that provide superior wastewater processing for challenging sites or environmentally sensitive areas. These systems offer enhanced treatment beyond conventional septic systems.</p>
        
        <h2>Advanced Systems We Install & Service:</h2>
        <ul>
            <li>Aerobic Treatment Units (ATUs)</li>
            <li>Media filters</li>
            <li>Mound systems</li>
            <li>Drip irrigation systems</li>
            <li>Recirculating sand filters</li>
            <li>Engineered wetlands</li>
        </ul>
        
        <p>Our team helps you select the appropriate system for your property\'s specific conditions and ensures proper installation and maintenance for optimal performance.</p>
    ');
    
    // More about pages
    create_page_if_not_exists('Testimonials', 'testimonials', '
        <h1>Customer Testimonials</h1>
        <p>Don\'t just take our word for it. Here\'s what our customers have to say about their experiences with Wade\'s Plumbing & Septic.</p>
        
        <div class="testimonial">
            <blockquote>
                "Wade\'s Plumbing responded quickly to our emergency call when our water heater failed. The technician was professional, explained everything clearly, and completed the installation of our new unit efficiently. Highly recommend their services!"
            </blockquote>
            <p>— Sarah M., Residential Customer</p>
        </div>
        
        <div class="testimonial">
            <blockquote>
                "As a property manager, I need reliable service providers. Wade\'s has never let me down. Their team handles all our plumbing and septic needs for multiple properties, always with quality work and transparent pricing."
            </blockquote>
            <p>— Robert T., Commercial Property Manager</p>
        </div>
        
        <div class="testimonial">
            <blockquote>
                "We had a complicated septic issue that two other companies couldn\'t resolve. Wade\'s team diagnosed the problem correctly and fixed it permanently. Their knowledge and persistence made all the difference."
            </blockquote>
            <p>— Jennifer and David K., Homeowners</p>
        </div>
        
        <h2>Share Your Experience</h2>
        <p>We value feedback from our customers. If you\'ve recently used our services, we invite you to share your experience.</p>
    ');
    
    create_page_if_not_exists('Service Areas', 'service-areas', '
        <h1>Our Service Areas</h1>
        <p>Wade\'s Plumbing & Septic proudly serves residential and commercial customers throughout the following regions:</p>
        
        <h2>California</h2>
        <ul>
            <li>Santa Cruz County</li>
            <li>Monterey County</li>
            <li>San Benito County</li>
            <li>Santa Clara County (southern portion)</li>
        </ul>
        
        <h2>Georgia</h2>
        <ul>
            <li>Pickens County</li>
            <li>Cherokee County</li>
            <li>Gilmer County</li>
            <li>Dawson County</li>
        </ul>
        
        <p>Not sure if we service your area? Contact us to confirm coverage for your specific location.</p>
        
        <h2>24/7 Emergency Service</h2>
        <p>We provide emergency plumbing and septic services throughout our service areas, 24 hours a day, 7 days a week.</p>
    ');
    
    create_page_if_not_exists('Community Involvement', 'community', '
        <h1>Community Involvement</h1>
        <p>At Wade\'s Plumbing & Septic, we believe in giving back to the communities we serve. Our commitment extends beyond providing quality plumbing and septic services—we actively participate in community initiatives and support local causes.</p>
        
        <h2>Our Community Initiatives</h2>
        
        <h3>Local Sponsorships</h3>
        <p>We sponsor local youth sports teams, community events, and charitable fundraisers throughout our service areas.</p>
        
        <h3>Educational Outreach</h3>
        <p>Our team provides free educational workshops on basic plumbing maintenance, water conservation, and septic system care at community centers and schools.</p>
        
        <h3>Environmental Stewardship</h3>
        <p>We participate in local watershed cleanup events and promote environmentally friendly plumbing and septic practices.</p>
        
        <h3>Emergency Assistance</h3>
        <p>During natural disasters and community emergencies, we offer support through reduced-rate services for affected families and businesses.</p>
        
        <h2>Recent Community Activities</h2>
        <p>Check back regularly to see updates on our latest community involvement efforts and upcoming events.</p>
    ');
    
    // Additional resource pages
    create_page_if_not_exists('Maintenance Tips', 'maintenance-tips', '
        <h1>Plumbing & Septic Maintenance Tips</h1>
        <p>Regular maintenance can prevent costly repairs and extend the life of your plumbing and septic systems. Follow these tips to keep your systems running smoothly.</p>
        
        <h2>Plumbing Maintenance Tips</h2>
        <ul>
            <li>Check for leaks regularly and repair them promptly</li>
            <li>Insulate exposed pipes in cold weather</li>
            <li>Clean faucet aerators and showerheads periodically</li>
            <li>Never flush anything besides toilet paper</li>
            <li>Use drain strainers in sinks and showers</li>
            <li>Avoid chemical drain cleaners that can damage pipes</li>
            <li>Know where your main water shut-off valve is located</li>
            <li>Schedule annual plumbing inspections</li>
        </ul>
        
        <h2>Septic System Maintenance Tips</h2>
        <ul>
            <li>Pump your septic tank every 3-5 years</li>
            <li>Conserve water to prevent system overload</li>
            <li>Keep records of all maintenance and repairs</li>
            <li>Never park or drive over your drainfield</li>
            <li>Don\'t plant trees near your septic system</li>
            <li>Avoid pouring grease, oil, or chemicals down drains</li>
            <li>Use septic-safe cleaning products</li>
            <li>Schedule professional inspections regularly</li>
        </ul>
        
        <p>For more detailed maintenance advice or to schedule a professional inspection, contact our team today.</p>
    ');
    
    create_page_if_not_exists('Emergency Services', 'emergency', '
        <h1>24/7 Emergency Plumbing & Septic Services</h1>
        <p>When plumbing emergencies strike, Wade\'s Plumbing & Septic is ready to respond 24 hours a day, 7 days a week. Our emergency response team provides prompt, professional service when you need it most.</p>
        
        <h2>Our Emergency Services Include:</h2>
        <ul>
            <li>Burst pipe repair</li>
            <li>Severe clogs and backups</li>
            <li>Sewer line emergencies</li>
            <li>Water heater failures</li>
            <li>Gas line leaks</li>
            <li>Septic system overflows</li>
            <li>Frozen pipe thawing</li>
            <li>Flood cleanup and mitigation</li>
        </ul>
        
        <h2>What to Do in a Plumbing Emergency</h2>
        <ol>
            <li>Shut off the water supply to the affected area or at the main valve</li>
            <li>If it\'s a gas-related emergency, leave your home immediately</li>
            <li>Call our emergency line at [Emergency Phone Number]</li>
            <li>Take photos of the damage for insurance purposes if safe to do so</li>
            <li>Wait in a safe location for our technician to arrive</li>
        </ol>
        
        <p>Our emergency technicians arrive fully equipped to handle most situations on the first visit, minimizing damage to your home and restoring your plumbing system quickly.</p>
    ');
    
    create_page_if_not_exists('Videos', 'videos', '
        <h1>Plumbing & Septic Video Tutorials</h1>
        <p>Welcome to our video resource center. These educational videos provide helpful tips, demonstrations, and information about plumbing and septic systems.</p>
        
        <h2>Plumbing Tutorials</h2>
        <ul>
            <li>How to shut off your water in an emergency</li>
            <li>Simple fixes for running toilets</li>
            <li>Preventing and thawing frozen pipes</li>
            <li>Understanding your water heater</li>
            <li>How to clean a clogged drain naturally</li>
        </ul>
        
        <h2>Septic System Information</h2>
        <ul>
            <li>How your septic system works</li>
            <li>Signs your septic tank needs pumping</li>
            <li>Septic system do\'s and don\'ts</li>
            <li>Understanding advanced treatment systems</li>
            <li>Caring for your drainfield</li>
        </ul>
        
        <h2>DIY Tips & Tricks</h2>
        <ul>
            <li>Installing a new showerhead</li>
            <li>Fixing a leaky faucet</li>
            <li>Replacing a toilet flapper</li>
            <li>Insulating exposed pipes</li>
            <li>Water conservation techniques</li>
        </ul>
        
        <p>Check back regularly as we add new videos to our library. Have a topic you\'d like us to cover? Let us know!</p>
    ');
    
    // Additional contact pages
    create_page_if_not_exists('Request a Quote', 'request-quote', '
        <h1>Request a Quote</h1>
        <p>Ready to get started with Wade\'s Plumbing & Septic? Request a quote for your plumbing or septic project, and our team will provide you with detailed pricing and options.</p>
        
        <h2>Get Your Personalized Quote</h2>
        <p>Please fill out the form below with details about your project. The more information you provide, the more accurate our initial quote will be.</p>
        
        <!-- Quote request form would be inserted here -->
        
        <h2>What Happens Next?</h2>
        <ol>
            <li>We\'ll review your request and contact you within 24 hours (usually sooner)</li>
            <li>For complex projects, we may schedule an on-site evaluation</li>
            <li>You\'ll receive a detailed quote outlining all costs and options</li>
            <li>Once you approve, we\'ll schedule your service at a convenient time</li>
        </ol>
        
        <h2>Our Quote Guarantee</h2>
        <p>We pride ourselves on transparent pricing. Our quotes include all aspects of your project with no hidden fees or surprise charges. The price we quote is the price you\'ll pay, unless the scope of work changes.</p>
        
        <p>If you have questions or need immediate assistance, please call us directly.</p>
    ');
    
    create_page_if_not_exists('Schedule Service', 'schedule-service', '
        <h1>Schedule Service</h1>
        <p>Ready to schedule your plumbing or septic service? Use our convenient online scheduling tool or contact us directly to set up an appointment that works for you.</p>
        
        <h2>Online Scheduling</h2>
        <p>Select your service type, preferred date and time, and provide your contact information using the form below. Our team will confirm your appointment.</p>
        
        <!-- Scheduling form would be inserted here -->
        
        <h2>Available Services</h2>
        <ul>
            <li>Plumbing repairs and installations</li>
            <li>Drain cleaning</li>
            <li>Water heater services</li>
            <li>Septic pumping and maintenance</li>
            <li>Septic system inspections</li>
            <li>Fixture installations</li>
            <li>Leak detection</li>
            <li>And more...</li>
        </ul>
        
        <h2>What to Expect</h2>
        <p>After scheduling, you\'ll receive a confirmation email with your appointment details. Our technician will call before arriving at your property and will arrive in a clearly marked vehicle. All our technicians are licensed, insured, and have passed background checks for your peace of mind.</p>
    ');
    
    create_page_if_not_exists('Customer Support', 'customer-support', '
        <h1>Customer Support</h1>
        <p>At Wade\'s Plumbing & Septic, we\'re committed to providing exceptional support before, during, and after service. Our customer service team is here to assist you with any questions or concerns.</p>
        
        <h2>Contact Our Support Team</h2>
        <ul>
            <li>Phone: [Customer Support Phone Number]</li>
            <li>Email: support@wadesinc.io</li>
            <li>Hours: Monday-Friday, 8:00 AM - 5:00 PM</li>
        </ul>
        
        <h2>Frequently Asked Support Questions</h2>
        
        <h3>How do I pay my bill?</h3>
        <p>We accept payment by credit card, check, or cash at the time of service. For larger projects, we also offer financing options. You can request an emailed receipt for your records.</p>
        
        <h3>What if I\'m not satisfied with my service?</h3>
        <p>Your satisfaction is our priority. If you\'re not completely satisfied with our work, please contact us within 30 days, and we\'ll make it right.</p>
        
        <h3>Do you offer warranties?</h3>
        <p>Yes, we stand behind our work with service warranties. The specific warranty period depends on the type of service performed. Ask your technician for details about your service warranty.</p>
        
        <h3>How do I schedule a follow-up service?</h3>
        <p>You can schedule follow-up service by calling our office or using our online scheduling tool. Be sure to mention your previous service so we can review your history before the appointment.</p>
    ');
    
    create_page_if_not_exists('Reviews', 'reviews', '
        <h1>Leave a Review</h1>
        <p>We value your feedback about your experience with Wade\'s Plumbing & Septic. Your reviews help us improve our services and assist other customers in making informed decisions.</p>
        
        <h2>Share Your Experience</h2>
        <p>Please take a moment to share your thoughts about our service. Your honest feedback is appreciated!</p>
        
        <!-- Review form would be inserted here -->
        
        <h2>Review Us on Other Platforms</h2>
        <p>You can also leave a review on these platforms:</p>
        <ul>
            <li><a href="#">Google</a></li>
            <li><a href="#">Yelp</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Angie\'s List</a></li>
            <li><a href="#">Better Business Bureau</a></li>
        </ul>
        
        <h2>Recent Customer Reviews</h2>
        <p>Here\'s what some of our recent customers have said about their experience with Wade\'s Plumbing & Septic:</p>
        
        <!-- Recent reviews would be displayed here -->
    ');
}

/**
 * Enhanced SEO optimization function
 * Adds comprehensive meta tags, structured data, and SEO improvements
 */
function wades_plumbing_septic_enhance_seo() {
    // Get current page/post data
    $post_id = get_the_ID();
    $post_type = get_post_type();
    $post_title = get_the_title();
    $post_excerpt = get_the_excerpt();
    $post_url = get_permalink();
    $featured_image = get_the_post_thumbnail_url($post_id, 'full');
    
    // Default meta description
    $meta_description = !empty($post_excerpt) ? $post_excerpt : "Professional plumbing and septic services for residential and commercial properties. From routine maintenance to complex installations, our licensed professionals deliver quality workmanship.";
    
    // Add meta tags
    echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
    
    // Open Graph tags
    echo '<meta property="og:title" content="' . esc_attr($post_title) . ' | Wade\'s Plumbing & Septic">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
    echo '<meta property="og:type" content="' . ($post_type === 'post' ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($post_url) . '">' . "\n";
    if ($featured_image) {
        echo '<meta property="og:image" content="' . esc_url($featured_image) . '">' . "\n";
    }
    
    // Twitter Card tags
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($post_title) . ' | Wade\'s Plumbing & Septic">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";
    if ($featured_image) {
        echo '<meta name="twitter:image" content="' . esc_url($featured_image) . '">' . "\n";
    }
    
    // Canonical URL
    echo '<link rel="canonical" href="' . esc_url($post_url) . '">' . "\n";
    
    // Add structured data based on post type
    $structured_data = array(
        "@context" => "https://schema.org",
        "@type" => $post_type === 'post' ? "BlogPosting" : "WebPage",
        "name" => $post_title,
        "description" => $meta_description,
        "url" => $post_url,
        "publisher" => array(
            "@type" => "Organization",
            "name" => "Wade's Plumbing & Septic",
            "logo" => array(
                "@type" => "ImageObject",
                "url" => get_theme_mod('custom_logo')
            )
        )
    );
    
    // Add specific structured data based on post type
    switch ($post_type) {
        case 'post':
            $structured_data['datePublished'] = get_the_date('c');
            $structured_data['dateModified'] = get_the_modified_date('c');
            $structured_data['author'] = array(
                "@type" => "Person",
                "name" => get_the_author()
            );
            break;
            
        case 'page':
            if (is_front_page()) {
                $structured_data['@type'] = 'LocalBusiness';
                $front_phone = wades_plumbing_septic_get_location_based_phone();
                $front_phone = is_array($front_phone) ? ($front_phone['active_phone'] ?? '') : $front_phone;
                $structured_data['address'] = array(
                    "@type" => "PostalAddress",
                    "streetAddress" => get_theme_mod('business_street_address', ''),
                    "addressLocality" => get_theme_mod('business_city', 'Santa Cruz'),
                    "addressRegion" => get_theme_mod('business_region', 'CA'),
                    "postalCode" => get_theme_mod('business_postal_code', '95060'),
                    "addressCountry" => "US"
                );
                $structured_data['telephone'] = $front_phone;
                $structured_data['openingHoursSpecification'] = array(
                    array(
                        "@type" => "OpeningHoursSpecification",
                        "dayOfWeek" => array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday"),
                        "opens" => "09:00",
                        "closes" => "17:00"
                    )
                );
            }
            break;
    }
    
    // Output structured data
    echo '<script type="application/ld+json">' . wp_json_encode($structured_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    
    // Add breadcrumb structured data
    $breadcrumb_data = array(
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList",
        "itemListElement" => array(
            array(
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Home",
                "item" => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' )
            )
        )
    );
    
    // Add current page to breadcrumb
    if (!is_front_page()) {
        $breadcrumb_data['itemListElement'][] = array(
            "@type" => "ListItem",
            "position" => 2,
            "name" => $post_title,
            "item" => $post_url
        );
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($breadcrumb_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

// Hook the SEO enhancement function

/**
 * Ensure services are properly categorized in the new structure
 */
function wades_activate_service_categories() {
    // Only run this once by checking an option
    if (get_option('wades_service_categories_activated')) {
        return;
    }
    
    // Get all our category terms
    $residential_plumbing = get_term_by('slug', 'residential-plumbing', 'service_category');
    $commercial_plumbing = get_term_by('slug', 'commercial-plumbing', 'service_category');
    $septic_services = get_term_by('slug', 'septic-services', 'service_category');
    $emergency_services = get_term_by('slug', 'emergency-services', 'service_category');
    $specialty_services = get_term_by('slug', 'specialty-services', 'service_category');
    
    // Get the original categories
    $plumbing = get_term_by('slug', 'plumbing', 'service_category');
    $septic = get_term_by('slug', 'septic', 'service_category');
    $commercial = get_term_by('slug', 'commercial', 'service_category');
    
    // Only proceed if all categories exist
    if (!$residential_plumbing || !$commercial_plumbing || !$septic_services || 
        !$emergency_services || !$specialty_services || !$plumbing || !$septic || !$commercial) {
        return;
    }
    
    // Get all services
    $services = get_posts(array(
        'post_type' => 'service',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));
    
    // Update service categories
    foreach ($services as $service) {
        $current_terms = wp_get_post_terms($service->ID, 'service_category', array('fields' => 'ids'));
        
        // Assign to new categories based on existing ones
        if (in_array($plumbing->term_id, $current_terms)) {
            // Add to residential plumbing for most plumbing services
            wp_set_post_terms($service->ID, array_merge($current_terms, array($residential_plumbing->term_id)), 'service_category');
        }
        
        if (in_array($commercial->term_id, $current_terms)) {
            // Add to commercial plumbing for commercial services
            wp_set_post_terms($service->ID, array_merge($current_terms, array($commercial_plumbing->term_id)), 'service_category');
        }
        
        if (in_array($septic->term_id, $current_terms)) {
            // Add to septic services for septic services
            wp_set_post_terms($service->ID, array_merge($current_terms, array($septic_services->term_id)), 'service_category');
        }
    }
    
    // Mark this as completed so we don't run it again
    update_option('wades_service_categories_activated', true);
}
add_action('init', 'wades_activate_service_categories', 20); // Run after the categories are registered

/**
 * Enhanced image optimization for better SEO and page speed
 */
function wades_plumbing_septic_optimize_images() {
    // Enable WebP image generation if supported by the server
    if (function_exists('imagewebp')) {
        add_filter('wp_handle_upload', 'wades_plumbing_septic_create_webp_version', 10, 2);
    }
    
    // Add responsive image support with srcset
    add_filter('wp_calculate_image_srcset', 'wades_plumbing_septic_enhance_srcset', 10, 5);
    
    // Add support for WebP in allowed mime types
    add_filter('upload_mimes', 'wades_plumbing_septic_add_webp_mime_type');
    
    // Add SVG support for logos and icons
    add_filter('upload_mimes', 'wades_plumbing_septic_add_svg_mime_type');
}
add_action('init', 'wades_plumbing_septic_optimize_images');

/**
 * Create WebP versions of uploaded JPEG and PNG images
 *
 * @param array $upload Array of upload data
 * @param string $context The type of upload
 * @return array The upload data
 */
function wades_plumbing_septic_create_webp_version($upload, $context) {
    // Only run on image uploads
    if (!preg_match('/image\/(jpeg|png)/i', $upload['type'])) {
        return $upload;
    }
    
    // Get the path to the uploaded file
    $file_path = $upload['file'];
    $webp_path = pathinfo($file_path, PATHINFO_DIRNAME) . '/' . pathinfo($file_path, PATHINFO_FILENAME) . '.webp';
    
    // Create WebP version based on image type
    if ($upload['type'] === 'image/jpeg') {
        $image = imagecreatefromjpeg($file_path);
        imagewebp($image, $webp_path, 80); // 80% quality for good balance
        imagedestroy($image);
    } elseif ($upload['type'] === 'image/png') {
        $image = imagecreatefrompng($file_path);
        // Handle PNG transparency
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);
        imagewebp($image, $webp_path, 80);
        imagedestroy($image);
    }
    
    // Add entry to WordPress attachment metadata for the WebP version
    // This will be handled by a separate function
    
    return $upload;
}

/**
 * Enhance srcset generation for responsive images
 *
 * @param array $sources Array of image sources
 * @param array $size_array Array of width and height values
 * @param string $image_src Image URL
 * @param array $image_meta Image metadata
 * @param int $attachment_id Attachment ID
 * @return array Modified sources array
 */
function wades_plumbing_septic_enhance_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    // If we have sources and WebP is supported by the server
    if ($sources && function_exists('imagewebp')) {
        foreach ($sources as $width => $source) {
            // Check if a WebP version exists
            $webp_url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $source['url']);
            $webp_file = str_replace(site_url('/'), ABSPATH, $webp_url);
            
            if (file_exists($webp_file)) {
                // Add WebP as a source with higher priority
                $sources[$width]['url'] = $webp_url;
                $sources[$width]['mime_type'] = 'image/webp';
            }
        }
    }
    
    return $sources;
}

/**
 * Add WebP MIME type to allowed uploads
 *
 * @param array $mimes Allowed MIME types
 * @return array Modified MIME types
 */
function wades_plumbing_septic_add_webp_mime_type($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}

/**
 * Add SVG MIME type to allowed uploads for logos and icons
 *
 * @param array $mimes Allowed MIME types
 * @return array Modified MIME types
 */
function wades_plumbing_septic_add_svg_mime_type($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}

/**
 * Enhanced image attributes for better SEO and accessibility
 * 
 * @param array $attributes Existing image attributes
 * @param WP_Post $attachment The attachment post object
 * @param string|array $size Requested image size
 * @return array Modified image attributes
 */
function wades_plumbing_septic_enhance_image_attributes($attributes, $attachment, $size) {
    // If alt is empty, use the title or fallback to a descriptive text
    if (empty($attributes['alt'])) {
        $attributes['alt'] = get_the_title($attachment->ID);
        
        // If it's a logo, be descriptive
        if (strpos(strtolower($attributes['alt']), 'logo') !== false) {
            $attributes['alt'] = get_bloginfo('name') . ' Logo';
        }
    }
    
    // Add loading="lazy" for images that aren't in the initial viewport
    // Skip for logos and very small images which are likely to be in the viewport
    $skip_lazy = false;
    if (strpos(strtolower($attributes['alt']), 'logo') !== false || 
        strpos(strtolower($attributes['alt']), 'header') !== false ||
        strpos(strtolower($attributes['class']), 'logo') !== false ||
        strpos(strtolower($attributes['class']), 'header') !== false) {
        $skip_lazy = true;
    }
    
    // For small images, don't lazy load as they're usually visible
    if (isset($attributes['width']) && isset($attributes['height'])) {
        if ((int)$attributes['width'] < 100 || (int)$attributes['height'] < 100) {
            $skip_lazy = true;
        }
    }
    
    if (!$skip_lazy && !isset($attributes['loading'])) {
        $attributes['loading'] = 'lazy';
    }
    
    // Add decoding="async" for better performance
    if (!isset($attributes['decoding'])) {
        $attributes['decoding'] = 'async';
    }
    
    // Add fetchpriority="high" for LCP (Largest Contentful Paint) images
    // This helps Core Web Vitals
    if (!$skip_lazy && is_singular() && get_post_thumbnail_id() === $attachment->ID) {
        $attributes['fetchpriority'] = 'high';
    }
    
    return $attributes;
}
add_filter('wp_get_attachment_image_attributes', 'wades_plumbing_septic_enhance_image_attributes', 10, 3);

/**
 * Optimize image markup in content for SEO
 * 
 * @param string $content The content to filter
 * @return string The filtered content
 */
function wades_plumbing_septic_optimize_content_images($content) {
    // Add missing alt attributes to images in content
    $content = preg_replace_callback('/<img([^>]*)>/i', function($matches) {
        $img_attrs = $matches[1];
        
        // If no alt attribute is found, add an empty one
        if (!preg_match('/alt=(["\'])(.*?)\1/i', $img_attrs)) {
            $img_attrs .= ' alt=""';
        }
        
        // If no loading attribute is found, add lazy loading
        if (!preg_match('/loading=(["\'])(.*?)\1/i', $img_attrs)) {
            $img_attrs .= ' loading="lazy"';
        }
        
        // If no decoding attribute is found, add async decoding
        if (!preg_match('/decoding=(["\'])(.*?)\1/i', $img_attrs)) {
            $img_attrs .= ' decoding="async"';
        }
        
        return '<img' . $img_attrs . '>';
    }, $content);
    
    return $content;
}
add_filter('the_content', 'wades_plumbing_septic_optimize_content_images');

/**
 * Add FAQ Schema markup to content that contains questions and answers
 * This helps Google show FAQ rich snippets in search results
 * 
 * @param string $content The post content
 * @return string The content with FAQ schema if applicable
 */
function wades_plumbing_septic_add_faq_schema($content) {
    // Only process on singular pages that have content
    if (!is_singular() || empty($content)) {
        return $content;
    }
    
    // Pattern to detect FAQ-like structure: look for <h3>Question</h3><p>Answer</p> patterns
    $pattern = '/<h[2-4].*?>(.*?)<\/h[2-4]>.*?<p.*?>(.*?)<\/p>/is';
    
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        // We found question-answer pairs, create FAQ schema
        $faq_items = array();
        
        foreach ($matches as $match) {
            $question = strip_tags($match[1]);
            $answer = strip_tags($match[2]);
            
            // Skip very short questions/answers as they're likely not real FAQs
            if (strlen($question) < 10 || strlen($answer) < 15) {
                continue;
            }
            
            $faq_items[] = array(
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $answer
                )
            );
        }
        
        // Only add schema if we found valid FAQ items
        if (!empty($faq_items)) {
            $faq_schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faq_items
            );
            
            // Add the schema to the end of the content
            $content .= '<script type="application/ld+json">' . wp_json_encode($faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
        }
    }
    
    return $content;
}

/**
 * Add enhanced local business schema with multiple locations
 * This helps with Google Maps and local search results
 */
function wades_plumbing_septic_local_business_schema() {
    // Only add on front page or contact/about/location pages
    $is_location_page = false;
    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        $location_slugs = array('contact', 'about', 'locations', 'service-area', 'service-areas');
        $is_location_page = in_array($slug, $location_slugs);
    }
    
    if (!is_front_page() && !$is_location_page) {
        return;
    }
    
    // Define multiple service locations
    $locations = array(
        'ca' => array(
            'name' => "Wade's Plumbing & Septic - Santa Cruz",
            'description' => "Professional plumbing and septic services serving Santa Cruz County and surrounding areas.",
            'telephone' => "(831) 225-4344",
            'street' => "123 Ocean Street",
            'city' => "Santa Cruz",
            'state' => "CA",
            'zip' => "95060",
            'country' => "US",
            'geo' => array('latitude' => 36.9741, 'longitude' => -122.0308),
            'hours' => array(
                'monday' => array('9:00', '17:00'),
                'tuesday' => array('9:00', '17:00'),
                'wednesday' => array('9:00', '17:00'),
                'thursday' => array('9:00', '17:00'),
                'friday' => array('9:00', '17:00'),
                'saturday' => array('9:00', '13:00'),
                'sunday' => array('closed', 'closed')
            ),
            'service_area' => "Santa Cruz County, Monterey County, and San Benito County"
        ),
        'ga' => array(
            'name' => "Wade's Plumbing & Septic - Pickens County",
            'description' => "Professional plumbing and septic services serving Pickens County and surrounding areas.",
            'telephone' => "(706) 253-1234",
            'street' => "456 Main Street",
            'city' => "Jasper",
            'state' => "GA",
            'zip' => "30143",
            'country' => "US",
            'geo' => array('latitude' => 34.4687, 'longitude' => -84.4294),
            'hours' => array(
                'monday' => array('8:00', '17:00'),
                'tuesday' => array('8:00', '17:00'),
                'wednesday' => array('8:00', '17:00'),
                'thursday' => array('8:00', '17:00'),
                'friday' => array('8:00', '16:00'),
                'saturday' => array('closed', 'closed'),
                'sunday' => array('closed', 'closed')
            ),
            'service_area' => "Pickens County, Cherokee County, and Gilmer County"
        )
    );
    
    // Get current location if function exists
    $current_location = 'ca'; // Default to CA
    if (function_exists('wades_plumbing_septic_get_current_location')) {
        $current_location = wades_plumbing_septic_get_current_location();
    }
    
    // Set location data based on current location
    $location = $locations[$current_location];
    
    // Create schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'additionalType' => 'PlumbingService',
        'name' => $location['name'],
        'description' => $location['description'],
        'url' => function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' ),
        'telephone' => $location['telephone'],
        'image' => get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '',
        'priceRange' => '$$',
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress' => $location['street'],
            'addressLocality' => $location['city'],
            'addressRegion' => $location['state'],
            'postalCode' => $location['zip'],
            'addressCountry' => $location['country']
        ),
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => $location['geo']['latitude'],
            'longitude' => $location['geo']['longitude']
        ),
        'openingHoursSpecification' => array()
    );
    
    // Add hours
    foreach ($location['hours'] as $day => $hours) {
        if ($hours[0] != 'closed') {
            $schema['openingHoursSpecification'][] = array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ucfirst($day),
                'opens' => $hours[0],
                'closes' => $hours[1]
            );
        }
    }
    
    // Add services offered
    $schema['makesOffer'] = array(
        '@type' => 'Offer',
        'itemOffered' => array(
            array(
                '@type' => 'Service',
                'name' => 'Plumbing Repairs',
                'description' => 'Professional plumbing repair services for residential and commercial properties'
            ),
            array(
                '@type' => 'Service',
                'name' => 'Septic Services',
                'description' => 'Septic tank installation, maintenance and repair services'
            ),
            array(
                '@type' => 'Service',
                'name' => 'Water Heater Services',
                'description' => 'Installation, repair, and maintenance of water heaters'
            ),
            array(
                '@type' => 'Service',
                'name' => 'Drain Cleaning',
                'description' => 'Professional drain cleaning and clog removal services'
            )
        )
    );
    
    // Add service area
    $schema['areaServed'] = array(
        '@type' => 'GeoCircle',
        'geoMidpoint' => array(
            '@type' => 'GeoCoordinates',
            'latitude' => $location['geo']['latitude'],
            'longitude' => $location['geo']['longitude']
        ),
        'geoRadius' => '50000'
    );
    
    // Add review aggregate if it exists
    if (function_exists('wades_plumbing_septic_get_reviews')) {
        $reviews = wades_plumbing_septic_get_reviews();
        if (!empty($reviews) && isset($reviews['average']) && isset($reviews['count'])) {
            $schema['aggregateRating'] = array(
                '@type' => 'AggregateRating',
                'ratingValue' => $reviews['average'],
                'reviewCount' => $reviews['count']
            );
        }
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}

/**
 * Add breadcrumb navigation for better user experience and SEO
 */
function wades_plumbing_septic_display_breadcrumbs() {
    // Don't display on the front page
    if (is_front_page()) {
        return;
    }
    
    // Start the breadcrumb
    echo '<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">';
    echo '<div class="mx-auto max-w-7xl px-4 py-2 text-sm text-gray-600">';
    
    // Add home link
    echo '<span property="itemListElement" typeof="ListItem">';
    echo '<a property="item" typeof="WebPage" href="' . esc_url( function_exists( 'wades_plumbing_septic_get_canonical_page_url' ) ? wades_plumbing_septic_get_canonical_page_url( 'home' ) : home_url( '/' ) ) . '">';
    echo '<span property="name">Home</span>';
    echo '</a>';
    echo '<meta property="position" content="1">';
    echo '</span>';
    
    echo ' &raquo; ';
    
    // Add different breadcrumb paths based on content type
    if (is_singular('post')) {
        // Blog post breadcrumb
        echo '<span property="itemListElement" typeof="ListItem">';
        echo '<a property="item" typeof="WebPage" href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">';
        echo '<span property="name">Blog</span>';
        echo '</a>';
        echo '<meta property="position" content="2">';
        echo '</span>';
        
        echo ' &raquo; ';
        
        // Current post
        echo '<span property="itemListElement" typeof="ListItem">';
        echo '<span property="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta property="position" content="3">';
        echo '</span>';
    } elseif (is_singular('service')) {
        // Services breadcrumb
        echo '<span property="itemListElement" typeof="ListItem">';
        
        // Try to find services page
        $services_page = function_exists('wades_get_page_by_path') ? wades_get_page_by_path('services') : null;
        if (!$services_page && function_exists('get_page_by_path')) {
            $services_page = get_page_by_path('services', OBJECT, 'page');
        }
        $services_page_id = $services_page ? $services_page->ID : null;
        if (!$services_page_id) {
            // Try to find page with services template
            $services_pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-services.php'
            ));
            
            if (!empty($services_pages)) {
                $services_page_id = $services_pages[0]->ID;
            }
        }
        
        if ($services_page_id) {
            echo '<a property="item" typeof="WebPage" href="' . esc_url(get_permalink($services_page_id)) . '">';
            echo '<span property="name">Services</span>';
            echo '</a>';
        } else {
            echo '<span property="name">Services</span>';
        }
        
        echo '<meta property="position" content="2">';
        echo '</span>';
        
        // Check if service has a category
        $service_categories = get_the_terms(get_the_ID(), 'service_category');
        if (!empty($service_categories)) {
            echo ' &raquo; ';
            
            // Category
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<a property="item" typeof="WebPage" href="' . esc_url(get_term_link($service_categories[0])) . '">';
            echo '<span property="name">' . esc_html($service_categories[0]->name) . '</span>';
            echo '</a>';
            echo '<meta property="position" content="3">';
            echo '</span>';
            
            echo ' &raquo; ';
            
            // Current service
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<span property="name">' . esc_html(get_the_title()) . '</span>';
            echo '<meta property="position" content="4">';
            echo '</span>';
        } else {
            echo ' &raquo; ';
            
            // Current service
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<span property="name">' . esc_html(get_the_title()) . '</span>';
            echo '<meta property="position" content="3">';
            echo '</span>';
        }
    } elseif (is_singular('page')) {
        // Get ancestors if any
        $ancestors = get_post_ancestors(get_the_ID());
        $position = 2;
        
        if (!empty($ancestors)) {
            // Reverse the array to get the correct order
            $ancestors = array_reverse($ancestors);
            
            foreach ($ancestors as $ancestor) {
                echo '<span property="itemListElement" typeof="ListItem">';
                echo '<a property="item" typeof="WebPage" href="' . esc_url(get_permalink($ancestor)) . '">';
                echo '<span property="name">' . esc_html(get_the_title($ancestor)) . '</span>';
                echo '</a>';
                echo '<meta property="position" content="' . $position . '">';
                echo '</span>';
                
                echo ' &raquo; ';
                $position++;
            }
        }
        
        // Current page
        echo '<span property="itemListElement" typeof="ListItem">';
        echo '<span property="name">' . esc_html(get_the_title()) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</span>';
    } elseif (is_archive()) {
        if (is_category() || is_tag() || is_tax()) {
            // Category/tag/taxonomy archives
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<span property="name">' . esc_html(get_the_archive_title()) . '</span>';
            echo '<meta property="position" content="2">';
            echo '</span>';
        } elseif (is_author()) {
            // Author archives
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<span property="name">Author: ' . esc_html(get_the_author()) . '</span>';
            echo '<meta property="position" content="2">';
            echo '</span>';
        } elseif (is_date()) {
            // Date archives
            echo '<span property="itemListElement" typeof="ListItem">';
            echo '<span property="name">' . esc_html(get_the_archive_title()) . '</span>';
            echo '<meta property="position" content="2">';
            echo '</span>';
        }
    } elseif (is_search()) {
        // Search results
        echo '<span property="itemListElement" typeof="ListItem">';
        echo '<span property="name">Search results for: ' . esc_html(get_search_query()) . '</span>';
        echo '<meta property="position" content="2">';
        echo '</span>';
    } elseif (is_404()) {
        // 404 page
        echo '<span property="itemListElement" typeof="ListItem">';
        echo '<span property="name">Page not found</span>';
        echo '<meta property="position" content="2">';
        echo '</span>';
    }
    
    echo '</div></div>';
}

/**
 * Add breadcrumbs hook to content area
 */
function wades_plumbing_septic_add_breadcrumbs() {
    // Check theme support and add breadcrumbs
    add_action('wades_before_content', 'wades_plumbing_septic_display_breadcrumbs');
}
add_action('wp', 'wades_plumbing_septic_add_breadcrumbs');

/**
 * Generate a table of contents for long-form content
 * This improves user experience and SEO for long articles
 * 
 * @param string $content The post content
 * @return string The content with table of contents added
 */
function wades_plumbing_septic_add_table_of_contents($content) {
    // Only add to single posts or pages with long content
    if (!is_singular() || empty($content) || str_word_count(strip_tags($content)) < 300) {
        return $content;
    }
    
    // Don't add TOC to specific post types or templates
    $excluded_types = array('product', 'testimonial', 'team_member');
    if (in_array(get_post_type(), $excluded_types)) {
        return $content;
    }
    
    // Get all headings from the content
    $pattern = '/<h([2-4])(.*?)>(.*?)<\/h[2-4]>/i';
    if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
        // Found headings, create TOC
        $toc = '<div class="table-of-contents">';
        $toc .= '<h2>Table of Contents</h2>';
        $toc .= '<ol>';
        
        // Replace headings with anchored versions
        $headings_count = 0;
        
        foreach ($matches as $i => $heading) {
            $level = $heading[1]; // h2, h3, etc.
            $attrs = $heading[2]; // Any attributes
            $title = strip_tags($heading[3]); // The heading text
            
            // Skip very short headings or those that might be part of UI elements
            if (strlen($title) < 3 || strpos(strtolower($title), 'click') !== false) {
                continue;
            }
            
            $headings_count++;
            $anchor = 'toc-' . sanitize_title($title) . '-' . $i;
            
            // Add to TOC list with proper indentation based on heading level
            $indent_class = 'toc-level-' . $level;
            $toc .= '<li class="' . $indent_class . '"><a href="#' . $anchor . '">' . $title . '</a></li>';
            
            // Replace the heading in content with one that has an ID
            $new_heading = '<h' . $level . $attrs . ' id="' . $anchor . '">' . $heading[3] . '</h' . $level . '>';
            $content = str_replace($heading[0], $new_heading, $content);
        }
        
        $toc .= '</ol>';
        $toc .= '</div>';
        
        // Only add TOC if we have enough headings
        if ($headings_count >= 3) {
            // Add the TOC after the first paragraph or before the first heading
            $first_paragraph_pos = strpos($content, '</p>');
            if ($first_paragraph_pos !== false) {
                $content = substr_replace($content, '</p>' . $toc, $first_paragraph_pos, 4);
            } else {
                $first_heading_pos = strpos($content, '<h');
                if ($first_heading_pos !== false) {
                    $content = substr_replace($content, $toc, $first_heading_pos, 0);
                } else {
                    // Just add to the beginning if no paragraphs or headings found
                    $content = $toc . $content;
                }
            }
            
            // Add skip to content link
            $content = '<div id="content-top"></div>' . $content;
            $content .= '<div class="back-to-top"><a href="#content-top">Back to Top</a></div>';
        }
    }
    
    return $content;
}
add_filter('the_content', 'wades_plumbing_septic_add_table_of_contents', 10);

/**
 * Add schema markup for reviews and testimonials
 * This improves rich snippets for review content
 */
function wades_plumbing_septic_add_review_schema() {
    // Only run on testimonial pages or pages with reviews
    if (!is_singular('testimonial') && !is_page('reviews') && !is_page('testimonials')) {
        return;
    }
    
    // Get testimonial data
    $testimonials = array();
    
    // If it's a single testimonial
    if (is_singular('testimonial')) {
        $testimonials[] = array(
            'author' => get_the_title(),
            'date' => get_the_date('c'),
            'rating' => get_post_meta(get_the_ID(), '_testimonial_rating', true) ?: 5,
            'text' => get_the_content(),
        );
    } else {
        // If it's a page with multiple testimonials
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => 10,
            'post_status' => 'publish',
        );
        
        $testimonial_query = new WP_Query($args);
        
        if ($testimonial_query->have_posts()) {
            while ($testimonial_query->have_posts()) {
                $testimonial_query->the_post();
                $testimonials[] = array(
                    'author' => get_the_title(),
                    'date' => get_the_date('c'),
                    'rating' => get_post_meta(get_the_ID(), '_testimonial_rating', true) ?: 5,
                    'text' => get_the_excerpt(),
                );
            }
            wp_reset_postdata();
        }
    }
    
    // Only proceed if we have testimonials
    if (empty($testimonials)) {
        return;
    }
    
    // Calculate average rating
    $total_rating = 0;
    foreach ($testimonials as $testimonial) {
        $total_rating += (float)$testimonial['rating'];
    }
    $average_rating = $total_rating / count($testimonials);
    
    // Build schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => "Wade's Plumbing & Septic",
        'aggregateRating' => array(
            '@type' => 'AggregateRating',
            'ratingValue' => number_format($average_rating, 1),
            'reviewCount' => count($testimonials),
            'bestRating' => '5',
            'worstRating' => '1'
        ),
        'review' => array()
    );
    
    // Add each review
    foreach ($testimonials as $testimonial) {
        $schema['review'][] = array(
            '@type' => 'Review',
            'author' => array(
                '@type' => 'Person',
                'name' => $testimonial['author']
            ),
            'datePublished' => $testimonial['date'],
            'reviewRating' => array(
                '@type' => 'Rating',
                'ratingValue' => $testimonial['rating'],
                'bestRating' => '5',
                'worstRating' => '1'
            ),
            'reviewBody' => wp_strip_all_tags($testimonial['text'])
        );
    }
    
    // Output schema
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}

/**
 * Automatically add descriptive alt tags to images missing them
 * This improves SEO and accessibility
 * 
 * @param array $attr Image attributes
 * @param WP_Post $attachment Attachment post object
 * @param string|array $size Image size
 * @return array Modified attributes
 */
function wades_plumbing_septic_auto_image_alt($attr, $attachment, $size) {
    // If alt is already set and not empty, return unchanged
    if (isset($attr['alt']) && !empty($attr['alt'])) {
        return $attr;
    }
    
    // Get attachment info
    $attachment_id = $attachment->ID;
    $parent_id = $attachment->post_parent;
    $parent_post = false;
    
    if ($parent_id) {
        $parent_post = get_post($parent_id);
    }
    
    // Build alt text from metadata and context
    $alt_text = '';
    
    // Try to use the image title first
    if (!empty($attachment->post_title) && $attachment->post_title !== 'Untitled' && $attachment->post_title !== 'automatic draft') {
        $alt_text = $attachment->post_title;
    }
    // Otherwise try to use the attachment caption
    elseif (!empty($attachment->post_excerpt)) {
        $alt_text = $attachment->post_excerpt;
    }
    // Otherwise try to use the parent post title if available
    elseif ($parent_post) {
        $alt_text = $parent_post->post_title . ' - Plumbing & Septic Image';
    }
    // Fallback to the filename without extension as a last resort
    else {
        $filename = basename(get_attached_file($attachment_id));
        $filename = preg_replace('/\.[^.]+$/', '', $filename); // Remove extension
        $filename = str_replace(array('-', '_'), ' ', $filename); // Replace dashes and underscores with spaces
        $alt_text = ucwords($filename); // Capitalize first letter of each word
    }
    
    // Add business name to make alt more descriptive
    if (strpos($alt_text, "Wade's") === false && strpos($alt_text, "Wades") === false) {
        $alt_text .= " - Wade's Plumbing & Septic";
    }
    
    // Set the alt attribute
    $attr['alt'] = $alt_text;
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'wades_plumbing_septic_auto_image_alt', 10, 3);

/**
 * Add image structured data for featured images
 * This helps Google display rich image results
 */
function wades_plumbing_septic_add_image_schema() {
    // Only run on single posts and pages with featured images
    if (!is_singular() || !has_post_thumbnail()) {
        return;
    }
    
    $post_id = get_the_ID();
    $thumbnail_id = get_post_thumbnail_id($post_id);
    $thumbnail = wp_get_attachment_image_src($thumbnail_id, 'full');
    
    if (!$thumbnail) {
        return;
    }
    
    $thumbnail_url = $thumbnail[0];
    $thumbnail_width = $thumbnail[1];
    $thumbnail_height = $thumbnail[2];
    
    // Get image metadata
    $attachment = get_post($thumbnail_id);
    $alt_text = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    
    // If no alt text, generate one
    if (empty($alt_text)) {
        $alt_text = !empty($attachment->post_title) ? $attachment->post_title : get_the_title($post_id);
    }
    
    // Create image schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'ImageObject',
        'contentUrl' => $thumbnail_url,
        'url' => $thumbnail_url,
        'representativeOfPage' => true,
        'width' => $thumbnail_width,
        'height' => $thumbnail_height,
        'caption' => !empty($attachment->post_excerpt) ? $attachment->post_excerpt : $alt_text,
        'name' => !empty($attachment->post_title) ? $attachment->post_title : $alt_text,
        'description' => !empty($attachment->post_content) ? $attachment->post_content : $alt_text,
        'datePublished' => get_the_date('c', $attachment->ID),
        'copyrightHolder' => array(
            '@type' => 'Organization',
            'name' => "Wade's Plumbing & Septic"
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}

/**
 * Improve attachment pages for better SEO
 * Make sure attachment pages redirect to parent post or add proper schema
 */
function wades_plumbing_septic_attachment_page_improvements() {
    if (is_attachment()) {
        global $post;
        
        // If attachment has a parent, redirect to the parent post
        if ($post->post_parent > 0) {
            wp_redirect(get_permalink($post->post_parent), 301);
            exit;
        }
        
        // Otherwise improve the attachment page with schema
        add_action('wp_head', 'wades_plumbing_septic_single_image_schema');
    }
}

/**
 * Add schema for single image attachment pages
 */
function wades_plumbing_septic_single_image_schema() {
    global $post;
    
    $attachment_id = $post->ID;
    $image = wp_get_attachment_image_src($attachment_id, 'full');
    
    if (!$image) {
        return;
    }
    
    $image_url = $image[0];
    $image_width = $image[1];
    $image_height = $image[2];
    
    // Get image metadata
    $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    
    // If no alt text, use title
    if (empty($alt_text)) {
        $alt_text = !empty($post->post_title) ? $post->post_title : '';
    }
    
    // Create image schema
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'ImageObject',
        'contentUrl' => $image_url,
        'url' => $image_url,
        'width' => $image_width,
        'height' => $image_height,
        'caption' => !empty($post->post_excerpt) ? $post->post_excerpt : $alt_text,
        'name' => !empty($post->post_title) ? $post->post_title : $alt_text,
        'description' => !empty($post->post_content) ? $post->post_content : $alt_text,
        'datePublished' => get_the_date('c', $post->ID),
        'copyrightHolder' => array(
            '@type' => 'Organization',
            'name' => "Wade's Plumbing & Septic"
        )
    );
    
    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
}


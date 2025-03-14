<?php
/**
 * Wade's Plumbing & Septic Theme Customizer
 *
 * @package Wades_Plumbing_&_Septic
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wades_plumbing_septic_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'wades_plumbing_septic_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'wades_plumbing_septic_customize_partial_blogdescription',
			)
		);
	}

	// Header Settings Section
	$wp_customize->add_section(
		'wades_plumbing_septic_header_settings',
		array(
			'title'       => __( 'Header Settings', 'wades-plumbing-septic' ),
			'priority'    => 30,
		)
	);

	// Custom Logo
	$wp_customize->add_setting(
		'custom_logo_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'custom_logo_image',
			array(
				'label'    => __( 'Upload Logo Image', 'wades-plumbing-septic' ),
				'section'  => 'wades_plumbing_septic_header_settings',
				'settings' => 'custom_logo_image',
			)
		)
	);

	// Business Phone
	$wp_customize->add_setting(
		'business_phone',
		array(
			'default'           => '831.225.4344',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'business_phone',
		array(
			'label'       => __( 'Primary Business Phone', 'wades-plumbing-septic' ),
			'description' => __( 'Enter your primary business phone number', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_header_settings',
			'type'        => 'text',
		)
	);

	// Missouri Phone
	$wp_customize->add_setting(
		'missouri_phone',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'missouri_phone',
		array(
			'label'       => __( 'Missouri Phone Number', 'wades-plumbing-septic' ),
			'description' => __( 'Enter your Missouri-specific phone number', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_header_settings',
			'type'        => 'text',
		)
	);

	// Enable/disable Missouri phone detection
	$wp_customize->add_setting(
		'enable_state_detection',
		array(
			'default'           => false,
			'sanitize_callback' => 'wades_plumbing_septic_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'enable_state_detection',
		array(
			'label'       => __( 'Enable State Detection', 'wades-plumbing-septic' ),
			'description' => __( 'Show Missouri phone number to visitors from Missouri', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_header_settings',
			'type'        => 'checkbox',
		)
	);

	// Show phone or button option
	$wp_customize->add_setting(
		'show_phone_button',
		array(
			'default'           => 'phone',
			'sanitize_callback' => 'wades_plumbing_septic_sanitize_select',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'show_phone_button',
		array(
			'label'       => __( 'Header Button Type', 'wades-plumbing-septic' ),
			'description' => __( 'Show phone number or "Get a Quote" button', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_header_settings',
			'type'        => 'select',
			'choices'     => array(
				'phone'  => __( 'Phone Number', 'wades-plumbing-septic' ),
				'button' => __( 'Get a Quote Button', 'wades-plumbing-septic' ),
			),
		)
	);

	// Add SEO section
	$wp_customize->add_section(
		'wades_plumbing_septic_seo_settings',
		array(
			'title'       => __( 'SEO Settings', 'wades-plumbing-septic' ),
			'description' => __( 'Settings for improving search engine optimization', 'wades-plumbing-septic' ),
			'priority'    => 70,
		)
	);
	
	// Meta description
	$wp_customize->add_setting(
		'meta_description',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	
	$wp_customize->add_control(
		'meta_description',
		array(
			'label'       => __( 'Meta Description', 'wades-plumbing-septic' ),
			'description' => __( 'Enter a site-wide meta description (for SEO)', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_seo_settings',
			'type'        => 'textarea',
		)
	);
	
	// Default image alt text
	$wp_customize->add_setting(
		'default_image_alt',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	
	$wp_customize->add_control(
		'default_image_alt',
		array(
			'label'       => __( 'Default Image Alt Text', 'wades-plumbing-septic' ),
			'description' => __( 'Default alt text to use when image alt is not set', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_seo_settings',
			'type'        => 'text',
		)
	);

	// Add service areas for header bar
	$wp_customize->add_setting(
		'service_areas',
		array(
			'default'           => 'Santa Cruz County, Monterey County, Santa Clara County',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	
	$wp_customize->add_control(
		'service_areas',
		array(
			'label'       => __( 'Service Areas', 'wades-plumbing-septic' ),
			'description' => __( 'Comma-separated list of service areas to show in the header', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_header_settings',
			'type'        => 'text',
		)
	);

	// Footer Settings Section
	$wp_customize->add_section(
		'wades_plumbing_septic_footer_settings',
		array(
			'title'       => __( 'Footer Settings', 'wades-plumbing-septic' ),
			'priority'    => 90,
		)
	);

	// Facebook URL
	$wp_customize->add_setting(
		'facebook_url',
		array(
			'default'           => 'https://www.facebook.com/wadesplumbingandseptic/',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'facebook_url',
		array(
			'label'       => __( 'Facebook URL', 'wades-plumbing-septic' ),
			'description' => __( 'Enter your Facebook page URL', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'url',
		)
	);

	// Instagram URL
	$wp_customize->add_setting(
		'instagram_url',
		array(
			'default'           => 'https://www.instagram.com/wadesplumbing/?hl=en',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'instagram_url',
		array(
			'label'       => __( 'Instagram URL', 'wades-plumbing-septic' ),
			'description' => __( 'Enter your Instagram profile URL', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'url',
		)
	);

	// Designer Name
	$wp_customize->add_setting(
		'designer_name',
		array(
			'default'           => 'Byron Wade',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'designer_name',
		array(
			'label'       => __( 'Designer Name', 'wades-plumbing-septic' ),
			'description' => __( 'Name displayed in the footer credit', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'text',
		)
	);

	// Designer URL
	$wp_customize->add_setting(
		'designer_url',
		array(
			'default'           => 'https://www.byronwade.com/',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'designer_url',
		array(
			'label'       => __( 'Designer URL', 'wades-plumbing-septic' ),
			'description' => __( 'Link for the designer credit in footer', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'url',
		)
	);

	// Add copyright text for footer
	$wp_customize->add_setting(
		'copyright_text',
		array(
			'default'           => '© ' . date('Y') . ' Wade\'s Plumbing & Septic. All rights reserved.',
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'refresh',
		)
	);
	
	$wp_customize->add_control(
		'copyright_text',
		array(
			'label'       => __( 'Copyright Text', 'wades-plumbing-septic' ),
			'description' => __( 'Copyright text for footer', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'textarea',
		)
	);
	
	// Footer credit toggle
	$wp_customize->add_setting(
		'footer_credit',
		array(
			'default'           => true,
			'sanitize_callback' => 'wades_plumbing_septic_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);
	
	$wp_customize->add_control(
		'footer_credit',
		array(
			'label'       => __( 'Show Designer Credit', 'wades-plumbing-septic' ),
			'description' => __( 'Display "Designed by Byron Wade" in footer', 'wades-plumbing-septic' ),
			'section'     => 'wades_plumbing_septic_footer_settings',
			'type'        => 'checkbox',
		)
	);
}
add_action( 'customize_register', 'wades_plumbing_septic_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wades_plumbing_septic_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wades_plumbing_septic_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wades_plumbing_septic_customize_preview_js() {
	wp_enqueue_script( 'wades-plumbing-septic-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), WADES_PLUMBING_SEPTIC_VERSION, true );
}
add_action( 'customize_preview_init', 'wades_plumbing_septic_customize_preview_js' );

/**
 * Sanitize checkbox values.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool
 */
function wades_plumbing_septic_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize select option values.
 *
 * @param string $input The input from the setting.
 * @param object $setting The selected setting.
 * @return string The sanitized input.
 */
function wades_plumbing_septic_sanitize_select( $input, $setting ) {
	// Get all the choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// Return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
} 
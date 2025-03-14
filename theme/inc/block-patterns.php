<?php
/**
 * Block Patterns
 *
 * @package Wades_Plumbing_&_Septic
 */

/**
 * Register Block Pattern Category.
 */
function wades_plumbing_septic_register_block_pattern_categories() {
	register_block_pattern_category(
		'wades-sections',
		array( 'label' => esc_html__( 'Wade\'s Sections', 'wades-plumbing-septic' ) )
	);
	register_block_pattern_category(
		'wades-cards',
		array( 'label' => esc_html__( 'Wade\'s Cards', 'wades-plumbing-septic' ) )
	);
	register_block_pattern_category(
		'wades-heroes',
		array( 'label' => esc_html__( 'Wade\'s Heroes', 'wades-plumbing-septic' ) )
	);
	register_block_pattern_category(
		'wades-cta',
		array( 'label' => esc_html__( 'Wade\'s CTAs', 'wades-plumbing-septic' ) )
	);
}
add_action( 'init', 'wades_plumbing_septic_register_block_pattern_categories', 9 );

/**
 * Register Block Patterns.
 */
function wades_plumbing_septic_register_block_patterns() {
	// Get all pattern files.
	$pattern_files = glob( get_template_directory() . '/inc/patterns/*.php' );

	// Loop through all pattern files.
	foreach ( $pattern_files as $pattern_file ) {
		// Get pattern data from the file.
		$pattern_data = require $pattern_file;

		// Get the pattern name from the filename.
		$pattern_name = basename( $pattern_file, '.php' );

		// Register the pattern.
		register_block_pattern(
			'wades-plumbing-septic/' . $pattern_name,
			$pattern_data
		);
	}
}
add_action( 'init', 'wades_plumbing_septic_register_block_patterns' ); 
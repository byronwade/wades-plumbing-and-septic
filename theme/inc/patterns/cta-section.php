<?php
/**
 * Call to Action Pattern
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'       => esc_html__( 'Call to Action', 'wades-plumbing-septic' ),
	'description' => esc_html__( 'A call-to-action section with background', 'wades-plumbing-septic' ),
	'categories'  => array( 'wades-cta' ),
	'content'     => '<!-- wp:cover {"url":"https://via.placeholder.com/1200x400","className":"py-16 relative"} -->
<div class="wp-block-cover py-16 relative"><span aria-hidden="true" class="wp-block-cover__background bg-primary opacity-70"></span><img class="wp-block-cover__image-background" alt="" src="https://via.placeholder.com/1200x400" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"max-w-4xl mx-auto px-4"} -->
<div class="wp-block-group max-w-4xl mx-auto px-4"><!-- wp:heading {"textAlign":"center","className":"text-background text-3xl font-bold mb-4"} -->
<h2 class="has-text-align-center text-background text-3xl font-bold mb-4">Ready to Solve Your Plumbing Problems?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"text-background mb-8"} -->
<p class="has-text-align-center text-background mb-8">Contact us today for a free estimate. Our team of licensed professionals is ready to help.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"className":"gap-4"} -->
<div class="wp-block-buttons gap-4"><!-- wp:button {"className":"bg-background text-primary font-medium rounded"} -->
<div class="wp-block-button bg-background text-primary font-medium rounded"><a class="wp-block-button__link wp-element-button">Contact Us</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"border border-background text-background font-medium rounded"} -->
<div class="wp-block-button border border-background text-background font-medium rounded"><a class="wp-block-button__link wp-element-button">Learn More</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->',
); 
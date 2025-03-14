<?php
/**
 * Services Grid Pattern
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'       => esc_html__( 'Services Grid', 'wades-plumbing-septic' ),
	'description' => esc_html__( 'A grid of services with icons', 'wades-plumbing-septic' ),
	'categories'  => array( 'wades-sections' ),
	'content'     => '<!-- wp:group {"align":"full","className":"bg-background py-16 px-8"} -->
<div class="wp-block-group alignfull bg-background py-16 px-8"><!-- wp:heading {"textAlign":"center","className":"mb-12"} -->
<h2 class="has-text-align-center mb-12">Our Services</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide","className":"gap-8"} -->
<div class="wp-block-columns alignwide gap-8"><!-- wp:column {"className":"bg-white p-8 rounded-lg shadow-md"} -->
<div class="wp-block-column bg-white p-8 rounded-lg shadow-md"><!-- wp:image {"align":"center","width":64,"height":64,"sizeSlug":"large","className":"mb-4"} -->
<figure class="wp-block-image aligncenter size-large is-resized mb-4"><img src="https://via.placeholder.com/64" alt="Plumbing" width="64" height="64"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">Plumbing Repairs</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Professional repairs for leaks, clogs, and all plumbing issues. Our expert technicians provide fast, reliable service.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"bg-white p-8 rounded-lg shadow-md"} -->
<div class="wp-block-column bg-white p-8 rounded-lg shadow-md"><!-- wp:image {"align":"center","width":64,"height":64,"sizeSlug":"large","className":"mb-4"} -->
<figure class="wp-block-image aligncenter size-large is-resized mb-4"><img src="https://via.placeholder.com/64" alt="Septic" width="64" height="64"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">Septic Services</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Complete septic system installation, maintenance, and repair services. We keep your system running efficiently.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"bg-white p-8 rounded-lg shadow-md"} -->
<div class="wp-block-column bg-white p-8 rounded-lg shadow-md"><!-- wp:image {"align":"center","width":64,"height":64,"sizeSlug":"large","className":"mb-4"} -->
<figure class="wp-block-image aligncenter size-large is-resized mb-4"><img src="https://via.placeholder.com/64" alt="Installation" width="64" height="64"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">New Installations</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Quality installation of fixtures, pipes, water heaters, and more. We use only the best materials for lasting results.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
); 
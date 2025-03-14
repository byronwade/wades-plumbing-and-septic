<?php
/**
 * Team Members Grid Pattern
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'       => esc_html__( 'Team Members Grid', 'wades-plumbing-septic' ),
	'description' => esc_html__( 'A grid showing team members with images and descriptions', 'wades-plumbing-septic' ),
	'categories'  => array( 'wades-sections' ),
	'content'     => '<!-- wp:group {"align":"full","className":"bg-background py-16 px-8"} -->
<div class="wp-block-group alignfull bg-background py-16 px-8"><!-- wp:heading {"textAlign":"center","className":"mb-2"} -->
<h2 class="has-text-align-center mb-2">Our Expert Team</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"mb-12 max-w-2xl mx-auto"} -->
<p class="has-text-align-center mb-12 max-w-2xl mx-auto">Meet our team of licensed, professional plumbers and septic specialists, dedicated to providing you with the highest quality service.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide","className":"gap-8"} -->
<div class="wp-block-columns alignwide gap-8"><!-- wp:column {"className":"w-full md:w-1/3"} -->
<div class="wp-block-column w-full md:w-1/3"><!-- wp:group {"className":"bg-white p-6 rounded-lg shadow-md text-center"} -->
<div class="wp-block-group bg-white p-6 rounded-lg shadow-md text-center"><!-- wp:image {"align":"center","width":200,"height":200,"sizeSlug":"medium","className":"rounded-full mb-4 mx-auto"} -->
<figure class="wp-block-image aligncenter size-medium is-resized rounded-full mb-4 mx-auto"><img src="https://via.placeholder.com/200" alt="Team member" width="200" height="200"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">John Smith</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"text-primary font-bold mb-2"} -->
<p class="has-text-align-center text-primary font-bold mb-2">Master Plumber</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">John has over 15 years of experience and specializes in complex plumbing systems and repairs.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"w-full md:w-1/3"} -->
<div class="wp-block-column w-full md:w-1/3"><!-- wp:group {"className":"bg-white p-6 rounded-lg shadow-md text-center"} -->
<div class="wp-block-group bg-white p-6 rounded-lg shadow-md text-center"><!-- wp:image {"align":"center","width":200,"height":200,"sizeSlug":"medium","className":"rounded-full mb-4 mx-auto"} -->
<figure class="wp-block-image aligncenter size-medium is-resized rounded-full mb-4 mx-auto"><img src="https://via.placeholder.com/200" alt="Team member" width="200" height="200"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">Sarah Johnson</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"text-primary font-bold mb-2"} -->
<p class="has-text-align-center text-primary font-bold mb-2">Septic Specialist</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Sarah is our lead septic system expert with extensive knowledge in installation and maintenance.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"w-full md:w-1/3"} -->
<div class="wp-block-column w-full md:w-1/3"><!-- wp:group {"className":"bg-white p-6 rounded-lg shadow-md text-center"} -->
<div class="wp-block-group bg-white p-6 rounded-lg shadow-md text-center"><!-- wp:image {"align":"center","width":200,"height":200,"sizeSlug":"medium","className":"rounded-full mb-4 mx-auto"} -->
<figure class="wp-block-image aligncenter size-medium is-resized rounded-full mb-4 mx-auto"><img src="https://via.placeholder.com/200" alt="Team member" width="200" height="200"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"textAlign":"center","level":3,"className":"text-xl font-semibold"} -->
<h3 class="has-text-align-center text-xl font-semibold">Robert Williams</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"text-primary font-bold mb-2"} -->
<p class="has-text-align-center text-primary font-bold mb-2">Service Manager</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Robert oversees our service team, ensuring every job is completed to the highest standards.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
); 
<?php
/**
 * Header Pattern
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'      => __( 'Site Header with Primary Menu', 'wades-plumbing-septic' ),
	'categories' => array( 'wades-headers' ),
	'content'    => '<!-- wp:group {"className":"site-header","style":{"position":{"type":"sticky","top":"0px"},"zIndex":50,"spacing":{"padding":{"top":"0","bottom":"0"}}},"backgroundColor":"background","textColor":"foreground","layout":{"type":"constrained"}} -->
<div class="wp-block-group site-header has-foreground-color has-background-background-color has-text-color has-background" style="padding-top:0;padding-bottom:0;position:sticky;top:0px;z-index:50">
	<!-- wp:group {"className":"bg-black text-white sticky top-0 z-50","layout":{"type":"constrained","contentSize":"1280px"}} -->
	<div class="wp-block-group bg-black text-white sticky top-0 z-50">
		<!-- wp:group {"className":"relative flex p-3 items-center justify-between mx-auto px-6 lg:px-8","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group relative flex p-3 items-center justify-between mx-auto px-6 lg:px-8">
			<!-- wp:group {"className":"flex items-center space-x-4","layout":{"type":"flex","flexWrap":"nowrap"}} -->
			<div class="wp-block-group flex items-center space-x-4">
				<!-- wp:site-logo {"className":"site-logo"} /-->
				<!-- wp:site-title {"className":"hidden text-2xl font-bold xl:inline-flex"} /-->
			</div>
			<!-- /wp:group -->
			
			<!-- wp:group {"className":"flex items-center space-x-8","layout":{"type":"flex","flexWrap":"nowrap"}} -->
			<div class="wp-block-group flex items-center space-x-8">
				<!-- wp:navigation {"textColor":"white","overlayTextColor":"white","backgroundColor":"black","overlayBackgroundColor":"black","className":"hidden md:flex space-x-8 items-center font-bold","layout":{"type":"flex","orientation":"horizontal"},"style":{"spacing":{"blockGap":"2rem"}},"menuSlug":"primary"} /-->
				
				<!-- wp:buttons -->
				<div class="wp-block-buttons">
					<!-- wp:button {"backgroundColor":"#f5f16e","className":"inline-flex justify-center items-center rounded font-bold text-black hover:bg-brand-600"} -->
					<div class="wp-block-button inline-flex justify-center items-center rounded font-bold text-black hover:bg-brand-600"><a class="wp-block-button__link has-text-black-color has-background wp-element-button" href="tel:+1' . preg_replace('/[^0-9]/', '', get_theme_mod('phone_number', '831.225.4344')) . '" style="background-color:#f5f16e"><!-- wp:paragraph {"className":"flex items-center"} -->
					<p class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>' . esc_html(get_theme_mod('phone_number', '831.225.4344')) . '</p>
					<!-- /wp:paragraph --></a></div>
					<!-- /wp:button -->
				</div>
				<!-- /wp:buttons -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		
		<!-- wp:group {"className":"hidden px-4 py-1 font-bold text-black shadow md:block bg-brand","layout":{"type":"constrained","contentSize":"1280px"}} -->
		<div class="wp-block-group hidden px-4 py-1 font-bold text-black shadow md:block bg-brand">
			<!-- wp:group {"className":"items-center justify-center hidden p-1 px-6 pr-4 mx-auto space-x-10 text-sm lg:flex lg:px-8","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
			<div class="wp-block-group items-center justify-center hidden p-1 px-6 pr-4 mx-auto space-x-10 text-sm lg:flex lg:px-8">
				<!-- wp:paragraph -->
				<p>' . esc_html(get_theme_mod('business_hours', 'Mon - Fri 9:00am - 5:00pm')) . '</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:paragraph {"className":"text-lg font-extrabold hover:underline"} -->
				<p class="text-lg font-extrabold hover:underline">' . esc_html(get_theme_mod('phone_number', '831.225.4344')) . '</p>
				<!-- /wp:paragraph -->
				
				<!-- wp:paragraph -->
				<p>' . esc_html(get_theme_mod('service_areas', 'Santa Cruz County, Monterey County, Santa Clara County')) . '</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->',
	'viewportWidth' => 1280,
); 
<?php
/**
 * Hero Section Pattern with Parallax
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'       => esc_html__( 'Hero Section with Parallax', 'wades-plumbing-septic' ),
	'description' => esc_html__( 'A hero section with parallax background, overlay, and content', 'wades-plumbing-septic' ),
	'categories'  => array( 'wades-heroes' ),
	'content'     => '<!-- wp:cover {"url":"' . esc_url( get_template_directory_uri() ) . '/assets/images/hero-background.jpg","id":999,"dimRatio":70,"customGradient":"linear-gradient(90deg,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.7) 100%)","focalPoint":{"x":0.5,"y":0.5},"minHeight":100,"minHeightUnit":"vh","contentPosition":"center center","align":"full","className":"is-style-wades-parallax-hero relative overflow-hidden alignfull header-offset-height"} -->
<div class="wp-block-cover alignfull is-style-wades-parallax-hero relative overflow-hidden header-offset-height" style="min-height:100vh"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-70 has-background-dim wp-block-cover__gradient-background has-background-gradient" style="background:linear-gradient(90deg,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.7) 100%)"></span><img class="wp-block-cover__image-background wp-image-999" alt="Professional plumbing services - Wade\'s Plumbing and Septic hero image" src="' . esc_url( get_template_directory_uri() ) . '/assets/images/hero-background.jpg" style="object-position:50% 50%" data-object-fit="cover" data-object-position="50% 50%"/><div class="wp-block-cover__inner-container">

<!-- wp:group {"className":"container relative z-10 mx-auto flex flex-col justify-center px-4 sm:px-6 lg:px-8","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group container relative z-10 mx-auto flex flex-col justify-center px-4 sm:px-6 lg:px-8">

<!-- wp:columns {"className":"grid gap-8 lg:gap-12 lg:grid-cols-12"} -->
<div class="wp-block-columns grid gap-8 lg:gap-12 lg:grid-cols-12">

<!-- wp:column {"className":"lg:col-span-7"} -->
<div class="wp-block-column lg:col-span-7">

<!-- wp:group {"className":"inline-flex items-center rounded-full bg-brand px-3 py-1 text-sm font-medium text-black","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group inline-flex items-center rounded-full bg-brand px-3 py-1 text-sm font-medium text-black">
<!-- wp:image {"id":99999,"width":16,"height":16,"className":"mr-1 h-4 w-4"} -->
<figure class="wp-block-image is-resized mr-1 h-4 w-4"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/badge-check.svg" alt="Verified" class="wp-image-99999" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph -->
<p>Professional Plumbing &amp; Septic Services</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:heading {"level":1,"style":{"typography":{"fontWeight":"800"}},"className":"mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl"} -->
<h1 class="wp-block-heading mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl lg:text-7xl" style="font-weight:800">Where Quality <span class="text-brand">Meets</span> Community.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"mt-6 max-w-2xl text-lg text-white bg-black/50 p-4 rounded backdrop-blur-sm"} -->
<p class="mt-6 max-w-2xl text-lg text-white bg-black/50 p-4 rounded backdrop-blur-sm">At Wade\'s Plumbing &amp; Septic, we\'re more than just a plumbing company – we\'re your trusted neighbors. Our commitment to exceptional service and quality workmanship has made us the preferred choice for residential and commercial plumbing needs.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"mt-8 grid gap-6 sm:grid-cols-2"} -->
<div class="wp-block-group mt-8 grid gap-6 sm:grid-cols-2">

<!-- wp:group {"className":"border-0 bg-black/50 backdrop-blur-md rounded-lg overflow-hidden"} -->
<div class="wp-block-group border-0 bg-black/50 backdrop-blur-md rounded-lg overflow-hidden">
<!-- wp:group {"className":"p-6"} -->
<div class="wp-block-group p-6">
<!-- wp:group {"className":"border-l-4 border-brand pl-4"} -->
<div class="wp-block-group border-l-4 border-brand pl-4">
<!-- wp:group {"className":"flex items-center","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group flex items-center">
<!-- wp:image {"id":99998,"width":16,"height":16,"className":"mr-2 h-4 w-4 text-brand"} -->
<figure class="wp-block-image is-resized mr-2 h-4 w-4 text-brand"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/map-pin.svg" alt="Location" class="wp-image-99998" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"className":"font-medium text-white"} -->
<p class="font-medium text-white">Santa Cruz, CA</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mt-2 flex items-center","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group mt-2 flex items-center">
<!-- wp:image {"id":99997,"width":16,"height":16,"className":"mr-2 h-4 w-4 text-brand"} -->
<figure class="wp-block-image is-resized mr-2 h-4 w-4 text-brand"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/phone.svg" alt="Phone" class="wp-image-99997" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"className":"text-2xl font-bold text-white"} -->
<p class="text-2xl font-bold text-white">831.225.4344</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"mt-1 text-sm text-white/80"} -->
<p class="mt-1 text-sm text-white/80">Call or Text For Service</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"p-4 pt-0"} -->
<div class="wp-block-buttons p-4 pt-0">
<!-- wp:button {"backgroundColor":"brand","textColor":"black","className":"w-full hover:bg-brand-600","width":100} -->
<div class="wp-block-button has-custom-width has-100-width w-full hover:bg-brand-600"><a class="wp-block-button__link has-black-color has-brand-background-color has-text-color has-background wp-element-button">Contact Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"border-0 bg-black/50 backdrop-blur-md rounded-lg overflow-hidden"} -->
<div class="wp-block-group border-0 bg-black/50 backdrop-blur-md rounded-lg overflow-hidden">
<!-- wp:group {"className":"p-6"} -->
<div class="wp-block-group p-6">
<!-- wp:group {"className":"border-l-4 border-brand pl-4"} -->
<div class="wp-block-group border-l-4 border-brand pl-4">
<!-- wp:group {"className":"flex items-center","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group flex items-center">
<!-- wp:image {"id":99998,"width":16,"height":16,"className":"mr-2 h-4 w-4 text-brand"} -->
<figure class="wp-block-image is-resized mr-2 h-4 w-4 text-brand"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/map-pin.svg" alt="Location" class="wp-image-99998" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"className":"font-medium text-white"} -->
<p class="font-medium text-white">West Branson, MO</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mt-2 flex items-center","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group mt-2 flex items-center">
<!-- wp:image {"id":99997,"width":16,"height":16,"className":"mr-2 h-4 w-4 text-brand"} -->
<figure class="wp-block-image is-resized mr-2 h-4 w-4 text-brand"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/phone.svg" alt="Phone" class="wp-image-99997" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"className":"text-2xl font-bold text-white"} -->
<p class="text-2xl font-bold text-white">417.336.1885</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"mt-1 text-sm text-white/80"} -->
<p class="mt-1 text-sm text-white/80">Call or Text For Service</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:buttons {"className":"p-4 pt-0"} -->
<div class="wp-block-buttons p-4 pt-0">
<!-- wp:button {"backgroundColor":"brand","textColor":"black","className":"w-full hover:bg-brand-600","width":100} -->
<div class="wp-block-button has-custom-width has-100-width w-full hover:bg-brand-600"><a class="wp-block-button__link has-black-color has-brand-background-color has-text-color has-background wp-element-button">Contact Us</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"mt-8 flex items-center","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group mt-8 flex items-center">
<!-- wp:image {"id":99999,"width":16,"height":16,"className":"mr-2 h-4 w-4 text-brand"} -->
<figure class="wp-block-image is-resized mr-2 h-4 w-4 text-brand"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/badge-check.svg" alt="Verified" class="wp-image-99999" width="16" height="16"/></figure>
<!-- /wp:image -->
<!-- wp:paragraph {"className":"text-sm text-white/80"} -->
<p class="text-sm text-white/80">License Number (Plumbing &amp; Septic): 1087260</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:column -->

<!-- wp:column {"className":"hidden lg:col-span-5 lg:flex lg:items-end lg:justify-end"} -->
<div class="wp-block-column hidden lg:col-span-5 lg:flex lg:items-end lg:justify-end">
<!-- wp:group {"className":"relative h-[400px] w-[300px]"} -->
<div class="wp-block-group relative h-[400px] w-[300px]">
<!-- wp:image {"id":1000,"sizeSlug":"full","linkDestination":"none","className":"object-contain absolute inset-0"} -->
<figure class="wp-block-image size-full object-contain absolute inset-0"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/mario.webp" alt="Cartoon plumber mascot" class="wp-image-1000"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

</div></div>
<!-- /wp:cover -->',
); 
<?php
/**
 * Contact Form Pattern
 *
 * @package Wades_Plumbing_&_Septic
 */

return array(
	'title'       => esc_html__( 'Contact Form Section', 'wades-plumbing-septic' ),
	'description' => esc_html__( 'A contact form section with information', 'wades-plumbing-septic' ),
	'categories'  => array( 'wades-sections' ),
	'content'     => '<!-- wp:group {"align":"full","className":"bg-background py-16 px-8"} -->
<div class="wp-block-group alignfull bg-background py-16 px-8"><!-- wp:heading {"textAlign":"center","className":"mb-8"} -->
<h2 class="has-text-align-center mb-8">Contact Us</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"mb-12 max-w-2xl mx-auto"} -->
<p class="has-text-align-center mb-12 max-w-2xl mx-auto">Have questions or need to schedule a service? Fill out the form below or call us directly. We\'ll get back to you as soon as possible.</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide","className":"gap-8"} -->
<div class="wp-block-columns alignwide gap-8"><!-- wp:column {"className":"w-full md:w-1/3"} -->
<div class="wp-block-column w-full md:w-1/3"><!-- wp:group {"className":"bg-white p-8 rounded-lg shadow-md"} -->
<div class="wp-block-group bg-white p-8 rounded-lg shadow-md"><!-- wp:heading {"level":3,"className":"text-xl font-semibold mb-4"} -->
<h3 class="text-xl font-semibold mb-4">Contact Information</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"mb-4"} -->
<p class="mb-4"><strong>Phone:</strong><br>(555) 123-4567</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"mb-4"} -->
<p class="mb-4"><strong>Email:</strong><br>info@wadesplumbing.com</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"mb-4"} -->
<p class="mb-4"><strong>Address:</strong><br>123 Main Street<br>Anytown, ST 12345</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Hours:</strong><br>Monday-Friday: 8am-6pm<br>Saturday: 9am-2pm<br>Sunday: Closed</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"w-full md:w-2/3"} -->
<div class="wp-block-column w-full md:w-2/3"><!-- wp:group {"className":"bg-white p-8 rounded-lg shadow-md"} -->
<div class="wp-block-group bg-white p-8 rounded-lg shadow-md"><!-- wp:heading {"level":3,"className":"text-xl font-semibold mb-4"} -->
<h3 class="text-xl font-semibold mb-4">Send Us a Message</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"mb-6"} -->
<p class="mb-6">Fill out this form and we\'ll get back to you shortly.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<form class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="md:col-span-1">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Name</label>
    <input type="text" id="name" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
  </div>
  <div class="md:col-span-1">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone</label>
    <input type="tel" id="phone" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="service">Service Needed</label>
    <select id="service" name="service" class="w-full px-3 py-2 border border-gray-300 rounded-md">
      <option value="">Select a service</option>
      <option value="plumbing">Plumbing Repairs</option>
      <option value="septic">Septic Services</option>
      <option value="installation">New Installation</option>
      <option value="emergency">Emergency Service</option>
      <option value="other">Other</option>
    </select>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-1" for="message">Message</label>
    <textarea id="message" name="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
  </div>
  <div class="md:col-span-2">
    <button type="submit" class="bg-primary text-white py-2 px-6 rounded hover:bg-primary-dark transition">Send Message</button>
  </div>
</form>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
); 
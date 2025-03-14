<?php
/**
 * The header for our theme
 *
 * This is the template that displays the `head` element and everything up
 * until the `#content` element.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Wades_Plumbing_&_Septic
 */

// Get site description for meta tags
$meta_description = get_theme_mod('meta_description');
if (empty($meta_description)) {
    $meta_description = get_bloginfo('description');
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo esc_attr($meta_description); ?>">
	<?php if (is_front_page()) : ?>
	<meta name="robots" content="index, follow">
	<?php endif; ?>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	
	<!-- Preconnect to essential domains -->
	<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php if (is_front_page()) : ?>
	<link rel="preconnect" href="https://ipapi.co" crossorigin>
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page">
	<a href="#content" class="sr-only"><?php esc_html_e( 'Skip to content', 'wades-plumbing-septic' ); ?></a>

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>

	<div id="content">

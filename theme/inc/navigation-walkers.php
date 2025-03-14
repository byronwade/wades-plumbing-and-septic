<?php
/**
 * Custom navigation walkers for Wade's Plumbing & Septic
 *
 * @package Wades_Plumbing_&_Septic
 */

/**
 * Custom Walker for the main navigation menu
 * Formats menu items with Tailwind CSS classes
 */
class Wade_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param WP_Post $item   Menu item data object.
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 * @param int     $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		
		// Check if item has children
		$has_children = in_array( 'menu-item-has-children', $classes );
		
		// Basic item class
		$item_class = 'hover:underline';
		
		// Item with dropdown gets popover button styling
		if ( $has_children ) {
			$item_class = 'inline-flex items-center gap-x-1 hover:underline';
		}
		
		// Create a container for each menu item for proper spacing
		$output .= '<div class="menu-item">';
		$output .= '<a class="' . esc_attr( $item_class ) . '" href="' . esc_url( $item->url ) . '">';
		$output .= esc_html( $item->title );
		
		// Add dropdown arrow for items with children
		if ( $has_children ) {
			$output .= '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" 
			stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6" aria-hidden="true">
				<polyline points="6 9 12 15 18 9"></polyline>
			</svg>';
		}
		
		$output .= '</a>';
	}
	
	/**
	 * Ends the element output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param WP_Post $item   Menu item data object.
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		// Close the menu item container
		$output .= '</div>';
	}
	
	/**
	 * Start the level output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// We're not displaying submenu items in this header navigation
		// For a dropdown menu, you would add the dropdown code here
	}
	
	/**
	 * End the level output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		// Closing tag for submenu would go here
	}
}

/**
 * Custom Walker for the mobile navigation menu
 * Formats menu items with Tailwind CSS classes for mobile view
 */
class Wade_Mobile_Nav_Walker extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param WP_Post $item   Menu item data object.
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 * @param int     $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes );
		
		// Add list item to create proper spacing in mobile menu
		$output .= '<div class="py-2">';
		
		// Basic item styling for mobile
		$item_class = 'block text-lg font-bold hover:text-gray-300';
		
		// Item with dropdown
		if ( $has_children ) {
			$item_class .= ' flex items-center justify-between';
		}
		
		$output .= '<a class="' . esc_attr( $item_class ) . '" href="' . esc_url( $item->url ) . '">';
		$output .= esc_html( $item->title );
		
		// Add dropdown arrow for items with children
		if ( $has_children ) {
			$output .= '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
			stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-1" aria-hidden="true">
				<polyline points="6 9 12 15 18 9"></polyline>
			</svg>';
		}
		
		$output .= '</a>';
	}
	
	/**
	 * Ends the element output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param WP_Post $item   Menu item data object.
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$output .= '</div>';
	}
	
	/**
	 * Start the level output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		// For mobile submenu, we would add styling here
		$output .= '<div class="pl-4 mt-2 space-y-2 border-l border-gray-700">';
	}
	
	/**
	 * End the level output.
	 *
	 * @param string  $output Used to append additional content (passed by reference).
	 * @param int     $depth  Depth of menu item.
	 * @param array   $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</div>';
	}
} 
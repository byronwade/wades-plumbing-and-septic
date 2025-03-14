<?php
/**
 * Custom walker class for the footer menu
 *
 * @package Wades_Plumbing_&_Septic
 */

if ( ! class_exists( 'Wade_Footer_Nav_Walker' ) ) {
    /**
     * Custom walker class for the footer navigation menu
     */
    class Wade_Footer_Nav_Walker extends Walker_Nav_Menu {

        /**
         * Starts the element output.
         *
         * @param string  $output Used to append additional content (passed by reference).
         * @param WP_Post $item   Menu item data object.
         * @param int     $depth  Depth of menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int     $id     Current item ID.
         */
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

            $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            /**
             * Filters the arguments for a single nav menu item.
             *
             * @since 4.4.0
             *
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param WP_Post  $item  Menu item data object.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

            // Build the output for the footer menu item
            $output .= '<div class="pb-6">';
            
            $atts           = array();
            $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target ) ? $item->target : '';
            $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
            $atts['href']   = ! empty( $item->url ) ? $item->url : '';
            $atts['class']  = 'text-sm leading-6 text-gray-400 hover:text-white';

            /**
             * Filters the HTML attributes applied to a menu item's anchor element.
             *
             * @since 3.6.0
             * @since 4.1.0 The `$depth` parameter was added.
             *
             * @param array $atts {
             *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
             *
             *     @type string $title        Title attribute.
             *     @type string $target       Target attribute.
             *     @type string $rel          The rel attribute.
             *     @type string $href         The href attribute.
             * }
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            /** This filter is documented in wp-includes/post-template.php */
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            /**
             * Filters a menu item's title.
             *
             * @since 4.4.0
             *
             * @param string   $title The menu item's title.
             * @param WP_Post  $item  The current menu item.
             * @param stdClass $args  An object of wp_nav_menu() arguments.
             * @param int      $depth Depth of menu item. Used for padding.
             */
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= $item_output;
            $output .= '</div>';
        }

        /**
         * Ends the element output, if needed.
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Page data object. Not used.
         * @param int      $depth  Depth of page. Not Used.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }
            // No closing element needed as we've already closed the div in start_el
        }
    }
} 
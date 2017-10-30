<?php

/**
 * Gebruiker Centraal - single.php
 * ----------------------------------------------------------------------------------
 * pagina
 * ----------------------------------------------------------------------------------
 * @package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.7.1
 * @desc.   actieteampagina, actieteam-widget, skiplinks, 404
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 */

showdebug(__FILE__, '/');


add_action( 'wp_enqueue_scripts', 'gc_wbvb_add_blog_single_css' );
add_action( 'genesis_entry_content', 'gc_wbvb_add_single_socialmedia_buttons', 1 );
add_action( 'genesis_entry_header', 'gc_wbvb_get_date_badge', 6 );
add_action( 'genesis_entry_content', 'eo_prev_next_post_nav', 20 );
add_action( 'genesis_entry_content', 'gc_wbvb_post_print_links', 10 );
add_action( 'genesis_entry_content', 'gc_wbvb_post_print_downloads', 11 );

add_filter('genesis_attr_entry-header', 'gc_wbvb_add_wrap_class');
add_filter('genesis_attr_entry-content', 'gc_wbvb_add_wrap_class');
add_filter('genesis_attr_entry-footer', 'gc_wbvb_add_wrap_class');



genesis();

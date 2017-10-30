    <?php

/**
 * Gebruiker Centraal - page_archive.php
 * ----------------------------------------------------------------------------------
 * Pagina met archief / sitemap
 * ----------------------------------------------------------------------------------
 * @package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.7.1
 * @desc.   actieteampagina, actieteam-widget, skiplinks, 404
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 */


//* Template Name: GC - Archief en sitemap (page2)

//* Remove standard post content output
remove_action( 'genesis_post_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'gc_wbvb_404', 15 );
//add_action( 'genesis_post_content', 'gc_wbvb_404', 15 );


genesis();
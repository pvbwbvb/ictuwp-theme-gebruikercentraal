<?php

/**
 * Gebruiker Centraal - 404.php
 * ----------------------------------------------------------------------------------
 * 404 pagina
 * ----------------------------------------------------------------------------------
 * @package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.7.1
 * @desc.   actieteampagina, actieteam-widget, skiplinks, 404
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 */



remove_action( 'genesis_loop', 'genesis_do_loop' );
remove_action( 'genesis_loop', 'genesis_404' );

add_action( 'genesis_loop', 'gc_wbvb_404' );

genesis();

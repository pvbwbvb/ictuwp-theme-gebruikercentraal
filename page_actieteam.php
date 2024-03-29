<?php

// Gebruiker Centraal - page_actieteam.php
// ----------------------------------------------------------------------------------
// Pagina waarop alle leden van het actieteam getoond worden
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 4.3.7
// @desc.   Spotlight-component toegevoegd; tekstblok-component voor home toegevoegd.
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme

//* Template Name: GC-pagina - Actieteampagina

//========================================================================================================

add_action( 'genesis_entry_content', 'gc_wbvb_show_actieteamleden', 11 );

// relevante content en externe links toevoegen
// @since	  4.2.2
add_action( 'wp_enqueue_scripts', 'ictu_gctheme_frontend_general_get_related_content_headercss' );

add_action( 'genesis_loop', 'ictu_gctheme_frontend_general_get_spotlight', 12 );

add_action( 'genesis_loop', 'ictu_gctheme_frontend_general_get_related_content', 14 );

//========================================================================================================

function gc_wbvb_show_actieteamleden() {


	if ( have_rows( 'actieteamleden', 'option' ) ):

		echo '<div class="actieteam">';

		// loop through the rows of data
		while ( have_rows( 'actieteamleden', 'option' ) ) : the_row();

			$userdata   = get_sub_field( 'actielid' );
			$acf_userid = $userdata['ID'];   // grabs the user ID
			echo gc_wbvb_authorbox_compose_box( $acf_userid );

		endwhile;

		echo '</div>';

	else :

		// no rows found
		echo 'Geen actieteam bekend';

	endif;


}

//========================================================================================================

genesis();


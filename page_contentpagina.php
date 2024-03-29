<?php

//
// Gebruiker Centraal - page_contentpagina.php
// ----------------------------------------------------------------------------------
// Pagina met gerelateerde content
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 3.29.1
// @desc.   Public Service nominatie-widget op homepage.
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme


//* Template Name: GC-pagina - Pagina Relevante Content Oude Stijl

//========================================================================================================

// widget voor grote banners
add_action( 'genesis_entry_header', 'gc_wbvb_write_widget_home_widget_beforecontent', 8 );

//========================================================================================================

add_action( 'genesis_entry_content', 'gc_wbvb_show_related_content', 11 );

function gc_wbvb_show_related_content() {

    if ( function_exists( 'get_field' ) ) {
        
        $gridcontent    = get_field('gerelateerde_content');
        
        if( $gridcontent ): 

            echo '<h2>' . __( "Zie ook:", 'gebruikercentraal' ) . '</h2><div class="related page_contentpagina">';


            foreach( $gridcontent as $post): 
                setup_postdata($post); 
                
                gc_wbvb_related_content($post);
                
            endforeach; 

            wp_reset_postdata();

           echo '</div>';
    
        else :

        endif; 

    }
    else {
	    echo ACF_PLUGIN_NOT_ACTIVE_WARNING;
    }


}


genesis();



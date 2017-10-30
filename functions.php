<?php

//
// Gebruiker Centraal - functions.php
// ----------------------------------------------------------------------------------
// Zonder functions geen functionaliteit, he?
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 3.9.1
// @desc.   Toevoegen posttypes voor klantcontact-in-beeld.
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme


/**
 * Call Genesis's core functions.
 */
require_once( get_template_directory() . '/lib/init.php' );

/**
 * Define child theme constants.
 */
define( 'CHILD_THEME_NAME', 'Gebruiker Centraal' );
define( 'CHILD_THEME_URL', 'https://wbvb.nl/themes/gebruikercentraal' );
define( 'CHILD_THEME_VERSION', '3.9.1' );
define( 'CHILD_THEME_DESCRIPTION', "3.9.1 - Toevoegen posttypes voor klantcontact-in-beeld." );

define( 'GC_TWITTERACCOUNT', 'gebrcentraal' );

define( 'WP_THEME_DEBUG', false );


$sharedfolder = get_template_directory();
$sharedfolder = preg_replace('|genesis|i','gebruiker-centraal',$sharedfolder);

$default_persoon_plaatje = 'voorbeeld-persoon-1.png';

define( 'GC_FOLDER', $sharedfolder );

define( 'GC_WBVB_WIDGET_SITE_FOOTER', 'site-footer-widget');
define( 'GC_WBVB_WIDGET_HOME_WIDGET_1', 'widgetarea-home-links');
define( 'GC_WBVB_WIDGET_HOME_WIDGET_2', 'widgetarea-home-rechts');

//========================================================================================================

define( 'BLOG_SINGLE_MOBILE', 'blog-single-mobile' );
define( 'BLOG_SINGLE_TABLET', 'blog-single-tablet' );
define( 'BLOG_SINGLE_DESKTOP', 'blog-single-desktop' );
define( 'HALFWIDTH', 'halfwidth' );
define( 'IMG_SIZE_HUGE', 'feature-huge' );
define( 'IMG_SIZE_HUGE_MIN_WIDTH', 1200 );

define( 'ID_BLOGBERICHTEN_CSS', 'blogberichten' );
define( 'ID_BLOG_WIDGET_CSS', 'blog-widget' );
define( 'ID_SINGLE_CSS', 'single-post' );

define( 'SOC_MED_NO', 'socmed_nee' );
define( 'SOC_MED_YES', 'socmed_ja' );

define( 'GC_BRIEVENCONTEXT', 'briefcpt' );
define( 'GC_BEELDENCONTEXT', 'beeldcpt' );

define( 'GC_KLANTCONTACT_BEELDEN_CPT', 'beeld' );
define( 'GC_KLANTCONTACT_BRIEF_CPT', 'brief' );
define( 'GC_TAX_LICENTIE', 'licentie' );
define( 'GC_TAX_ORGANISATIE', 'organisatie' );




add_image_size( HALFWIDTH, 380, 9999, false );
add_image_size( BLOG_SINGLE_MOBILE, 120, 9999, false );
add_image_size( BLOG_SINGLE_TABLET, 250, 9999, false );
add_image_size( BLOG_SINGLE_DESKTOP, 380, 9999, false );
add_image_size( IMG_SIZE_HUGE, IMG_SIZE_HUGE_MIN_WIDTH, 9999, false );

//========================================================================================================

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

//* Display author box on archive pages
add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );

remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );
add_action( 'genesis_entry_content', 'genesis_do_author_box_single', 20 );

//========================================================================================================

//* voor de widgets
require_once( GC_FOLDER . '/widgets/gc-actieteam-widget.php' );
require_once( GC_FOLDER . '/widgets/gc-e-newsletter.php' );
require_once( GC_FOLDER . '/widgets/gc-user-welcome-widget.php' );
require_once( GC_FOLDER . '/widgets/gc-event-widget.php' );
require_once( GC_FOLDER . '/widgets/gc-berichten-widget.php' );
require_once( GC_FOLDER . '/widgets/gc-footer-widget.php' );
require_once( GC_FOLDER . '/includes/common-functions.php' );


//========================================================================================================

require_once( get_stylesheet_directory() . '/nojs.php' );

// does our beloved visitor allow for JavaScript?
$genesis_js_no_js = new Genesis_Js_No_Js;
$genesis_js_no_js->run();

//========================================================================================================
// custom post types, custom taxonomies, custom fields (ACF)
require_once( GC_FOLDER . '/includes/custom-fields-and-post-types.php' );

//========================================================================================================

// functions for the author box
require_once( GC_FOLDER . '/includes/author-box.php' );

//========================================================================================================

$imgbreakpoints = array(
  'break_phone' => array( 
    'direction'       => 'max',
    'width'           => '500px',
    'header-padding'  => '100px',
    'content-before'  => true,
    'content-height'  => '150px',
    'content-width'   => '50%',
    'img_size_single' => BLOG_SINGLE_MOBILE,
    'img_size_archive_list'   => 'halfwidth'
  ), 
  'break_tablet' => array( 
    'direction'       => 'min',
    'width'           => '650px',
    'header-padding'  => '200px',
    'content-before'  => true,
    'content-height'  => '150px',
    'content-width'   => '250px',
    'img_size_single' => BLOG_SINGLE_TABLET,
    'img_size_archive_list'   => 'medium_large'
  ),
  'break_fullwidth' => array( 
    'direction'       => 'min',
    'width'           => '960px',
    'header-padding'  => '400px',
    'content-before'  => true,
    'content-height'  => '250px',
    'content-width'   => '350px',
    'img_size_single' => BLOG_SINGLE_DESKTOP,
    'img_size_archive_list'   => IMG_SIZE_HUGE
  ),
);

//========================================================================================================

//* Remove the site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 2 );

//========================================================================================================

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

//========================================================================================================
// deactivate some site layout options
// Remove Genesis layouts
 
genesis_unregister_layout( 'full-width-content' );
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Unregister primary sidebar
unregister_sidebar( 'sidebar' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_sidebar_alt', 'genesis_do_sidebar_alt' );

//========================================================================================================

// Force layout on custom post type 'tip'
add_filter('genesis_site_layout', 'allow_only_full_width_layout');

function allow_only_full_width_layout($opt) {

    $opt = 'full-width-content';

    return $opt;
}

//========================================================================================================

//* Add class to .site-header
//add_filter('genesis_attr_site-header', 'gc_add_attribute_role_banner');

function gc_add_attribute_role_banner($attributes) {
	$attributes['role'] .= 'banner';
	return $attributes;
}


//* Add class to .site-heade
//add_filter('genesis_attr_site-footer', 'gc_add_attribute_role_contentinfo');

function gc_add_attribute_role_contentinfo($attributes) {
	$attributes['role'] .= 'contentinfo';
	return $attributes;
}




//========================================================================================================

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' );

//* Modify breadcrumb arguments.
add_filter( 'genesis_breadcrumb_args', 'gc_wbvb_breadcrumb_args' );
function gc_wbvb_breadcrumb_args( $args ) {
  
  $separator = '<span class="separator">&nbsp;</span>';

  $auteursoverzichtpagina_start = '';
  $auteursoverzichtpagina_end   = $separator;
  
  if ( function_exists( 'get_field' ) ) {

    if( get_field('auteursoverzichtpagina_link', 'option') ):
      $auteursoverzichtpagina_url   = get_field('auteursoverzichtpagina_link', 'option');
      $auteursoverzichtpagina_start = '<a href="' . $auteursoverzichtpagina_url . '">' ;
      $auteursoverzichtpagina_end   = '</a>' . $separator;
    	$args['labels']['author']     = $auteursoverzichtpagina_start . __( "Auteurs", 'gebruikercentraal' ) . $auteursoverzichtpagina_end;
    else:
    	$args['labels']['author']     = '';
    endif;

  }
  else {
    echo 'de ACF custom fields plugin is niet actief.';
  }

  
	$args['home']                     = __( "Home", 'gebruikercentraal' );
	$args['sep']                      = $separator;
	$args['list_sep']                 = ', '; // Genesis 1.5 and later
	$args['prefix']                   = '<div class="breadcrumb"><div class="wrap"><nav class="breadlist">';
	$args['suffix']                   = '</nav>' . get_search_form(false) . '</div></div>';
	$args['heirarchial_attachments']  = true; // Genesis 1.5 and later
	$args['heirarchial_categories']   = true; // Genesis 1.5 and later
	$args['display']                  = true;
	$args['labels']['prefix']         = ''; // __( "prefix", 'gebruikercentraal' );
	$args['labels']['category']       = ''; //__( "Categorie", 'gebruikercentraal' );
	$args['labels']['tag']            = __( "Label", 'gebruikercentraal' ) . $separator;
	$args['labels']['date']           = __( "Datum-archief", 'gebruikercentraal' );
	$args['labels']['search']         = __( "Zoekresultaat", 'gebruikercentraal' );
	$args['labels']['tax']            = __( "Taxonomie", 'gebruikercentraal' );
	$args['labels']['post_type']      = ''; //__( "Berichten", 'gebruikercentraal' );
	$args['labels']['404']            = __( "Oeps", 'gebruikercentraal' );


  return $args;

}

//========================================================================================================
add_filter('genesis_seo_title', 'gc_wbvb_add_site_title' );

// Add additional custom style to site header
function gc_wbvb_add_site_title( $title ) {
	
	$title = '<div id="sitelogo"><a href="' . esc_url( home_url( '/' ) ) . '"><img alt="Logo Gebruiker Centraal" src="' . WBVB_THEMEFOLDER . '/images/logo-mobile.png" /></a></div>' . $title;

	return $title;
	
}
//========================================================================================================

add_action( 'genesis_after_entry_content', 'gc_wbvb_after_entry_content' );


function gc_wbvb_after_entry_content() { 

    global $post;

    if ( ! is_singular() ) {
    	printf( '<div class="read-more"><a href="' . get_permalink() . '">%s%s%s', __( "Lees: \"", 'gebruikercentraal' ) , get_the_title(), '"</a></div>' );
    }
}

//========================================================================================================
//* Customize the entry meta in the entry header (requires HTML5 theme support)

add_filter( 'genesis_post_info', 'gc_wbvb_post_append_postinfo' ); 

function gc_wbvb_post_append_postinfo($post_info) {
    global $wp_query;
    global $post;

    $socialmedia_icoontjes    = SOC_MED_YES;

    if ( 
        ( 'page'    == get_post_type() ) ||
        ( 'post'    == get_post_type() ) ||
        ( 'event'   == get_post_type() ) 
         ) {

        
        if ( function_exists( 'get_field' ) ) {
            $socialmedia_icoontjes    = get_field('socialmedia_icoontjes', $post->ID );
        }
        else {
            $socialmedia_icoontjes    = '';
        }
    }


    if  ( ( $socialmedia_icoontjes !== SOC_MED_NO ) && ( is_single() ) )  {
        $socialmedia_icoontjes = gc_wbvb_socialbuttons( $post, '' );
    }            
    else {
        $socialmedia_icoontjes = '';
    }

    if ( is_home() ) {
        // niks, eigenlijk
    	return '[post_date]';
    }
    elseif ( is_page() ) {
        // niks, eigenlijk
    	return '[post_date]';
	}
    else {
        
    	if ( 'event' == get_post_type() ) {
        	return '';
    	}
    	elseif ( GC_KLANTCONTACT_BEELDEN_CPT == get_post_type() ) {
      	if ( is_single() ) {
        	return do_shortcode('[post_terms taxonomy="' . GC_TAX_LICENTIE . '" before=""] - [post_terms taxonomy="' . GC_TAX_ORGANISATIE . '" before=""]');
      	}
      	else {
      	}
    	}
    	elseif ( GC_KLANTCONTACT_BRIEF_CPT == get_post_type() ) {
      	if ( is_single() ) {
        	return do_shortcode('[post_terms taxonomy="' . GC_TAX_ORGANISATIE . '" before=""]');
      	}
    	}
    	elseif ( 'post' == get_post_type() ) {
      	if ( is_single() ) {
        	return  __('Geschreven door', 'gebruikercentraal' ) . ': ' . '[post_author_posts_link]';
      	}
      	else {
          	return '[post_author_posts_link] [post_date] [post_comments] ' . $socialmedia_icoontjes ;
      	}
    	} 
    	else {
        	return '[post_date]';
    	}
    }
}
//========================================================================================================

function gc_wbvb_get_date_badge() {

  $publishdate  = get_the_date();

  if ( date("Y") == get_the_date( 'Y' ) ) {
    $jaar =  '';
  }
  else {
    $jaar =  '<span class="jaar">' . get_the_date( 'Y' ) . '</span>';
  }

	echo ' <span class="date-badge" itemprop="datePublished" content="' . $publishdate . '"><span class="dag">' . get_the_date( 'd' ) . '</span> <span class="maand">' . get_the_date( 'M' ) . '</span>' . $jaar . '</span>';

}

//========================================================================================================

function gc_wbvb_add_single_socialmedia_buttons() {
  
  global $post;

  $socialmedia_icoontjes    = SOC_MED_YES;
  
  if ( function_exists( 'get_field' ) ) {
    $socialmedia_icoontjes    = get_field('socialmedia_icoontjes', $post->ID );

    if  ( ( $socialmedia_icoontjes !== SOC_MED_NO ) && ( is_single() ) )  {
      $socialmedia_icoontjes = gc_wbvb_socialbuttons($post, '' );
    }
    else {
      $socialmedia_icoontjes = '';
    }

  }
  
  echo $socialmedia_icoontjes;

}

//========================================================================================================

//Social Buttons

function gc_wbvb_socialbuttons($post_info, $hidden = '') {
	
//	return '';

    $thelink    = urlencode(get_permalink($post_info->ID));
    $thetitle   = urlencode($post_info->post_title);
    $sitetitle  = urlencode(get_bloginfo('name'));
    $summary    = urlencode($post_info->post_excerpt);
    $comment    = '';
        
    if ( $hidden ) {
        $comment    = '<!-- ey, we hoeven maar 1 werkende set sokmetknoppen te gebruiken ja? dit hiero is versiering -->';
        $thetag     = 'i';
        $hrefattr   = 'data-href';
        $popup      = ' onclick="javascript:window.open(this.dataset.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"';
    }
    else {
        $thetag = 'a';
        $hrefattr = 'href';
        $popup      = ' onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"';
    }    
    
    if ( $thelink ) {
        return $comment . '<ul class="social-media share-buttons">
            <li><' . $thetag . ' ' . $hrefattr . '="https://twitter.com/share?url=' . $thelink . '&via=' . GC_TWITTERACCOUNT . '&text=' . $thetitle . '" class="twitter" data-url="' . $thelink . '" data-text="' . $thetitle . '" data-via="' . GC_TWITTERACCOUNT . '"' . $popup . '><span class="visuallyhidden">' . __('Deel op Twitter', 'gebruikercentraal') . '</span></' . $thetag . '></li>
            <li><' . $thetag . ' class="facebook" ' . $hrefattr . '="https://www.facebook.com/sharer/sharer.php?u=' . $thelink . '&t=' . $thetitle . '"' . $popup . '><span class="visuallyhidden">' . __('Deel op Facebook', 'gebruikercentraal') . '</span></' . $thetag . '></li>
            <li><' . $thetag . ' class="linkedin" ' . $hrefattr . '="http://www.linkedin.com/shareArticle?mini=true&url=' . $thelink . '&title=' . $thetitle . '&summary=' . $summary . '&source=' . $sitetitle . '"' . $popup . '><span class="visuallyhidden">' . __('Deel op LinkedIn', 'gebruikercentraal') . '</span></' . $thetag . '></li>
            </ul>';    

//            <li><' . $thetag . ' class="googleplus" ' . $hrefattr . '="https://plus.google.com/share?url=' . $thelink . '&t=' . $thetitle . '"' . $popup . '><span>' . __('Deel op Google+', 'gebruikercentraal') . '</span></' . $thetag . '></li>

            
    }
}


//========================================================================================================
//* Customize the entry meta in the entry footer 
add_filter( 'genesis_post_meta', 'gc_wbvb_single_post_meta', 4 );

function gc_wbvb_single_post_meta($post_meta) {
    global $post;
    $return = '';
    
    if ( 
        ( ( 'post' == get_post_type() ) && ( is_single() ) ) ||
        ( ( 'event' == get_post_type() ) && ( is_single() ) ) 
         ) {
    
        
        if ( 'post' == get_post_type() )  {
//            $return = '[post_categories]    [post_tags]';
            remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
        }
        else {
            //* Remove the post meta function
            remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
            remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
        }
    }
    return $return;
}


//========================================================================================================

add_filter( 'genesis_post_title_output', 'gc_wbvb_sharebuttons_for_page_top', 15 );
 
function gc_wbvb_sharebuttons_for_page_top( $title ) {

    global $post;

    $socialmedia_icoontjes    = SOC_MED_YES;

    if ( is_page() ) {
        if ( function_exists( 'get_field' ) ) {
            $socialmedia_icoontjes    = get_field('socialmedia_icoontjes', $post->ID );
        }
        if  ( $socialmedia_icoontjes !== SOC_MED_NO )  {
            // boven moeten deelknoppen komen
            $socialmedia_icoontjes = gc_wbvb_socialbuttons($post, '' );
        }            
        else {
            $socialmedia_icoontjes = '';
        }
        $title .= $socialmedia_icoontjes;
    }

    return $title;

}


//========================================================================================================

// Ervoor zorgen dat het commentform niet leeg gelaten kan worden
add_action( 'wp_enqueue_scripts', 'gc_wbvb_comment_form_script' );

function gc_wbvb_comment_form_script() {

  if ( ( is_page() || is_single() ) ) {
    wp_enqueue_script( 'commentform', WBVB_THEMEFOLDER . '/js/commentform.js?v3', array( 'jquery' ), '', true );
    
    $protocol = isset( $_SERVER["HTTPS"] ) ? 'https://' : 'http://'; //This is used to set correct adress if secure protocol is used so ajax calls are working
    $params = array(
      'ajax_url' => admin_url( 'admin-ajax.php', $protocol ),
      'empty_email' => __( 'Voer een mailadres in alsjeblieft.', 'email-newsletter' ),
      'saving' => __( 'Saving...', 'email-newsletter' )
    );
    
    wp_localize_script( 'commentform', 'email_newsletter_widget_scripts', $params );
  
  }
}

//========================================================================================================
function debugmessage($message, $tag = 'p', $context = '') {


  if ( WP_THEME_DEBUG && WP_DEBUG ) {
    echo '<' . $tag . ' class="debugmessage">' . $message;

    if ( $context ) {
      echo ' (context: ' . $context . ')';
    }
    echo '<br/>R: ' . WP_THEME_DEBUG . ' / D: ' .  WP_DEBUG;
    echo '</' . $tag . '>';
  }

}


//========================================================================================================

add_action( 'wp_enqueue_scripts', 'gc_wbvb_add_css' );

if ( WP_DEBUG ) {
    add_action( 'wp_enqueue_scripts', 'gc_wbvb_debug_css' );
}

//========================================================================================================


/**
* Add a link first thing after the body element that will skip to the inner element.
*/

add_action( 'genesis_before_header', 'gc_wbvb_add_skip_link' );

function gc_wbvb_add_skip_link( ) {

    echo sprintf( 
        '<ul id="%7$s"><li><a href="#%4$s">%1$s</a></li><li><a href="#%5$s">%2$s</a></li><li><a href="#%6$s">%3$s</a></li></ul>',
        _x('Direct naar belangrijkste content', 'Skiplinks', 'gebruikercentraal'),
        _x('Direct naar hoofdnavigatie', 'Skiplinks', 'gebruikercentraal'), 
        _x('Direct naar zoeken', 'Skiplinks', 'gebruikercentraal'),
        ID_MAINCONTENT,
        ID_MAINNAV,
        ID_ZOEKEN,
        ID_SKIPLINKS
    );
}

//========================================================================================================

function gc_wbvb_check_actieteamlid() {

  if ( ( GC_KLANTCONTACT_BEELDEN_CPT == get_post_type() ) || ( GC_KLANTCONTACT_BRIEF_CPT == get_post_type() ) )  {
    return;
  }  
  
  // checken of dit een lid van het actieteam is

  if ( is_author() ) {

    if ( $author_id = get_query_var( 'author' ) ) { $author = get_user_by( 'id', $author_id ); }
  
  
    if( have_rows('actieteamleden', 'option') ):
  
      while( have_rows('actieteamleden', 'option') ): the_row(); 
  
        $actieteamlid = get_sub_field('actielid');
        $acf_userid   = $actieteamlid['ID'];
        
        
        if ( $author_id == $acf_userid ) {
        
          if( get_field('actieteampagina_link', 'option') ) {
            $auteursoverzichtpagina_url   = get_field('actieteampagina_link', 'option');
            $auteursoverzichtpagina_start = '<a href="' . $auteursoverzichtpagina_url . '" class="cta">' ;
            $auteursoverzichtpagina_end   = '</a>';
            $pagina_actieteam_id          = url_to_postid( $auteursoverzichtpagina_url );
            $user_info                    = get_userdata( $author_id );
            
            $displayname = ( $user_info->first_name ? $user_info->first_name : ( $user_info->display_name ? $user_info->display_name : '?' ) );
            
            if ( $pagina_actieteam_id ) {
              echo '<div class="author-info lid-actieteam">';
              echo '<div class="bg-color">';
              echo '<h2>' . $displayname . ' ' . __( 'is lid van het actieteam', 'gebruikercentraal' ) . '</h2>';
              $post   = get_post( $pagina_actieteam_id );
              $output =  apply_filters( 'the_content', $post->post_content );
              echo $output;
            	echo $auteursoverzichtpagina_start . __( 'Alle actieteamleden', 'gebruikercentraal' ) . $auteursoverzichtpagina_end;
              echo '</div>';
              echo '</div>';
              
            }
          }    
          break;
        }  
      
      endwhile;
      
    else:    
  
    endif;

  }
    
  
}

//========================================================================================================

function gc_wbvb_404_no_posts_content_header() {
  
  if ( is_author() ) {
    gc_wbvb_check_actieteamlid();
  }
  else {
  	printf( '<h2 class="entry-title">%s</h2>', __( 'Not found, error 404', 'gebruikercentraal' ) );
  }

}
//========================================================================================================

function gc_wbvb_404_no_posts_content() {

  if ( is_author() ) {
  }
  else {
    echo '<p>' . sprintf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'gebruikercentraal' ), home_url() ) . '</p>';
    echo '<p>' . get_search_form() . '</p>';
  }

}


//========================================================================================================
// voor pagina's zonder goede 404-afhandeling

remove_action( 'genesis_loop_else', 'genesis_404' );
remove_action( 'genesis_loop_else', 'genesis_do_noposts' );


add_action( 'genesis_loop', 'gc_wbvb_check_actieteamlid', 1 );

add_action( 'genesis_loop_else', 'gc_wbvb_404_no_posts_content_header', 13 );
add_action( 'genesis_loop_else', 'gc_wbvb_404_no_posts_content', 14 );
add_action( 'genesis_loop_else', 'gc_wbvb_404', 15 );


//========================================================================================================

function gc_wbvb_404() {

  if ( is_author() ) {
  }
  else {
    
  
  
  	echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';
  
          if ( is_404() ) {
              gc_wbvb_404_no_posts_content_header();
          }
  
  		echo '<div class="entry-content">';
  
         if ( is_404() ) {
              gc_wbvb_404_no_posts_content();
          }
  
          ?>
          
          	<h2><?php _e( 'Pages:', 'gebruikercentraal' ); ?></h2>
          	<ul>
          		<?php wp_list_pages( 'exclude=78,80&title_li=' ); ?>
          	</ul>
          
          	<h2><?php _e( 'Blog-artikelen:', 'gebruikercentraal' ); ?></h2>
          	<ul>
          		<?php wp_get_archives(  array( 'type' => 'postbypost'  ) ); ?>
          	</ul>
  
          
          	<h2><?php _e( 'Categories:', 'gebruikercentraal' ); ?></h2>
          	<ul>
          		<?php wp_list_categories( 'sort_column=name&title_li=' ); ?>
          	</ul>
          
          	<h2><?php _e( 'Authors:', 'gebruikercentraal' ); ?></h2>
          	<ul>
          		<?php wp_list_authors( 'exclude_admin=0&optioncount=0' ); ?>
          	</ul>
          
          <?php
  
  		echo '</div>';
  
  		echo genesis_html5() ? '</article>' : '</div>';
  }
}

//========================================================================================================
function dovardump($data, $description = '' ) {
    if ( $description ) {
      echo '<h1>' . $description . ':</h1>';
    }
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}	    

//========================================================================================================

function gc_wbvb_add_blog_single_css() {

  global $imgbreakpoints;

  wp_enqueue_style(
    ID_SINGLE_CSS,
    WBVB_THEMEFOLDER . '/blogberichten.css'
  );

  $BLOGBERICHTEN_CSS   = '';


  if ( have_posts() ) : 
  
    $countertje = 0;
  
    while ( have_posts() ) : the_post();
  
      // do loop stuff
      $countertje++;
      $postid       = get_the_ID();
      $permalink    = get_permalink( $postid );
      $publishdate  = get_the_date();
      $theID        = 'featured_image_post_' . $postid;
      $the_image_ID = 'image_' . $theID;
      $extra_class  = '';
      $class        = 'feature-image noimage';
  
      // check of het eerste bericht een enorme afbeelding heeft
  
      if (has_post_thumbnail( $postid ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), IMG_SIZE_HUGE );

        if ( $image[1] >= IMG_SIZE_HUGE_MIN_WIDTH ) {

			    foreach ( $imgbreakpoints as $breakpoint ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $breakpoint['img_size_archive_list'] );
            $BLOGBERICHTEN_CSS .= '@media only screen and ('  . $breakpoint['direction'] .  '-width: ' . $breakpoint['width'] . " ) {\n";
            $BLOGBERICHTEN_CSS .= " .content:before { \n";
            $BLOGBERICHTEN_CSS .= "   content: ' ';\n";
            $BLOGBERICHTEN_CSS .= "   display: block;\n";
            $BLOGBERICHTEN_CSS .= "   padding-top: " . $breakpoint['header-padding'] . ";\n";
            $BLOGBERICHTEN_CSS .= "   background-image: url('" . $image[0] . "');\n";
            $BLOGBERICHTEN_CSS .= "   background-size: cover;\n";
            $BLOGBERICHTEN_CSS .= "   background-position: center center;\n";
            $BLOGBERICHTEN_CSS .= " } \n";
            $BLOGBERICHTEN_CSS .= "} \n";
			    }
          
          $class      = 'feature-image';
          $extra_class  = ' enorm-huge';
  
        }
        else {

          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'medium' );

          if ( $image[0] ) {
  
            foreach ( $imgbreakpoints as $breakpoint ) {
              if ( $breakpoint['content-before'] ) {

                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), $breakpoint['img_size_single'] );

                $BLOGBERICHTEN_CSS .= '@media only screen and ('  . $breakpoint['direction'] .  '-width: ' . $breakpoint['width'] . " ) {\n";
                $BLOGBERICHTEN_CSS .= " .content .entry-content:before { \n";
                $BLOGBERICHTEN_CSS .= "   content: ' ';\n";
                $BLOGBERICHTEN_CSS .= "   width: " . $image[1] . "px;\n";
                $BLOGBERICHTEN_CSS .= "   height: " . $image[2] . "px;\n";
                $BLOGBERICHTEN_CSS .= "   margin: 0 0 16px 16px;\n";
                $BLOGBERICHTEN_CSS .= "   display: block;\n";
                $BLOGBERICHTEN_CSS .= "   float: right;\n";
                $BLOGBERICHTEN_CSS .= "   background-image: url('" . $image[0] . "');\n";
                $BLOGBERICHTEN_CSS .= "   background-size: cover;\n";
                $BLOGBERICHTEN_CSS .= " } \n";
                $BLOGBERICHTEN_CSS .= "} \n";
              }
            }
          }
          else {
           // heeft geen image
          }
        }
      }

    
    endwhile; /** end of one post **/

  else : /** if no posts exist **/

  endif; /** end loop **/



  wp_add_inline_style( ID_SINGLE_CSS, $BLOGBERICHTEN_CSS );

}	    

//========================================================================================================

function gc_wbvb_add_berichten_widget_css() {

    $args = array(
        'post_type'             =>  'post',
        'posts_per_page'        =>  5, 
        'ignore_sticky_posts'   =>  1, 
        'order'                 =>  'DESC',
        'orderby'               =>  'date'
      );
    

    $sidebarposts = new WP_query( $args );

    wp_enqueue_style(
      ID_BLOG_WIDGET_CSS,
      WBVB_THEMEFOLDER . '/css/blanco.css'
    );
  
    $custom_css = '';
    
    $countertje = 0; // Run your normal loop

    if ($sidebarposts->have_posts()) {
      
      while ($sidebarposts->have_posts()) : $sidebarposts->the_post();
      
        // do loop stuff
        $countertje++;
        $getid        = get_the_ID();
        $theID        = 'featured_image_post_' . $getid;

        if (has_post_thumbnail( $sidebarposts->ID ) ) {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $sidebarposts->ID ), 'medium' );
          
          if ( $image[0] ) {
            $custom_css .= '#' . $theID . " { \n";
            $custom_css .= "background-image: url('" . $image[0] . "');\n";
            $custom_css .= "}\n";
          }
        }
      
      endwhile;
      
      wp_reset_postdata();
    
    }

    wp_add_inline_style( ID_BLOG_WIDGET_CSS, $custom_css );

}	    

//========================================================================================================

function gc_wbvb_add_beeldbank_foto_css() {

  global $imgbreakpoints;
  global $post;

  wp_enqueue_style(
    ID_BLOGBERICHTEN_CSS,
    WBVB_THEMEFOLDER . '/blogberichten.css'
  );

  $BLOGBERICHTEN_CSS  = '';
  $countertje         = 0;

  $brief_page_overview          = get_field('brief_page_overview', 'option');
  $beelden_page_overview        = get_field('beelden_page_overview', 'option');
  
  $post_type = GC_KLANTCONTACT_BEELDEN_CPT;
  if ( $brief_page_overview == $post->ID ) {
    $post_type = GC_KLANTCONTACT_BRIEF_CPT;
  }

	$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  $args   = array(
          'post_type'       => $post_type,
          'post_status'     => 'publish',
          'paged'           => $paged
        );
  
  $wp_query = new WP_Query( $args );

  if ( $wp_query->have_posts() ) : 
  
  
    while ( $wp_query->have_posts() ) : $wp_query->the_post();
  
      // do loop stuff
      $countertje++;
      $getid        = get_the_ID();
      $theID        = 'featured_image_post_' . $getid;
      $the_image_ID = 'image_' . $theID;
  
    	if ( GC_KLANTCONTACT_BEELDEN_CPT == get_post_type( $getid ) ) {

    		$attachment     = get_field('beeld_foto', $getid );
    		if ( isset( $attachment['ID'] ) ) {
          $image = wp_get_attachment_image_src( $attachment['ID'], 'medium' );
        }
    	}
      elseif (has_post_thumbnail( $getid ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), 'medium' );
      }

      if ( isset( $image[0] ) ) {
        $BLOGBERICHTEN_CSS .= '#' . $the_image_ID . " { ";
        $BLOGBERICHTEN_CSS .= "background-image: url('" . $image[0] . "'); /* gc_wbvb_add_beeldbank_foto_css */ ";
        $BLOGBERICHTEN_CSS .= "} ";
      }

    endwhile; /** end of one post **/

  else : /** if no posts exist **/

  endif; /** end loop **/


  wp_add_inline_style( ID_BLOGBERICHTEN_CSS, $BLOGBERICHTEN_CSS );

}	    

//========================================================================================================

function gc_wbvb_add_blog_archive_css() {

  global $imgbreakpoints;

  wp_enqueue_style(
    ID_BLOGBERICHTEN_CSS,
    WBVB_THEMEFOLDER . '/blogberichten.css'
  );



  $BLOGBERICHTEN_CSS   = '';
  $countertje   = 0;

  if ( have_posts() ) : 
  
  
    while ( have_posts() ) : the_post();
  
      // do loop stuff
      $countertje++;
      $getid        = get_the_ID();
      $posttype     = get_post_type( $getid );
      $permalink    = get_permalink( $getid );
      $publishdate  = get_the_date();
      $theID        = 'featured_image_post_' . $getid;
      $the_image_ID = 'image_' . $theID;
      $extra_class         = '';
      $class        = 'feature-image noimage';
  
      // check of het eerste bericht een enorme afbeelding heeft
      if ( $countertje == 1 && 'post' == $posttype ) {
  
        	if (has_post_thumbnail( $getid ) ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), IMG_SIZE_HUGE );
  
            if ( $image[1] >= IMG_SIZE_HUGE_MIN_WIDTH ) {
  
  				    foreach ( $imgbreakpoints as $breakpoint ) {
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), $breakpoint['img_size_archive_list'] );
                $BLOGBERICHTEN_CSS .= '@media only screen and ('  . $breakpoint['direction'] .  '-width: ' . $breakpoint['width'] . " ) {\n";
                $BLOGBERICHTEN_CSS .= ' #' . $the_image_ID . " { \n";
                $BLOGBERICHTEN_CSS .= "   background-image: url('" . $image[0] . "');\n";
                $BLOGBERICHTEN_CSS .= " } \n";
                $BLOGBERICHTEN_CSS .= "} \n";
  				    }
              
              $class      = 'feature-image';
              $extra_class  = ' enorm-huge';
      
            }
            else {
  
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), 'medium' );
  
              if ( $image[0] ) {
                $BLOGBERICHTEN_CSS .= '#' . $the_image_ID . " { \n";
                $BLOGBERICHTEN_CSS .= " background-image: url('" . $image[0] . "');\n";
                $BLOGBERICHTEN_CSS .= "} \n";
                $class = 'feature-image';
              }
              else {
               // heeft geen image
              }
            }
          }
      }
      else {

      	if ( GC_KLANTCONTACT_BEELDEN_CPT == get_post_type( $getid ) ) {

      		$attachment     = get_field('beeld_foto', $getid );
      		if ( isset( $attachment['ID'] ) ) {
            $image = wp_get_attachment_image_src( $attachment['ID'], 'medium' );
          }
      	}
        elseif (has_post_thumbnail( $getid ) ) {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), 'medium' );
        }

        if ( $image[0] ) {
          $BLOGBERICHTEN_CSS .= '#' . $the_image_ID . " { \n";
          $BLOGBERICHTEN_CSS .= "background-image: url('" . $image[0] . "');\n";
          $BLOGBERICHTEN_CSS .= "} \n";
          $class = 'feature-image';
        }
        
      }
    
    endwhile; /** end of one post **/

  else : /** if no posts exist **/

  endif; /** end loop **/

  wp_add_inline_style( ID_BLOGBERICHTEN_CSS, $BLOGBERICHTEN_CSS );

}



function gc_wbvb_add_css() {

	wp_enqueue_style(
		ID_SKIPLINKS,
		WBVB_THEMEFOLDER . '/css/blanco.css'
	);

    $custom_css = '

    
ul#' . ID_SKIPLINKS . ', ul#' . ID_SKIPLINKS . ' li {
    list-style-type: none;
    list-style-image: none;
    padding: 0;
    margin: 0;
}
ul#' . ID_SKIPLINKS . ' li {
    background: none;
}
#' . ID_SKIPLINKS . ' li a {
    position: absolute;
    top: -1000px;
    left: 50px;
}
#' . ID_SKIPLINKS . ' li a:focus {


    left: 6px;
    top: 7px;
    height: auto;
    width: auto;
    display: block;
    font-size: 14px;
    font-weight: 700;
    padding: 15px 23px 14px;
    background: #f1f1f1;
    color: #21759b;
    z-index: 100000;
    line-height: normal;
    text-decoration: none;
    -webkit-box-shadow: 0 0 2px 2px rgba(0,0,0,.6);
    box-shadow: 0 0 2px 2px rgba(0,0,0,.6)
}

#' . ID_MAINNAV . ':focus {
    position: relative;
    z-index: 100000;
}

#' . ID_MAINNAV . ' a:focus {
    position: relative;
    z-index: 100000;
/*    background: #006985; */
    color: #fff;
}


#' . ID_ZOEKEN . ':focus label {
    position: relative;
    left: 0;
    top: 0;
}';
    wp_add_inline_style( ID_SKIPLINKS, $custom_css );

}

//========================================================================================================
/* CSS voor admin, site en debug
*/

function admin_append_editor_styles() {
    add_editor_style(WBVB_THEMEFOLDER . '/css/editor-styles.css?v3');
}

add_action( 'init', 'admin_append_editor_styles' );


//========================================================================================================


// Change favicon location and add touch icons
add_filter( 'genesis_pre_load_favicon', 'gc_wbvb_add_favicon_filter' );

function gc_wbvb_add_favicon_filter( $favicon ) 
{
	
	$nuttig = false;
	
    echo '<link rel="Shortcut Icon" href="' . WBVB_THEMEFOLDER . '/images/favicon.ico" type="image/x-icon" />' . "\n";
	if ( $nuttig ) {
		
	    echo '<link rel="apple-touch-icon" sizes="60x60" href="' . WBVB_THEMEFOLDER . '/images/icon-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="60x60" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-60x60-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="120x120" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-120x120-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="57x57" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-57x57-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-114x114-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="76x76" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-76x76-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-152x152-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-72x72-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-144x144-precomposed.png" />'."\n";
	    echo '<link rel="apple-touch-icon-precomposed" href="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-precomposed.png" />'."\n";
	
	    echo '<meta name="apple-mobile-web-app-capable" content="yes">'."\n";
	    echo '<meta name="msapplication-TileImage" content="' . WBVB_THEMEFOLDER . '/images/apple-touch-icon-precomposed.png"/>'."\n";
	    echo '<meta name="msapplication-TileColor" content="#BFD00C"/>'."\n";
	    echo '<meta name="msapplication-navbutton-color" content="#BFD00C" />'."\n";
	    echo '<meta name="msapplication-tooltip" content="' . get_bloginfo('description') . '" />'."\n";
	    echo '<meta name="msapplication-starturl" content="/" />'."\n";
	
	    echo '<meta name="application-name" content="' . get_bloginfo('name') . '" />'."\n";
	    echo '<meta name="generator" content="' . get_bloginfo('name') . '" />'."\n";
	}    

    
}

//========================================================================================================

//* Hook after post widget area after post content
genesis_widget_area( 'after-post', array( 'before' => 'AFTER POOST<div class="after-post widget-area">', 'after' => '</div>' ) );

//========================================================================================================


// LOGIN PAGE WIDGET for users not currently logged in
function gc_wbvb_write_widget_site_footer() {
    if ( !dynamic_sidebar( GC_WBVB_WIDGET_SITE_FOOTER ) ) {
        // do nothing
    }     
}

genesis_register_sidebar(   
    array(
        'name'              => __( "Widget in de site footer", 'gebruikercentraal' ),
        'id'                => GC_WBVB_WIDGET_SITE_FOOTER,
        'description'       => __( "Ruimte voor widgets in de site footer. Hier bijvoorbeeld footerlinks.", 'gebruikercentraal' ),
		'before_widget' => genesis_markup( array(
			'html5' => '<div id="%1$s" class="widget %2$s site-footer-widget '.GC_WBVB_WIDGET_SITE_FOOTER . '"><div class="widget-wrap">',
			'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'echo'  => false,
		) ),
		'after_widget'  => genesis_markup( array(
			'html5' => '</div></div>' . "\n",
			'xhtml' => '</div></div>' . "\n",
			'echo'  => false
		) ),
		'before_title'  => '<h2 class="widget-title widgettitle">',
		'after_title'   => "</h2>\n",
    )
);


//* Customize the site footer
add_action( 'genesis_footer', 'gc_wbvb_bg_custom_footer' );
function gc_wbvb_bg_custom_footer() { 
    gc_wbvb_write_widget_site_footer(); 
}

//========================================================================================================
function gc_wbvb_home_append_to_header() {
	echo '<div class="breadcrumb"><div class="wrap">' . get_search_form(false) . '</div></div>';
}

//========================================================================================================



// LOGIN PAGE WIDGET for users not currently logged in
function gc_wbvb_write_widget_home_widget_left() {
    if ( !dynamic_sidebar( GC_WBVB_WIDGET_HOME_WIDGET_1 ) ) {
        // do nothing
    }     
}

genesis_register_sidebar(   
    array(
        'name'              => __( "Home-widget links", 'gebruikercentraal' ),
        'id'                => GC_WBVB_WIDGET_HOME_WIDGET_1,
        'description'       => __( "Hier kun je de widgets plaatsen voor events en blogberichten", 'gebruikercentraal' ),
		'before_widget' => genesis_markup( array(
			'html5' => '<div id="%1$s" class="widget %2$s '.GC_WBVB_WIDGET_HOME_WIDGET_1 . '"><div class="widget-wrap">',
			'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'echo'  => false,
		) ),
		'after_widget'  => genesis_markup( array(
			'html5' => '</div></div>' . "\n",
			'xhtml' => '</div></div>' . "\n",
			'echo'  => false
		) ),
		'before_title'  => '<h2 class="widget-title widgettitle">',
		'after_title'   => "</h2>\n",
    )
);

//========================================================================================================



// LOGIN PAGE WIDGET for users not currently logged in
function gc_wbvb_write_widget_home_widget_right() {
    if ( !dynamic_sidebar( GC_WBVB_WIDGET_HOME_WIDGET_2 ) ) {
        // do nothing
    }     
}

genesis_register_sidebar(   
    array(
        'name'              => __( "Home-widget rechts", 'gebruikercentraal' ),
        'id'                => GC_WBVB_WIDGET_HOME_WIDGET_2,
        'description'       => __( "Hier kun je de widgets plaatsen voor o.m. het actieteam", 'gebruikercentraal' ),
		'before_widget' => genesis_markup( array(
			'html5' => '<div id="%1$s" class="widget %2$s '.GC_WBVB_WIDGET_HOME_WIDGET_2 . '"><div class="widget-wrap">',
			'xhtml' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'echo'  => false,
		) ),
		'after_widget'  => genesis_markup( array(
			'html5' => '</div></div>' . "\n",
			'xhtml' => '</div></div>' . "\n",
			'echo'  => false
		) ),
		'before_title'  => '<h2 class="widget-title widgettitle">',
		'after_title'   => "</h2>\n",
    )
);


//========================================================================================================



function gc_wbvb_home_manifest() {
	
	global $post;
	setup_postdata($post);

	echo '<article class="manifest entry" itemscope="" itemtype="http://schema.org/CreativeWork">';
	echo '<header><h1 class="entry-title" itemprop="headline">'; 
	the_title();
	echo '</h1></header>';
	echo '<div class="content">';
	
	the_content();
	
	if ( function_exists( 'get_field' ) ) {
		if ( get_field('lees-meer-link') ) {
			echo '<a class="cta" href="' . get_field('lees-meer-link') . '">' . get_field('lees-meer-tekst') . '</a>';
		}
		else {
		}
	}	
	echo '</div>';
	echo '</article>';

	echo '<div id="home-widgets-left">';
	gc_wbvb_write_widget_home_widget_left();
	echo '</div>';
	echo '<div id="home-widgets-right">';
	gc_wbvb_write_widget_home_widget_right();
	echo '</div>';
}

//========================================================================================================

//========================================================================================================

// remove Open Sans font
// Remove Open Sans that WP adds from frontend

if (!function_exists('gc_wbvb_remove_wp_open_sans')) :

	function gc_wbvb_remove_wp_open_sans() {

		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		
		if ( !is_admin() ) {
		// filter to remove TinyMCE emojis
		add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );		
		}
		
		
	}

	add_action('wp_enqueue_scripts', 'gc_wbvb_remove_wp_open_sans');
	
	// Uncomment below to remove from admin
	add_action('admin_enqueue_scripts', 'gc_wbvb_remove_wp_open_sans');

endif;

//========================================================================================================
// options page 
if( function_exists('acf_add_options_page') ):

	$args = array(
		'slug' => 'instellingen',
		'title' => 'Theme-instelling',
		'parent' => 'themes.php'
	); 
	
		acf_add_options_page($args);

endif;

//========================================================================================================

function gc_wbvb_eventmanager_custom_formats( $array_in ){

  $my_formats = array();
  
  
  if ( ( 'page'    == get_post_type() ) ||
      ( 'post'    == get_post_type() ) ||
      ( 'event'   == get_post_type() ) 
    ) {
    if ( is_page() ) {
      $my_formats = array(
        'dbem_event_list_item_format',
        'dbem_event_list_item_format_header',
        'dbem_event_list_item_format_footer',
        'dbem_event_single_format', 
      );
    }
    elseif ( is_single() ) {
      $my_formats = array('dbem_single_event_format'); //the format you want to override, corresponding to file above.
    }
  }
  else {
  
  }
  
  return array_merge($array_in,  $my_formats); //return the default array and your formats.
}

add_filter('em_formats_filter', 'gc_wbvb_eventmanager_custom_formats', 1, 1);

//========================================================================================================

add_filter('em_event_output_placeholder','gc_wbvb_eventmanager_styles_placeholders',1,3);

function gc_wbvb_eventmanager_styles_placeholders($replace, $EM_Event, $result){
	global $wp_query;
	global $wp_rewrite;
	global $EM_Event;

	
	switch( $result ){
		case '#_EVENTEXCERPT':

      if ( $EM_Event->post_excerpt !== '') {
        $return  = $EM_Event->post_excerpt;
        
      }
      else {
        $return  = $EM_Event->post_content;
      }
      
      
      return strip_tags ( $return, '<br>' );
      
			
			break;
			
		case '#_AVAILABILITYCHECK':


      if ( ( $EM_Event->get_bookings()->get_available_spaces() <= 0 ) && ( $EM_Event->get_bookings()->tickets->tickets ) ) {
        return '<div class="tickets unavailable">' . __( 'zit vol', 'gebruikercentraal' ) . '</div>';
      }
      else {
        return '';
      }

			break;
		  
		case '#_DATEBADGE':

      $event_start_datetime     = strtotime( $EM_Event->event_start_date . ' ' . $EM_Event->event_start_time );

      if ( date("Y") == date_i18n('Y', $event_start_datetime) ) {
        $jaar =  '';
      }
      else {
        $jaar =  '<span class="jaar">' . date_i18n('Y', $event_start_datetime) . '</span>';
      }
      
      return '<span class="dag">' . date_i18n('d', $event_start_datetime) . '</span><span class="maand">' . date_i18n('M', $event_start_datetime) . '</span>' . $jaar;			
			break;

		case '#_EVENTLOCATIONMETA':

      $event_start_datetime     = strtotime( $EM_Event->event_start_date . ' ' . $EM_Event->event_start_time );

      if ( $EM_Event->location_id ) {
        return '<div class="event-location">#_LOCATIONNAME</div>';
      }
      else {
        return '';  
      }
      
			break;
			
	}
	return $replace;
}
//========================================================================================================

function gc_wbvb_clean_url( $url_to_clean ) {

    $url_to_clean_linktext = $url_to_clean;
	
	if(substr($url_to_clean_linktext, -1) == '/') {
		$url_to_clean_linktext = substr($url_to_clean_linktext, 0, -1);
	}
	
	$link_array = explode('/',$url_to_clean_linktext);
	$url_to_clean_linktext	=	end($link_array);


	$pos = strpos($url_to_clean_linktext, '#');
	if ($pos ) {
		$link_array = explode('#',$url_to_clean_linktext);
		$url_to_clean_linktext	=	$link_array[0];
	}			

	if(substr(strtolower($url_to_clean_linktext), -4) == '.pdf') {
		$url_to_clean_linktext = substr($url_to_clean_linktext, 0, -4);
		$url_to_clean_toevoeging = ' (PDF)';
	}

	if(substr(strtolower($url_to_clean_linktext), -5) == '.html') {
		$url_to_clean_linktext = substr($url_to_clean_linktext, 0, -5);
	}
	
	$url_to_clean_linktext = str_replace("_", " ", $url_to_clean_linktext);
	$url_to_clean_linktext = str_replace("-", " ", $url_to_clean_linktext);
    
    
    return $url_to_clean_linktext;
        
}


//========================================================================================================


function gc_wbvb_event_get_programma() {

  global $post;
  
  $return = '';

  if ( function_exists( 'have_rows' ) ) {
  
    if( have_rows( 'programmaonderdelen' ) ) {
      
      $return = '<div id="programma"><h2>' . _x('Programma', 'Kopje op evenementpagina', 'gebruikercentraal') . '</h2>';
      $return .= '<ul class="event-program">';
      
      // loop through the rows of data
      while ( have_rows('programmaonderdelen') ) : the_row();
      
        $programmaonderdeel_tijd            = strip_tags( get_sub_field('programmaonderdeel_tijd'), '<br>' );
        $programmaonderdeel_beschrijving    = strip_tags( get_sub_field('programmaonderdeel_beschrijving'), '<br>' );
        
        $programmaonderdeel_beschrijving = '<span class="beschrijving">' . $programmaonderdeel_beschrijving . '</span>';
        
        if ( $programmaonderdeel_tijd ) {
          $programmaonderdeel_tijd = '<span class="tijd">' . $programmaonderdeel_tijd . '</span>';
        }
  
        $return .= '<li>' . $programmaonderdeel_tijd  . $programmaonderdeel_beschrijving . '</li>';
      
      endwhile;
      
      $return .= '</ul></div>';
  
    }    
  }
  else {
    echo 'de ACF custom fields plugin is niet actief.';
  }

  
  return $return;
  
}


//========================================================================================================


function gc_wbvb_post_print_downloads() {
  echo gc_wbvb_post_get_downloads();
}



//========================================================================================================


function gc_wbvb_post_print_links() {
  echo gc_wbvb_post_get_links();
}

//========================================================================================================


function gc_wbvb_post_get_downloads() {

  global $post;
  
  $return = '';

  if ( function_exists( 'have_rows' ) ) {
  
    if( have_rows( 'post_downloads_collection' ) ) {
    
      $return = '<h2>' . _x('Downloads', 'Kopje op berichtpagina', 'gebruikercentraal') . '</h2>';
      $return .= '<ul class="link-list">';
      
      // loop through the rows of data
      while ( have_rows('post_downloads_collection') ) : the_row();
        
        $event_link_linktekst     = strip_tags( get_sub_field('post_download_title'), '' );
        $post_download_filetype   = strip_tags( get_sub_field('post_download_filetype'), '' );
        $post_download_file       = get_sub_field('post_download_file');
        $size_to_display          = size_format( filesize( get_attached_file( $post_download_file['ID'] ) ) ); 
  
        if ( !$event_link_linktekst ) {
          $event_link_linktekst = gc_wbvb_clean_url( $post_download_file['url'] );
        }
  
        if ( $size_to_display && $post_download_filetype ) {
          $event_link_linktekst .= ' (' . $post_download_filetype . ', ' . $size_to_display . ')';
        }
        else {
          if ( $post_download_filetype ) {
            $event_link_linktekst .= ' (' . $post_download_filetype . ')';
          }
          elseif ( $size_to_display ) {
            $event_link_linktekst .= ' (' . $size_to_display . ')';
          }
        }
        
        $return .= '<li><a href="' . $post_download_file['url'] . '" itemprop="url">' . $event_link_linktekst . '</a></li>';
      
      endwhile;
      
      $return .= '</ul>';
    } 
  } 
  else {
    echo 'de ACF custom fields plugin is niet actief.';
  }
   
  return $return;
}

//========================================================================================================

function gc_wbvb_beelden_brieven_show_connected_files() {
  
  if ( GC_KLANTCONTACT_BEELDEN_CPT == get_post_type() ) {
    $titel          = "Brieven";
    $beschrijving   = "Deze foto wordt gebruikt in deze brieven gebruikt:";
  } 
  else {
    $titel          = "Foto's";
    $beschrijving   = "Deze brief gebruikt deze foto's:";
  }

  $return = '';

  if ( function_exists( 'have_rows' ) ) {

    $posts = get_field('beelden_brieven_connectie');

    if( $posts ) {    

      $return = '<div class="connected-files for-' . get_post_type() . '"><h2>' . $titel . '</h2>';
      if ( $beschrijving ) {
        $return .= '<p>' . $beschrijving . '</p>';
      }
      $return .= '<ul class="link-list">';
      
      // loop through the rows of data
      foreach( $posts as $p ) {

        $plaatje = '';
        $size   = BLOG_SINGLE_MOBILE;

        if (has_post_thumbnail( $p->ID ) ) {
  
          $image  = wp_get_attachment_image_src( get_post_thumbnail_id( $p->ID ), $size );
          if ( isset( $image[0] ) ) {
            $plaatje = '<img src="' . $image[0] . '" alt="" width="' . $image[1] . '" height="' . $image[2] . '" />';
          }
  
        }
        else {
      		$attachment     = get_field('beeld_foto', $p->ID );
      		if ( isset( $attachment['ID'] ) ) {

            // thumbnail
            $thumb  = $attachment['sizes'][ $size ];
            $width  = $attachment['sizes'][ $size . '-width' ];
            $height = $attachment['sizes'][ $size . '-height' ];
        		
            $plaatje = '<img src="' . $thumb . '" alt="' . $attachment['alt'] . '" width="' . $width . '" height="' . $height . '" />';
          }
        }
        
        
        $return .= '<li><a href="' . get_permalink( $p->ID ) . '" itemprop="url">' . $plaatje . ' ' . get_the_title( $p->ID ) . '</a></li>';
      
      }
      
      $return .= '</ul>';
      $return .= '</div>';
    }
    else {
      
    } 
  } 
  else {
    echo 'de ACF custom fields plugin is niet actief.';
  }
   
  echo $return;
}

//========================================================================================================


function gc_wbvb_post_get_links() {

  global $post;
  
  $return = '';

  if ( function_exists( 'have_rows' ) ) {
    
    if( have_rows( 'event_post_links_collection' ) ) {
    
      $return = '<h2>' . _x('Links', 'Kopje op bericht- of evenementpagina', 'gebruikercentraal') . '</h2>';
      $return .= '<ul class="link-list">';
      
      // loop through the rows of data
      while ( have_rows('event_post_links_collection') ) : the_row();
        
        $event_link_url         = strip_tags( get_sub_field('event_post_link_url'), '' );
        $event_link_linktekst   = strip_tags( get_sub_field('event_post_link_linktekst'), '' );
        
        if ( !$event_link_linktekst ) {
          $event_link_linktekst = gc_wbvb_clean_url( $event_link_url );
        }
        
        $return .= '<li><a href="' . $event_link_url . '" itemprop="url">' . $event_link_linktekst . '</a></li>';
      
      endwhile;
      
      $return .= '</ul>';
      
    }
  }
  else {
    echo 'de ACF custom fields plugin is niet actief.';
  }
  return $return;
}

//========================================================================================================


function gc_wbvb_event_get_organizer_info() {
  global $post;
  return gc_wbvb_authorbox_compose_box( get_the_author_meta('ID') );
}


//========================================================================================================

if ( ! function_exists( 'gc_wbvb_comment_nav' ) ) :

  function gc_wbvb_comment_nav() {
  	// Are there comments to navigate through?
  	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
  	?>
  	<nav class="navigation comment-navigation" role="navigation">
  		<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'gebruikercentraal' ); ?></h2>
  		<div class="nav-links">
  			<?php
  				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'gebruikercentraal' ) ) ) :
  					printf( '<div class="nav-previous">%s</div>', $prev_link );
  				endif;
  
  				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'gebruikercentraal' ) ) ) :
  					printf( '<div class="nav-next">%s</div>', $next_link );
  				endif;
  			?>
  		</div><!-- .nav-links -->
  	</nav><!-- .comment-navigation -->
  	<?php
  	endif;
  }
  
endif;


//========================================================================================================

function gc_wbvb_comment_item($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $status = '';

    if ( $comment->comment_approved == '0' ) {
      $status = ' data-status="comment-awaiting-moderation"';
    }
    
    ?>
    <<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>"<?php echo $status ?>>

    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>

    <?php if ( $comment->comment_approved == '0' ) : ?>
         <em class="comment-awaiting-moderation"><?php _e( 'Je reactie moet nog beoordeeld worden', 'gebruikercentraal' ); ?></em>
          <br />
    <?php endif; ?>


    <div class="comment-author vcard">
        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        <?php printf( __( '<cite class="fn">%s</cite> <span class="says">schreef:</span>' ), get_comment_author_link() ); ?>
    </div>

    <div class="comment-content">
    <?php comment_text(); ?>
    </div>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
        <?php
        /* translators: 1: date, 2: time */
        printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
        ?>

      <div class="reply">
          <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
      </div>
        
    </div>


    
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
    <?php
    }
//========================================================================================================

function gc_wbvb_write_widget_loginpage_logged_in() {
  
}

//========================================================================================================

function gc_wbvb_write_widget_loginpage_not_logged_in() {
  
}

//========================================================================================================

function gc_wbvb_archive_loop() {

  //** Use old loop hook structure if < HTML5
  if ( ! genesis_html5() ) {
    genesis_legacy_loop();
    return;
  }


  $countertje   = 0;

  if ( have_posts() ) : 
  
    echo '<div class="archive-list">';
  
    while ( have_posts() ) : the_post();
  
    // do loop stuff
    $countertje++;
    $getid        = get_the_ID();
    $posttype     = get_post_type( $getid );
    $permalink    = get_permalink( $getid );
    $publishdate  = get_the_date();
    $theID        = 'featured_image_post_' . $getid;
    $the_image_ID = 'image_' . $theID;
    $extra_class         = '';
    $class        = 'feature-image noimage';

    // check of het eerste bericht een enorme afbeelding heeft
    if ( $countertje == 1 ) {

        if (has_post_thumbnail( $getid ) ) {
          $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), IMG_SIZE_HUGE );

          if ( $image[1] >= IMG_SIZE_HUGE_MIN_WIDTH ) {

            $class      = 'feature-image';
            if ( 'post' == $posttype ) {
              $extra_class  = ' enorm-huge';
            }
    
          }
          else {

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), 'medium' );

            if ( $image[0] ) {
              $class = 'feature-image';
            }
            else {
             // heeft geen image
            }
          }
        }
    }
    else {
      if (has_post_thumbnail( $getid ) ) {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $getid ), 'medium' );
  
        if ( $image[0] ) {
          $class = 'feature-image';
        }
      }
    }
    
    echo '<section class="entry' . $extra_class . '" itemid="' . $permalink . '" itemscope itemtype="http://schema.org/SocialMediaPosting" id="' . $theID . '">';
    echo '<a href="' . $permalink . '" itemprop="url">';
    echo '<div id="' . $the_image_ID . '" class="' . $class . '">&nbsp;</div>';
    echo '<div class="bloginfo">';

      if ( date("Y") == get_the_date( 'Y' ) ) {
        $jaar =  '';
      }
      else {
        $jaar =  '<span class="jaar">' . get_the_date( 'Y' ) . '</span>';
      }

    
    echo '<header><span class="date-badge" itemprop="datePublished" content="' . $publishdate . '"><span class="dag">' . get_the_date( 'd' ) . '</span> <span class="maand">' . get_the_date( 'M' ) . '</span>' . $jaar . '</span>';        
    echo '<h2 class="entry-title" itemprop="headline">';
    the_title();
    echo '</h2></header>';
    echo '<div class="excerpt">';
    echo the_excerpt();
    echo '</div>';
    echo '</div>';
    echo '</a>';
    echo '</section>'; 
    
  endwhile; /** end of one post **/
    do_action( 'genesis_after_endwhile' );
    


    echo '</div>';


  else : /** if no posts exist **/
    do_action( 'genesis_loop_else' );
  endif; /** end loop **/

}


//========================================================================================================





function gc_wbvb_add_taxonomy_description() {
    global $wp_query;


    if ( ! is_category() && ! is_tag() && ! is_tax() && ! is_page() )
        return;

//    if ( get_query_var( 'paged' ) >= 2 )
//        return;

    $term = is_tax() ? get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ) : $wp_query->get_queried_object();

    if ( ! $term || ! isset( $term->meta ) )
        return;

    $headline   = '';
    $intro_text = '';

    if ( is_page() ) {
        $headline = sprintf( '<h1 class="archive-title">%s</h1>', get_the_title() );
    }
    if ( $term->name )
        $headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->name ) );
        
    if ( isset( $term->meta['headline'] ) )
        $headline = sprintf( '<h1 class="archive-title">%s</h1>', strip_tags( $term->meta['headline'] ) );
        
    if ( isset( $term->meta['intro_text'] ) )
        $intro_text = apply_filters( 'genesis_term_intro_text_output', $term->meta['intro_text'] );

    if ( $term->description ) {
        $intro_text = apply_filters( 'genesis_term_intro_text_output', $term->description );
    }

    if ( $headline || $intro_text ) {
        printf( '<div class="taxonomy-description">%s</div>', $headline . $intro_text );
    }
    else {
        echo '';
    }

}

//========================================================================================================

function gc_wbvb_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'gc_wbvb_remove_genesis_page_templates' );

//========================================================================================================

add_filter ( 'genesis_next_link_text' , 'gc_wbvb_paging_next' );
function gc_wbvb_paging_next ( $text ) {
	if ( is_category() ) {
	    return '<span>' . __( "Ouder", 'gebruikercentraal' ) . '</span>';
    }
    else {
	    return $text;
    }
}

add_filter ( 'genesis_prev_link_text' , 'gc_wbvb_paging_previous' );
function gc_wbvb_paging_previous ( $text ) {
	if ( is_category() ) {
	    return '<span>' . __( "Nieuwer", 'gebruikercentraal' ) . '</span>';
    }
    else {
	    return $text;
    }
}

//========================================================================================================

function eo_prev_next_post_nav() {
  
    if ( is_single() ) {

        echo '<nav class="pagination">';
        previous_post_link( '<div class="pagination-previous alignleft">%link</div>', '%title' );
        next_post_link( '<div class="pagination-next alignright">%link</div>', '%title' );
        echo '</nav><!-- .prev-next-navigation -->';
 
    }
 
}

//========================================================================================================

function gc_wbvb_add_wrap_class($attributes) {
	$attributes['class'] .= ' wrap';
	return $attributes;
}

//========================================================================================================

add_action( 'wp_enqueue_scripts', 'wbvb_jqscripts' );

function wbvb_jqscripts() {
  if ( ! is_admin() ) {
//    wp_enqueue_script( 'wbvb-modernista-menu', WBVB_THEMEFOLDER . '/js/min/menu-min.js', '', '', true );
    wp_enqueue_script( 'wbvb-modernista-menu', WBVB_THEMEFOLDER . '/js/menu.js', '', '', true );
  }
}

//========================================================================================================

//add_filter( 'genesis_attr_site-header', 'add_class_to_header' );

function add_class_to_header( $attributes ) {
	$attributes['class'] .= ' js-header';
	return $attributes;
}

add_filter( 'genesis_attr_nav-primary', 'add_class_to_menu' );
add_filter( 'genesis_attr_nav-secondary', 'add_class_to_menu' );

function add_class_to_menu( $attributes ) {
	$attributes['class'] .= ' js-menu';
	return $attributes;
}

//========================================================================================================

add_filter( 'avatar_defaults', 'gc_wbvb_new_default_avatar' );

function gc_wbvb_new_default_avatar ( $avatar_defaults ) {

    $default_persoon_plaatje = 'voorbeeld-persoon-1.png';
  
		//Set the URL where the image file for your avatar is located
		$new_avatar_url = WBVB_THEMEFOLDER . '/images/' . $default_persoon_plaatje ;
		//Set the text that will appear to the right of your avatar in Settings>>Discussion
		$avatar_defaults[$new_avatar_url] = 'Your New Default Avatar';
		return $avatar_defaults;
}

//========================================================================================================

function gc_wbvb_modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['linkedin']     = 'LinkedIn profiel';
	$profile_fields['personalurl']  = 'Persoonlijke website';
//	$profile_fields['twitter']  = 'Twitter Username';
//	$profile_fields['facebook'] = 'Facebook URL';
//	$profile_fields['gplus']    = 'Google+ URL';

	// Remove old fields
	unset($profile_fields['user-url']);
	unset($profile_fields['aim']);

	return $profile_fields;
}
add_filter('user_contactmethods', 'gc_wbvb_modify_contact_methods');


//========================================================================================================

add_action( 'send_headers', 'wbvb_set_hsts_policy' );
/**
 * Enables the HTTP Strict Transport Security (HSTS) header.
 *
 * @since 1.0.0
 */
function wbvb_set_hsts_policy() {
 
  // 2 year expiration: 63072000
  header( 'Strict-Transport-Security: max-age=63072000; includeSubDomains; preload' );

 
}

//========================================================================================================

function gc_wbvb_get_human_filesize($bytes, $decimals = 2) {
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor] . 'B';
}

//========================================================================================================

add_filter( 'genesis_single_crumb',   'wbvb_modernista_breadcrumb_add_newspage', 10, 2 );
add_filter( 'genesis_page_crumb',     'wbvb_modernista_breadcrumb_add_newspage', 10, 2 );
add_filter( 'genesis_archive_crumb',  'wbvb_modernista_breadcrumb_add_newspage', 10, 2 );

function wbvb_modernista_breadcrumb_add_newspage( $crumb, $args ) {
	
	global $post;

  $span_before_start  = '<span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';  
  $span_between_start = '<span itemprop="name">';  
  $span_before_end    = '</span>';  
  
	if ( is_singular( GC_KLANTCONTACT_BEELDEN_CPT ) && ( get_field('beelden_page_overview', 'option') ) ) {

		$actueelpageid    = get_field('beelden_page_overview', 'option');
		$actueelpagetitle = get_the_title( $actueelpageid );
		
		if ( $actueelpageid ) {
      $crumb = gc_wbvb_breadcrumbstring( $actueelpageid, $args );
		}
	}

	if ( is_singular( GC_KLANTCONTACT_BRIEF_CPT ) && ( get_field('brief_page_overview', 'option') ) ) {

		$currentpageID  = get_field('brief_page_overview', 'option');

		if ( $currentpageID ) {
      $crumb = gc_wbvb_breadcrumbstring( $currentpageID, $args );
		}
	}

	return $crumb;

}

//========================================================================================================

function gc_wbvb_breadcrumbstring( $currentpageID, $args ) {
  global $post;
  $crumb = '';
  $countertje = 0;

	if ( $currentpageID ) {
		$crumb = '<a href="' . get_permalink( $currentpageID ) . '">' . get_the_title( $currentpageID ) .'</a>' . $args['sep'] . ' ' . get_the_title( $post->ID );
    $postparents = get_post_ancestors( $currentpageID );
    foreach( $postparents as $postparent ) {
  	  $countertje ++;	
			$crumb = '<a href="' . get_permalink( $postparent ) . '">' . get_the_title( $postparent ) .'</a>' . $args['sep'] . $crumb;
    }
	}

	return $crumb;
	
}

//========================================================================================================

remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

add_action( 'genesis_after_endwhile', 'wbvb_modernista_prev_next_post_nav' );

//========================================================================================================
 
function wbvb_modernista_prev_next_post_nav() {

	$label 			= get_post_type();
//	$labelprev	= __( 'Vorige', 'genesis' ) . ' ' . $label;
//	$labelnext	= __( 'Nieuwere', 'genesis' ) . ' ' . $label;
	$labelprev	= __( 'Vorige', 'genesis' );
	$labelnext	= __( 'Volgende', 'genesis' );

	$prev_link = get_previous_posts_link( apply_filters( 'genesis_prev_link_text', $labelprev ) );
	$next_link = get_next_posts_link( apply_filters( 'genesis_next_link_text', $labelnext ) );


	if ( get_previous_posts_link() || get_next_posts_link() ) {
		echo '<nav class="pagination">';
		if ( is_single() ) {
			previous_post_link( '<div class="pagination-previous alignleft">%link</div>', '%title' );
			next_post_link( '<div class="pagination-next alignright">%link</div>', '%title' );
		}
		else {

			$pagination = $prev_link ? sprintf( '<div class="pagination-previous alignleft">%s</div>', $prev_link ) : '';
			$pagination .= $next_link ? sprintf( '<div class="pagination-next alignright">%s</div>', $next_link ) : '';
	
			genesis_markup( array(
				'open'    => '<div %s>',
				'close'   => '</div>',
				'content' => $pagination,
				'context' => 'archive-pagination',
			) );

		}
		echo '</nav><!-- .prev-next-navigation -->';
  }
}

//========================================================================================================


add_action( 'genesis_before', 'gc_wbvb_check_page_style' );

add_action( 'wp_enqueue_scripts', 'gc_wbvb_add_beeldbank_foto_css' ); // sorry, overhead. maar het moet maar


function gc_wbvb_check_page_style() {

  if ( ! is_admin() ) {

    global $post;
    global $wp_query;
  
    $brief_page_overview          = get_field('brief_page_overview', 'option');
    $beelden_page_overview        = get_field('beelden_page_overview', 'option');

    if ( ( 'page'    == get_post_type() ) &&  ( $brief_page_overview == $post->ID ||  $beelden_page_overview == $post->ID ) ) {
      add_action( 'genesis_entry_content', 'gc_wbvb_page_add_archive_for_cpt', 12 );
    }
  }
}

//========================================================================================================

function gc_wbvb_page_add_archive_for_cpt() {
  
  global $post;
//  global $post;
  global $wp_query;

  $brief_page_overview          = get_field('brief_page_overview', 'option');
  $beelden_page_overview        = get_field('beelden_page_overview', 'option');

  if ( 'page'    == get_post_type() ) {


    if ( $brief_page_overview == $post->ID ||  $beelden_page_overview == $post->ID ) {

      $post_type = GC_KLANTCONTACT_BEELDEN_CPT;
      
      if ( $brief_page_overview == $post->ID ) {
        $post_type = GC_KLANTCONTACT_BRIEF_CPT;
      }

    	$paged  = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
      $args   = array(
              'post_type'       => $post_type,
              'post_status'     => 'publish',
              'paged'           => $paged
            );
      
      $wp_query = new WP_Query( $args );
      
      if ( $wp_query->have_posts() ) : 
      
        echo '<div class="beeldbank for-' . $post_type . '">';
        gc_wbvb_archive_loop();
        echo '</div>';

    	  do_action( 'genesis_after_endwhile' );    
        
      endif;
      wp_reset_query();

      remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
      remove_action( 'genesis_after_endwhile', 'wbvb_modernista_prev_next_post_nav' );
      
      
    }
    
  }
  else {
    return;
  }
}

//========================================================================================================

add_action( 'init', 'rhswp_dossiercontext_add_rewrite_rules');

//define( 'GC_KLANTCONTACT_BEELDEN_CPT', 'beeld' );
//define( 'GC_KLANTCONTACT_BRIEF_CPT', 'brief' );


function rhswp_dossiercontext_add_rewrite_rules() {

  add_rewrite_rule( '(.+?)(/' . GC_BEELDENCONTEXT . '/)(.+?)/?$', 'index.php?name=$matches[3]&post_type=' . GC_KLANTCONTACT_BEELDEN_CPT, 'top');

  add_rewrite_rule( '(.+?)(/' . GC_BRIEVENCONTEXT . '/)(.+?)/?$', 'index.php?name=$matches[3]&post_type=' . GC_KLANTCONTACT_BRIEF_CPT, 'top');

}

//========================================================================================================
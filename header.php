<?php

/**
 * Gebruiker Centraal - header.php
 * ----------------------------------------------------------------------------------
 * Overwrites voor header, zoals aparte IE-classes
 * ----------------------------------------------------------------------------------
 * @package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.4.11
 * @desc.   Tabs to spaces, tabs to spaces
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 */


do_action( 'genesis_doctype' );
do_action( 'genesis_title' );
do_action( 'genesis_meta' );

wp_head(); //* we need this for plugins

?>
</head>
<?php
genesis_markup( array(
  'html5'   => '<body %s>',
  'xhtml'   => sprintf( '<body class="%s">', implode( ' ', get_body_class() ) ),
  'context' => 'body',
) );
do_action( 'genesis_before' );

genesis_markup( array(
  'html5'   => '<div %s>',
  'xhtml'   => '<div id="wrap">',
  'context' => 'site-container',
) );

do_action( 'genesis_before_header' );
do_action( 'genesis_header' );
do_action( 'genesis_after_header' );

genesis_markup( array(
  'html5'   => '<div %s>',
  'xhtml'   => '<div id="inner">',
  'context' => 'site-inner',
) );
genesis_structural_wrap( 'site-inner' );
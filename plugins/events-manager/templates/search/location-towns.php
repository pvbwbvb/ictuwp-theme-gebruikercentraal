<?php 

/**
 * Gebruiker Centraal
 * ----------------------------------------------------------------------------------
 * Onderdeel van de vormgeving voor de events-manager
 * ----------------------------------------------------------------------------------
 * @package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.4.11
 * @desc.   Tabs to spaces, tabs to spaces
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 */

    
    showdebug(__FILE__, 'templates search'); 

    $args = !empty($args) ? $args:array(); /* @var $args array */ ?>
<!-- START City Search -->
<div class="em-search-town em-search-field">
  <label><?php echo esc_html($args['town_label']); ?></label>
  <select name="town" class="em-search-town em-events-search-town">
    <option value=''><?php echo esc_html(get_option('dbem_search_form_towns_label')); ?></option>
    <?php
    global $wpdb;
    $em_towns = $cond = array();
    if( !empty($args['country']) ) $cond[] = $wpdb->prepare("AND location_country=%s", $args['country']);
    if( !empty($args['region']) ) $cond[] =  $wpdb->prepare("AND location_region=%s", $args['region']);
    if( !empty($args['state']) ) $cond[] = $wpdb->prepare(" AND location_state=%s ", $args['state']);
    if( !empty($cond) || empty($args['search_countries']) ){ //get specific towns, whether restricted by country/region/state or all towns if no country field is displayed
      $em_towns = $wpdb->get_results("SELECT DISTINCT location_town FROM ".EM_LOCATIONS_TABLE." WHERE location_town IS NOT NULL AND location_town != '' AND location_status=1 ".implode(' ', $cond)." ORDER BY location_town", ARRAY_N);
    }
    foreach($em_towns as $town){
      ?>
       <option<?php echo (!empty($args['town']) && $args['town'] == $town[0]) ? ' selected="selected"':''; ?>><?php echo esc_html($town[0]); ?></option>
      <?php 
    }
    ?>
  </select>
</div>
<!-- END City Search -->
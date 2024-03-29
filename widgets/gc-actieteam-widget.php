<?php

// Gebruiker Centraal - gc-actieteam-widget.php
// ----------------------------------------------------------------------------------
// Toont de leden van het actieteam in een widget. Gebruik deze op de homepage
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 4.3.1
// @desc.   Fixes voor actieteamwidget bug (sanitize_title) en authorbox (get user ID from get_queried_object).
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme



//========================================================================================================
//* banner widget
class gc_actieteam_widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
	
		$widget_ops = array(
			'classname'   => 'gc-actieteam-widget',
			'description' => __( 'Widget voor het tonen van de actieteamleden', 'gebruikercentraal' ),
		);
		
		parent::__construct( 'gc_actieteam_widget', 'GC - Actieteam', $widget_ops );
	
	}
	
     
	function form($instance) {
		
		$instance = wp_parse_args( 
			(array) $instance, 
			array( 
		        'title'             	=> '', 
		        'gc_actieteam_array'	=> '', 
		      ) 
		    );
		$title              		= apply_filters( 'widget_title', $instance['title'] );
		$gc_actieteam_array 		= isset ( $instance['gc_actieteam_array'] ) ? $instance['gc_actieteam_array'] : array();
		$gc_actieteam_array_temp	= maybe_unserialize( $gc_actieteam_array );

		if ( function_exists( 'have_rows' ) ) {
			
			if( have_rows('actieteamleden', 'option') ):
			
				$arr_temp = array();

				echo '<p>' . __('Vink alleen de naam van actieleden aan die je wilt tonen in deze widget', 'gebruikercentraal' ) . ':</p>';
				
				// loop through the rows of data
				while ( have_rows('actieteamleden', 'option') ) : the_row();
				
					$comment    = '';
					$checked    = '';
					$userdata   = get_sub_field('actielid');
					$acf_userid = $userdata['ID'];   // grabs the user ID        
					$the_id     = 'cb_' . $acf_userid;
					
					$arr_temp[$acf_userid] = array( 
						'id'      => $acf_userid,
						'name'    => sanitize_title( $userdata['display_name'] ) // * @since	  4.3.1

					);

					if ( isset( $gc_actieteam_array_temp[$acf_userid]['checked'] ) ) {
						if ($gc_actieteam_array_temp[$acf_userid]['checked'] ) {
							$checked = ' checked="checked"';
						}
					}
					?>
					<p><label for="<?php echo $this->get_field_id( $the_id ); ?>"><input type="checkbox" id="<?php echo $this->get_field_id( $the_id ); ?>" name="<?php echo $this->get_field_name( $the_id ); ?>" value="<?php echo 'value_' . $the_id; ?>"<?php echo $checked ?> /><?php echo $comment ?><?php echo $userdata['display_name'] ?></label></p><?php
					
				endwhile;
			
			else :
			
				// no rows found
				echo 'Geen actieteam bekend';
			
			endif;
			
		}
		else {
			echo ACF_PLUGIN_NOT_ACTIVE_WARNING;
		}
	
	
		//dovardump( $arr_temp );
		
		$comma_separated = maybe_serialize( $arr_temp );    
		
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titel boven de widget', 'gebruikercentraal' ) ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /><input id="<?php echo $this->get_field_id( 'gc_actieteam_array' ); ?>" name="<?php echo $this->get_field_name( 'gc_actieteam_array' ); ?>" type="hidden" value='<?php echo $comma_separated; ?>' /></p>
		<?php
		
		
	}
		
	  
	function update($new_instance, $old_instance) {
		$instance			= $old_instance;
		$instance['title']	= strip_tags($new_instance['title']);
		$checkarray			= unserialize(strip_tags($new_instance['gc_actieteam_array']));
		
		$newarray = array();
		
		foreach ($checkarray as $key => $value) {
			
			$the_id = $key;
			
			$newarray[$key] = array(
					'key'     => $key,
					'checked' => $new_instance['cb_' . $key],
				);
		}
		
		$instance['gc_actieteam_array']   = serialize($newarray);
		
		return $instance;

	}
     
  function widget($args, $instance) {

    extract($args, EXTR_SKIP);
    
    $title                   = empty($instance['title']) ? '' : $instance['title'] ;
    $gc_actieteam_array      = empty($instance['gc_actieteam_array']) ? '' : $instance['gc_actieteam_array'] ;
    $linkafter               = '';
    $gc_actieteam_array_temp = maybe_unserialize( $gc_actieteam_array );
    
    echo $before_widget;
    
    if ( $title )
    echo $before_title . $title . $after_title;

  if ( function_exists( 'have_rows' ) ) {
    
    if( have_rows('actieteamleden', 'option') ):
      
      $actielid_counter = 0;
      
      echo '<div class="actieteam">';
      
      // loop through the rows of data
      while ( have_rows('actieteamleden', 'option') ) : the_row();

        $userdata   = get_sub_field('actielid');
        $acf_userid = ( isset( $userdata['ID'] ) ? $userdata['ID'] : 0 );   // grabs the user ID        

        if ( isset( $gc_actieteam_array_temp[$acf_userid]['checked'] ) ) {
          if ($gc_actieteam_array_temp[$acf_userid]['checked'] ) {
            echo  gc_wbvb_authorbox_actieteamlid( $acf_userid );
            $actielid_counter++;
          }
        }
        else {
        }

        
      
      endwhile;
      
      if ( $actielid_counter < 1 ) {
        echo __( 'Je hebt geen actieleden geselecteerd voor deze widget.', 'gebruikercentraal');
        echo '<br>';
        echo __( 'Dat kun je doen via de widget-instellingen:<br>&gt; admin &gt; weergave &gt; widgets ', 'gebruikercentraal');
      }
      
      echo '</div>';
      
    else :
      
      // no rows found
      echo __( 'Je hebt geen actieleden geselecteerd voor deze widget.', 'gebruikercentraal');
      echo '<br>';
      echo __( 'Actieleden kun je toevoegen via:<br>&gt; admin &gt; weergave &gt; Theme-instelling ', 'gebruikercentraal');
      
    endif;

    if( get_field('actieteampagina_link', 'option') ):
      $url = get_field('actieteampagina_link', 'option');
      echo '<a href="' . $url . '" class="actieteam-pagina widget-read-all">' . __( 'Alle actieteamleden', 'gebruikercentraal' ). '</a>';
    endif;

  }
  else {
    echo ACF_PLUGIN_NOT_ACTIVE_WARNING;
  }
    
    
    echo $after_widget;
  }
 
}

function gc_actieteam_widget_init() {
  return register_widget("gc_actieteam_widget");
}

add_action( 'widgets_init', 'gc_actieteam_widget_init' );

//========================================================================================================



<?php

// Gebruiker Centraal - gc-berichten-widget.php
// ----------------------------------------------------------------------------------
// Widget voor het tonen van berichten. Gebruik deze vooral op de homepage
// ----------------------------------------------------------------------------------
// @package gebruiker-centraal
// @author  Paul van Buuren
// @license GPL-2.0+
// @version 4.3.17
// @desc.   Mogelijkheid om uitgelichte afbeelding te verbergen toegevoegd aan GC_berichten_widget.
// @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme


//========================================================================================================
//* berichten widget
class GC_berichten_widget extends WP_Widget {


	public function __construct() {
		$widget_ops = array(
			'classname'   => 'gc-berichten-widget',
			'description' => 'Toont een aantal blogberichten in een widget'
		);
		parent::__construct( 'GC_berichten_widget', 'GC - Berichtenwidget', $widget_ops );
	}


	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance,
			array(
				'gc_berichtenwidget_titel'       => '',
				'verberg_uitgelichte_afbeelding' => 0,
				'gc_berichtenwidget_aantal'      => ''
			)
		);

		$gc_berichtenwidget_titel       = empty( $instance['gc_berichtenwidget_titel'] ) ? 'Blog' : $instance['gc_berichtenwidget_titel'];
		$gc_berichtenwidget_aantal      = $instance['gc_berichtenwidget_aantal'];
		$verberg_uitgelichte_afbeelding = $instance['verberg_uitgelichte_afbeelding'];

		?>
        <p><label
                    for="<?php echo $this->get_field_id( 'gc_berichtenwidget_titel' ) . '">' . __( "Titel:", 'gebruikercentraal' ) ?><br /><input id="<?php echo $this->get_field_id( 'gc_berichtenwidget_titel' ); ?>
            " name="<?php echo $this->get_field_name( 'gc_berichtenwidget_titel' ); ?>" type="text" style="width: 100%;"
            value="<?php echo esc_attr( $gc_berichtenwidget_titel ); ?>" /></label></p>
		<?php
		$checked = '';
		if ( ! empty( $instance['verberg_uitgelichte_afbeelding'] ) && $instance['verberg_uitgelichte_afbeelding'] ) {
			$checked = 'checked';
		}

		echo '<p><label for="' . $this->get_field_id( 'verberg_uitgelichte_afbeelding' ) . '">';
		echo '<input type="checkbox" id="' . $this->get_field_id( 'verberg_uitgelichte_afbeelding' ) . '" name="' . $this->get_field_name( 'verberg_uitgelichte_afbeelding' ) . '"' . $checked . '>';
		echo __( "Vink aan om de uitgelichte afbeelding te verbergen", 'gebruikercentraal' );
		echo '</label></p>';


		$counter = 0;
		$max     = 10;

		echo '<p><label for="' . $this->get_field_id( 'gc_berichtenwidget_aantal' ) . '">' . __( "Aantal:", 'gebruikercentraal' ) . '<br /><select name="' . $this->get_field_name( 'gc_berichtenwidget_aantal' ) . '" id="gc_berichtenwidget_aantal">';

		while ( $counter < $max ) {

			$counter ++;
			echo '<option value="' . $counter . '"';
			if ( $gc_berichtenwidget_aantal == $counter ) {
				echo ' selected>';
			} else {
				echo '>';
			}
			echo $counter . '</option>';
		}

		echo "</select></label></p>";

	}

	function update( $new_instance, $old_instance ) {
		$instance                                   = $old_instance;
		$instance['verberg_uitgelichte_afbeelding'] = empty( $new_instance['verberg_uitgelichte_afbeelding'] ) ? '' : $new_instance['verberg_uitgelichte_afbeelding'];
		$instance['gc_berichtenwidget_titel']       = empty( $new_instance['gc_berichtenwidget_titel'] ) ? '' : $new_instance['gc_berichtenwidget_titel'];
		$instance['gc_berichtenwidget_aantal']      = empty( $new_instance['gc_berichtenwidget_aantal'] ) ? '' : $new_instance['gc_berichtenwidget_aantal'];

		return $instance;
	}

	function widget( $args, $instance ) {
		global $query;
		global $post;
		global $wp_query;

		extract( $args, EXTR_SKIP );

		$gc_berichtenwidget_titel       = empty( $instance['gc_berichtenwidget_titel'] ) ? 'Blog' : $instance['gc_berichtenwidget_titel'];
		$aantalberichten                = empty( $instance['gc_berichtenwidget_aantal'] ) ? '5' : $instance['gc_berichtenwidget_aantal'];
		$verberg_uitgelichte_afbeelding = empty( $instance['verberg_uitgelichte_afbeelding'] ) ? 'toon_afbeelding' : $instance['verberg_uitgelichte_afbeelding'];

		$args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $aantalberichten,
			'ignore_sticky_posts' => 1,
			'order'               => 'DESC',
			'orderby'             => 'date'
		);

		$sidebarposts = new WP_query( $args );
		$custom_css   = '';
		$countertje   = 0; // Run your normal loop

		if ( $sidebarposts->have_posts() ) {

			echo $before_widget;
			echo '<h2 class="widget-title">' . $gc_berichtenwidget_titel . '</h2>';
			echo '<div class="entry-list entry-list--blogs">';

			while ( $sidebarposts->have_posts() ) : $sidebarposts->the_post();

				// do loop stuff
				$countertje ++;
				$getid       = get_the_ID();
				$permalink   = get_permalink( $getid );
				$publishdate = get_the_date();
				$theID       = 'featured_image_post_' . $getid;
				$has_image   = '';

				if ( 'toon_afbeelding' === $verberg_uitgelichte_afbeelding ) {


					if ( has_post_thumbnail( $sidebarposts->ID ) ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $sidebarposts->ID ), 'medium' );

						if ( $image[0] ) {
							$has_image = true;
						}
					}
				}

				if ( date( "Y" ) == get_the_date( 'Y' ) ) {
					$jaar = '';
				} else {
					$jaar = '<span class="jaar">' . get_the_date( 'Y' ) . '</span>';
				}

				echo '<section class="entry entry--blog ' . ( $has_image ? 'entry--with-image' : 'entry--no-image' ) . '" itemid="' . $permalink . '" itemscope itemtype="http://schema.org/SocialMediaPosting">';
				echo '<a class="entry__link" href="' . $permalink . '" itemprop="url">';
				// Only primt image if it's there

				echo( $has_image ? '<div id="' . $theID . '" class="entry__featured-image">&nbsp;</div>' : '' );
				echo '<div class="bloginfo">';
				echo '<header><span class="date-badge" itemprop="datePublished" content="' . $publishdate . '"><span class="dag">' . get_the_date( 'd' ) . '</span> <span class="maand">' . get_the_date( 'M' ) . '</span>' . $jaar . '</span>';
				echo '<h3 class="entry-title" itemprop="headline"><span class="arrow-link"><span class="arrow-link__text">';
				the_title();
				echo '</span><span class="arrow-link__icon"></span></span></h3></header>';
				echo '<div class="excerpt">';
				echo the_excerpt();
				echo '</div>';
				echo '</div>';

				echo '</a>';

				echo '</section>';

			endwhile;

			echo '</div>';

			$idObj       = get_category_by_slug( 'blog' );
			$category_id = $idObj->term_id;

			// Get the URL of this category
			$category_link = get_category_link( $category_id );

			if ( $category_link ) {
				echo '<a href="' . esc_url( $category_link ) . '" class="blog widget-read-all">' . $idObj->name . '</a>';
			}


			wp_reset_postdata();

		}

		echo $after_widget;


		// RESET THE QUERY
		wp_reset_query();

	}

}

function GC_berichten_widget_init() {
	return register_widget( "GC_berichten_widget" );
}

add_action( 'widgets_init', 'GC_berichten_widget_init' );


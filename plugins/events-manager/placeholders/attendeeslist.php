<?php

/**
 * Gebruiker Centraal
 * ----------------------------------------------------------------------------------
 * Onderdeel van de vormgeving voor de events-manager
 * ----------------------------------------------------------------------------------
 * @@package gebruiker-centraal
 * @author  Paul van Buuren
 * @license GPL-2.0+
 * @version 3.16.1
 * @desc.   CTA-kleuren, a11y groen, sharing buttons optional, beeldbank CPT code separation.
 * @link    https://github.com/ICTU/gebruiker-centraal-wordpress-theme
 * */


showdebug( __FILE__, 'placeholders' );
/* @var $EM_Event EM_Event */
$people      = array();
$EM_Bookings = $EM_Event->get_bookings();

if ( count( $EM_Bookings->bookings ) > 0 ) {

	$guest_bookings       = get_option( 'dbem_bookings_registration_disable' );
	$guest_booking_user   = get_option( 'dbem_bookings_registration_user' );
	$bookings_total       = count( $EM_Bookings->bookings );
	$nr_anon_bookings     = 0;
	$usercounter          = 0;
	$confirmedusercounter = 0;
	$nonanon_userlist     = [];
	$people               = [];


	// Check of bij de laatste reservering het veld 'show_name_attendeelist' aanwezig is.
	// Dit gaat expliciet om de laatste aanmelding, want als we deze check zouden uitvoeren op de eerste
	// aanmelding dan komen wijzigingen achteraf niet door. Als bij het laatste record dit veld WEL aanwezig is,
	// dan is het blijkbaar WEL de bedoeling om de deelnemerlijst te tonen.
	// Als dat veld NIET aanwezig is, concluderen we dus maar voor het gemak dat de aanwezigenlijst NIET getoond hoeft te worden
	$lastbooking = $EM_Bookings->bookings[ ( $bookings_total - 1 ) ];

	if ( ! isset( $lastbooking->booking_meta['booking']['show_name_attendeelist'] ) ) {
		// blijkbaar zit het veld show_name_attendeelist niet in de form fields,
		// dus we hoeven de hele aanwezigenlijst sowieso niet te tonen
		// verder doen we niks
	} else {
		// het veld zit wel in de formfields, dus we gaan door alle inschrijvingen heen om de namenlijst te construeren

		foreach ( $EM_Bookings as $EM_Booking ) {

			$boookinginfo = [];
			if ( isset( $EM_Booking->meta['booking'] ) ) {
				$boookinginfo = $EM_Booking->meta['booking'];
			}
			$name = '';
			$usercounter ++;

			if ( $EM_Booking->booking_status == 1 ) {

				$confirmedusercounter ++;

				if ( $guest_bookings && $EM_Booking->get_person()->ID == $guest_booking_user ) {

					$thename = attendeelist_get_the_bookingpersonname( $EM_Booking );

					if ( $thename ) {
						$nonanon_userlist[] = $thename;
					} else {
						$nr_anon_bookings ++;
					}
				} else {
					if ( ! in_array( $EM_Booking->get_person()->ID, $people ) ) {

						$thename = attendeelist_get_the_bookingpersonname( $EM_Booking );

						$people[ $EM_Booking->get_person()->ID ] = $EM_Booking->get_person()->ID;

						if ( $thename ) {
							$nonanon_userlist[] = $thename;
						} else {
							$nr_anon_bookings ++;
						}
					}
				}
			}
		}

		$attendeecounter = sprintf( _n( '%s attendee', '%s attendees', $confirmedusercounter, 'gebruikercentraal' ), $confirmedusercounter );

		if ( $nr_anon_bookings > 0 ) {
			// some users prefer not to be listed on the attendeeslist
			$attendeecounter .= ' (' . sprintf( _n( '%s attendee not shown', '%s attendees not shown', $nr_anon_bookings, 'gebruikercentraal' ), $nr_anon_bookings ) . ')';
		}

		if ( $nonanon_userlist ) {
			// er zijn items toegevoegd aan de lijst $nonanon_userlist, i.e. er zijn deelnemers die het goed vinden dat hun naam getoond wordt

			echo '<div class="attendees-list" id="attendeeslist">';
			echo '<h2>' . __( 'Other attendees', 'gebruikercentraal' ) . '<span class="event-aanmeldingen">' . $attendeecounter . '</span></h2>';
			echo '<ul class="event-attendees">';
			foreach ( $nonanon_userlist as $name ) {
				if ( $name ) {
					echo '<li class="person"><span itemprop="attendee" itemscope itemtype="http://schema.org/Person">' . $name . '</span></li>';
				}
			}
			echo '</ul>';
			echo '</div>';

		}
	}


} else {
	// no bookings
}


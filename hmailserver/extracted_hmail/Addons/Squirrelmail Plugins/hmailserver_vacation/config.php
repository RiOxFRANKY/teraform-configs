<?php
// If you have some problems with a plank page or something like that,
// pleasy temporary uncamment the following line:
//ini_set('error_reporting', E_ALL);

/**
 * This configuration variable is used in hMailServer 4.3 authentication
 * If you are using 4.3 or later, you should set it to your main hMailServer
 * administrator password.
 */
$admin_password = ""; 

/**
 * If you are using a default domain, you need to specify this domain here.
 * Otherwise the script won't work since it does not know what domain the
 * user is on.
 */
$default_domain = "";

/**
 * Settings for the calendar-popup:
 */
$countdown_length = 20;					// Time until the calendar-popup-window closes automatically in seconds
$calendar_width 	= 180;				// Width of the calendar-popup-window
$calendar_height 	= 200;				// Height of the calendar-popup-window
$font_size = 'auto';						// Fontsize for the calendar-popup-window; possible values: 'auto', any integer

$type_of_datefield = 'auto';		// The type of the datefield; possible values: 'auto' or '', 'text', 'selectbox'
?>
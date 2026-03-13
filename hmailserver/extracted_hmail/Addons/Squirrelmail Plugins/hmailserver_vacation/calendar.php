<?php
/* 
 ============================================================== 
 =   Calendar-Popup-Window  -  calendar.php                   =
 ==============================================================
*/
// $Id: calendar.php,v 1.2 2007/03/11 09:41:37 hmailserver Exp $
/******************************************************************************************************************
 * based on MRXS content management system -  created by  Dr. Mario Roediger                                      *
 * ============================================================================================================== *
 *                                                                                                                *
 * Copyright (C) [2007] Author: Dr. Mario Roediger ( MRXS Infotainment GmbH (MRXS) )                              *
 *                                                                                                                *
 ******************************************************************************************************************
 * Modified version of: MRXS_CMS\calendar.php			                                                                *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General     *
 * Public License as published by the Free Software Foundation; either version 2 of the License, or (at your      *
 * option) any later version.                                                                                     *
 *                                                                                                                *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the     *
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License    *
 * for more details.                                                                                              *
 *                                                                                                                *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to    *
 * the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110, USA                         *
 *                                                                                                                *
 *****************************************************************************************************************/

define('_NL',"\r\n");
define('_TAB',"\t");
define('_BR',"<br />");

/**
 * Path for SquirrelMail required files.
 * @ignore
 */
if (!defined('SM_PATH')) define('SM_PATH','../../');

include_once (SM_PATH . 'include/validate.php');

/* SquirrelMail required files. */
require_once('config.php');
require_once(SM_PATH . 'functions/global.php');
require_once(SM_PATH . 'functions/i18n.php');

// Load default theme if possible
if (@file_exists($theme[$theme_default]['PATH']))
   @include ($theme[$theme_default]['PATH']);
 
	if ( !isset($color[0]) ) $color[0] = "#808080";
	if ( !isset($color[2]) ) $color[2] = "#808080";
	if ( !isset($color[4]) ) $color[4] = "#808080";
	if ( !isset($color[8]) ) $color[8] = "#808080";
	if ( !isset($color[9]) ) $color[9] = "#808080";
	if ( !isset($color[16]) ) $color[16] = "#808080";
	
	$calendar_width 	= ( !isset($calendar_width) || empty($calendar_width) )? 180 : $calendar_width;
	$calendar_height 	= ( !isset($calendar_height) || empty($calendar_height) )? 200 : $calendar_height;
	$font_size 				= ( !isset($font_size) || empty($font_size) || $font_size == 'auto' )? ($calendar_height/20): $font_size;
	$font_family = 'Verdana';
	
	$table_headline = 'background-color:'.$color[0].';';  // {background-color: #808080;} =>
	$table_normalborder = 'border: 2px inset; font-family:'.$font_family.';';
	$table_normalbgcol = 'background-color:'.$color[4].';'; //{background-color: #BEBEBE;}
	$table_lightbgcol = 'background-color:'.$color[9].';'; //{background-color: #999999;}
	$style_text = 'color:'.$color[8].'; font-size:'.$font_size.';'; //{color: #000000;}{font-family: Tahoma; font-size: 11px; font-weight: normal;}
	$style_alerttext = 'color:'.$color[2].'; font-size:'.$font_size.';font-weight: bold;'; // {color: #FF0000;}{font-family: Tahoma; font-size: 11px; font-weight: bold;}
	$style_infotext = 'color:'.$color[16].'; font-size:'.$font_size.';font-weight: bold;'; // {color: #006600;}{font-family: Tahoma; font-size: 11px; font-weight: bold;}
	$style_lightmiditext = 'color:'.$color[4].'; font-size:'.(1.1*$font_size).';font-weight: bold;'; //{color: #BEBEBE;}{font-family: Tahoma; font-size: 11px; font-weight: bold;}
	
	$style_mouseover = $color[9];
	$style_mouseout = $color[4];
					
	$style_current_date = 'border: 1px solid Red;';
	$style_letter_today = $style_infotext;
		
	$args = extract($_GET);
		
	$width = ( isset($_GET['width']) )? $_GET['width'] : '180';
	$height = ( isset($_GET['height']) )? $_GET['height'] : '200';
	$td_width = 'width="'.(($width-10)/7).'"';
	$tr_height = 'height="'.(($height-50)/8).'"';

	// Name of month:
	$months = array (0=>_("December"), 1=>_("January"), 2=>_("February"), 3=>_("March"), 4=>_("April"), 5=>_("May"), 6=>_("June"),
									 7=>_("July"), 8=>_("August"), 9=>_("September"), 10=>_("October"), 11=>_("November"), 12=>_("December") );
	// Name of days(short)
	$days = array (0=>_("Sun"), 1=>_("Mon"), 2=>_("Tue"), 3=>_("Wed"), 4=>_("Thu"), 5=>_("Fri"), 6=>_("Sat"), 7=>_("Sun") );
	
	$now = time();
	$set_day = ( !empty($_GET['set_day']) )? $_GET['set_day'] : date("d", $now);
	$month = ( isset($_POST['month']) )? $_POST['month'] : ( ( !empty($_GET['set_month']) )? $_GET['set_month'] : date("m", $now) );
	$month = preg_replace('!^0!', '', $month);
	$year = ( isset($_POST['year']) )? $_POST['year'] : ( ( !empty($_GET['set_year']) )? $_GET['set_year'] : date("Y", $now) );	
	
	// Unix-timestamp only is available between 01.01.1970 and 31.12.2038;
 	$set_day = ( !empty($set_day) && $year >=1970 && $year <=2038 )? $set_day : date("d", $now);
 	$month = ( !empty($month) && $year >=1970 && $year <=2038 )? $month : date("m", $now);
 	$year = ( !empty($set_year) && $year >=1970 && $year <=2038 )? $year : date("Y", $now);
 	
 	$data['day'] = $set_day;
	$data['month'] = $month;
	$data['year'] = $year;

	$output  = '<html>'._NL;	
	$output .= '<head>'._NL;
	$output .= '<title>'._("Calendar").'</title>'._NL;	  

  $output .= '<script type="text/javascript">'._NL;
 	
  	$output .= 'function send_date(day, month, year)'._NL;
		$output .= '{'._NL;
			$output .= 'var dateset = new Date(year, month-1, day);'._NL; // javascript: january=0!
			$output .= 'var timestamp = dateset.getTime()/1000;'._NL;
				
			global $squirrelmail_language; 
			$locale = ( !empty($squirrelmail_language) )? $squirrelmail_language : 'en_GB';

			bindtextdomain('squirrelmail', SM_PATH . 'locale');
			textdomain('squirrelmail');
			
			$date_shown = (strpos($locale,"de")===false)? 'year+"-"+month+"-"+day' : 'day+"."+month+"."+year'; 			
	  	if ( $day_target ) $output .= 'window.opener.document.getElementsByName("'.$day_target.'")[0].value= day;'._NL;
	  	if ( $month_target ) $output .= 'window.opener.document.getElementsByName("'.$month_target.'")[0].value= month;'._NL;
	  	if ( $year_target ) $output .= 'window.opener.document.getElementsByName("'.$year_target.'")[0].value= year;'._NL;
	  	if ( $date_target ) $output .= 'window.opener.document.getElementsByName("'.$date_target.'")[0].value= '.$date_shown.';'._NL;
	  	if ( $unixtimestamp_target ) $output .= 'window.opener.document.getElementsByName("'.$unixtimestamp_target.'")[0].value= timestamp;'._NL;
	  	$output .= 'window.close()'._NL;
	  $output .= '}'._NL;
	  
	  $output .= 'function countdown(time,anchorname)'._NL;
		$output .= '{'._NL;
		$output .= 'obj = document.getElementById(anchorname);';
		$output .= 'output = (obj.innerText)? obj.innerText : obj.textContent;';
			$output .= 'new_anchorname = anchorname;';
			$output .= 'showtime = time-1;';
			$output .= 'showtime = (showtime<10)? "0"+showtime : showtime;';
			//$output .= 'document.getElementsByName(anchorname)[0].innerText = showtime;'._NL;
			//$output .= 'new_time = document.getElementsByName(anchorname)[0].innerText;'._NL;
			$output .= 'if(obj.innerText) {obj.innerText = showtime; } else { obj.textContent = showtime; }'._NL;
			$output .= 'new_time = showtime;'._NL;
			$output .= 'setTimeout("countdown(new_time, new_anchorname)", 1000);'._NL;
	  $output .= '}'._NL;
	  
  $output .= 'setTimeout("window.close()", '.($countdown_length*1000).')'._NL;
  
  $output .= '</script>'._NL;
  
  $output .= '</head>'._NL;
	$output .= '<body style="'.$table_normalbgcol.'" topmargin="2px" bottommargin="2px" leftmargin="2px" rightmargin="2px">'._NL;
	
	$output .= '<form name="calendarpopup"  action="'.$_SERVER['REQUEST_URI'].'" method="post" >'._NL;
	$output .= '<table align="center" cellspacing="0" style="'.$table_normalborder.';">'._NL;

	$output .= '<tr style="'.$table_headline.';">'._NL;
	//$output .= '<th colspan="7" align="center" '.$style_lightmiditext.'>'._NL;	
	//$output .= $months[$month].' '.$year ._NL;	
	
	$output .= '<td colspan="7"><table align="center" ><tr>'._NL;		
	$output .= '<td><select name="month" style="'.$style_lightmiditext.'; width:'.(0.5*$width).'px; '.$table_headline.'" onChange="submit();">'._NL;
	foreach ( $months as $key => $monthname )
		{
			if ( $key == 0 ) continue;
			$month_selected = ( isset($month) && $month == $key )? 'selected="selected"' : '';
			$output .= '<option value="'.$key.'" '.$month_selected.' style="'.$style_lightmiditext.'">'.$monthname.'</option>'._NL;
		}	
	$output .= '</select><td>'._NL;
	$output .= '<td><select name="year" style="'.$style_lightmiditext.'; width:'.(0.32*$width).'px; '.$table_headline.'" onChange="submit();">'._NL;
		for ($yr = 1970; $yr <= 2037; $yr++)
		{
			$year_selected = ( isset($year) && $yr == $year )? 'selected="selected"' : '';
			$output .= '<option value="'.$yr.'" '.$year_selected.' style="'.$style_lightmiditext.'" >'.$yr.'</option>'._NL;
		}	
	$output .= '</select><td>'._NL;
	$output .= '</tr>'._NL;
	$output .= '</table></td></tr>'._NL;

	$output .= '<tr style="'.$table_headline.';">'._NL;
		for ($i = 1; $i <= 7; $i ++)
		{
			$output .= '<th '.$tr_height.' '.$td_width.' style="'.$style_lightmiditext.'">'.$days[$i].'</th>'._NL;
		}
	$output .= '</tr>'._NL;
		$first = mktime (12, 0, 0, $month, 1, $year);
		$date = getdate ($first);
		if ($date['wday'] == 0) { $date['wday'] = 7; }
		$offset = $date['wday'] - 1;
		
	$output .= '<tr '.$tr_height.'>'._NL;
		for ($i = 1; $i <= 7; $i ++)
		{
			if ($i > $offset)
			{
				$day = $i - $offset;				
				//$style_days = ( $i>=6 )? $style_alerttext : $style_text;
				$style_days = ($day==date("d", $now) && $month==date("m", $now) && $year==date("Y", $now))? $style_letter_today : ( ( $i>=6 )? $style_alerttext : $style_text );				
				$style_day_shown = ( $day == $set_day )? $style_current_date : '';
			  
				$output .= '<td align="right" style="cursor: pointer; '.$style_day_shown.' '.$style_days.'" onClick="send_date(\''.$day.'\', \''.$month.'\', \''.$year.'\');" onMouseOver="this.style.backgroundColor=\''.$style_mouseover.'\'" onMouseOut="this.style.backgroundColor=\''.$style_mouseout.'\'">'.$day.'</td>'._NL;
			} else {
				# Don't show last month
				$output .= '<td>&nbsp;</td>'._NL;
			}
		}
		$output .= '</tr>'._NL;

		for ($i = 8; $i <= 42; $i++)
		{
			$output .= '<tr '.$tr_height.'>'._NL;
			$n = $i + 7;
			for ($i; $i < $n; $i++)
			{
				$day = $i - $offset;
				//$style_days = ( (($i+1)%7)==0 || ($i%7)==0 )? $style_alerttext : $style_text;
				$style_days = ($day==date("d", $now) && $month==date("m", $now) && $year==date("Y", $now))? $style_letter_today : ( ( (($i+1)%7)==0 || ($i%7)==0 )? $style_alerttext : $style_text);
				$style_day_shown = ( $day == $set_day )? $style_current_date : '';

				if ($day < 29)
				{ 
					$output .= '<td align="right" style="cursor: pointer; '.$style_day_shown.' '.$style_days.'" onClick="send_date(\''.$day.'\', \''.$month.'\', \''.$year.'\');" onMouseOver="this.style.backgroundColor=\''.$style_mouseover.'\'" onMouseOut="this.style.backgroundColor=\''.$style_mouseout.'\'">'.$day.'</td>'._NL;
				} else {
					$current = mktime (12, 0, 0, $month, $day, $year);
					$date = getdate ($current);
					if ($date['mon'] == $month)
					{
						$date_shown = $date['mday'];
						$output .= '<td align="right" style="cursor: pointer; '.$style_day_shown.' '.$style_days.'" onClick="send_date(\''.$day.'\', \''.$month.'\', \''.$year.'\');" onMouseOver="this.style.backgroundColor=\''.$style_mouseover.'\'" onMouseOut="this.style.backgroundColor=\''.$style_mouseout.'\'">'.$day.'</td>'._NL;
					} else {
						$output .= '<td>&nbsp;</td>'._NL;
					}
				}
			}
			$i --;
			$output .= '</tr>'._NL;
		}

		$output .= '</table>'._NL;
		$output .= '</form>'._NL;
 	$data['month'] = $month;
	$data['year'] = $year;
	
	
	$output .= '<div style="float: left"><a ID="countdown_close" name="countdown_close" style="font-family:'.$font_family.'; font-size:'.(0.9*$font_size).';">#</a></div>'._NL;  
	$output .= '<div style="text-align:right;padding-right:2px"><a href="#" onclick="window.close()" style="font-family:'.$font_family.'; font-size:'.(0.9*$font_size).';">'._("Close Window").'</a></div>'._NL;

	
	$output .= '<script type="text/javascript">'._NL;
	$output .= 'setTimeout("countdown(\''.$countdown_length.'\', \'countdown_close\')", 1000);'._NL;
	$output .= '</script>'._NL;
	
	
	$output .= '</body>'._NL;
	$output .= '</html>'._NL;
	
	echo $output;


?>
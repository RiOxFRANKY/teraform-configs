<?php
   /*
    *  Change hMailServer Vacation message plugin 1.1
    *
    */

/******************************************************************************************************************
 *                                                                                                                *
 * Copyright (C) [2007] Author: Martin Knafve                                                                     *
 * modified for using with calendar.php by: Dr. Mario Roediger ( MRXS Infotainment GmbH (MRXS) )                  *
 *                                                                                                                *
 ******************************************************************************************************************
 *                                             		                                                                *
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

function hmailserver_vacation_opt_do() {

    global $optpage_blocks;    
    bindtextdomain('hmailserver_vacation', SM_PATH . 'plugins/hmailserver_vacation/locale');
   	textdomain('hmailserver_vacation'); 
        
    $optpage_blocks[] = array(
        'name' => _("Vacation / Autoresponder"),
        'url' => '../plugins/hmailserver_vacation/options.php',
        'desc' => _("Set up an auto-reply message for your incoming email.  This can be useful when you are away on vacation."),
        'js' => FALSE
    );          
}       

function hmailserver_vacation_optpage_loadinfo_do() {
	
	global $optpage, $optpage_name;   
 	if (sqgetGlobalVar('optpage',$optpage,SQ_FORM) && $optpage == 'hmailserver_vacation') 
  {
  	bindtextdomain('hmailserver_vacation',SM_PATH . 'plugins/hmailserver_vacation/locale');
    textdomain('hmailserver_vacation');

    if ($optpage=='hmailserver_vacation') {
    	// is displayed after "Successfully Saved Options:"
      $optpage_name=_("User's vacation / autoresponder");
   	}
  	bindtextdomain('squirrelmail',SM_PATH . 'locale');
    textdomain('squirrelmail');
  }   
}       

 /* ================================================================================
  * Function 	show_CalendarPopup(...)
  * Desc:			Shows an popup with a calendar and sends the selected value to a field
  * based on;	MRXS_CMS\include\classes\class.ConfigOut.php
  * Author:	 	Dr. Mario Roediger <info_hmailserver@mrxs.de> || MRXS Infotainment GmbH
  * @access pupblic
  * ================================================================================
  */ 
  function show_CalendarPopup($instance='', $width='180', $height='200', $day_target='', $month_target='', $year_target='', $date_target='', $timestamp_target='', $create_selectset=false, $create_datefield=false, $create_timestampfield=false, $size_factor=1, $set_day='', $set_month='', $set_year='' )
  { 
  	bindtextdomain('hmailserver_vacation', SM_PATH . 'plugins/hmailserver_vacation/locale');
   	textdomain('hmailserver_vacation');

  	if ( (empty($day_target) || empty($month_target) || empty($year_target)) && $create_selectset != false )
  	{
  		echo '<span style="color:#FF0000;">'._("Error: Some fieldnames for the selectbox-set not specified!").'</span><br />';
  		$create_selectset = false;
  	}
  	if ( empty($date_target) && $create_datefield != false )
  	{
  		echo '<span style="color:#FF0000;">'._("Error: Fieldname of the date-field not specified!").'</span><br />';
  		$create_datefield = false;
  	}
  	if ( empty($timestamp_target) && $create_timestampfield != false )
  	{
  		echo '<span style="color:#FF0000;">'._("Error: Fieldname of the timestamp-field not specified!").'</span><br />';
  		$create_timestampfield = false;
  	}
  	// We only allow a selctfield-set OR an inputfield for dates not both!
  	if ( !empty($day_target) && !empty($month_target) && !empty($year_target) && !empty($date_target) )
  	{
  		echo '<span style="color:#FF0000;">'._("Error: Cannot create both selectset and datefield!").'</span><br />';
  		$date_target = '';
  		$create_datefield = false;
  	}
  	  	
   	$size_factor = ( !isset($size_factor) || empty($size_factor) )? 1 : $size_factor;
  	
  	// Unix-timestamp only is available between 01.01.1970 and 31.12.2038;
  	$now = time();
  	$set_day = ( !empty($set_day) && $set_year >=1970 && $set_year <=2038 )? $set_day : date("d", $now);
  	$set_month = ( !empty($set_month) && $set_year >=1970 && $set_year <=2038 )? $set_month : date("m", $now);
  	$set_year = ( !empty($set_year) && $set_year >=1970 && $set_year <=2038 )? $set_year : date("Y", $now);  	
  	  	
  	echo '<script type="text/javascript">'._NL;
			echo 'function calendarPopup'.$instance.'(coordX,coordY)'._NL;
			echo '{'._NL;
				echo 'coordX -= 200;'._NL;
	  		echo 'coordY -= 150;'._NL;
	  		echo 'var width = \''.$width.'\';'._NL;
	  		echo 'var height = \''.$height.'\';'._NL;
	  		echo 'var dayfield = \''.$day_target.'\';'._NL;
	  		echo 'var monthfield = \''.$month_target.'\';'._NL;
	  		echo 'var yearfield = \''.$year_target.'\';'._NL;
	  		echo 'var datefield = \''.$date_target.'\';'._NL;
	  		echo 'var timestampfield = \''.$timestamp_target.'\';'._NL;
	  		echo 'var set_day = \''.$set_day.'\';'._NL;
	  		echo 'var set_month = \''.$set_month.'\';'._NL;
	  		echo 'var set_year = \''.$set_year.'\';'._NL;
	  		echo 'var day, month, year;'._NL;
	  		echo 'var query_string;'._NL;
	  		
	  		echo 'if(timestampfield!="")'._NL;
	  		echo '{'._NL;
	  			echo 'var unixtimestamp = document.getElementsByName(timestampfield)[0].value;'._NL;
	  			echo 'var timestamp = new Date(unixtimestamp*1000);';
					echo 'year = timestamp.getFullYear();'._NL;
					echo 'month = timestamp.getMonth()+1;'._NL;
					echo 'day = timestamp.getDate();'._NL;
				echo '} else {'._NL;
					echo 'if(datefield!="")'._NL;				
					echo '{'._NL;		
						echo 'var date = document.getElementsByName(datefield)[0].value;'._NL;			
						echo 'if(date.match(/-/))'._NL;
						echo '{'._NL;
							echo 'parts = date.split("-");'._NL;
							echo 'year = parts[0];'._NL;
							echo 'month = parts[1];'._NL;
							echo 'day = parts[2];'._NL;
						echo '}'._NL;
						echo 'if(date.match(/./))'._NL;
						echo '{'._NL;
							echo 'parts = date.split(".");'._NL;
							echo 'year = parts[2];'._NL;
							echo 'month = parts[1];'._NL;
							echo 'day = parts[0];'._NL;
						echo '}'._NL;
					echo '} else {'._NL;
						echo 'year = document.getElementsByName(yearfield)[0].value;'._NL;
						echo 'month = document.getElementsByName(monthfield)[0].value;'._NL;
						echo 'day = document.getElementsByName(dayfield)[0].value;'._NL;
					echo '}'._NL;
				echo '}'._NL;				
	  		
	  		echo 'query_string = "width="+width+"&height="+height+
	  												 "&day_target="+dayfield+"&month_target="+monthfield+"&year_target="+yearfield+
	  												 "&date_target="+datefield+
	  												 "&unixtimestamp_target="+timestampfield+
	  												 "&set_day="+day+"&set_month="+month+"&set_year="+year;'._NL;
	  		//echo 'calPopup = window.open("calendar.php?'.$query_string.'","calPopup","width='.$width.',height='.$height.',screenX="+coordX+",screenY="+coordY+",top="+coordY+",left="+coordX+",dependent=yes,scrollbars=no");'._NL;
	  		echo 'calPopup = window.open("calendar.php?"+query_string,"calPopup","width='.$width.',height='.$height.',screenX="+coordX+",screenY="+coordY+",top="+coordY+",left="+coordX+",dependent=yes,scrollbars=no");'._NL;
	  		echo 'calPopup.focus();'._NL;
			echo '}'._NL;
			
			echo 'function changeTimestamp'.$instance.'(dayfield,monthfield,yearfield,datefield,timestampfield)'._NL;
		  echo '{'._NL;
		  	echo 'if(dayfield!=""&&monthfield!=""&&yearfield!=""&&timestampfield!="")'._NL;
				echo '{'._NL;	
					echo 'var day=document.getElementsByName(dayfield)[0].value;'._NL;
					echo 'var month=document.getElementsByName(monthfield)[0].value;'._NL;
					echo 'var year=document.getElementsByName(yearfield)[0].value;'._NL;
				echo '}'._NL;		
				echo 'if(datefield!="" && timestampfield!="")'._NL;				
				echo '{'._NL;		
					echo 'var date=document.getElementsByName(datefield)[0].value;'._NL;			
					echo 'if(date.match(/-/))'._NL;
					echo '{'._NL;
						echo 'parts=date.split("-");'._NL;
						echo 'year=parts[0];'._NL;
						echo 'month=parts[1];'._NL;
						echo 'day=parts[2];'._NL;
					echo '}'._NL;
					echo 'if(date.match(/./))'._NL;
					echo '{'._NL;
						echo 'parts=date.split(".");'._NL;
						echo 'year=parts[2];'._NL;
						echo 'month=parts[1];'._NL;
						echo 'day=parts[0];'._NL;
					echo '}'._NL;
				echo '}'._NL;
				echo 'var dateset = new Date(year, month-1, day);'._NL;
				echo 'var timestamp = dateset.getTime()/1000;'._NL;		
				echo 'document.getElementsByName(timestampfield)[0].value= timestamp;'._NL;						
			echo '}'._NL;
	  echo '</script>'._NL;
	  	
	  	$onchange = 'onChange="changeTimestamp'.$instance.'(\''.$day_target.'\', \''.$month_target.'\', \''.$year_target.'\', \''.$date_target.'\', \''.$timestamp_target.'\');"';
	  	$now = time();
	  	
	  	global $squirrelmail_language; 
			$locale = ( !empty($squirrelmail_language) )? $squirrelmail_language : 'en_GB';
	  	$style_input = '';
	  	$output = '';
	  if ( isset($create_selectset) && !empty($create_selectset) )
	  {	
	 		$day = '<select '.$style_input.' name="'.$day_target.'" style="width:'.($size_factor*40).'px;" '.$onchange.'>'._NL;
				for ( $i=1; $i<=31; $i++ )
				{
				 	$default_day = ( isset($_POST[$day_target]) && !empty($day_target) )? $_POST[$day_target] : $set_day;
				 	$day_selected = ( $default_day == $i )? 'selected="selected"' : '';
					$day .= '<option value="'.$i.'" '.$day_selected.'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>'._NL;
				}
			$day .= '</select>'._NL;
			$month = '<select '.$style_input.' name="'.$month_target.'" style="width:'.($size_factor*40).'px;"  '.$onchange.'>'._NL;
				for ( $i=1; $i<=12; $i++ )
				{
					$default_month = ( isset($_POST[$month_target]) && !empty($month_target) )? $_POST[$month_target] : $set_month;
				 	$month_selected = ( $default_month == $i )? 'selected="selected"' : '';
					$month .= '<option value="'.$i.'" '.$month_selected.'>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>'._NL;
				}
			$month .= '</select>'._NL;
			$year = '<select '.$style_input.' name="'.$year_target.'" style="width:'.($size_factor*55).'px;"  '.$onchange.'>'._NL;
				for ( $i=1930; $i<2038; $i++ )
				{
					$default_year = ( isset($_POST[$year_target]) && !empty($year_target) )? $_POST[$year_target] : $set_year;
				 	$year_selected = ( $default_year == $i )? 'selected="selected"' : '';
					$year .= '<option value="'.$i.'" '.$year_selected.'>'.$i.'</option>'._NL;
				}
			$year .= '</select>'._NL;
		
			$output .= (strpos($locale,"en")!==false)?  $year . $month . $day : $day	. $month . $year;
			$format_string = (strpos($locale,"en")!==false)? _("YYYY").' '._("MM").' '._("DD") : _("DD").' '._("MM").' '._("YYYY");	
	  }
	  
	  if ( isset($create_datefield) && !empty($create_datefield) )
	  {	
			//$time_format = ( $user_lang == 'en' )? "Y-m-d" : "d.m.Y";
			$set_time = (strpos($locale,"en")!==false)? "$set_year-$set_month-$set_day" : "$set_day.$set_month.$set_year";
			$format_string = (strpos($locale,"en")!==false)? _("YYYY").'-'._("MM").'-'._("DD") : _("DD").'.'._("MM").'.'._("YYYY");
			
	  	$default_date = ( isset($_POST[$date_target]) && !empty($date_target) )? $_POST[$date_target] : $set_time;
	  	$type = ( $create_datefield === 'text' || $create_datefield === 'hidden' )? $create_datefield : 'text';
	  	$output .= '<input '.$style_input.' type="'.$type.'" name="'.$date_target.'" value="'.$default_date.'" style="width:'.($size_factor*70).'px;"  '.$onchange.'/>'._NL;
	  }
	  
	  if ( isset($create_timestampfield) && !empty($create_timestampfield) )
	  {	
			//$default_timestamp = ( isset($_POST[$timestamp_target]) && !empty($timestamp_target) )? $_POST[$timestamp_target] : $now;
			$default_timestamp = ( isset($_POST[$timestamp_target]) && !empty($timestamp_target) )? $_POST[$timestamp_target] : mktime(0,0,0,$set_month,$set_day,$set_year);
	  	$type = ( $create_timestampfield === 'text' || $create_timestampfield === 'hidden' )? $create_timestampfield : 'text';
	  	$output .= '<input readonly '.$style_input.' type="'.$type.'" name="'.$timestamp_target.'" value="'.$default_timestamp.'" style="width:'.($size_factor*70).'px;" />'._NL;
	  }	
 		
	  bindtextdomain('hmailserver_vacation', SM_PATH . 'plugins/hmailserver_vacation/locale');
   	textdomain('hmailserver_vacation');
    
   	$output .= '<span style="vertical-align: text-bottom;"><img src="images/calico.png"';
  	$output .= ' title="'._("Click here to show calendar").'" onClick="calendarPopup'.$instance.'(event.screenX,event.screenY);"></span>'._NL;
  	$output .= '<br />['.$format_string.']';
    
    return $output;
  }        
?>
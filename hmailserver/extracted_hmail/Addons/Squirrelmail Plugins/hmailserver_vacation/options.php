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

   if (!defined('SM_PATH')) define('SM_PATH','../../');
   
   include_once (SM_PATH . 'include/validate.php');
   include_once (SM_PATH . 'functions/display_messages.php');
   
   global $color;
      
   include('./config.php');
   
   sqgetGlobalVar('username',$username,SQ_SESSION); 
   
   if (strpos($username, '@') == FALSE)
   {
      // The user name is not a full email address.
      // Append default domain to it.
      global $default_domain;
      $username .= "@" . $default_domain;
   }  

   // if a message and other info was submitted, process it here
   //
   sqgetGlobalVar('vacationMessageSubmit', $vacationMessageSubmit, SQ_POST);
      
   if (isset($vacationMessageSubmit) && $vacationMessageSubmit == 1)
   {
   		// Save the changes...      
      sqgetGlobalVar('messageText', $messageText, SQ_POST);
      sqgetGlobalVar('messageSubject', $messageSubject, SQ_POST);
      sqgetGlobalVar('vacationStatus', $vacationStatus, SQ_POST);
      sqgetGlobalVar('messageExpires', $messageExpires, SQ_POST);
      sqgetGlobalVar('messageExpiresDate_timestamp', $messageExpiresDate, SQ_POST);

      if ($vacationStatus == "") $vacationStatus = "0";      
      if ($messageExpires == "") $messageExpires = "0";
      
      $obAccount = GetAccountObject($username);
      
      $obAccount->VacationMessage = $messageText;
      $obAccount->VacationSubject = $messageSubject;
      $obAccount->VacationMessageIsOn = (isset($vacationStatus) && $vacationStatus == "1");
      
      $obAccount->VacationMessageExpires      = $messageExpires;
      $obAccount->VacationMessageExpiresDate  = date("Y-m-d", $messageExpiresDate);

      $obAccount->Save();         		   

      $location = '../../src/options.php?optmode=submit&optpage=hmailserver_vacation';
      
      header('Location: ' . $location);
      exit(0);
   }

   // pull previous settings from the account object
   //
   $obAccount = GetAccountObject($username);
   $messageText = $obAccount->VacationMessage();
   $messageSubject = $obAccount->VacationSubject();
   $vacationStatus = $obAccount->VacationMessageIsOn();
   
   $messageExpires = $obAccount->VacationMessageExpires;
   $messageExpiresDate = $obAccount->VacationMessageExpiresDate;

   bindtextdomain('squirrelmail', SM_PATH . 'locale');
	 textdomain('squirrelmail');

   displayPageHeader($color, 'None', 'document.forms[0].elements["messageText"].focus();');
  
   bindtextdomain('hmailserver_vacation', SM_PATH . 'plugins/hmailserver_vacation/locale');
   textdomain('hmailserver_vacation');
 
   echo '<br>';
   echo '<form method="POST"><input type="hidden" name="vacationMessageSubmit" value="1">'
      . '<table width=95% align=center cellpadding=2 cellspacing=2 border=0>'
      . '<tr><td bgcolor="' . $color[0] . '">'
      . '<center><b>'
      . _("Vacation / Autoresponder");
   ?>   
   		</b></center>
     </td>
   </tr>
   <tr> 
     <td align="center">
       <table width="70%" cellspacing="2" cellpadding="0" border="0">
         <tr>
           <td valign="top" width="20%">
             <br>
             <input type="checkbox" name="vacationStatus" value="1" <?php if ($vacationStatus == 'on') echo ' CHECKED' ?>>
           </td>
           <td>
             <br>
             <b><?php echo _("Activate vacation autoresponder") ?></b>
           </td>
         </tr>
         <tr>
           <td colspan="2">
             <br>
             <b><?php echo _("Message subject") . '</b> ' . _("(leave blank to use standard \"RE:\" syntax)"); ?>:
             <br>
             <input type="text" name="messageSubject" size="87" value="<?php echo $messageSubject; ?>">
           </td>
         </tr>
         <tr>
           <td colspan="2"> 
             <br>
             <b><?php echo _("Message text"); ?></b>:
             <br>
             <textarea name="messageText" rows="5" cols="75" wrap="off"><?php echo eregi_replace('<br[[:space:]]*/?[[:space:]]*>', "\n", $messageText); ?></textarea>
           </td>
         </tr>         
         <tr>
           <td valign="top">
             <br>
             <input type="checkbox" name="messageExpires" value="1" <?php if ($messageExpires == '1') echo ' CHECKED' ?>>
           </td>
           <td>
             <br>
             <b><?php echo _("vacation autoresponder expires") ?></b>
           </td>
         </tr>         
         <tr>
           <td valign="top" nowrap>
             <br>    
             <?php
             $type_of_datefield = ( !isset($type_of_datefield) || empty($type_of_datefield) || $type_of_datefield=='auto' )? 'selectbox' : $type_of_datefield;
             $type_of_datefield = ( $type_of_datefield != 'selectbox' && $type_of_datefield != 'text' )? 'selectbox' : $type_of_datefield;
             if ( $type_of_datefield == 'selectbox' )
             {
             	 $day_target='messageExpiresDate_day';
             	 $month_target='messageExpiresDate_month';
             	 $year_target='messageExpiresDate_year';
             	 $date_target='';
             	 $create_selectset = true;
             	 $create_datefield = false;
             } else {
             	 $date_target='messageExpiresDate_date'; 
             	 $day_target = $month_target = $year_target = '';
             	 $create_selectset = false;
             	 $create_datefield = true;
             }
               $timestamp_target = 'messageExpiresDate_timestamp';
               $create_timestampfield = 'hidden';
             $time_db = ( strpos($messageExpiresDate, '0000') === false && strpos($messageExpiresDate, '-00') === false )? strtotime($messageExpiresDate) : time();
             $set_day 	= date("d", $time_db);
             $set_month = date("m", $time_db);
             $set_year 	= date("Y", $time_db); 
             require_once('functions.php');
             echo show_CalendarPopup($instance='1', $calendar_width, $calendar_height, $day_target, $month_target, $year_target, $date_target, $timestamp_target, $create_selectset, $create_datefield, $create_timestampfield, $size_factor=1, $set_day, $set_month, $set_year );             
             ?>             
           </td>
           <td>
             <br>
             <b><?php echo _("vacation autoresponder expiresdate") ?></b>
           </td> 
         </tr>		
         <tr>
           <td align="center" colspan="2">
             <br>
             <input type="submit" value="<?php echo _("Submit"); ?>" style="width:99%">
           </td>
         </tr>
       </table>
     </td>
   </tr>
 </table>
</form>
</body>
</html>

<?php

exit(0);



// displays simple error output page
//
function showError($message)
{

   global $color;
   displayPageHeader($color, 'None');
   echo '<br><br><center><font color="' . $color[2] . '"><b>'
      . $message
      . '</b></font></center></body></html>';

}

function GetAccountObject($username)
{
  global $imapServerAddress;  
  
   bindtextdomain('hmailserver_vacation', SM_PATH . 'plugins/hmailserver_vacation/locale');
   textdomain('hmailserver_vacation');
   
	 $hmailserver_addr = (!empty($imapServerAddress))? $imapServerAddress : 'localhost';

		// Extract domain part from email address
    $iAtPos = strpos($username, '@');
    
    $DomainName = substr($username, $iAtPos + 1);

   /**
    * FIXME: handle COM permission issues.
    * Fatal error: Uncaught exception 'com_exception' with message 'Failed 
    * to create COM object `hMailServer.Application': Access is denied. '
    */    
    $hCOMApp = new COM("hMailServer.Application", $hmailserver_addr);

    global $admin_password;
    if (strlen($admin_password) > 0)
      $hCOMApp->Authenticate("Administrator", $admin_password);    
  
    $obDomain = $hCOMApp->Domains->ItemByName($DomainName);
    
    if (!isset($obDomain))
    {
        echo _("Operation failed - Can not access the domain object.");
        die;
    }
    
    $obAccount = $obDomain->Accounts->ItemByAddress($username);
    
    if (!isset($obAccount))
    {
        echo _("Operation failed - Can not access the account object.");
        die;
    }
    
    return $obAccount;

}
?>
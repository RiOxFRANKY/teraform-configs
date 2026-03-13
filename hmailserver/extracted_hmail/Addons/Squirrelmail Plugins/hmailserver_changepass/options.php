<?php

   /*
    *  Change hMailServer Password plugin 1.1
    *
    */

   if (!defined('SM_PATH')) define('SM_PATH','../../');
   
   include_once (SM_PATH . 'include/validate.php');
   /* sqm_baseuri() function is not loaded in older sm versions with db setup */
   include_once (SM_PATH . 'functions/display_messages.php');

   global $color;
   
   include('./config.php');

   // get flag that tells us if this is a password submission attempt...
   //
   sqgetGlobalVar('plugin_hmailserver_changepass',$plugin_hmailserver_changepass,SQ_FORM);

   // hack depends on sq_base_url variable which is stored by get_location() in session	 
   $location = get_location();
   if (! sqgetGlobalVar('sq_base_url',$sq_base_url,SQ_SESSION)) {
       $sq_base_url = '';
   }
   
   $cancelLocation = $sq_base_url . sqm_baseuri() . 'src/options.php';


   // if a password change is given, check its validity
   //
   if (isset($plugin_hmailserver_changepass))
   {
       $Messages = hmailserver_changepass_check();

       // the above only returns if password wasn't changed
       // so if we came from webmail.php, must redirect to
       // right_main.php (need to pass messages along...)
       //
       sqgetGlobalVar('PHP_SELF',$PHP_SELF, SQ_SERVER);       
   }

        
   // don't display page header if we got a successful
   // password change (No error messages exist and a 
   // password was submitted.  Cannot send output before 
   // header() call)
   //
   if (!isset($Messages) && isset($cp_oldpass) && $cp_oldpass)
   {
      // do nothing
   }
   else
   {
      displayPageHeader($color, '', 'document.forms[0].elements["cp_oldpass"].focus();');
               
  		bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
  	  textdomain('hmailserver_changepass'); 
  	  
      echo '<br>';

      echo '<table width=95% align=center cellpadding=2 cellspacing=2 border=0>';
      echo '<tr><td bgcolor="';
 
      echo $color[0] . '">';   
   }   

   echo '<center><b>';
   echo _("Change Password"); 
   echo '</b></center></td>';

if (isset($Messages) && count($Messages)) {
    	echo "<tr><td>\n";
    	foreach ($Messages as $line) {
        echo htmlspecialchars($line) . "<br>\n";
    }
    echo "</td></tr>\n";
}

?><tr><td>
<?php 
   sqgetGlobalVar('PHP_SELF',$SPHP_SELF, SQ_SERVER);       

	if ($SPHP_SELF) {
		$location=$SPHP_SELF;
	} else {
		$location="../plugins/hmailserver_changepass/options.php";
	}

  $location = str_replace('right_main.php', 'webmail.php', $location);
?>
    <form method=post action="<?php echo $location; ?>">
    <table align="center" cellpadding="2" cellspacing="2">
      <tr>
        <br />
        <th align=right><?php echo _("Old Password"); ?>:</th>
        <td><input type=password name=cp_oldpass value=""  size=20></td>
      </tr>
      <tr>
        <th align=right><?php echo _("New Password"); ?>:</th>
        <td><input type=password name=cp_newpass value="" size=20></td>
      </tr>
      <tr>
        <th align=right><?php echo _("Verify New Password"); ?>:</th>
        <td><input type=password name=cp_verify value="" size=20></td>
      </tr>
      <tr>
        <td align=center colspan=2>
          <input type="hidden" name="plugin_hmailserver_changepass" value="1">
          <input type=submit value="<?php echo _("Submit"); ?>" style="width:49%">
<?php 

     echo '<input type=button value="' . _("Cancel") . '" onClick="document.location=\'' . $cancelLocation . '\'"'
        		. ' name="plugin_hmailserver_changepass_cancel" style="width:49%">';
?>
        </td>
      </tr>
    </table>
</td></tr>
</tr></table>
</body></html>
<?php

exit(0);


function hmailserver_changepass_check() {
   sqgetGlobalVar('key',$key, SQ_COOKIE);
   sqgetGlobalVar('onetimepad',$onetimepad, SQ_SESSION);
   
   bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
   textdomain('hmailserver_changepass');

   $Messages = array();
   $password = OneTimePadDecrypt($key, $onetimepad);

    // Set variables to empty values
    $cp_oldpass = '';
    $cp_newpass = '';
    $cp_verify = '';
    
    // Get password data from POST
   sqgetGlobalVar('cp_oldpass',$cp_oldpass,SQ_POST);
   sqgetGlobalVar('cp_newpass',$cp_newpass,SQ_POST);
   sqgetGlobalVar('cp_verify',$cp_verify,SQ_POST);
   
   if ($cp_oldpass == '')
       array_push($Messages, _("You must type in your old password."));
   if ($cp_newpass == '')
       array_push($Messages, _("You must type in a new password."));
   if ($cp_verify == '')
       array_push($Messages, _("You must also type in your new password in the verify box."));
   if ($cp_newpass != '' && $cp_verify != $cp_newpass)
       array_push($Messages, _("Your new password does not match the verify password."));
   if ($cp_oldpass != '' && $cp_oldpass != $password)
       array_push($Messages, _("Your old password is not correct."));
   if ($cp_oldpass == $cp_newpass)
			 array_push($Messages, _("Your new password must be different than your old password."));

   if (count($Messages))
       return $Messages;

   return hmailserver_changepass_go($password);
}


function hmailserver_changepass_go($password) 
{
  bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
  textdomain('hmailserver_changepass');  
	
	$Messages = array();

    sqgetGlobalVar('cp_newpass',$cp_newpass,SQ_FORM);
    sqgetGlobalVar('username',$username,SQ_SESSION); 
    sqgetGlobalVar('base_uri',$base_uri,SQ_SESSION); 
    sqgetGlobalVar('onetimepad',$onetimepad,SQ_SESSION); 
    sqgetGlobalVar('key',$key,SQ_COOKIE); 
    
    if (strpos($username, '@') == FALSE)
    {
       // The user name is not a full email address.
       // Append default domain to it.
       global $default_domain;
       $username .= "@" . $default_domain;
    }

    // Extract domain part from email address
    $iAtPos = strpos($username, '@');
    
    $DomainName = substr($username, $iAtPos + 1);   

    if(!class_exists('COM')) {
        array_push($Messages, _("COM class is not available. Password can be changed only on Windows servers."));
        return $Messages;
    }

    if (check_php_version(5)) {
        set_exception_handler('hmailserver_exception_handler');
    } else {
        // turn on error reporting. Users will get PHP error message instead of white page on PHP4.
        error_reporting(E_ALL);
        ini_set('display_errors',1);
    }

    $hCOMApp = new COM("hMailServer.Application");
    
    global $admin_password;
    
    if (strlen($admin_password) > 0)
      $hCOMApp->Authenticate("Administrator", $admin_password);    
    
    $obDomain = $hCOMApp->Domains->ItemByName($DomainName);

    if (!isset($obDomain))
    {
        array_push($Messages, _("Operation failed - Can not access the domain object."));
        return $Messages;    	
    }
    
    $obAccount = $obDomain->Accounts->ItemByAddress($username);
    
    if (!isset($obAccount))
    {
        array_push($Messages, _("Operation failed - Can not access the account object."));
        return $Messages;    	
    }
    
    $sOldPassword = $obAccount->Password();
    
    // Check that it matches ...
    sqgetGlobalVar('cp_oldpass',$sOldPasswordEntry,SQ_FORM);
    
    $hCOMUtilities = new COM("hMailServer.Utilities");

	 // MD5 the entered password.
	 $sOldPasswordEntry = $hCOMUtilities->MD5($sOldPasswordEntry);
    
    if ($sOldPassword != $sOldPasswordEntry)
    {
        array_push($Messages, _("Strange, your old password does not match the database... rejecting."));
        return $Messages;    	
    }
    
    // OK, we should change it.
    
    $obAccount->Password = $cp_newpass;
    
    // Save the change.
    $obAccount->Save();

 
	// Write new cookies for the password
	$onetimepad = OneTimePadCreate(strlen($cp_newpass));
	
	sqgetGlobalVar('onetimepad',$onetimepad,SQ_SESSION); 

	$key = OneTimePadEncrypt($cp_newpass, $onetimepad);
	setcookie('key', $key, 0, $base_uri);

    // hack depends on sq_base_url variable which is stored by get_location() in session	 
    $location = get_location();
    if (! sqgetGlobalVar('sq_base_url',$sq_base_url,SQ_SESSION)) {
        $sq_base_url = '';
    }
   
    $location = $sq_base_url . sqm_baseuri() . 'src/options.php?optmode=submit&optpage=hmailserver_changepass';
    
	header("Location: $location");
	exit(0);

}

/**
 * PHP5 exception handler
 * @exception object PHP5 exception object
 * @return void
 */
function hmailserver_exception_handler($exception) {
    global $color, $pageheader_sent, $org_title;

    bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
    textdomain('hmailserver_changepass');

    if ( !isset( $color ) ) {
        $color = array();
        $color[0]  = '#dcdcdc';  /* light gray    TitleBar               */
        $color[1]  = '#800000';  /* red                                  */
        $color[2]  = '#cc0000';  /* light red     Warning/Error Messages */
        $color[4]  = '#ffffff';  /* white         Normal Background      */
        $color[7]  = '#0000cc';  /* blue          Links                  */
        $color[8]  = '#000000';  /* black         Normal text            */
        $color[9]  = '#ababab';  /* mid-gray      Darker version of #0   */
    }
    if ( !isset( $org_title ) ) {
        $org_title = "SquirrelMail";
    }

    $err = _("DCOM error");

    /* check if the page header has been sent; if not, send it! */
    if(!isset($pageheader_sent) && !$pageheader_sent) {
        /* include this just to be sure */
        include_once( SM_PATH . 'functions/page_header.php' );
        displayHtmlHeader($org_title.': '.$err);
        $pageheader_sent = TRUE;
        echo "<body text=\"$color[8]\" bgcolor=\"$color[4]\" link=\"$color[7]\" vlink=\"$color[7]\" alink=\"$color[7]\">\n\n";
    }

    echo '<table width="100%" cellpadding="1" cellspacing="0" align="center" border="0" bgcolor="'.$color[9].'">'.
         '<tr><td>'.
         '<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="'.$color[4].'">'.
         '<tr><td align="center" bgcolor="'.$color[0].'">'.
         '<font color="'.$color[2].'"><b>' . $err . '</b></font>'.
         '</td></tr><tr><td>'.
         '<table cellpadding="1" cellspacing="5" align="center" border="0">'.
         '<tr>' . html_tag( 'td', $exception->getMessage() ."\n", 'left') . '</tr></table>'.
         '</td></tr></table></td></tr></table>';

    die('</body></html>');
}
?>
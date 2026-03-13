<?php

$domainid	= hmailGetVar("domainid",0);
$accountid	= hmailGetVar("accountid",0);
$action	   = hmailGetVar("action","");

$error_message	   = hmailGetVar("error_message","");

if (hmailGetAdminLevel() == 0 && ($accountid != hmailGetAccountID() || $action != "edit" || $domainid != hmailGetDomainID()))
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);

$admin_rights = (hmailGetAdminLevel()  === ADMIN_SERVER || 
				     hmailGetAdminLevel()  === ADMIN_DOMAIN);
				
$accountactive = 1;
$accountmaxsize = 0;
$accountsize = 0;				
$accountaddress = "";
$accountlastlogontime = "";
$accountadminlevel = 0;
				     
if ($action == "edit")
{
   $obAccount = $obDomain->Accounts->ItemByDBID($accountid);  

   $accountmaxsize = $obAccount->MaxSize;
   $accountaddress = $obAccount->Address;
   $accountactive  = $obAccount->Active;
   $accountsize    = $obAccount->Size();
   $accountlastlogontime = $obAccount->LastLogonTime();
   $accountadminlevel = $obAccount->AdminLevel();
   
   $accountaddress = substr($accountaddress, 0, strpos($accountaddress, "@"));
}
   
$accountactivechecked = hmailCheckedIf1($accountactive);

$domainname = $obDomain->Name;

$str_user   = $obLanguage->String(STR_USER);
$str_domain = $obLanguage->String(STR_DOMAIN);
$str_server = $obLanguage->String(STR_SERVER);

?>

<h1><?php echo $obLanguage->String(STR_ACCOUNT)?></h1>

<?php
   if (strlen($error_message) > 0)
   {
      $error_message = $obLanguage->String($error_message);
      echo "<font color=\"red\"><b>$error_message</b></font><br><br>";
   }
?>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_account_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	<input type="hidden" name="accountid" value="<?php echo $accountid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td width="70%">
   			<?php
   			$str_address = $obLanguage->String(STR_ADDRESS);
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"accountaddress\" value=\"$accountaddress\" checkallownull=\"false\" checkmessage=\"$str_address\">";
   			else
   				echo $accountaddress;
   			?>
   			
   			@<?php echo $domainname?>
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_PASSWORD)?></td>
			<td><input type="password" name="accountpassword" value=""></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_MAXSIZEMB)?></td>
			<td>
   			<?php
   			$str_mailboxsize = $obLanguage->String(STR_MAXSIZEMB);
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"accountmaxsize\" value=\"$accountmaxsize\" size=\"5\"checkallownull=\"false\" checkmessage=\"$str_mailboxsize\">";
   			else
   				echo $accountmaxsize;
   			?>
   	   </td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_SIZEMB)?></td>
			<td>
   			<?php
   			echo Round($accountsize,3);
   			?>
   	   </td>
		</tr>		
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td>
			<?php
			if ($admin_rights)
			   echo "<input type=\"checkbox\" name=\"accountactive\" value=\"1\" $accountactivechecked>";
			else
			{
				if ($accountactive == 1)
				   echo $obLanguage->String(STR_YES);
				else
				   echo $obLanguage->String(STR_NO);
		   }
			?>			
			</td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_LAST_LOGON_TIME)?></td>
			<td>
   			<?php
   			if (is_php5())
   			{
   			   echo $accountlastlogontime;
   			}
   			else
   			{
   			   echo date("Y-m-d G:i:s", $accountlastlogontime);
   			}
   			?>
   	   </td>
		</tr>		
		<tr>
			<td><?php echo $obLanguage->String(STR_ADMINISTRATION_LEVEL)?></td>
			<td>
		      <select name="accountadminlevel" 
		         <?php if ($admin_rights == 0) echo " disabled ";?>
		         
		         style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; font-size:10 px;">
		         <option value="0" <?php if ($accountadminlevel == 0) echo " selected "; ?>><?php echo $str_user; ?></option>
		         <option value="1" <?php if ($accountadminlevel == 1) echo " selected "; ?>><?php echo $str_domain; ?></option>
		         <option value="2" <?php if ($accountadminlevel == 2) echo " selected "; ?>><?php echo $str_server; ?></option>
		      </select>

   	   </td>
		</tr>					
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

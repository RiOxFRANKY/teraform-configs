<?php

$domainid	= hmailGetVar("domainid",0);
$accountid	= hmailGetVar("accountid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 0 && ($accountid != hmailGetAccountID() || $domainid != hmailGetDomainID()))
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);

$obAccount = $obDomain->Accounts->ItemByDBID($accountid);  

if ($action == "save")
{
   // Fetch settings from form
   $vacationmessageon  = hmailGetVar("vacationmessageon","");
   $vacationsubject   = hmailGetVar("vacationsubject","0");
   $vacationmessage   =   hmailGetVar("vacationmessage","");
   $vacationmessageexpires   =   hmailGetVar("vacationmessageexpires","0");
   $vacationmessageexpiresdate   =   hmailGetVar("vacationmessageexpiresdate","2001-01-01");
   
   // Save the settings
   $obAccount->VacationMessageIsOn = $vacationmessageon == "1";
   $obAccount->VacationSubject     = $vacationsubject;
   $obAccount->VacationMessage     = $vacationmessage;
   
   $obAccount->VacationMessageExpires      = $vacationmessageexpires;
   $obAccount->VacationMessageExpiresDate  = $vacationmessageexpiresdate;
     
   $obAccount->Save();   
}

$vacationmessageon = $obAccount->VacationMessageIsOn;
$vacationsubject = $obAccount->VacationSubject;
$vacationmessage = $obAccount->VacationMessage;

$vacationmessageexpires     = $obAccount->VacationMessageExpires;
$vacationmessageexpiresdate = $obAccount->VacationMessageExpiresDate;
  
$vacationmessageonchecked = hmailCheckedIf1($vacationmessageon);
$vacationmessageexpireschecked = hmailCheckedIf1($vacationmessageexpires);

   
?>

<h1><?php echo $obLanguage->String(STR_AUTOREPLY)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="account_autoreply">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	<input type="hidden" name="accountid" value="<?php echo $obAccount->ID?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td width="70%">
   			<?php
   			echo "<input type=\"checkbox\" name=\"vacationmessageon\" value=\"1\" $vacationmessageonchecked>";
   			?>
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_SUBJECT)?></td>
			<td><input type="text" name="vacationsubject" value="<?php echo $vacationsubject?>"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_TEXT)?></td>
			<td><textarea name="vacationmessage" rows="6" cols="55"><?php echo $vacationmessage?></textarea></td>
		</tr>
		<tr>
			<td valign="top"><?php echo $obLanguage->String(STR_AUTOMATICALLY_EXPIRE)?></td>
			<td valign="top">
   			<?php
   			echo "<input type=\"checkbox\" name=\"vacationmessageexpires\" value=\"1\" $vacationmessageexpireschecked>";
   			?>
   		
   			<input type="text" name="vacationmessageexpiresdate" value="<?php echo $vacationmessageexpiresdate?>"> (YYYY-MM-DD)
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

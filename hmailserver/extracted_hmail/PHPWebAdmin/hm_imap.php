<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obSettings->WelcomeIMAP= hmailGetVar("welcomeimap",0);
	$obSettings->MaxIMAPConnections = hmailGetVar("MaxIMAPConnections",0);
	
	$obSettings->IMAPSortEnabled  = hmailGetVar("IMAPSortEnabled",0);
	$obSettings->IMAPQuotaEnabled = hmailGetVar("IMAPQuotaEnabled",0);
	$obSettings->IMAPIdleEnabled  = hmailGetVar("IMAPIdleEnabled",0);
}

$welcomeimap = $obSettings->WelcomeIMAP;     
$MaxIMAPConnections = $obSettings->MaxIMAPConnections;

$IMAPSortEnabled  = $obSettings->IMAPSortEnabled;
$IMAPQuotaEnabled = $obSettings->IMAPQuotaEnabled;
$IMAPIdleEnabled  = $obSettings->IMAPIdleEnabled;

$IMAPSortEnabledChecked = hmailCheckedIf1($IMAPSortEnabled);
$IMAPQuotaEnabledChecked = hmailCheckedIf1($IMAPQuotaEnabled);
$IMAPIdleEnabledChecked = hmailCheckedIf1($IMAPIdleEnabled);

?>

<h1><?php echo $obLanguage->String(STR_IMAP)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="imap">
   <input type="hidden" name="action" value="save">
   
   <h2><?php echo $obLanguage->String(STR_GENERAL)?></h2>
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td><?php echo $obLanguage->String(STR_WELCOMEMESSAGE)?></td>
   		<td><input type="textbox" name="welcomeimap" value="<?php echo $welcomeimap?>" size="50"  checkallownull="true" checkmessage="<?php echo $obLanguage->String(STR_WELCOMEMESSAGE)?>"></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?></td>
   		<td><input type="textbox" name="MaxIMAPConnections" value="<?php echo $MaxIMAPConnections?>" size="10"  checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?>"></td>
   	</tr> 	
 	</table>
 	
 	<h2><?php echo $obLanguage->String(STR_ADVANCED)?></h2>
 	
 	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="30%">IMAP Sort</td>
   		<td width="70%" width="70%"><input type="checkbox" name="IMAPSortEnabled" value="1" <?php echo $IMAPSortEnabledChecked?>></td>
   	</tr>   	
   	<tr>
   		<td>IMAP Quota</td>
   		<td><input type="checkbox" name="IMAPQuotaEnabled" value="1" <?php echo $IMAPQuotaEnabledChecked?>></td>
   	</tr>    	
   	<tr>
   		<td>IMAP Idle</td>
   		<td><input type="checkbox" name="IMAPIdleEnabled" value="1" <?php echo $IMAPIdleEnabledChecked?>></td>
   	</tr>  	
   	<tr>
   		<td colspan="2">  
   		   <br/>
   		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
   		</td>
   	</tr>		
	</table>
</form>
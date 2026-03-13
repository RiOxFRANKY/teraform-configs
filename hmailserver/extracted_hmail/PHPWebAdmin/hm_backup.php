<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obBackup    = $obSettings->Backup();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obBackup->Destination = hmailGetVar("backupdestination",0);
	$obBackup->BackupSettings = hmailGetVar("backupsettings",0);
	$obBackup->BackupDomains = hmailGetVar("backupdomains",0);
	$obBackup->BackupMessages = hmailGetVar("backupmessages",0);
	$obBackup->CompressDestinationFiles = hmailGetVar("backupcompress",0);
}
elseif ($action == "startbackup")
{
   $obBaseApp->BackupManager->StartBackup();  
}

$backupdestination = $obBackup->Destination;
$backupsettings = $obBackup->BackupSettings;
$backupdomains = $obBackup->BackupDomains;
$backupmessages = $obBackup->BackupMessages;
$backupcompress = $obBackup->CompressDestinationFiles;

$backupsettingschecked = hmailCheckedIf1($backupsettings);
$backupdomainschecked = hmailCheckedIf1($backupdomains);
$backupmessageschecked = hmailCheckedIf1($backupmessages);
$backupcompresschecked = hmailCheckedIf1($backupcompress);

?>

<h1><?php echo $obLanguage->String(STR_BACKUP)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="backup">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_DESTINATION)?></td>
		<td width="70%"><input type="text" name="backupdestination" value="<?php echo $backupdestination?>" size="50"></td>
	</tr>   
	<tr>
	      <td colspan="2">
	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
	         <br/>
	         <b><?php echo $obLanguage->String(STR_BACKUP)?></b>
	      </td>
	</tr>	
	<tr>
		<td><?php echo $obLanguage->String(STR_SETTINGS)?></td>
		<td><input type="checkbox" name="backupsettings" value="1" <?php echo $backupsettingschecked?>></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_DOMAINS)?></td>
		<td><input type="checkbox" name="backupdomains" value="1" <?php echo $backupdomainschecked?>></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_MESSAGES)?></td>
		<td><input type="checkbox" name="backupmessages" value="1" <?php echo $backupmessageschecked?>></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_BUTTON_ADD)?></td>
		<td><input type="checkbox" name="backupcompress" value="1" <?php echo $backupcompresschecked?>></td>
	</tr>   		
	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>
<br/>
<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="backup">
   <input type="hidden" name="action" value="startbackup">
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td colspan="1">  
		   <br/>
		   <input type="submit" value="Start">
		</td>
	</tr>		
	</table>
</form>
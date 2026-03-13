<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obAntivirus	= $obSettings->AntiVirus();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obAntivirus->Action            = hmailGetVar("avaction",0);
	$obAntivirus->NotifySender      = hmailGetVar("avnotifysender",0);
	$obAntivirus->NotifyReceiver    = hmailGetVar("avnotifyreceiver",0);
	
	$obAntivirus->ClamWinEnabled    = hmailGetVar("clamwinenabled",0);
	$obAntivirus->ClamWinExecutable = hmailGetVar("clamwinexecutable",0);
	$obAntivirus->ClamWinDBFolder   = hmailGetVar("clamwindbfolder",0);
	
	$obAntivirus->CustomScannerEnabled    = hmailGetVar("customscannerenabled",0);
	$obAntivirus->CustomScannerExecutable = hmailGetVar("customscannerexecutable",0);
	$obAntivirus->CustomScannerReturnValue = hmailGetVar("customscannerreturnvalue",0);	
	

}

$avaction = $obAntivirus->Action;      
$avnotifysender = $obAntivirus->NotifySender;     
$avnotifyreceiver = $obAntivirus->NotifyReceiver;     

$clamwinenabled    = $obAntivirus->ClamWinEnabled;     
$clamwinexecutable = $obAntivirus->ClamWinExecutable;     
$clamwindbfolder    = $obAntivirus->ClamWinDBFolder;     
   
$customscannerenabled    = $obAntivirus->CustomScannerEnabled;     
$customscannerexecutable = $obAntivirus->CustomScannerExecutable;     
$customscannerreturnvalue    = $obAntivirus->CustomScannerReturnValue;  

$avactiondeletemailchecked = hmailCheckedIf1($avaction == 0);
$avactiondeletattachmentschecked = hmailCheckedIf1($avaction == 1);
   
$clamwinenabledchecked = hmailCheckedIf1($clamwinenabled);
$customscannerenabledchecked = hmailCheckedIf1($customscannerenabled);
?>

<h1><?php echo $obLanguage->String(STR_ANTIVIRUS)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="smtp_antivirus">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
     	<tr>
   	      <td colspan="2">
   	         <b><?php echo $obLanguage->String(STR_GENERAL)?></b>
   	      </td>
   	</tr>
	
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_WHENAVIRUSISFOUND)?></td>
		<td width="70%"><input type="radio" name="avaction" value="0" <?php echo $avactiondeletemailchecked?>> <?php echo $obLanguage->String(STR_AV_DELETE_EMAIL)?></td>
	</tr>  	
	<tr>
		<td></td>
		<td><input type="radio" name="avaction" value="1" <?php echo $avactiondeletattachmentschecked?>> <?php echo $obLanguage->String(STR_AV_DELETE_ATTACHMENTS)?></td>
	</tr>	
	<tr>
	      <td colspan="2">
	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
	         <br/>
	         <b>ClamWin</b>
	      </td>
	</tr>
	<tr>
		<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
		<td><input type="checkbox" name="clamwinenabled" value="1" <?php echo $clamwinenabledchecked?>></td>
	</tr> 		
	<tr>
		<td><?php echo $obLanguage->String(STR_AV_CLAMSCAN_EXECUTABLE)?></td>
		<td><input type="textbox" name="clamwinexecutable" value="<?php echo htmlentities($clamwinexecutable)?>" size="50"></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_AV_CLAMSCAN_DATABASE)?></td>
		<td><input type="textbox" name="clamwindbfolder" value="<?php echo htmlentities($clamwindbfolder)?>"  size="50"></td>
	</tr>  	
	<tr>
	      <td colspan="2">
	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
	         <br/>
	         <b><?php echo $obLanguage->String(STR_EXTERNALVIRUSSCANNER)?></b>
	      </td>
	</tr>
	<tr>
		<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
		<td><input type="checkbox" name="customscannerenabled" value="1" <?php echo $customscannerenabledchecked?>></td>
	</tr> 		
	<tr>
		<td><?php echo $obLanguage->String(STR_CUSTOMSCANNEREXECUTABLE)?></td>
		<td><input type="textbox" name="customscannerexecutable" value="<?php echo htmlentities($customscannerexecutable)?>" size="50"></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_CUSTOMSCANNERRETURNVALUE)?></td>
		<td><input type="textbox" name="customscannerreturnvalue" value="<?php echo $customscannerreturnvalue?>"  size="4"></td>
	</tr> 	
	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>
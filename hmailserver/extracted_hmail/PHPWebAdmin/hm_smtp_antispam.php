<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obAntiSpam	= $obSettings->AntiSpam;

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obSettings->TarpitCount= hmailGetVar("tarpitcount",0);
	$obSettings->TarpitDelay= hmailGetVar("tarpitdelay",0);
	$obSettings->UseSPF= hmailGetVar("usespf",0);
	$obSettings->UseMXChecks= hmailGetVar("usemxchecks",0);
	
	$obAntiSpam->CheckHostInHelo = hmailGetVar("checkhostinhelo", 0);
	
	$obAntiSpam->GreyListingEnabled = hmailGetVar("greylistingenabled", 0);
	$obAntiSpam->GreyListingInitialDelay = hmailGetVar("greylistinginitialdelay", 0);
	$obAntiSpam->GreyListingInitialDelete = hmailGetVar("greylistinginitialdelete", 0) * 24;
	$obAntiSpam->GreyListingFinalDelete = hmailGetVar("greylistingfinaldelete", 0) * 24;
	
	$obAntiSpam->AntiSpamAction = hmailGetVar("AntiSpamAction", 1);
	$obAntiSpam->AddHeaderSpam = hmailGetVar("AddHeaderSpam", 0);
	$obAntiSpam->AddHeaderReason = hmailGetVar("AddHeaderReason", 0);
	$obAntiSpam->PrependSubject = hmailGetVar("PrependSubject", 0);
	$obAntiSpam->PrependSubjectText = hmailGetVar("PrependSubjectText", "");
}

$usespf = $obSettings->UseSPF;     
$usemxchecks = $obSettings->UseMXChecks;     
$tarpitcount = $obSettings->TarpitCount;      
$tarpitdelay = $obSettings->TarpitDelay;    
$checkhostinhelo =   $obAntiSpam->CheckHostInHelo;

$greylistingenabled =   $obAntiSpam->GreyListingEnabled;
$greylistinginitialdelay = $obAntiSpam->GreyListingInitialDelay;
$greylistinginitialdelete = $obAntiSpam->GreyListingInitialDelete / 24;
$greylistingfinaldelete = $obAntiSpam->GreyListingFinalDelete / 24;

$AntiSpamAction =   $obAntiSpam->AntiSpamAction;
$AddHeaderSpam =   $obAntiSpam->AddHeaderSpam;
$AddHeaderReason =   $obAntiSpam->AddHeaderReason;
$PrependSubject =   $obAntiSpam->PrependSubject;
$PrependSubjectText =   $obAntiSpam->PrependSubjectText;

$usespfchecked = hmailCheckedIf1($usespf);
$usemxcheckschecked = hmailCheckedIf1($usemxchecks);
$checkhostinhelochecked = hmailCheckedIf1($checkhostinhelo);
$greylistingenabledchecked = hmailCheckedIf1($greylistingenabled);

$AddHeaderSpamChecked = hmailCheckedIf1($AddHeaderSpam);
$AddHeaderReasonChecked = hmailCheckedIf1($AddHeaderReason);
$PrependSubjectChecked = hmailCheckedIf1($PrependSubject);

if ($AntiSpamAction == 0)
{
   $AntiSpamActionDeleteChecked = " checked ";
   $AntiSpamActionDeliverChecked = "";
}
elseif ($AntiSpamAction == 1)
{
   $AntiSpamActionDeleteChecked = "";
   $AntiSpamActionDeliverChecked = " checked ";
}

?>
<h1><?php echo $obLanguage->String(STR_SPAMPROTECTION)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="smtp_antispam">
   <input type="hidden" name="action" value="save">

   <h2><?php echo $obLanguage->String(STR_WHEN_SPAM_HAS_BEEN_DETECTED)?></h2>   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="100%" colspan="3">
            <input type="radio" name="AntiSpamAction" value="0" <?php echo $AntiSpamActionDeleteChecked?>> <?php echo $obLanguage->String(STR_AV_DELETE_EMAIL)?><br/>
            <input type="radio" name="AntiSpamAction" value="1" <?php echo $AntiSpamActionDeliverChecked?>> <?php echo $obLanguage->String(STR_DELIVER_BUT_MODIFY_HEADERS)?>
         </td>
   	</tr> 	
   	<tr>
   	   <td width="10%"></td>
   		<td width="45%"><?php echo $obLanguage->String(STR_ADD_XHMAILSERVER_SPAM)?></td>
   		<td width="45%"><input type="checkbox" name="AddHeaderSpam" value="1" <?php echo $AddHeaderSpamChecked?>></td>
   	</tr> 		
   	<tr>
   	   <td></td>
   		<td><?php echo $obLanguage->String(STR_ADD_XHMAILSERVER_REASON)?></td>
   		<td><input type="checkbox" name="AddHeaderReason" value="1" <?php echo $AddHeaderReasonChecked?>></td>
   	</tr> 		  
   	<tr>
   	   <td></td>
   		<td><?php echo $obLanguage->String(STR_ADD_TO_MESSAGE_HEADER)?><br/>
   		</td>
   		<td>
   		   <input type="checkbox" name="PrependSubject" value="1" <?php echo $PrependSubjectChecked?>>
   		   <input type="text" name="PrependSubjectText" value="<?php echo $PrependSubjectText?>">
   		
   		</td>
   	</tr> 		  

   </table>
   

   <h2><?php echo $obLanguage->String(STR_GENERAL)?></h2>   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="30%"><?php echo $obLanguage->String(STR_USESPF)?></td>
   		<td width="70%"><input type="checkbox" name="usespf" value="1" <?php echo $usespfchecked?>></td>
   	</tr> 	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_USEMXCHECKS)?></td>
   		<td><input type="checkbox" name="usemxchecks" value="1" <?php echo $usemxcheckschecked?>></td>
   	</tr> 		
   	<tr>
   		<td><?php echo $obLanguage->String(STR_CHECK_HOST_IN_HELO)?></td>
   		<td><input type="checkbox" name="checkhostinhelo" value="1" <?php echo $checkhostinhelochecked?>></td>
   	</tr> 		
   </table>
   
   <h2><?php echo $obLanguage->String(STR_GREYLISTING)?></h2>   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="70%"><?php echo $obLanguage->String(STR_ACTIVATE)?></td>
   		<td width="30%"><input type="checkbox" name="greylistingenabled" value="1" <?php echo $greylistingenabledchecked?>></td>
   	</tr> 	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_MINUTES_TO_DEFER_DELIVERY_ATTEMPTS)?></td>
   		<td><input type="textbox" name="greylistinginitialdelay" value="<?php echo $greylistinginitialdelay?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MINUTES_TO_DEFER_DELIVERY_ATTEMPTS)?>"></td>
   	</tr>  	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_DAYS_BEFORE_REMOVING_UNUSED_RECORDS)?></td>
   		<td><input type="textbox" name="greylistinginitialdelete" value="<?php echo $greylistinginitialdelete?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DAYS_BEFORE_REMOVING_UNUSED_RECORDS)?>"></td>
   	</tr>  	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_DAYS_BEFORE_REMOVING_USED_RECORDS)?></td>
   		<td><input type="textbox" name="greylistingfinaldelete" value="<?php echo $greylistingfinaldelete?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DAYS_BEFORE_REMOVING_USED_RECORDS)?>"></td>
   	</tr>  	

   </table>
      
   
   <h2><?php echo $obLanguage->String(STR_TARPITTING)?></h2> 
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="30%"><?php echo $obLanguage->String(STR_COUNT)?></td>
   		<td width="70%"><input type="textbox" name="tarpitcount" value="<?php echo $tarpitcount?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_COUNT)?>"></td>
   	</tr>   
   	<tr>
   		<td><?php echo $obLanguage->String(STR_DELAYSECONDS)?></td>
   		<td><input type="textbox" name="tarpitdelay" value="<?php echo $tarpitdelay?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DELAYSECONDS)?>"></td>
   	</tr>  
   	<tr>
   		<td colspan="2">  
   		   <br/>
   		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
   		</td>
   	</tr>		
	</table>
</form>
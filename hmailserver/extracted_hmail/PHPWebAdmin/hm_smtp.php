<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	// General
	$obSettings->MaxSMTPConnections = hmailGetVar("maxsmtpconnections",0);
	$obSettings->WelcomeSMTP 	    = hmailGetVar("welcomesmtp",0);


	// Delivery of email
	$obSettings->SMTPNoOfTries= hmailGetVar("smtpnooftries",0);
	$obSettings->SMTPMinutesBetweenTry= hmailGetVar("smtpminutesbetweentry",0);
	$obSettings->SMTPRelayer= hmailGetVar("smtprelayer",0);
	$obSettings->SMTPRelayerPort= hmailGetVar("smtprelayerport",0);
	
	$obSettings->RuleLoopLimit = hmailGetVar("smtprulelooplimit",0);
	
	$obSettings->MaxMessageSize = hmailGetVar("maxmessagesize",0);
	
	$obSettings->SMTPDeliveryBindToIP = hmailGetVar("smtpdeliverybindtoip", "");
	$obSettings->MaxSMTPRecipientsInBatch = hmailGetVar("maxsmtprecipientsinbatch", "0");
	$obSettings->UseMXChecks= hmailGetVar("usemxchecks",0);
	$obSettings->UseDeliveryLog = hmailGetVar("usedeliverylog",0);
	
	// RFC compliance
	$obSettings->AllowSMTPAuthPlain = hmailGetVar("AllowSMTPAuthPlain",0);
	$obSettings->DenyMailFromNull = hmailGetVar("AllowMailFromNull",0) == "0";
	$obSettings->AllowIncorrectLineEndings = hmailGetVar("AllowIncorrectLineEndings",0);
	$obSettings->DisconnectInvalidClients = hmailGetVar("DisconnectInvalidClients",0);
	$obSettings->MaxNumberOfInvalidCommands = hmailGetVar("MaxNumberOfInvalidCommands",0);
	
	$obSettings->SendStatistics = hmailGetVar("SendStatistics",0);
}

// General
$maxsmtpconnections = $obSettings->MaxSMTPConnections;     
$welcomesmtp = $obSettings->WelcomeSMTP;     


// Delivery of email
$smtpnooftries = $obSettings->SMTPNoOfTries;     
$smtpminutesbetweentry = $obSettings->SMTPMinutesBetweenTry;
$smtprelayer = $obSettings->SMTPRelayer;
$smtprelayerport = $obSettings->SMTPRelayerPort;
$smtprulelooplimit = $obSettings->RuleLoopLimit;
$maxmessagesize = $obSettings->MaxMessageSize;

$smtpdeliverybindtoip = $obSettings->SMTPDeliveryBindToIP;
$maxsmtprecipientsinbatch = $obSettings->MaxSMTPRecipientsInBatch;
$usedeliverylog = $obSettings->UseDeliveryLog;

$AllowSMTPAuthPlain     = $obSettings->AllowSMTPAuthPlain;
$AllowMailFromNull      = $obSettings->DenyMailFromNull == "0";
$AllowIncorrectLineEndings     = $obSettings->AllowIncorrectLineEndings;
$DisconnectInvalidClients     = $obSettings->DisconnectInvalidClients;
$MaxNumberOfInvalidCommands     = $obSettings->MaxNumberOfInvalidCommands;

$SendStatistics         = $obSettings->SendStatistics;

$usedeliverylogchecked = hmailCheckedIf1($usedeliverylog);

$AllowSMTPAuthPlainChecked = hmailCheckedIf1($AllowSMTPAuthPlain);
$AllowMailFromNullChecked    = hmailCheckedIf1($AllowMailFromNull);
$AllowIncorrectLineEndingsChecked = hmailCheckedIf1($AllowIncorrectLineEndings);
$DisconnectInvalidClientsChecked = hmailCheckedIf1($DisconnectInvalidClients );
$SendStatisticsChecked = hmailCheckedIf1($SendStatistics );


?>

<h1><?php echo $obLanguage->String(STR_SMTP)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="smtp">
   <input type="hidden" name="action" value="save">
   
   <h2><?php echo $obLanguage->String(STR_GENERAL)?></h2>
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="30%"><?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?></td>
   		<td width="70%"><input type="textbox" name="maxsmtpconnections" value="<?php echo $maxsmtpconnections?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?>"></td>
   	</tr> 		
   	<tr>
   		<td><?php echo $obLanguage->String(STR_WELCOMEMESSAGE)?></td>
   		<td><input type="textbox" name="welcomesmtp" value="<?php echo $welcomesmtp?>" size="50"></td>
   	</tr> 	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_MAX_MESSAGE_SIZE)?></td>
   		<td><input type="textbox" name="maxmessagesize" value="<?php echo $maxmessagesize?>" size="5" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAX_MESSAGE_SIZE)?>"></td>
   	</tr>	
   </table>
   
   <h2><?php echo $obLanguage->String(STR_DELIVERYOFEMAIL)?></h2>
   
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_MINUTESBETWEENRETRY)?></td>
		<td width="70%"><input type="textbox" name="smtpminutesbetweentry" value="<?php echo $smtpminutesbetweentry?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MINUTESBETWEENRETRY)?>"></td>
	</tr>	
	<tr>
		<td><?php echo $obLanguage->String(STR_NUMBEROFRETRIES)?></td>
		<td><input type="textbox" name="smtpnooftries" value="<?php echo $smtpnooftries?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_NUMBEROFRETRIES)?>"></td>
	</tr>				
	<tr>
		<td><?php echo $obLanguage->String(STR_SMTPRELAYER)?></td>
		<td><input type="textbox" name="smtprelayer" value="<?php echo $smtprelayer?>" size="25"></td>
	</tr>
	<tr>
		<td><?php echo $obLanguage->String(STR_TCPPORT)?></td>
		<td><input type="textbox" name="smtprelayerport" value="<?php echo $smtprelayerport?>" size="25" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_TCPPORT)?>"></td>
	</tr>
	</table>
	
   <h2><?php echo $obLanguage->String(STR_STATISTICS)?></h2>
   
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="70%"><?php echo $obLanguage->String(STR_SEND_STATISTICS)?></td>
		<td width="30%"><input type="checkbox" name="SendStatistics" value="1" <?php echo $SendStatisticsChecked?>></td>
	</tr>	
   </table>	
   
   <h2><?php echo $obLanguage->String(STR_RFC_COMPLIANCE)?></h2>
   
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="70%"><?php echo $obLanguage->String(STR_ALLOW_PLAINTEXT_AUTH)?></td>
   		<td width="30%"><input type="checkbox" name="AllowSMTPAuthPlain" value="1" <?php echo $AllowSMTPAuthPlainChecked?>></td>
   	</tr>	   
   	<tr>
   		<td><?php echo $obLanguage->String(STR_ALLOW_EMPTY_SENDER_ADDRESS)?></td>
   		<td><input type="checkbox" name="AllowMailFromNull" value="1" <?php echo $AllowMailFromNullChecked?>></td>
   	</tr>	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_ALLOW_INCORRECTLY_FORMATTED_LINEENDINGS)?></td>
   		<td><input type="checkbox" name="AllowIncorrectLineEndings" value="1" <?php echo $AllowIncorrectLineEndingsChecked?>></td>
   	</tr>	   
  	   <tr>
   		<td><?php echo $obLanguage->String(STR_DISCONNECT_CLIENT_AFTER_TOO_MANY_INVALID_COMMANDS)?></td>
   		<td><input type="checkbox" name="DisconnectInvalidClients" value="1" <?php echo $DisconnectInvalidClientsChecked?>></td>
   	</tr>	   
  	   <tr>
   		<td><?php echo $obLanguage->String(STR_MAXIMUM_NUMBER_OF_INVALID_COMMANDS)?></td>
   		<td><input type="textbox" name="MaxNumberOfInvalidCommands" value="<?php echo $MaxNumberOfInvalidCommands?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAXIMUM_NUMBER_OF_INVALID_COMMANDS)?>"></td>
   	</tr>   			

	
	</table>  

   <h2><?php echo $obLanguage->String(STR_ADVANCED)?></h2>
   
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_BIND_TO_LOCAL_IPADDRESS)?></td>
		<td width="70%"><input type="textbox" name="smtpdeliverybindtoip" value="<?php echo $smtpdeliverybindtoip?>" size="20" checkallownull="true" checktype="ipaddress" checkmessage="<?php echo $obLanguage->String(STR_BIND_TO_LOCAL_IPADDRESS)?>"></td>
	</tr>	   
	<tr>
		<td><?php echo $obLanguage->String(STR_MAX_NUMBER_OF_RECIPIENTS_IN_BATCH)?></td>
		<td><input type="textbox" name="maxsmtprecipientsinbatch" value="<?php echo $maxsmtprecipientsinbatch?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAX_NUMBER_OF_RECIPIENTS_IN_BATCH)?>"></td>
	</tr>	
	<tr>
		<td><?php echo $obLanguage->String(STR_USEDELIVERYLOG)?></td>
		<td><input type="checkbox" name="usedeliverylog" value="1" <?php echo $usedeliverylogchecked?>></td>
	</tr> 		
	<tr>
		<td><?php echo $obLanguage->String(STR_RULE_LOOP_LIMIT)?></td>
		<td><input type="textbox" name="smtprulelooplimit" value="<?php echo $smtprulelooplimit?>" size="3" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_RULE_LOOP_LIMIT)?>"></td>
	</tr>		
	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>

<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obLogging	= $obSettings->Logging();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obLogging->Enabled		   = hmailGetVar("logenabled",0);
	$obLogging->LogApplication = hmailGetVar("logapplication",0); 
	$obLogging->LogSMTP		   = hmailGetVar("logsmtp",0);
	$obLogging->LogPOP3	   	= hmailGetVar("logpop3",0);
	$obLogging->LogIMAP	   	= hmailGetVar("logimap",0);
	$obLogging->LogTCPIP	      = hmailGetVar("logtcpip",0);
	$obLogging->LogDebug	      = hmailGetVar("logdebug",0);
	$obLogging->AwstatsEnabled  	= hmailGetVar("logawstats",0);

}

$logenabledchecked = hmailCheckedIf1($obLogging->Enabled);
$logapplicationchecked = hmailCheckedIf1($obLogging->LogApplication);
$logsmtpchecked = hmailCheckedIf1($obLogging->LogSMTP);
$logpop3checked = hmailCheckedIf1($obLogging->LogPOP3);
$logimapchecked = hmailCheckedIf1($obLogging->LogIMAP);
$logtcpipchecked = hmailCheckedIf1($obLogging->LogTCPIP);
$logdebugchecked = hmailCheckedIf1($obLogging->LogDebug);     
$logawstatschecked = hmailCheckedIf1($obLogging->AwstatsEnabled);

?>

<h1><?php echo $obLanguage->String(STR_LOGGING)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="logging">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
		<td width="70%"><input type="checkbox" name="logenabled" value="1" <?php echo $logenabledchecked?>></td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_APPEVENTS)?></td>
		<td><input type="checkbox" name="logapplication" value="1" <?php echo $logapplicationchecked?>></td>
	</tr>  	
	<tr>
		<td><?php echo $obLanguage->String(STR_SMTP)?></td>
		<td><input type="checkbox" name="logsmtp" value="1" <?php echo $logsmtpchecked?>></td>
	</tr>  	
	<tr>
		<td><?php echo $obLanguage->String(STR_POP3)?></td>
		<td><input type="checkbox" name="logpop3" value="1" <?php echo $logpop3checked?>></td>
	</tr>  		
	<tr>
		<td><?php echo $obLanguage->String(STR_IMAP)?></td>
		<td><input type="checkbox" name="logimap" value="1" <?php echo $logimapchecked?>></td>
	</tr>  		
	<tr>
		<td><?php echo $obLanguage->String(STR_DEBUG)?></td>
		<td><input type="checkbox" name="logdebug" value="1" <?php echo $logdebugchecked?>></td>
	</tr>  		
	<tr>
		<td><?php echo $obLanguage->String(STR_TCPIPEVENTS)?></td>
		<td><input type="checkbox" name="logtcpip" value="1" <?php echo $logtcpipchecked?>></td>
	</tr>  		
	<tr>
		<td>AWStats</td>
		<td><input type="checkbox" name="logawstats" value="1" <?php echo $logawstatschecked?>></td>
	</tr>  	
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>		
	</table>
</form>
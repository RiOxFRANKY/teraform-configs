<?php

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Not server admin

$tcpipportid 	= hmailGetVar("tcpipportid",0);
$action	   = hmailGetVar("action","");

$obSettings	   = $obBaseApp->Settings();
$obTCPIPPOrts  = $obSettings->TCPIPPorts;

$protocol    = 1;
$portnumber = "";

if ($action == "edit")
{
   $obTCPIPPort     = $obTCPIPPOrts->ItemByDBID($tcpipportid);
   $portnumber      = $obTCPIPPort->PortNumber;
   $protocol        = $obTCPIPPort->Protocol;
}

?>

<h1><?php echo $obLanguage->String(STR_TCPPORT)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_tcpipport_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="tcpipportid" value="<?php echo $tcpipportid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_PROTOCOL)?></td>
			<td width="70%">
				<select name="protocol"  style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
					<option value="1" <?php if ($protocol == "1") echo "selected";?> ><?php echo $obLanguage->String(STR_SMTP)?></a>
					<option value="3" <?php if ($protocol == "3") echo "selected";?> ><?php echo $obLanguage->String(STR_POP3)?></a>
					<option value="5" <?php if ($protocol == "5") echo "selected";?> ><?php echo $obLanguage->String(STR_IMAP)?></a>
				</select>
         	</td>			
		</tr>
	<tr>
			<td><?php echo $obLanguage->String(STR_TCPPORT)?></td>
			<td>
   				<input type="text" name="portnumber" value="<?php echo $portnumber?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_TCPPORT)?>">
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

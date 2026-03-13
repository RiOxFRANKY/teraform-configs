<?php

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Domain admin but not for this domain.

$iphomeid 	= hmailGetVar("iphomeid",0);
$action	   = hmailGetVar("action","");

$obSettings	= $obBaseApp->Settings();
$obIPHomes  = $obSettings->IPHomes;

$iphomeaddress = "";

if ($action == "edit")
{
   $obIPHome = $obIPHomes->ItemByDBID($iphomeid);
   $iphomeaddress   = $obIPHome->IPAddress;
}

?>

<h1><?php echo $obLanguage->String(STR_IP_ADDRESS)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_iphome_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="iphomeid" value="<?php echo $iphomeid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_IP_ADDRESS)?></td>
			<td width="70%">
   			<input type="text" name="iphomeaddress" value="<?php echo $iphomeaddress?>" checkallownull="false" checktype="ipaddress" checkmessage="<?php echo $obLanguage->String(STR_IP_ADDRESS)?>">
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

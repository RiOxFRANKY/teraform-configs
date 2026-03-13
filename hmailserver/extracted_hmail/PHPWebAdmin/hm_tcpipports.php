<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obTCPIPPorts  = $obSettings->TCPIPPorts;

$action	   = hmailGetVar("action","");

?>

<h1><?php echo $obLanguage->String(STR_TCPIP_PORTS)?></h1>

<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_PROTOCOL)?></td>
		<td width="30%"><?php echo $obLanguage->String(STR_TCPPORT)?></td>
		<td width="20%"></td>
	</tr>
	
<?php
$bgcolor = "#EEEEEE";

$Count = $obTCPIPPorts->Count();


$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obTCPIPPort         = $obTCPIPPorts->Item($i);
	
	$portprotcol             = $obTCPIPPort->Protocol;
	$portid            	     = $obTCPIPPort->ID;
	$portnumber              = $obTCPIPPort->PortNumber;
	
	$protocol_name = "";
	switch ($portprotcol)
	{
		case 1:
			
			$protocol_name = $obLanguage->String(STR_SMTP);
			break;
		case 3:
			$protocol_name = $obLanguage->String(STR_POP3);
			break;
		case 5:
			$protocol_name = $obLanguage->String(STR_IMAP);
			break;
	}
	
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"30%\"><a href=\"?page=tcpipport&action=edit&tcpipportid=$portid\">$protocol_name</a></td>";
	echo "<td width=\"30%\"><a href=\"?page=tcpipport&action=edit&tcpipportid=$portid\">$portnumber</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_tcpipport_save&action=delete&tcpipportid=$portid\">$str_delete</a></td>";
	echo "</tr>";
	
	if ($bgcolor == "#EEEEEE")
	   $bgcolor = "#DDDDDD";
	else
	   $bgcolor = "#EEEEEE";
}
?>
<tr>
   <td>
      <br>
      <a href="?page=tcpipport&action=add"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>

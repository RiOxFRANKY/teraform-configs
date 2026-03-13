<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obIPHomes  = $obSettings->IPHomes;

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obSettings->ListenOnAllAddresses   = hmailGetVar("multihomingalladdresses",0);
}
   
$multihomingalladdresses = $obSettings->ListenOnAllAddresses;
?>

<h1><?php echo $obLanguage->String(STR_MULTIHOMING)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="multihoming">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
	      <td colspan="2">
	         <br/>
	         <b><?php echo $obLanguage->String(STR_LISTEN_ON)?></b>
	      </td>
	</tr>	
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_ALL_TCPIP_ADDRESSES)?></td>
		<td width="70%" colspan="2"><input type="radio" name="multihomingalladdresses" value="1" <?php if ($multihomingalladdresses == 1) echo "checked";?>></td>
	</tr>   
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_TCPIP_ADDRESSES_BELOW)?></td>
		<td width="70%" colspan="2"><input type="radio" name="multihomingalladdresses" value="0" <?php if ($multihomingalladdresses == 0) echo "checked";?>></td>
	</tr>   
	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>

<h1><?php echo $obLanguage->String(STR_ADDRESSES)?></h1>

<table border="0" class="settingsborder" width="100%" cellpadding="5">

<?php
$bgcolor = "#EEEEEE";

$Count = $obIPHomes->Count();


$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obIPHome            = $obIPHomes->Item($i);
	$iphomeaddress       = $obIPHome->IPAddress;
	$iphomeid            = $obIPHome->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"80%\"><a href=\"?page=iphome&action=edit&iphomeid=$iphomeid\">$iphomeaddress</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_iphome_save&action=delete&iphomeid=$iphomeid\">$str_delete</a></td>";
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
      <a href="?page=iphome&action=add"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>

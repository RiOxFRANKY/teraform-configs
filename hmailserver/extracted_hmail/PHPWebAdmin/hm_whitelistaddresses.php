<?php
   if (hmailGetAdminLevel() != 2)
   	hmailHackingAttemp(); // Only server admins can change this.
   
   $obWhiteListAddresses	= $obBaseApp->Settings()->AntiSpam()->WhiteListAddresses;

?>

<h1><?php echo $obLanguage->String(STR_WHITELISTING)?></h1>

<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_DESCRIPTION)?></td>
		<td width="20%"><?php echo $obLanguage->String(STR_LOWERIP)?></td>
		<td width="20%"><?php echo $obLanguage->String(STR_UPPERIP)?></td>
		<td width="20%"><?php echo $obLanguage->String(STR_EMAILADDRESS)?></td>
	</tr>
	
<?php
$bgcolor = "#EEEEEE";

$Count = $obWhiteListAddresses->Count();



$str_delete     = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obAddress   = $obWhiteListAddresses->Item($i);
	
	$ID   	               = $obAddress->ID;
	$LowerIPAddress         = $obAddress->LowerIPAddress;
	$UpperIPAddress         = $obAddress->UpperIPAddress;
	$EmailAddress		      = $obAddress->EmailAddress;
	$Description	      	= $obAddress->Description;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td><a href=\"?page=whitelistaddress&action=edit&ID=$ID\">$Description</a></td>";
	echo "<td><a href=\"?page=whitelistaddress&action=edit&ID=$ID\">$LowerIPAddress</a></td>";
	echo "<td><a href=\"?page=whitelistaddress&action=edit&ID=$ID\">$UpperIPAddress</a></td>";
	echo "<td><a href=\"?page=whitelistaddress&action=edit&ID=$ID\">$EmailAddress</a></td>";
	echo "<td><a href=\"?page=background_whitelistaddress_save&action=delete&ID=$ID\">$str_delete</a></td>";
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
      <a href="?page=whitelistaddress&action=add"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>



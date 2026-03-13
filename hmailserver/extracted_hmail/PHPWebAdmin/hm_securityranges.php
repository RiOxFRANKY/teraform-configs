<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Users are not allowed to show this page.

$domainid  = hmailGetVar("domainid",null);

?>
<h1><?php echo $obLanguage->String(STR_IPRANGES)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php

$bgcolor = "#EEEEEE";

$obSettings			= $obBaseApp->Settings();
$obSecurityRanges	= $obSettings->SecurityRanges();

$Count = $obSecurityRanges->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obSecurityRange     = $obSecurityRanges->Item($i);
	$securityrangename   = $obSecurityRange->Name;
	$securityrangeid     = $obSecurityRange->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"80%\"><a href=\"?page=securityrange&action=edit&securityrangeid=$securityrangeid&\">$securityrangename</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_securityrange_save&action=delete&securityrangeid=$securityrangeid\">$str_delete</a></td>";
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
      <a href="?page=securityrange&action=add"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>

</table>
<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

?>
<h1><?php echo $obLanguage->String(STR_DOMAINS)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php

$bgcolor = "#EEEEEE";

$DomainCount = $obBaseApp->Domains->Count();
$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

$str_name      = $obLanguage->String(STR_DOMAINNAME);
$str_maxsizemb = $obLanguage->String(STR_MAXSIZEMB);

echo "<tr bgcolor=\"#CCCCCC\">";
echo "<td width=\"60%\">$str_name</td>";
echo "<td width=\"20%\">$str_maxsizemb</td>";
echo "<td width=\"20%\"></td>";
echo "</tr>";

for ($i = 1; $i <= $DomainCount; $i++)
{
	$obDomain            = $obBaseApp->Domains->Item($i-1);
	$domainname          = $obDomain->Name;
	$domainid            = $obDomain->ID;
	$domainmaxsize       = $obDomain->MaxSize;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"60%\"><a href=\"?page=domain&action=edit&domainid=$domainid\">$domainname</a></td>";
	echo "<td width=\"20%\">$domainmaxsize</td>";
	echo "<td width=\"20%\"><a href=\"?page=background_domain_save&action=delete&domainid=$domainid&\">$str_delete</a></td>";
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
      <a href="?page=domain&action=add"><i><?php echo $obLanguage->String(STR_ADD_DOMAIN)?></i></a>
   </td>
</tr>
</table>
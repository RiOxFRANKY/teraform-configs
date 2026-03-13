<?php

$domainid  = hmailGetVar("domainid",null);

if (hmailGetAdminLevel() == 0)
	hmailHackingAttemp(); // Users are not allowed to show this page.

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.
	

?>
<h1><?php echo $obLanguage->String(STR_ALIASES)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php

$bgcolor = "#EEEEEE";

$obDomain			= $obBaseApp->Domains->ItemByDBID($domainid);
$obAliases 			= $obDomain->Aliases();

$Count = $obAliases->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);
for ($i = 0; $i < $Count; $i++)
{
	$obAlias             = $obDomain->Aliases->Item($i);
	$aliasname           = $obAlias->Name;
	$aliasid             = $obAlias->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"80%\"><a href=\"?page=alias&action=edit&domainid=$domainid&aliasid=$aliasid\">$aliasname</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_alias_save&action=delete&domainid=$domainid&aliasid=$aliasid\">$str_delete</a></td>";
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
      <a href="?page=alias&action=add&domainid=<?php echo $domainid?>"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>
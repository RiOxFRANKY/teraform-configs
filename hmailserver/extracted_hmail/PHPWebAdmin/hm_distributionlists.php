<?php

$domainid  = hmailGetVar("domainid",null);

if (hmailGetAdminLevel() == 0)
	hmailHackingAttemp(); // Users are not allowed to show this page.

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

?>
<h1><?php echo $obLanguage->String(STR_DISTRIBUTIONLISTS)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php


$bgcolor = "#EEEEEE";

$obDomain			= $obBaseApp->Domains->ItemByDBID($domainid);
$obLists 			= $obDomain->DistributionLists();

$Count = $obLists->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obList              = $obDomain->DistributionLists->Item($i);
	$listaddress         = $obList->Address;
	$listid              = $obList->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td><a href=\"?page=distributionlist&action=edit&domainid=$domainid&distributionlistid=$listid&\">$listaddress</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_distributionlist_save&action=delete&domainid=$domainid&distributionlistid=$listid\">$str_delete</a></td>";
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
      <a href="?page=distributionlist&action=add&domainid=<?php echo $domainid?>"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>
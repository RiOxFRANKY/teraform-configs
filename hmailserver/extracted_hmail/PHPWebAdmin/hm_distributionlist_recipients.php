<?php

$domainid  = hmailGetVar("domainid",null);
$distributionlistid	= hmailGetVar("distributionlistid",0);

if (hmailGetAdminLevel() == 0)
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

?>
<h1><?php echo $obLanguage->String(STR_MEMBERS)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php
$bgcolor = "#EEEEEE";

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
$obList = $obDomain->DistributionLists->ItemByDBID($distributionlistid);
$obRecipients = $obList->Recipients;

$Count = $obRecipients->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obRecipient         = $obRecipients->Item($i);
	
	$recipientaddress    = $obRecipient->RecipientAddress;
	$recipientid         = $obRecipient->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"80%\"><a href=\"?page=distributionlist_recipient&action=edit&domainid=$domainid&distributionlistid=$distributionlistid&recipientid=$recipientid\">$recipientaddress</a></td>";
	echo "<td width=\"20%\"><a href=\"?page=background_distributionlist_recipient_save&action=delete&domainid=$domainid&distributionlistid=$distributionlistid&recipientid=$recipientid\">$str_delete</a></td>";
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
      <a href="?page=distributionlist_recipient&action=add&domainid=<?php echo $domainid?>&distributionlistid=<?php echo $distributionlistid?>"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>

</table>


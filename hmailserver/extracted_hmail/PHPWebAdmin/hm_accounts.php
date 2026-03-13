<h1><?php echo $obLanguage->String(STR_ACCOUNTS)?></h1>
<?php

$domainid  = hmailGetVar("domainid",null);

if (hmailGetAdminLevel() == 0)
	hmailHackingAttemp(); // Users are not allowed to show this page.

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

echo '<table border="0" class="settingsborder" width="100%" cellpadding="5">';

$bgcolor = "#EEEEEE";

$obDomain				= $obBaseApp->Domains->ItemByDBID($domainid);
$obAccounts 			= $obDomain->Accounts();

$Count = $obAccounts->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

$currentaccountid = hmailGetAccountID();

$str_accountaddress  = $obLanguage->String(STR_ACCOUNTADDRESS);
$str_maxsizemb       = $obLanguage->String(STR_MAXSIZEMB);

echo "<tr bgcolor=\"#CCCCCC\">";
echo "<td width=\"60%\">$str_accountaddress</td>";
echo "<td width=\"20%\">$str_maxsizemb</td>";
echo "<td width=\"20%\"></td>";
echo "</tr>";

for ($i = 0; $i < $Count; $i++)
{
	$obAccount           = $obDomain->Accounts->Item($i);
	$accountaddress      = $obAccount->Address;
	$accountid           = $obAccount->ID;
	$accountmaxsize      = $obAccount->MaxSize();
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=\"60%\"><a href=\"?page=account&action=edit&domainid=$domainid&accountid=$accountid\">$accountaddress</a></td>";
	echo "<td width=\"20%\">$accountmaxsize</td>";
	
	echo "<td width=\"20%\">";
	if ($currentaccountid != $accountid)
	   echo "<a href=\"?page=background_account_save&action=delete&domainid=$domainid&accountid=$accountid\">$str_delete</a>";

	else "</td>";
	   
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
      <a href="?page=account&action=add&domainid=<?php echo $domainid?>"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>
</table>
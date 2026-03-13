<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Users are not allowed to show this page.

?>
<h1><?php echo $obLanguage->String(STR_ROUTES)?></h1>
<table border="0" class="settingsborder" width="100%" cellpadding="5">
<?php
$bgcolor = "#EEEEEE";

$obRoutes	= $obSettings->Routes();

$Count = $obRoutes->Count();

$str_delete = $obLanguage->String(STR_BUTTON_DELETE);

for ($i = 0; $i < $Count; $i++)
{
	$obRoute             = $obRoutes->Item($i);
	$routename           = $obRoute->DomainName;
	$routeid             = $obRoute->ID;
	
	echo "<tr bgcolor=\"$bgcolor\">";
	echo "<td width=80><a href=\"?page=route&action=edit&routeid=$routeid&\">$routename</a></td>";
	echo "<td width=20><a href=\"?page=background_route_save&action=delete&routeid=$routeid&\">$str_delete</a></td>";
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
      <a href="?page=route&action=add"><i><?php echo $obLanguage->String(STR_BUTTON_ADD)?></i></a>
   </td>
</tr>

</table>


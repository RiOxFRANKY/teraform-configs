<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); 
	
$routeid 	= hmailGetVar("routeid",0);
$routeaddressid	= hmailGetVar("routeaddressid",0);
$action	   = hmailGetVar("action","");

$routeaddress = "";

if ($action == "edit")
{
   $obRoute = $obSettings->Routes->ItemByDBID($routeid);
   $obRouteAddresses = $obRoute->Addresses;
   $obRouteAddress = $obRouteAddresses->ItemByDBID($routeaddressid);
   $routeaddress   = $obRouteAddress->Address;
}

?>

<h1><?php echo $obLanguage->String(STR_ADDRESS)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_route_address_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="routeid" value="<?php echo $routeid?>">
	<input type="hidden" name="routeaddressid" value="<?php echo $routeaddressid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td width="70%">
   			<input type="text" name="routeaddress" value="<?php echo $routeaddress?>" size="35" checkallownull="false" checktype="email" checkmessage="<?php echo $obLanguage->String(STR_ADDRESS)?>">
         </td>			
		</tr>
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

<?php

if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Only server admins can change this.

$ID 		   = hmailGetVar("ID",0);
$action	   = hmailGetVar("action","");

$obWhiteListAddresses	= $obBaseApp->Settings()->AntiSpam()->WhiteListAddresses;

if ($action == "edit")
{
   $obAddress = $obWhiteListAddresses->ItemByDBID($ID);
	
   $LowerIPAddress       = $obAddress->LowerIPAddress;
   $UpperIPAddress       = $obAddress->UpperIPAddress;
   $EmailAddress         = $obAddress->EmailAddress;
   $Description          = $obAddress->Description;
}
else 
{
   $LowerIPAddress = "";
   $UpperIPAddress = "";
   $EmailAddress = "";
   $Description = "";
}
?>

<h1><?php echo $obLanguage->String(STR_IP_ADDRESS)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_whitelistaddress_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="ID" value="<?php echo $ID?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="40%"><?php echo $obLanguage->String(STR_DESCRIPTION)?></td>
			<td width="60%">
   		   <input type="text" name="Description" value="<?php echo $Description?>" size="50" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_DESCRIPTION)?>">
         </td>			
		</tr>	

		<tr>
			<td><?php echo $obLanguage->String(STR_LOWERIP)?></td>
			<td>
   		   <input type="text" name="LowerIPAddress" value="<?php echo $LowerIPAddress?>" size="20">
         </td>			
		</tr>	

		<tr>
			<td><?php echo $obLanguage->String(STR_UPPERIP)?></td>
			<td>
   		   <input type="text" name="UpperIPAddress" value="<?php echo $UpperIPAddress?>" size="20">
         </td>			
		</tr>	
		
		<tr>
			<td><?php echo $obLanguage->String(STR_EMAILADDRESS)?></td>
			<td>
   		   <input type="text" name="EmailAddress" value="<?php echo $EmailAddress?>" size="50">
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

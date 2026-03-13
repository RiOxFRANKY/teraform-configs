<?php

$domainid  = hmailGetVar("domainid",null);
$distributionlistid	         = hmailGetVar("distributionlistid",0);
$action	                     = hmailGetVar("action","");

$error_message	   = hmailGetVar("error_message","");

if (hmailGetAdminLevel() == 0)
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);

$listaddress="";
$listactive=0;
$listrequiresmtpauth=0;


$Mode = 0;

if ($action == "edit")
{
   $obList = $obDomain->DistributionLists->ItemByDBID($distributionlistid);

   $listaddress = $obList->Address;
   $listactive = $obList->Active;
   $listrequiresmtpauth = $obList->RequireSMTPAuth;
   $Mode = $obList->Mode;
   $RequireSenderAddress = $obList->RequireSenderAddress;

   $listaddress = substr($listaddress, 0, strpos($listaddress, "@"));
   
}
else
{
   $RequireSenderAddress = "";
}

$domainname = $obDomain->Name;

$listactivechecked = hmailCheckedIf1($listactive);
$listrequiresmtpauthchecked = hmailCheckedIf1($listrequiresmtpauth);
?>

<h1><?php echo $obLanguage->String(STR_DISTRIBUTIONLIST)?></h1>

<?php
   if (strlen($error_message) > 0)
   {
      $error_message = $obLanguage->String($error_message);
      echo "<font color=\"red\"><b>$error_message</b></font><br><br>";
   }
?>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_distributionlist_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="distributionlistid" value="<?php echo $distributionlistid?>">
	<input type="hidden" name="domainid" value="<?php echo $domainid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
     	<tr>
   	      <td colspan="2">
   	         <b><?php echo $obLanguage->String(STR_GENERAL)?></b>
   	      </td>
   	</tr>
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td width="70%">
   				<input type="text" name="listaddress" value="<?php echo $listaddress?>" size="30" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_ADDRESS)?>"> @<?php echo $domainname?>
            </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td><input type="checkbox" name="listactive" value="1" <?php echo $listactivechecked?>></td>
		</tr>
   		<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_SECURITY)?></b>
   	      </td>
   		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_MODE)?></td>
			<td>
				<select name="Mode" style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
					<option value="0" <?php if ($Mode == 0) echo "selected";?> ><?php echo $obLanguage->String(STR_PUBLIC_ANYONE_CAN_SEND)?></option>
					<option value="1" <?php if ($Mode == 1) echo "selected";?> ><?php echo $obLanguage->String(STR_MEMBERSHIP_ONLY_MEMBERS_CAN_SEND)?></option>
					<option value="2" <?php if ($Mode == 2) echo "selected";?> ><?php echo $obLanguage->String(STR_ANNOUNCEMENTS_ONLY_ALLOW_FOLLOWING_SNEDER)?></option>
				</select>
		
			</td>
		</tr>   	
		<tr>
			<td><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td>
   				<input type="text" name="RequireSenderAddress" value="<?php echo $RequireSenderAddress?>" size="30">
            </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_REQUIRESMTPAUTH)?></td>
			<td><input type="checkbox" name="listrequiresmtpauth" value="1" <?php echo $listrequiresmtpauthchecked?>></td>
		</tr>
 	
 		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

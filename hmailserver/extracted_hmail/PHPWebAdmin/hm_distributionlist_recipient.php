<?php

$distributionlistid 	= hmailGetVar("distributionlistid",0);
$recipientid	      = hmailGetVar("recipientid",0);
$domainid	      = hmailGetVar("domainid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 0)
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$recipientaddress = "";

if ($action == "edit")
{
   $obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
   $obList = $obDomain->DistributionLists->ItemByDBID($distributionlistid);
   $obRecipient = $obList->Recipients->ItemByDBID($recipientid);

   $recipientaddress = $obRecipient->RecipientAddress;
}

?>

<h1><?php echo $obLanguage->String(STR_RECIPIENTADDRESS)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_distributionlist_recipient_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
   <input type="hidden" name="distributionlistid" value="<?php echo $distributionlistid?>">
	<input type="hidden" name="domainid" value="<?php echo $domainid?>">
	<input type="hidden" name="recipientid" value="<?php echo $recipientid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td width="70%">
   			<input type="text" name="recipientaddress" value="<?php echo $recipientaddress?>" size="30"  checkallownull="false" checktype="email" checkmessage="<?php echo $obLanguage->String(STR_ADDRESS)?>">
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

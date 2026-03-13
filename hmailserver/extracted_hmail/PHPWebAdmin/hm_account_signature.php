<?php

$domainid	= hmailGetVar("domainid",0);
$accountid	= hmailGetVar("accountid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 0 && ($accountid != hmailGetAccountID() || $domainid != hmailGetDomainID()))
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);

$obAccount = $obDomain->Accounts->ItemByDBID($accountid);  

if ($action == "save")
{
   // Fetch settings from form
   $SignatureEnabled  = hmailGetVar("SignatureEnabled","0");
   $SignatureHTML   = hmailGetVar("SignatureHTML","");
   $SignaturePlainText   =   hmailGetVar("SignaturePlainText","0");
   
   // Save the settings
   $obAccount->SignatureEnabled		= $SignatureEnabled == "1";
   $obAccount->SignatureHTML		= $SignatureHTML;
   $obAccount->SignaturePlainText	= $SignaturePlainText;
     
   $obAccount->Save();   
}

$SignatureEnabled   = $obAccount->SignatureEnabled;
$SignatureHTML 	    = $obAccount->SignatureHTML;
$SignaturePlainText = $obAccount->SignaturePlainText;
  
$SignatureEnabledChecked = hmailCheckedIf1($SignatureEnabled);
   
?>

<h1><?php echo $obLanguage->String(STR_SIGNATURE)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="account_signature">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	<input type="hidden" name="accountid" value="<?php echo $obAccount->ID?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td width="70%">
   			<?php
   			echo "<input type=\"checkbox\" name=\"SignatureEnabled\" value=\"1\" $SignatureEnabledChecked>";
   			?>
         </td>			
		</tr>
		<tr>
			<td valign="top"><?php echo $obLanguage->String(STR_PLAIN_TEXT_SIGNATURE)?></td>
			<td>
				<textarea cols="50" rows="4" name="SignaturePlainText"><?php echo $SignaturePlainText?></textarea>
			</td>
		</tr>
		<tr>
			<td valign="top"><?php echo $obLanguage->String(STR_HTML_SIGNATURE)?></td>
			<td>
				<textarea cols="50" rows="4" name="SignatureHTML"><?php echo $SignatureHTML?></textarea>
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

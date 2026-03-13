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
   $forwardenabled  = hmailGetVar("forwardenabled","0");
   $forwardaddress   = hmailGetVar("forwardaddress","");
   $forwardkeeporiginal   =   hmailGetVar("forwardkeeporiginal","0");
   
   // Save the settings
   $obAccount->ForwardEnabled		= $forwardenabled == "1";
   $obAccount->ForwardAddress		= $forwardaddress;
   $obAccount->ForwardKeepOriginal	= $forwardkeeporiginal == "1";
     
   $obAccount->Save();   
}

$forwardenabled = $obAccount->ForwardEnabled;
$forwardaddress = $obAccount->ForwardAddress;
$forwardkeeporiginal = $obAccount->ForwardKeepOriginal;
  
$forwardenabledchecked = hmailCheckedIf1($forwardenabled);
$forwardkeeporiginalchecked = hmailCheckedIf1($forwardkeeporiginal);
   
?>

<h1><?php echo $obLanguage->String(STR_FORWARDING)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="account_forward">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	<input type="hidden" name="accountid" value="<?php echo $obAccount->ID?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td width="70%">
   			<?php
   			echo "<input type=\"checkbox\" name=\"forwardenabled\" value=\"1\" $forwardenabledchecked>";
   			?>
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_ADDRESS)?></td>
			<td><input type="text" name="forwardaddress" value="<?php echo $forwardaddress?>" size="40"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_KEEP_ORIGINAL_MESSAGE)?></td>
			<td>
				<?php
					echo "<input type=\"checkbox\" name=\"forwardkeeporiginal\" value=\"1\" $forwardkeeporiginalchecked>";
				?>
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

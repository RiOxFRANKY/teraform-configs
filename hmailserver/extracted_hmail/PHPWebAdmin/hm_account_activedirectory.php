<?php

$domainid	= hmailGetVar("domainid",0);
$accountid	= hmailGetVar("accountid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 0)
	hmailHackingAttemp(); // Users are not allowed to show this page.

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
$obAccount = $obDomain->Accounts->ItemByDBID($accountid);  

if ($action == "save")
{
   // Fetch settings from form
   $adenabled   = hmailGetVar("adenabled","");
   $addomain    = hmailGetVar("addomain","0");
   $adusername  =   hmailGetVar("adusername","");
   
   // Save the settings
   $obAccount->IsAD         = $adenabled == "1";
   $obAccount->ADDomain     = $addomain;
   $obAccount->ADUsername   = $adusername;   
  
   $obAccount->Save();  
}

$adenabled       = $obAccount->IsAD;
$addomain        = $obAccount->ADDomain;
$adusername      = $obAccount->ADUsername;
  
$adenabledchecked = hmailCheckedIf1($adenabled);

   
?>

<h1><?php echo $obLanguage->String(STR_ACTIVEDIRECTORY)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="account_activedirectory">
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	<input type="hidden" name="accountid" value="<?php echo $obAccount->ID?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td width="70%">
   			<?php
   			echo "<input type=\"checkbox\" name=\"adenabled\" value=\"1\" $adenabledchecked>";
   			?>
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_DOMAIN)?></td>
			<td><input type="text" name="addomain" value="<?php echo $addomain?>"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_ACCOUNT)?></td>
			<td><input type="text" name="adusername" value="<?php echo $adusername?>"></td>
		</tr>
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

<?php

$domainid	= hmailGetVar("domainid",0);
$aliasid	   = hmailGetVar("aliasid",0);
$action	   = hmailGetVar("action","");

$error_message	   = hmailGetVar("error_message","");

if (hmailGetAdminLevel() == 0)
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.
				     
$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);

$aliasname="";
$aliasvalue="";
$aliasactive=0;
				     
if ($action == "edit")
{
   $obAlias = $obDomain->Aliases->ItemByDBID($aliasid);  
   $aliasname = $obAlias->Name;
   $aliasvalue = $obAlias->Value;
   $aliasactive  = $obAlias->Active;
   $aliasname = substr($aliasname, 0, strpos($aliasname, "@"));
}

$domainname = $obDomain->Name;

$aliasactivechecked = hmailCheckedIf1($aliasactive);

?>

<h1><?php echo $obLanguage->String(STR_ALIAS)?></h1>

<?php
   if (strlen($error_message) > 0)
   {
      $error_message = $obLanguage->String($error_message);
      echo "<font color=\"red\"><b>$error_message</b></font><br><br>";
   }
?>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_alias_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="domainid" value="<?php echo $domainid?>">
	<input type="hidden" name="aliasid" value="<?php echo $aliasid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_NAME)?></td>
			<td width="70%"><input type="text" name="aliasname" value="<?php echo $aliasname?>" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_NAME)?>">@<?php echo $domainname?></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_VALUE)?></td>
			<td><input type="text" name="aliasvalue" value="<?php echo $aliasvalue?>"  checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_VALUE)?>"></td>
		</tr>

		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td><input type="checkbox" name="aliasactive" value="1" <?php echo $aliasactivechecked?>></td>
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

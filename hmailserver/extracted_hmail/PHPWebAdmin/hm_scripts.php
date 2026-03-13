<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obScripting    = $obSettings->Scripting();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obScripting->Enabled = hmailGetVar("scriptingenabled",0);
	$obScripting->Language = hmailGetVar("scriptinglanguage",0);
}
elseif ($action == "checksyntax")
{
   $syntax_result = $obScripting->CheckSyntax();
}
elseif ($action == "reloadscripts")
{
   $obScripting->Reload();
}


$scriptingenabled = $obScripting->Enabled;
$scriptinglanguage = $obScripting->Language;

$scriptingenabledchecked = hmailCheckedIf1($scriptingenabled);

?>

<h1><?php echo $obLanguage->String(STR_SCRIPT)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="scripts">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
		<td width="70%" colspan="2"><input type="checkbox" name="scriptingenabled" value="1" <?php echo $scriptingenabledchecked?>></td>
	</tr>   
	<tr>
		<td></td>
		<td>
		   <select name="scriptinglanguage"  style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
		      <option value="VBScript" <?php if ($scriptinglanguage == "VBScript") echo "selected"; ?>>VBScript</option>
		      <option value="JScript" <?php if ($scriptinglanguage == "JScript") echo "selected"; ?>>JScript</option>
		   </select>
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

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="scripts">
   <input type="hidden" name="action" value="checksyntax">
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
 
	<tr>
		<td>
		   <?php
		   if ($action == "checksyntax")
		      echo $syntax_result;
		   ?>
		</td>
	</tr>   

	<tr>
		<td colspan="1">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_CHECK_SYNTAX)?>">
		</td>
	</tr>		
	</table>
</form>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="scripts">
   <input type="hidden" name="action" value="reloadscripts">
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
 
	<tr>
		<td colspan="1">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_RELOAD_SCRIPTS)?>">
		</td>
	</tr>		
	</table>
</form>
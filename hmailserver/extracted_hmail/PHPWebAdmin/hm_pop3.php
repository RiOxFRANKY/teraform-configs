<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obSettings->MaxPOP3Connections= hmailGetVar("maxpop3connections",0);
	$obSettings->WelcomePOP3= hmailGetVar("welcomepop3",0);
	
	
}

$maxpop3connections = $obSettings->MaxPOP3Connections;     
$welcomepop3 = $obSettings->WelcomePOP3;     

?>

<h1><?php echo $obLanguage->String(STR_POP3)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="pop3">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td><?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?></td>
		<td><input type="textbox" name="maxpop3connections" value="<?php echo $maxpop3connections?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAXSIMELTANCONNECTIONS)?>"></td>
	</tr> 	
	<tr>
		<td><?php echo $obLanguage->String(STR_WELCOMEMESSAGE)?></td>
		<td><input type="textbox" name="welcomepop3" value="<?php echo $welcomepop3?>" size="50"></td>
	</tr> 	
 	
	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>
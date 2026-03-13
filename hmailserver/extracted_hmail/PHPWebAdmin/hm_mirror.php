<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();

$action	   = hmailGetVar("action","");

if($action == "save")
	$obSettings->MirrorEMailAddress= hmailGetVar("mirroremailaddress",0);

$mirroremailaddress = $obSettings->MirrorEMailAddress;      
?>

<h1><?php echo $obLanguage->String(STR_MIRROR)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="mirror">
   <input type="hidden" name="action" value="save">
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_MIRROREMAILADDRESS)?></td>
		<td width="70%"><input type="textbox" name="mirroremailaddress" value="<?php echo $mirroremailaddress?>"  checkallownull="true" checktype="email" checkmessage="<?php echo $obLanguage->String(STR_MIRROREMAILADDRESS)?>"></td>
	</tr>   

	<tr>
		<td colspan="2">  
		   <br/>
		   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
		</td>
	</tr>		
	</table>
</form>
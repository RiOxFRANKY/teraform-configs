<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // Domain admin but not for this domain.

$routeid	         = hmailGetVar("routeid",0);
$action	         = hmailGetVar("action","");

$obRoutes	= $obSettings->Routes();

$routetargetsmtpport  = 25;
$routenumberoftries  = 5;
$routemminutesbetweentry = 60;

$routedomainname = "";
$routetargetsmtphost= "";
$routetreatsecurityaslocal = false;
$routerequiresauth=0;
$routeauthusername="";
		     
if ($action == "edit")
{
   $obRoute = $obRoutes->ItemByDBID($routeid);

   $routedomainname = $obRoute->DomainName;
   $routetargetsmtphost = $obRoute->TargetSMTPHost;
   $routetargetsmtpport = $obRoute->TargetSMTPPort;
   $routetreatsecurityaslocal = $obRoute->TreatSecurityAsLocalDomain;
   
   $routenumberoftries = $obRoute->NumberOfTries;
   $routemminutesbetweentry = $obRoute->MinutesBetweenTry;
   $routerequiresauth = $obRoute->RelayerRequiresAuth;
   $routeauthusername = $obRoute->RelayerAuthUsername;
   
   
}

$routerequiresauthchecked = hmailCheckedIf1($routerequiresauth);


?>

<h1><?php echo $obLanguage->String(STR_ROUTE)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_route_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="routeid" value="<?php echo $routeid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
     	<tr>
   	      <td colspan="2">
   	         <b><?php echo $obLanguage->String(STR_GENERAL)?></b>
   	      </td>
   	</tr>
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_DOMAIN)?></td>
			<td width="70%">
   			<input type="text" name="routedomainname" value="<?php echo $routedomainname?>" size="30"  checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_DOMAIN)?>">
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_TARGET_SMTP)?></td>
			<td><input type="text" name="routetargetsmtphost" value="<?php echo $routetargetsmtphost?>" size="25" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_TARGET_SMTP)?>"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_TCPPORT)?></td>
			<td><input type="text" name="routetargetsmtpport" value="<?php echo $routetargetsmtpport?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_TCPPORT)?>"></td>
		</tr>
   	<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_DELIVERYOFEMAIL)?></b>
   	      </td>
   	</tr>
   	<tr>
   		<td><?php echo $obLanguage->String(STR_NUMBEROFRETRIES)?></td>
   		<td><input type="text" name="routenumberoftries" value="<?php echo $routenumberoftries?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_NUMBEROFRETRIES)?>"></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_MINUTESBETWEENRETRY)?></td>
   		<td><input type="text" name="routemminutesbetweentry" value="<?php echo $routemminutesbetweentry?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MINUTESBETWEENRETRY)?>"></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_SERVER_REQUIRES_AUTHENTICATION)?></td>
   		<td><input type="checkbox" name="accountactive" value="1" <?php echo $routerequiresauthchecked?>></td>
   	</tr>    	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_USERNAME)?></td>
   		<td><input type="text" name="routeauthusername" value="<?php echo $routeauthusername?>" size="30"></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_PASSWORD)?></td>
   		<td><input type="password" name="routeauthpassword" value="" size="20"></td>
   	</tr>    	
 		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

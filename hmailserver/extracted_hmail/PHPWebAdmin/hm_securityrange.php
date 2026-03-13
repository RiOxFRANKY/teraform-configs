<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp(); // The user is not server administrator

$securityrangeid	= hmailGetVar("securityrangeid",0);
$action	         	= hmailGetVar("action","");
	
$securityrangename="";
$securityrangepriority = 100;
$securityrangelowerip = "0.0.0.0";
$securityrangeupperip = "255.255.255.255";

$allowsmtpconnections = 0;
$allowpop3connections = 0;
$allowimapconnections = 0;

$allowlocaltolocal = 0;
$allowlocaltoremote = 0;
$allowremotetolocal = 0;
$allowremotetoremote = 0;
$enablespamprotection = 0;
$IsForwardingRelay = 0;

$requireauthtolocal = 0;
$requireauthtoremote = 0;
		     
if ($action == "edit")
{
   $obSecurityRange = $obBaseApp->Settings->SecurityRanges->ItemByDBID($securityrangeid);

   $securityrangename		= $obSecurityRange->Name;
   $securityrangepriority	= $obSecurityRange->Priority;
   $securityrangelowerip	= $obSecurityRange->LowerIP;
   $securityrangeupperip	= $obSecurityRange->UpperIP;
   
   $allowsmtpconnections	= $obSecurityRange->AllowSMTPConnections;
   $allowpop3connections	= $obSecurityRange->AllowPOP3Connections;
   $allowimapconnections	= $obSecurityRange->AllowIMAPConnections;
   
   $allowlocaltolocal		= $obSecurityRange->AllowDeliveryFromLocalToLocal;
   $allowlocaltoremote		= $obSecurityRange->AllowDeliveryFromLocalToRemote;
   $allowremotetolocal		= $obSecurityRange->AllowDeliveryFromRemoteToLocal;
   $allowremotetoremote		= $obSecurityRange->AllowDeliveryFromRemoteToRemote;
   
   $requireauthtolocal		= $obSecurityRange->RequireAuthForDeliveryToLocal;
   $requireauthtoremote		= $obSecurityRange->RequireAuthForDeliveryToRemote;
   
   $enablespamprotection	= $obSecurityRange->EnableSpamProtection;
   $IsForwardingRelay	   = $obSecurityRange->IsForwardingRelay;
}

$allowsmtpconnectionschecked	= hmailCheckedIf1($allowsmtpconnections);
$allowpop3connectionschecked	= hmailCheckedIf1($allowpop3connections);
$allowimapconnectionschecked	= hmailCheckedIf1($allowimapconnections);

$allowlocaltolocalchecked	= hmailCheckedIf1($allowlocaltolocal);
$allowlocaltoremotechecked	= hmailCheckedIf1($allowlocaltoremote);
$allowremotetolocalchecked	= hmailCheckedIf1($allowremotetolocal);
$allowremotetoremotechecked	= hmailCheckedIf1($allowremotetoremote);
   
$enablespamprotectionchecked	= hmailCheckedIf1($enablespamprotection);
$IsForwardingRelayChecked     = hmailCheckedIf1($IsForwardingRelay);

$requireauthtolocalchecked	= hmailCheckedIf1($requireauthtolocal);
$requireauthtoremotechecked	= hmailCheckedIf1($requireauthtoremote);
?>

<h1><?php echo $obLanguage->String(STR_IPRANGE)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_securityrange_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="securityrangeid" value="<?php echo $securityrangeid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
     	<tr>
   	      <td colspan="2">
   	         <b><?php echo $obLanguage->String(STR_GENERAL)?></b>
   	      </td>
   	</tr>
	
		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_NAME)?></td>
			<td width="70%">
   			<input type="text" name="securityrangename" value="<?php echo $securityrangename?>" size="30"  checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_NAME)?>">
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_PRIORITY)?></td>
			<td><input type="text" name="securityrangepriority" value="<?php echo $securityrangepriority?>" size="4" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_PRIORITY)?>"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_LOWERIP)?></td>
			<td><input type="text" name="securityrangelowerip" value="<?php echo $securityrangelowerip?>" size="25" checkallownull="false" checktype="ipaddress" checkmessage="<?php echo $obLanguage->String(STR_LOWERIP)?>"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_UPPERIP)?></td>
			<td><input type="text" name="securityrangeupperip" value="<?php echo $securityrangeupperip?>" size="25" checkallownull="false" checktype="ipaddress" checkmessage="<?php echo $obLanguage->String(STR_UPPERIP)?>"></td>
		</tr>		
   	<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_ALLOW_CONNECTIONS)?></b>
   	      </td>
   	</tr>
   	<tr>
   		<td><?php echo $obLanguage->String(STR_SMTP)?></td>
   		<td><input type="checkbox" name="allowsmtpconnections" value="1" <?php echo $allowsmtpconnectionschecked?>></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_POP3)?></td>
   		<td><input type="checkbox" name="allowpop3connections" value="1" <?php echo $allowpop3connectionschecked?>></td>
   	</tr> 
   	<tr>
   		<td><?php echo $obLanguage->String(STR_IMAP)?></td>
   		<td><input type="checkbox" name="allowimapconnections" value="1" <?php echo $allowimapconnectionschecked?>></td>
   	</tr>    
   	<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_ALLOW_DELIVERIES)?></b>
   	      </td>
   	</tr>   	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_FROM_LOCAL_TO_LOCAL)?></td>
   		<td><input type="checkbox" name="allowlocaltolocal" value="1" <?php echo $allowlocaltolocalchecked?>></td>
   	</tr>  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_FROM_LOCAL_TO_REMOTE)?></td>
   		<td><input type="checkbox" name="allowlocaltoremote" value="1" <?php echo $allowlocaltoremotechecked?>></td>
   	</tr>  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_FROM_REMOTE_TO_LOCAL)?></td>
   		<td><input type="checkbox" name="allowremotetolocal" value="1" <?php echo $allowremotetolocalchecked?>></td>
   	</tr>  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_FROM_REMOTE_TO_REMOTE)?></td>
   		<td><input type="checkbox" name="allowremotetoremote" value="1" <?php echo $allowremotetoremotechecked?>></td>
   	</tr>     	
   	<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_REQUIRE_AUTHENTICATION_FOR)?></b>
   	      </td>
   	</tr>      	  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_DELIVERIES_TO_LOCAL)?></td>
   		<td><input type="checkbox" name="requireauthtolocal" value="1" <?php echo $requireauthtolocalchecked?>></td>
   	</tr>  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_DELIVERIES_TO_REMOTE)?></td>
   		<td><input type="checkbox" name="requireauthtoremote" value="1" <?php echo $requireauthtoremotechecked?>></td>
   	</tr>    	 	   	  		   		   	
   	<tr>
   	      <td colspan="2">
   	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
   	         <br/>
   	         <b><?php echo $obLanguage->String(STR_OTHER)?></b>
   	      </td>
   	</tr>  
   	<tr>
   		<td><?php echo $obLanguage->String(STR_SPAMPROTECTION)?></td>
   		<td><input type="checkbox" name="enablespamprotection" value="1" <?php echo $enablespamprotectionchecked?>></td>
   	</tr>    
   	<tr>
   		<td><?php echo $obLanguage->String(STR_FORWARDING_RELAY)?></td>
   		<td><input type="checkbox" name="IsForwardingRelay" value="1" <?php echo $IsForwardingRelayChecked?>></td>
   	</tr>   		  	
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

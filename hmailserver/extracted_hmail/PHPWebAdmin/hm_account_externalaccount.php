<?php
$domainid	= hmailGetVar("domainid",0);
$accountid	= hmailGetVar("accountid",0);
$faid 		= hmailGetVar("faid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 0 && ($accountid != hmailGetAccountID() || $domainid != hmailGetDomainID()))
   hmailHackingAttemp();

if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
	hmailHackingAttemp(); // Domain admin but not for this domain.

$obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
$obAccount = $obDomain->Accounts->ItemByDBID($accountid);  

if ($action == "edit")
{
   $obFetchAccount = $obAccount->FetchAccounts->ItemByDBID($faid);
	
   $Enabled = $obFetchAccount->Enabled;
   $Name = $obFetchAccount->Name;
   $DaysToKeepMessages   = $obFetchAccount->DaysToKeepMessages;
   $MinutesBetweenFetch  = $obFetchAccount->MinutesBetweenFetch;
   $Port  				 = $obFetchAccount->Port;
   $ProcessMIMERecipients = $obFetchAccount->ProcessMIMERecipients;
   $ProcessMIMEDate       = $obFetchAccount->ProcessMIMEDate;
   $ServerAddress  		  = $obFetchAccount->ServerAddress;
   $ServerType  		  = $obFetchAccount->ServerType;
   $Username   			  = $obFetchAccount->Username;
}
else 
{
   $Enabled = 1;
   $Name = "";
   $DaysToKeepMessages = 0;
   $MinutesBetweenFetch = 30;
   $Port = 110;
   $ProcessMIMERecipients = 0;
   $ProcessMIMEDate = 0;
   $ServerAddress = "";
   $ServerType = 0;
   $Username = "";
   
}

$EnabledChecked = hmailCheckedIf1($Enabled);
$ProcessMIMERecipientsChecked = hmailCheckedIf1($ProcessMIMERecipients);
$ProcessMIMEDateChecked = hmailCheckedIf1($ProcessMIMEDate);

$DaysToKeepMessagesValue = 0;
if ($DaysToKeepMessages > 0)
	$DaysToKeepMessagesValue = $DaysToKeepMessages;
?>

<h1><?php echo $obLanguage->String(STR_EXTERNAL_ACCOUNT)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_account_externalaccount_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="faid" value="<?php echo $faid?>">
	<input type="hidden" name="domainid" value="<?php echo $domainid?>">
	<input type="hidden" name="accountid" value="<?php echo $accountid?>">
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td width="40%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td width="60%">
   			<?php
   			echo "<input type=\"checkbox\" name=\"Enabled\" value=\"1\" $EnabledChecked>";
   			?>				
         	</td>			
		</tr>
		<tr>
			<td colspan="2"><?php echo $obLanguage->String(STR_SERVER_INFORMATION)?></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_NAME)?></td>
			<td>
   				<input type="text" name="Name" value="<?php echo $Name?>" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_NAME)?>">
         	</td>			
		</tr>	
		<tr>
			<td><?php echo $obLanguage->String(STR_TYPE)?></td>
			<td>
   				<select name="Type"  style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
   					<option value="0" selected>POP3</option>
   				</select>
         	</td>			
		</tr>	
		<tr>
			<td colspan="2">
				<table width="350">
					<tr>
						<td><?php echo $obLanguage->String(STR_SERVER_ADDRESS)?></td>
						<td><?php echo $obLanguage->String(STR_TCPPORT)?></td>
					</tr>
					<tr>
						<td><input type="text" name="ServerAddress" size="25" value="<?php echo $ServerAddress?>" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_SERVER_ADDRESS)?>"></td>
						<td><input type="text" name="Port" size="25" value="<?php echo $Port?>"  checktype="number" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_TCPPORT)?>"></td>
					</tr>					
				</table>
			</td>
		</tr>	
		<tr>
			<td colspan="2">
				<table width="350">
					<tr>
						<td><?php echo $obLanguage->String(STR_USERNAME)?></td>
						<td><?php echo $obLanguage->String(STR_PASSWORD)?></td>
					</tr>
					<tr>
						<td><input type="text" name="Username" value="<?php echo $Username?>" size="25" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_USERNAME)?>"></td>
						<td><input type="password" name="Password" value=""  size="25"></td>
					</tr>					
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2"><?php echo $obLanguage->String(STR_SETTINGS)?></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_MINUTES_BETWEEN_DOWNLOAD)?></td>
			<td>
   				<input type="text" name="MinutesBetweenFetch" value="<?php echo $MinutesBetweenFetch?>" checktype="number" checkallownull="false" checkmessage="<?php echo $obLanguage->String(STR_MINUTES_BETWEEN_DOWNLOAD)?>">
         	</td>			
		</tr>			
		<tr>
			<td><?php echo $obLanguage->String(STR_DELIVER_TO_RECIPIENTS_IN_HEADERS)?></td>
			<td>
			   	<?php
   					echo "<input type=\"checkbox\" name=\"ProcessMIMERecipients\" value=\"1\" $ProcessMIMERecipientsChecked>";
   				?>				
         	</td>			
		</tr>	
		<tr>
			<td><?php echo $obLanguage->String(STR_RETRIEVE_DATE_FROM_RECEIVED_HEADER)?></td>
			<td>
			   	<?php
   					echo "<input type=\"checkbox\" name=\"ProcessMIMEDate\" value=\"1\" $ProcessMIMEDateChecked>";
   				?>				
         	</td>			
		</tr>			
		
		<tr>
			<td colspan="2">
				<table width="350">
					<tr>
						<td><input type="radio" name="DaysToKeepMessages" value="-1" <?php if ($DaysToKeepMessages == -1) echo "checked";?> ></td>
						<td><?php echo $obLanguage->String(STR_DELETE_MESSAGES_IMMEDIATELY)?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><input type="radio" name="DaysToKeepMessages" value="0" <?php if ($DaysToKeepMessages == 0) echo "checked";?> ></td>
						<td><?php echo $obLanguage->String(STR_DO_NOT_DELETE_MESSAGES)?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><input type="radio" name="DaysToKeepMessages" value=""  <?php if ($DaysToKeepMessages > 0) echo "checked";?>></td>
						<td><?php echo $obLanguage->String(STR_DELETE_MESSAGES_AFTER)?></td>
						<td><input type="text" name="DaysToKeepMessagesValue" value="<?php echo $DaysToKeepMessagesValue?>"> <?php echo $obLanguage->String(STR_DAYS)?></td>
					</tr>				
				</table>
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

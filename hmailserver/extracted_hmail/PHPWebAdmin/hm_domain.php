<?php

$domainid	= hmailGetVar("domainid",0);
$action	   = hmailGetVar("action","");

if (hmailGetAdminLevel() == 1 && ($domainid != hmailGetDomainID() || $action != "edit"))
	hmailHackingAttemp(); 

$admin_rights = (hmailGetAdminLevel()  === ADMIN_SERVER);

$domainname = "";
$domainactive = 1;
$domainpostmaster = "";
$domainmaxsize = 0;
$domainplusaddressingenabled = 0;
$domainplusaddressingcharacter = "+";
$domainantispamenablegreylisting = 1;
$domainmaxmessagesize = 0;

$SignatureEnabled = 0;
$SignatureHTML = "";
$SignaturePlainText = "";
$SignatureMethod = 1;

$AddSignaturesToLocalMail = 1;
$AddSignaturesToReplies = 0;

$MaxNumberOfAccounts = 0;
$MaxNumberOfAliases  = 0;
$MaxNumberOfDistributionLists = 0;
$MaxAccountSize      = 0;

$MaxNumberOfAccountsEnabled = 0;
$MaxNumberOfAliasesEnabled  = 0;
$MaxNumberOfDistributionListsEnabled = 0;

if ($action == "edit")
{
   $obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
   
   $domainname       = $obDomain->Name;
   $domainactive     = $obDomain->Active;
   $domainpostmaster = $obDomain->Postmaster;
   $domainmaxsize    = $obDomain->MaxSize;
   $domainmaxmessagesize    = $obDomain->MaxMessageSize;
   
   $domainplusaddressingenabled = $obDomain->PlusAddressingEnabled;
   $domainplusaddressingcharacter = $obDomain->PlusAddressingCharacter;
   $domainantispamenablegreylisting = $obDomain->AntiSpamEnableGreylisting;
   
   $SignatureEnabled   = $obDomain->SignatureEnabled;
   $SignatureHTML  	   = $obDomain->SignatureHTML;
   $SignaturePlainText = $obDomain->SignaturePlainText;
   $SignatureMethod    = $obDomain->SignatureMethod;
   
   $AddSignaturesToLocalMail = $obDomain->AddSignaturesToLocalMail;
   $AddSignaturesToReplies  = $obDomain->AddSignaturesToReplies;
   
   $MaxAccountSize      = $obDomain->MaxAccountSize;
   
   $MaxNumberOfAccounts = $obDomain->MaxNumberOfAccounts;
   $MaxNumberOfAliases  = $obDomain->MaxNumberOfAliases;
   $MaxNumberOfDistributionLists = $obDomain->MaxNumberOfDistributionLists;
   $MaxNumberOfAccountsEnabled = $obDomain->MaxNumberOfAccountsEnabled;
   $MaxNumberOfAliasesEnabled  = $obDomain->MaxNumberOfAliasesEnabled;
   $MaxNumberOfDistributionListsEnabled = $obDomain->MaxNumberOfDistributionListsEnabled;
   
}

$domainactivechecked = hmailCheckedIf1($domainactive);
$domainplusaddressingenabledchecked = hmailCheckedIf1($domainplusaddressingenabled);
$domainantispamenablegreylistingchecked = hmailCheckedIf1($domainantispamenablegreylisting);

$SignatureEnabledChecked = hmailCheckedIf1($SignatureEnabled);
$AddSignaturesToLocalMailChecked = hmailCheckedIf1($AddSignaturesToLocalMail);
$AddSignaturesToRepliesChecked   = hmailCheckedIf1($AddSignaturesToReplies);

$MaxNumberOfAccountsEnabledChecked          = hmailCheckedIf1($MaxNumberOfAccountsEnabled);
$MaxNumberOfAliasesEnabledChecked           = hmailCheckedIf1($MaxNumberOfAliasesEnabled);
$MaxNumberOfDistributionListsEnabledChecked = hmailCheckedIf1($MaxNumberOfDistributionListsEnabled);

?>

<h1><?php echo $obLanguage->String(STR_DOMAIN)?></h1>
<form action="index.php" method="post" onSubmit="return formCheck(this);">

	<input type="hidden" name="page" value="background_domain_save">
	<input type="hidden" name="action" value="<?php echo $action?>">
	<input type="hidden" name="domainid" value="<?php echo $obDomain->ID?>">
	
	<h2><?php echo $obLanguage->String(STR_GENERAL)?></h2>
	
	<table border="0" class="settingsborder" width="100%" cellpadding="5">

		<tr>
			<td width="30%"><?php echo $obLanguage->String(STR_NAME)?></td>
			<td width="70%">
   			<?php
   			$str_name = $obLanguage->String(STR_NAME);
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"domainname\" value=\"$domainname\" size=\"40\" checkallownull=\"false\" checkmessage=\"$str_name\">";
   			else
   				echo $domainname;
   			?>
         </td>			
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_CATCH_ALL)?></td>
			<td><input type="text" name="domainpostmaster" value="<?php echo $domainpostmaster?>" size="40"></td>
		</tr>
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td>
			<?php
			if ($admin_rights)
			   echo "<input type=\"checkbox\" name=\"domainactive\" value=\"1\" $domainactivechecked>";
			else
			{
				if ($domainactive == 1)
				   echo $obLanguage->String(STR_YES);
				else
				   echo $obLanguage->String(STR_NO);				
			}
			?>			
			</td>
		</tr>

   </table>
   <h2><?php echo $obLanguage->String(STR_ADVANCED)?></h2>
   <table border="0" class="settingsborder" width="100%" cellpadding="5">

     	<tr>
	      <td colspan="2">
	         <h3><?php echo $obLanguage->String(STR_PLUS_ADDRESSING)?></h3>
	      </td>
   	</tr>
   	   	
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td>
			<?php
		   echo "<input type=\"checkbox\" name=\"domainplusaddressingenabled\" value=\"1\" $domainplusaddressingenabledchecked>";
			?>			
			</td>
		</tr>
   	
		<tr>
			<td><?php echo $obLanguage->String(STR_CHARACTER)?></td>
			<td>
   		   <select name="domainplusaddressingcharacter" style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
   		      <option value="+" <?php if ($domainplusaddressingcharacter == "+") echo "selected";?> >+</option>
   		      <option value="-" <?php if ($domainplusaddressingcharacter == "-") echo "selected";?> >-</option>
   		      <option value="_" <?php if ($domainplusaddressingcharacter == "_") echo "selected";?> >_</option>
   		      <option value="%" <?php if ($domainplusaddressingcharacter == "%") echo "selected";?> >%</option>
   		   </select>
			</td>
		</tr>   	
   	
     	<tr>
	      <td colspan="2">
	         <h3><?php echo $obLanguage->String(STR_GREYLISTING)?></h3>
	      </td>
   	</tr>
   	   	
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td>
			   <input type="checkbox" name="domainantispamenablegreylisting" value="1" <?php echo $domainantispamenablegreylistingchecked?>>
			</td>
		</tr>
   	</table>
   	
   <h2><?php echo $obLanguage->String(STR_SIGNATURE)?></h2>
   <table border="0" class="settingsborder" width="100%" cellpadding="5">
		<tr>
			<td><?php echo $obLanguage->String(STR_ACTIVE)?></td>
			<td>
			<?php
		   echo "<input type=\"checkbox\" name=\"SignatureEnabled\" value=\"1\" $SignatureEnabledChecked>";
			?>			
			</td>
		</tr>
   	<tr>
   		<td><?php echo $obLanguage->String(STR_ADD_SIGNATURES_TO_LOCAL_EMAIL)?></td>
   		<td><input type="checkbox" name="AddSignaturesToLocalMail" value="1" <?php echo $AddSignaturesToLocalMailChecked?>></td>
   	</tr>   	
   	<tr>
   		<td><?php echo $obLanguage->String(STR_ADD_SIGNATURES_TO_REPLIES)?></td>
   		<td><input type="checkbox" name="AddSignaturesToReplies" value="1" <?php echo $AddSignaturesToRepliesChecked?>></td>
   	</tr>   	   	
   	
		<tr>
			<td>&nbsp;</td>
			<td>
   		   <select name="SignatureMethod" style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
   		      <option value="1" <?php if ($SignatureMethod == "1") echo "selected";?> ><?php echo $obLanguage->String(STR_USE_SIGNATURE_IF_NONE_SPECIFIED)?></option>
   		      <option value="2" <?php if ($SignatureMethod == "2") echo "selected";?> ><?php echo $obLanguage->String(STR_OVERWRITE_ACCOUNT_SIGNATURE)?></option>
   		      <option value="3" <?php if ($SignatureMethod == "3") echo "selected";?> ><?php echo $obLanguage->String(STR_APPEND_TO_ACCOUNT_SIGNATURE)?></option>
   		   </select>
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
		
   	</table>   	
   	
      <h2><?php echo $obLanguage->String(STR_LIMITS)?></h2>
      <table border="0" class="settingsborder" width="100%" cellpadding="5">
   		<tr>
   			<td width="40%"><?php echo $obLanguage->String(STR_MAXSIZEMB)?></td>
   			<td width="60%">
   			<?php
   			$str_maxsizemb = $obLanguage->String(STR_MAXSIZEMB);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"domainmaxsize\" value=\"$domainmaxsize\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_maxsizemb\">";
   			else
   				echo $domainmaxsize;
   			?>			
   			</td>
   		</tr>
   		<tr>
   			<td><?php echo $obLanguage->String(STR_MAX_MESSAGE_SIZE)?></td>
   			<td>
   			<?php
   			$str_warning = $obLanguage->String(STR_MAX_MESSAGE_SIZE);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"domainmaxmessagesize\" value=\"$domainmaxmessagesize\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_warning\">";
   			else
   				echo $domainmaxsize;
   			?>			
   			</td>
   		</tr>		
   		</tr>	   
   		<tr>
   			<td><?php echo $obLanguage->String(STR_MAX_SIZE_OF_ACCOUNTS)?></td>
   			<td>
   			
   			<?php
   			$str_warning = $obLanguage->String(STR_MAX_SIZE_OF_ACCOUNTS);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"MaxAccountSize\" value=\"$MaxAccountSize\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_warning\">";
   			else
   				echo $MaxAccountSize;
   			?>			
   			</td>
   		</tr>	     		
   		<tr>
   			<td><?php echo $obLanguage->String(STR_MAX_NUMBER_OF_ACCOUNTS)?></td>
   			<td>
   			<?php

   			if ($admin_rights)
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfAccountsEnabled\" value=\"1\" $MaxNumberOfAccountsEnabledChecked>";
   			else
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfAccountsEnabled\" value=\"1\" readonly disabled $MaxNumberOfAccountsEnabledChecked>";
   			
   			$str_warning = $obLanguage->String(STR_MAX_NUMBER_OF_ACCOUNTS);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"MaxNumberOfAccounts\" value=\"$MaxNumberOfAccounts\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_warning\">";
   			else
   				echo $MaxNumberOfAccounts;
   			?>			
   			</td>
   		</tr>	  
   		<tr>
   			<td><?php echo $obLanguage->String(STR_MAX_NUMBER_OF_ALIASES)?></td>
   			<td>
   			<?php
   			
   			if ($admin_rights)
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfAliasesEnabled\" value=\"1\" $MaxNumberOfAliasesEnabledChecked>";
   			else
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfAliasesEnabled\" value=\"1\" readonly disabled $MaxNumberOfAliasesEnabledChecked>";

   			   
   			$str_warning = $obLanguage->String(STR_MAX_NUMBER_OF_ALIASES);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"MaxNumberOfAliases\" value=\"$MaxNumberOfAliases\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_warning\">";
   			else
   				echo $MaxNumberOfAliases;
   			?>			
   			</td>
   		</tr>	   
   		<tr>
   			<td><?php echo $obLanguage->String(STR_MAX_NUMBER_OF_DISTRIBUTIONLISTS)?></td>
   			<td>
   			<?php
   			if ($admin_rights)
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfDistributionListsEnabled\" value=\"1\" $MaxNumberOfDistributionListsEnabledChecked>";
   			else
   			   echo "<input type=\"checkbox\" name=\"MaxNumberOfDistributionListsEnabled\" value=\"1\" readonly disabled $MaxNumberOfDistributionListsEnabledChecked>";

   			
   			$str_warning = $obLanguage->String(STR_MAX_NUMBER_OF_DISTRIBUTIONLISTS);
   			
   			if ($admin_rights)
   			   echo "<input type=\"text\" name=\"MaxNumberOfDistributionLists\" value=\"$MaxNumberOfDistributionLists\" size=\"8\" checkallownull=\"false\" checkmessage=\"$str_warning\">";
   			else
   				echo $MaxNumberOfDistributionLists;
   			?>			
   			</td>
  		 		  		 		
   	</table>
   	
   	
   	<table>
		<tr>
			<td colspan="2">  
			   <br/>
			   <input type="submit" value="<?php echo $obLanguage->String(STR_SAVE)?>">
			</td>
		</tr>
	</table>
</form>

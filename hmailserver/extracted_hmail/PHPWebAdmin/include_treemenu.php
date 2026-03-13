<?php
// Build tree menu
$dtitem=0;
$dtree = "d.add(" . $dtitem++ .",-1,'" . GetStringForJavaScript(STR_WELCOME) . "','index.php','');\r\n";
$username = $_SESSION['session_username'];

if (hmailGetAdminLevel() == 0)
{
   // User 	
   $domainname = hmailGetUserDomainName($username);
   
   $obDomain = $obBaseApp->Domains->ItemByName($domainname);
   $obAccounts = $obDomain->Accounts;
   
   $obAccount	= $obAccounts->ItemByAddress($username);
   
   $accountaddress = $obAccount->Address;
   $accountaddress = str_replace("'", "\'", $accountaddress);
   
   $url = htmlentities("index.php?page=account&action=edit&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID);
   $di = $dtitem++;
   
   $dtree .= "d.add($di,0,'" . $accountaddress . "','$url','','','" . "images/hm_kuser.gif','" . "images/hm_kuser.gif');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_AUTOREPLY) . "','index.php?page=account_autoreply&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID. "');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_FORWARDING) . "','index.php?page=account_forward&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID. "');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_SIGNATURE) . "','index.php?page=account_signature&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID. "');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_EXTERNAL_ACCOUNTS) . "','index.php?page=account_externalaccounts&accountid=" . $obAccount->ID . "&domainid=" . $obDomain->ID. "');\r\n";		
}


if (hmailGetAdminLevel() == 1)
{
   // Domain
   $dtree .= "d.add(" . $dtitem++ .",0,'" . GetStringForJavaScript(STR_DOMAINS) . "','','','','" . "images/hm_konqueror.gif','" . "images/hm_konqueror.gif');\r\n";
   
   $domainname = hmailGetUserDomainName($username);
   
   $obDomain = $obBaseApp->Domains->ItemByName($domainname);
   
   $domain_root = $dtitem++;
   
   GetStringForDomain($obDomain,1);
}
	
if (hmailGetAdminLevel() == 2)
{
   $obSettings	= $obBaseApp->Settings();
   
   // Server
   $dtree .= "d.add(" . $dtitem++ . ",0,'" . GetStringForJavaScript(STR_STATUS) . "','index.php?page=status','','','" . "images/hm_rightarrow.gif');\r\n";
   
   // List all domains
   $obDomains	= $obBaseApp->Domains();
   $DomainCount = $obDomains->Count();
   
   $dtree .= "d.add(" . $dtitem++ .",0,'" . GetStringForJavaScript(STR_DOMAINS) . " ($DomainCount)','index.php?page=domains','','','" . "images/hm_konqueror.gif','" . "images/hm_konqueror.gif');\r\n";
   	
   for ($i = 1; $i <= $DomainCount; $i++)
   {
   	$obDomain = $obBaseApp->Domains[$i-1];
   	$domain_root = $dtitem++;
   	GetStringForDomain($obDomain,2);
   }
   
   $settings_root = $dtitem++;
   $dtree .= "d.add(" . $settings_root . ",0,'" . GetStringForJavaScript(STR_SETTINGS) . "','','','','" . "images/hm_advancedsettings.gif','" . "images/hm_advancedsettings.gif');\r\n";
   
   $settings_protocols_root = $dtitem++;
   
   $dtree .= "d.add(" . $settings_protocols_root . ",$settings_root,'" . GetStringForJavaScript(STR_PROTOCOLS) . "','','','','" . "images/hm_network_local.gif','" . "images/hm_network_local.gif');\r\n";
   
   $settings_smtp_root = $dtitem++;
   $dtree .= "d.add(" . $settings_smtp_root . ",$settings_protocols_root,'" . GetStringForJavaScript(STR_SMTP) . "','index.php?page=smtp','','','" . "images/hm_socket.gif','" . "images/hm_socket.gif');\r\n";
   
   $dtree .= "d.add(" . $dtitem++ . ",$settings_smtp_root,'" . GetStringForJavaScript(STR_ANTIVIRUS) . "','index.php?page=smtp_antivirus','','','" . "images/hm_virus.gif','" . "images/hm_virus');\r\n";
   
   $settings_spamprotection_root = $dtitem++;
   $dtree .= "d.add(" . $settings_spamprotection_root . ",$settings_smtp_root,'" . GetStringForJavaScript(STR_SPAMPROTECTION) . "','index.php?page=smtp_antispam','','','" . "images/hm_player_stop_blue.gif','" . "images/hm_player_stop_blue.gif');\r\n";
   
   
   $dtree .= "d.add(" . $dtitem++ . ",$settings_spamprotection_root,'" . GetStringForJavaScript(STR_WHITELISTING) . "','index.php?page=whitelistaddresses','','','" . "images/hm_player_stop_blue.gif','" . "images/hm_player_stop_blue.gif');\r\n";
   
   $settings_smtp_route	= $dtitem++;
   
   $obRoutes	= $obSettings->Routes();
   $Count = $obRoutes->Count();
   $dtree .= "d.add(" . $settings_smtp_route . ",$settings_smtp_root,'" . GetStringForJavaScript(STR_ROUTES) . " (" . $Count . ")','index.php?page=routes','','','" . "images/hm_finish_not.gif','" . "images/hm_finish_not.gif');\r\n";
   
   for ($i = 0; $i < $Count; $i++)
   {
   	$obRoute = $obRoutes->Item($i);
   	$di = $dtitem++;
   	$dtree .= "d.add($di,$settings_smtp_route,'" . $obRoute->DomainName . "','index.php?page=route&action=edit&routeid=" . $obRoute->ID . "','','','" . "images/hm_finish.gif','" . "images/hm_finish.gif');\r\n";
   	$dsub = $dtitem++;
   	$dtree .= "d.add($dsub,$di,'" . GetStringForJavaScript(STR_ADDRESSES) . "','index.php?page=route_addresses&routeid=" . $obRoute->ID . "');\r\n";
   }
   
   $dtree .= "d.add(" . $dtitem++ . ",$settings_protocols_root,'" . GetStringForJavaScript(STR_POP3) . "','index.php?page=pop3','','','" . "images/hm_socket.gif','" . "images/hm_socket.gif');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$settings_protocols_root,'" . GetStringForJavaScript(STR_IMAP) . "','index.php?page=imap','','','" . "images/hm_socket.gif','" . "images/hm_socket.gif');\r\n";
   
   $dtree .= "d.add(" . $dtitem++ . ",$settings_root,'" . GetStringForJavaScript(STR_BACKUP) . "','index.php?page=backup','','','" . "images/hm_script.gif','" . "images/hm_script.gif');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$settings_root,'" . GetStringForJavaScript(STR_LOGGING) . "','index.php?page=logging','','','" . "images/hm_document.gif','" . "images/hm_document.gif');\r\n";
   
   $dtree .= "d.add(" . $dtitem++ . ",$settings_root,'" . GetStringForJavaScript(STR_TCPIP_PORTS) . "','index.php?page=tcpipports','','','" . "images/hm_gohome.gif','" . "images/hm_gohome.gif');\r\n";
   
   $obSecurityRanges	= $obSettings->SecurityRanges();
   $obSecurityRanges->Refresh();
   $Count = $obSecurityRanges->Count();
   
   
   $advanced_root = $dtitem++;
   $dtree .= "d.add(" . $advanced_root . ",$settings_root,'" . GetStringForJavaScript(STR_ADVANCED) . "','','','','" . "images/hm_konsole3.gif','" . "images/hm_konsole3.gif');\r\n";
   
   
   $dtree .= "d.add(" . $dtitem++ . ",$advanced_root,'" . GetStringForJavaScript(STR_MULTIHOMING) . "','index.php?page=multihoming','','','" . "images/hm_gohome.gif','" . "images/hm_gohome.gif');\r\n";
   
   $settings_ipranges_root = $dtitem++;
   $dtree .= "d.add(" . $settings_ipranges_root . ",$advanced_root,'" . GetStringForJavaScript(STR_IPRANGES) . " ($Count)','index.php?page=securityranges','','','" . "images/hm_lock2.gif','" . "images/hm_lock2.gif');\r\n";
   
   for ($j = 0; $j < $Count; $j++)
   {
   	$obSecurityRange = $obSecurityRanges->Item($j);
   
   
   	$di = $dtitem++;
   	$dtree .= "d.add($di,$settings_ipranges_root,'" . HMEscape($obSecurityRange->Name) . "','index.php?page=securityrange&action=edit&securityrangeid=" . $obSecurityRange->ID . "','','','" . "images/hm_document.gif','" . "images/hm_document.gif');\r\n";
   }
    
   $dtree .= "d.add(" . $dtitem++ . ",$advanced_root,'" . GetStringForJavaScript(STR_MIRROR) . "','index.php?page=mirror','','','" . "images/hm_email.gif','" . "images/hm_email.gif');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$advanced_root,'" . GetStringForJavaScript(STR_PERFORMANCE) . "','index.php?page=performance','','','" . "images/hm_2rightarrow.gif','" . "images/hm_2rightarrow.gif');\r\n";
   $dtree .= "d.add(" . $dtitem++ . ",$advanced_root,'" . GetStringForJavaScript(STR_SCRIPT) . "','index.php?page=scripts','','','" . "images/hm_script.gif','" . "images/hm_script.gif');\r\n";
   

}

$dtree .= "d.add(" . $dtitem++ .",-1,'" . GetStringForJavaScript(STR_LOGOUT) . "','logout.php','" . "" ."');\r\n";

$dtree .= "document.write(d);";

function GetStringForDomain($obDomain, $parentid)
{
   global $dtree, $dtitem, $domain_root;
   
   $current_domainid = hmailGetVar("domainid",0);
   $current_accountid = hmailGetVar("accountid",0);
   
   $dtree .= "d.add($domain_root,$parentid,'" . $obDomain->Name . "','index.php?page=domain&action=edit&domainid=" . $obDomain->ID . "','','','" . "images/hm_home.gif','" . "images/hm_home.gif');\r\n";
   
   if ($current_domainid != $obDomain->ID && hmailGetAdminLevel() == ADMIN_SERVER)
   {
      // If the user is logged on as a system administrator, only show accounts
      // for the currently selected domain.
      return;
   }
   
   $obAccounts 	= $obDomain->Accounts();
   $AccountsCount	= $obAccounts->Count();
   $accounts_root = $dtitem++;
   $dtree .= "d.add($accounts_root,$domain_root,'" . GetStringForJavaScript(STR_ACCOUNTS) . " ($AccountsCount)','index.php?page=accounts&domainid=" . $obDomain->ID . "','','','" . "images/hm_kcmsystem.gif','" . "images/hm_kcmsystem.gif');\r\n";
   for ($j = 0; $j < $AccountsCount; $j++)
   {
      $obAccount	= $obAccounts->Item($j);
      
      $accountaddress = $obAccount->Address;
      $accountaddress = str_replace("'", "\'", $accountaddress);
      
      $accountid = $obAccount->ID;
      
      $di = $dtitem++;
      $url = htmlentities("index.php?page=account&action=edit&accountid=" . $accountid . "&domainid=" . $obDomain->ID);
      $dtree .= "d.add($di,$accounts_root,'" . $accountaddress . "','$url','','','" . "images/hm_kuser.gif','" . "images/hm_kuser.gif');\r\n";
      
      // Only show sub-nodes for the currently selected account.
      if ($current_accountid == $accountid)
      {
         $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_AUTOREPLY) . "','index.php?page=account_autoreply&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
         $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_ACTIVEDIRECTORY) . "','index.php?page=account_activedirectory&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
         $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_FORWARDING) . "','index.php?page=account_forward&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
         $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_SIGNATURE) . "','index.php?page=account_signature&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
         $dtree .= "d.add(" . $dtitem++ . ",$di,'" . GetStringForJavaScript(STR_EXTERNAL_ACCOUNTS) . "','index.php?page=account_externalaccounts&accountid=" . $accountid . "&domainid=" . $obDomain->ID. "');\r\n";
      }
   }
   
   $obAliases		= $obDomain->Aliases();
   $AliasesCount	= $obAliases->Count();
   $aliases_root	= $dtitem++;
   $dtree .= "d.add($aliases_root,$domain_root,'" . GetStringForJavaScript(STR_ALIASES) . " ($AliasesCount)','index.php?page=aliases&domainid=" . $obDomain->ID . "','','','" . "images/hm_kcmsystem.gif','" . "images/hm_kcmsystem.gif');\r\n";
   
   for ($j = 0; $j < $AliasesCount; $j++)
   {
      $obAlias	= $obAliases->Item($j);
      
      $aliasname = $obAlias->Name;
      $aliasname = str_replace("'", "\'", $aliasname);
      
      $di = $dtitem++;
      $dtree .= "d.add($di,$aliases_root,'" . $aliasname . "','index.php?page=alias&action=edit&aliasid=" . $obAlias->ID . "&domainid=" . $obDomain->ID  . "','','','" . "images/hm_2rightarrow.gif','" . "images/hm_2rightarrow.gif');\r\n";
   }
   
   $obDistributionLists	= $obDomain->DistributionLists();
   $DListCount				= $obDistributionLists->Count();
   $dlist_root				= $dtitem++;
   $dtree .= "d.add($dlist_root,$domain_root,'" . GetStringForJavaScript(STR_DISTRIBUTIONLISTS) . " ($DListCount)','index.php?page=distributionlists&domainid=" . $obDomain->ID . "','','','" . "images/hm_kcmsystem.gif','" . "images/hm_kcmsystem.gif');\r\n";
   
   for ($j = 0; $j < $DListCount; $j++)
   {
      $obDistributionList	= $obDistributionLists->Item($j);
      $di = $dtitem++;
      $dtree .= "d.add($di,$dlist_root,'" . $obDistributionList->Address .  "','index.php?page=distributionlist&action=edit&distributionlistid=" . $obDistributionList->ID . "&domainid=" . $obDomain->ID . "','','','" . "images/hm_fork.gif','" . "images/hm_fork.gif');\r\n";
      $dtree .= "d.add(" . $dtitem++ .",$di,'" . GetStringForJavaScript(STR_MEMBERS) . " (" . $obDistributionList->Recipients->Count() . ")','index.php?page=distributionlist_recipients&distributionlistid=" . $obDistributionList->ID . "&domainid=" . $obDomain->ID. "');\r\n";
   }		
   

}

?>
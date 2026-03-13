<?php
   
   $domainid	= hmailGetVar("domainid",0);
   $accountid	= hmailGetVar("accountid",0);
   $action	   = hmailGetVar("action","");
   
   $obDomain	= $obBaseApp->Domains->ItemByDBID($domainid);
   
   if (hmailGetAdminLevel() == 0 && ($accountid != hmailGetAccountID() || $action != "edit"))
      hmailHackingAttemp();
   
   if (hmailGetAdminLevel() == 1 && $domainid != hmailGetDomainID())
   	hmailHackingAttemp(); // Domain admin but not for this domain.
   	
   $accountpassword  = hmailGetVar("accountpassword","");
   $accountmaxsize   = hmailGetVar("accountmaxsize","0");
   $accountaddress   = hmailGetVar("accountaddress","") . "@". $obDomain->Name;
   $accountactive    = hmailGetVar("accountactive","0");
   $accountadminlevel  = hmailGetVar("accountadminlevel","0");

   if ($action == "add")
   {
      $result = IsAddAllowed($obDomain);
      
      if ($result > 0)
      {
         header("Location: index.php?page=account&action=$action&domainid=$domainid&accountid=$accountid&error_message=$result");  
         exit();        
      } 
      
   }
   
   if ($action == "edit")
      $obAccount = $obDomain->Accounts->ItemByDBID($accountid);  
   elseif ($action == "add")
      $obAccount = $obDomain->Accounts->Add();  
   elseif ($action == "delete")
   {
      $obAccount = $obDomain->Accounts->DeleteByDBID($accountid);  
      header("Location: index.php?page=accounts&domainid=$domainid");
      exit();
   }
   
   if (hmailGetAdminLevel() != ADMIN_USER)
   {
      $result = CheckAccountSize($obDomain, $obAccount, $accountmaxsize);
      
      if ($result > 0)
      {
         header("Location: index.php?page=account&action=$action&domainid=$domainid&accountid=$accountid&error_message=$result");  
         exit();        
      } 
   }
  
   // If this is the current user, we need to update the session password.
   if ($action == "edit" &&
       $accountid == hmailGetAccountID())
   {
      if ($accountpassword != "")
         $_SESSION['session_password'] = $accountpassword;  
   }
   
   if ($accountpassword != "")
      $obAccount->Password = "$accountpassword";
   
   if (hmailGetAdminLevel() != 0)
   {
      $accountmaxsize = str_replace(".", ",", $accountmaxsize);

      // Save other properties
      $obAccount->Address = $accountaddress;
      $obAccount->MaxSize = $accountmaxsize;
      $obAccount->Active  = $accountactive;
      
      if (hmailGetAdminLevel() == 1)
      {
         // The web user is domain administrator. Don't allow him
         // to change the user to server admin, unless he already
         // is this.
         
         if ($accountadminlevel == 0 || $accountadminlevel == 1)
         {
            $obAccount->AdminLevel = $accountadminlevel;
         }
      }
      else if (hmailGetAdminLevel() == 2)
      {
         // The web user is server administrator. Allow any change
         $obAccount->AdminLevel = $accountadminlevel;
      }
   }
   
   
   $obAccount->Save();
   $accountid = $obAccount->ID;
   
   header("Location: index.php?page=account&action=edit&domainid=$domainid&accountid=$accountid");
   
   function CheckAccountSize($obDomain, $obAccount, $accountmaxsize )
   {
      // Check that the account size fits within the domain max size.
      if ($obDomain->MaxSize() > 0)
      {
         // A max size has been specified. Check that an account
         // size has been specified.
         if ($accountmaxsize == 0)
         {
            // A domain max size has been specified, but no account max size
            // Can't do this. Forward user back to account page with 
            // an error message.
            return STR_THIS_DOMAIN_HAS_A_MAX_SIZE_MUST_SET_ACCOUNT_SIZE;
         }
         
         // Check that the account size fits...
         if (isset($obAccount))
         {
            if ($obDomain->AllocatedSize - $obAccount->MaxSize + $accountmaxsize > $obDomain->MaxSize)
               return STR_SPECIFIED_ACCOUNT_MAX_SIZE_TO_BIG;
         }
         else
         {
            if ($obDomain->AllocatedSize + $accountmaxsize > $obDomain->MaxSize())
               return STR_SPECIFIED_ACCOUNT_MAX_SIZE_TO_BIG;
         }
         
      }      
      
      if ($obDomain->MaxAccountSize() > 0)
      {
         if ($accountmaxsize == 0)
            return STR_SPECIFIED_ACCOUNT_MAX_SIZE_TO_BIG;
         
         if ($accountmaxsize > $obDomain->MaxAccountSize())
            return STR_SPECIFIED_ACCOUNT_MAX_SIZE_TO_BIG;
      }
      
      return 0;
   }
   
   function IsAddAllowed($obDomain)
   {
      if (!$obDomain->MaxNumberOfAccountsEnabled)
         return 0;
      
      if ($obDomain->Accounts->Count >= $obDomain->MaxNumberOfAccounts)
         return STR_ACCOUNT_COULD_NOT_BE_ADDED_MAX_REACHED;
        
      return 0;
   }
?>


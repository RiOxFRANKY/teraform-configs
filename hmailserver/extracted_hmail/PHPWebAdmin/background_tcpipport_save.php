<?php

   if (hmailGetAdminLevel() != 2)
      hmailHackingAttemp(); // Server admin required

   $tcpipportid 	= hmailGetVar("tcpipportid",0);
   $protocol	= hmailGetVar("protocol",0);
   $portnumber	= hmailGetVar("portnumber",0);
   $action	   = hmailGetVar("action","");
   
   $obSettings   = $obBaseApp->Settings();
   $obTCPIPPorts  = $obSettings->TCPIPPorts;

   if ($action == "edit")
      $obTCPIPPort = $obTCPIPPorts->ItemByDBID($tcpipportid);
   elseif ($action == "add")
      $obTCPIPPort = $obTCPIPPorts->Add();
   elseif ($action == "delete")
   {
   	  $obTCPIPPorts->DeleteByDBID($tcpipportid);
      header("Location: index.php?page=tcpipports");
      exit();
   }

   $obTCPIPPort->Protocol = $protocol;
   $obTCPIPPort->PortNumber = $portnumber;
   $obTCPIPPort->Save();
   
   $tcpipportid = $obTCPIPPort->ID;
   
   header("Location: index.php?page=tcpipport&action=edit&tcpipportid=$tcpipportid");

?>


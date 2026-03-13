<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();
	
$obStatus      = $obBaseApp->Status();
$serverstate	= $obBaseApp->ServerState();
$action  		= hmailGetVar("action","");

$statusstarttime = $obStatus->StartTime();
$statusprocessedmessages = $obStatus->ProcessedMessages();
$statusmessageswithvirus = $obStatus->RemovedViruses();
$statusmessageswithspam = $obStatus->RemovedSpamMessages();

if ($action == "control")
{
   $controlaction = hmailGetVar("controlaction","");
   
   if ($controlaction == "1")
      $obBaseApp->Start();
   else if ($controlaction == "0")
      $obBaseApp->Stop();
   
}

switch($serverstate)
{
	case 1:
		$state = $obLanguage->String(STR_STOPPED);
		break;
	case 2:
	   $state = $obLanguage->String(STR_STARTING);
		break;
	case 3:
	   $state = $obLanguage->String(STR_RUNNING);
		break;
	case 4:
	   $state = $obLanguage->String(STR_STOPPING);
		break;
	default:
	   $state = "Unknown";;
		break;
}

switch($serverstate)
{
	case 1:
	case 4:
		$controlaction = 1;
		$controlbutton = $obLanguage->String(STR_START);
		break;
	case 2:
	case 3:
	   $controlaction = 0;
	   $controlbutton = $obLanguage->String(STR_STOP);
		break;
	default:
	   $state = "Unknown";
		break;
}
?>
<h1><?php echo $obLanguage->String(STR_SERVER)?></h1>

<table border="0" class="settingsborder" width="100%" cellpadding="5">
	<tr>
		<td width="30%"><?php echo $obLanguage->String(STR_CURRENT_STATUS)?></td>
		<td><?php echo $state?></td>
   </tr>
   <form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="status">
   <input type="hidden" name="action" value="control">
	<tr>
		<td><?php echo $obLanguage->String(STR_ACTION)?></td>
		<td>
	      <input type="hidden" name="controlaction" value="<?php echo $controlaction?>">
	      <input type="submit" value="<?php echo $controlbutton?>">
		</td>
   </tr> 
   </form>  
	<tr>
	      <td colspan="2">
	         <hr noshade style="height: 1px; border: 1px solid #eeeeee;">
	         <br/>
	         <b><?php echo $obLanguage->String(STR_STATUS)?></b>
	      </td>
	</tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_SERVER_UP_SINCE)?></td>
		<td><?php echo $statusstarttime?></td>
   </tr>   
	<tr>
		<td><?php echo $obLanguage->String(STR_PROCESSED_MESSAGES)?></td>
		<td><?php echo $statusprocessedmessages?></td>
   </tr>    
	<tr>
		<td><?php echo $obLanguage->String(STR_EMAIL_CONTAINING_VIRUS)?></td>
		<td><?php echo $statusmessageswithvirus?></td>
   </tr>    
	<tr>
		<td><?php echo $obLanguage->String(STR_EMAIL_CONTAINING_SPAM)?></td>
		<td><?php echo $statusmessageswithspam?></td>
   </tr>    


</table>

       
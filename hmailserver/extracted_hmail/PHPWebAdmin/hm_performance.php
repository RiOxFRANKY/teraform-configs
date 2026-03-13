<?php
if (hmailGetAdminLevel() != 2)
	hmailHackingAttemp();

$obSettings	= $obBaseApp->Settings();
$obCache    = $obSettings->Cache();

$action	   = hmailGetVar("action","");

if($action == "save")
{
	$obCache->Enabled		            = hmailGetVar("cacheenabled",0);
	$obCache->DomainCacheTTL         = hmailGetVar("cachedomainttl",0); 
	$obCache->AccountCacheTTL		   = hmailGetVar("cacheaccountttl",0);
	
   $obCache->AliasCacheTTL            = hmailGetVar("cachealiasttl",0);
   $obCache->DistributionListCacheTTL = hmailGetVar("cachedistributionlistttl",0);

	
	$obSettings->TCPIPThreads        = hmailGetVar("tcpipthreads", 0);
	$obSettings->MaxDeliveryThreads  = hmailGetVar("maxdeliverythreads", 0);
	$obSettings->WorkerThreadPriority = hmailGetVar("workerthreadpriority", 0);
	
}

$cacheenabledchecked = hmailCheckedIf1($obCache->Enabled);
    
$cachedomainttl = $obCache->DomainCacheTTL;
$cacheaccountttl = $obCache->AccountCacheTTL;
$cachedomainhitrate = $obCache->DomainHitRate;
$cacheaccounthitrate = $obCache->AccountHitRate;
$cachealiashitrate = $obCache->AliasHitRate;
$cachealiasttl     = $obCache->AliasCacheTTL;
$cachedistributionlisthitrate = $obCache->DistributionListHitRate;
$cachedistributionlistttl = $obCache->DistributionListCacheTTL;


$tcpipthreads           = $obSettings->TCPIPThreads;
$maxdeliverythreads     = $obSettings->MaxDeliveryThreads;
$workerthreadpriority   = $obSettings->WorkerThreadPriority;

?>

<h1><?php echo $obLanguage->String(STR_PERFORMANCE)?></h1>

<form action="index.php" method="post" onSubmit="return formCheck(this);">
   <input type="hidden" name="page" value="performance">
   <input type="hidden" name="action" value="save">
   
   <h2><?php echo $obLanguage->String(STR_CACHE)?></h2>
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td width="30%"><?php echo $obLanguage->String(STR_ACTIVE)?></td>
   		<td width="70%" colspan="2"><input type="checkbox" name="cacheenabled" value="1" <?php echo $cacheenabledchecked?>></td>
   	</tr>   
   	<tr>
   		<td><i><?php echo $obLanguage->String(STR_TYPE)?></i></td>
   		<td><i><?php echo $obLanguage->String(STR_TIME_TO_LIVE)?></i></td>
   		<td><i><?php echo $obLanguage->String(STR_HITRATE)?></i></td>
   	</tr>   
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_DOMAIN)?></td>
   		<td><input type="text" name="cachedomainttl" value="<?php echo $cachedomainttl?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DOMAIN)?>"></td>
   		<td><?php echo $cachedomainhitrate?></td>
   	</tr>  	
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_ACCOUNT)?></td>
   		<td><input type="text" name="cacheaccountttl" value="<?php echo $cacheaccountttl?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_ACCOUNT)?>">
   		<td><?php echo $cacheaccounthitrate?></td>
   		</td>
   	</tr>  	
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_ALIAS)?></td>
   		<td><input type="text" name="cachealiasttl" value="<?php echo $cachealiasttl?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_ALIAS)?>"></td>
   		<td><?php echo $cachealiashitrate?></td>
   	</tr>  	
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_DISTRIBUTIONLIST)?></td>
   		<td><input type="text" name="cachedistributionlistttl" value="<?php echo $cachedistributionlistttl?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DISTRIBUTIONLIST)?>">
   		<td><?php echo $cachedistributionlisthitrate?></td>
   		</td>
   	</tr>    	
   </table>

   <h2><?php echo $obLanguage->String(STR_THREADING)?></h2>
   
	<table border="0" class="settingsborder" width="100%" cellpadding="5">
   	<tr>
   		<td size="30%" valign="top"><?php echo $obLanguage->String(STR_MAX_NUMBER_OF_COMMAND_THREADS)?></td>
   		<td size="70%"><input type="text" name="tcpipthreads" value="<?php echo $tcpipthreads?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_MAX_NUMBER_OF_COMMAND_THREADS)?>"></td>
   	</tr>  	
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_DELIVERY_THREADS)?></td>
   		<td><input type="text" name="maxdeliverythreads" value="<?php echo $maxdeliverythreads?>" checkallownull="false" checktype="number" checkmessage="<?php echo $obLanguage->String(STR_DELIVERY_THREADS)?>"></td>
   	</tr> 
   	<tr>
   		<td valign="top"><?php echo $obLanguage->String(STR_WORKER_THREAD_PRIORITY)?></td>
   		<td>  
   		   
   		   <select name="workerthreadpriority" style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif">
   		      <option value="2" <?php if ($workerthreadpriority == "2") echo "selected";?> >Highest</option>
   		      <option value="1" <?php if ($workerthreadpriority == "1") echo "selected";?> >Above normal</option>
   		      <option value="0" <?php if ($workerthreadpriority == "0") echo "selected";?> >Normal</option>
   		      <option value="-1" <?php if ($workerthreadpriority == "-1") echo "selected";?> >Below normal</option>
   		      <option value="-2" <?php if ($workerthreadpriority == "-2") echo "selected";?> >Lowest</option>
   		      <option value="-15" <?php if ($workerthreadpriority == "-15") echo "selected";?> >Idle</option>
   		   </select>
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
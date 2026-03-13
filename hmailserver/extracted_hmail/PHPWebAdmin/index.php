<?php


   error_reporting(E_ALL);
      
   if (!file_exists("config.php"))
   {
   	echo "Please rename config-dist.php to config.php. The file is found in the PHPWebAdmin root folder.";
   	die;
   }
  
   require_once("config.php");
   require_once("initialize.php");
 
   set_error_handler("ErrorHandler");
   
   if (is_php5())
      set_exception_handler("ExceptionHandler");
   

   
   $page = hmailGetVar("page");
   
   if ($page == "")
      $page = "frontpage";

   $isbackground = (substr($page, 0,10) == "background");
   
   
   if ($isbackground)
      $page = "$page.php";
   else
      $page = "hm_$page.php";
      
   // Check that the page really exists.
   $page = stripslashes($page);
   if (!file_exists($page))
      hmailHackingAttemp();

   // If it's a background page, run here.
   if ($isbackground)
   {
      include $page;

      // Page is run, die now.
      die;
   }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=iso-8859-1">
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="0">
		
		<TITLE>PHPWebAdmin</TITLE>
		<LINK href="style.css" type=text/css rel=stylesheet>
		
		<script language="JavaScript" src="include/formcheck.js" type="text/javascript"></script>
      <script type="text/javascript" src="include/dtree.js"></script>

</head>
<body>
  <br/>
  
  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
     <td>
         <font face="verdana, arial" size="1">
         PHPWebAdmin for hMailServer
     </td>
  </tr>
  </table>
  <br/>
   
  <table width="950" height="500" class="mainborder" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
      <td valign="top">
         
            <table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
	            <tr> 
		            <?php
		            
		            if (isset($_SESSION['session_loggedin']) && 
		                      $_SESSION['session_loggedin'] == "1")
		            {

	               ?>
                     <td width="300" valign="top">
		               <br/>
                     <?php
                     
   		               include "include_treemenu.php";
      						echo "<div class=\"dtree\">
         						<script type=\"text/javascript\">
         						//<!--
         						d = new dTree('d','images/');
         						$dtree
         						//-->
         						</script>
      						";
   		            ?>
      		         </td>
      		         
   			         <td valign="top" align="left" width="600">
                        <?php
                        
                           include "$page";
                        ?>
                        <br/><br/>
                     </td>
                  <?php
                  }
                  else
                  {
                     ?>
   			         <td valign="top" align="left" width="900">
                        <?php
                        
                           include "hm_login.php";
                        ?>
                        <br/><br/>
                     </td>                     
                     <?php
                  }
                  ?>
               </tr>
           </table>
           
        </div>
     </td>
  </tr>
</table>

  <table width="800" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
     <td>
         <font face="verdana, arial" size="1">
         <a href="http://www.hmailserver.com">hmailserver.com</a>, <a href="http://www.hmailserver.com/documentation/">documentation</a>, <a href="http://www.hmailserver.com/forum/">forum</a>
     </td>
  </tr>
  </table>
                    
</body>
</html>

<?php
// user defined error handling function
function ErrorHandler($errno, $errstr, $errfile, $errline)
{
   include "error.php";
   die;
}

function ExceptionHandler($exception)
{
   $errno = $exception->getCode();
   $errfile = $exception->getFile();
   $errline = $exception->getLine();
   $errstr = $exception->getMessage() . "<br>" . $exception->getTraceAsString();
   
   include "error.php";
   
   die;
}

?>
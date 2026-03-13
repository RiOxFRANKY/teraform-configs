<?php
   // Force termination of the session. 
   $_SESSION['session_loggedin'] = 0;
?>

   <table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr> 
        <td>
         <h1>Error</h1>
         An error has occured. Please make sure that you have logged on with the appropriate permissions to perform this task.
         
         <br/><br/>
         <a href="index.php">Log in again.</a>
         
         
         <br/>
         <br/>
         <br/>
         <font color="#888888">
         <i>Problem information</i>
         
         
         <table width="100%" cellpadding="0" cellspacing="0>
           <tr valign="top">
             <td width="100"><i>Number</i></td>
             <td><?php echo $errno?></td>
           </tr>
           <tr valign="top">
             <td><i>File</i></td>
             <td><?php echo $errfile?></td>
           </tr>		              
           <tr valign="top">
             <td><i>Line</i></td>
             <td><?php echo $errline?></td>
           </tr>		              

           <tr valign="top">
             <td><i>Description</i></td>
             <td><?php echo $errstr?></td>
           </tr>
           </table>
         </td>
         </font>
      </tr>
  </table>

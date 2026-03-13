   <br/>
   <br/>
   <form action="index.php" method="post" onSubmit="return formCheck(this);" name="mainform">

      <input type="hidden" name="page" value="background_login">

      <table width="200" align="center">
         <tr>
            <td>
               <br/><br/>
               <img src="images/hm_logotype.gif" border="0">    
            	<br/><br/>
            	<?php
            	   $error = hmailGetVar("error");
            	   if ($error == "1")
            	   {
            	      echo "Incorrect username or password<br/><br/>";  
            	   }
            	?>
            	<?php echo $obLanguage->String(STR_USERNAME)?>:<br/>
            	<input type="text" name="username" size="25" maxlength="256"><br/>
            	<?php echo $obLanguage->String(STR_PASSWORD)?>:<br/>
            	<input type="password" name="password" size="25" maxlength="256"><br/>
            	<br/>
            	<input type="submit" value="<?php echo $obLanguage->String(STR_OK)?>">
               </div>
            </td>
         </tr>
      </table>
   
   </form>
   
   <script language="javascript">
      document.mainform.username.focus();
   </script>

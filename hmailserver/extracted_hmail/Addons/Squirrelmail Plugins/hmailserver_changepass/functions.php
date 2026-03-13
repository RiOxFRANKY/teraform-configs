<?php

function hmailserver_changepass_opt_do() {
    global $optpage_blocks;
    
    bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
    textdomain('hmailserver_changepass'); 
        
    $optpage_blocks[] = array(
        'name' => _("Change Password"),
        'url' => '../plugins/hmailserver_changepass/options.php',
        'desc' => _("Use this to change your email password."),
        'js' => FALSE
    );          
                
}       
        
function hmailserver_changepass_optpage_loadinfo_do() {
   global $optpage, $optpage_name;
   
   bindtextdomain('hmailserver_changepass', SM_PATH . 'plugins/hmailserver_changepass/locale');
   textdomain('hmailserver_changepass');

   if ($optpage=='hmailserver_changepass') {
       // is displayed after "Successfully Saved Options:"
       $optpage_name=_("User's Password");
   }
}       

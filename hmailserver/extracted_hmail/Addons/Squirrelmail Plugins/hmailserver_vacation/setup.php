<?php

function squirrelmail_plugin_init_hmailserver_vacation() {
  global $squirrelmail_plugin_hooks;

  $squirrelmail_plugin_hooks['optpage_set_loadinfo']['hmailserver_vacation'] = 'hmailserver_vacation_optpage_loadinfo';
  $squirrelmail_plugin_hooks['optpage_register_block']['hmailserver_vacation'] = 'hmailserver_vacation_opt';
}

function hmailserver_vacation_opt() {

   if (defined('SM_PATH'))
      include_once(SM_PATH . 'plugins/hmailserver_vacation/functions.php');
   else
      include_once('../plugins/hmailserver_vacation/functions.php');

   hmailserver_vacation_opt_do();
}


function hmailserver_vacation_optpage_loadinfo() {

   if (defined('SM_PATH'))
      include_once(SM_PATH . 'plugins/hmailserver_vacation/functions.php');
   else
      include_once('../plugins/hmailserver_vacation/functions.php');

   hmailserver_vacation_optpage_loadinfo_do();

}

function hmailserver_vacation_version() {

   return '2.0';
}
?>
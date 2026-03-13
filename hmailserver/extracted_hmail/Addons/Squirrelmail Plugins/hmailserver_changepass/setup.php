<?php

function squirrelmail_plugin_init_hmailserver_changepass() {
  global $squirrelmail_plugin_hooks;

  $squirrelmail_plugin_hooks['optpage_set_loadinfo']['hmailserver_changepass'] = 'hmailserver_changepass_optpage_loadinfo';
  $squirrelmail_plugin_hooks['optpage_register_block']['hmailserver_changepass'] = 'hmailserver_changepass_opt';

}

function hmailserver_changepass_opt() {

   if (defined('SM_PATH'))
      include_once(SM_PATH . 'plugins/hmailserver_changepass/functions.php');
   else
      include_once('../plugins/hmailserver_changepass/functions.php');

   hmailserver_changepass_opt_do();

}


function hmailserver_changepass_optpage_loadinfo() {

   if (defined('SM_PATH'))
      include_once(SM_PATH . 'plugins/hmailserver_changepass/functions.php');
   else
      include_once('../plugins/hmailserver_changepass/functions.php');

   hmailserver_changepass_optpage_loadinfo_do();

}


function hmailserver_changepass_version() {
   return '1.1';
}

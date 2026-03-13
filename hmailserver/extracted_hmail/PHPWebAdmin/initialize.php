<?php
/*
**	hMailServer - Web interface
**
**	File formatted using TAB size 4
**
**	Get hMailserver at http://www.hmailserver.com
**
**	Author: Steen Rabøl <srabol@mail.tele.dk>
**	Copyright (c) 2004, Steen Rabøl <srabol@mail.tele.dk>
**
**  This program is free software; you can redistribute it and/or modify
**  it under the terms of the GNU General Public License as published by
**  the Free Software Foundation; either version 2 of the License, or
**  (at your option) any later version.
**
**  You may not change or alter any portion of this comment or credits
**  of supporting developers from this source code or any supporting
**  source code which is considered copyrighted (c) material of the
**  original comment or credit authors.
**
**  This program is distributed in the hope that it will be useful,
**  but WITHOUT ANY WARRANTY; without even the implied warranty of
**  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**  GNU General Public License for more details.
**
**  You should have received a copy of the GNU General Public License
**  along with this program; if not, write to the Free Software
**  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
**
*/

// make sure path's only have forward slashes
$hmail_config['rootpath']		= str_replace("\\","/",$hmail_config['rootpath']);
$hmail_config['includepath']	= str_replace("\\","/",$hmail_config['includepath']);
$hmail_config['temppath']		= str_replace("\\","/",$hmail_config['temppath']);
require_once($hmail_config['includepath'] . "functions.php");

session_start();

// Connect to hMailServer
$obBaseApp = new COM("hMailServer.Application");
$error_handler = set_error_handler("ConnectError");
$obBaseApp->Connect();
restore_error_handler();

if (isset($_SESSION['session_username']) && 
    isset($_SESSION['session_password']))
{
	// Authenticate the user
	$obBaseApp->Authenticate($_SESSION['session_username'], $_SESSION['session_password']);
}

include "hmailserver_string_constants.php";

$obLanguage = $obBaseApp->GlobalObjects->Language($hmail_config['defaultlanguage']);

// error handler function
function ConnectError($errno, $errstr, $errfile, $errline)
{
   $descstart = strpos($errstr, "Description");
   $descstart += strlen("Description");

   $cleanerrormsg = substr($errstr, $descstart);
   echo "<br><br>ERROR: $cleanerrormsg";
}


function phpnum() 
{
   $version = explode('.', phpversion());
   return (int) $version[0];
}

function is_php5()
{
   return phpnum() == 5; 
}

function is_php4() 
{ 
   return phpnum() == 4; 
}

?>
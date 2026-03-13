<?php
/*
** $Id: functions.php,v 1.8 2007/03/19 21:55:09 hmailserver Exp $
**
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

function hmailGetVar($p_varname, $p_defaultvalue = null)
{
	$retval = $p_defaultvalue;
	if(isset($_GET[$p_varname]))
	{
		$retval = $_GET[$p_varname];
	}
	else if (isset($_POST[$p_varname]))
	{
		$retval = $_POST[$p_varname];
	}
	else if (isset($_REQUEST[$p_varname]))
	{
		$retval	= $_REQUEST[$p_varname];
	}
	
	if (get_magic_quotes_gpc())
	   $retval = stripslashes($retval);
	
	return $retval;
}


function hmailGetUserDomainName($username)
{
	$atpos = strpos($username, "@");
	$domain = substr($username, $atpos + 1);
	return $domain;
}

define("ADMIN_USER", 0);
define("ADMIN_DOMAIN", 1);
define("ADMIN_SERVER", 2);


function hmailGetAdminLevel()
{
	if (isset($_SESSION["session_adminlevel"]))
		return $_SESSION["session_adminlevel"];
	else
		return -1;
}

function hmailGetDomainID()
{
	if (isset($_SESSION["session_domainid"]))
		return $_SESSION["session_domainid"];
	else
		return -1;
}

function hmailGetAccountID()
{
	if (isset($_SESSION["session_accountid"]))
		return $_SESSION["session_accountid"];
	else
		return -1;
}

function hmailHackingAttemp()
{
	include "hm_permission_denied.php";
	
	exit();
}

function hmailHasDomainAccess($domainid)
{
	if (hmailGetAdminLevel() == 2)
		return true;

	if (hmailGetAdminLevel() == 1 && hmailGetDomainID() == $domainid)
		return true;
		
	return false;
}

function hmailCheckedIf1($value)
{
   if ($value == "1")
      return "checked";  
   else
      return "";
   
}

function GetStringForJavaScript($StringID)
{
   global $obLanguage;
   
   $value = $obLanguage->String($StringID);
   $value = str_replace('\'', '\\\'', $value);
   return $value;
}


function HMEscape($string)
{
   $string = str_replace('\'', '\\\'', $string);
   return $string;
}
?>
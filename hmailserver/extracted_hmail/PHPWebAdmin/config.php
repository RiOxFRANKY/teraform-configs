<?php
/*
** $Id: config-dist.php,v 1.1 2005/10/15 21:17:54 hmailserver Exp $
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

// Global configuration. See examples below:
$hmail_config['rootpath']			= "CHANGE-ME";
$hmail_config['rooturl']			= "CHANGE-ME";
$hmail_config['includepath']		= $hmail_config['rootpath'] . "include/";
$hmail_config['temppath']			= $hmail_config['rootpath'] . "temp/";
$hmail_config['defaultlanguage']	= "english";

/*
	Example:
	$hmail_config['rootpath']			= "C:/Program Files/Apache Group/Apache2/htdocs/PHPWebAdmin/";
	$hmail_config['rooturl']			= "http://www.mydomain.com/PHPWebAdmin/";
	$hmail_config['includepath']		= $hmail_config['rootpath'] . "include/";
	$hmail_config['temppath']			= $hmail_config['rootpath'] . "temp/";
	$hmail_config['pluginpath']			= $hmail_config['rootpath'] . "plugins/";
	$hmail_config['defaultlanguage']	= "english";
	$hmail_config['defaulttheme']		= "default";


*/

?>
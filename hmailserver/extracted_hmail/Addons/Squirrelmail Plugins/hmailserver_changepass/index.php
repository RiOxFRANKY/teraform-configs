<?php

/**
 * index.php
 *
 * Copyright (c) 1999-2002 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This plugin is based on the MySQL password changer written
 * by Paul Lesneiwski.
 * (http://www.squirrelmail.org/plugin_view.php?id=187)
 *
 * It has been modified to fit for the mailserver hMailServer.
 * (http://www.hmailserver.com)
 * It uses the hMailServer COM library for password modification, so the
 * plugin has to be run under Win32.
 *
 * This file simply takes any attempt to view source files and sends those
 * people to the login screen. At this point no attempt is made to see if
 * the person is logged or not.
 *
 */


header("Location:../index.php");

/* pretty impressive huh? */

?>

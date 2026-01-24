<?php
//-----------------------------------------------------------------------------
// BellaBook Copyright © Jem Turner 2004-2007,2008 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------


$title = "Messages for Timotheus"; // guestbook title shown in <title> and header

$admin_name	= "admin";   // admin username
$admin_pass	= "password";   // admin password
$admin_email = "contact@example.com";   // admin e-mail address
$admin_url = "https://tim.mesh.net.nz";   // optional site url for footer context
$admin_gburl = "https://tim.mesh.net.nz/eprn-guestbook";   // guestbook url used in notifications
$admin_sitename = "Messages for Timotheus";   // footer/site name
$secret = "pleasechangeme";    // long random string acts as second factor for auth

$dateformat	= "d M Y h:ia";   // date format, more details: php.net/date
$stylecolor	= "bigblue";   // theme file prefix (bigblue-stylesheet.css)

$showwebsites = "no";  // unused for this fork; locations are always shown when provided
$showemail = "no";   // never show sender emails on the public page
$emailentries = "no";   // set to yes if you want email notifications to admin

$emailrequired = "no";   // email optional; reduces PII
$perpage = "10";   // entries per page
$smilies = "no";   // keep messages plain text

// spam protection options
$captcha = "no";   // captcha on? - write yes or no
$moderate = "yes";   // new entries must be approved before display
$floodcontrol = "yes";   // prevent back-to-back posts from same IP
$allowlinks = "yes";   // links will be stripped to plain text before saving
$maxPoints = 4; // max points before rejecting as spam

?>
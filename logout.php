<?php
//-----------------------------------------------------------------------------
// BellaBook Copyright © Jem Turner 2004-2007,2008 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------

if (isset($_COOKIE['bellabook'])) {
	if (session_status() == PHP_SESSION_NONE) session_start();
	session_destroy();
	setcookie('bellabook', '', time()-3600, '/', '', isset($_SERVER['HTTPS']), true);
	header("Location: logout.php");
	exit;
}
@include('header.php');

echo "<p>You are now logged out.</p>";

@include('footer.php');
?>
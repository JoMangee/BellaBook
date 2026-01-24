<!--
//-----------------------------------------------------------------------------
// BellaBook Copyright © Jem Turner 2004-2007,2008 unless otherwise noted
// http://www.jemjabella.co.uk/
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License. See README.txt
// or LICENSE.txt for more information.
//-----------------------------------------------------------------------------
-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="Support messages for Timotheus at Christchurch Men's Prison." />
<link href="<?php echo $stylecolor; ?>-stylesheet.css" rel="stylesheet" type="text/css" />
<title><?php echo $title; ?><?php if (isset($_GET['page']) && is_numeric($_GET['page'])) echo ' | Page '. (int)$_GET['page']; ?></title>
</head>
<body>
<div id="container">
    <h1 class="site-title"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="lede">Short messages of encouragement will be reviewed and printed for Timotheus at Christchurch Men's Prison. Please keep them respectful and suitable for mailroom review.</p>
    <div class="guidelines">
        <h2>Message guidelines</h2>
        <ul>
            <li>Keep it brief, supportive, and free of legal advice or case details.</li>
            <li>No illegal or objectionable material, profane, sexual, or gang-related language.</li>
            <li>Anything that threatens prison security, management, or any prisoner will not be passed on.</li>
            <li>Coded messages will not be passed on; links are stripped to plain text.</li>
            <li>Messages are reviewed by family; Corrections or Police may also review.</li>
        </ul>
    </div>
    <p id="topnav"><a href="sign.php#form">Send a message</a> | <a href="index.php#messages">View messages</a></p>

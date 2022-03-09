<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once('Nikki_fns.php');
$title = "Nikki Index";
$header = "Home";
$description = "Landing Page Description";

doHtmlHeader($title, $header, $description);

doAboutMe();

doHtmlFooter();


?>

<?php
session_start();
require_once('Nikki_fns.php');

$title = "Playground";
$mainHeader= "Playground!";
$mainDescription = "Playground";
?>
<html>
        <head>
        <link href="card.css" rel="stylesheet" type="text/css">
           <style>
           img {
                max-width: 100%;
                max-height: 100%;
            }

            .portrait {
                height: 80px;
                width: 30px;
            }

            .landscape {
                height: 30px;
                width: 80px;
            }

            .square {
                height: 75px;
                width: 75px;
            }
           </style>
        </head>
        <body>
        <div class="portrait">
        Portrait Div
    <img src="http://i.stack.imgur.com/xkF9Q.jpg">
</div>

Landscape Div
<div class="landscape">
    <img src="http://i.stack.imgur.com/xkF9Q.jpg">
</div>

Square Div
<div class="square">
    <img src="http://i.stack.imgur.com/xkF9Q.jpg">
</div>
<?php
    do_html_footer();
?>
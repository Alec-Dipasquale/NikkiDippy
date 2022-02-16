<?php   
session_start();
require_once('Nikki_fns.php');
$title = "home";
$mainHeader= "Nikki Dippy's Catalog";
$mainDescription = "This is a catalog of all of Nikki's current products.";
do_html_header($title, $mainHeader, $mainDescription);

do_catalog_nav();
if(isset($_SESSION["search_result"])) {
    $result = $_SESSION["search_result"];
}
do_catalog_products($result);

do_html_footer();
?> 
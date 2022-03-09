<?php
session_start();
require_once('Nikki_fns.php');

if (isset($_POST['forwardButton_x'])) {
  $_SESSION['catalog_product_count'] = $_SESSION['catalog_product_count'] + $_POST['maxProductCount'];
  debugToConsole("catalogFunction: forward_arrow clicked.");
  header("location:catalogView.php");
}
if (isset($_POST['backButton_x'])) {
  $_SESSION['catalog_product_count'] = $_SESSION['catalog_product_count'] - $_POST['maxProductCount'];
  debugToConsole("catalogFunction: back_arrow clicked.");
  header("location:catalogView.php");
}

?>
<?php   
session_start();
require_once('Nikki_fns.php');

$title = "home";
$mainHeader= "Nikki Dippy's Catalog";
$mainDescription = "This is a catalog of all of Nikki's current products.";

doHtmlHeader($title, $mainHeader, $mainDescription); 

$maxProductRows = 4;
$maxProductColumns = 2;
$maxProductCount = $maxProductRows * $maxProductColumns;

if (!isset($_SESSION['catalog_product_count'])) {
  $_SESSION['catalog_product_count'] = 0;
}

?> 
    
  <div class="item2">
    <?php
    doCatalogNav();
    ?>
  </div>
  <div class="item3">
        <?php
        
        if (isset($_SESSION["search_result"])) {
            $result = $_SESSION["search_result"];
        }
        if (isset($_SESSION["search_term"])) {
          $search_term = $_SESSION["search_term"];
          $_SESSION['catalog_product_count'] = 0;
        }
        doCatalogProducts($result, $maxProductRows, $maxProductColumns);
        ?>
  </div>  
</div>

<?php
// do_html_header($title, $mainHeader, $mainDescription);



doHtmlFooter();
?> 
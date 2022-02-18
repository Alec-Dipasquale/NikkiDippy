<?php   
session_start();
require_once('Nikki_fns.php');
$title = "home";
$mainHeader= "Nikki Dippy's Catalog";
$mainDescription = "This is a catalog of all of Nikki's current products.";
do_html_header($title, $mainHeader, $mainDescription); 

    ?>
    
  <div class="item2">
    <?php
    do_catalog_nav();
    ?>
  </div>
  <div class="item3">
        <?php
        if(isset($_SESSION["search_result"])) {
            $result = $_SESSION["search_result"];
        }
        do_catalog_products($result);
        ?>
  </div>  
</div>

<?php
// do_html_header($title, $mainHeader, $mainDescription);



do_html_footer();
?> 
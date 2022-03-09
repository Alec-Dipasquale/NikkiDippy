<?php
    session_start();
    require_once('Nikki_fns.php');

    if (isset($_POST['delete'] )) {
        if(isset($username)){
            $query_cart_item_delete = "DELETE FROM cart_items WHERE product_id = ".$_POST['cart_index']." AND username = '".$username."'";
            debugToConsole("query_cart_item_delete: " . $query_cart_item_delete);
    
            $delete_result= $db->query($query_cart_item_delete);
            if($delete_result){
                header("location:cartView.php");
            } else{
                echo "<p>Error deleting from cart</p>";
            }
        } else{
            unset($_SESSION['cart_array'][$_POST['cart_index']]);
            header("location:cartView.php");
        }
    
    }
?>
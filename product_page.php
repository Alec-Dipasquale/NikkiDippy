<?php
session_start();
require_once('Nikki_fns.php');
$db = db_connect();

$title = "Nikki's Product Page";
$mainHeader= "Product Page";
$mainDescription = "This is a catalog of all of Nikki's current products.";
do_html_header($title, $mainHeader, $mainDescription);

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if(isset($_POST['product_id'])){
$product_id = $_POST['product_id'];
$query_product = "SELECT * FROM products WHERE product_id LIKE '%".$product_id."%'";
$result = $db->query($query_product);
$num_results = $result->num_rows;

}
    if(isset($_POST['add_to_cart'])) {
        if(isset($username)){
            $username = $_POST['username'];
            if (!get_magic_quotes_gpc()) {
                $username = addslashes($username);
            }
        }
        $quantity = $_POST['quantity'];
        $product_id = $_POST['product_id'];
        
        if (!get_magic_quotes_gpc()) {
            $product_id = addslashes($product_id);
            $quantity = addslashes($quantity);
            }
            echo "<h1>";
            if(isset($username)){
            $update_cart_query = "update cart_items set quantity = '".$quantity."' where (product_id = '".$product_id."' AND username = '".$username."') ";
            $update_result= $db->query($update_cart_query);
            $check_rows_num= $db -> affected_rows;
            if ( $check_rows_num == 0) {
                
                $insert_cart_query = "insert into cart_items values (NULL, '".$username."', '".$product_id."', '".$quantity."')";
                $insert_cart_result = $db->query($insert_cart_query);

                if ($insert_cart_result) {
                    echo  $quantity." item placed in cart.</h1>";
                } else {
                    echo "An error has occurred.  The item was not added to cart.";
                }
                
            } else{
                echo "Cart updated";
            }
        } else{
            if(isset($_SESSION['cart'])){
                array_push($_SESSION['cart'],array( $product_id, $quantity ));
                echo "Cart updated";
            }
            else{
                $_SESSION['cart'] = array (
                    array( $product_id, $quantity )
                );
                echo "Cart started";
            }
        }
        
        echo "</h1>";

        }

?>
<html>
    
<div
    <form method="post" >
    <?php

        
             
              
            
        $count = 0;
        for ($i=0; $i <1; $i++) {
            $count++;
            if($count > $num_results){
                break;
            }
            $row = $result->fetch_assoc();
             
            echo '<div class="product"><h1>';
            echo htmlspecialchars(stripslashes($row["name"]));
            echo '</h1>';
            echo '<img src="data:image/jpg;base64,'.base64_encode( $row['img'] ).'" style="max-width:500px"/>';
            echo '<p>Description: ';
            echo htmlspecialchars(stripslashes($row["description"]));
            echo '</p><p>Price: $';
            echo htmlspecialchars(stripslashes($row["price"]));
            echo '</p><p>In Stock: ';
            $in_stock= htmlspecialchars(stripslashes($row["quantity"]));
            echo $in_stock;
            echo '</p>';
            
    }
    
?>
        <form method="post"> 
                <?php 
                echo '<input style="font-size:25px;width:5%" type="number" name="quantity" min=1 max ='.$in_stock.'>';
                if(isset($_SESSION['username'])){
                    echo '<input type="hidden" name="username" value='.$username.'>';
                }
                echo '<input type="hidden" name="product_id" value= '.$product_id.'>';
                ?>
                <input style="width:13%;" type="submit" name="add_to_cart" value="Add To Cart"/> 
        </form> 
        <form method="post" action="main_page.php">
            <input style="width:20%" type="submit" name="home" value = "Home"/>
        </form>
            
            <?php
            
        
        $db->close();
        ?>
<br/></p>
</div>
</body>
</html>




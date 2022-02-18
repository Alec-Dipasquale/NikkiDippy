<?php
session_start();
require_once('Nikki_fns.php');
require_once('cart_fns.php');
$db = db_connect();

$title = "Nikki's Cart Page";
$mainHeader= "Cart";
$mainDescription = "This is a catalog of all of Nikki's current products.";
do_html_header($title, $mainHeader, $mainDescription);

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query_for_cart = "select * from cart_items where username = '".$username."'";
    $result = $db->query($query_for_cart);
    $num_results = $result->num_rows;
}

if(isset($_POST['delete'] )){
    if(isset($username)){
        $query_cart_item_delete = "DELETE FROM cart_items WHERE product_id = ".$_POST['cart_index']." AND username = '".$username."'";
        debug_to_console("query_cart_item_delete: " . $query_cart_item_delete);

        $delete_result= $db->query($query_cart_item_delete);
        if($delete_result){
            header("Refresh:1");
        } else{
            echo "<p>Error deleting from cart</p>";
        }
    } else{
        unset($_SESSION['cart_array'][$_POST['cart_index']]);
        header("Refresh:1");
    }

}
    
    
    
    

?>
<html>
    <header>
        <link href="credentials.css" rel="stylesheet" type="text/css">
    </header>
<body>
<div class="cart">
    <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
                </thead>
            <tbody>
                
               <?php
               
               $subtotal = 0;
               $total = 0;
               if(isset($username)){
                    $query = "select * from cart_items where username = '".$username."'";
                    $result = $db->query($query);
                    $num_results = $result->num_rows;

                    for ($i=0; $i <$num_results; $i++) {
                        $row = $result->fetch_assoc();

                        $item_total = do_check_out_item($row, $db);
                        
                        $subtotal = $subtotal + $item_total;      
                        
                    }
                    do_check_out_totals($subtotal);
                ?>
                </td></tr></table>
                <form action = 'receipt.php' method='post'>
                    <div style="text-align:right;">
                        <?php
                            echo "<input type='hidden'  name='username' value='".$username."'/>";
                        ?>
                        <input style="width:20%"type="submit" name="check_out" value = "check out"/>
                    </div>
                </form>
                    
                    <?php
               }else{
                   if(isset($_SESSION['cart_array'])){
                        reset($_SESSION['cart_array']);
                        $currentArray = current($_SESSION['cart_array']);
                        for($i=0; $i < count($_SESSION['cart_array']); $i++) {
                        
                            if(isset($currentArray)){
                                $product_query = "SELECT * FROM products WHERE product_id like '%".$currentArray['product_id']."%'";
                                $product = $db->query($product_query);
                                $product_row = $product->fetch_assoc();
                                
                                $item_price = $product_row['price'];
                                $item_quantity = $currentArray['quantity'];
                                $item_total=$item_price * $item_quantity;
                                $subtotal = $subtotal + $item_total;
                                $product_img = base64_encode( $product_row["img"] );
                                $product_id = $currentArray['product_id'];
                                
                                do_check_out($product_row, $item_price, $item_quantity, $item_total, $product_id, $product_img);
                            }

                            $currentArray = next($_SESSION['cart_array']);
                        }
                        do_check_out_totals($subtotal);
                   }
               }
                
                $db->close();
            ?>
        
</div>
</body>
</html>
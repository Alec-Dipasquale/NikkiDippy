<?php
session_start();
require_once('Nikki_fns.php');
require_once('cart_fns.php');
$db = db_connect();

$title = "Nikki's Cart Page";
$mainHeader= "Cart";
$mainDescription = "This is a catalog of all of Nikki's current products.";
doHtmlHeader($title, $mainHeader, $mainDescription);

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query_for_cart = "select * from cart_items where username = '".$username."'";
    $result = $db->query($query_for_cart);
    $num_results = $result->num_rows;
}

//TODO create file for post values

    
    
    /*
        TODO change if username else statement into one statement
        TODO 
    */
    
?>
<html>
    <header>
        <link href="cart.css" rel="stylesheet" type="text/css">
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

                        $item_total = doCheckOutItem($row, $db);
                        
                        $subtotal = $subtotal + $item_total;      
                        
                    }
                    doCheckOutTotals($subtotal);
                ?>
                </td></tr></table>
                <form action = 'receipt.php' method='post'>
                    <div style="text-align:right;">
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
                                
                                doCheckOut($product_row, $item_price, $item_quantity, $item_total, $product_id, $product_img);
                            }

                            $currentArray = next($_SESSION['cart_array']);
                        }
                        doCheckOutTotals($subtotal);
                   }
               }
                
                $db->close();
            ?>
            
            </td></tr></table>
                <form action = 'receipt.php' method='post'>
                    <div style="text-align:right;">
                        <input style="width:20%"type="submit" name="check_out" value = "check out"/>
                    </div>
                </form>
        
</div>
</body>
</html>
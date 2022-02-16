<?php
session_start();
require_once('Nikki_fns.php');

    if($_SESSION['logged'] == false){
        header("Location: login_page.html");
    } else{
        $username = $_SESSION['username'];
    }
  if(isset($_POST['username'])){
      $date = date('H:i, jS F Y');
  }
?>
<html>
<head>
  <title>Nikki Dippy's - Order Results</title>
</head>
<body>
<h1>Nikki Dippy's Graphics</h1>
    <div style="text-align:center;padding-top:25px;">
        <form method="post" action="main_page.php">
            <input style="width:20%" type="submit" name="home" value = "Home"/>
        </form>
    </div>
<h2>Order Results</h2>
<?php

	echo "<p>Order processed at ".date('H:i, jS F Y')."</p>";

	echo "<p>Your order is as follows: </p>";
    $subtotal = 0;
    $tax_rate = .07;
    $total = 0;
    $query = "select * from cart_items where username = '".$username."'";
    $result = $db->query($query);
    $num_results = $result->num_rows;
    
    $outputstring = $username."<br/>".$date."<br/>";
    
    for ($i=0; $i <$num_results; $i++) {
        $row = $result->fetch_assoc();
        $product_query = "SELECT * FROM products WHERE product_id like '%".stripslashes($row['product_id'])."%'";
        $product = $db->query($product_query);
        
        for($j = 0; $j <  1;$j++){
            $product_row = $product->fetch_assoc();
            $item_price = $product_row['price'];
            $item_quantity = $row['quantity'];
            $item_total=$item_price * $item_quantity;
            $subtotal = $subtotal + $item_total;
            echo "Ordered:". $item_quantity." ".$product_row['name']." for ".$item_total."</br>";
            $outputstring = $outputstring."Ordered:". $item_quantity." ".$product_row['name']." for ".$item_total."<br/>";
            
            if($result != false){
                $query_adjust_stock = "update products set quantity = (quantity -".$item_quantity.") where product_id = '".$product_row['product_id']."'";
                if($db->query($query_adjust_stock) == false){
                    echo "Error with updating stock.";
                    exit;
                }
            }
        }
    }
    $tax = number_format($subtotal * $tax_rate,2);
    $total = number_format($subtotal + $tax,2);

    if($result != false){
        $delete_cart_items_query = "delete from cart_items where username = '".$username."'";
        $db->query($delete_cart_items_query);
    }
	if ($num_results == 0) {

	  echo "You did not order anything on the previous page!<br />";
      exit;
	}
    

    $outputstring = $outputstring."Total:".$total ;
    
    if (!get_magic_quotes_gpc()) {
                $username = addslashes($username);
                $outputstring = addslashes($outputstring);
                $date = addslashes($date);
                }
    
    $query_insert_order = "insert into orders values (NULL, '".$username."', '".$outputstring."', '".$date."')";
    if($db->query($query_insert_order) == false){
        echo 'Could not add order to database';
        exit;
    }
    
    
	echo "<p>Total of order is $".$total." tax included.</p>";
	echo "<p>Order placed. Thank you!</p>";
	$db->close();
?>
    
</body>
</html>

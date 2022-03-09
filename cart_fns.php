<?php
function doCheckOutItem($row, $db){
    $product_query = "SELECT * FROM products WHERE product_id like '%".stripslashes($row['product_id'])."%'";
    $product = $db->query($product_query);
    $product_row = $product->fetch_assoc();
    

    $item_price = $product_row['price'];
    $item_quantity = $row['quantity'];
    $item_total=$item_price * $item_quantity;  
    $product_img = base64_encode( $product_row["img"] );
    $product_id = $row['product_id'];
            
    doCheckOut($product_row, $item_price, $item_quantity, $item_total, $product_id, $product_img);
    
    echo "</tr>";
    return $item_total;
}



function doCheckOut($product_row, $item_price, $item_quantity, $item_total, $product_id, $product_img){                                
    echo "<tr><td><img src='data:image/jpg;base64,".$product_img."' style='max-width:100px;'/></td>";
    echo "<td>".$product_row['name']."</td>";
    echo "<td>$".$item_price."</td>";
    echo "<td><a>".$item_quantity."</a></td>";
    echo "<td>$".$item_total."</td>";
    echo "<td style='border:0px;'><form method='post' action='cart.php'>
    <input type='hidden' name='cart_index' value='". $product_id."'/>
    <input type='submit' name='delete' value= 'remove from cart'/></form></td>";
    echo "</tr>";
}


function doCheckOutTotals($subtotal){
    $tax_rate = .07;
    echo "<td colspan ='4'>subtotal</td><td>".$subtotal."</td></tr>";
    $tax = number_format($subtotal * $tax_rate,2);
    echo "<td colspan ='4'>tax</td><td>".$tax."</td></tr>";
    $total = number_format($subtotal + $tax,2);
    echo "<td colspan ='4'>total</td><td>".$total;
    
}
?>
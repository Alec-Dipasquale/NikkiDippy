<?php
function do_html_header($title, $header, $description) {
    ?>
    <html>
        <head>
        <title><?php echo $title;?></title>
            <link href="style.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div class="grid-container">
                <div class="item1">
        
                    <div class = "div_main_title">
                        <h class = "main_title">Nikki Dippy</h>
                        <p class = "main_description">Nikki's art store</p>
                    </div>

            
                    <div class="top_nav">
                        <a href="index.php">Home</a>
                        <a href="catalog.php">Products</a>
                        <a href="cart.php">Cart</a>

                        <?php 
                    

                        if(isset(($_SESSION['username']))){   
                        $priv = strcmp($_SESSION['type'], 'Owner');
                        if($priv == 0){ 
                            echo '<a href="admin_page.php">Admin</a>';
                            // echo '<a href="playground.php">Playground</a>';
                        }
                        echo '<a href="logout.php">Log Out</a>';
                        } 
                        else{
                            echo '<a href="login.php">Log In</a>';
                            echo '<a href="register.php">Register</a>';
                            // echo '<a href="playground.php">Playground</a>';
                        }
                        if(!isset(($_SESSION['cart_array']))){
                            $_SESSION['cart_array'] = array ();
                            debug_to_console("initialized cart_array in Session: " . print_r($_SESSION['cart_array']));
                    }
                        ?>
                    </div>
                <div class="page_title">
                    <h1><?php echo $header; ?></h1>
                </div>
            </div>
                <?php
}       

function do_html_footer(){
  
  // print an HTML footer
  ?>
  
  </body>
  </html>
<?php 
}

function do_admin_section(){
    if(isset(($_SESSION['type']))){
        if($_SESSION['type'] == "Owner" || $_SESSION['type'] == 'Manager' ||$_SESSION['type'] == 'Employee'){
            echo '<div style = "border:1px solid black; padding: 5px;">';
            echo '<h1>Admin Section</h1>';
            echo '<form method="post" action="check_receipts.php">
            <input style="width: 100%;" type="submit" name="check_all_orders" value = "Check All Orders"/></form>';  
            
            if($_SESSION['type'] == "Owner" || $_SESSION['type'] == 'Manager'){
                echo '<a href="insert.html" style="padding: 5px;">
                <button type="submit">Insert Product</button>
                </a>';
                
                if($_SESSION['type'] == "Owner"){
                    echo '<a href="delete_product.html" style="padding: 5px;">
                    <button type="submit">Delete Product</button>
                    </a></div>'; 
                }
            }
        }
    }
}

function side_cart(){
?>
<header>
   <!-- logo and menu here -->
   <div id="cd-cart-trigger"><a class="cd-img-replace" href="#0">Cart</a></div>
</header>

<main>
   <!-- content here -->
</main>

<div id="cd-shadow-layer"></div>

<div id="cd-cart">
   <h2>Cart</h2>
   <ul class="cd-cart-items">
      <li>
         <!-- ... -->
      </li>

      <li>
         <!-- ... -->
      </li>
   </ul> <!-- cd-cart-items -->

   <div class="cd-cart-total">
      <p>Total <span>$39.96</span></p>
   </div> <!-- cd-cart-total -->

   <a href="#0" class="checkout-btn">Checkout</a>

   <p class="cd-go-to-cart"><a href="#0">Go to cart page</a></p>
</div> <!-- cd-cart -->
<?php
}

function do_catalog_nav(){
    $db = db_connect();
    $query = "select * from products";
    if(isset($_POST['search']) && isset($_POST['searchterm'])) {

        $searchterm = $_POST['searchterm'];
        $query = "select * from products 
        where (product_id like '%".$searchterm."%' OR 
        name like '%".$searchterm."%' OR 
        description like '%".$searchterm."%')";
    }
    if(isset($_POST['show_all'])) {
        $query = "select * from products";
    }

    $result = $db->query($query);
    $_SESSION["search_result"] = $result;
    $num_results = $result->num_rows;
    echo '<div class="results">';
    echo "<form method='post' action='catalog.php'>
                    <input type='text' name='searchterm' />
                    <input type='submit' name='search' value = 'search'/>
                    <input type='submit' name='show_all' value = 'Full Catalog'/>
                </form>";
    echo "<p>Number of products found: ".$num_results."</p>";

    echo '</div>';
    
    $db->close();
}

function do_catalog_products($result){
    $num_results = $result->num_rows;
    echo "<p>Search Results: ".$num_results."</p>";

    echo '<div class= "outer_table_style"><div class="table_style">';
    echo '<table style="width:100%">';
    $count = 0;
    $max_product_rows = 5;
    $max_product_columns = 3;
    $row = array();
    for ($i=0; $i <$num_results; $i++) {
        $row[$i] = $result->fetch_assoc();
    }

    for($i = 0; $i<$max_product_rows; $i++){
        echo '<tr>';
        for($j=0; $j <$max_product_columns; $j++){ 
            if($i >= $num_results){
                break;
            }
            echo '<td>';
            do_catalog_card($row[$count]);
            $count++;
            echo '</td>';

        }    
        echo '</tr>';
    }

    echo'</table></div></div>';
    
}

function do_catalog_card($product_info){
    $product_img = base64_encode( $product_info['img'] );
    $product_name =  htmlspecialchars(stripslashes($product_info["name"]));
    $product_stock = htmlspecialchars(stripslashes($product_info["quantity"]));
    $product_id = htmlspecialchars(stripslashes($product_info['product_id']));
    $product_price = htmlspecialchars(stripslashes($product_info["price"]));
    ?>

        <head>
            <link href="card.css" rel="stylesheet" type="text/css"/>
        </head>
            </div>
            <div class="container page-wrapper">
            <div class="page-inner">
                <div class="row">
                <div class="el-wrapper">
                    <div class="box-up">
                    <img class="img" src="data:image/jpg;base64,<?php echo $product_img ?>" alt="">
                    <div class="img-info">
                        <div class="info-inner">
                        <!-- <span class="p-name"><?php echo $product_name?></span>
                        <span class="p-company">Nikki Dippy</span> -->
                        </div>
                        <div class="a-size"><span class="size"><?php echo $product_name?></span></div>
                    </div>
                    </div>

                    <div class="box-down">
                    <div class="h-bg">
                        <div class="h-bg-inner"></div>
                    </div>

                    <form action="product_page.php" method="post">
                        <a class="product_view">
                            <input type = "hidden" name = "product_id" value = "<?php echo  $product_id ?>" />
                            <span class="price"><?php echo $product_price?></span>
                            <button class="view_product" type="submit"  href="#">
                            <span class="txt">View Product(<?php echo $product_stock?>)</span>
                            </button>
                        </a>
                    </form>

                    <!-- <a class="product_view" href="#">
                        <span class="price"><?php echo $product_price?></span>
                        <span class="view_product">
                        <span class="txt">View Product (<?php echo $product_stock?>)</span>
                        </span>
                    </a> -->
                    </div>
                </div>
                </div>
            </div>
            </div>

            <?php
}

function do_about_me(){
    ?>
    <div class="about_me">
        <h1>About me!</h1>
        <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nibh tortor id aliquet lectus proin nibh nisl condimentum id. Faucibus ornare suspendisse sed nisi lacus sed. Urna id volutpat lacus laoreet non. Sed lectus vestibulum mattis ullamcorper. Quisque egestas diam in arcu cursus euismod quis viverra. Tempus egestas sed sed risus pretium quam. Pulvinar sapien et ligula ullamcorper malesuada proin libero. In massa tempor nec feugiat. Aliquet lectus proin nibh nisl. Imperdiet dui accumsan sit amet nulla facilisi morbi. Volutpat sed cras ornare arcu dui. Morbi tristique senectus et netus et malesuada fames ac. Lectus mauris ultrices eros in. Ipsum dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Malesuada nunc vel risus commodo viverra maecenas accumsan. Malesuada fames ac turpis egestas sed tempus urna. Adipiscing tristique risus nec feugiat in fermentum posuere.

In ornare quam viverra orci sagittis. Nec sagittis aliquam malesuada bibendum. Faucibus ornare suspendisse sed nisi lacus. Lacinia at quis risus sed. Porttitor lacus luctus accumsan tortor posuere ac. Pellentesque adipiscing commodo elit at imperdiet dui accumsan. A arcu cursus vitae congue mauris rhoncus. Urna nunc id cursus metus aliquam. Arcu dui vivamus arcu felis bibendum ut. Euismod quis viverra nibh cras pulvinar mattis nunc. In dictum non consectetur a erat nam at lectus urna. Aliquet sagittis id consectetur purus ut faucibus pulvinar elementum integer. Nisl purus in mollis nunc. Vitae turpis massa sed elementum tempus egestas sed sed.

Metus vulputate eu scelerisque felis imperdiet. Est velit egestas dui id ornare arcu odio ut. Dictum at tempor commodo ullamcorper a lacus vestibulum sed. Urna molestie at elementum eu facilisis sed odio morbi quis. Elementum nisi quis eleifend quam adipiscing. Eu nisl nunc mi ipsum faucibus vitae aliquet nec ullamcorper. Felis donec et odio pellentesque diam volutpat commodo. Quisque non tellus orci ac. Vel turpis nunc eget lorem dolor sed viverra ipsum nunc. Purus ut faucibus pulvinar elementum integer enim neque. Vivamus arcu felis bibendum ut tristique. Proin libero nunc consequat interdum varius sit amet mattis. Tincidunt augue interdum velit euismod in pellentesque. Sed risus ultricies tristique nulla aliquet. Id aliquet lectus proin nibh nisl condimentum id venenatis. Gravida rutrum quisque non tellus orci ac. Et malesuada fames ac turpis egestas maecenas.

Vestibulum lorem sed risus ultricies. Vulputate enim nulla aliquet porttitor lacus luctus accumsan. Iaculis at erat pellentesque adipiscing commodo. Massa ultricies mi quis hendrerit. Nulla facilisi etiam dignissim diam quis. Fringilla phasellus faucibus scelerisque eleifend donec pretium vulputate sapien. Nisl nunc mi ipsum faucibus vitae. Duis ut diam quam nulla porttitor massa id. Ultrices tincidunt arcu non sodales neque sodales. Id aliquet lectus proin nibh nisl. Risus pretium quam vulputate dignissim suspendisse in est ante.

Elit scelerisque mauris pellentesque pulvinar pellentesque habitant morbi tristique. Iaculis eu non diam phasellus vestibulum. Eget nullam non nisi est sit amet. Eget arcu dictum varius duis at consectetur lorem donec. Morbi tristique senectus et netus et malesuada. Malesuada pellentesque elit eget gravida cum. Non arcu risus quis varius quam quisque id. Lorem dolor sed viverra ipsum nunc aliquet bibendum enim. Urna neque viverra justo nec ultrices dui. Odio pellentesque diam volutpat commodo sed. Feugiat nibh sed pulvinar proin gravida hendrerit. Quis auctor elit sed vulputate mi sit amet mauris. Blandit turpis cursus in hac habitasse platea dictumst quisque. Egestas integer eget aliquet nibh praesent tristique magna.       </p>
    </div>
    <?php
}


function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function do_check_out_totals($subtotal){
    $tax_rate = .07;
    echo "<td colspan ='4'>subtotal</td><td>".$subtotal."</td></tr>";
    $tax = number_format($subtotal * $tax_rate,2);
    echo "<td colspan ='4'>tax</td><td>".$tax."</td></tr>";
    $total = number_format($subtotal + $tax,2);
    echo "<td colspan ='4'>total</td><td>".$total;
    
}
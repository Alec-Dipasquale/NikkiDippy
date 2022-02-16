<?php
function do_html_header($title, $header, $description) {
    ?>
    <html>
        <head>
        <title><?php echo $title;?></title>
            <link href="style.css" rel="stylesheet">
        </head>
        <body>
            <div class = "div_main_title">
                <h class = "main_title">Nikki Dippi</h>
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
                    echo '<a href="playground.php">Playground</a>';
                }
                echo '<a href="logout.php">Log Out</a>';
                } 
                else{
                    echo '<a href="login.php">Log In</a>';
                    echo '<a href="register.php">Register</a>';
                }
                ?>
            </div>
            <div class="page_title">
                <h1><?php echo $header; ?></h1>
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
    echo '<div class= "results">';
    echo "<p>Number of products found: ".$num_results."</p>";
    echo '<form method="post" action="catalog.php">
            <input style="width:100%;" type="submit" name="show_all" value = "Full Catalog"/></form>';
    echo '</div>';
    echo '<div class= "results">';
    echo "<form method='post' action='catalog.php'>
                    <input type='text' name='searchterm' />
                    <input type='submit' name='search' value = 'search'/>
                </form>";
    echo '</div>';
    
    $db->close();
}

function do_catalog_products($result){
    $num_results = $result->num_rows;

    echo '<div class= "outer_table_style"><div class= "table_style">';
    echo '<p>';
    echo '<table style="">';
    $count = 0;
    for ($i=0; $i <($num_results/3); $i++) {
        echo '<tr>';
        for($j=0; $j <3; $j++){
            $count++;
            if($count > $num_results){
                break;
            }
            $row = $result->fetch_assoc();
            do_catalog_card($row);
        }
        echo '</tr>';
    }
    echo'</table></p></div></div>';
}

function do_catalog_card($product_info){
    ?>
    <td>
        <div class="card">
            <h1>
            <?php echo htmlspecialchars(stripslashes($product_info["name"]))?>
            </h1>
            <img src="data:image/jpg;base64,<?php echo base64_encode( $product_info['img'] )?>"/>
            <p>
            Price: $ <?php echo htmlspecialchars(stripslashes($product_info["price"])) ?>
            </p>
            <p>
            In Stock: 
            <?php echo htmlspecialchars(stripslashes($product_info["quantity"])) ?>
            </p>
            </p>
            <form action="product_page.php" method="post">
            <input type = "hidden" name = "product_id" value = "<?php echo  htmlspecialchars(stripslashes($product_info['product_id']))?>" />
                <p>
                    <button type="submit">See Product</button>
                </p>
            </form>
        </div>
    </td>
            <?php
}

function do_about_me(){
    ?>
    <div class="about_me">
        <h1>About me!</h1>
        <p>
        Hello! My name is Elliot Smith. As a born and raised New Yorker, I take food quite seriously. In fact, I based my entire graphic design career around it! I have worked for a variety of restaurants and franchises to create logos, brochures, websites, menus, product labels and countless other deliverables. As someone who also completed culinary school, I can promise you I know what good food looks like. As someone who has a graphic design background, I can also promise you that I know how to market it.

My interests outside of graphic design and food culture include listening to classical music, writing poetry and riding my road bike. I am eager to work with up-and-coming food brands, although I certainly enjoy designing for well-established companies too.

Want to learn more? Fill out the contact form below! I would love to learn about your brand's needs and find a way I can help.
        </p>
    </div>
    <?php
}



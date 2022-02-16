<?php
session_start();
require_once('Nikki_fns.php');
  if($_SESSION['logged'] == false){
        header("Location: login_page.html");
    }
    if($_SESSION['type'] != 'Owner' && $_SESSION['type'] != 'Manager'){
        header("Location: main_page.html");
    }
    ?>
<html>
<head>
  <title>Nikki Dippy insert product</title>
</head>
<body>
<h1>Nikki Dippy insert product</h1>
<?php
    
  if(count($_FILES)>0){
  $product_name=$_POST['product_name'];
  $product_description=$_POST['product_description'];
  $price=$_POST['price'];
  $quantity=$_POST['quantity'];
  $name = $_FILES['image_file']['name'];
  $type = $_FILES['image_file']['type'];
  $data = file_get_contents($_FILES['image_file']['tmp_name']);

  
  if (!$product_name || !$product_description || !$quantity || !$price || !$data) {
     echo "You have not entered all the required details.<br />"
          ."Please go back and try again.";
     exit;
  }

  if (!get_magic_quotes_gpc()) {
    $product_name = addslashes($product_name);
    $product_description = addslashes($product_description);
    $price = addslashes($price);
    $quantity = addslashes($quantity);
    $data =addslashes($data);
    if(!empty($data)) {
            $image_base64 = base64_encode(file_get_contents($_FILES['image_file']['tmp_name']) );
    }else {
        echo 'file empty';
    }
    $image = 'data:image/;base64,'.$image_base64;
  }

  $format_price = number_format($price,2);
  $query = "insert into products values
            (NULL, '".$product_name."', '".$product_description."', '".$format_price."','".$quantity."', 0, 0, '".$data."')";
  $result = $db->query($query);
  if ($result) {
      echo  $db->affected_rows." product inserted into database.";
  } else {
  	  echo "An error has occurred #2.  The item was not added.";
  }

  $db->close();
  } else{
  	  echo "An error has occurred #1.  The item was not added.";
  }
?>
</body>
</html>

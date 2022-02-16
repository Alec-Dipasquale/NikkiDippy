<?php
session_start();
require_once('Nikki_fns.php');
  if($_SESSION['logged'] == false){
        header("Location: login_page.html");
        exit;
    }
    if($_SESSION['type'] != 'Owner'){
        header("Location: main_page.html");
        exit;
    }
    ?>
    <html>
<head>
  <title>Nikki Dippy's Designs - Deleted</title>
</head>
<body>
<h1>Nikki Dippy's Designs - Deleted</h1>
<?php
  $delete_type=$_POST['delete_type'];
  $delete_term=trim($_POST['delete_term']);

  if (!$delete_type || !$delete_term) {
     echo 'You have not entered search details.  Please go back and try again.';
     exit;
  }

  if (!get_magic_quotes_gpc()){
    $delete_type = addslashes($delete_type);
    $delete_term = addslashes($delete_term);
  }

  @     $db = new mysqli('localhost','hulberb2_charley_smith','charleysmith12345','hulberb2_Users_Fall20_Sec1');

    
      if (mysqli_connect_errno()) {
         echo 'Error: Could not connect to database.  Please try again later.';
         exit;
      }

  $query = "delete from products where ".$delete_type." = '".$delete_term."'";
  $result = $db->query($query);

  $num_results = $db->affected_rows;
  
  if($num_results == 0){
    echo "<p>Error deleting product, check spelling!</p>";
  } else{
    echo "<p>Number of products deleted: ".$num_results."</p>";

  }

  $db->close();

?>
</body>
</html>

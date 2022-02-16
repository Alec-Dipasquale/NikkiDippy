<?php
session_start();
require_once('Nikki_fns.php');

  $username=$_POST['username'];
  $password=$_POST['password'];
  $confirm_password=$_POST['confirm_password'];
  try   {
   

    // passwords not the same
    if ($password != $confirm_password) {
      throw new Exception('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($password) < 6) || (strlen($password) > 16)) {
      throw new Exception('Your password must be between 6 and 16 characters Please go back and try again.');
    }
  }catch (Exception $e) {
     echo $e->getMessage();
     exit;
  }
  
    $query = "select username from user_type where username = '".$username."'";
    $result = $db->query($query);
    
    
    if($result){
     echo 'Username already exists';
     exit;
    }
    
    $query_insert = "insert into user_types values ('".$username."', '".$password."', 'User')";
    $result_insert = $db->query($query_insert);
    if($result_insert){
        echo '<script>alert("Successfully registered.")</script>';
        header("Location: index.php");
    } else{
      echo '<script>alert("Successfully registered.")</script>';
      header("Location: register.html");
    }
    
    
    

?>
<?php
session_start();
require_once('Nikki_fns.php');
$db = db_connect();


    $username=$_POST['username'];  
    $password=$_POST['password'];
    
    if (!$username || !$password) {     
        echo 'You have not entered credentials.';     
    exit;  
} 
    
    //protect sql injections
    $username  = stripslashes($username);    
    $password = stripslashes($password);
    
    //$password = md5($password);
    
    $query = "SELECT user_type FROM user_types WHERE username = '".$username."' and password = '".$password."'";
    $result = $db->query($query);
    if (!$result) {
        throw new Exception('Could not execute query');
    }
    $row = $result->num_rows;

    $type = $result->fetch_object();
    if($row == 1){
        
        $_SESSION["logged"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["type"] = $type->user_type;


        header("Location: index.php");

    }
    else {
 
        echo "Failure to login!";

    }
    
    $result->free();    
    $db->close();

?>
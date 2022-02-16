<?php
function loggedIn(){
     if($_SESSION['logged'] == false){
         header("Location: login_page.html");
     }
}
?>
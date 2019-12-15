<?php
if (isset($_COOKIE['UserId'])){
   setcookie('UserId','');
   header("Location:login.php");
} else{
    header("Location:login.php");
}
?>

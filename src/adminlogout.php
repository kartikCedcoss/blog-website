<?php
session_start();

    unset($_SESSION['admin']);
    unset($_SESSION['adminname']);
    unset($_SESSION['adminrole']);
    header("Location: adminlogin.php");
    exit();
  

?>
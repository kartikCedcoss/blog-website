<?php
session_start();
$servername = "mysql-server";
$username = "root";
$password = "secret";
$blogdb="db_blog";

 if(isset($_POST['reguser'])){
     $name = $_POST['name'];
     $email = $_POST['useremail'];
     $pass =  $_POST['userpass'];

     try {
    $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM usertable where email = '$email'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    

      if($result){
        $_SESSION['exist'] = true;
       header("Location:userreg.php"); 
     }



    else{
      try {
     $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     $sql = " INSERT INTO usertable ( userid, username, email, passw, userstatus, userrole) 
     VALUES (Null,'$name ','$email','$pass','pending','user')";
     $stmt = $conn->prepare($sql);
     $stmt->execute();
     header("Location: userlogin.php");
     exit();
    
     } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
     }
     $conn = null;
      }
}
catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
 }


 if(isset($_POST['regadmin'])){
     
    $name = $_POST['adname'];
    $email = $_POST['ademail'];
    $pass =  $_POST['adpass'];

try {
   $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   $sql = " INSERT INTO usertable ( userid, username, email, passw, userstatus, userrole) 
   VALUES (Null,'$name ','$email','$pass','pending','admin')";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   header("Location: adminlogin.php");
   exit();
   
 } catch(PDOException $e) {
   echo "Error: " . $e->getMessage();
 }
 $conn = null;


}


?>
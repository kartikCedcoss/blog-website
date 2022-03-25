<?php

session_start();

if(!isset($_SESSION['admin'])){

  
  header("location:adminlogin.php");
  echo '<div class="alert alert-danger" role="alert">
    Please Login First
    </div>';
  exit();

}

if(isset($_POST['signout'])){
 include 'adminlogout.php';
}

if(isset($_POST['filter'])){
   echo $_POST['filter'];
}


$servername = "mysql-server";
$username = "root";
$password = "secret";
$cartdb="db_blog";

if(isset($_POST['changestatus'])){
   echo $statusid;
    $statusid = $_POST['changestatus'];

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT userstatus FROM usertable WHERE userid = '$statusid' ");
      $stmt->execute();
    
      
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      foreach($stmt->fetchAll() as $k=>$v) {
        if($v['userstatus']=="pending"){
          try {
               $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
                 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                 $sql = "UPDATE `usertable` SET `userstatus` = 'approved' WHERE `usertable`.`userid` = '$statusid'";
                 $stmt = $conn->prepare($sql);
                $stmt->execute();
               
                
             } catch(PDOException $e) {
                 echo "Error: " . $e->getMessage();
               }
               $conn = null;
               //displayusers();
        }
     else{
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
          $sql = "UPDATE `usertable` SET `userstatus` = 'pending' WHERE `usertable`.`userid` = '$statusid'";
          $stmt = $conn->prepare($sql);
         $stmt->execute();
        
         
      } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;

     }
    }
    } 
    
    catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
    $conn = null;
  
}

if(isset($_POST['deleteuser'])){
   
    $deleteid = $_POST['deleteuser'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = " DELETE FROM `usertable` WHERE `usertable`.`userid` = '$deleteid'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      
      }

     
      if(isset($_POST['adduser'])){
      
        $uname = $_POST['newuname'];
        $uemail = $_POST['newuemail'];
        $upass =  $_POST['newupass'];
        $ustatus = $_POST['newustatus'];
        $urole = $_POST['newurole'];
    
    try {
       $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
       $sql = " INSERT INTO usertable ( userid, username, email, passw, userstatus, userrole) 
       VALUES (Null,'$uname ','$uemail','$upass','$ustatus','$urole')";
       $stmt = $conn->prepare($sql);
       $stmt->execute();
       
       
     } catch(PDOException $e) {
       echo "Error: " . $e->getMessage();
     }
     $conn = null;
     
    
    }



function recentusers(){

  $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $newdb="db_blog";
    $numberpage2 = 10;
    $page = $_GET['startd'];
    $startd = $page * $numberpage2;
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM `usertable` WHERE userid NOT IN (SELECT MIN(userid) FROM usertable) ORDER BY userid DESC LIMIT 3   ");
        $stmt->execute();
      
        
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo '<h2>RECENT Users</h2>
        <div class="table-responsive" id="recentuser" >
          <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">USER ID</th>
            <th scope="col">USER NAME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">PASSWORD</th>
            <th scope="col">ROLE</th>
            <th scope="col">STATUS</th>
          </tr>
        </thead>
        <tbody>
          <tr>';
        foreach($stmt->fetchAll() as $k=>$v) {
       
          echo '<td>'.$v["userid"].'</td>
              <td>'.$v["username"].'</td>
              <td>'.$v["email"].'</td>
              <td>'.$v["passw"].'</td>
              <td>'.$v["userrole"].'</td>
              <td>'.$v["userstatus"].'</td>
             
              <td><button class="btn btn-primary" type="submit" value="'.$v["userid"].'" name="changestatus" >Change Status</button></td>
              <td><button class="btn btn-danger" type="submit" value="'.$v["userid"].'" name="deleteuser" >Delete</button></td></tr>


            </tr>';   

        }
      
      } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      $conn = null;
      echo "</tbody></table>";


}
 




?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Admin Page</title>
    <link rel="stylesheet" href="dashboard.css">
      <link rel="stylesheet" href="dashboard.rtl.css">


    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    

    <!-- Bootstrap core CSS -->
<link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Admin Panel</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <form action=""m method="POST">
    <div class="nav-item text-nowrap">

<?php
 if(isset($_SESSION['admin'])){
 echo '<button class="nav-link px-3 btn"  name="signout" >Sign out</button>';
 }
 else{
    echo '<a class="nav-link px-3 btn" href="adminlogin.php">Sign In</a>';
 }
 ?>
</div>
    </form>
   
  </div>
</header>

<div class="container-fluid">
  <form method="POST" action="">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="dashboard.php">
              <span data-feather="home"></span>
              Dashboard
            </>
          </li>
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="admindash.php">
              <span data-feather="user"></span>
              All Users
          </a>
          </li>
          
          <li class="nav-item">
            <a type="submit" class="nav-link  " href="adminblog.php"  >
              <span data-feather="file"></span>
              My Blog
    </a>
          </li>
          <li class="nav-item">
            <a class="nav-link "  href="allusers.php">
              <span data-feather="users"></span>
             All User's Blog
    </a>
          </li>
          
          <li class="nav-item">
          <a class="nav-link "  href="adminpost.php">
              <span data-feather="document"></span>
              New Post
    </a>
          </li>
          <li class="nav-item">
            
          </li>
        </ul>

        
        <ul class="nav flex-column mb-2">
         
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          
    
          
        </div>
      </div>
    
     <div id="recentusers" >   <?php
       
       recentusers();

      ?></div> </form>
     <form method="POST" action="adminreadblog.php"  > 
     <div><h2>Recent Blogs</h2>
      <div class="container-fluid mt-1 mb-3">
        <div class="row justify-content-center">


        <?php

$servername = "mysql-server";
$username = "root";
$password = "secret";
$blogdb="db_blog";
$userid = $_SESSION['user'];
$numberpage2 = 8;
$page = $_GET['start'];
$start = $page * $numberpage2;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM `tb_blog` WHERE userid NOT IN ('$userid')  ORDER BY blogid DESC LIMIT 4");
  $stmt->execute();

  
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach($stmt->fetchAll() as $k=>$v) {

         
   echo   ' <div class="col-3 mt-4">
          <div class="card" style="width: 15rem;" >
        <img src="images/'.$v['blogimage'].'" class="card-img-top" alt="...">
         <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text">'.$v['blog'].'</p>
        </div>
     
        <div class="card-body">
        <button type="submit"  class="card-link btn btn-outline-primary border-0 " value="'.$v['blogid'].'"  name="editblog" >Edit</button>
        <button type="submit"  class="card-link btn btn-outline-danger border-0 "  value="'.$v['blogid'].'" name="deleteblog" >Delete</button>
       <button  type="submit" class="card-link btn btn-outline-success border-0 mt-2 "  value="'.$v['blogid'].'" name="readblog" >Read More..</button>
       </div>
       </div>

            </div>';
            
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        $conn = null;


    ?>
      </div>
    </div></div>
      
        

        

     </form>
      </div>
      
    </main>
  </div>
</div>

<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="myscript.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>

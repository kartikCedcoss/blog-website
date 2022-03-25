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

     



function displayusers(){

  $servername = "mysql-server";
    $username = "root";
    $password = "secret";
    $newdb="db_blog";
    $numberpage2 = 10;
    $page = $_GET['startu'];
    $startu = $page * $numberpage2;
    
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM `usertable` WHERE userid NOT IN (SELECT MIN(userid) FROM usertable) ORDER BY userid LIMIT $startu,$numberpage2 ");
        $stmt->execute();
      
        
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo '
        <div class="table-responsive" id="recentuser" >
          <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th scope="col">USER ID</th>
            <th scope="col">USER NAME</th>
            
          </tr>
        </thead>
        <tbody>
          <tr>';
        foreach($stmt->fetchAll() as $k=>$v) {
       
          echo '<form method="POST" action="allusersfunction.php" ><td>'.$v["userid"].'</td>
              <td>'.$v["username"].'</td>
              
              
              
              <td><button class="btn btn-primary" type="submit" value="'.$v["userid"].'" name="viewblog" >View Blog</button></td>
            
              


            </tr></form>';   

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
  </div>
</header>

<div class="container-fluid">
  <form method="POST" action="allusersfunction.php">
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
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>
    
     
      
        <?php
       
         displayusers();
         
    
        ?>
            
        </table>

        

     </form>
      </div>

      <div class="container text-center mt-5" style="margin-left: 30em;">
     <nav aria-label="...">
       <ul class="pagination ">
     <?php
     
     $numberpage2 =10;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT COUNT( userid ) FROM usertable ");
            $stmt->execute();
             $result = $stmt->fetch();
            $numrecord = $result[0];
            $numlinks = ceil($numrecord/$numberpage2);
            
          } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
          $conn = null;
          echo '<li class="page-item">
          <a class="page-link"  href="allusers.php?startu='.($j-1).'" tabindex="-1">pre</a>
        </li>';
         for($i =0; $i<$numlinks;$i++){
             $y = $i+1;
             $j=$y;
             echo  '<li class="page-item"><a class="page-link" href="allusers.php?startu='.$i.'">'.$y.'</a></li>';
         }
         echo '<li class="page-item">
         <a class="page-link"  href="allusers.php?startu='.($j+1).'" tabindex="-1">next</a>
       </li>';
     
     
     ?>

      
      
     
      </ul>
       </nav>

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

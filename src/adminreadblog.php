<?php
session_start();

// if(isset($_POST['signout'])){
//   session_destroy();
//   header("location:userlogin.php");
//   exit();
// }

 



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Read Edit </title>
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
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">BLOGGERS</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
     
    <div class="nav-item text-nowrap">

    
     <a class="nav-link px-3 "  name="signout" >Sign out</a>'
     
     
   
  </div>
</header>

<div class="container-fluid">
 
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
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
     <form method="POST" action=""> 
      <div class="container-fluid mt-1 ">
        <div class="row justify-content-center">
            
           
<?php



$servername = "mysql-server";
$username = "root";
$password = "secret";
$blogdb="db_blog";

$userid = $_SESSION['user'];

$editid = $_POST['editblog'];
  $deleteid = $_POST['deleteblog'] ;



 
if(isset($_POST['editblog'])){
   
    
 try {
   $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $stmt = $conn->prepare("SELECT * FROM `tb_blog` WHERE blogid = $editid");
   $stmt->execute();

  
   $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
   foreach($stmt->fetchAll() as $k=>$v) {

         
    echo   ' <div class=" mt-4">
           <div class="card w-75"  >
           <div class="mb-4">
           <label for="formFile" class="form-label">Select an image</label>
           <input type="hidden" value="'.$v['blogid'].'" name="updateid"  >
           <input class="form-control" type="text"  name="editimage" value="'.$v['blogimage'].'" >
           </div>
          <div class="card-body">
         <h5 class="card-title"><input type="text" class="form-control" value="'.$v['blog'].'" name="edittitle"  ></h5>
         <textarea rows="5" class="form-control card-text" name=" editdesc" >'.$v['details'].'</textarea>                           
         </div>
     
         <div class="card-body">
      
        <button type="submit"  class="card-link btn btn-outline-warning" name="updateblog" >Update</button>
       
        </div>
        </div>
            </div>';
            
           }

          
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
         $conn = null;
       

    }
  $flag = 0;
    if(isset($_POST['deleteblog'])){
        $flag =1;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("DELETE FROM `tb_blog` WHERE `tb_blog`.`blogid` = '$deleteid' ");
            $stmt->execute();
          
           
            echo '<div class="alert alert-danger" role="alert">
            Deleted Succesfully
            </div>';
               
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
          }
           $conn = null;  
           
    }
   



    if(isset($_POST['updateblog'])){
           
    $editimage = $_POST['editimage'];
    $edittitle = $_POST['edittitle'];
    $editdesc =$_POST['editdesc'];
    $updateid = $_POST['updateid'];
    
     try {
        $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE tb_blog SET blog = '$edittitle', details ='$editdesc' ,blogimage ='$editimage ' WHERE blogid='$updateid'    ");
        $stmt->execute();
     
       
        echo '<div class="alert alert-success" role="alert">
      Blog Edit Succesfully
        </div>';
        
           
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
       $conn = null;  
     
    }  


    ?>
        </div>
    </div> 
    <h2>All Blogs</h2>
      <div class="container-fluid mt-1 mb-3">
        <div class="row justify-content-center">


        <?php

$servername = "mysql-server";
$username = "root";
$password = "secret";
$blogdb="db_blog";
$userid = $_SESSION['user'];

if(isset($_POST['readblog'])){

$readid = $_POST['readblog'];


    try {
        $conn = new PDO("mysql:host=$servername;dbname=$blogdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM `tb_blog` WHERE blogid = '$readid'");
        $stmt->execute();
     
       
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($stmt->fetchAll() as $k=>$v) {
     
              
         echo   ' <div class=" mt-4">
                <div class="card w-100"  >
                <div class="mb-4">
                <img src="images/'.$v['blogimage'].'" class="card-img-top w-50 " alt="..."   >
                </div>
               <div class="card-body">
              <h5 class="card-title">'.$v['blog'].'</h5>
                                       
              </div>
          
              <div class="card-body">
           
              <p  class="card-text"  >'.$v['details'].'</p>  
            
             </div>
             </div>
                 </div>';
                 
                }
     
               
             } catch(PDOException $e) {
               echo "Error: " . $e->getMessage();
             }
              $conn = null;
            
}

    ?>
        </div>
    </div>
      <?php
       
       ?>
     </form>
      </div >
    </main>
  </div>
</div>


<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <script src="myscript.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>

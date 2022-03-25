<?php
session_start();

$servername = "mysql-server";
$username = "root";
$password = "secret";
$cartdb="db_blog";

if(isset($_POST['btnpost'])){
   $title = $_POST['title'];
   $desc = $_POST['description'];
   $image = $_POST['image'];
   $userid = $_SESSION['user'];
   $userrole = $_SESSION['userrole'];
    
   try {
     $conn = new PDO("mysql:host=$servername;dbname=$cartdb", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     $sql = " INSERT INTO `tb_blog`(`blogid`, `userid`, `userrole`, `blog`, `details`, `blogimage`) 
     VALUES (null,'$userid','$userrole','$title','$desc','$image')";
     $stmt = $conn->prepare($sql);
     $stmt->execute();
     header("Location: index.php");
     exit();
    
   } catch(PDOException $e) {
     echo "Error: " . $e->getMessage();
   }
   $conn = null;
   
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
</div>

<div class="bg-image" 
     style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg');
            height: 100vh">
            <div class="container">
<div class="mt-3" ><a type="submit" class="nav-link mt-5  " href="index.php"  >
              <span data-feather="home"></span>
             <h4>Home</h4> 
    </a></div>

	<div class="row">
	    
	    <div class="col-md-8 col-md-offset-2">
	        
    		<h1>Create post</h1>
    		
    		<form action="" method="POST">
    		    
    		   
    		    
    		    <div class="form-group">
    		        <label for="title">Title <span class="require">*</span></label>
    		        <input type="text" class="form-control" name="title" />
    		    </div>
    		    
    		    <div class="form-group">
    		        <label for="description">Description</label>
    		        <textarea rows="5" class="form-control" name="description" ></textarea>
    		    </div>

    		    <div class="mb-4">
           <label for="formFile" class="form-label">Select an image</label>
           <input class="form-control" type="file" id="formFile" name="image">
           </div>
    		   
    		    
    		    <div class="form-group mt-3" >
    		        <button type="submit" class="btn btn-primary" name="btnpost">
    		          POST BLOG
    		        </button>
    		        
    		    </div>
    		    
    		</form>
		</div>
		
	</div>
</div>
</div>


</body>
</html>

 

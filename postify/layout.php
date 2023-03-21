<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@700&family=Roboto:wght@100;300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../bootstrap-file/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap-file/css/form.css">


  <link rel="stylesheet" href="../bootstrap-file/css/all.min.css">
  <link rel="icon" href="../media/logo/icon.png" type="image/x-icon" />
  <title><?= $pageTitle ?></title>

  <!--  pupups -->


  <link rel="stylesheet" href="../bootstrap-file/css/chang_profile.css">
  <link rel="stylesheet" href="../bootstrap-file/css/welcome.css">
  <!-- <link rel="stylesheet" href="../bootstrap-file/css/user_profile.css"> -->
  
  <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

  


</head>

<body>



  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Postify</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

          <?php

          if (isset($_SESSION['email'])) :
            echo ' <li class="nav-item"> 
    <a class="nav-link" href="./welcom.php">Home</a>
   </li> 
   <li class="nav-item"> 
    <a class="nav-link" href="./profile.php">Profile</a>
   </li> 
     <li class="nav-item">
      <a class="nav-link" href="./logout.php">Log Out</a>
    </li>';
          else :
            echo '<li class="nav-item">
      <a class="nav-link active" aria-current="page" href="#">Home</a>
    </li>
     <li class="nav-item">
       <a class="nav-link" href="./login.php">Login</a>
      </li>
         <li class="nav-item">
          <a class="nav-link" href="./signup.php">Sign up</a>
        </li>';
          endif ?>
    </ul>

      </div>
    </div>
  </nav>

  


    <!-- Modal HTML  popup form-->




    <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal">Upload File</a> -->








    <!-- <div id="myModal" class="modal fade" style="display: none;">
      <div class="modal-dialog modal-login">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"> Change Image</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
              <label class="form-label" for="profile">Profile Pictue</label>
                <input type="file" name="profile" class="form-control" id="profile">
              </div>
              
              <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block btn-lg" value="change">
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <a href="./profile.php">Postify</a>
          </div>
        </div>
      </div>
    </div>

  </div> -->

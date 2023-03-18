<?php

session_start();

$email = $_SESSION['email'];
$id = $_SESSION['id'];

if (isset($_SESSION['email'])) :

    $pageTitle = "Profile";
    include './layout.php';

    include_once('../db/conn.php');


    if (empty($_FILES['profile']['name'])) {
        $errors[] = 'photo is requared';
    }



    if (!isset($errors)) {

        $file_name = $_FILES['profile']['name'];
        $file_tmp_name = $_FILES['profile']['tmp_name'];
        $file_size = $_FILES['profile']['size'];
        $file_error = $_FILES['profile']['error'];
        $file = explode('.', $file_name); //bach tfr9
        $file_accepte = strtolower(end($file));
        $allowed = array('png', 'jpg', 'svg', 'jpge');
        if (in_array($file_accepte, $allowed)) {
            if ($file_error === 0) {
                if ($file_size < 4000000) {
                    $image_new_name = uniqid("", true) . "-" . $file_name;
                    $target = '../media/profile_img/' . $image_new_name;
                    $sql = " UPDATE users  SET profile = '$image_new_name' WHERE email = '$email'";
                    if (!empty($file_name)) {
                        mysqli_query($conn, $sql);
                        if (move_uploaded_file($file_tmp_name, $target)); // to save file in target location
                        header('location:./profile.php');
                    }
                } else {
                    $errors[] = ' image size is too big';
                }
            }
        }
    }

    // to get the updated data from database
    $user_profile = mysqli_query($conn, "SELECT * FROM users WHERE  email='$email'  ");
    while ($data = mysqli_fetch_array($user_profile)) :
        $id_for_post = $data['id'];
        $post_number_result = mysqli_query($conn, "SELECT COUNT(*) FROM post WHERE user_id='$id_for_post'");
        $post_number_array = mysqli_fetch_array($post_number_result);
        $post_number = $post_number_array[0];



?>


        <html>

        <head>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width">
            <link rel="stylesheet" href="../bootstrap-file/css/profile.css">
        </head>
        <style>
            .model-popup .modal-dialog {
                max-width: 62%;
            }

            .model-popup .modal-body {
                padding: 0;
                background-color: #f2f2f2;
            }

            .model-popup .modal-body .row {
                margin-right: 0;
                padding-right: 0;

            }

            .model-popup .modal-body img {
                max-width: 100%;
                height: auto;
            }

            .model-popup .modal-body .modal-body-content {
                background-color: #f2f2f2;
                padding-right: 01px;

                height: auto;
            }

            .model-popup .modal-body form input {
                background-color: #f2f2f2;

                border: unset;

            }

            .model-popup .modal-body form input[type=text]:active {
                box-shadow: none;

                border: unset;
            }

            .model-popup .modal-body form input[type=text]:focus {
                box-shadow: none;

                border: unset;
            }

            .model-popup .modal-body form input[type=submit]:hover {
                color: black;
                font-weight: bold;

            }

            .model-popup .modal-body form input[type=submit] {
                color: blueviolet;
                font-weight: lighter;



            }
        </style>

        <body>
            <!-- popup form -->
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Change Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="profile">Profile Pictue</label>
                                    <input type="file" name="profile" class="form-control" id="profile">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="container-fluid">
                <div class="row">
                    <div class=" col-sm-4 col-4 w-25 h-100 d-none  d-md-block ">
                        <div class="aside d-flex flex-column  border-end flex-shrink-0 p-3 " style="width: 280px; height:90vh;  position: fixed; ">

                            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                                <svg class="bi me-2" width="40" height="32">
                                    <use xlink:href="#bootstrap"></use>
                                </svg>
                                <span class="fs-4">Postify</span>
                            </a>
                            <hr>
                            <ul class="nav nav-pills flex-column mb-auto">
                                <li class="nav-item">
                                    <a href="#" class="nav-link active" aria-current="page">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#home"></use>
                                        </svg>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link link-dark">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#speedometer2"></use>
                                        </svg>
                                        Export
                                    </a>
                                </li>

                                <li>
                                    <a href="#" class="nav-link link-dark">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#grid"></use>
                                        </svg>
                                        Create
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link link-dark" href="./logout.php">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#people-circle"></use>
                                        </svg>
                                        Log Out
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="nav-link link-dark">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#table"></use>
                                        </svg>
                                        Orders
                                    </a>
                                </li>
                            </ul>
                            <hr>
                            <div class="dropdown d-flex align-items-end">
                                <a href="#" class=" link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">

                                    <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="32" height="32" class="rounded-circle me-2">
                                    <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>
                                </a>
                                <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                                    <li><a class="dropdown-item" href="#">New post</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-8 w-75">
                        <div class="row  " style="margin-top:10vh ; margin-bottom:14vh;height: 30vh;">
                            <div class="col-4 text-center  " id="change profile">
                                <!-- Button HTML (to Trigger Modal) -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#uploadModal">

                                    <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="150" height="150" class="rounded-circle me-2">
                                </a>

                            </div>
                            <div class="col-8 ps-4">
                                <span class="fs-4 pe-3"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?></span>
                                <button type="button" class="btn btn-dark">Edit profile</button>
                                <div class="pt-4">
                                    <span class="fs-5 pe-3">post <?php echo $post_number ?></span>
                                    <span class="fs-5 pe-3">Like 15</span>

                                </div>
                                <div class="pt-4">
                                    <ul>
                                        <li>
                                            Name: <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'] ?>
                                        </li>
                                        <li>
                                            Email: <?php echo $_SESSION['email'] ?>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <hr style="width:90%;margin-top:3vh ">

                        </div>

                        <main>
                            <div class="album ">
                                <div class="container">
                                    <div class="row justify-content-start  ">
                                        <?php
                                        $id_for_post = $data['id'];

                                        $user_post = mysqli_query($conn, "SELECT *  FROM post WHERE  user_id='$id_for_post' ORDER BY create_at desc   ");

                                        // this condition check if there no post 
                                        if ($count = mysqli_num_rows($user_post) < 1) :
                                            echo "<div class='display-2 text-center fw-bold'>No Post</div>";
                                        else :
                                            while ($post = mysqli_fetch_array($user_post)) :
                                                $post_user_id = $post['user_id'];

                                                $user_info = mysqli_query($conn, "SELECT * FROM users WHERE  id='$post_user_id'   ");
                                                while ($user_post_from_db = mysqli_fetch_array($user_info)) :

                                        ?>








                                                    <div class="col-10 col-md-6 col-lg-4">
                                                        <div class="card" style="background-color: #f2f2f2; border: unset;">
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $post['post_id'] ?>">
                                                                <img src="../media/post_img/<?php echo $post['image'] ?>" class="bd-placeholder-img card-img-top" alt="" width="100%" height="273px" class="rounded-circle me-2">
                                                            </a>
                                                            <div class="card-body">
                                                                <p class="card-text"><?php echo $post['text'] ?></p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal model-popup fade" id="imageModal<?php echo $post['post_id'] ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $post['post_id'] ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-8 p-0">
                                                                            <img src="../media/post_img/<?php echo $post['image'] ?>" class="img-fluid" alt="">
                                                                        </div>
                                                                        <div class="col-md-4 p-0 modal-body-content  d-flex flex-column justify-content-between">

                                                                            <div class="row ms-2 mt-3">
                                                                                <div class=" col-6 text-start d-inline ">
                                                                                    <div class="profile-img d-flex align-items-end d-inline">


                                                                                        <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="64" height="64" class="rounded-circle me-2">
                                                                                        <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>


                                                                                    </div>

                                                                                </div>
                                                                                <!-- 3 point drop down -->
                                                                                <div class=" col-6 text-end d-inline ">

                                                                                    <div class="btn-group dropend">
                                                                                        <button type="button" class="border-0 fs-4" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                            <i class="fas fa-ellipsis"></i>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu">
                                                                                            <li><a class="dropdown-item text-danger" href="delete.php?id=<?php echo  $post['post_id'] ?>">Delelte</a></li>

                                                                                            <li><a class="dropdown-item" href="#">Share</a></li>
                                                                                            <li><a class="dropdown-item" href="#">Cancel</a></li>
                                                                                        </ul>
                                                                                    </div>


                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                                                                </div>

                                                                            </div>
                                                                            <hr>
                                                                            <!-- popup comment -->
                                                                            <div class="row ms-2 mt-3">
                                                                                <div class=" col-3 align-items-center text-start d-inline ">
                                                                                    <div class="profile-img d-flex align-items-end d-inline">
                                                                                        <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="72" height="72" class="rounded-circle me-2">
                                                                                    </div>

                                                                                </div>
                                                                                <div class="text-start mt-3  col-7 ">
                                                                                    <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>
                                                                                    <span class="d-block text-trance text-truncate " style="width:100%;"><?php echo $post['text'] ?></span>

                                                                                </div>
                                                                            </div>
                                                                            <div class="text-center mt-auto">
                                                                                <form method="post" action="">

                                                                                    <div class="input-group ms-0 ps-0  mb-3">
                                                                                        <input name="comment" type="text" class="form-control" placeholder="Add a comment..." aria-label="Recipient's username" aria-describedby="button-addon2">
                                                                                        <input class="btn btn-outline-secondary" value="Post" type="submit" id="button-addon2">
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>






                                                    <!-- delete modal -->
                                                    <!-- <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteLabel">delete Image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <h3 class="text-danger display-6 text-center "> Are you sure you want to delete</h3>
                            </div>
                            
                        </form>
                        <a href="delete.php?id=<?php echo  $post['post_id'] ?>" class="btn btn-danger">delete</a>
                    </div>
                </div>
            </div> -->


                                                <?php endwhile ?>
                                            <?php endwhile ?>
                                        <?php endif ?>

                                    </div>
                                </div>
                            </div>

                            <script>
                                const imageLinks = document.querySelectorAll("[data-bs-toggle='modal']");

                                imageLinks.forEach((link) => {
                                    link.addEventListener("click", (event) => {
                                        event.preventDefault();
                                        const modalTarget = link.getAttribute("data-bs-target");
                                        const modal = document.querySelector(modalTarget);
                                        const modalBody = modal.querySelector(".modal-body");
                                        const image = link.querySelector("img");

                                        // Remove old image from modal
                                        const oldImage = modalBody.querySelector("img");
                                        if (oldImage) {
                                            oldImage.remove();
                                        }

                                        // Create new image element
                                        const newImage = document.createElement("img");
                                        newImage.src = image.src;
                                        newImage.classList.add("img-fluid");

                                        // Add new image to modal
                                        modalBody.querySelector(".col-md-8").appendChild(newImage);

                                        // Show modal
                                        const modalInstance = new bootstrap.Modal(modal);
                                        modalInstance.show();
                                    });
                                });
                            </script>
                        </main>

                    </div>

                </div>



            </div>
        </body>

        </html>









    <?php
    endwhile;
else :
    $pageTitle = "Postify";
    include './layout.php'; ?>

    <h1 class='display-1 text-center mt-5 pt-5 '>Sorry! </h1>
    <h1 class='display-1 text-center mt-1 pt-1 '>You Need To<a class="nav-link d-inline link-primary" href="./login.php"> Login </a> </h1>

<?php endif ?>
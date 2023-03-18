<?php

session_start();
if (isset($_SESSION['email'])) :

    $email = $_SESSION['email'];
    $user_id = $_SESSION['id'];

    $pageTitle = "Postify";
    include './layout.php';
    include_once('../db/conn.php');





    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $text = mysqli_real_escape_string($conn, $_POST['text']); /*to prevent to be hacked*/


        $error = [];


        if (!$text) {
            $errors[] = 'first name is requared';
        }


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
                        $target = '../media/post_img/' . $image_new_name;
                        $time = date('Y-m-d H:i:s');
                        $sql = " INSERT INTO post (text,image,create_at,user_id) VALUES('$text','$image_new_name','$time','$user_id')";
                        if (!empty($file_name)) {
                            mysqli_query($conn, $sql);
                            if (move_uploaded_file($file_tmp_name, $target)); // to save file in target location
                            header('location:./welcom.php');
                        }
                    } else {
                        $errors[] = ' image size is too big';
                    }
                }
            }
        }
    }


    //to get the current time

    function getTimeDifference($datetime_str)
    {
        $given_time = strtotime($datetime_str);
        $current_time = time();

        $time_diff_seconds = abs($given_time - $current_time);
        if ($time_diff_seconds < 60) {
            $time_diff = $time_diff_seconds . " sec";
        } elseif ($time_diff_seconds < 3600) {
            $time_diff = round($time_diff_seconds / 60) . " min";
        } elseif ($time_diff_seconds < 86400) {
            $time_diff = round($time_diff_seconds / 3600) . " hour";
            if ($time_diff > 1) {
                $time_diff .= "s";
            }
        } else {
            $time_diff = round($time_diff_seconds / 86400) . " day";
            if ($time_diff > 1) {
                $time_diff .= "s";
            }
        }

        return   $time_diff;
    }

    // to apear the post  from data base

    $user_profile = mysqli_query($conn, "SELECT * FROM users WHERE  email='$email'  ");

    while ($data = mysqli_fetch_array($user_profile)) :

?>


        <html>

        <head>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width">
            <link rel="stylesheet" href="../bootstrap-file/css/profile.css">
        </head>

        <body>
            <!-- popup form -change profile -->
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
            <!-- popup form -create poste -->
            <div class="modal fade" id="Create_Post" tabindex="-1" aria-labelledby="Create_PostLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="Create_PostLabel">Create Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="profile">Profile Pictue</label>
                                    <input type="file" name="profile" class="form-control" id="profile">
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label" for="text">Description</label>
                                    <input type="text" name="text" class="form-control" id="text">
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
                    <!-- aside bar -->
                    <div class=" col-sm-3 col-3 w-25 h-100 d-none  d-md-block ">
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
                                    <!-- Button HTML (to Trigger Modal) -->
                                    <a href="#" class="nav-link link-dark text-decoration-none " data-bs-toggle="modal" data-bs-target="#Create_Post">
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
                    
                    <!-- post_area -->
                    <div class="posts mt-5 pt-5 col-sm-4 col-md-6 col-12 w-50">
                        <main>
                            <div class="album ">
                                <div class="container">
                                    <!-- i use that while to showing data from data base -->
                                    <?php
                                    $user_post = mysqli_query($conn, "SELECT * FROM post ORDER BY create_at desc  ");
                                    while ($post = mysqli_fetch_array($user_post)) :
                                        $post_user_id = $post['user_id'];
                                           // to create a comment we need   user_id and post id 
                                        
                                        $user_info = mysqli_query($conn, "SELECT * FROM users WHERE  id='$post_user_id'   ");
                                        while ($user_post_from_db = mysqli_fetch_array($user_info)) : ?>

                                            <!-- 1 card posts -->
                                            <div class="row mother_card justify-content-center ">
                                                <div class="col-8 mb-4 ">
                                                    <div class="card " style=" background-color: #f2f2f2; border: unset; ">
                                                        <div class="card-head  d-flex justify-content-between align-items-center   " style="height:100px; padding:0 15px 0 15px; ">
                                                            <div>


                                                                <img src="../media/profile_img/<?php echo $user_post_from_db['profile'] ?>" alt="" width="64" height="64" class="rounded-circle me-2">
                                                                <strong><?php echo $user_post_from_db['fname'] . " " . $user_post_from_db['lname'] ?></strong>
                                                                <small class="text-muted"><i class="fa-solid fa-circle text-secondary " style="width: 6px; margin:0 5px 0 10px;"></i></small>
                                                                <small class="text-muted"><?php echo getTimeDifference($post['create_at']) . " "  ?></small>
                                                            </div>
                                                            <div class="dropdown d-flex align-items-end">

                                                                <a href="#" class=" link-dark text-decoration-none " id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="fa-solid fa-ellipsis fs-3"></i>
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
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $post['post_id'] ?>">

                                                            <img src="../media/post_img/<?php echo $post['image'] ?>" class="bd-placeholder-img card-img-top" alt="" width="100%" class="rounded-circle me-2">

                                                        </a>
                                                        <!-- card body -->
                                                        <div class="card-body">

                                                            <p class="card-text">
                                                                <?php echo $post['text'] ?>
                                                                .</p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                                                </div>
                                                                <small class="text-muted"><?php
                                                                                            echo getTimeDifference($post['create_at']) . " "  ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <!-- popup model -->
                                                        <div class="modal fade" id="imageModal<?php echo $post['post_id'] ?>" tabindex="-1" aria-labelledby="imageModalLabel<?php echo $post['post_id'] ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-8 p-0">
                                                                                <!-- image  -->
                                                                                <img src="../media/post_img/<?php echo $post['image'] ?>" class="img-fluid" alt="">
                                                                            </div>
                                                                            <!-- wihte space -->
                                                                            <div class="col-md-4 p-0 modal-body-content  d-flex flex-column justify-content-between">
                                                                                <!-- profile picture -->
                                                                                <div class="row ms-2 mt-3">

                                                                                    <div class=" col-6 text-start d-inline ">
                                                                                        <div class="profile-img d-flex align-items-end d-inline">

                                                                                            <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="64" height="64" class="rounded-circle me-2">
                                                                                            <strong><?php echo $data['fname'] . " " . $data['lname'] ?></strong>


                                                                                        </div>

                                                                                    </div>
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
                                                                                <!-- description  area -->
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
                                                                                <!--  comment area-->
                                                                                <div class="row ms-2 mt-3">
                                                                                    <div class=" col-3 align-items-center text-start d-inline ">
                                                                                        <div class="profile-img d-flex align-items-end d-inline">
                                                                                            <img src="../media/profile_img/<?php echo $user_post_from_db['profile'] ?>" alt="" width="64" height="64" class="rounded-circle me-2">
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="text-start mt-3  col-7 ">
                                                                                        <strong><?php echo $user_post_from_db['fname'] . " " . $user_post_from_db['lname'] ?></strong>
                                                                                        <span class="d-block text-trance text-truncate " style="width:100%;">
                                                                                            <?php //echo $post['text'] 
                                                                                            ?>
                                                                                            your comment
                                                                                        </span>

                                                                                    </div>
                                                                                </div>
                                                                                <!-- create comment -->
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
                                                    </div>
                                                </div>


                                            </div>

                                            <style>
                                                .modal .modal-dialog {
                                                    max-width: 62%;
                                                }

                                                .modal .modal-body {
                                                    padding: 0;
                                                    background-color: #f2f2f2;
                                                }

                                                .modal .modal-body .row {
                                                    margin-right: 0;
                                                    padding-right: 0;

                                                }

                                                .modal .modal-body img {
                                                    max-width: 100%;
                                                    height: auto;
                                                }

                                                .modal .modal-body .modal-body-content {
                                                    background-color: #f2f2f2;
                                                    padding-right: 01px;

                                                    height: auto;
                                                }

                                                .modal .modal-body form input {
                                                    background-color: #f2f2f2;

                                                    border: unset;

                                                }

                                                .modal .modal-body form input[type=text]:active {
                                                    box-shadow: none;

                                                    border: unset;
                                                }

                                                .modal .modal-body form input[type=text]:focus {
                                                    box-shadow: none;

                                                    border: unset;
                                                }

                                                .modal .modal-body form input[type=submit]:hover {
                                                    color: black;
                                                    font-weight: bold;

                                                }

                                                .modal .modal-body form input[type=submit] {
                                                    color: blueviolet;
                                                    font-weight: lighter;



                                                }
                                            </style>

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

                                        <?php endwhile; ?>

                                    <?php endwhile; ?>

                                </div>
                            </div>

                        </main>
                    </div>
                    <div class=" col-sm-3 col-3 w-25 h-100 d-none  d-md-block ">
                        <div class="aside-right d-flex flex-column  border-start flex-shrink-0  " style="width: 95%; height:90vh;  position: fixed; ">
                            <use xlink:href="#bootstrap"></use>

                            <ul class="nav nav-pills flex-column mb-auto">

                                <li class="nav-item pt-5">
                                    <a href="./profile.php" class="nav-link  link-dark" aria-current="page">
                                        <svg class="bi me-2" width="16" height="16">
                                            <use xlink:href="#home"></use>
                                        </svg>

                                        <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="80" height="80" class="rounded-circle me-2">
                                        <strong class="ps-4"><?php echo $data['fname'] . " " . $data['lname'] ?></strong>

                                    </a>
                                </li>
                                <hr>
                                <li class="nav-item">
                                    <a href="#" class="nav-link " aria-current="page">
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

                        </div>
                    </div>

                </div>

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
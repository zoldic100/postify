<?php

session_start();
if (isset($_SESSION['email'])) :

    $email = $_SESSION['email'];
    $user_id = $_SESSION['id'];

    $pageTitle = "Postify";
    include './layout.php';
    include_once('../db/conn.php');

    //if (isset($_POST['submit'])) :
    // create comment
    if ($_SERVER['REQUEST_METHOD'] == 'POST') :
        if (isset($_POST['get_id'])) :
            $get_id = $_POST['get_id'];
        endif;
        if (isset($_POST['comment'])) :
            $comment_txt = $_POST['comment'];
            if (isset($comment_txt) || $comment_txt != "") {
                $time = date('Y-m-d H:i:s');
                $sql = " INSERT INTO `comment` (text,created_at,user_id,post_id) VALUES('$comment_txt','$time','$user_id',$get_id)"; // $get_id from hidden input input
                mysqli_query($conn, $sql);
                // to prevent tikrar l commment when refrech the page
                echo '<meta http-equiv="Refrech" content="0; url=welcome.php">';
            }
        endif;


        $error = [];




        if (empty($_FILES['profile']['name'])) {
            $errors[] = 'photo is requared';
        }

        // crezate post
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





    endif;


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





<body>
    <!-- popup form -change profile -->

    <?php include('./welcome_popup.php'); ?>

    <div class="container-fluid">

        <!-- the slice of the page -->

        <div class="row justify-content-between ">
            <!-- aside bar -->
            <div class=" col-2 col-md-2  aside-left ">
                <div class="aside d-flex flex-column  border-end flex-shrink-0 p-3 "
                    style="width: 280px; height:90vh;  position: fixed; ">

                    <a href="/"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
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
                            <a href="#" class="nav-link link-dark text-decoration-none " data-bs-toggle="modal"
                                data-bs-target="#Create_Post">
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
                        <a href="#" class=" link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="32" height="32"
                                class="rounded-circle me-2">
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
            <?php include('./welcome_pots_area.php');?>

            <!-- aside bar-rght -->
            <div class=" col-2 col-md-2    aside-right ">
                <div class="aside-right d-flex flex-column  border-start flex-shrink-0  "
                    style="width: 95%; height:90vh;  position: fixed; ">
                    <use xlink:href="#bootstrap"></use>

                    <ul class="nav nav-pills flex-column mb-auto">

                        <li class="nav-item pt-5">
                            <a href="./profile.php" class="nav-link  link-dark" aria-current="page">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#home"></use>
                                </svg>

                                <img src="../media/profile_img/<?php echo $data['profile'] ?>" alt="" width="80"
                                    height="80" class="rounded-circle me-2">
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

</body>
<script src="../bootstrap-file/js/welcome.js"></script>
<?php

    endwhile;
    include('./footer.php');

else :
    $pageTitle = "Postify";
    include './layout.php'; ?>

<h1 class='display-1 text-center mt-5 pt-5 '>Sorry! </h1>
<h1 class='display-1 text-center mt-1 pt-1 '>You Need To<a class="nav-link d-inline link-primary" href="./login.php">
        Login </a> </h1>

<?php endif ?>
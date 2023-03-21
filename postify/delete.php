<?php 
session_start();

include_once('../db/conn.php');

if(isset($_SESSION['email']) and isset($_GET['id']) ):
    $id_post = $_GET['id'];
    $sql = "SELECT `user_id` FROM `post` WHERE `post`.post_id='$id_post'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['user_id'] === $_SESSION['id']) {
        $sql = "DELETE FROM `comment` WHERE `comment`.post_id='$id_post' ";
        mysqli_query($conn,$sql);
        $sql = "DELETE FROM `post` WHERE `post`.post_id='$id_post' ";
        mysqli_query($conn,$sql);

    }
    
    header('location:./profile.php');
endif;

    ?>


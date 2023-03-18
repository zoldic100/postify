<?php 
session_start();

include_once('../db/conn.php');

if(isset($_SESSION['email']) and isset($_GET['id']) ):
$id_post = $_GET['id'];
$sql = "DELETE FROM `post` WHERE `post`.post_id='$id_post' ";
mysqli_query($conn,$sql);
header('location:./profile.php');
    endif;
    ?>
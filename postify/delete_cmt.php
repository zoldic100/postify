<?php 


include_once('../db/conn.php');

$id_comment_id = $_GET['id'];
$sql = "DELETE FROM comment WHERE `comment`.`comment_id` ='$id_comment_id' ";
mysqli_query($conn,$sql);

header('location:./welcom.php');
    
    ?>
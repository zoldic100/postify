<?php

session_start();
include_once('../db/conn.php');

session_unset();
session_destroy();

header('location:login.php')
?>
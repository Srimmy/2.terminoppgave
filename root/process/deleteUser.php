<?php
session_start();
require_once "../process/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}


if(isset($_POST['deleteUser'])) {
    $username = $_POST['username'];
$stmt = 
        "Delete from users where username = '$username';
        delete from bilder where brukernavn = '$username';
        delete from following where username = '$username';
        delete from following where following = '$username';
        delete from likedbilder where username = '$username';";
        if ($result = mysqli_multi_query($link, $stmt)) {
            session_destroy();
            header('location: ../register/register.php');
        }

} else {
    header('location: ../register/login.php');
}

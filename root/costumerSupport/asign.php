<?php
session_start();
require_once "../config/config.php";


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
} else if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../browse/index.php");
    exit;
}
if($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $username = $_SESSION['username'];
    $id = $_POST['id'];
    echo $id;
    if(isset($_POST['assign'])) {
        $stmt = "UPDATE ticket set answerer = '$username' where id = '$id'";
        mysqli_query($link, $stmt);
        echo $stmt;
        //header("location: ".$_POST['url']."");
    } else {
        $stmt = "UPDATE ticket set answerer = NULL where id = '$id'";
        echo $stmt;
        mysqli_query($link, $stmt);
        //header("location: ".$_POST['url']."");
    }
    header("location: ".$_POST['url']."");
    

} 
?>
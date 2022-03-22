<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
require_once "../config/config.php";
$username = $_SESSION['username'];

if (isset($_POST['title'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $desc = mysqli_real_escape_string($link, $_POST['desc']);

    $stmt = "insert into ticket(keyword, description, user, status) values ('$title', '$desc', '$username', 'unopened')";
    if (mysqli_query($link, $stmt)) {
        header("location: ../costumerSupport/tickets.php");
    } else {
        $title = mysqli_real_escape_string($link, $_POST['title']);
        $desc = mysqli_real_escape_string($link, $_POST['desc']);

        // header("location: ../costumerSupport/createTicket");
    }
} else {
    header("location: ../costumerSupport/createTicket");
}

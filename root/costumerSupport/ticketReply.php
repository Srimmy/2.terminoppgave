<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once "../config/config.php";
    session_start();
    $reply = mysqli_real_escape_string($link, $_POST['reply']);
    $username = $_SESSION['username'];
    $ticketId = mysqli_real_escape_string($link,$_POST['id']);
    $url = mysqli_real_escape_string($link,$_POST['url']);
    var_dump($_POST);
    $stmt = "INSERT INTO ticketreply(ticketid, username, reply) VALUES('$ticketId', '$username', '$reply')";

    if($result = mysqli_query($link, $stmt)) {
        echo $url;
        header('location: '.$url.'');
    } else {
        header("location: ../browse/index.php?replayfailed");
    }
} else {
    header("location: ../browse/index.php");
}
?>
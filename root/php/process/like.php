<?php
//https://www.youtube.com/watch?v=B-ywDE8tBeQ&ab_channel=NickFrostbutter SEARCH ENGINE
//https://youtu.be/B-ywDE8tBeQ?t=1408

require_once "../config/config.php";
$username = $_SESSION["username"];


//lik (hjerte) knapp er trykket
if (isset($_POST['like'])) {
    $bildetIdPOST = $_POST['bildeId'];
    $stmt = mysqli_prepare($link, "SELECT * FROM liktebilderview WHERE liker = ? AND id = ?");
    mysqli_stmt_bind_param($stmt, 'si', $username, $bildetIdPOST);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        //case 1: du liker allerede, fjerner like
        $stmt = mysqli_prepare($link, "DELETE FROM liktebilder where username = ? AND likedPicId = ?");
    } else {
        //case 2: du liker ikke, legger like
        $stmt = mysqli_prepare($link, "INSERT INTO liktebilder(username, likedPicId) VALUES (?, ?)");
    }
    mysqli_stmt_bind_param($stmt, 'si', $username, $bildetIdPOST);
    mysqli_stmt_execute($stmt);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
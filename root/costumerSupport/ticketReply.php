<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once "../config/config.php";
    $reply = mysqli_real_escape_string($link, $_POST['reply']);
    $username = $_SESSION['username'];
    $ticketId = mysqli_real_escape_string($link, $_POST['id']);
    $url = mysqli_real_escape_string($link, $_POST['url']);
    if (in_array($_SESSION['role'], $answerTickets)) {
        //case 1: brukerstøtte skrev meldingen -> notification
        $stmt = "INSERT INTO ticketreply(ticketid, username, reply) VALUES('$ticketId', '$username', '$reply')";
        $stmt2 = "UPDATE ticket set status = 'Awaiting your reply' where id = '$ticketId'";
    } else {
        //case 2: bruker skrev meldingen -> ingen notification
        $stmt = "INSERT INTO ticketreply(ticketid, username, reply) VALUES('$ticketId', '$username', '$reply')";
    }

    if ($result = mysqli_query($link, $stmt)) {
        //tester om query kjører
        if ($stmt2) {
            if ($result2 = mysqli_query($link, $stmt2)) {
            } else {
                //hvis queryen ikke kjører
                echo $stmt;
                // header("location: ../browse/index.php?replayfailed");
            }
        }
        echo $url;
        header('location: ' . $url . '');
    } else {
        //hvis queryen ikke kjører
        echo $stmt;
        // header("location: ../browse/index.php?replayfailed");
    }
} else {
    //hvis det ikke er POST data
    header("location: ../browse/index.php");
}

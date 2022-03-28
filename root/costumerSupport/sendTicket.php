<?php
require_once "../config/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
$username = $_SESSION['username'];

if (isset($_POST['title'])) {
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $desc = mysqli_real_escape_string($link, $_POST['desc']);
    $stmt = "insert into ticket(keyword, description, user, status) values ('$title', '$desc', '$username', 'open')";
    if (mysqli_query($link, $stmt)) {
        $stmt2 = "SELECT * FROM ticket ORDER BY UNIX_TIMESTAMP(created_at) DESC LIMIT 1";
        if ($result = mysqli_query($link, $stmt2)) {
            if ($rad = $rad = mysqli_fetch_assoc(mysqli_query($link, $stmt2)))
            header("location: http://localhost/dashboard/terminoppgave/root/costumerSupport/answerTicket.php?id=".$rad['id']."&seeTicket=0");
        }
        // header("location: ../costumerSupport/costumerTickets.php");
    } else {
        //lagde ikke
        header("location: ../costumerSupport/createTicket?errorSendTicket");
    }
} else {
    header("location: ../costumerSupport/createTicket");
}

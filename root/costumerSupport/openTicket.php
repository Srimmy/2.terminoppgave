<?php
session_start();
require_once "../process/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../browse/browse.php");
    exit;
} else if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../browse/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $stmt  = "SELECT * FROM TICKET WHERE id = '$id'";
    if($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
        $title = $rad['keyword'];
        $desc = $rad['description'];
        $questioner = $rad['user'];
        $stmt = "SELECT * FROM users WHERE username = '$questioner'";
        if($rad1 = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
            $profilePicPath = $rad1['profilePicPath'];
        }

        
    }
} else {
    header("location: ../browse/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ticket #<?php echo $id ?></title>
</head>
<body>
    
</body>
</html>
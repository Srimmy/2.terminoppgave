<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
require_once "../config/config.php";
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Your tickets</title>
</head>

<body>
    <?php include("../config/navbar.php") ?>
    <div class="whitespace"></div>

    <div class="containerBody">
        <h2 class="title">Your tickets</h2>
        <?php
        $stmt = "SELECT * FROM ticket where user = '$username' ORDER BY created_at desc";
        if ($result = mysqli_query($link, $stmt)) {
            while ($rad = mysqli_fetch_assoc($result)) {
                $title = $rad['keyword'];
                $desc = $rad['description'];
                $id = $rad['id'];
                echo " 
                <div onClick=seeTicket('$id')> 
                    <div class = 'yourTickets'>
                    <p class = 'ticketTitle'> <b>$title</b> </p>
                    <p class = 'ticketDesc'> $desc </p>
                    </div>
                </div>";
            }
        }
        ?>
        Need help?
        <a href="../costumerSupport/createTicket.php"> Create a ticket</a>

    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"></script>

</body>

</html>
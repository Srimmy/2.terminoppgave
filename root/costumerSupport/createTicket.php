<?php
require_once "../config/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/Ticket.css">
    <title>Create ticket</title>
</head>

<body>
<?php include("../config/navbar.php")?>
    <div class="whitespace"></div>
    <div class="containerBody">
        <form action="sendTicket.php" method="POST" class="column">
            <label class="supportLabel" for="">Title</label>
            <input class="supportTitle" required maxlength="30" name="title" ; type="text" placeholder="Keywords of your issue">
            <label class="supportLabel" for="">Description</label>
            <textarea required class="supportDescription" name="desc" id="" cols="30" rows="10" placeholder="Explain your issue"></textarea>
            <input type="submit" class = "createButton"value="Send ticket">
        </form>
    </div>




</body>

</html>
<?php
$link = mysqli_connect("localhost", "root", "", "users");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// fra roles
$answerTickets = array();
$stmt = "SELECT * FROM roleprivileges where privileges = 'answerTicket'";
if($result = mysqli_query($link, $stmt)) {
    while($rad = mysqli_fetch_assoc($result)) {
    array_push($answerTickets, $rad['role']);
    }
}

// logger deg inn hvis du har brukerdata
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    //case 1: du er ikke logget inn
    if (basename($_SERVER['PHP_SELF']) != "browse.php" && basename($_SERVER['PHP_SELF']) != "login.php" && basename($_SERVER['PHP_SELF']) != "register.php") {
        //hvis det ikke er browse.php, login.php eller register.php så bytter du til login.php
        header("location: ../register/login.php");
        exit;
    }
} else if (isset($_SESSION['username']) && $_SESSION['loggedin'] === true) {
    //case 2: du er logget inn
    if (basename($_SERVER['PHP_SELF']) == "browse.php" || basename($_SERVER['PHP_SELF']) == "login.php" && basename($_SERVER['PHP_SELF']) == "register.php") {
        //logger deg inn
        header("location: index.php?alreadyloggedin");
        exit;
    }
}
?>

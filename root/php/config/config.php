<?php
session_start();

$postedPicRoot = "../../bilder/delteBilder/";
$profilePicRoot = "../../bilder/profilBilder/";
$faqPicRoot = "../../bilder/faqPictures/";

$link = new mysqli("localhost", "root", "", "users");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
// fra roles
$answerTickets = array();
$stmt = "SELECT * FROM roleprivileges where privileges = 'answerTicket'";
if ($result = mysqli_query($link, $stmt)) {
    while ($rad = mysqli_fetch_assoc($result)) {
        //legger til privileges til roller
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
    $username = $_SESSION['username'];
    if (basename($_SERVER['PHP_SELF']) == "browse.php" || basename($_SERVER['PHP_SELF']) == "login.php" && basename($_SERVER['PHP_SELF']) == "register.php") {
        //logger deg inn
        header("location: index.php?alreadyloggedin");
        $username = '';
        exit;
    }
}


// if (isset($_GET['k']) && $_GET['k'] != '') {
//     //gjør at ' k ' blir til 'k'
//     $k = trim(mysqli_real_escape_string($link, $_GET['k']));
//     //keyword blir en array der hvert element blir separert med et mellomrom
//     //"hei du" -> $keyword[0] = hei, $keyword[1] = du
//     $keywords = explode(' ', $k);

//     //query
//     $searchStmt = "select * from users WHERE";
//     foreach ($keywords as $word) {
//         $searchStmt .= " username like '%" . $word . "%' OR ";
//         $display_words = "";
//     }

//     //fjerner den siste "OR" fra stringen for å ikke få feil
//     //fjerner de siste 3 bokstavene fra stringen.
//     $searchStmt = substr($searchStmt, 0, strlen($searchStmt) - 3);
// }

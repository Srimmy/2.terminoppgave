<?Php
require_once "config.php";
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //fjerner mellomrom og skjekker om noe er i kommentarfeltet
    if(empty(trim($_POST['newComment'], ""))) {
        header("Location: following.php?deterikkenoeikommentarfeltetmenjegorkerikkeålageenfeilmeldingsåurlenblirbarevlediglangsåjegserettydelig");
    } else {
        $bildeId = $_POST['bildeId'];
        $kommentar = $_POST['newComment'];
        $stmt = "INSERT INTO kommentar (kommentar, bildeId, brukernavn) VALUES ('$kommentar', '$bildeId', '$username')";
        mysqli_query($link, $stmt);
        header("Location: following.php");
    }

}

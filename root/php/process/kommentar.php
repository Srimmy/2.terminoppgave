<?Php
require_once "../config/config.php";

$username = $_SESSION['username'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //fjerner mellomrom og skjekker om noe er i kommentarfeltet
    if(empty(trim($_POST['newComment'], ""))) {
        header("Location: ../browse/following.php?");
    } else {
        //hvis det var en melding som inneholdt noe mer enn ett mellomrom
        //legger ut kommentar
        $bildeId = $_POST['bildeId'];
        $kommentar = $_POST['newComment'];
        $stmt = "INSERT INTO kommentar (kommentar, bildeId, brukernavn) VALUES ('$kommentar', '$bildeId', '$username')";
        mysqli_query($link, $stmt);
        //sender til riktig side
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

}

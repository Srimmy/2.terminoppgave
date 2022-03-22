<?php
require_once "../config/config.php";

//henter ticket fra URL
$stmt = "SELECT * FROM TICKET WHERE id = '" . $_GET['id'] . "'";
$ticketUsername = mysqli_fetch_assoc(mysqli_query($link, $stmt))['user'];

if (in_array($_SESSION['role'], $answerTickets) || $_SESSION['username'] == $ticketUsername) {
    //case 2: du har en rolle som kan se tickets eller så er brukernavnet ditt den som skrev ticketen
    if ($_SESSION['username'] == $ticketUsername) {
        $role = "Author";
    }
} else {
    //case 3: du er logget inn men har ikke rolle og brukernavnet passer ikke
    header("location: ../browse/index.php");
    exit;
}

//henter fra URL
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //case 1: du har fått GET i URL
    $id = $_GET['id'];
    $stmt  = "SELECT * FROM TICKET WHERE id = '$id'";
    if ($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
        //case 1: ticketen finnes
        $title = $rad['keyword'];
        $desc = $rad['description'];
        $asker = $rad['user'];
        $stmt = "SELECT * FROM users WHERE username = '$asker'";
        if ($rad1 = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
            $profilePicPath = $rad1['profilePicPath'];
        }
    } else {
        //case 2: ticketen finnes ikke
        header("location: ../costumerSupport/openTicket.php");
    }
} else {
    //case 2: det er ingen GET
    header("location: ../browse/index.php");
}

//lager url til dette stedet, for senere bruk
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Ticket #<?php echo $id ?></title>
</head>

<body>
    <div class="containerBody">
        <a href="openTicket.php">back</a>
        <form action="asign.php" method="POST">
            <?php
            //henter informasjon om ticketen
            $stmt = "SELECT * FROM ticket WHERE id = '$id'";
            $result = mysqli_query($link, $stmt);
            $answerer = mysqli_fetch_assoc($result)['answerer'];
            //legger til informasjon til form, brukes senere på submit
            $sendURL = '<input class = "invisable" value = "' . $escaped_url . '" name = "url">';
            $sendID =  '<input class = "invisable" value = "' . $id . '" name = "id">';
            if (isset($answerer)) {
                //case 1: noen har satt seg selv om svarer til ticketen
                if ($answerer == $_SESSION['username']) {
                    //case 1: du er den som er satt
                    echo '<input type="submit" value=" Unassign" name = "unAssign">';
                } else {
                    //case 2: noen andre er satt
                    echo '<h5' . mysqli_fetch_assoc($result)['answerer'] . ' is assigned</h5>';
                }
            } else {
                //case 2: ingen er satt
                echo '<input type="submit" value="Assign yourself" name = "assign">';
            }
            echo $sendURL;
            echo $sendID;
            ?>

        </form>
        <h3> <?php echo $title ?></h3>
        <h4> Support ticket</h4>
        <div class="row  threadDiv">
            <div class="writer">
                <div class="ticketPfp">
                    <img src="<?php echo $profilePicPath ?>" alt="Profile Picture <?php $asker ?>">
                </div>
            </div>
            <div class="thread">
                <h5><?php echo $asker ?> <br> <span>Author</span></h5>
                <p> <?php echo $desc ?> </p>
            </div>
        </div>
        <?php
        //henter alle som har svart på ticketen
        $stmt = "SELECT * FROM ticketreply WHERE ticketid = '$id' order by created_at asc";
        if ($result = mysqli_query($link, $stmt)) {
            //skriver hver rad i databasen
            while ($rad = mysqli_fetch_assoc($result)) {
                $reply = $rad['reply'];
                $replyer = $rad['username'];
                $time = $rad['created_at'];
                $replyerInfo = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM USERS WHERE username = '$replyer'"));

                echo ' <div class="row  threadDiv">
                <div class="writer">
                    <div class="ticketPfp">
                        <img src="' . $replyerInfo['profilePicPath'] . '" alt="Profile Picture ' . $replyer . '">
                    </div>
                </div>
                <div class="thread">
                    <h5> ' . $replyer . ' <br> <span>' . $replyerInfo['role'] . '</span></h5>
                    <p>' . $reply . '</p>
                </div>
            </div>';
            }
        }
        ?>

        <!-- Lager html kode for ditt eget ikon -->
        <div class="row  threadDiv">
            <div class="writer">
                <div class="ticketPfp">
                    <img src="<?php echo $profilePicPath ?>" alt="Profile Picture <?php $asker ?>">
                </div>
            </div>
            <div class="thread">
                <h5><?php echo $_SESSION['username'] ?> <br> <span><?php echo $role; ?></span></h5>
                <form action="ticketreply.php" id="replyForm" method="POST">
                    <textarea required class="" name="reply" id="" cols="30" rows="10" placeholder="Write here"></textarea>
                    <input type="text" name="id" class="invisable" value="<?php echo $id; ?>">
                    <input type="text" name="url" class="invisable" value="<?php echo $escaped_url ?>">

                </form>
                <div class="row">
                    <input type="submit" form="replyForm" value="Send reply">
                    <form action="">
                        <input type="submit" value="Mark as completed">
                    </form>
                </div>

            </div>

        </div>
    </div>
    <div class="whitespace"></div>


</body>

</html>
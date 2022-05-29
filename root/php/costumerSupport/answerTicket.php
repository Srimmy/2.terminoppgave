<?php
require_once "../config/config.php";
$role = $_SESSION['role'];

//henter ticket fra URL
$stmt = mysqli_prepare($link, "select * from ticket WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ticketUsername = mysqli_fetch_assoc($result)['user'];
$support = false;
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        //case 1: du har fått GET i URL
        $id = $_GET['id'];
        $stmt  = "select * from ticket WHERE id = '$id'";
        $result = mysqli_query($link, $stmt);
        if ($rad = mysqli_fetch_assoc($result)) {
            //case a: ticketen finnes
            $title = $rad['keyword'];
            $desc = $rad['description'];
            $asker = $rad['user'];
            $stmt = "SELECT * FROM users WHERE username = '$asker'";
            if ($rad1 = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
                $profilePicPath = $profilePicRoot . $rad1['profilePicPath'];
                break;
            }
        } else {
            //case b: ticketen finnes ikke
            header("location: ../costumerSupport/openTicket.php");
        }
    case 'POST':
        //case 2: det er en POST, 
        $stmt = "UPDATE ticket set status = 'solved' where id = '" . $_POST['id'] . "'";
        mysqli_query($link, $stmt);
        header("location: ../costumerSupport/costumerTickets.php");
        break;
    default:
        //case 3: det er ingen GET eller POSt
        header("location: ../browse/index.php");
}
if ($_SESSION['username'] == $ticketUsername) {
    //sluttbrukeren som lagde ticketen vil se den
    $role = "Author";
} else if (in_array($_SESSION['role'], $answerTickets)) {
    //support ser ticket
    $support = true;
} else if (!$_POST) {
    // verken rolle eller brukernavn passer
    header("location: ../browse/index.php");
    exit;
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
    <link rel="stylesheet" href="../../css/style.css">
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
            echo '<input class = "invisable" readonly value = "' . $escaped_url . '" name = "url">';
            echo '<input class = "invisable" readonly value = "' . $id . '" name = "id">';
            if ($support) {
                if (isset($answerer)) {
                    //case 1: noen har satt seg selv om svarer til ticketen
                    if ($answerer == $_SESSION['username']) {
                        //case 1: du er den som er satt
                        echo '<input type="submit" value=" Unassign" name = "unAssign">';
                    } else {
                        //case 2: noen andre er satt
                        echo '<h5>' . $answerer . ' is assigned</h5>';
                    }
                } else {
                    //case 2: ingen er satt
                    echo '<input type="submit" value="Assign yourself" name = "assign">';
                }
            }
            ?>

        </form>
        <h3> <?php echo $title ?></h3>
        <h4> Support ticket</h4>
        <div class="row  threadDiv">
            <div class="writer">
                <div class="ticketPfp">
                    <img class='ticketActualPfp' src="<?php echo $profilePicPath ?>" alt="Profile Picture <?php $asker ?>">
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
                $replyerInfo = mysqli_fetch_assoc(mysqli_query($link, "select * from users WHERE username = '$replyer'"));

                echo ' <div class="row  threadDiv">
                <div class="writer">
                    <div class="ticketPfp">
                        <img class ="ticketActualPfp" src="' . $profilePicRoot . $replyerInfo['profilePicPath'] . '" alt="Profile Picture ' . $replyer . '">
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
                    <img class="ticketActualPfp" src="<?php echo $_SESSION['profilePic'] ?>" alt="Profile Picture <?php $asker ?>">
                </div>
            </div>
            <div class="thread">
                <h5><?php echo $_SESSION['username'] ?> <br> <span><?php echo $role; ?></span></h5>
                <form action="ticketreply.php" id="replyForm" method="POST">
                    <textarea required class="" name="reply" id="" cols="30" rows="10" placeholder="Write here"></textarea>
                    <input readonly name="id" class="invisable" value="<?php echo $id; ?>">
                    <input readonly name="url" class="invisable" value="<?php echo $escaped_url ?>">
                </form>
                <div class="row">
                    <input type="submit" form="replyForm" value="Send reply">
                    <?php
                    if ($role == "Author") {
                        //legger til 'mark as complete' button
                        echo '                
                    <form action="answerTicket.php" method = "POST">
                        <input readonly name = "id" class = "invisable" value = "' . $id . '" >
                        <input type="submit" name "ticketSolved" value="Mark as solved">
                    </form>';
                    } ?>

                </div>


            </div>

        </div>
    </div>
    <div class="whitespace"></div>


</body>

</html>
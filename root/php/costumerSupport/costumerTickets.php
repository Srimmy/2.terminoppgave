<?php
require_once "../config/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
$username = $_SESSION['username'];
$possibleStatus = [
    "Awaiting your reply",
    "open",
    "solved",
];

//lager tickets elementer
function createTicketEls($queryResult)
{
    while ($rad = mysqli_fetch_assoc($queryResult)) {
        $title = $rad['keyword'];
        $desc = $rad['description'];
        if (strlen($desc) > 30) {
            //gjør description kortere
            $desc = substr($desc, 0, 27) . '...';
        }
        $id = $rad['id'];
        $status = $rad['status'];
        //html elementer
        echo "
            <tr onclick=seeTicket('$id') class = 'yourTickets'>
                <td class = 'ticketTableTitle'>
                    $title
                </td>
                <td>
                $desc
                </td>
                <td>
                    #$id
                </td>
                <td>
                    <div class = ' status $status'> 
                        $status
                    </div>
                </td>
            </tr>";
    }
}
//       echo " 
// <div onClick=seeTicket('$id')> 
// <div class = 'yourTickets'>
// <p class = 'ticketTitle'> <b>$title</b> </p>
// <p class = 'ticketDesc'> $desc </p>
// </div>
// </div>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Your tickets</title>
</head>

<body>
    <?php include("../config/navbar.php") ?>
    <div class="whitespace"></div>

    <div class="containerBody">
        <h1 class="title"> My tickets</h1>


        <table class='ticketTable'>
            <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>ID</th>
                <th>Status</th>
            </tr>
            <?php
            for ($i = 0; $i < count($possibleStatus); $i++) {
                $stmt = "SELECT * FROM ticket where user = '$username' AND status = '$possibleStatus[$i]' ORDER BY created_at desc";
                if ($result = mysqli_query($link, $stmt)) {
                    //tegner alle tickets
                    createTicketEls($result);
                }
            }
            ?>
        </table>
        <br>
        <a href="../costumerSupport/createTicket.php" class='createTicket'> Create a ticket</a>

    </div>
    <div id="invisable"></div>
    <script src="../../script/ui.js"></script>

</body>

</html>
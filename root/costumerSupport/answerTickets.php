<?php
require_once("../process/config.php");
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../browse/browse.php");
    exit;
} else if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../browse/index.php");
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
    <title>Incomming tickets</title>
</head>

<body>

    <div class="containerBody">
        <div>
            <table class="ticketTable">
                <tr>

                    <th>ID</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Requester</th>
                    <th>Asignee</th>

                </tr>

                <?php
                //henter alle tickets
                $stmt = "SELECT * FROM ticket ORDER BY created_at asc";
                if ($result = mysqli_query($link, $stmt)) {
                    while ($rad = mysqli_fetch_assoc($result)) {
                        $id = $rad['id'];
                        $title = $rad['keyword'];
                        $desc = $rad['description'];
                        if (strlen($desc) > 25) {
                            $desc = substr($desc, 0, 22) . '...';
                        }
                        $user = $rad['user'];
                        $answerer = $rad['answerer'];
                        if (is_null($answerer)) {
                            $answerer = "-";
                        }
                        $priority = $rad['priority'];
                        echo "
                    <tr onclick=seeTicket('$id')>
                        <td>
                            #$id
                        </td>
                        <td>
                            $title
                        </td>
                        <td>
                            $desc
                        </td>
                        <td>
                            $user
                        </td>
                        <td>
                            $answerer
                        </td>
                    </tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"></script>

</body>

</html>
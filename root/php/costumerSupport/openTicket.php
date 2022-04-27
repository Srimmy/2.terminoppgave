<?php

require_once "../config/config.php";
if (!in_array($_SESSION['role'], $answerTickets)) {
    header("location: ../costumerSupport/costumerTickets.php");
    exit;
}
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Incomming tickets</title>
</head>

<body>
    <!-- navbar -->
    <?php include("../config/navbar.php") ?>
    <div class="whitespace"> </div>

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
                $stmt = "SELECT * FROM ticket where status != 'solved' ORDER BY created_at asc";
                if ($result = mysqli_query($link, $stmt)) {
                    while ($rad = mysqli_fetch_assoc($result)) {
                        $id = $rad['id'];
                        $title = $rad['keyword'];
                        $desc = $rad['description'];
                        if (strlen($desc) > 25) {
                            //forkorter slik at description ikke blir for lang
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
    <script src="../../script/ui.js"></script>

</body>

</html>
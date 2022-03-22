<?php

require_once "../config/config.php";
$sql = "SELECT username, highscore FROM users ORDER BY highscore desc LIMIT 1;"; //queries
$result = mysqli_query($link, $sql);
$username = $_SESSION['username'];
if ($result) { //sjekker om det finnes noe
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $highscore = $user_data['highscore'];
        $highscoreName = $user_data['username'];
        // echo "Highscore: ", $highscore, "\r\n Username: ",  $highscoreName;
    }
}


//skjekker din highscore
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['loggedin']) { //vetner på en form som blir submittet
    $score = $_POST['score'];
    $sql = "SELECT highscore FROM users WHERE username = '$username'"; //queries
    $result = mysqli_query($link, $sql);             //lagrer scoren sendt fra js submit                      
    if ($result) {
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $oldScore = $user_data['highscore'];
            if ($oldScore < $score) { //Må legge til > score slik at if statementen fungerer riktig
                $sql = "UPDATE users SET highscore = '$score' where username = '$username'";
                $result = mysqli_query($link, $sql);
            }
        } else {
            $sql = "UPDATE USERS SET HIGHSCORE = '$score' where username = '$username'";
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- navbar -->
    <?php include("../config/navbar.php")?>


    <div class="whitespace"></div>
    <button id="startSpill" onClick="startGame()"> Start spill</button>

    <div class="inline container containerBody" id="pong">
        <canvas id="gameScreen" height="600" width="800"></canvas>
        <div>
            <h2>Leaderboards</h2>
            <table cellspacing="0" id="highscoreTable">
                <tr>
                    <th>
                        Rank
                    </th>
                    <th>
                        Highscore
                    </th>
                    <th>
                        Username
                    </th>
                </tr>
                <?php
                //leaderboard
                $stmt = "SELECT * FROM USERS WHERE HIGHSCORE > 0 ORDER BY HIGHSCORE DESC ";
                $rank = 1;
                if ($resultat = mysqli_query($link, $stmt)) {
                    while ($rad = mysqli_fetch_assoc($resultat)) {
                        //finner top 10 leaderboard
                        $rowScore = $rad['highscore'];
                        $rowUser = $rad['username'];
                        if ($rank < 11) {
                            $tableRow = "<tr onClick = sendTilProfil('$rowUser')> <td> $rank </td> <td> $rowScore </td> <td> $rowUser </td></tr>";
                            echo $tableRow;
                            $rank++;
                        }
                    }
                }
                if ($resultat = mysqli_query($link, $stmt)) {
                    $rank = 1;
                    while ($rad = mysqli_fetch_assoc($resultat)) {
                        //finner din rank
                        $rowScore = $rad['highscore'];
                        $rowUser = $rad['username'];
                        if ($rowUser == $username) {
                            $tableRow = "<tr> <td> $rank </td> <td> $rowScore </td> <td> $rowUser </td></tr>";
                            echo $tableRow;
                        }
                        $rank++;
                    }
                }
                ?>
            </table>
            <h1>
                <?php
                //user highscore
                if ($_SESSION['loggedin']) {
                    $stmt = "SELECT * FROM users where username = '$username'";
                    if ($result = mysqli_query($link, $stmt)) {
                        if ($rad = mysqli_fetch_assoc($result)) {
                            $oldScore = $rad['highscore'];
                            echo "\r\nYour highscore: ", $oldScore;
                        }
                    }
                }
                ?>
            </h1>
            <h1 id="scoreTekst"> Score: 0</h1>
            <h1 id="C"> Combo: 0</h1>
            <?php
            if ($_SESSION['loggedin']) {
                echo ' <form action="pong.php" method="post" id="submitHighscore">
                <input id="highscore" type="number" value="0" name="score">
                <button onClick="SendHighscore()">Submit highscore</button>
            </form>
            <p class="note " >Note: highscore will not save unless you submit.</p>';
            } else {
                echo '<p class="note container"><a href = "register.php"> Sign up</a> to save your score!</p>';
            }


            ?>




        </div>
    </div>
    <div class="whitespace"></div>


    <script src="spill/script.js"></script>
    <script src="../script/ui.js"></script>


</body>

</html>
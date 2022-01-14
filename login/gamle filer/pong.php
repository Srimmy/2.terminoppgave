<?php
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
$sql = "SELECT username, highscore FROM users ORDER BY highscore desc LIMIT 1;"; //queries
$result = mysqli_query($link, $sql);
if ($result) { //sjekker om det finnes noe
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $highscore = $user_data['highscore'];
        $highscoreName = $user_data['username'];
        // echo "Highscore: ", $highscore, "\r\n Username: ",  $highscoreName;
    }
}
$sql = "SELECT highscore FROM users WHERE username = '$username'"; //queries
$result = mysqli_query($link, $sql);

//skjekker din highscore
if ($_SERVER["REQUEST_METHOD"] == "POST") { //vetner på en form som blir submittet
    $score = $_POST['score'];               //lagrer scoren sendt fra js submit                      
    if ($result) {
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $oldScore = $user_data['highscore'];
            if ($oldScore < $score) { //Må legge til > score slik at if statementen fungerer riktig
                $sql = "UPDATE users SET highscore = '$score' where username = '$username'";
                $result = mysqli_query($link, $sql);
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>

    <style>
        #gameScreen {
            border: 1px solid black;
        }
    </style>

    <div class="inline">
        <canvas id="gameScreen" height="600" width="800"></canvas>
        <div>
            <h1>
                <?php
                $stmt = "SELECT * FROM users where username = '$username'";
                if ($result = mysqli_query($link, $stmt)) {
                    if ($rad = mysqli_fetch_assoc($result)) {
                        $oldScore = $rad['highscore'];
                        echo "\r\nYour highscore: ", $oldScore;
                    }
                }
                ?>
            </h1>
            <h1 id="scoreTekst"> Score: 0</h1>
            <h1 id="C"> Combo: 0</h1>

        </div>
    </div>

    <button id="startSpill"> Start spill</button>




    <form action="pong.php" method="post" id="submitHighscore">
        <input id="highscore" type="number" value="0" name="score">
        <input type="submit" class="submit">
    </form>
    <p>Note that if you do submit your highscore, it will not be registered in the database.</p>

    <h2>Leaderboards</h2>
    <table>
        <tr>
            <th>
                Highscore
            </th>
            <th>
                Username
            </th>
        </tr>
        <?php
        $stmt = "SELECT * FROM USERS ORDER BY HIGHSCORE DESC LIMIT 10";
        if ($resultat = mysqli_query($link, $stmt)) {
            while ($rad = mysqli_fetch_assoc($resultat)) {
                $rowScore = $rad['highscore'];
                $rowUser = $rad['username'];
                $tableRow = "<tr> <td> $rowScore </td> <td> $rowUser </td></tr>";
                echo $tableRow;
            }
        }
        ?>
    </table>
    


    <script src="spill/script.js"></script>


</body>

</html>
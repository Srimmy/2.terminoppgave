<?php

session_start();
require_once "../config/config.php";
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
    <!-- Skal jeg gjøre navbar til en php eller js variabel slik at jeg kan endre alt på likt?-->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <form method="GET" class="row searchForm" action='../browse/search.php'>
            <div id="search" style="width: 15vw">
                <img src="../htmlBilder/søke.png" id="søkeBildet" alt="">
                <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
            </div>
        </form>
        <div class="right-navbar">
            <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="../htmlBilder/house.png" alt="home"></a>
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse.png" alt="explore"></a>
            <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="../htmlBilder/pong-reverse.png" alt="explore"></a>
            <!--modal-->
            <a class="menu" id="modalButton"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
            <div id="modalParent" onclick="hideModal(event)">
                <div id="modalChild">
                    <form action="../process/sharePic.php" method="POST" enctype="multipart/form-data">
                        <div class="modalTitleDiv">
                            <h2 class="modalTitle">Create a new post</h2>
                            <input class="" id="uploadPicture" type="submit" name="submit" value="Upload">
                        </div>
                        <div class="preview">
                            <img style="display: none;" id="picturePreview">
                        </div>

                        <label for="uploadInput" class="input submit" id="fileUpload"> Select from computer</label>
                        <!--Live preview av bildet-->
                        <input type="file" accept="image/*" onchange="showPreview(event);" id="uploadInput" name="file">
                    </form>
                </div>
            </div>
            <div id="pfpRadius" class="dropdownElement pfpRadius">
                <img class="profilBildet" id="drop" src="<?php echo $_SESSION['profilePic']; ?>" alt="profile picture">
            </div>


            <div id="dropDown" class="shadow">
                <div class="dropContainer ">
                    <a class="dropElement" href="../profile/profile.php">Profil</a>
                    <a class="dropElement" href="../profile/profileEdit.php">Edit profile</a>
                    <a class="dropElement" href="../costumerSupport/tickets.php">Tickets</a>
                    <?php
                    $stmt = "SELECT * FROM USERS WHERE USERNAME = '$username'";
                    if ($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
                        if (in_array($rad['role'], $answerTickets)) {
                            echo '<a class="dropElement" href="../costumerSupport/openTicket.php">Answer tickets</a>';
                        }
                    }
                    ?>
                    <a class="dropElement" href="../process/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>

    </div>


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
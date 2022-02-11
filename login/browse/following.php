<?php
// Initialize the session
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden
/// BRUKT KONTROLL F5 for å refreshe php siden

// ONCLICK FUNKER IKKE HVIS MAN HAR NAME = "X" INNI TAGGET
//https://www.youtube.com/watch?v=B-ywDE8tBeQ&ab_channel=NickFrostbutter SEARCH ENGINE
//https://youtu.be/B-ywDE8tBeQ?t=1408
session_start();
require_once "../process/config.php";
// Check if the user is logged in, if not then redirect him to login page
$followPage = false;
$username = $_SESSION["username"];
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: browse.php");
    exit;
}

//like bilder
if (isset($_POST['like'])) {
    $bildetIdPOST = $_POST['bildeId'];
    $stmt = "SELECT * FROM liktebilderview WHERE liker = '$username' AND id = '$bildetIdPOST'";
    if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
        //den er liked
        $stmt = "DELETE FROM liktebilder where username = '$username' AND likedPicId = '$bildetIdPOST'";
        mysqli_query($link, $stmt);
    } else {
        $stmt = "INSERT INTO liktebilder(username, likedPicId) VALUES ('$username', '$bildetIdPOST')";
        mysqli_query($link, $stmt);
    }
}
//skjekker den høyeste scoren 



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <form method="GET" class="row" action="search.php">
            <div id="search">
                <img src="../htmlBilder/søke.png" class="søkeBildet" alt="">
                <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
            </div>

            <input type="submit">
        </form>
        <div class="right-navbar">
            <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="../htmlBilder/house-reverse.png" alt="home"></a>
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse.png" alt="explore"></a>
            <a class="menu" id = "modal"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
            <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="../htmlBilder/pong.png" alt="explore"></a>
            <div id="pfpRadius" class="dropdownElement pfpRadius">
                <img class="profilBildet" id="drop" src="<?php echo $_SESSION['profilePic']; ?>" alt="profile picture">
            </div>


            <div id="dropDown" class="shadow">
                <div class="dropContainer ">
                    <a class="dropElement" href="../profile/profile.php">Profil</a>
                    <a class="dropElement" href="../profile/profileEdit.php">Edit profile</a>
                    <a class="dropElement" href="../process/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>


    <div class="whitespace"></div>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($username); ?></b>. Welcome to our site.</h1>

    <p>
        <a href="sharePic.php">Share a picture</a>
    </p>

    <!--Bildet feed-->
    <div class="container containerBody">
        <?php

        // SELECT following.following , following.username, bilder.Path, bilder.brukernavn, bilder.dato FROM following 
        // JOIN bilder ON following.username = bilder.brukernavn
        // ORDER BY bilder.DATO DESC; er satt som en view, den heter FOLLOWINGBILDER
        //follow page kode

        $stmt = "SELECT * FROM FOLLOWINGBILDER WHERE FOLLOWING = '$username'";
        if ($result = mysqli_query($link, $stmt)) {
            $innleggTall = 0;


            //kjører koden hver gang $rad får en ny verdi, altså for hver rad i databasen
            while ($rad = mysqli_fetch_assoc($result)) {
                //definerer pathen til filen
                $like = false;
                $path = $rad['Path'];
                $usernamePic = $rad['brukernavn'];
                $bildetId = $rad['id'];
                $stmt = "SELECT * FROM USERS WHERE USERNAME = '$usernamePic'";
                $userPfp = mysqli_fetch_assoc(mysqli_query($link, $stmt))['profilePicPath'];
                //elementet som skal vises
                //funker ikke som writeForm function av en eller annen grunn, kanskje pga php kode
                $innleggEl = "<div class='innlegg'>
                                    <div class='row alignLeft'>
                                        <div class='pfpRadius profilInnlegg'>
                                            <img src='$userPfp' alt='profile picture' onClick=sendTilProfil('$usernamePic') class='profilBildet'>
                                        </div>
                                        <p class = 'brukerBildet' onclick=sendTilProfil('$usernamePic')>$usernamePic</p>
                                    </div>
                                    <div class = 'bildetOverflow'>
                                        <img src='$path' class = 'bildetInnlegg' alt='innlegg'>
                                    </div>";


                echo $innleggEl; //legger 1/3 av innlegget i html
                $stmt = "SELECT * FROM liktebilderview where liker = '$username' AND id = '$bildetId'";
                if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
                    $like = true;
                }
                if ($like) {
                    echo "<img src = '../htmlBilder/hjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                } else {
                    echo "<img src = '../htmlBilder/usynligHjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                }

                $stmt = "SELECT * FROM kommentarpåbildet where bildeid = '$bildetId'";
                if ($result2 = mysqli_query($link, $stmt)) {
                    while ($rad2 = mysqli_fetch_assoc($result2)) {
                        $kommentar = $rad2['kommentar'];
                        $kommentarBruker = $rad2['brukernavn'];
                        $stmt = "SELECT * FROM USERS WHERE USERNAME = '$kommentarBruker'";
                        //skjønner ikke hvorfor jeg ikke får lov til å skrive:
                        //$pfp = mysqli_fetch_assoc(mysqli_query($link, $stmt))['profilePicPath']
                        $result3 = mysqli_query($link, $stmt);
                        $brukerInfo = mysqli_fetch_assoc($result3);
                        $pfp = $brukerInfo['profilePicPath'];

                        $kommentarEl = "<div class = 'kommentarer'>
                                            <div class='row alignLeft'>
                                                <div class='kommentarPfpRadius profilInnlegg'>
                                                    <img src='$pfp' alt='profile picture' onClick=sendTilProfil('$kommentarBruker') class='kommentarPfp'>
                                                </div>
                                                <p class = 'kommentar' > <span class = 'pointer' hover = 'pointer' onclick=sendTilProfil('$kommentarBruker')> $kommentarBruker</span> $kommentar</p>
                                            </div>    
                                        </div>";
                        echo $kommentarEl; //legger 1/3 av innlegget i html, altså alle kommentarene
                    }
                }
                $skrivKommentar = "
                    <div class = 'addComment alignLeft'>  
                        <form method='POST' action='kommentar.php'>
                            <input class = 'newComment' onkeypress='test($innleggTall)' type='text' name = 'newComment' placeholder='Add a comment..'>
                            <input class = 'invisable' type='text' name = 'bildeId' value = '$bildetId'>
                            <input type = 'submit' name = 'submitComment' value = 'Post';>
                        </form>
                    </div>

                </div>";
                echo $skrivKommentar; //siste delen av innlegget som er at man selv kan skrive kommentar
                $innleggTall++;
            }
        }

        ?>

    </div>


    <div class="whitespace"></div>
    <p id="invisable"> </p>
    <div id="invisable"></div>
    <script src="../script/ui.js"></script>
</body>

</html>
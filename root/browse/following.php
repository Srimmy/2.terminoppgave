<?php
// Initialize the session


// ONCLICK FUNKER IKKE HVIS MAN HAR NAME = "X" INNI TAGGET
//https://www.youtube.com/watch?v=B-ywDE8tBeQ&ab_channel=NickFrostbutter SEARCH ENGINE
//https://youtu.be/B-ywDE8tBeQ?t=1408

session_start();
require_once "../config/config.php";
$followPage = false;
$username = $_SESSION["username"];


//kjører hvis du trykker på like knappen
if (isset($_POST['like'])) {
    $bildetIdPOST = $_POST['bildeId'];
    $stmt = "SELECT * FROM liktebilderview WHERE liker = '$username' AND id = '$bildetIdPOST'";
    if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
        //case 1: du liker allerede, fjerner like
        $stmt = "DELETE FROM liktebilder where username = '$username' AND likedPicId = '$bildetIdPOST'";
        mysqli_query($link, $stmt);
    } else {
        //case 2: du liker ikke, legger like
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
        <form method="GET" class="row searchForm" action='../browse/search.php'>
            <div id="search" style="width: 15vw">
                <img src="../htmlBilder/søke.png" id="søkeBildet" alt="">
                <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
            </div>
        </form>
        <div class="right-navbar">
            <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="../htmlBilder/house-reverse.png" alt="home"></a>
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse.png" alt="explore"></a>
            <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="../htmlBilder/pong.png" alt="explore"></a>
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
                    //ser om rolen din kan se tickets
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


    <div class="whitespace"></div>

    <!--Bildet feed-->
    <div class="container containerBody">
        <?php
        //finner bilder fra de du follower
        $stmt = "SELECT * FROM FOLLOWINGBILDER WHERE FOLLOWING = '$username'";
        if ($result = mysqli_query($link, $stmt)) {
            $innleggTall = 0;
            //kjører loop for hver rad i databasen
            while ($rad = mysqli_fetch_assoc($result)) {
                $like = false;
                //definerer pathen til filen
                $path = $rad['Path'];
                $usernamePic = $rad['brukernavn'];
                $bildetId = $rad['id'];

                //henter profilbildet
                $stmt = "SELECT * FROM USERS WHERE USERNAME = '$usernamePic'";
                $userPfp = mysqli_fetch_assoc(mysqli_query($link, $stmt))['profilePicPath'];

                //skriver 1/3 av html, bare bruker, profilbildet og innlegget
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


                echo $innleggEl;
                //ser om du liker bildet
                $stmt = "SELECT * FROM liktebilderview where liker = '$username' AND id = '$bildetId'";
                if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
                    //case 1: du liker bildet
                    $like = true;
                    echo "<img src = '../htmlBilder/hjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                } else {
                    //case 2: du liker ikke bildet
                    echo "<img src = '../htmlBilder/usynligHjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                }

                //henter kommentarer på bildet
                $stmt = "SELECT * FROM kommentarpåbildet where bildeid = '$bildetId'";
                if ($result2 = mysqli_query($link, $stmt)) {
                    while ($rad2 = mysqli_fetch_assoc($result2)) {
                        $kommentar = $rad2['kommentar'];
                        $kommentarBruker = $rad2['brukernavn'];
                        $stmt = "SELECT * FROM USERS WHERE USERNAME = '$kommentarBruker'";
                        $result3 = mysqli_query($link, $stmt);
                        $brukerInfo = mysqli_fetch_assoc($result3);
                        $pfp = $brukerInfo['profilePicPath'];

                        //lager kommentarfeltet -> andre 1/3 av innlegget
                        $kommentarEl = "<div class = 'kommentarer'>
                                            <div class='row alignLeft'>
                                                <div class='kommentarPfpRadius profilInnlegg'>
                                                    <img src='$pfp' alt='profile picture' onClick=sendTilProfil('$kommentarBruker') class='kommentarPfp'>
                                                </div>
                                                <p class = 'kommentar' > <span class = 'pointer' hover = 'pointer' onclick=sendTilProfil('$kommentarBruker')> $kommentarBruker</span> $kommentar</p>
                                            </div>    
                                        </div>";
                        echo $kommentarEl;
                    }
                }
                $skrivKommentar = "
                    <div class = 'addComment alignLeft'>  
                        <form method='POST' action='../process/kommentar.php'>
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
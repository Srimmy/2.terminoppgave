<?php
include("../config/config.php");
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $sql = 'SELECT * FROM bilder where id = ?';
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_GET['picId']);
    mysqli_stmt_execute($stmt);
    if ($result = mysqli_stmt_get_result($stmt)) {
        //henter data i assoc array
        if (mysqli_num_rows($result) > 0) {
            if ($rad = mysqli_fetch_assoc($result))
                $usernamePic = $rad['brukernavn'];
            $picSrc = $postedPicRoot . $rad['Path'];
        } else {
            header('location: ../browse/index.php');
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
    <title><?php echo 'noe' ?></title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php
    include("../config/navbar.php") ?>
    <div id="commentModalParent">
        <div id="commentModal">
            <div class="bildetKommentarContainer">
                <?php
                echo '<div class = "fullPicOverflow"><img class = "fullsizePic"src = "' . $picSrc . '" alt = "Uploaded picture"></div> ';
                ?>
                <div>
                    <?php
                    $innleggTall = 0;

                    $stmt = "SELECT * FROM users WHERE username = '$usernamePic'";
                    $userPfp = $profilePicRoot . mysqli_fetch_assoc(mysqli_query($link, $stmt))['profilePicPath'];

                    //skriver 1/3 av html, bare bruker, profilbildet og innlegget
                    $innleggEl = "<div class='storKommentarSamling'>
                                                        <div class='row alignLeft'>
                                                            <div class='pfpRadius profilInnlegg'>
                                                                <img src='$userPfp' alt='profile picture' onClick=sendTilProfil('$usernamePic') class='profilBildet'>
                                                            </div>
                                                            <p class = 'brukerBildet' onclick=sendTilProfil('$usernamePic')>$usernamePic</p>
                                                        </div>";


                    echo $innleggEl;
                    $bildetId = $_GET['picId'];
                    //ser om du liker bildet
                    $sql0 = "SELECT * FROM liktebilderview where liker = '$username' AND id = '$bildetId'";
                    if (mysqli_num_rows(mysqli_query($link, $sql0)) > 0) {
                        //case 1: du liker bildet
                        $like = true;
                        $likedEcho = "<img src = '../../bilder/htmlBilder/hjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                    } else {
                        //case 2: du liker ikke bildet
                        $likedEcho =  "<img src = '../../bilder/htmlBilder/usynligHjerte.png' class = 'hjerte' onclick=like('$bildetId')>";
                    }

                    $skrivKommentar = "
                    <div class = 'addComment alignLeft' id = 'commentHud'>  
                        $likedEcho
                        <form method='POST' action='../process/kommentar.php'>
                            <input class = 'newComment' minlength = '1' maxlength = '20' onkeypress='test($innleggTall)' type='text' name = 'newComment' placeholder='Add a comment..'>
                            <input class = 'invisable' readonly name = 'bildeId' value = '$bildetId'>
                            <input type = 'submit' name = 'submitComment' value = 'Post';>
                        </form>
                    </div>
                </div>";
                    echo $skrivKommentar; //siste delen av innlegget som er at man selv kan skrive kommentar
                    $sql = "SELECT * FROM kommentarpåbildet where id = '$bildetId'";

                    if ($result = mysqli_query($link, $sql)) {
                        while ($rad3 = mysqli_fetch_assoc($result)) {
                            $kommentar = $rad3['kommentar'];
                            $kommentarBruker = $rad3['brukernavn'];
                            $stmt4 = "select * from users WHERE username = '$kommentarBruker'";
                            $result4 = mysqli_query($link, $stmt);
                            $brukerInfo = mysqli_fetch_assoc($result4);
                            $pfp = $profilePicRoot . $brukerInfo['profilePicPath'];

                            //lager kommentarfeltet -> andre 1/3 av innlegget
                            $kommentarEl = "<div class = 'storKommentar'>
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

                    $innleggTall++;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <p id="invisable"> </p>
    <div id="invisable"></div>
    <script src="../../script/ui.js"></script>
    <script src="../../script/comment.js"></script>
</body>

</html>
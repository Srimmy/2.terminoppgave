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

session_start();
require_once "config.php";
$likedEcho ="";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$otherProfile = false;
$following = false;
$likedPictures = false;

//sin egen profil
$username = $ownUsername = $_SESSION['username'];
$profilePic = $_SESSION['profilePic'];
//kan egentlig bare fjerne $:server request men jeg liker den koden 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['liked'])) {
        if ($_POST['liked'] == 0) {
            $likedPictures = true;

        } else {
            $likedPictures = false;
        }
    } else if (!($_POST['username'] == $_SESSION['username'])) {
        //annen sin profil
        $username = $_POST['username'];
        $stmt = "SELECT * FROM USERS WHERE USERNAME = '$username'";
        $profilePic = mysqli_fetch_assoc($result = mysqli_query($link, $stmt))['profilePicPath'];
        $otherProfile = true;
        $stmt = "SELECT * FROM following WHERE following = '$ownUsername' AND username = '$username'";
        //sjeker om det du følger denne personen
        if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
            $following = true;
        }
    }
    if (isset($_POST['followUser'])) {
        $following = true;
        $stmt = "INSERT INTO following(following, username) VALUES('$ownUsername', '$username')";
        mysqli_query($link, $stmt);
    } else if (isset($_POST['unFollowUser'])) {
        $following = false;
        $stmt = "DELETE FROM following where following = '$ownUsername' AND username = '$username'";
        mysqli_query($link, $stmt);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- navbar -->
    <!-- Skal jeg gjøre navbar til en php eller js variabel slik at jeg kan endre alt på likt?-->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <div class="right-navbar">
            <a class="menu" href="index.php">Home</a>
            <a class="menu" href="pong.php">Pong</a>
            <div id="pfpRadius" class="dropdownElement">
                <img class="profilBildet" id="drop" src="<?php echo $_SESSION['profilePic']; ?>" alt="profile picture">
            </div>
            <div id="dropDown" class="shadow">
                <div class="dropContainer ">
                    <a class="dropElement" href="profile.php">Profil</a>
                    <a class="dropElement" href="profileEdit.php">Edit profile</a>
                    <a class="dropElement" href="logout.php">Log Out</a>
                </div>

            </div>
        </div>
    </div>


    <div class="whitespace"></div>

    <div class="container containerBody underline ">
        <div class="bigPfpRadius">
            <img class="bigPfp" src=" <?php echo $profilePic; ?>" alt="">
        </div>
        <div class="description">
            <div class="description">
                <div class="inline">
                    <h2> <?php echo $username ?> </h2>
                    <div>
                        <?php
                        if ($otherProfile) {
                            if ($following) {
                                $editOrFollow = "<a class = 'edit' onclick = unFollow('$username')> Following </a>";
                            } else {
                                $editOrFollow = "<a class = 'edit' onclick = follow('$username')> Follow </a>";
                            }
                        } else {
                            $editOrFollow = '<a href="profileEdit.php" class="edit">Edit profile</a>';
                            if (!$likedPictures) {
                                $likedEcho = "<a class = 'edit' id = 'likedOrOwn' onclick = seeLiked('0')> Liked pictures </a>";
                            } else {
                                $likedEcho = "<a class = 'edit' id = 'likedOrOwn' onclick = seeLiked('1')> Posted pictures </a>";
                            }
                        }
                        echo $editOrFollow;
                        echo $likedEcho;
                        ?>

                    </div>
                </div>

                <p>
                    <?php
                    $stmt = "SELECT * FROM BILDER WHERE brukernavn = '$username'";
                    if ($result = mysqli_query($link, $stmt)) {
                        if (($rows = mysqli_num_rows($result)) > 0) {
                            echo $rows;
                        } else {
                            $rows = "0";
                            echo $rows;
                        }
                    }
                    ?>
                    Posts
                </p>

                <?php
                if (!$otherProfile) {
                    echo  '<form action="sharePic.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="file">
                        <input class="input submit" id="profileSubmit" type="submit" name="submit" value="Upload">
                    </form>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="whitespace"></div>
    <div class="container containerBody">
        <?php
        if (!$otherProfile && $likedPictures) {
            $stmt = "SELECT * FROM liktebilderview where liker = '$ownUsername' ORDER BY date desc";
            $result = mysqli_query($link, $stmt);
        }
        if ($rows > 0) {
            while ($rad = mysqli_fetch_assoc($result)) {
                //definerer pathen til filen
                $path = $rad['Path'];
                $usernamePic = $rad['brukernavn'];
                //elementet som skal vises
                $bildeEl = "
                <div class = 'item'> 
                    <div class = 'bilder'> 
                        <img src = $path alt = 'bildet'> 
                    </div> 
                </div> ";
                echo $bildeEl;
            }
        } else {
            $bildeEl = "<h2> <span> $username </span> has not published any pictures. </h2>";
            echo $bildeEl;
        }

        ?>
    </div>
    <div class="whitespace"></div>
    <p id="invisable"></p>


    <script src="script/ui.js"></script>
</body>

</html>
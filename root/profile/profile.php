<?php

session_start();
require_once "../config/config.php";
$likedEcho = "";
$otherProfile = false;
$following = false;
$likedPictures = false;
$url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

//sin egen profil
$username = $ownUsername = $_SESSION['username'];
$profilePic = $_SESSION['profilePic'];

//kan egentlig bare fjerne $:server request men jeg liker den koden 
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (!($_GET['username'] == $_SESSION['username'])) {
        $username = $_GET['username'];
        $stmt = "SELECT * FROM USERS WHERE USERNAME = '$username'";
        //annen sin profil
        if (mysqli_num_rows($result = mysqli_query($link, $stmt)) == 1) {
            $profilePic = mysqli_fetch_assoc($result)['profilePicPath'];
            $otherProfile = true;
            if (isset($_GET['followUser'])) {
                $following = true;
                $stmt = "INSERT INTO following(following, username) VALUES('$ownUsername', '$username')";
                mysqli_query($link, $stmt);
                header("location: " . $escaped_url);
            } else if (isset($_GET['unFollowUser'])) {
                $following = false;
                $stmt = "DELETE FROM following where following = '$ownUsername' AND username = '$username'";
                mysqli_query($link, $stmt);
                header("location: " . $escaped_url);
            }
            $stmt = "SELECT * FROM following WHERE following = '$ownUsername' AND username = '$username'";
            //sjeker om det du følger denne personen
            if (mysqli_num_rows(mysqli_query($link, $stmt)) > 0) {
                $following = true;
            }
        } else {
            header("location: ../profile/profile.php?username=" . $_SESSION['username']);
        }
    }
}
if (isset($_GET['liked'])) {
    if ($_GET['liked'] == 0) {
        $likedPictures = true;
    } else {
        $likedPictures = false;
    }
}






?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/navbar.css">
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
                                $likedEcho = "<a class = 'edit' id = 'likedOrOwn' href = 'profile.php?username=dsa&liked=0'> Liked pictures </a>";
                            } else {
                                $likedEcho = "<a class = 'edit' id = 'likedOrOwn' href = 'profile.php?username=dsa&liked=1'> Posted pictures </a>";
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
                    echo  '<form action="../process/sharePic.php" method="POST" enctype="multipart/form-data">
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
    <p id="invisable">
    </p>


    <script src="../script/ui.js"></script>
</body>

</html>
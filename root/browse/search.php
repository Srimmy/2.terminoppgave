<?php
require_once "../config/config.php";
session_start();

//search engine
if (isset($_GET['k']) && $_GET['k'] != '') {
    //gjør at ' k ' blir til 'k'
    $k = trim(mysqli_real_escape_string($link, $_GET['k']));
    //keyword blir en array der hvert element blir separert med et mellomrom
    //"hei du" -> $keyword[0] = hei, $keyword[1] = du
    $keywords = explode(' ', $k);

    //query
    $searchStmt = "SELECT * FROM USERS WHERE";
    foreach ($keywords as $word) {
        $searchStmt .= " username like '%" . $word . "%' OR ";
        $display_words = "";
    }

    //fjerner den siste "OR" fra stringen for å ikke få feil
    //fjerner de siste 3 bokstavene fra stringen.
    $searchStmt = substr($searchStmt, 0, strlen($searchStmt) - 3);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Results for <?php echo ' ' . $k ?></title>
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
                    //sjekker om du har role som ser tickets
                    if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true) {
                        $username = $_SESSION['username'];
                        $stmt = "SELECT * FROM USERS WHERE username = '$username'";
                        if ($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
                            if (in_array($rad['role'], $answerTickets)) {
                                echo '<a class="dropElement" href="../costumerSupport/openTicket.php">Answer tickets</a>';
                            }
                        }
                    }

                    ?>
                    <a class="dropElement" href="../process/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>
    <div class="whitespace"> </div>
    <div class="container containerBody">
        <?php
        //kjører sql statement lenger opp i koden
        if ($result = mysqli_query($link, $searchStmt)) {
            //finner antall treff
            if ($result_num = mysqli_num_rows($result)) {
                if ($result_num > 0) {
                    //case 1: de som blir søkt på finnes
                    print 'Your search for&#160;<i> ' . $k . '</i> <hr /> <br/>';
                    print '<div class = ""><b><u>' . $result_num . '</u></b> results found</div>';
                    while ($row = mysqli_fetch_assoc($result)) { //henter all dataen
                        $brukernavn = $row['username'];
                        $profilePic = $row['profilePicPath'];
                        $bruker = "  <div class = 'result'  onClick=sendTilProfil('$brukernavn')>
                                        <div class = 'bigPfpRadius' >
                                            <img class = 'bigPfp'  src=" . $profilePic . " alt='$brukernavn'> 
                                        </div>
                                        <div class='column brukerSøk'>
                                            <h2 class = 'bruker'> $brukernavn </h2>
                                            <h2 class='desc light'> cap for nå</h2>
                                        </div>
                                        
                                    </div>";
                        echo $bruker;
                    }
                } else {
                    //case 2: de finnes ikke
                    print "no results found";
                }
            }
        } else {
            //hvis queryen feiler
            print(mysqli_error($link));
        }

        ?>
    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"> </script>
</body>

</html>
<?php
require_once "../process/config.php";

//search engine
if (isset($_GET['k']) && $_GET['k'] != '') {
    //gjør at ' k ' blir til 'k'
    $k = trim(mysqli_real_escape_string($link, $_GET['k']));
    //keyword blir en array der hvert element blir separert med et mellomrom
    //"hei du" -> $keyword[0] = hei, $keyword[1] = du
    $keywords = explode(' ', $k);

    //query
    $stmt = "SELECT * FROM USERS WHERE";
    foreach ($keywords as $word) {
        $stmt .= " username like '%" . $word . "%' OR ";
        $display_words = "";
    }

    //fjerner den siste "OR" fra stringen for å ikke få feil
    //fjerner de siste 3 bokstavene fra stringen.
    $stmt = substr($stmt, 0, strlen($stmt) - 3);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Results for <?php echo $k ?></title>
</head>

<body>
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
            <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="../htmlBilder/house.png" alt="home"></a>
            <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="../htmlBilder/browse.png" alt="explore"></a>
            <a class="menu" id="modal"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
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
    <div class="whitespace"> </div>
    <div class="container containerBody">
        <?php
        if ($result = mysqli_query($link, $stmt)) {
            if ($result_num = mysqli_num_rows($result)) {
                if ($result_num > 0) {
                    print 'Your search for <i> ' . $k . '</i> <hr /> <br/>';
                    print '<div class = ""><b><u>' . $result_num . '</u></b> results found</div>';
                    while ($row = mysqli_fetch_assoc($result)) { //henter all dataen
                        $brukernavn = $row['username'];
                        $profilePic = $row['profilePicPath'];
                        $bruker = "<div class = 'result' onClick=sendTilProfil('$profilePic')> <div class = 'bigPfpRadius' ><img class = 'bigPfp' src=" . $profilePic . " alt='$brukernavn'> </div><h2> $brukernavn </h2></div>";
                        echo $bruker;
                    }
                } else {
                    print "no results found";
                }
            }
        } else {
            print(mysqli_error($link));
        } ?>
    </div>


</body>

</html>
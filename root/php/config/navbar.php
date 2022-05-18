<!-- navbar -->
<?php
$followingSrc = "../../bilder/htmlBilder/house.png";
$homeSrc = "../../bilder/htmlBilder/browse.png";
$pongSrc = "../../bilder/htmlBilder/pong.png";
$logout = "Log Out";

switch (basename($_SERVER['PHP_SELF'])) {
        //endrer ikon samsvarende med hvilken side det er 
    case "following.php":
        $followingSrc = "../../bilder/htmlBilder/house-reverse.png";
        break;
    case "index.php":
        $homeSrc = "../../bilder/htmlBilder/browse-reverse.png";
        break;
    case "browse.php":
        $homeSrc = "../../bilder/htmlBilder/browse-reverse.png";
        $logout = "Log In";
        $_SESSION['profilePic'] = "../profilbilder/standard.svg";
        break;
    case "pong.php":
        $pongSrc = "../../bilder/htmlBilder/pong-reverse.png";
        break;
    case "faq.php":
        if (isset($_SESSION["loggedin"])) {
            $username = $_SESSION['username'];
        } else {
            $username = '';
            $logout = "Log In";
            $_SESSION['profilePic'] = "../profilbilder/standard.svg";
        }
}

?>
<link rel="stylesheet" href="../../css/style.css">
<div class="navbar">
    <!--logo-->
    <div class="left-navbar">
        <img src="../../bilder/htmlBilder/logo.svg" alt="logo" class="logo">
    </div>
    <!--Søkemotor-->
    <form method="GET" class="row searchForm" action='../browse/search.php'>
        <div id="search" style="width: 15vw">
            <img src="../../bilder/htmlBilder/søke.png" id="søkeBildet" alt="">
            <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
        </div>
    </form>
    <div class="right-navbar">
        <!--Høyre side av navbar-->
        <a class="menu" href="../browse/following.php"><img class="navbar-icon" src="<?php echo $followingSrc; ?>" alt="home"></a>
        <a class="menu" href="../browse/index.php"><img class="navbar-icon" src="<?php echo $homeSrc; ?>" alt="explore"></a>
        <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="<?php echo $pongSrc; ?>" alt="explore"></a>
        <a class="menu" id="modalButton"><img class="navbar-icon" src="../../bilder/htmlBilder/share-button.png" alt="upload picture"></a>
        <!--modal for del bilde popup, alt i denne er usynlig før man trykker på knappen-->
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
        <a class="menu" href="../costumerSupport/faq.php"><img class="navbar-icon" src="../../bilder/htmlBilder/brukerstotte.svg" alt="explore"></a>
        <div id="pfpRadius" class="dropdownElement pfpRadius">
            <img class="profilBildet" id="drop" src="<?php echo $_SESSION['profilePic']; ?>" alt="profile picture">
        </div>


        <div id="dropDown" class="shadow">
            <div class="dropContainer ">
                <a class="dropElement" href="../profile/profile.php">Profil</a>
                <a class="dropElement" href="../profile/profileEdit.php">Edit profile</a>
                <a class="dropElement" href="../costumerSupport/costumerTickets.php">Tickets</a>
                <?php
                //ser om du har en rolle som lar deg se tickets
                $stmt = "select * from users WHERE username = '$username'";
                if ($rad = mysqli_fetch_assoc(mysqli_query($link, $stmt))) {
                    if (in_array($rad['role'], $answerTickets)) {
                        echo '<a class="dropElement" href="../costumerSupport/openTicket.php">Answer tickets</a>';
                    }
                }
                ?>
                <a class="dropElement" href="../process/logout.php"><?php echo $logout ?></a>
            </div>
        </div>
    </div>
</div>

<?php
include('../../cookie/cookie.html');
?>
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
// Check if the user is logged in, if not then redirect him to login page
$followPage = false;
$username = $_SESSION["username"];
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: browse.php");
    exit;
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- navbar -->
    <!-- Burde gjøre alt dette til javascript så det er mye lettere å endre, for dette er ork-->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <div class="right-navbar">
            <a class="menu" href="index.php">Home</a>
            <a class="menu" href="following.php">Following</a>
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
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($username); ?></b>. Welcome to our site.</h1>

    <p>
        <a href="sharePic.php">Share a picture</a>
    </p>

    <!--Bildet feed-->
    <div class="container containerBody">
        <?php


        $stmt = "SELECT * FROM BILDER";
        if ($result = mysqli_query($link, $stmt)) {
            //finner mengden bilder som finnes, altså rows i databasen
            if ($bildeCount = mysqli_num_rows($result)) {
                //kjører koden hver gang $rad får en ny verdi, altså for hver rad i databasen
                while ($rad = mysqli_fetch_assoc($result)) {
                    //definerer pathen til filen
                    $path = $rad['Path'];
                    $usernamePic = $rad['brukernavn'];
                    //elementet som skal vises
                    //funker ikke som writeForm function av en eller annen grunn, kanskje pga php kode
                    $bildeEl = "<div class = 'item center' onClick = sendTilProfil('$usernamePic') > 
                                    <div class = 'bilder'> 
                                    <div class = 'blackbox'>
                                    </div >
                                        <img src = $path alt = 'bildet'> 
                                    </div> 
                                    
                                </div> ";
                    echo $bildeEl;
                }
            }
        }

        ?>
    </div>




    <div class="whitespace"></div>
    <p id="invisable"> </p>

    <script src="script/ui.js"></script>
</body>

</html>
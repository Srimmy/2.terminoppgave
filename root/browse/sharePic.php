<?php

session_start();
require_once "../process/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$root = '../delteBilder/';
$Id = $_SESSION['id'];
$username = $_SESSION['username'];
//https://www.youtube.com/watch?v=JaRq73y5MJk
//skjekker om knappen er trykket ved å se om det har blitt submitta en post som heter submit
if (isset($_POST['submit'])) {
    //variabel for filen som ble sendt med navn 'file'
    $file = $_FILES['file'];

    //finner navnet til filen, tmp navn, størrelse, om det er en feil og type fil
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType  = $_FILES['file']['type'];

    //fjerner . og fil navnet fra filnavnet.fil slik at vi får både filnavn og fil til å være alene
    $fileExt = explode('.', $fileName);
    //gjør alle extensions til å være lower case slik at jeg slipper å skrive jPg, Jpg, JPG, osv
    $fileActualExt = strtolower(end($fileExt));

    //fil extensions som er lovlig på siden
    $allowed = array('jpg', 'jpeg', 'png', 'svg');

    //skjekker extensions som er lovlige å opploade imot filen som blir uploade'a
    if (in_array($fileActualExt, $allowed)) {
        //hvis fileerror = 0 betyr det at det ikke er noen errors
        if ($fileError === 0) {
            //Hvis filstørrelsen er mindre enn 10mb
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                //destinasjon av filer
                $fileDestination = $root . $fileNameNew;
                $stmt = "INSERT INTO bilder(Path, brukernavn) values('$fileDestination', '$username')";
                $result = mysqli_query($link, $stmt);
                //flytter filen til riktig desitnasjon
                move_uploaded_file($fileTmpName, $fileDestination);

                header("Location: profile.php?uploadFromSharePic");
            } else {
                echo "Your file is too large!";
            }
        } else {
            echo "There was an error uploading your file";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>share a picture</title>
</head>

<body>
    <!-- navbar -->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
                <form method="GET" class="row searchForm"  action='search.php'>
            <div id="search" style="width: 15vw">
                <img src="../htmlBilder/søke.png" id="søkeBildet" alt="">
                <input class="search" id="searchText" name="k" type="text" class="search" placeholder="Search">
            </div>
        </form>
        <div class="right-navbar">
            <a class="menu" href="../browse/index.php">Home</a>
            <a class="menu" href="../game/pong.php">Pong</a>
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

    <form action="sharePic.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input class="input submit" type="submit" name="submit">upload image</input>
    </form>

    <script src="../script/ui.js"></script>
</body>

</html>
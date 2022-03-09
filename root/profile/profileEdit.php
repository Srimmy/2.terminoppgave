<?php
session_start();
require_once "../process/config.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../register/login.php");
    exit;
}
$root = '../profilbilder/';
$id = $_SESSION['id'];
$username_err = $password_err = $valid_err = $upload_err = "";
$username = $_SESSION['username'];

//https://www.youtube.com/watch?v=JaRq73y5MJk
//skjekker om knappen er trykket ved å se om det har blitt submitta en post som heter submit
//problem med siden: når du trykker enter er det bare brukernavn som endres, ikke passordet
//må gjøre slik at brukernavn delen blir selvstendig og at passord blir selvstendig.

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['password'])) {
        //Setter som variabler
        $password = mysqli_real_escape_string($link, $_POST['password']);
        $newPassword = mysqli_real_escape_string($link, $_POST['newPassword']);
        //feilsøking i brukernavn
        // logikken jeg bruker
        if (empty($_POST['password'])) {
            $password_err = "Please enter your password";
        } else if (empty($_POST['newPassword'])) { //funker ikke å legge inn i if password empty || new password empty
            $password_err = "Please enter your new password";
        } else if (!password_verify($password, $_SESSION['password'])) {
            $password_err = "Incorrect password";
        } else if (!($_POST['newPassword'] === $_POST['confirmPassword'])) {
            $password_err = "Password does not match.";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt =    "
            update users set password = '$hashedPassword' where id = '$id';";
            if (mysqli_multi_query($link, $stmt)) {
                $valid_err = "Successful change!";
            } else {
                $valid_err = "Something went wrong. Please try again later.";
            }
        }
    } else if (isset($_POST['username'])) { //bare endre username
        $newUsername = mysqli_real_escape_string($link, $_POST['username']);
        if (empty($_POST['username'])) {
            $username_err = "Please enter a username.";
            //Sjekker om det bare er skrevet a-z, A-Z, 0-9, _ 
        } else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
            $username_err = "Username can only contain letters, numbers and underscores.";
        } else {
            //ser om brukernavnet finnes
            $stmt = "SELECT * FROM USERS WHERE username = '$newUsername'";
            //definerer både $row og $result slik at jeg kan hente informasjon fra tabellen samtiig som jeg kan bruke $result til å sjekke hvor mange rader d er.
            if ($row = mysqli_fetch_assoc($result = mysqli_query($link, $stmt))) {
                if (mysqli_num_rows($result) == 1  && !($row['id'] == $_SESSION['id'])) {
                    $username_err = "Username already exists.";
                }
            } else {
                $stmt =    "
                            update USERS set username = '$newUsername' where id = '$id';
                            update bilder set brukernavn = '$newUsername' where brukernavn = '$username';
                            update following set username = '$newUsername' where username = '$username';
                            update following set following = '$newUsername' where following = '$username';
                            update kommentar set username = '$newUsername' where brukernavn = '$username';
                            update kommentar set brukernavn = '$newUsername' where brukernavn = '$username';
                            update liktebilder set username = '$newUsername' where username = '$username';
                            ";
                if (mysqli_multi_query($link, $stmt)) {
                    $valid_err = "Successfull Change";
                    $_SESSION['username'] = $newUsername;
                } else {
                    $valid_err = "Something went wrong. Please try again later.";
                }
            }
        }
    } else { //profilbildet endring, kan eventuelt bruke changepfp.php hvis det er mer ryddig
        //https://www.youtube.com/watch?v=JaRq73y5MJk
        //skjekker om knappen er trykket ved å se om det har blitt submitta en post som heter submit
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

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

            //skjekker extensions som er lovlige å opploade imot filen som blir uploadea
            if (in_array($fileActualExt, $allowed)) {
                //hvis fileerror = 0 betyr det at det ikke er noen errors
                if ($fileError === 0) {
                    //Hvis filstørrelsen er mindre enn 10mb
                    if ($fileSize < 1000000) {
                        //gir nytt random navn og legger til . + filen sin extension
                        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                        //destinasjon av filer
                        $fileDestination = $root . $fileNameNew;
                        $stmt = "update users set profilePicPath = '$fileDestination' where id = '$id'";
                        $result = mysqli_query($link, $stmt);
                        if (!($_SESSION['profilePic'] == "../profilbilder/standard.svg")) {
                            //fjerner fil
                            unlink($_SESSION['profilePic']);
                        }
                        $_SESSION['profilePic'] = $fileDestination;

                        //flytter filen til riktig desitnasjon
                        move_uploaded_file($fileTmpName, $fileDestination);

                        header("Location: profileEdit.php?uploadfromChangepfp");
                    } else {
                        $upload_err = "Your file is too large!";
                    }
                } else {
                    $upload_err = "There was an error uploading your file";
                }
            } else {
                $upload_err = "You cannot upload files of this type!";
            }
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
    <link rel="stylesheet" href="css/editProfile.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit profile</title>
</head>

<body>
    <!-- navbar -->
    <!-- Skal jeg gjøre navbar til en php eller js variabel slik at jeg kan endre alt på likt?-->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <form method="GET" class="row searchForm" action='../profile/profile.php'>
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
                    <a class="dropElement" href="../process/logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </div>
    <div class="whitespace"></div>
    <div class="register">
        <form action="profileEdit.php" method="POST" enctype="multipart/form-data">
            <div class="profileEdit">
                <div class="bigPfpRadius gap" id="editPfp">
                    <img class="bigPfp" src=" <?php echo $_SESSION['profilePic'] ?>" alt="">
                </div>
                <div>
                    <input class="file" type="file" name="file">
                    <input class="input submit" id="pfpSubmit" type="submit" name="pfpChange" value="Change">
                    <p class="note"> <?php echo $upload_err; ?></p>
                </div>
            </div>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="inputDiv">
                <input class="input" type="text" name="username" id="username" placeholder="Username" value=<?php echo $_SESSION['username']; ?>>
                <input class="input submit" type="submit" value="Change username" name="usernameChange">
            </div>
        </form>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="inputDiv">
                <input class="input gap" type="password" id='password' name="password" placeholder="Password">
                <input class="input" type="password" id='newPassword' name="newPassword" placeholder="New password">
                <input class="input" type="password" id='confirmPassword' name="confirmPassword" placeholder="Confirm password">
                <input class="input submit" type="submit" value="Change password" name="changePassword">
                <p class="note"> <?php echo $username_err, $password_err; ?> <span class="successful"> <?php echo $valid_err; ?></span></p>
            </div>
        </form>
        <div class="inputDiv">
            <?php
            echo "<button class='input submit' id='deleteUser' onclick=confirmDelete('$username')>Delete user</button>"
            ?>

        </div>

    </div>

    <div class="register gap">
        <p>
            <a href="profile.php" class="note link">Back to profile</a>
        </p>
    </div>
    <div id="invisable"></div>
    <script src="../script/ui.js"></script>
</body>

</html>
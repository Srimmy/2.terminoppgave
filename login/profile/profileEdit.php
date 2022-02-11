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

//https://www.youtube.com/watch?v=JaRq73y5MJk
//skjekker om knappen er trykket ved å se om det har blitt submitta en post som heter submit
//problem med siden: når du trykker enter er det bare brukernavn som endres, ikke passordet
//må gjøre slik at brukernavn delen blir selvstendig og at passord blir selvstendig.

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['changeUser'])) {
        //Setter som variabler
        $newUsername = mysqli_real_escape_string($link, $_POST['username']);
        $password = mysqli_real_escape_string($link, $_POST['password']);
        $newPassword = mysqli_real_escape_string($link, $_POST['newPassword']);
        //feilsøking i brukernavn
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
                //logikken er dårlig fordi hvis det ikke finnes et brukernavn så blir $row udefinert som returnerer false
                //logikken er dårlig fordi hvis det ikke finnes et brukernavn så blir $row udefinert som returnerer false
                if (mysqli_num_rows($result) == 1  && !($row['id'] == $_SESSION['id'])) {
                    $username_err = "Username already exists.";
                } else { //Ser om passord er gyldig
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
                        $stmt = "update USERS set username = '$newUsername', password = '$hashedPassword' where id = '$id'";
                        if (mysqli_query($link, $stmt)) {
                            $valid_err = "Successfull change!";
                            $_SESSION['username'] = $newUsername;
                            $_SESSION['password'] = $hashedPassword;
                        } else {
                            echo "Something went wrong. Please try again later.";
                        }
                    }
                }
            } else { // ser om passord er gyldig i gjen, jeg burde gjøre dette til en funksjon men jeg klarer ikke å få det til å funke foreløpig eller bare endre
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
                    $stmt = "update USERS set username = '$newUsername', password = '$hashedPassword' where id = '$id'";
                    echo $stmt;
                    if (mysqli_query($link, $stmt)) {
                        $valid_err = "Successful change!";
                        $_SESSION['username'] = $newUsername;
                        $_SESSION['password'] = $hashedPassword;
                        echo $stmt;
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }
            }
        }
    } else if (isset($_POST['usernameChange'])) { //bare endre username
        $newUsername = $_POST['username'];
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
                //logikken er dårlig fordi hvis det ikke finnes et brukernavn så blir $row udefinert som returnerer false
                //logikken er dårlig fordi hvis det ikke finnes et brukernavn så blir $row udefinert som returnerer false
                if (mysqli_num_rows($result) == 1  && !($row['id'] == $_SESSION['id'])) {
                    $username_err = "Username already exists.";
                }
            } else {
                $stmt = "update USERS set username = '$newUsername' where id = '$id'";
                if (mysqli_query($link, $stmt)) {
                    $valid_err = "Successfull Change";
                    $_SESSION['username'] = $newUsername;
                } else {
                    echo "Something went wrong. Please try again later.";
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
//ikke brukt i koden men kan oppdateres slik at det blir mindre copypaste
function changePassword($password, $newPassword, $newUsername, $id, $link)
{
    if (empty($_POST['password'])) {
        $password_err = "Please enter your password";
    } else if (empty($_POST['newPassword'])) { //funker ikke å legge inn i if password empty || new password empty
        $password_err = "Please enter your new password";
    } else if (!password_verify($password, $_SESSION['password'])) {
        $password_err = "Wrong password";
    } else if (!($_POST['newPassword'] === $_POST['confirmPassword'])) {
        $password_err = "Password does not match.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = "update USERS set username = '$newUsername', password = '$hashedPassword' where id = '$id'";
        echo $stmt;
        if (mysqli_query($link, $stmt)) {
            $valid_err = "Successfull change!";
            $_SESSION['username'] = $newUsername;
            $_SESSION['password'] = $hashedPassword;
            echo $stmt;
        } else {
            echo "Something went wrong. Please try again later.";
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
            <a class="menu" id = "modal"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
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
        <form action="profileEdit.php" method="POST">
            <div class="inputDiv">
                <input class="input" type="text" name="username" placeholder="Username" value=<?php echo $_SESSION['username']; ?>>
                <input class="input submit" type="submit" value="Change username" name="usernameChange">
                <input class="input gap" type="password" name="password" placeholder="Password">
                <input class="input" type="password" name="newPassword" placeholder="New password">
                <input class="input" type="password" name="confirmPassword" placeholder="Confirm password">
                <input class="input submit" type="submit" value="Change both" name="changeUser">
                <p class="note"> <?php echo $username_err, $password_err; ?> <span class="successful"> <?php echo $valid_err; ?></span></p>
            </div>
        </form>
    </div>

    <div class="register gap">
        <p>
            <a href="profile.php" class="note link">Back to profile</a>
        </p>
    </div>

    <script src="../script/ui.js"></script>
</body>

</html>
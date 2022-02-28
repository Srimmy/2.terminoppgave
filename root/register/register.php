<?php
require_once "../process/config.php";

$username_err = $password_err = $confirmPassword_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Setter som variabler
    //mysqli real escape string gjør at special characters som ' blir endret slik at man ikke kan injecte inn i sql.
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($link, $_POST['confirmPassword']);
    //feilsøking i brukernavn
    if (empty($_POST['username'])) {
        $username_err = "Please enter a username.";
        //sikkerhet slik at man ikke kan injecte også, hvis man kan legge til ' kan man lage kode selv.
    } else if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
        $username_err = "Username can only contain letters, numbers and underscores.";
    } else {
        //ser om brukernavnet finnes
        $stmt = "SELECT * FROM USERS WHERE username = '$username'";
        if ($result = mysqli_query($link, $stmt)) {
            if (mysqli_num_rows($result) > 0) {
                $username_err = "Username already exists.";
            } else { //Ser om passord er gyldig
                if (empty($_POST['password']) || empty($_POST['confirmPassword'])) {
                    $password_err = "Please enter a password";
                } else if (!($password === $confirmPassword)) {
                    $password_err = "Password does not match.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = "INSERT INTO USERS (username, password, profilePicPath) VALUES ('$username', '$hashedPassword', '../profilbilder/standard.svg')";
                    if (mysqli_query($link, $stmt)) {
                        header("location: login.php");
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }

                //ser om passordet er gyldig;

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
    <link rel="stylesheet" href="../css/style.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
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
    <div class="whitespace"></div>
    <form action="register.php" method="POST">
        <div class=" register ">
            <div class="inputDiv">
                <input class="input" type="text" name="username" placeholder="Username">
                <input class="input" type="password" name="password" placeholder="Password">
                <input class="input" type="password" name="confirmPassword" placeholder="Confirm password">
                <input class="input submit" type="submit" value="Register">
                <p> <?php echo $username_err; ?></p>
            </div>
        </div>
        <div class="register gap ">
            <p class="note">Already have an account? <a href="login.php" class="link">Log in</a></p>
        </div>

    </form>
</body>

</html>
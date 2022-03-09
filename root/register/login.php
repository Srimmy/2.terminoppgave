<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['loggedin'] === true) {
    header("location: ../browse/index.php?alreadyloggedin");
    exit;
}

require_once "../process/config.php";
//definerer feilmeldinger
$login_err = "";

//hvis noen har brukt formen i html
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    //hvis det begge er fyllt
    if (!empty($username) && !empty($password)) {
        $stmt = "SELECT * FROM users where username = '$username'";
        if ($result = mysqli_query($link, $stmt)) {
            //henter data i assoc array
            if ($user_data = mysqli_fetch_assoc($result)) {
                //skjekker om dataen stemmer, funker ikke gjøre om passordet til hashed og teste d
                if (password_verify($password, $user_data['password'])) {
                    //lager session slik at variabler lagrer seg, gjør det lettere senere
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user_data['id'];
                    $_SESSION['username'] = $user_data['username'];
                    $_SESSION['highscore'] = $user_data['highscore'];
                    $_SESSION['password'] = $user_data['password'];
                    if (is_null($user_data['profilePicPath'])) {
                        $_SESSION['profilePic'] = "../profilbilder/standard.svg";
                    } else {
                        $_SESSION['profilePic'] =  $user_data['profilePicPath'];
                    }


                    //tar deg til index.php
                    header("location: ../browse/index.php?fraNewlogin");
                } else {
                    $login_err = "Invalid username or password."; //$login_err er allerede i html koden, bare at den ikke er definert
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        } else {
            $login_err = "Something went wrong, try again later.";
        }
    } else {
        $login_err = "Invalid username or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="../css/style.css">

    <title>login</title>

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
            <a class="menu" id="modal"><img class="navbar-icon" src="../htmlBilder/share-button.png" alt="upload picture"></a>
            <a class="menu" href="../game/pong.php"><img class="navbar-icon" src="../htmlBilder/pong.png" alt="explore"></a>
            <div id="pfpRadius" class="dropdownElement pfpRadius">
                <img class="profilBildet" id="drop" src="../profilbilder/standard.svg" alt="profile picture">
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
    <form action="login.php" method="POST">
        <div class=" register ">
            <div class="inputDiv">
                <input class="input" id="registerUser" type="text" name="username" placeholder="Username">
                <input class="input" id="registerPassword" type="password" name="password" placeholder="Password">
                <input class="input submit" id='registerSubmit' type="submit" value="Log in">
                <p class="note"> <?php echo $login_err ?></p>
            </div>
        </div>
        <div class="register gap ">
            <p class="note">Don't have an account?<a href="register.php" class="link"> Sign up</a></p>
            <p class="note">Need help? Contact us: <a href="mailto: srpra001@osloskolen.no" class="link">srpra001@osloskolen.no </a></p>
        </div>
    </form>
    <script src="../script/ui.js"></script>
    <script src="../script/register.js"></script>
</body>

</html>
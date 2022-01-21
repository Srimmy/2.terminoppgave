<?php
require_once "config.php";

$username_err = $password_err = $confirmPassword_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Setter som variabler
    $username = $_POST['username'];
    $password = $_POST['password'];
    //feilsøking i brukernavn
    if (empty($_POST['username'])) {
        $username_err = "Please enter a username.";
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
                } else if (!($_POST['password'] === $_POST['confirmPassword'])) {
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
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <div class="navbar">
        <div class="left-navbar">
            <img src="../htmlBilder/logo.png" alt="logo" class="logo">
        </div>
        <div class="right-navbar">
            <a class="menu" href="index.php">Home</a>
            <a class="menu" href="pong.php">Pong</a>
            <div id="pfpRadius" class="dropdownElement">
                <img class="profilBildet" id="drop" src="../profilbilder/standard.svg" alt="profile picture">
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
    <form action="register.php" method="POST">
        <div class=" register ">
            <div class="inputDiv">
                <input class="input" type="text" name="username" placeholder="Username">
                <input class="input" type="password" name="password" placeholder="Password">
                <input class="input" type="password" name="confirmPassword" placeholder="Confirm password">
                <input class="input submit" type="submit" value="Register">
                <p> <?php echo $username_err;?></p>
            </div>
        </div>
        <div class="register gap ">
            <p class="note">Already have an account? <a href="login.php" class="link">Log in</a></p>
        </div>

    </form>
</body>

</html>